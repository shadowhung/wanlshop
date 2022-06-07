<template>
	<!-- ok -->
	<view class="wanlpage-goods" :style="[pageData.style]">
		<wanl-product :dataList="data" :dataStyle="'col-'+ pageData.params.colthree +'-'+pageData.params.colmargin" />
	</view>
</template>
<script>
	export default {
		name: "WanlPageGoods",
		props: {
			pageData: {
				type: Object,
				default: function() {
					return {
						name: '商品组件',
						type: 'goods',
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
				let ids = [],
					data = this.pageData.data;
				for(let i = 0; i < data.length; i++) {
					ids.push(data[i].goodsLink);
				};
				this.$api.get({
					url: '/wanlshop/page/goods',
					data: {ids: ids.join(',')},
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
