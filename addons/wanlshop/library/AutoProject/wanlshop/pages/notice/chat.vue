<!-- 
	版本声明：
	* 由于 WanlLive、WanlChat、以下代码开发难度较大，已将相关代码独立申请著作权，受法律保护！！！
	* 无论你购买任何版本，均不允许复制到第三方直接、间接使用，且也不能以学习为目的参考和借鉴！！
	* 你仅有在 WanlShop 中使用、二次开发权利，否则我们会追究法律责任 
	* 福建度虎科技有限公司 @www.i36k.com
-->
<template>
	<view class="wanl-chat">
		<view class="edgeInsetTop"></view>
		<view @touchstart="hideDrawer">
			<scroll-view class="cu-chat" scroll-y="true" :scroll-with-animation="scrollAnimation" :scroll-top="scrollTop"
			 :scroll-into-view="scrollToView" @scrolltoupper="loadHistory" upper-threshold="50">
				<!-- 加载历史数据waitingUI -->
				<view class="loading" v-show="isHistoryLoading">
					<view class="spinner">
						<view class="rect1"></view>
						<view class="rect2"></view>
						<view class="rect3"></view>
						<view class="rect4"></view>
						<view class="rect5"></view>
					</view>
				</view>
				<view v-for="(row, index) in msgList" :key="index" :id="'msg' + row.id">
					<view v-if="row.type == 'chat'">
						<view class="cu-item self" v-if="row.to_id == to_id">
							<view class="main" v-if="row.message.type == 'text'">
								<view class="content bg-green">
									<rich-text :nodes="row.message.content.text"></rich-text>
								</view>
							</view>
							<!-- 图片消息 -->
							<view class="main" v-if="row.message.type == 'img'">
								<image :src="row.message.content.url" @tap="showPic(row.message)" :style="{ width: row.message.content.w + 'px', height: row.message.content.h + 'px' }"></image>
							</view>
							<!-- 语音消息 -->
							<view class="main" v-if="row.message.type == 'voice'" @tap="playVoice(row.message)" :class="playMsgid == row.message.id ? 'play' : ''">
								<view class="action text-bold text-grey" style="padding-right: 2rpx;">
									{{ row.message.content.length }}
									<text class="wlIcon-miao"></text>
								</view>
								<view class="content bg-green">
									<text :style="{ width: row.message.content.length * 6 + 'rpx' }"></text>
									<text class="wlIcon-yuyinyou text-xxl padding-left-xl"></text>
								</view>
							</view>
							<!-- 商品消息 1.0.2升级 -->
							<view class="main goods" v-if="row.message.type == 'goods'">
								<view class="content" @tap="onGoods(goods.id)">
									<image :src="$wanlshop.oss(row.message.content.image, 100, 0)" mode="widthFix"></image>
									<view class="text-price text-orange text-lg margin-tb-xs">
										{{row.message.content.price}}
									</view>
									<view>
										{{row.message.content.title}}
									</view>
								</view>
							</view>
							<!-- 订单消息 1.0.2升级 -->
							<view class="main order" v-if="row.message.type == 'order'">
								<view class="content" @tap="orderDetails(row.message.content.id)">
									<view class="">
										<text>订单详情：</text>
									</view>
									<view class="margin-tb-bj radius product padding-sm">
										<view class="item" v-for="(item, index) in row.message.content.goods" :key="index">
											<view class="image">
												<image :src="$wanlshop.oss(item.image, 50, 50)" mode="aspectFill"></image>
											</view>
											<view class="details text-sm">
												<view class="text-cut wanl-gray-dark">
													<text>{{item.title}}</text>
												</view>
												<view class="wanl-gray-light flex justify-between" style="width: 100%;">
													<view class="text-price text-orange">
														{{item.price * item.number}}
													</view>
													<view>
														<text>{{item.difference}} x {{item.number}}</text>
														<text v-if="item.refund_status != 0">({{refundStatusText[item.refund_status]}})</text>
													</view>
												</view>
											</view>
										</view>
									</view>
									<view class="text-sm flex justify-between ">
										<view>
											<text class="">{{stateText[row.message.content.state-1]}}</text>
										</view>
										<view>
											<text>ID：</text>
											<text>{{row.message.content.order_no}}</text>
										</view>
									</view>
								</view>
							</view>

							<view class="cu-avatar radius" :style="{ backgroundImage: 'url(' + $wanlshop.oss(row.form.avatar, 100, 100) + ')' }"></view>
							<view class="date">{{ $wanlshop.timeToChat(row.createtime) }}</view>
						</view>
						<view class="cu-item" v-else>
							<view class="cu-avatar radius" :style="{ backgroundImage: 'url(' + $wanlshop.oss(row.form.avatar, 100, 100) + ')' }"></view>
							<view class="main" v-if="row.message.type == 'text'">
								<view class="content">
									<rich-text :nodes="row.message.content.text"></rich-text>
								</view>
							</view>
							<!-- 图片消息 -->
							<view class="main" v-if="row.message.type == 'img'">
								<image :src="row.message.content.url" @tap="showPic(row.message)" :style="{ width: row.message.content.w + 'px', height: row.message.content.h + 'px' }"></image>
							</view>
							<!-- 语音消息 -->
							<view class="main" v-if="row.message.type == 'voice'" @tap="playVoice(row.message)" :class="playMsgid == row.message.id ? 'play' : ''">
								<view class="content">
									<text class="wlIcon-yuyinzuo text-xxl padding-right-xl"></text>
									<text :style="{ width: row.message.content.length * 6 + 'rpx' }"></text>
								</view>
								<view class="action text-bold text-grey">
									{{ row.message.content.length }}
									<text class="wlIcon-miao"></text>
								</view>
							</view>
							<view class="date ">{{ $wanlshop.timeToChat(row.createtime) }}</view>
						</view>
					</view>
					<view v-if="row.type == 'sys'">
						<!-- 系统消息 -->
						<view class="cu-info round">对方撤回一条消息!</view>
					</view>
				</view>
			</scroll-view>
		</view>
		<!-- 抽屉栏 -->
		<view class="popup-layer" :class="{showLayer: popupLayerClass}" @touchmove.stop.prevent="discard">
			<!-- 表情 -->
			<view :class="{ hidden: hideEmoji }">
				<view class="emoji">
					<scroll-view class="emojinav" scroll-x scroll-with-animation>
						<view class="item">
							<view :class="item == TabCur ? 'emojibg' : ''" v-for="(item, index) in emojiList.categories" :key="index" @tap="tabSelect"
							 :data-id="item" :style="{ backgroundImage: 'url(' + emojiList.groups[item][0].url + ')' }"></view>
						</view>
					</scroll-view>
					<!-- 列表 -->
					<scroll-view v-for="(emoji, groups) in emojiList.groups" :key="groups" v-if="TabCur == groups" class="subject"
					 scroll-y scroll-with-animation>
						<view class="item grid margin-bottom text-center col-5">
							<view v-for="(item, index) in emoji" :key="index" @tap="addEmoji(item.value)" :style="{ backgroundImage: 'url(' + item.url + ')' }"></view>
						</view>
					</scroll-view>
				</view>
			</view>
			<!-- 更多功能 1.0.2升级 -->
			<view class="solid-top" :class="{ hidden: hideMore }">
				<view class="opmenu solid-top">
					<view class="box" @tap="browsing">
						<view class="icon wanl-gray"><text class="wlIcon-shangpin-"></text></view>
						<text class="text-sm">商品</text>
					</view>
					<view class="box" @tap="order">
						<view class="icon wanl-gray"><text class="wlIcon-dingdan1"></text></view>
						<text class="text-sm">订单</text>
					</view>
					<!-- #ifndef H5 -->
					<view class="box" @tap="camera">
						<view class="icon wanl-gray"><text class="wlIcon-31paishexuanzhong"></text></view>
						<text class="text-sm">拍摄</text>
					</view>
					<!-- #endif -->
					<view class="box" @tap="chooseImage">
						<view class="icon wanl-gray"><text class="wlIcon-tupian1"></text></view>
						<text class="text-sm">照片</text>
					</view>
					<view class="box" @tap="complaint">
						<view class="icon wanl-gray"><text class="wlIcon-zhuyidapx"></text></view>
						<text class="text-sm">投诉</text>
					</view>
				</view>
			</view>
		</view>
		<!-- 底部输入栏 -->
		<view class="input-box" :class="{ emptybottom: emptybottom, showLayer: popupLayerClass}" @touchmove.stop.prevent="discard">
			<!-- H5下不能录音，输入栏布局改动一下 -->
			<!-- #ifndef H5 -->
			<view class="voice">
				<view :class="isVoice ? 'wlIcon-jianpanqiehuan' : 'wlIcon-yuyin'" @tap="switchVoice"></view>
			</view>
			<!-- #endif -->

			<!-- #ifdef H5 -->
			<view class="more" @tap="showMore">
				<view class="wlIcon-yuanquanjiahao"></view>
			</view>
			<!-- #endif -->
			<view class="textbox">
				<view class="voice-mode" :class="[isVoice ? '' : 'hidden', recording ? 'recording' : '']" @touchstart="voiceBegin"
				 @touchmove.stop.prevent="voiceIng" @touchend="voiceEnd" @touchcancel="voiceCancel">
					{{ voiceTis }}
				</view>
				<view class="text-mode" :class="isVoice ? 'hidden' : ''">
					<view class="box">
						<textarea auto-height="true" maxlength="300" :show-confirm-bar="false" cursor-spacing="90" v-model="textMsg"
						 @focus="textareaFocus" @blur="textareaBlur" @confirm="sendText" />
						</view>
					<view class="em" @tap="chooseEmoji"><view class="wlIcon-biaoqing2"></view></view>
				</view>
			</view>
			<!-- #ifndef H5 -->
			<view class="more" @tap="showMore" style="margin-right: -12rpx;"><view class="wlIcon-yuanquanjiahao"></view></view>
			<!-- #endif -->
			<view class="send" :class="isVoice ? 'hidden' : ''" @tap="sendText">
				<text class="wlIcon-zhifeiji" v-if="textMsg"></text>
				<text class="wlIcon-fasong" v-else></text>
			</view>
		</view>
		<!-- 提示 1.0.2升级 -->
		<view class="chatTips bg-white radius-bock margin-lr-bj padding-sm" v-if="goods && isGoods">
			<image class="radius" :src="$wanlshop.oss(goods.image,100,100)" mode="aspectFill"></image>
			<view class="details">
				<view class="flex justify-between margin-bottom-sm">
					<view class="text-cut title">
						<text>{{goods.title}}</text>
					</view>
					<view @tap="closeTips()">
						<text class="wlIcon-31guanbi"></text>
					</view>
				</view>
				<view class="flex justify-between">
					<view class="text-lg text-orange">
						<text class="text-price">{{goods.price}}</text>
					</view>
					<view>
						<button class="cu-btn round bg-orange sm" @tap="sendGoods(goods)">发送商家</button>
					</view>
				</view>
			</view>
		</view>
		<!-- 录音UI效果 -->
		<view class="record" :class="recording ? '' : 'hidden'">
			<view class="ing" :class="willStop ? 'hidden' : ''"><view class="wlIcon-huatong01"></view></view>
			<view class="cancel" :class="willStop ? '' : 'hidden'"><view class="wlIcon-shanchu2"></view></view>
			<view class="tis" :class="willStop ? 'change' : ''">{{ recordTis }}</view>
		</view>
		<!-- 模态框 -->
		<view class="WANL-MODAL">
			<!-- 商品列表 -->
			<view class="cu-modal bottom-modal" :class="modalName == 'goods' ? 'show' : ''" @tap="hideModal">
				<view class="cu-dialog bg-white" @tap.stop="">
					<view class="wanl-modal">
						<view class="head padding-bj">
							<view class="content"><view class="text-lg">浏览过的商品</view></view>
							<view class="close wlIcon-31guanbi" @tap="hideModal"></view>
						</view>
						<scroll-view class="scroll-y" scroll-y="true">
							<view class="item goods" v-for="(item, index) in goodsData" :key="index">
								<image class="radius" :src="$wanlshop.oss(item.goods.image,100,100)" mode="aspectFill"></image>
								<view class="details">
									<view class="text-cut-2 title">
										<text>{{item.goods.title}}</text>
									</view>
									<view class="flex justify-between info">
										<view class="text-lg text-orange">
											<text class="text-price">{{item.goods.price}}</text>
										</view>
										<button class="cu-btn round line-orange sm" @tap="sendGoods(item.goods)">发送商品</button>
									</view>
								</view>
							</view>
						</scroll-view>
						<view class="foot padding-lr-bj"><button class="cu-btn bg-gradual-orange round text-bold complete" @tap="hideModal">完成</button></view>
					</view>
				</view>
			</view>
			<!-- 订单列表 -->
			<view class="cu-modal bottom-modal" :class="modalName == 'order' ? 'show' : ''" @tap="hideModal">
				<view class="cu-dialog bg-bgcolor" @tap.stop="">
					<view class="wanl-modal">
						<view class="head padding-bj">
							<view class="content"><view class="text-lg">购买过的订单</view></view>
							<view class="close wlIcon-31guanbi" @tap="hideModal"></view>
						</view>
						<scroll-view class="scroll-y" scroll-y="true">
							<view class="item bg-white radius-bock margin-tb-sm padding-bj" v-for="(item, index) in orderData" :key="item.id" @tap="sendOrder(item)">
								<view class="flex justify-between">
									<text>订单号：{{item.order_no}}</text>
									<text class="wanl-gray-dark text-sm">{{stateText[item.state-1]}}</text>
								</view>
								<view class="goods" v-for="(goods, key) in item.goods" :key="key">
									<image class="radius" :src="$wanlshop.oss(goods.image,100,100)" mode="aspectFill"></image>
									<view class="details">
										<view class="text-cut-2 title wanl-gray-dark">
											<text>{{goods.title}}</text>
										</view>
										<view class="flex justify-between info">
											<view class="text-lg text-orange">
												<text class="text-price">{{goods.price}}</text>
											</view>
											<!-- <button v-if="goods.refund_status != 0" class="cu-btn round sm" :class="refundStatusBg[goods.refund_status]">{{refundStatusText[goods.refund_status]}}</button> -->
										</view>
									</view>
								</view>
								<view class="flex justify-end">
									<button class="cu-btn round sm line-orange">发送订单</button>
								</view>
							</view>
						</scroll-view>
						<view class="foot padding-lr-bj"><button class="cu-btn bg-gradual-orange round text-bold complete" @tap="hideModal">完成</button></view>
					</view>
				</view>
			</view>
		</view>
	</view>
