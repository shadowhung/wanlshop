<template>
	<!-- ok -->
	<view class="wanlpage-advert-image" @tap="$wanlshop.on(pageData.data[0].link)">
		<image :src="$wanlshop.oss(pageData.data[0].image, 414, 0, 1, 'transparent', 'png')" :style="[pageData.style]"></image>
	</view>
</template>
<script>
	export default {
		name: "WanlPageImage",
		props: {
			pageData: {
				type: Object,
				default: function() {
					return {
						name: '图片组件',
						type: 'image',
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
