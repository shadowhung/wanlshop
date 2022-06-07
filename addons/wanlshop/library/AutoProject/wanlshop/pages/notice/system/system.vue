<template>
	<view>
		<view class="edgeInsetTop"></view>
		<view class="wanl-system" v-if="dataList.length != 0">
			<block v-for="(item, index) in dataList" :key="item.id" @tap="onDetails(item.id,item.title)">
				<view class="text-center margin-tb-bj wanl-gray-light">
					{{item.createtime_text}}
				</view>
				<view class="margin-lr-bj margin-bottom bg-white radius" >
					<image :src="$wanlshop.oss(item.image, 388, 218)" mode="widthFix"></image>
					<view class="padding-bj">
						<view class="text-lg text-cut-2">
							{{item.title}}
						</view>
						<text class="wanl-gray margin-top-xs" v-if="item.description">
							{{item.description}}
						</text>
					</view>
				</view>
			</block>
		</view>
		<wanl-empty src="notice_default3x" text="没有找到任何通知系统消息！" v-else/>
		<uni-load-more :status="status" :content-text="contentText" />
	</view>
</template>

<script>
	export default {
		data() {
			return {
				dataList: [],
				reload: false, //判断是否上拉
				total: 0, //数据量
				current_page: 1, //当前页码
				last_page: 1, //总页码
				status: 'more',
				contentText: {
					contentdown: ' ',
					contentrefresh: '加载中',
					contentnomore: ''
				}
			}
		},
		onLoad() {
			this.loadData();
		},
		onPullDownRefresh() {
			this.current_page = 1;
			this.reload = true;
			this.loadData();
		},
		onReachBottom() {
			//判断是否最后一页
			if (this.current_page >= this.last_page) {
				this.status = 'noMore';
			} else {
				this.reload = false;
				this.current_page = this.current_page + 1; //页码+1
				this.status = 'loading';
				this.loadData();
			}
		},
		methods: {
			async loadData() {
				this.$api.post({
					url: '/wanlshop/article/getList',
					data: {
						page: this.current_page,
						type: 'sys'
					},
					success: res => {
						uni.stopPullDownRefresh();
						this.dataList = this.reload ? res.data : this.dataList.concat(res.data); //数据 追加
						this.total = res.total; //数据量
						this.current_page = res.current_page; //当前页码
						this.last_page = res.last_page; //总页码
						this.status = res.total == 0 ? 'noMore':'more';
					}
				});
			},
		}
	}
</script>

<style>
	.wanl-system image{
		width: 100%;
	}
</style>

