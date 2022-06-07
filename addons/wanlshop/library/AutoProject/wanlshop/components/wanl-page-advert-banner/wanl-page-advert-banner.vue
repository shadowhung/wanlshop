<template>
	<!-- ok -->
	<view class="wanlpage-advert-banner" :style="[pageData.style]">
		<swiper class="screen-swiper square-dot" :indicator-dots="true" :circular="true" :autoplay="true" :interval="pageData.params.interval" duration="500">
			<swiper-item v-for="(item, index) in advertData" :key="item.id" v-if="item.module == 'page' && item.type == 'banner'" @tap="onAdvert(item)">
				<image :src="$wanlshop.oss(item.media, 414, 0, 1, 'transparent', 'png')" mode="aspectFill"></image>
			</swiper-item>
		</swiper>
	</view>
</template>

<script>
	export default {
		name: "WanlPageAdvertBanner",
		props: {
			pageData: {
				type: Object,
				default: function() {
					return {
						name: '',
						type: '',
						params: [],
						style: []
					}
				}
			},
			advertData: {
				type: Array,
				default: () => []
			}
		}
	}
</script>
<style>
</style>