</template>
<script>
const emotions = require('@/static/json/emotions.json');
import { mapMutations } from 'vuex';
export default {
	data() {
		return {
			user_id: this.$store.state.user.id,
			avatar: this.$store.state.user.avatar,
			username: this.$store.state.user.username,
			nickname: this.$store.state.user.nickname,
			to_id: 0,
			shop_id: 0,
			shop_name: null,
			shop_avatar: null,
			textMsg: '', //文字消息
			isHistoryLoading: false, //消息列表
			reload: false,
			current_page: 1,
			scrollAnimation: false,
			scrollTop: 0,
			scrollToView: '',
			msgList: [],
			msgImgList: [],
			goods: null,
			isGoods: true,
			goodsData: [],
			orderData: [],
			// 取消底部
			emptybottom: false,
			//录音相关参数
			// #ifndef H5
			//H5不能录音
			RECORDER: uni.getRecorderManager(),
			// #endif
			isVoice: false,
			voiceTis: '按住 说话',
			recordTis: '手指上滑 取消发送',
			recording: false,
			willStop: false,
			initPoint: { identifier: 0, Y: 0 },
			recordTimer: null,
			recordLength: 0,
			//播放语音相关参数
			AUDIO: uni.createInnerAudioContext(),
			playMsgid: null,
			VoiceTimer: null,
			// 抽屉参数
			popupLayerClass: false,
			// more参数
			hideMore: true,
			modalName: null,
			stateText: ["等待您付款", "付款成功", "待收货", "待评论", "退款订单", "订单已完成", "交易关闭"],
			refundStatusText: ["未退款", "退款中", "待退货", "退款完成", "退款关闭", "退款被拒"],
			refundStatusBg: ["", "bg-orange", "bg-red", "bg-green", "bg-grey", "bg-red"],
			//表情定义
			//表情
			TabCur: '默认',
			hideEmoji: true,
			emojiList: this.emojiData(),
			QnUrl: '',
			Sysmodel: this.$wanlshop.wanlsys().model
		};
	},
	onLoad(option) {
		// 判断是否通过商品进来 1.0.2升级
		if (option.hasOwnProperty('goods')) {
			this.goods = JSON.parse(option.goods);
			setTimeout(()=> {
				this.isGoods = false;
			}, 5000);
		}
		// 临时关闭推送
		this.$store.commit('chat/setIschat', {notice: false});
		// 查看权限 1.0.2升级 追加商家在线状态 
		this.$api.post({
			url: '/wanlshop/shop/shop',
			data: {
				id: option.shop_id,
				type: 'chat'
			},
			success: res => {
				this.to_id = res.user_id;
				this.shop_id = res.id;
				// 新版新追加
				this.shop_name = res.shopname;
				this.shop_avatar = res.avatar;
				this.$wanlshop.title(res.shopname + (res.isOnline == 1 ? '-在线':'-离线'));
				// 初始界面
				this.getMsgList(res.user_id);
			}
		});
		//语音自然播放结束
		this.AUDIO.onEnded(res => {
			this.playMsgid = null;
		});
		// #ifndef H5
		//录音开始事件
		this.RECORDER.onStart(e => {
			this.recordBegin(e);
		});
		//录音结束事件
		this.RECORDER.onStop(e => {
			this.recordEnd(e);
		});
		// #endif
		// 监听服务消息
		uni.$on('onChat', this.onSend);
	},
	// 店铺按钮
	onNavigationBarButtonTap() {
		this.onShop(this.shop_id);
	},
	// 监听返回
	onUnload() {
		this.$store.dispatch('chat/update', {type:'del', id:this.to_id});
		// 恢复全局监听
		this.$store.commit('chat/setIschat', {notice: true, number: 0});
	},
	onShow() {
		this.scrollTop = 9999999;
	},
	methods: {
		getMsgList(id) {
			// 消息列表
			uni.getStorage({
				key: 'wanlchat:message_' + id,
				success: res => {
					var list = res.data;
					for (let i = 0; i < list.length; i++) {
						// 获取消息中的图片,并处理显示尺寸
						if (list[i].type == 'chat' && list[i].message.type == 'img') {
							list[i].message.content = this.setPicSize(list[i].message.content);
							this.msgImgList.push(list[i].message.content.url);
						}
						// 获取消息中表情，并处理为图片
						if (list[i].type == 'chat' && list[i].message.type == 'text') {
							list[i].message.content.text = this.replaceEmoji(list[i].message.content.text);
						}
					}
					this.msgList = list;
					// 滚动到底部
					this.$nextTick(() => {
						//进入页面滚动到底部
						this.scrollTop = 9999;
						this.$nextTick(() => {
							this.scrollAnimation = true;
						});
					});
				}
			});
		},
		// 接受本地消息
		onChat(msg) {
			if (msg.type == 'system') {
				if (msg.msg.type == 'text') {
					this.addSystemTextMsg(msg);
				}
			} else if (msg.type == 'chat') {
				// 用户消息
				if (msg.message.type == 'text') {
					this.addTextMsg(msg);
				}
				if (msg.message.type == 'voice') {
					this.addVoiceMsg(msg);
				}
				if (msg.message.type == 'img') {
					this.addImgMsg(msg);
				}
				// 1.0.2升级
				if (msg.message.type == 'goods') {
					this.addGoodsMsg(msg);
				}
				if (msg.message.type == 'order') {
					this.addOrderMsg(msg);
				}
			}
			// 滚动到底
			this.$nextTick(() => {
				this.scrollToView = 'msg' + msg.id;
			});
		},
		// 接受在线消息
		onSend(msg) {
			if (msg.form.id == this.to_id) {
				if (msg.type == 'system') {
					if (msg.msg.type == 'text') {
						this.addSystemTextMsg(msg);
					}
				} else if (msg.type == 'chat') {
					// 用户消息
					if (msg.message.type == 'text') {
						this.addTextMsg(msg);
					}
					if (msg.message.type == 'voice') {
						this.addVoiceMsg(msg);
					}
					if (msg.message.type == 'img') {
						this.addImgMsg(msg);
					}
					if (msg.message.type == 'goods') {
						this.addGoodsMsg(msg);
					}
					if (msg.message.type == 'order') {
						this.addOrderMsg(msg);
					}
				}
				// 滚动到底
				this.$nextTick(() => {
					this.scrollToView = 'msg' + msg.id;
				});
			}
		},
		// 发送消息
		sendMsg(content, type) {
			let lastid = 1;
			if (this.msgList.length) {
				lastid = this.msgList[this.msgList.length - 1].id;
				lastid++;
			}
			let data = {
				id: lastid,
				type: 'chat',
				to_id: this.to_id,
				form: {
					id: this.user_id, //本人
					avatar: this.avatar,
					name: this.nickname
				},
				message: {
					type: type,
					content: content
				},
				createtime: parseInt(new Date().getTime() / 1000)
			};
			// 深拷贝移除数据绑定
			this.onChat(JSON.parse(JSON.stringify(data)));
			// 更新列表
			this.$store.dispatch('chat/update', {type:'send', data:data, shop: {
				id: this.shop_id,
				user_id: this.to_id,
				name: this.shop_name,
				avatar: this.shop_avatar,
			}});
			// 发送消息
			this.$wanlshop.send(data);
		},
		// 添加文字消息到列表
		addTextMsg(msg) {
			msg.message.content.text = this.replaceEmoji(msg.message.content.text);
			this.msgList.push(msg);
		},
		// 添加语音消息到列表
		addVoiceMsg(msg) {
			this.msgList.push(msg);
		},
		// 添加图片消息到列表
		addImgMsg(msg) {
			msg.message.content = this.setPicSize(msg.message.content);
			this.msgImgList.push(msg.message.content.url);
			this.msgList.push(msg);
		},
		// 添加商品消息到列表 1.0.2升级
		addGoodsMsg(msg) {
			this.msgList.push(msg);
		},
		addOrderMsg(msg) {
			this.msgList.push(msg);
		},
		// 添加系统文字消息到列表
		addSystemTextMsg(msg) {
			this.msgList.push(msg);
		},
		// 表情数据
		emojiData() {
			var groups = {},
				categories = [],
				map = {};
			emotions.forEach(emotion => {
				var cate = emotion.category.length > 0 ? emotion.category : '默认';
				if (!groups[cate]) {
					groups[cate] = [];
					categories.push(cate);
				}
				groups[cate].push(emotion);
				map[emotion.phrase] = emotion.icon;
			});
			return { groups, categories, map };
		},
		//替换表情符号为图片
		replaceEmoji(str) {
			// 这里处理 链接   换行符
			let replacedStr = str.replace(/\[([^(\]|\[)]*)\]/g, (item, index) => {
				return '<img src="' + this.emojiList.map[item] + '" width="18rpx">';
			});
			return replacedStr.replace(/(\r\n)|(\n)/g, '<br>');
		},
		// 表情tab
		tabSelect(e) {
			this.TabCur = e.currentTarget.dataset.id;
		},
		//触发滑动到顶部(加载历史信息记录)
		loadHistory(e) {
			if (this.isHistoryLoading) {
				return;
			}
			// 说明加载过一次，并且没有任何记录了
			if (this.reload) {
				return;
			}
			this.isHistoryLoading = true; //参数作为进入请求标识，防止重复请求
			this.scrollAnimation = false; //关闭滑动动画
			let view_id = this.msgList[0].id; //记住第一个信息ID
			//请求历史记录效果
			this.$api.post({
				url: '/wanlshop/chat/history',
				data: {
					to_id: this.to_id,
					page: this.current_page
				},
				success: res => {
					// 消息列表
					let list = res.data;
					// 获取消息中的图片,并处理显示尺寸
					for (let i = 0; i < list.length; i++) {
						if (list[i].type == 'chat' && list[i].message.type == 'img') {
							list[i].message.content = this.setPicSize(list[i].message.content);
							this.msgImgList.unshift(list[i].message.content.url);
						}
						// 获取消息中表情，并处理为图片
						if (list[i].type == 'chat' && list[i].message.type == 'text') {
							list[i].message.content.text = this.replaceEmoji(list[i].message.content.text);
						}
					}
					list.sort(function(a, b) {
						return a.updatetime - b.updatetime;
					});
					this.msgList = res.current_page == 1 ? list : list.concat(this.msgList);
					//这段代码很重要，不然每次加载历史数据都会跳到顶部
					this.$nextTick(() => {
						this.scrollToView = 'msg' + view_id;
						this.$nextTick(() => {
							this.scrollAnimation = true; //恢复滚动动画
						});
					});
					// 判断尾页
					if (res.current_page == res.last_page) {
						// 下次不允许下拉加载数据了
						this.reload = true;
					} else {
						this.current_page = res.current_page + 1;
					}
					this.isHistoryLoading = false;
				},
				fail: res => {
					this.isHistoryLoading = false;
				}
			});
		},

		//处理图片尺寸，如果不处理宽高，新进入页面加载图片时候会闪
		setPicSize(content) {
			// 让图片最长边等于设置的最大长度，短边等比例缩小，图片控件真实改变，区别于aspectFit方式。
			let maxW = uni.upx2px(350); //350是定义消息图片最大宽度
			let maxH = uni.upx2px(350); //350是定义消息图片最大高度
			if (content.w > maxW || content.h > maxH) {
				let scale = content.w / content.h;
				content.w = scale > 1 ? maxW : maxH * scale;
				content.h = scale > 1 ? maxW / scale : maxH;
			}
			return content;
		},
		//更多功能(点击+弹出)
		showMore() {
			this.isVoice = false;
			this.hideEmoji = true;
			if (this.hideMore) {
				this.hideMore = false;
				this.openDrawer();
			} else {
				this.hideDrawer();
			}
		},
		// 打开抽屉
		openDrawer() {
			this.emptybottom = true;
			this.popupLayerClass = true;
		},
		// 隐藏抽屉
		hideDrawer() {
			this.emptybottom = false;
			this.popupLayerClass = false;
			setTimeout(() => {
				this.hideMore = true;
				this.hideEmoji = true;
			}, 150);
		},
		// 选择图片发送
		chooseImage() {
			this.getImage('album');
		},
		//拍照发送
		camera() {
			this.getImage('camera');
		},
		//选照片 or 拍照
		getImage(type) {
			this.hideDrawer();
			uni.chooseImage({
				sourceType: [type],
				sizeType: ['original', 'compressed'], //可以指定是原图还是压缩图，默认二者都有
				success: res => {
					this.$api.get({
						url: '/wanlshop/common/uploadData',
						success: updata => {
							for (let i = 0; i < res.tempFilePaths.length; i++) {
								// 读取图片宽高
								uni.getImageInfo({
									src: res.tempFilePaths[i],
									success: image => {
										this.$api.upload({
											url: updata.uploadurl,
											filePath: image.path,
											name: 'file',
											formData: updata.storage == 'local' ? null : updata.multipart,
											success: data => {
												this.sendMsg({ url: data.fullurl, w: image.width, h: image.height }, 'img');
											}
										});
									}
								});
							}
						}
					});
				}
			});
		},
		// 预览图片
		showPic(message) {
			uni.previewImage({
				indicator: 'none',
				current: message.content.url,
				urls: this.msgImgList
			});
		},
		// 选择表情
		chooseEmoji() {
			this.hideMore = true;
			if (this.hideEmoji) {
				this.hideEmoji = false;
				this.openDrawer();
			} else {
				this.hideDrawer();
			}
		},
		//添加表情
		addEmoji(em) {
			this.textMsg += em;
		},
		//获取焦点，如果不是选表情ing,则关闭抽屉
		textareaFocus() {
			this.emptybottom = true;
			this.closeTips();
			if (this.popupLayerClass && this.hideMore == false) {
				this.hideDrawer();
			}
		},
		// 失去焦点
		textareaBlur() {
			this.emptybottom = false;
		},
		
		// 发送文字消息
		sendText() {
			this.hideDrawer(); //隐藏抽屉
			if (!this.textMsg) {
				return;
			}
			let msg = { text: this.textMsg };
			this.sendMsg(msg, 'text');
			this.textMsg = ''; //清空输入框
		},
		// 发送商品消息
		sendGoods(data){
			this.sendMsg(data, 'goods');
			this.closeTips();
			this.hideModal();
		},
		// 发送订单消息
		sendOrder(data){
			this.sendMsg({id: data.id,order_no: data.order_no,goods: data.goods,state: data.state}, 'order');
			this.closeTips();
			this.hideModal();
		},
		// 关闭提示窗口
		closeTips(){
			this.isGoods = false;
		},
		// 投诉
		complaint(){
			this.$wanlshop.to(`/pages/user/complaint/complaint?id=${this.shop_id}&type=2`);
			//隐藏抽屉
			this.hideDrawer(); 
		},
		// 查询浏览商品
		browsing(){
			//隐藏抽屉
			this.hideDrawer(); 
			this.$api.post({
				url: '/wanlshop/product/getBrowsingToShop',
				data: {shop_id: this.shop_id},
				success: res => {
					this.goodsData = res;
					this.modalName = 'goods';
				}
			});
		},
		// 查询订单
		order(){
			//隐藏抽屉
			this.hideDrawer(); 
			this.$api.post({
				url: '/wanlshop/order/getOrderListToShop',
				data: {shop_id: this.shop_id},
				success: res => {
					this.orderData = res;
					this.modalName = 'order';
				}
			});
		},
		hideModal() {
			this.modalName = null;
		},
		// 播放语音
		playVoice(message) {
			this.playMsgid = message.id;
			this.AUDIO.src = message.content.url;
			this.$nextTick(() => {
				this.AUDIO.play();
			});
		},
		// 录音开始
		voiceBegin(e) {
			if (e.touches.length > 1) {
				return;
			}
			this.initPoint.Y = e.touches[0].clientY;
			this.initPoint.identifier = e.touches[0].identifier;
			this.RECORDER.start({ format: 'mp3' }); //录音开始,
		},
		//录音开始UI效果
		recordBegin(e) {
			this.recording = true;
			this.voiceTis = '松开 结束';
			this.recordLength = 0;
			this.recordTimer = setInterval(() => {
				this.recordLength++;
			}, 1000);
		},
		// 录音被打断
		voiceCancel() {
			this.recording = false;
			this.voiceTis = '按住 说话';
			this.recordTis = '手指上滑 取消发送';
			this.willStop = true; //不发送录音
			this.RECORDER.stop(); //录音结束
		},
		// 录音中(判断是否触发上滑取消发送)
		voiceIng(e) {
			if (!this.recording) {
				return;
			}
			let touche = e.touches[0];
			//上滑一个导航栏的高度触发上滑取消发送
			if (this.initPoint.Y - touche.clientY >= uni.upx2px(200)) {
				this.willStop = true;
				this.recordTis = '松开手指 取消发送';
			} else {
				this.willStop = false;
				this.recordTis = '手指上滑 取消发送';
			}
		},
		// 结束录音
		voiceEnd(e) {
			if (!this.recording) {
				return;
			}
			this.recording = false;
			this.voiceTis = '按住 说话';
			this.recordTis = '手指上滑 取消发送';
			this.RECORDER.stop(); //录音结束
		},
		//录音结束(回调文件)
		recordEnd(e) {
			clearInterval(this.recordTimer);
			if (!this.willStop) {
				this.$api.get({
					url: '/wanlshop/common/uploadData',
					success: updata => {
						this.$api.upload({
							url: updata.uploadurl,
							filePath: e.tempFilePath,
							name: 'file',
							formData: updata.storage == 'local' ? null : updata.multipart,
							success: data => {
								let msg = {length: 0, url: data.fullurl};
								msg.length = this.recordLength % 60;
								if (msg.length > 0) {
									this.sendMsg(msg, 'voice');
								}
							},
							fail: error =>{
								this.$wanlshop.msg(JSON.parse(error.data).msg);
							}
						});
					}
				});
			} else {
				console.log('取消发送录音');
			}
			this.willStop = false;
		},
		// 切换语音/文字输入
		switchVoice() {
			this.hideDrawer();
			this.isVoice = this.isVoice ? false : true;
		},
		discard() {
			return;
		}
	}
};
</script>
<style>
/* 1.0.2升级 */
.cu-btn.sm{
	font-size: 26rpx;
}
.cu-modal{
	z-index: 2001;
}
.chatTips{
	display: inline-flex;
	align-items: center;
	position: absolute;
	z-index: 101;
	right: 0;
	left: 0;
	bottom: 120rpx;
	bottom: calc(120rpx + env(safe-area-inset-bottom));
}
.chatTips image{
	width: 100rpx;
	height: 100rpx;
	margin-right: 20rpx;
	flex-shrink: 0;
}
.chatTips .details{
	width: calc(100% - 100rpx - 20rpx);
}
.chatTips .details .title{
	width: 90%;
}
.cu-chat .cu-item > .main.goods .content, .cu-chat .cu-item > .main.order .content {
	display: block;
}
.cu-chat .cu-item > .main.order{
	max-width: calc(100% - 200rpx);
}
.cu-chat .cu-item > .main.order .product {
	background-color: #f9f9f9;
}
.cu-chat .cu-item > .main.order .product .item{
	display: flex;
	justify-content: space-between;
	margin-bottom: 25rpx;
}
.cu-chat .cu-item > .main.order .product .item:last-of-type{
	margin-bottom: 0;
}

