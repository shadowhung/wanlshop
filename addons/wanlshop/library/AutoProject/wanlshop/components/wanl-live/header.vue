<!-- 
	版本声明：
	* 由于 WanlLive、WanlChat、以下代码开发难度较大，已将相关代码独立申请著作权，受法律保护！！！
	* 无论你购买任何版本，均不允许复制到第三方直接、间接使用，且也不能以学习为目的参考和借鉴！！
	* 你仅有在 WanlShop 中使用、二次开发权利，否则我们会追究法律责任 
	* 福建度虎科技有限公司 @www.i36k.com
-->
<template>
	<view class="wanl-header" :style="{top:statusBarHeight+'px'}">
		<view class="wanl-header-left">
			<view class="wanl-header-img" @tap="toShop(userinfo.id)">
				<image class="wanl-header-image" :src="stcOss(userinfo.avatar)" mode=""></image>
			</view>
			<view class="wanl-header-shop" @tap="toShop(userinfo.id)">
				<text class="wanl-header-shop-text">{{!userinfo.shopname?'加载中..':userinfo.shopname}}</text>
				<view class="wanl-header-shop-info">
					<text class="wanl-header-shop-info-text">{{numFormat(online)}} 人观看</text>
				</view>
			</view>
			<view class="wanl-header-shop-button" v-if="!isFollow" @tap="shopLike">
				<text class="wanl-header-shop-button-text">关注</text>
			</view>
		</view>
		
		<view class="wanl-header-right">
			<view class="wanl-header-marker">
				<view class="wanl-header-marker-name">
					<text class="wanl-header-marker-name-text" v-if="state == 0">正在准备</text>
					<text class="wanl-header-marker-name-text" v-if="state == 1">商城直播</text>
					<text class="wanl-header-marker-name-text" v-if="state == 2">直播回放</text>
				</view>
				<view class="wanl-header-marker-id">
					<text class="wanl-header-marker-id-text">ID:{{!userinfo.id?0:userinfo.id}}</text>
				</view>
			</view>
			<view class="wanl-header-close" @tap="liveBack">
				<image class="wanl-header-close-btn" src="/static/images/live/close.png"></image>
			</view>
		</view>
	</view>
</template>
<script>
	export default {
		name: "wanlLiveHeader",
		props: {
			statusBarHeight: {
				default: 0
			},
			online:{
				type: Number,
				default: 0
			},
			state:{
				default: 0
			},
			isFollow: {
				type: Boolean,
				default: false
			},
			userinfo: {
				type: Object,
				default: function() {
					return {};
				}
			}
		},
		methods: {
			shopLike(){
				this.$emit('change');
			},
			liveBack(){
				uni.navigateBack({
					delta: 1
				});
			},
			toShop(id){
				uni.navigateTo({
					url: `/pages/shop/shop?id=${id}`
				})
			},
			stcOss(url){
				let oss = this.$store.state.common.appUrl.oss;
				let image = '';
				if (url) {
					if((/^(http|https):\/\/.+/.test(url))){
						image = url;
					}else{
						image = oss + url;
					}
				}else{
					image = oss + '/assets/addons/wanlshop/img/common/img_default3x.png';
				}
				return image;
			},
			numFormat(num){
				return num > 9999 ? ((num-num%1000)/10000 + '万') : num
			}
		}
	}
</script>

<style scoped>
	.wanl-header {
		position: absolute;
		top: 0;
		left: 0;
		right: 0;
		padding-left: 25rpx;
		padding-right: 25rpx;
		padding-top: 4rpx;
		/* #ifndef APP-PLUS */
		padding-top: 16rpx;
		/* #endif */
		flex-direction: row;
		align-items: center;
		justify-content: space-between;
		z-index: 999;
	}
	.wanl-header-left{
		background-color: rgba(0,0,0,.2);
		border-radius: 999px;
		overflow: hidden;
		flex-direction: row;
		align-items: center;
		justify-content: space-between;
		padding-left: 10rpx;
		padding-top: 10rpx;
		padding-bottom: 10rpx;
		padding-right: 10rpx;
		line-height: 1.18;
	}
		.wanl-header-img{
			width: 60rpx;
			height: 60rpx;
			border-radius: 999px;
			overflow: hidden;
		}
			.wanl-header-image{
				width: 60rpx;
				height: 60rpx;
			}
		
		.wanl-header-shop{
			margin-left: 15rpx;
			margin-right: 25rpx;
		}
			.wanl-header-shop-text{
				color: #ffffff;
				font-size: 26rpx;
			}
				.wanl-header-shop-info{
					
				}
				.wanl-header-shop-info-text{
					font-size: 20rpx;
					color: #ffffff;
				}
		.wanl-header-shop-button{
			background-color: #f02b57;
			align-items: center;
			justify-content: center;
			height: 50rpx;
			width: 100rpx;
			border-radius: 100px;
			margin-right: 8rpx;
		}
		.wanl-header-shop-button-text{
			color: #ffffff;
			font-size: 25rpx;
		}
	
	.wanl-header-right {
		flex-direction: row;
		/* #ifdef MP */
		position: absolute;
		top: 100rpx;
		right: 25rpx;
		/* #endif */
	}
		.wanl-header-marker{
			background-color: rgba(0,0,0,.2);
			height: 70rpx;
			justify-content: center;
			align-items: center;
			margin-right: 50rpx;
			border-top-left-radius: 20rpx;
			border-top-right-radius: 20rpx;
			border-bottom-right-radius: 20rpx;
			border-bottom-left-radius: 20rpx;
			overflow: hidden;
		}
			.wanl-header-marker-name{
				background-color: #ffffff;
				height: 35rpx;
				justify-content: center;
				padding-left: 10rpx;
				padding-right: 10rpx;
			}
				.wanl-header-marker-name-text{
					font-size: 20rpx;
				}
			.wanl-header-marker-id{
				height: 35rpx;
				justify-content: center;
			}
				.wanl-header-marker-id-text{
					font-size: 20rpx;
					color: #ffffff;
				}
		.wanl-header-close{
			height: 32rpx;
			/* #ifdef MP */
			justify-content: center;
			/* #endif */
		}
		.wanl-header-close-btn{
			width: 32rpx;
			height: 32rpx;
		}
</style>