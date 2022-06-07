<template>
	<view>
		<view class="wanlpage-advert-image" v-for="(item, index) in advertData" :key="item.id" v-if="item.id == 2" @tap="onAdvert(item)">
			<image :src="$wanlshop.oss(item.media, 414, 0, 1, 'transparent', 'png')" :style="[pageData.style]"></image>
		</view>
	</view>
</template>
<script>
	export default {
		name: "WanlPageAdvertImage",
		props: {
			pageData: {
				type: Object,
				default: function() {
					return {
						name: '图片组件',
						type: 'image',
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
