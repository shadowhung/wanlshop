<template>
	<view class="wanl-article">
		<view class="edgeInsetTop"></view>
		<!-- 进度条 -->
		<view class="load-progress" :class="loadProgress!=0?'show':'hide'">
			<view class="load-progress-bar bg-orange" :style="[{transform: 'translate3d(-' + (100-loadProgress) + '%, 0px, 0px)'}]"></view>
		</view>
		<!-- <view class="article-meta">
			<text class="article-author">sdfsdfsdf</text>
			<text class="article-text">发表于</text>
			<text class="article-time">sdfsd</text>
		</view> -->
		<view class="margin-bj content">
			<rich-text :nodes="detailsData.content"></rich-text>
		</view>
	</view>
</template>

<script>
	import htmlParser from '@/common/html-parser';
	export default {
		data() {
			return {
				loadProgress: 0, //进度条
				detailsData: {}
			}
		},
		onLoad(option) {
			// 进度条
			this.LoadProgress();
			this.loadData({id:option.id});
			this.$wanlshop.title(option.title);
		},
		methods: {
			// 异步加载
			async loadData(data) {
				this.$api.get({
					url: '/wanlshop/article/details',
					data: data,
					success: res => {
						this.detailsData = res;
						this.detailsData.content = htmlParser(res.content.replace(/\\/g, "").replace(/<img/g, "<img style=\"display:none;\""));
						this.loadProgress = 90;
					}
				});
			},
			// 进度条
			LoadProgress() {
				this.loadProgress = this.loadProgress + 2;
				if (this.loadProgress < 100) {
					setTimeout(() => {
						this.LoadProgress();
					}, 100)
				} else {
					this.loadProgress = 0;
				}
			}
		}
	}
</script>

<style>
	.wanl-article .content{
		
	}
</style>
