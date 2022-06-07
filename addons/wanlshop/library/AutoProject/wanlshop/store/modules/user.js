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

	state: {

		id: 0, //用户ID

		isLogin: false, // 登录状态

		username: '', // 用户名

		nickname: '', // 昵称

		mobile: '', // 手机号

		avatar: '', // 默认头像

		level: 0, // 等级

		gender: 0, // 性别

		birthday: '', // 生日

		bio: '', // 签名

		money: '0.00', // 余额

		score: 0, // 积分

		successions: '', // 连续登录天数

		maxsuccessions: '', // 最大连续登录天数

		prevtime: '', // 上次登录时间

		logintime: '', // 登录时间

		loginip: '', // 加入IP

		jointim: '', // 加入时间

		token: '', // 令牌

		pushs: true, // 推送

		shock: true, // 震动

		voice: true // 提示音

	},

	mutations: {

		setUserInfo(state, payload) {

			for (let i in payload) {

				for (let j in state) {

					if (i === j) {

						state[j] = payload[i];

					}

				}

			}

			uni.setStorageSync("wanlshop:user", state);

		}

	},

	actions: {

		async login({state, commit, dispatch, rootState}, data) {

			commit('setUserInfo', data.userinfo);

			state.isLogin = true; // 登录状态强制 开启

			// 根据notice.vue 而知，fastadmin没有此三项默认字段，手动添加，想同步修改该这两处即可

			state.pushs = true; // 推送

			state.voice = true; // 提示音

			state.shock = true; // 震动

			uni.setStorageSync("wanlshop:user", state);

			// 统计信息

			dispatch('statistics', data.statistics)

		},

		async logout({state, rootState}) {

			for (let j in state) {

				state[j] = ''

			}

			state.isLogin = false;

			let statistics = rootState.statistics;

			for (let j in statistics) {

				for (let i in statistics[j]) {

					statistics[j][i] = 0

				}

			}

			// 从本地缓存中异步移除指定key

			uni.removeStorageSync('wanlshop:user');

			uni.removeStorageSync('wanlshop:statis');

			// 关闭即时通讯

			uni.closeSocket();

		},

		async statistics({state, dispatch, rootState}, payload){

			let states = rootState.statistics;

			for (let i in payload) {

				for (let j in states) {

					if (i === j) {

						states[j] = payload[i];

					}

				}

			}

			uni.setStorageSync("wanlshop:statis", states);

		}

		

	}

};