<template>
	<view class="empty-content">
		<view class="wanl-gray text-center">
			<image class="animation-scale-down" :src="src ? $wanlshop.appstc('/default/' + src + '.png') : $wanlshop.appstc('/default/default3x.png')"></image>
			<view class="text-30">{{ text }}</view>
		</view>
	</view>
</template>

<script>
/**
 * WanlEmpty 缺省页
 * @description 缺省页组件 福建度虎科技有限公司 https://www.wanlshop.com（除万联官方内嵌系统，未经授权严禁使用）
 * @著作权：WanlShop 登记号：2020SR0255711 版本：V1.0.0
 *
 * @property {String} src 图片地址名
 * @property {String} text 提示文字
 * @example <wanl-empty src="" text=""/>
 */
export default {
	name: 'WanlEmpty',
	props: {
		src: {
			type: String,
			default: ''
		},
		text: {
			type: String,
			default: '没有找到任何内容'
		}
	}
};
</script>

<style>
	.empty-content {
		display: flex;
		align-items: center;
		justify-content: center;
		width: 100%;
		padding: 300rpx 130rpx;
	}
	.empty-content image{
		width: 320rpx;
		height: 320rpx;
	}
</style>
