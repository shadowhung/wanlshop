<template>
	<view class="wanlpage-activity" :style="[pageData.style]">
		<view class="cu-list grid col-2-2_1">
			<view class="cu-item" v-for="(item,index) in data" :key="index">
				<view class="name">
					<text class="text-lg" :class="item.color">{{item.activity}}</text>
					<view v-if="item.tags" class="cu-tag round sm wanl-bg-orange">
						<text class="wlIcon-dot"></text> {{item.tags}}
					</view>
				</view>
				<view v-if="item.describe" class="text-sm wanl-gray">{{item.describe}}</view>
				<view class="goods margin-top-bj">
					<image class="radius" :src="$wanlshop.appstc('/common/img_default3x.png')" mode=""></image>
					<image class="radius" :src="$wanlshop.appstc('/common/img_default3x.png')" mode="" v-if="item.list == 2"></image>
				</view>
			</view>
		</view>
	</view>
</template>
<script>
	export default {
		name: "WanlPageActivity",
		props: {
			pageData: {
				type: Object,
				default () {
					return {
						name: '活动橱窗',
						type: 'activity',
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
					url: '/wanlshop/page/activity',
					data: {
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
	.wanlpage-activity{overflow: hidden;}
	.wanlpage-activity .cu-list { text-align: left; }
	.wanlpage-activity .cu-list>.cu-item { padding: 25rpx; overflow: hidden; }
	.wanlpage-activity .cu-list>.cu-item .cu-tag { left: 0; top: -4rpx; margin-left: 10rpx; }
	.wanlpage-activity .cu-list>.cu-item .cu-tag text {font-size: 20rpx;color: rgba(255, 255, 255, 0.5);}
	.wanlpage-activity .cu-list>.cu-item .cu-tag.sm { padding-left: 0; }
	.wanlpage-activity .cu-list>.cu-item .name .text-lg { font-size: 31rpx; }
	.wanlpage-activity .cu-list>.cu-item .goods { display: flex; justify-content: space-between; align-items: center; }
	.wanlpage-activity .cu-list>.cu-item .goods>image { height: 130rpx; }
	.wanlpage-activity .cu-list>.cu-item .goods>image + image { margin-left: 25rpx; }
</style>
