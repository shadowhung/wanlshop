<template>
	<!-- ok -->
	<view class="wanlpage-search" :style="[pageData.style]">
		<view @tap="onSearch()" :style="{'border-radius':pageData.params.searchRadius,'background':pageData.params.searchBackground,'padding':pageData.params.searchPadding}" >
			<text class="wlIcon-sousuo margin-right-xs"></text><text>{{pageData.data[0].content}}</text>
		</view>
	</view>
</template>
<script>
	export default {
		name: "WanlPageSearch",
		props: {
			pageData: {
				type: Object,
				default: function() {
					return {
						name: '搜索组件',
						type: 'search',
						params: [],
						style: [],
						data: []
					}
				}
			}
		},
		methods: {
			onSearch() {
				this.$wanlshop.to('/pages/product/search');
			}
		}
	}
</script>
<style>
	.wanlpage-search{
		overflow: hidden;
	}
</style>