.cu-chat .cu-item > .main.order .product .item .image, .product .item .image image{
	width: 100rpx;
	height: 100rpx;
	border-radius: 10rpx;
}


.cu-chat .cu-item > .main.order .product .item .details{
	display: flex;
	flex-wrap: wrap;
	width: calc(100% - 120rpx);
	align-content: space-between;
}
/* 1.0.2升级 模态框 */
.wanl-modal .goods{
	display: flex;
	padding: 20rpx 0;
}
.wanl-modal .goods:last-of-type {
	padding-bottom: 0;
}
	
.wanl-modal .goods image{
	width: 180rpx;
	height: 180rpx;
	margin-right: 20rpx;
	flex-shrink: 0;
}
	
.wanl-modal .goods .details{
	flex-wrap: wrap;
	display: flex;
	flex: 1;
	align-content: space-between;
}
	
.wanl-modal .goods .details .info{
	width: 100%;
}	
	
	
	
	
	
	
.opmenu {
	display: flex;
	flex-wrap: wrap;
	margin-top: 2rpx;
	color: #4c4c4c;
}
.opmenu .box {
	padding-top: 35rpx;
	padding-left: 50rpx;
	text-align: center;
}
.opmenu .box .icon {
	height: 120rpx;
	width: 120rpx;
	display: flex;
	align-items: center;
	justify-content: center;
	justify-items: center;
	background-color: #ffffff;
	border-radius: 20rpx;
	font-size: 68rpx;
	margin-bottom: 10rpx;
}
.emptybottom{
	padding-bottom: 0 !important;
}
.hidden {
	display: none !important;
}
.cu-chat .cu-item > .main .content {
	font-size: 30rpx;
	border-radius: 17rpx;
}
.cu-chat .cu-item [class*='wlIcon-'] {
	font-size: 34rpx;
}



