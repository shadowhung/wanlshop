/**

 * WanlShop状态管理器 - 系统初始化

 * 

 * @ author 深圳前海万联科技有限公司 <wanlshop@i36k.com> 

 * < 程序仅用作FastAdmin付费插件API测试使用，未经版权所有权人书面许可，不能用于商业用途！>

 * @ link http://www.wanlshop.com

 * @ 2020年9月29日19:00:46

 * @ version 1.0.0

 **/

import api from '../../common/request/request';

import config from '../../common/config/config';

 

export default {

	namespaced: true,

	// 储存数据

	state: {

		appStyle: {}, // APP整体样式

		appConfig: {}, // APP整体配置

		// APP链接

		appUrl: {

			api: config.appurl,

			oss: config.cdnurl

		},

		// APP整体数据

		appInfo: {

			adVersion: '0', // 广告数据版本号	拉取大版本号数据

			serviceVersion: '0' // Api数据版本号  拉取大版本号数据  用于尚未更新用户正常使用

		},

		// 广告数据

		adData: {

			openAdverts: {},

			pageAdverts: [],

			categoryAdverts: [],

			firstAdverts: [],

			otherAdverts: []

		},

		// 模块数据

		modulesData: {

			homeModules: {}, //首页模块

			categoryModules: [], //类目模块

			searchModules: [] //搜索模块

		},

		config: {

			screenshot: false,

			position: true,

			map: true

		},

		version: config.versionName,

		versionCode: config.versionCode

	},

	mutations: {

		setConfig(state, payload) {

			for (let i in payload) {

				for (let j in state.config) {

					if (i === j) {

						state.config[j] = payload[i];

					}

				}

			}

		}

	},

	// 操作数据

	actions: {

		// WanlShop 初始化，检测

		async init({state, dispatch, rootState}) {

			let userStorage = uni.getStorageSync('wanlshop:user');

			uni.request({

			    url: config.appurl + '/wanlshop/token/check',

			    header: {

			        'token': userStorage ? userStorage.token : 'wanlshop'

			    },

			    success: (res) => {

					if (res.statusCode === 200) {

						// 已经登录，刷新一个token，将原有账户赋值给状态管理器

						if (userStorage) {

							rootState.user = userStorage;

						}

						rootState.user.isLogin = true;

					}else if(res.statusCode === 401){

						// 清除登录信息

						let user = rootState.user;

						for (let j in user) {

							user[j] = ''

						}

						rootState.user.isLogin = false;

						// 清除统计信息

						let statistics = rootState.statistics;

						for (let j in statistics) {

							for (let i in statistics[j]) {

								statistics[j][i] = 0

							}

						}

						// 从本地缓存中异步移除

						if (userStorage) {

							uni.removeStorageSync('wanlshop:user');

							uni.removeStorageSync('wanlshop:statis');

						}

					}

					dispatch('getAds');

			    	dispatch('getServices');

			    },

			    fail: (e) => {

			    	// #ifdef APP-PLUS

			    	plus.navigator.closeSplashscreen(); //主动关闭启动图

			    	// #endif

			    }

			});

		},

		async getServices({state}){

			api.get({

				url: '/wanlshop/common/init',

				data: {

					version: state.version

				},

				success: res => {

					// px转rpx正则表达

					for (var i = 0; i < res.modulesData.homeModules.item.length; i++) {

						for (var item in res.modulesData.homeModules.item[i].style) {

							res.modulesData.homeModules.item[i].style[item] = res.modulesData.homeModules.item[i].style[item].replace(/\d*\.?\d+px/, function(

								match) {

								return match.replace('px', '') * 2 + 'rpx'

							})

						};

						for (var item in res.modulesData.homeModules.item[i].params) {

							res.modulesData.homeModules.item[i].params[item] = res.modulesData.homeModules.item[i].params[item].replace(/\d*\.?\d+px/, function(

								match) {

								return match.replace('px', '') * 2 + 'rpx'

							})

						};

					};

					// 写入全局配置

					state.appConfig = res.appConfig;

					// 写入全局样式

					state.appStyle = res.appStyle;

					// 写入模块数据

					state.modulesData = res.modulesData;

				}

			});

		},

		async getAds({state}){

			api.get({

				url: '/wanlshop/common/adverts',

				data: {

					version: state.version

				},

				success: res=> {

					// 关闭启动图进入APP

					// #ifdef APP-PLUS

					setTimeout(() => {

						plus.navigator.closeSplashscreen(); //主动关闭启动图

					}, 100)

					// #endif

					state.adData = res.data;

				}

			});

		}

	}

};