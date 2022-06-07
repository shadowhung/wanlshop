<template>
	<!-- ok -->
	<view class="wanlpage-likes wanl-product col-2-20" :style="[pageData.style]">
		<wanl-product :dataList="data.data"/>
	</view>
</template>
<script>
	export default {
		name: "WanlPageLikes",
		props: {
			pageData: {
				type: Object,
				default: function() {
					return {
						name: '猜你喜欢',
						type: 'likes',
						params: [],
						style: [],
						data: []
					}
				}
			}
		},
		data() {
			return {
				data: []
			};
		},
		created() {
			this.loadData()
		},
		methods: {
			async loadData() {
				this.$api.get({
					url: '/wanlshop/product/likes?page=index',
					success: res => {
						this.data = res;
					}
				});
			}
		}
	}
</script>
<style>
</style>
