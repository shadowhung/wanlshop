/**

 * WanlShop状态管理器 - 即时通讯

 * 

 * @ author 深圳前海万联科技有限公司 <wanlshop@i36k.com> 

 * < 程序仅用作FastAdmin付费插件API测试使用，未经版权所有权人书面许可，不能用于商业用途！>

 * @ link http://www.wanlshop.com

 * @ 2020年9月29日19:00:46

 * @ version 1.0.0

 **/

 import Vue from 'vue';

 import api from '../../common/request/request'; 

 import fun from '../../common/wanlshop_function'; 

 import config from '../../common/config/config';

 export default {

 	namespaced: true,

 	state: {

		ischat: {

			notice: true,

			number: 0

		},

		close: false,

		list: [],

		reconnections: 0

 	},

 	mutations: {

		setIschat(state, payload) {

			for (let i in payload) {

				for (let j in state.ischat) {

					if (i === j) {

						state.ischat[j] = payload[i];

					}

				}

			}

		}

 	},

 	actions: {

		// 开始或重启即时通讯，全局监听，主要用于系统消息提示

		async start({state, dispatch, rootState}){

			// 如果已连接，关闭重新连接

			uni.onSocketOpen(()=> {

				state.isclose = true;

			});

			if (state.isclose) {

				uni.closeSocket();

				uni.onSocketClose((res)=> {

					config.debug ? console.log('WanlChat 已关闭！') : '';

				});

			}

			// 创建一个 WebSocket 连接

			uni.connectSocket({url: config.socketurl});

			// 监听 WebSocket 连接打开事件

			uni.onSocketOpen((res)=> {

				config.debug ? console.log('WanlChat 连接已打开！') : '';

			});

			// 监听WebSocket错误。

			uni.onSocketError((res)=> {

				api.get({

					url: '/wanlshop/chat/state',

					success: res => {

						state.reconnections += 1;

						if (state.reconnections <= 3) {

							uni.showToast({

							    title: `IM 连接失败，正尝试第${state.reconnections}次连接`,

							    icon: 'loading'

							});

							dispatch('start');

						}else{

							console.error('IM服务器启动正常，客户端已尝试3次重连接，请检查ws和wss是否可以正常访问');

						}

					},

					fail: err=> {

						uni.showModal({

						    content: err.data.msg,

						});

					}

				});

			});

			uni.onSocketMessage((res)=> {

				let data = JSON.parse(res.data);

				// 初始化

				if (data.type == 'init') {

					// 绑定 client_id 到 uid

					api.post({

						url: '/wanlshop/chat/shake',

						data: {'client_id': data.client_id},

						success: res => {

							uni.setStorageSync("wanlshop:chat_client_id", res);

						}

					});

				// 心跳回执

				}else if(data.type == 'ping'){

					// 通过 WebSocket 连接发送数据

					uni.sendSocketMessage({data: '{"type":"pong"}'});

				// 客服消息

				}else if(data.type == 'service') {

					// 全局通知

					uni.$emit('onService', data);

					// 消息提示

					dispatch('notice', {type: data.type, data: null});

				// 即时通讯消息

				}else if(data.type == 'chat'){

					// 全局通知

					uni.$emit('onChat', fun.setChat(data));

					// 更新数量

					dispatch('update', {type: data.type, data:data, shop: {id: data.form.shop_id, user_id: data.form.id, name: data.form.name,avatar: data.form.avatar,}});

					let tipsContent = '';

					if (data.message.type == 'text') {

						tipsContent = data.message.content.text

					}else if(data.message.type == 'img') {

						tipsContent = '[图片消息]';

					}else if(data.message.type == 'voice') {

						tipsContent = '[语音消息]';

					}

					if (state.ischat.notice) {

						dispatch('notice', {

							type: data.type, 

							data: {

								title: data.form.name,

								subtitle: '发来一条消息',

								content: tipsContent,

								jsondata: JSON.stringify({

									id: 0

								})

							}

						});

					}else{

						state.ischat.number++;

					}

				// 订单消息

				}else if(data.type == 'order'){

					// 全局更新,分析订单类型: 待收货（已发货）交易物流+1

					// 接受其他 签收，退款申请同意，拒绝

					dispatch('storage', {type: data.type});

					// 消息提示

					dispatch('notice', {

						type: 'order',

						data: {

							title: data.title,

							subtitle: '',

							content: data.content,

							jsondata: JSON.stringify({

								modules: data.modules,

								modules_id: data.modules_id

							})

						}

					});

				// 通知消息

				}else if(data.type == 'notice'){

					dispatch('storage', {type: data.type});

					// 消息提示

					dispatch('notice', {

						type: data.type,

						data: {

							title: '标题',

							subtitle: '副标题',

							content: '内容',

							jsondata: JSON.stringify({

								id: 0

							})

						}

					});

				}else if(data.type == 'live'){

					// 全局通知

					uni.$emit('onLive', data);

				}else{

					config.debug ? console.log('未知消息') : '';

				}

			});

			// 获取一次聊天列表

			setTimeout(()=> {

				if (rootState.user.isLogin) {

					dispatch('get');

				}

			},300);

		},

		// 全局消息提示

		async notice({state, dispatch, rootState}, {type, data}){

			// 声音提示

			if (rootState.user.voice) {

				let audio = uni.createInnerAudioContext();

				let cdn = rootState.common.appUrl.oss;

				let src = {

					service: cdn + '/assets/addons/wanlshop/voice/service.mp3',

					order: cdn + '/assets/addons/wanlshop/voice/order.mp3',

					notice: cdn + '/assets/addons/wanlshop/voice/notice.mp3',

					chat: cdn + '/assets/addons/wanlshop/voice/chat.mp3'

				};

				audio.autoplay = true;

				audio.src = src[type];

				audio.onPlay(() => {

					config.debug ? console.log('开始播放') : '';

				});

				audio.onError((res) => {

					config.debug ? console.log(res) : '';

				});

			}

			// 震动

			// #ifndef H5

				if (rootState.user.shock) {

					uni.vibrateShort();

				}

			// #endif

			//推送

			// #ifdef APP-PLUS

				// if (rootState.user.pushs) {

				// 	if (data) {

				// 		plus.push.createMessage(data.content, data.jsondata, {

				// 			cover: false,

				// 			title: data.title,

				// 			subtitle: data.subtitle

				// 		});

				// 	}else{

				// 		config.debug ? console.log('推送数据不存在无法推送') : '';

				// 	}

				// }

			// #endif

		},

		// 读取消息列表

		async get({state, dispatch, rootState}) {

			api.get({

				url: '/wanlshop/chat/lists',

				success: res => {

					state.list = res;

					let count = 0;

					res.forEach(item => {count += item.count;});

					dispatch('storage', {type: 'statis', number: count});

				}

			});

		},

		// 删除指定消息

		async del({state, dispatch, rootState}, index){

			let list = state.list;

			// 修改消息总数量

			dispatch('storage', {type: 'del', number: list[index].count});

			// 清空本地储存

			uni.removeStorage({

			    key: 'wanlchat:message_' + list[index].user_id,

			    success: (res) => {

					config.debug ? console.log('删除消息成功'):'';

			    }

			});

			// 操作云

			api.post({url: '/wanlshop/chat/del',data: {id: list[index].user_id}});

			// 删除状态管理器

			Vue.delete(state.list, index);

		},

		// 全部已读

		async empty({state, dispatch, rootState}){

			uni.showModal({

			    content: '是否将全部数据标记已读状态？',

			    success: res=> {

			        if (res.confirm) {

						// 已读状态管理器

			            state.list.forEach(item => {item.count = 0});

						// 全局清零

						dispatch('storage', {type: 'empty'});

			            // 操作云

			            api.post({

			            	url: '/wanlshop/chat/read',

			            	success: res => {

			            		uni.showToast({title: '全部已读',icon: 'none'});

			            	}

			            });

			        } else if (res.cancel) {

						config.debug ? console.log('用户点击取消') : '';

			        }

			    }

			});

		},

		// 通用更新，接受消息更新，发送消息更新，返回清空角标

		async update({state, dispatch}, {type, data, id, shop}){

			if (type == 'del') {

				let counts = 0;

				state.list.some(chat => {if (chat.user_id == id) {

					counts = chat.count;

					chat.count = 0;

					return true

				}});

				// 操作统计

				dispatch('storage', {type: 'del', number: counts});

				// 操作云

				api.post({url: '/wanlshop/chat/clear',data: {id: id}});

			}else if(type == 'chat' || type == 'send'){

				let content = '';

				let createtime = data.createtime;

				let chat_id = 0;

				let chat_name = null;

				let chat_avatar = null;

				if (data.message.type == 'text') {

					content = data.message.content.text;

				}else if(data.message.type == 'img') {

					content = '[图片消息]';

				}else if(data.message.type == 'voice') {

					content = '[语音消息]';

				}else if(data.message.type == 'goods') {

					content = '[商品消息]';

				}else{

					content = '[未知类型消息]';

				}

				if(type == 'chat'){

					chat_id = data.form.id;

					dispatch('storage', {type: 'chat'});

				}else if (type == 'send') {

					chat_id = data.to_id;

				}

				let result = state.list.some(chat => {

					if (chat.user_id == chat_id) {

						if(type == 'chat'){

							chat.count += 1;

						}

						chat.createtime = createtime;

						chat.content = content;

						return true

					}

				});

				// 如果没有新增一个，chat 数量初始1

				if (!result) {

					Vue.set(state.list, 0, {

						id: shop.id,

						user_id: shop.user_id,

						name: shop.name,

						avatar: shop.avatar,

						content: content,

						count: 1,

						createtime: createtime,

					});

				}

			}

		},

		// 操作储存

		async storage({state, rootState}, {type, number}) {

			if(type == 'statis'){

				rootState.statistics.notice.chat = number; 

			}else if(type == 'order'){

				rootState.statistics.notice.order += 1;

			}else if(type == 'notice'){

				rootState.statistics.notice.notice += 1;

			}else if(type == 'chat'){

				rootState.statistics.notice.chat += 1;

			}else if(type == 'del'){

				rootState.statistics.notice.chat -= number;

			}else if(type == 'empty'){

				rootState.statistics.notice.chat = 0; 

				rootState.statistics.notice.order = 0; 

				rootState.statistics.notice.notice = 0; 

			}

			uni.setStorageSync("wanlshop:statis", rootState.statistics);

		},

		// 关闭即时通讯

		async close(){

			uni.onSocketOpen(()=> {

				uni.closeSocket();

			});

			uni.onSocketClose((res)=> {

				console.log('WanlChat 已关闭！');

			});

		}

 	}

 };



