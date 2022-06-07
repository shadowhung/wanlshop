<template>
	<!-- ok -->
	<view class="wanlpage-banner" :style="[pageData.style]">
		<swiper class="screen-swiper square-dot" :indicator-dots="true" :circular="true" :autoplay="true" :interval="pageData.params.interval" duration="500">
			<swiper-item v-for="(image, keys) in pageData.data" :key="keys" @tap="$wanlshop.on(image.link)">
				<image :src="$wanlshop.oss(image.image, 414, 0, 1, 'transparent', 'png')" mode="aspectFill"></image>
			</swiper-item>
		</swiper>
	</view>
</template>
<script>
	export default {
		name: "WanlPageBanner",
		props: {
			pageData: {
				type: Object,
				default: function() {
					return {
						name: '',
						type: '',
						params: [],
						style: [],
						data: []
					}
				}
			}
		}
	}
</script>
<style>
</style>
