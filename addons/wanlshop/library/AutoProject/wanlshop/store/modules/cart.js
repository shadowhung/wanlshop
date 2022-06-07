/**

 * WanlShop状态管理器 - 购物车

 * 

 * @ author 深圳前海万联科技有限公司 <wanlshop@i36k.com> 

 * < 程序仅用作FastAdmin付费插件API测试使用，未经版权所有权人书面许可，不能用于商业用途！>

 * < 购物车状态管理器，不得复制、二次开发到第三方项目，否则我们会追究其法律责任 >

 * @ link http://www.wanlshop.com

 * @ 2020年9月29日19:00:46

 * @ version 1.0.0

 **/

import Vue from 'vue';

import api from '../../common/request/request'; 

import fun from '../../common/wanlshop_function'; 

export default {

	namespaced: true,

	state: {

		list: [], // 购物车数据

		cartnum: 0, // 商品数量

		allchoose: 0, //店铺选中个数

		allsum: 0, //总计价格

		allnum: 0, //总计数量

		status: false, //全选选中状态

		operate: false //管理购物车状态

	},

	actions: {

		async operate({state}) {

			state.operate = !state.operate;

		},

		async get({state, dispatch, rootState}){

			setTimeout(()=> {

				// 初始化购物车复用同步购物车

				if (rootState.user.isLogin) {

					// 如果登录则同步

					dispatch('login');

				}else{

					// 否则 初始化客户端，购物车用本地赋值，后续格式化购物车数据，整理

					uni.getStorageSync("wanlshop:cart") ? dispatch('format', uni.getStorageSync("wanlshop:cart")) : '';

				}

			}, 1000);

		},

		async login({state, dispatch}){

			let cart = uni.getStorageSync("wanlshop:cart");

			// 强制合并

			api.post({

				url: '/wanlshop/cart/synchro',

				data: {

					cart: cart ? cart: null

				},

				success: res => {

					dispatch('format', res);

				}

			});

		},

		// 操作商品 1.0.2升级 ---------------------------------------------------------------------------

		async choose({state, dispatch}, {index, keys}) {

			let cart = state.list[index];

			let goods = cart.products[keys];

			!goods.checked ? dispatch('choosetrue', {cart:cart, goods:goods}) : dispatch('choosefalse', {cart:cart, goods:goods});

		},

		async choosetrue({state}, {cart, goods}) {

			//将商品选中状态改为true

			goods.checked = true; 

			// 选中商品数量先+1

			cart.choose++;

			// 再与该店铺商品数量比较，如果相等就更改店铺选中状态为true

			if (cart.choose === cart.products.length) {

				cart.check = true;

			}

			//如果店铺选中状态改为true

			if (cart.check) {

				// 选中店铺，数量先+1

				state.allchoose++;

				// 再与店铺数量比较，如果相等就更改全选选中状态为true

				if (state.allchoose === state.list.length) {

					state.status = true;

				}else{

					state.status = false;

				}

			}

			state.allsum = fun.bcadd(state.allsum, goods.sum);

			state.allnum += goods.number;

		},

		async choosefalse({state}, {cart, goods}) {

			// 将商品选中状态改为false

			goods.checked = false; 

			// 选中商品数量-1

			cart.choose--;

			//如果店铺是被选中的，更改店铺选中状态

			if (cart.check) { 

				cart.check = false;

				//并且选中店铺数量-1

				state.allchoose--; 

			}

			state.status = false; //无论之前全选的状态，将其改为false就行

			state.allsum = fun.bcsub(state.allsum, goods.sum); //商品总计价格变动

			state.allnum -= goods.number;

		},

		// 操作店铺

		async shopchoose({dispatch}, cart) {

			!cart.check ? dispatch('shoptrue', cart) : dispatch('shopfalse', cart);

		},

		async shoptrue({dispatch}, cart) {

			//循环店铺中的商品，先筛选出目前没选中的商品，给它执行choosetrue

			cart.products.forEach((goods) => {

				goods.checked === false && dispatch('choosetrue', {cart:cart, goods:goods}); 

			})

		},

		async shopfalse({dispatch}, cart) {

			//循环店铺中的商品，先筛选出目前被选中的商品，给它执行choosefalse

			cart.products.forEach((goods) => {

				goods.checked === true && dispatch('choosefalse', {cart:cart, goods:goods});

			})

		},

		// 全选

		async cartchoose({state, dispatch}) {

			state.status = !state.status //取反改变状态

			//根据取反后的状态进行相应的店铺按钮操作   

			state.status ? state.list.forEach((cart) => dispatch('shoptrue', cart)) : state.list.forEach((cart) => dispatch('shopfalse', cart));

		},

		// 结算

		async settlement({state, dispatch, rootState}){

			let data = [];

			state.list.forEach((cart, index) => {

				cart.products.forEach((goods, key) => {

					if (goods.checked) {

						data.push({

							goods_id: goods.goods_id,

							number: goods.number,

							sku_id: goods.sku.id

						});

					}

				});

			});

			// 判断是否登录

			rootState.user.isLogin ? uni.navigateTo({url: `/pages/user/order/addorder?type=cart&data=${JSON.stringify(data)}`}) : uni.navigateTo({url: `/pages/user/auth/auth`});

		},

		// 整理本地数据、云端同步数据-------------------------------------------需要同步----------

		async format({state, dispatch}, data){

			let map = {},dest = [];

			for (let i = 0; i < data.length; i++) {

				let cart = data[i];

				// 1.0.2升级 读取数据库暂时取消所有已选

				cart.checked = false;

				if (!map[cart.shop_id]) {

					dest.push({

						shop_id: cart.shop_id,

						shop_name: cart.shop_name,

						products: [cart],

						check: false,

						choose: 0

					});

					map[cart.shop_id] = cart;

				} else {

					for (let j = 0; j < dest.length; j++) {

						let dj = dest[j];

						if (dj.shop_id == cart.shop_id) {

							dj.products.push(cart);

							break;

						}

					}

				}

			}

			state.list = dest;

			state.cartnum = 0;

			state.allchoose = 0;

			state.allsum = 0;

			state.allnum = 0;

			state.status = false; // 全选选中状态

			state.operate = false; // 管理购物车状态

			dispatch('storage', {type: 'synchro'});

		},

		// 加

		async bcadd({state, dispatch}, goods) {

			goods.number++;

			goods.sum = fun.bcadd(goods.sum, goods.sku.price);

			if (goods.checked) {

				state.allnum++;

				state.allsum = fun.bcadd(state.allsum, goods.sku.price);

			}

			dispatch('storage', {type: 'bcadd', goods: goods});

		},

		// 减

		async bcsub({state, dispatch}, goods) {

			if (goods.number > 1){

				goods.number--;

				goods.sum = fun.bcsub(goods.sum, goods.sku.price);

				if (goods.checked) {

					state.allnum--;

					state.allsum = fun.bcsub(state.allsum, goods.sku.price);

				}

				dispatch('storage', {type: 'bcsub', goods: goods});

			}

		},

		// 添加购物车---------------------------------------------------------------------------

		async add({state, dispatch}, goods){

			let isshop = -1;

			let data = {goods_id: goods.goods_id,sku_id: goods.sku_id,title: goods.title,image: goods.image,sku: goods.sku,number: goods.number,sum: goods.sum,checked: false};

			state.list.find((item, index)=> { 

				if(item.shop_id == goods.shop_id){

					isshop = index;

				}

			});

			// 新店铺

			if (isshop == -1) {

				state.list.push({

					shop_id: goods.shop_id,

					shop_name: goods.shop_name,

					products: [data],

					check: false, //店铺选中状态

					choose: 0, //商品选中个数

				}); 

			}else{

				// 老店铺追加

				let products = state.list[isshop].products;

				let isgoods = -1;

				products.find((item, index)=> {

					if(item.goods_id === goods.goods_id && item.sku_id === goods.sku_id){

						isgoods = index;

					}

				});

				if (isgoods == -1) {

					// 有新，即不会全选，复用以上方法全取消

					dispatch('shopfalse', state.list[isshop]);

					products.push(data);

				}else{

					// 商品已存在，只添加数量

					let shop = products[isgoods];

					shop.number += goods.number;

					shop.sum = fun.bcmul(goods.sku.price, shop.number);

					// 如果店铺全选,必须取消店铺全选

					if (shop.checked) {

						state.allnum += goods.number;

						state.allsum = fun.bcadd(state.allsum, fun.bcmul(goods.sku.price, goods.number));

					}

				}

			}

			dispatch('storage', {type: 'add', goods: goods});

		},

		// 移动入关注

		async move({state, dispatch, rootState}){

			// 判断是否登录

			rootState.user.isLogin ? dispatch('storage', {type: 'follow'}) : uni.navigateTo({url: `/pages/user/auth/auth`});

		},

		// 删除购物车

		async del({state, dispatch}){

			// 判断是否全选如果全选直接清空

			if (state.status) {

				dispatch('empty');

			}else{

				dispatch('storage', {type: 'del'});

			}

		},

		// 清空购物车

		async empty({state, dispatch}){

			state.list = [];

			state.cartnum = 0;

			state.allchoose = 0;

			state.allsum = 0;

			state.allnum = 0;

			state.status = false; // 全选选中状态

			state.operate = false; // 管理购物车状态

			dispatch('storage', {type: 'empty'});

		},

		// 数据操作 1.0.2升级

		async storage({state, dispatch, rootState}, {type, goods}){

			let cloud = null; // 云端更新条件

			let storage = []; // 本地更新条件

			// 删除，移动关注需要用到

			let select = []; // 选中数据

			let unchecked = []; // 未选中数据

			// 操作数据

			if(type == 'empty'){

				cloud = {type: type};

			}else{

				// 遍历

				state.list.forEach((cart, index) => {

					cart.products.forEach((item, key) => {

						let data = {shop_id: cart.shop_id,shop_name: cart.shop_name,goods_id: item.goods_id,title: item.title,number: item.number,image: item.image,sku: item.sku,sku_id: item.sku_id,sum: item.sum,checked: item.checked};

						if (type == 'del' || type == 'follow') {

							if (item.checked) {

								select.push(data);

							}else{

								unchecked.push(data);

							}

						}else{

							storage.push(data);

						}

					});

				});

				// 统计数量

				state.cartnum = storage.length;

				// 整理数据

				if(type == 'bcsub' || type == 'bcadd'){

					cloud = {type: type, goods_id: goods.goods_id, sku_id: goods.sku_id, number: goods.number, sum: goods.sum};

				}else if(type == 'del' || type == 'follow'){

					dispatch('format', unchecked);

					storage = unchecked;

					cloud = {type: type, data: select};

					// 取消管理

					state.operate = false;

				}else if(type == 'add'){

					cloud = {type: type, data: goods};

					// 取消全选

					state.status = false;

				}

			}

			// 操作云端

			if (cloud != null && rootState.user.isLogin) {

				api.post({

					url: '/wanlshop/cart/storage',

					data: cloud,

					success: res => {

						if (type == 'follow') {

							rootState.statistics.dynamic.collection = rootState.statistics.dynamic.collection + res;

						}

					}

				});

			}

			// 保存本地

			uni.setStorageSync("wanlshop:cart", storage);

		}

	}

};
