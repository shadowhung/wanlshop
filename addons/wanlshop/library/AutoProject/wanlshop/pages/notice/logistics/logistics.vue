<template>
	<view>
		<view class="edgeInsetTop"></view>
		<view class="wanl-logistics-list margin-top-bj" v-if="dataList.length != 0"> 
			<block v-for="(item, index) in dataList" :key="index">
			<view class="text-center wanl-gray">
				{{$wanlshop.timeToChat(item.createtime)}}
			</view>
			<view class="item margin-lr-bj margin-tb bg-white radius-bock padding-bj" @tap="$wanlshop.to(item.url)">
				<view class="title margin-bottom-bj">
					<text class="text-df">{{item.title}}</text>
					<text class="text-sm wanl-gray-light wlIcon-fanhui2"></text>
				</view>
				<view class="action">
					<image :src="$wanlshop.oss(item.image, 82, 82)"></image>
					<view class="padding-xs flex flex-wrap align-content-between">
						<view class="text-df margin-bottom-xs">{{item.content}}</view>
						<view class="text-sm wanl-gray">来自 {{item.come}}</view>
					</view>
				</view>
			</view>
			</block>
		</view>
		<wanl-empty src="notice_default3x" text="没有找到任何交易物流消息" v-else/>
		<uni-load-more :status="status" :content-text="contentText" />
		<view class="edgeInsetBottom"></view>
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
			this.$store.commit('statistics/noticec', {order: 0});
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
				this.$api.get({
					url: '/wanlshop/notice/getNoticeList',
					data: {
						type: 'order',
						page: this.current_page
					},
					success: res => {
						uni.stopPullDownRefresh();
						this.dataList = this.reload ? res.data : this.dataList.concat(res.data); //数据 追加
						this.total = res.total; //数据量
						this.current_page = res.current_page; //当前页码
						this.last_page = res.last_page; //总页码
						this.status = res.total == 0 ? 'noMore' : 'more';
					}
				});
			}
		}
	}
</script>

<style>

</style>
