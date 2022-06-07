/**

 * WanlShop状态管理器 - 系统更新 - 后续版本更新

 * 

 * @ author 深圳前海万联科技有限公司 <wanlshop@i36k.com> 

 * < 程序仅用作FastAdmin付费插件API测试使用，未经版权所有权人书面许可，不能用于商业用途！>

 * @ link http://www.wanlshop.com

 * @ 2020年9月29日19:00:46

 * @ version 1.0.0

 **/

import Vue from 'vue';

import api from '../../common/request/request';

import config from '../../common/config/config';



export default {

	namespaced: true,

	// 储存数据

	state: {

		update: false,

		data: {},

		link: {},

		download: {

			path: null,

			start: false,

			install: false,

			progress: 0,

			totalBytesWritten: 0,

			totalBytesExpectedToWrite: 0,

		},

		task: null

	},

	// 修改数据

	mutations: {

		edit(state, {data, index}){

			state[index] = data;

		}

	},

	actions: {

		async update({commit, dispatch}) {

			// #ifdef MP

			const mp = uni.getUpdateManager();

			// 请求完新版本信息的回调

			mp.onCheckForUpdate((res) => {

				console.log(res.hasUpdate);

			});

			mp.onUpdateReady((res) => {

				// 新的版本已经下载好，调用 applyUpdate 应用新版本并重启

				uni.showModal({

					title: '更新提示',

					content: '新版本已经准备好，是否重启应用？',

					success(show) {

						if (show.confirm) {

							mp.applyUpdate();

						}

					}

				});

			});

			mp.onUpdateFailed((res) => {

				console.log('新的版本下载失败');

			});

			// #endif

			

			// #ifdef APP-PLUS

			let storage = uni.getStorageSync('wanlshop:update');

			if (!storage.ignore) {

				api.get({

					url: '/wanlshop/common/update',

					success: (res) => {

						if (res !== null) {

							// 获取本地缓存

							if (Number(config.versionCode) !== Number(res.versionCode)) {

								let link = false;

								// 写入全局数据

								res.content = res.content.replace(/(\r\n)|(\n)/g, '<br>');

								commit('edit', {data: res, index: 'data'});

								// 下载链接

								if (plus.os.name.toLowerCase() === 'ios') {

									if (res.iosLink && res.iosLink !== '') {

										commit('edit', {data: {url: config.cdnurl + res.iosLink, type: res.iosLink.match(RegExp(/.wgt/)) ? 'wgt' : 'url'}, index: 'link'});

										link = true;

									}

								} else {

									if (res.iosLink && res.iosLink !== '') {

										commit('edit', {data: {url: config.cdnurl + res.iosLink, type: res.iosLink.match(RegExp(/.wgt/)) ? 'wgt' : 'url'}, index: 'link'});

										link = true;

									}

								}

								// 更新方式

								res.enforce === 1 ? (link && dispatch('download')) : (link && commit('edit', {data: true, index: 'update'}));

							}else{

								// 如果有缓存删除

								if (storage.path) {

									uni.removeSavedFile({

										filePath: storage.path,

										success: (res) => {

											uni.removeStorageSync('wanlshop:update');

										}

									});

								}

							}

						}else{

							console.log('暂未发现任何更新版本');

						}

					}

				});

			}

			// #endif

		},

		async download({state, commit, dispatch}) {

			// #ifdef APP-PLUS

			let storage = uni.getStorageSync('wanlshop:update');

			let link = state.link;

			let download = state.download;

			// 判断是否下载过，下载过安装

			if (storage.path) {

				console.log('已经下载过，未安装');

				commit('edit', {data: false, index: 'update'});

				if (link.type == 'wgt') {

					download.path = storage.path;

					if (state.data.enforce === 1) {

						dispatch('install');

					}else{

						uni.showModal({

							title: '更新尚未完成',

							content: '没有完成安装或安装的版本号不是最新！是否要继续安装更新包呢？',

							success: (res) => {

								if (res.confirm) {

									dispatch('install');

								}

							}

						});

					}

				}else if(link.type == 'url'){

					plus.runtime.openURL(link.url);

				}

			}else{

				// 判断下载类型

				if (link.type == 'wgt') {

					download.start = true;

					// 创建下载任务对象

					state.task = uni.downloadFile({

						url: link.url,

						success: (res) => {

							if (res.statusCode === 200) {

								// 保存下载的安装包

								uni.saveFile({

									tempFilePath: res.tempFilePath,

									success: (file) => {

										// 本地缓存

										uni.setStorage({

											key: 'wanlshop:update',

											data: {

												path: file.savedFilePath,

												ignore: false

											}

										});

										// 保存地址

										download.path = file.savedFilePath;

										// 任务完成，关闭下载任务

										state.task.abort();

										state.task = null;

										download.start = false;

										// 进行安装

										dispatch('install');

									}

								});

							}else{

								uni.showToast({

								    title: `有更新，但更新文件异常：${link.url}`,

									icon: 'none',

								    duration: 5000

								});

							}

						}

					});

					// 进度条更新

					state.task.onProgressUpdate((res) => {

						// 下载进度百分比

						download.progress = res.progress;

						// 已经下载的数据长度，单位 Bytes

						download.totalBytesWritten = res.totalBytesWritten;

						// 预期需要下载的数据总长度，单位 Bytes

						download.totalBytesExpectedToWrite = res.totalBytesExpectedToWrite;

					});

				}else if(link.type == 'url'){

					// 弹出更新

					console.log('弹出更新');

					plus.runtime.openURL(link.url);

				}

			}

			// #endif

		},

		async install({state, commit}) {

			console.log('开始安装');

			// #ifdef APP-PLUS

			let download = state.download;

			let force = state.update ? {} : {force: true};

			// 更新状态

			download.install = true;

			// 安装更新

			plus.runtime.install(download.path, force, function() {

				// 更新状态

				commit('edit', {data: false, index: 'update'});

				download.install = false;

				// 更新提示

				uni.showModal({

					title: '升级成功',

					content: '应用将重启以完成更新',

					showCancel: false,

					complete: () => {

						plus.runtime.restart();

					}

				});

			}, function(e) {

				// 更新状态

				download.install = false;

			    uni.showToast({

			        title: `安装失败：${e.message}`,

					icon: 'none',

			        duration: 8000

			    });

			});

			// #endif

		},

		// 忽略升级

		async ignore({state, commit}) {

			// 本地缓存

			uni.setStorage({

				key: 'wanlshop:update',

				data: {

					path: null,

					ignore: true

				}

			});

			commit('edit', {data: false, index: 'update'});

		}

	}

};