.popup-layer {
	transition: all 0.15s linear;
	width: 100%;
	height: 480rpx;
	background-color: #f5f5f5;
	position: fixed;
	z-index: 2000;
	top: 100%;
}
.popup-layer.showLayer {
	transform: translate3d(0, -480rpx, 0);
}
.popup-layer .emoji .emojinav {
	background-color: #f8f8f8;
}
.popup-layer .emoji .emojinav .item {
	display: flex;
	align-items: center;
	height: 100rpx;
	padding-left: 10rpx;
}
.popup-layer .emoji .emojinav .item .emojibg {
	background-color: #dedede;
}
.popup-layer .emoji .emojinav .item > view {
	margin: 0 25rpx;
	width: 60rpx;
	height: 60rpx;
	border-radius: 18rpx;
	background-repeat: no-repeat;
	background-size: 80%;
	background-position: center;
}

.popup-layer .emoji .subject {
	height: 380rpx;
	background-color: #f1f1f1;
}
.popup-layer .emoji .subject .item {
	padding: 25rpx;
}

.popup-layer .emoji .subject .item > view {
	background-repeat: no-repeat;
	background-size: 56%;
	background-position: center;
	width: 12.5%;
	height: 100rpx;
}

.input-box {
	width: 100%;
	min-height: 100rpx;
	padding-bottom: env(safe-area-inset-bottom);
	background-color: #f2f2f2;
	display: flex;
	align-items: flex-end;
	position: fixed;
	z-index: 2000;
	bottom: -2rpx;
	transition: all 0.15s linear;
}
.input-box [class*='wlIcon-'] {
	font-size: 50rpx;
	color: #323232;
}

