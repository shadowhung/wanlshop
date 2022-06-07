<!-- 
	版本声明：
	* 由于 WanlLive、WanlChat、以下代码开发难度较大，已将相关代码独立申请著作权，受法律保护！！！
	* 无论你购买任何版本，均不允许复制到第三方直接、间接使用，且也不能以学习为目的参考借鉴
	* 你仅有在 WanlShop 中使用、二次开发权利，否则我们会追究法律责任 
	* 福建度虎科技有限公司 @www.i36k.com
-->
<template>
	<view>
		<view class="wanl-image">
			<image
				class="wanl-image-image"
				:lazy-load="true" 
				:fade-show="false" 
				:style="{ height: screenHeight + 'px', width: screenWidth + 'px'}"
				:src="$wanlshop.oss(live.image, 0, 50, 1, 'transparent', 'png')"
				mode="aspectFill" 
			></image>
		</view>
		<view class="wanl-image-bg"> </view>
		<view class="wanl-end-main" :style="{top: statusBarHeight + 80 + 'px', bottom: statusFootHeight + 50 + 'px'}">
			<view class="wanl-end-main-info text-white">
				<view class="text-center">
					<view class="text-xxl margin-bottom-xs">
						直播已结束
					</view>
					<view class="text-min wanl-gray-light">
						稍后将生成直播回看
					</view>
				</view>
				<view class="text-center">
					<image class="wanl-end-main-info-image" :src="$wanlshop.oss(live.shop.avatar, 100, 100)"></image>
					<view class="text-xl">
						{{live.shop.shopname}}
					</view>
				</view>
				<view class="flex justify-around statistics">
					<view class="text-center">
						<view class="text-xl">
							{{live.like}}
						</view>
						<text class="text-min">点赞</text>
					</view>
					<view class="text-center solid-left solid-right">
						<view class="text-xl">
							{{live.views}}
						</view>
						<text class="text-min">观看人次</text>
					</view>
					<view class="text-center">
						<view class="text-xl">
							{{live.goodsnum}}
						</view>
						<text class="text-min">直播商品</text>
					</view>
				</view>
			</view>
			
			<view class="wanl-end-main-btn" @tap="$wanlshop.on('/pages/find/find')">
				<button class="cu-btn block round line-white lg">返回发现</button>
			</view>
		</view>
		
	</view>
</template>

<script>
var system = uni.getSystemInfoSync();
export default {
	data() {
		return {
			statusBarHeight: system.safeAreaInsets.top,
			statusFootHeight: system.safeAreaInsets.bottom,
			screenHeight: system.screenHeight,
			screenWidth: system.screenWidth,
			live: {}
		};
	},
	onLoad(option) {
		this.loadData(option.id);
	},
	methods: {
		async loadData(id) {
			this.$api.get({
				url: '/wanlshop/live/endLive',
				data: {
					id: id
				},
				success: res => {
					this.live = res;
				}
			});
		}
	}
};
</script>

<style>
	.wanl-image {
		position: absolute;
		left: 0;
		right: 0;
		top: 0;
		bottom: 0;
		background-color: #000000;
		z-index: 1;
	}
	.wanl-image-bg{
		position: absolute;
		left: 0;
		right: 0;
		top: 0;
		bottom: 0;
		background-color: rgba(0,0,0,.3);
		z-index: 2;
	}
	.wanl-image-image{
		filter: blur(20px);
	}
	.wanl-end-main{
		position: absolute;
		left: 0;
		right: 0;
		top: 0;
		bottom: 0;
		z-index: 3;
	}
	.wanl-end-main-info{
		position: absolute;
		left: 25rpx;
		right: 25rpx;
		top: 0;
	}
	.wanl-end-main-btn{
		position: absolute;
		left: 10%;
		right: 10%;
		bottom: 0;
	}
	.wanl-end-main-info-image{
		width: 200rpx;
		height: 200rpx;
		border-radius: 999px;
		margin-top: 80rpx;
		margin-bottom: 20rpx;
	}
	.statistics{
		color: rgba(255,255,255,.8);
		margin-top: 40rpx;
	}
	.statistics>view{
		flex: 1;
	}
</style>