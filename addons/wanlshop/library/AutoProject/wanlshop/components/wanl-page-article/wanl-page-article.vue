<template>
	<view class="wanlpage-article" :style="[pageData.style]">
		<view class="item" v-for="(item, index) in data" :key="item.id" @tap="onDetails(item.id, item.title)">
			<view class="action radius">
				<image :src="$wanlshop.oss(item.image, 50, 50)" mode=""></image>
			</view>
			<view class="content">
				<view class="text-cut-2">
					<view>
						{{item.title}}
					</view>
				</view>
				<view class="wanl-gray time text-sm">
					<text v-if="pageData.params.showTime">{{item.createtime_text}}</text>
					<text v-if="pageData.params.showView">浏览：{{item.views}}</text>
				</view>
			</view>
		</view>	
	</view>
</template>
<script>
	export default {
		name: "WanlPageArticle",
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
					url: '/wanlshop/page/article',
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
	.wanlpage-article .item {
		display: flex;
		padding-bottom: 25rpx;
		margin-bottom: 25rpx;
		position: relative;
	}
	
	.wanlpage-article .item:after{ 
		position: absolute;
		top: 0;
		left: 0;
		box-sizing: border-box;
		width: 200%;
		height: 200%;
		border-bottom: 1px solid #ddd;
		border-radius: inherit;
		content: " ";
		transform: scale(.5);
		transform-origin: 0 0;
		pointer-events: none;
	}
	
	.wanlpage-article .item:last-child{
		padding-bottom: 0;
		margin-bottom: 0;
	} 
	.wanlpage-article .item:last-child:after{
		width: 0;
		height: 0;
	}
	
	.wanlpage-article .item .action{
		width: 200rpx;
		height: 160rpx;
		margin-right: 25rpx;
	}
	
	.wanlpage-article .item .action image{
		height: 160rpx;
	}
	
	.wanlpage-article .item .content{
		display: flex;
		align-content: space-between;
		flex-wrap: wrap;
		flex: 1;
		margin: 10rpx 0;
	}
	.wanlpage-article .item .content>view{
		width: 100%;
	}
	
	.wanlpage-article .item .content .time{
		display: flex;
		justify-content: space-between;
	}
</style>
