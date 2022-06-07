<template>
	<view class="wanl-empty">
		<view class="wanl-empty-tag">
			<text class="wanl-empty-text">{{text}}</text>
		</view>
	</view>
</template>

<script>
	export default {
		name: "wanlLiveEmpty",
		props: {
			text: {
				type: String,
				default: ''
			}
		}
	}
</script>

<style>
	.wanl-empty{
		position: absolute;
		left: 0;
		right: 0;
		top: 0;
		bottom: 0;
		align-items: center;
		justify-content: center;
	}
	.wanl-empty-tag{
		background-color: rgba(255,100,0,.3);
		height: 70rpx;
		padding-left: 20rpx;
		padding-right: 20rpx;
		align-items: center;
		justify-content: center;
		border-radius: 100px;
	}
	.wanl-empty-text{
		font-size: 32rpx;
		color: #ffffff;
	}
</style>
