<template>
	<view class="wanl-signin-log">
		<view class="edgeInsetTop"> </view>
		<view class="header">
			<view class="text-center">
				<view class="text-sl" :style="{backgroundImage: 'url('+usermaks+')'}">
					{{user.score}}
				</view>
				<view class="cu-btn bg-orange radius-bock margin-top-bj" @tap="onScoreRank">
					查看签到排行榜
				</view>
			</view>
		</view>
		<view class="cu-list menu-avatar">
			<view class="cu-item" v-for="(item, index) in dataList" :key="item.id">
				<view class="content">
					<view class="text-sm flex">
						<view class="text-cut">
							{{item.memo}}
						</view> 
					</view>
					<view class="wanl-gray text-sm">{{ timestampToTime(item.createtime) }}</view>
				</view>
				<view class="action">
					<view class="wanl-text-yellow text-lg" v-if="item.score<0">{{item.score}}</view>
					<view class="text-lg text-orange" v-else>+{{item.score}}</view>
				</view>
			</view>
		</view>
		<view class="edgeInsetBottom"></view> 
		<uni-load-more :status="status" :content-text="contentText" />
	</view>
</template>

<script>
import { mapState } from 'vuex';
export default {
	data() {
		return {
			dataList: [],
			usermaks: '',
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
		};
	},
	computed: {
		...mapState(['user'])
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
				url: '/wanlshop/user/scoreLog',
				data: {
					page: this.current_page
				},
				success: res => {
					uni.stopPullDownRefresh();
					this.dataList = this.reload ? res.data : this.dataList.concat(res.data);this.usermaks = this.$wanlshop.maks(); //数据 追加
					this.total = res.total; //数据量
					this.current_page = res.current_page; //当前页码
					this.last_page = res.last_page; //总页码
					this.status = res.total == 0 ? 'noMore' : 'more';
				}
			});
		},
		timestampToTime(timestamp) {
			var date = new Date(timestamp * 1000);//时间戳为10位需*1000，时间戳为13位的话不需乘1000
			var Y = date.getFullYear() + '-';
			var M = (date.getMonth()+1 < 10 ? '0'+(date.getMonth()+1) : date.getMonth()+1) + '-';
			var D = (date.getDate() < 10 ?'0'+date.getDate():date.getDate()) + ' ';
			var h = date.getHours() + ':';
			var m = date.getMinutes() + ':';
			var s = date.getSeconds();
			return Y+M+D+h+m+s;
		},
		onScoreRank(){
			this.$wanlshop.to('/pages/user/signin/rank');
		}
	}
};
</script>

<style>
	.wanl-signin-log .header{
		display: flex;
		justify-content: center;
		align-items: center;
		height: 300rpx;
	}
	
	.wanl-signin-log .cu-list.menu-avatar>.cu-item .content{
		left: 25rpx;
	}
</style>
