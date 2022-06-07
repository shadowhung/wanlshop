<template>
	<view>
		<view class="edgeInsetTop"></view>
		<view v-if="isData" class="cu-list menu-avatar">
			<view class="cu-item" :class="modalName=='move-box-'+ index?'move-cur':''" v-for="(item,index) in dataList" :key="index" @touchstart="ListTouchStart" @touchmove="ListTouchMove" @touchend="ListTouchEnd" :data-target="'move-box-' + index">
				<view class="cu-avatar round lg" :style="[{backgroundImage:'url('+ $wanlshop.oss(item.shop.avatar, 52, 52) +')'}]"
				 @tap="onShop(item.shop_id)"></view>
				<view class="content" @tap="onShop(item.shop_id)">
					<view v-if="item.shop.isself == 1">
						<text class="cu-tag radius wanl-bg-redorange margin-right-xs">自营</text>
						{{item.shop.shopname}}
					</view>
					<view v-else>
						<text class="cu-tag radius bg-gray margin-right-xs" v-if="item.shop.state == 0">个人</text>
						<text class="cu-tag radius wanl-bg-blue margin-right-xs" v-if="item.shop.state == 1">企业</text>
						<text class="cu-tag radius wanl-bg-orange margin-right-xs" v-if="item.shop.state == 2">旗舰</text>
						{{item.shop.shopname}}
					</view>
					<view class="text-gray text-sm">{{item.shop.city}}</view>
				</view>
				<view class="action">
					<view class="text-grey text-xs">粉丝:{{$wanlshop.toFormat(item.shop.like, 'hundred')}}</view>
				</view>
				<view class="move">
					<view class="bg-orange" @tap="onShop(item.shop_id)">查看</view>
					<view class="bg-red" @tap="loadFollow(item.shop_id, index)">删除</view>
				</view>
			</view>
		</view>
		<wanl-empty text="还没有任何关注" src="follow_default3x" v-else></wanl-empty>
		<uni-load-more :status="status" :content-text="contentText" />
	</view>
</template>

<script>
	export default {
		data() {
			return {
				dataList: [],
				isData: true, //判断是否存在数据
				reload: false, //判断是否上拉
				total: 0, //数据量
				current_page: 1, //当前页码
				last_page: 1, //总页码
				status: 'loading',
				contentText: {
					contentdown: ' ',
					contentrefresh: '加载中',
					contentnomore: ''
				},
				// 侧滑
				modalName: null,
				listTouchStart: 0,
				listTouchDirection: null
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
				this.$api.get({
					url: '/wanlshop/shop/followList',
					data: {
						page: this.current_page
					},
					success: res => {
						uni.stopPullDownRefresh();
						this.dataList = this.reload ? res.data : this.dataList.concat(res.data); //评论数据 追加
						this.isData = this.dataList.length == 0 ? false : true; //判断是否存在数据
						this.total = res.total; //数据量
						this.current_page = res.current_page; //当前页码
						this.last_page = res.last_page; //总页码
						this.status = res.total == 0 ? 'noMore':'more';
					}
				});
			},
			async loadFollow(id, index) {
				this.$api.post({
					url: '/wanlshop/shop/follow',
					data: {
						id: id
					},
					success: res => {
						this.$delete(this.dataList, index);
						this.$store.commit('statistics/dynamic', {
							concern: this.$store.state.statistics.dynamic.concern - 1,
						});
					}
				});
			},
			// ListTouch触摸开始
			ListTouchStart(e) {
				this.listTouchStart = e.touches[0].pageX
			},
			// ListTouch计算方向
			ListTouchMove(e) {
				this.listTouchDirection = e.touches[0].pageX - this.listTouchStart > 0 ? 'right' : 'left'
			},
			// ListTouch计算滚动
			ListTouchEnd(e) {
				if (this.listTouchDirection == 'left') {
					this.modalName = e.currentTarget.dataset.target
				} else {
					this.modalName = null
				}
				this.listTouchDirection = null
			}
		}
	}
</script>

<style>
	.cu-tag{
		padding: 0 8rpx;
		height: 36rpx;
	}
</style>
