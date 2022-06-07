<template>
	<view>
		<view class="wanl-share">
			<view class="head">
				<view class="content"><view class="text-lg">分享到</view></view>
			</view>
			<scroll-view class="scroll-x solid-bottom" scroll-x="true" show-scrollbar="false" :scroll-left="scrollAnimation" scroll-with-animation>
				<!-- #ifdef MP -->
				<view class="scroll-item">
					<button open-type="share">
						<view class="icons bg-green"><text class="wlIcon-31fenxiang"></text></view>
						<view class="project text-sm"><text>分享</text></view>
					</button>
				</view>
				<!-- #endif -->
				<view class="scroll-item" v-for="(value, index) in providerList" :key="index" v-if="value" @tap="share(value)">
					<view class="icons" :class="value.background"><text :class="value.icon"></text></view>
					<view class="project text-sm">
						<text>{{ value.name }}</text>
					</view>
				</view>
			</scroll-view>
			<view class="footer" @tap="close"><text>取消</text></view>
		</view>
	</view>
</template>

<script>
	/**
	 * WanlShare 分享 
	 * @description 分享组件 福建度虎科技有限公司 https://www.wanlshop.com（除万联官方内嵌系统，未经授权严禁使用）
	 * @著作权：WanlShop 登记号：2020SR0255711 版本：V1.0.0
	 * @property {Number} scrollAnimation 滚动位置
	 * @property {Number} shareType 分享类型 0.图文 1.纯文字 2.纯图片 5.小程序
	 * @property {String} shareTitle 分享标题
	 * @property {String} shareText 分享详情
	 * @property {String} image 分享图片 如果是图文分享，且是ios平台，20kb
	 * @property {String} href 分享链接
	 * @event {Function} change 关闭弹窗
	 * @example <wanl-share :scrollAnimation="scrollAnimation" shareTitle="" shareText="" image="" href="" @change="hideModal"/>
	 */
	export default {
		name: 'WanlShare',
		props: {
			scrollAnimation: {
				type: Number,
				default: 300
			},
			shareType: {
				type: Number,
				default: 0
			},
			shareTitle: {
				type: String,
				default: ''
			},
			shareText: {
				type: String,
				default: ''
			},
			image: {
				type: String,
				default: ''
			},
			href: {
				type: String,
				default: ''
			},
			isReport: {
				type: Boolean,
				default: false
			}
		},
		data() {
			return {
				providerList: []
			};
		},
		created() {
			uni.getProvider({
				service: 'share',
				success: e => {
					let data = [];
					// #ifdef APP-PLUS
					for (let i = 0; i < e.provider.length; i++) {
						switch (e.provider[i]) {
							case 'weixin':
								data.push(
									{
										name: '微信好友',
										id: 'weixin',
										icon: 'wlIcon-WeChat',
										background: 'bg-green',
										sort: 0
									},
									{
										name: '微信朋友圈',
										id: 'weixin',
										icon: 'wlIcon-pengyouquan',
										background: 'bg-green',
										type: 'WXSenceTimeline',
										sort: 1
									}
								);
								break;
							case 'sinaweibo':
								data.push({
									name: '新浪微博',
									id: 'sinaweibo',
									icon: 'wlIcon-WeiBo',
									background: 'red',
									sort: 2
								});
								break;
							case 'qq':
								data.push({
									name: 'QQ',
									id: 'qq',
									icon: 'wlIcon-WeChat',
									background: 'blue',
									sort: 3
								});
								break;
							default:
								break;
						}
					}
					// #endif
					data.push(
						{
							name: '生成海报',
							id: 'poster',
							icon: 'wlIcon-classify',
							background: 'gray',
							sort: 4
						},
						{
							name: '链接',
							id: 'link',
							icon: 'wlIcon-lianjie',
							background: 'gray',
							sort: 5
						}
					);
					if(this.isReport){
						data.push(
							{
								name: '举报',
								id: 'report',
								icon: 'wlIcon-jubao',
								background: 'gray',
								sort: 6
							}
						);
					}
					this.providerList = data.sort((x, y) => {
						return x.sort - y.sort;
					});
				},
				fail: e => {
					uni.showModal({
						content: '获取分享通道失败',
						showCancel: false
					});
				}
			});
		},
		methods: {
			async share(e) {
				if (e.id == 'poster') {
					this.$wanlshop.to('/pages/user/qrcode/qrcode?url='+encodeURIComponent(this.href));
				} else if (e.id == 'link') {
					// #ifdef H5
					this.$wanlshop.msg('暂不支持，请手动复制');
					// #endif
					// #ifndef H5
					uni.setClipboardData({
						data: this.href,
						success: () => {
							this.$wanlshop.msg('复制成功');
						}
					});
					// #endif
				} else if (e.id == 'report') {
					this.complaint();
				} else {
					if (!this.shareTitle && (this.shareType === 1 || this.shareType === 0)) {
						uni.showModal({
							content: '分享内容不能为空',
							showCancel: false
						});
						return;
					}

					if (!this.image && (this.shareType === 2 || this.shareType === 0)) {
						uni.showModal({
							content: '分享图片不能为空',
							showCancel: false
						});
						return;
					}
					
					// 开始分享
					let shareOPtions = {
						provider: e.id,
						scene: e.type && e.type === 'WXSenceTimeline' ? 'WXSenceTimeline' : 'WXSceneSession', //WXSceneSession”分享到聊天界面，“WXSenceTimeline”分享到朋友圈，“WXSceneFavorite”分享到微信收藏     
						type: this.shareType,
						success: (e) => {
							uni.showModal({
								content: '已分享',
								showCancel:false
							})
						},
						fail: (e) => {
							uni.showModal({
								content: e.errMsg,
								showCancel:false
							})
						}
					}
					
					switch (this.shareType){
						case 0:
							shareOPtions.summary = this.shareText;
							shareOPtions.imageUrl = this.image;
							shareOPtions.title = this.shareTitle;
							shareOPtions.href = this.href;
							break;
						case 1:
							shareOPtions.summary = this.shareText;
							break;
						case 2:
							shareOPtions.imageUrl = this.image;
							break;
						case 5:
							var pages = getCurrentPages();  
							var page = (pages[pages.length - 1]).route;  
							shareOPtions.imageUrl = this.image ? this.image : $wanlshop.appstc('/qrcode/logo.png');
							shareOPtions.title = this.shareTitle;
							shareOPtions.miniProgram = {
								id: this.$store.state.common.appConfig.mp_weixin_id,
								path: page, //微信小程序ID
								webUrl: this.href,
								type:0
							};
							break;
						default:
							break;
					}
					// if(shareOPtions.type === 0 && plus.os.name === 'iOS'){//如果是图文分享，且是ios平台，则压缩图片 
					// 	shareOPtions.imageUrl = await this.compress();
					// }
					if(shareOPtions.type === 1 && shareOPtions.provider === 'qq'){//如果是分享文字到qq，则必须加上href和title
						shareOPtions.href = this.href;
						shareOPtions.title = this.shareTitle;
					}
					uni.share(shareOPtions);
				}
				this.close();
			},
			// 关闭模态框
			close() {
				this.$emit('change');
			},
			// 举报商品
			complaint(){
				this.$emit('change','complaint');
			}
		}
	};
