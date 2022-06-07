<template>
    <view>
		<view class="edgeInsetTop"></view>
		<!-- 获取网页 -->
		<web-view v-if="detailsData.url" :webview-styles="webviewStyles" :src="detailsData.url"></web-view>
		<!-- 获取内容 -->
		<view class="content" v-else>
			<rich-text :nodes="detailsData.content"></rich-text>
		</view>
    </view>
</template>

<script>
	import htmlParser from '@/common/html-parser';
    export default {
        data() {
            return {
                webviewStyles: {
                    progress: {
                        color: '#fe6600'
                    }
                },
				detailsData:{
					content: '加载中..',
					title: '加载中'
				}
            }
        },
		onLoad(option) {
			this.loadData({id:option.id});
		},
		methods: {
			// 异步加载
			async loadData(data) {
				this.$api.get({
					url: '/wanlshop/article/adDetails',
					data: data,
					success: res => {
						this.detailsData = res;
						this.detailsData.content = htmlParser(res.content.replace(/\\/g, "").replace(/<img/g, "<img style=\"display:none;\""));
						this.$wanlshop.title(res.title);
					}
				});
			}
		}
    }
</script>

<style>

</style>