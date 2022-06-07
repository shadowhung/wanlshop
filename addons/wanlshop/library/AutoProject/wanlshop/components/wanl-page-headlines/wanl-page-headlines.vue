<template>
	<view class="wanlpage-headlines" :style="[pageData.style]">
		<view class="margin-lr-bj icontext"><text class="wlIcon-toutiao"></text></view>
		<swiper disable-touch vertical autoplay circular interval="5000" class="swiper">
			<swiper-item class="swiper-item" v-for="(item, index) in headData" :key="index">
				<view class="list text-sm">
					<view class="item text-cut" v-for="(head, keys) in item" :key="head.id" @tap="onDetails(head.id, head.title)">
						<text class="cu-tag sm radius bg-gradual-red margin-right-xs">热门</text>
						<text class="content"> {{head.title}} </text>
					</view>
				</view>
				<image :src="$wanlshop.oss(item[0].image, 50, 50)"></image>
			</swiper-item>
		</swiper>
	</view>
</template>
<script>
	export default {
		name: "WanlPageHeadlines",
		props: {
			pageData: {
				type: Object,
				default: function() {
					return {
						name: '头条组件',
						type: 'headlines',
						params: [],
						style: []
					}
				}
			}
		},
		data() {
			return {
				headData: []
			};
		},
		created() {
			this.loadData()
		},
		methods: {
			async loadData() {
				this.$api.get({
					url: '/wanlshop/page/headlines',
					success: res => {
						var result = [];
						for(var i=0; i < res.length; i += 2){
						    result.push(res.slice(i, i + 2));
						}
						this.headData = result;
					}
				});
			},
			onArticleList(){
				this.$wanlshop.to('/pages/article/list');
			}
		}
	}
</script>
<style>
	.wanlpage-headlines {
		display: flex;
		align-items: center;
		overflow: hidden;
	}

	.wanlpage-headlines .icontext {
		font-size: 60rpx;
		color: #924849;
	}

	.wanlpage-headlines .swiper {
		width: 100%;
		height: 100rpx;
	}

	.wanlpage-headlines .swiper-item {
		display: flex;
		justify-content: space-between;
		align-items: center;
		position: relative;
	}
	.wanlpage-headlines .swiper-item .list{
		width: calc(100% - 116rpx);
		overflow: hidden;
	}
	.wanlpage-headlines .swiper-item .list .item{
		margin: 2rpx 0;
	}
	.wanlpage-headlines .swiper-item .list .item .content{
		vertical-align: middle;
	}
	.wanlpage-headlines .swiper-item image{
		width: 100rpx;
		height: 100rpx;
		border-radius: 0 20rpx 20rpx 0;
	}
</style>