.input-box .wlIcon-zhifeiji {
	color: #fe6600;
}

.input-box.showLayer {
	transform: translate3d(0, -480rpx, 0);
}
.input-box .voice,
.input-box .more {
	flex-shrink: 0;
	width: 90rpx;
	height: 100rpx;
	display: flex;
	justify-content: center;
	align-items: center;
}
.input-box .send {
	flex-shrink: 0;
	width: 90rpx;
	height: 100rpx;
	display: flex;
	justify-content: center;
	align-items: center;
}
.input-box .send .btn {
	width: 110rpx;
	height: 70rpx;
	display: flex;
	justify-content: center;
	align-items: center;
	border-radius: 16rpx;
	font-size: 32rpx;
}
.input-box .textbox {
	width: 100%;
}
.input-box .textbox .voice-mode {
	width: calc(100% - 2upx);
	height: 80rpx;
	margin: 10rpx 0;
	border-radius: 16rpx;
	display: flex;
	justify-content: center;
	align-items: center;
	font-size: 28rpx;
	background-color: #fff;
	color: #555;
}
.input-box .textbox .voice-mode.recording {
	background-color: #e5e5e5;
}
.input-box .textbox .text-mode {
	width: 100%;
	min-height: 80rpx;
	margin: 10rpx 0;
	display: flex;
	background-color: #ffffff;
	border-radius: 16rpx;
}
.input-box .textbox .text-mode .box {
	width: 100%;
	padding-left: 30rpx;
	min-height: 80rpx;
	display: flex;
	align-items: center;
}
.input-box .textbox .text-mode .box textarea {
	width: 100%;
}
.input-box .textbox .text-mode .em {
	flex-shrink: 0;
	width: 80rpx;
	padding-left: 10rpx;
	height: 80rpx;
	display: flex;
	justify-content: center;
	align-items: center;
}