</script>
<style>
	/* 分享 */
	.wanl-share {
		min-height: 50rpx;
		padding-bottom: 0px;
		padding-bottom: env(safe-area-inset-bottom);
	}
	.wanl-share .head {
		padding: 25rpx 25rpx 10rpx 25rpx;
	}
	.wanl-share .head .content {
		justify-content: left;
		margin-left: 16rpx;
	}
	.wanl-share .scroll-x {
		white-space: nowrap;
		width: 100%;
		padding: 32rpx 0;
		text-align: left;
		height: 250rpx;
		
	}
	.wanl-share .scroll-x .scroll-item {
		display: inline-block;
		font-size: 36rpx;
		margin-left: 36rpx;
		text-align: center;
	}

	.wanl-share .scroll-x .scroll-item button {
		line-height: 1;
		background-color: rgba(0, 0, 0, 0);
		border: 0;
		padding: 0;
	}

	.wanl-share .scroll-x .scroll-item button:after {
		border: 0;
	}

	.wanl-share .scroll-x .scroll-item:last-child {
		margin-right: 36rpx;
	}

	.wanl-share .scroll-x .scroll-item .icons {
		width: 100rpx;
		height: 100rpx;
		line-height: 100rpx;
		border-radius: 9999rpx;
		margin: 0 auto;
		font-size: 40rpx;
		display: block;
	}
	.wanl-share .scroll-x .scroll-item .icons.gray {
		color: #606060;
		background-color: #f5f5f5;
	}
	.wanl-share .scroll-x .scroll-item .icons.red {
		color: #ffffff;
		background-color: #e6162c;
	}
	.wanl-share .scroll-x .scroll-item .icons.blue {
		color: #ffffff;
		background-color: #3e92e8;
	}

	.wanl-share .scroll-x .scroll-item .project {
		margin-top: 25rpx;
	}
	.wanl-share .footer {
		height: 90rpx;
		line-height: 90rpx;
		font-size: 30rpx;
	}
</style>
