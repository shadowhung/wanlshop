<template>
	<!-- ok -->
	<view class="wanlpage-category-title" :style="[pageData.style]" @tap="$wanlshop.on(pageData.data[0].categoryLink)">
		<view class="text-lg">
			<text class="margin-right-xs" :class="pageData.data[0].icon"></text>{{pageData.data[0].categoryName}} ···
		</view>
		<view class="text-sm wanl-gray">
			更多<text class="wlIcon-fanhui2 margin-left-xs"></text>
		</view>
	</view>
</template>
<script>
	export default {
		name: "WanlPageCategoryTitle",
		props: {
			pageData: {
				type: Object,
				default: function() {
					return {
						name: '类目标题',
						type: 'categoryTitle',
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
	.wanlpage-category-title {
		display: flex;
		justify-content: space-between;
		align-items: center;
	}
</style>
