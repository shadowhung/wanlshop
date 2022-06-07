<template>
	<view class="wanl-coupon">
		<view class="edgeInsetTop"></view>
		<view class="details">
			
		</view>
	</view>
</template>

<script>
	export default {
		data() {
			return {
				couponData: {}
			}
		},
		onLoad(option) {
			this.couponData = JSON.parse(option.data);
		},
		methods: {
			
		}
	}
</script>

<style>

</style>
