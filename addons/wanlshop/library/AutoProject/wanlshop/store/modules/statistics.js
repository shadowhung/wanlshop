/**

 * WanlShop状态管理器 - 用户管理

 * 

 * @ author 深圳前海万联科技有限公司 <wanlshop@i36k.com> 

 * < 程序仅用作FastAdmin付费插件API测试使用，未经版权所有权人书面许可，不能用于商业用途！>

 * @ link http://www.wanlshop.com

 * @ 2020年9月29日19:00:46

 * @ version 1.0.0

 **/

export default {

	namespaced: true,

	// 储存数据

	state: {

		// 订单统计

		order: {

			pay: 0,

			delive: 0,

			receiving: 0,

			evaluate: 0,

			customer: 0 //售后

		},

		// 动态统计

		dynamic: {

			collection: 0,

			concern: 0,

			footprint: 0,

			coupon: 0, // 卡券

			accountbank: 0 // 银行卡

		},

		// 消息统计

		notice: {

			order: 0,

			notice: 0,

			chat: 0

		},

		// 物流状态

		logistics: []

	},

	// 修改数据

	mutations: {

		// 修改所有

		edit(state, payload){

			for (let i in payload) {

				for (let j in state) {

					if (i === j) {

						state[j] = payload[i];

					}

				}

			}

			uni.setStorageSync("wanlshop:statis", state);

		},

		// 设置统计订单数据 - 修改键

		order(state, payload) {

			for (let i in payload) {

				for (let j in state.order) {

					if (i === j) {

						state.order[j] = payload[i];

					}

				}

			}

			uni.setStorageSync("wanlshop:statis", state);

		},

		// 设置统计动态数据 - 修改键

		dynamic(state, payload) {

			for (let i in payload) {

				for (let j in state.dynamic) {

					if (i === j) {

						state.dynamic[j] = payload[i];

					}

				}

			}

			uni.setStorageSync("wanlshop:statis", state);

		},

		// 设置通知统计数据 - 修改键

		noticec(state, payload) {

			for (let i in payload) {

				for (let j in state.notice) {

					if (i === j) {

						state.notice[j] = payload[i];

					}

				}

			}

			uni.setStorageSync("wanlshop:statis", state);

		}

	},

	actions: {

		async get({commit, rootState}) {

			commit('edit', uni.getStorageSync('wanlshop:statis'));

		}

	}

};