.record {
	width: 39vw;
	height: 39vw;
	position: fixed;
	top: 35%;
	left: 30%;
	background-color: rgba(0, 0, 0, 0.8);
	border-radius: 40rpx;
}
.record .ing {
	width: 100%;
	height: 30vw;
	display: flex;
	justify-content: center;
	align-items: center;
}
@keyframes volatility {
	0% {
		background-position: 0% 130%;
	}
	20% {
		background-position: 0% 150%;
	}
	30% {
		background-position: 0% 155%;
	}
	40% {
		background-position: 0% 160%;
	}
	50% {
		background-position: 0% 145%;
	}
	70% {
		background-position: 0% 150%;
	}
	80% {
		background-position: 0% 170%;
	}
	90% {
		background-position: 0% 160%;
	}
	100% {
		background-position: 0% 135%;
	}
}
.record .ing [class*='wlIcon'] {
	background-image: linear-gradient(to bottom, #ffffff, #565656 50%);
	background-size: 100% 200%;
	animation: volatility 1.5s ease-in-out -1.5s infinite alternate;
	-webkit-background-clip: text;
	-webkit-text-fill-color: transparent;
	font-size: 140rpx;
	padding-top: 40rpx;
	color: #f09b37;
}
.record .cancel {
	width: 100%;
	height: 30vw;
	display: flex;
	justify-content: center;
	align-items: center;
}
.record .cancel [class*='wlIcon'] {
	color: #fff;
	font-size: 150rpx;
}
.record .tis {
	width: 100%;
	height: 10vw;
	display: flex;
	justify-content: center;
	font-size: 24rpx;
	color: #fff;
}
.record .tis.change {
	color: #f09b37;
}

.content {
	width: 100%;
}
page{
	background-color: #ececec;
}
.content .msg-list,
.cu-chat {
	position: absolute;
	top: 0;
	bottom: 100rpx;
	bottom: calc(env(safe-area-inset-bottom) + 100rpx);
	background-color: #ececec;
}





.loading {
	display: flex;
	justify-content: center;
}
@keyframes stretchdelay {
	0%,
	40%,
	100% {
		transform: scaleY(0.6);
	}
	20% {
		transform: scaleY(1);
	}
}
.loading .spinner {
	margin: 20upx 0;
	width: 60upx;
	height: 100upx;
	display: flex;
	align-items: center;
	justify-content: space-between;
}
.loading .spinner view {
	background-color: #dadada;
	height: 50upx;
	width: 6upx;
	border-radius: 6upx;
	animation: stretchdelay 1.2s infinite ease-in-out;
}
.loading .spinner .rect2 {
	animation-delay: -1.1s;
}
.loading .spinner .rect3 {
	animation-delay: -1s;
}
.loading .spinner .rect4 {
	animation-delay: -0.9s;
}
.loading .spinner .rect5 {
	animation-delay: -0.8s;
}
</style>
