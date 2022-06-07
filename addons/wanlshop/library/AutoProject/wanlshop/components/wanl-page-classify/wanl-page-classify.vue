<template>
	<view class="wanlpage-classify" :style="[pageData.style]">
		<view class="cu-list grid" :class="pageData.params.colStyle">
			<view class="cu-item" v-for="(item,index) in data" :key="index">
				<view class="name">
					<text class="text-lg" :class="item.color">{{item.name}}</text>
					<view v-if="item.tags" class="cu-tag round sm wanl-bg-orange">
						<text class="wlIcon-dot"></text> {{item.tags}}
					</view>
				</view>
				<view v-if="item.describe" class="text-sm wanl-gray">{{item.describe}}</view>
				<view class="goods margin-top-bj">
					<block v-for="(goods, keys) in item.list" :key="keys">
						<image class="radius" :src="$wanlshop.oss(goods.image, 70, 65)" @tap="onGoods(goods.id)"></image>
					</block>
				</view>
			</view>
		</view>
	</view>
</template>
<script>
	export default {
		name: "WanlPageClassify",
		props: {
			pageData: {
				type: Object,
				default () {
					return {
						name: '分类橱窗',
						type: 'classify',
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
			this.loadData();
		},
		methods: {
			async loadData() {
				this.$api.get({
					url: '/wanlshop/page/category',
					data: {
						col: this.pageData.params.colStyle,
						data: JSON.stringify(this.pageData.data)
					},
					success: res => {
						this.data = res;
					}
				});
			}
		}
	}
</script>
<style>
	.wanlpage-classify{overflow: hidden;}
	.wanlpage-classify .cu-list { text-align: left;}
	.wanlpage-classify .cu-list>.cu-item { padding: 25rpx; overflow: hidden; }
	.wanlpage-classify .cu-list>.cu-item .cu-tag { left: 0; top: -4rpx; margin-left: 10rpx; }
	.wanlpage-classify .cu-list>.cu-item .cu-tag text {font-size: 20rpx;color: rgba(255, 255, 255, 0.5);}
	.wanlpage-classify .cu-list>.cu-item .cu-tag.sm { padding-left: 0; }
	.wanlpage-classify .cu-list>.cu-item .name .text-lg { font-size: 31rpx; }
	.wanlpage-classify .cu-list>.cu-item .goods { display: flex; justify-content: space-between; align-items: center; }
	.wanlpage-classify .cu-list>.cu-item .goods>image { height: 130rpx; }
	.wanlpage-classify .cu-list>.cu-item .goods>image + image { margin-left: 25rpx; }
</style>
