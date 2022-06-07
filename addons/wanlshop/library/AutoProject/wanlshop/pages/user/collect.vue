<template>
	<view class="wanl-collect">
		<view class="edgeInsetTop"></view>
		<view v-if="isData" class="cu-list menu-avatar">
			<view class="cu-item" :class="modalName=='move-box-'+ index?'move-cur':''" v-for="(item,index) in dataList" :key="index" @touchstart="ListTouchStart" @touchmove="ListTouchMove" @touchend="ListTouchEnd" :data-target="'move-box-' + index">
				<block v-if="item.goods.title">
					<view class="cu-avatar radius" :style="[{backgroundImage:'url('+ $wanlshop.oss(item.goods.image, 88, 88) +')'}]"
					 @tap="onGoods(item.goods_id)"></view>
					<view class="content" @tap="onGoods(item.goods_id)">
						<view class="text-sm">
							<text class="text-cut-2">{{item.goods.title}}</text>
						</view>
						<view class="wanl-gray text-sm">
							<text>喜欢 {{item.goods.like}}</text>
							<text class="margin-left-xs">付款 {{item.goods.payment}}</text>
						</view>
						<view class="function">
							<view class="text-price text-red text-df"> {{item.goods.price}} </view>
						</view>
					</view>
					<view class="move">
						<view class="bg-orange" @tap="onShop(item.goods.shop_id)">店铺</view>
						<view class="bg-red" @tap="loadFollow(item.goods_id, index)">删除</view>
					</view>
				</block>
				<block v-else>
					<view class="cu-avatar radius empty">
						<text class="wlIcon-fuwuqi1"></text>
					</view>
					<view class="content" @tap="onGoods(item.goods_id)">
						<view class="text-sm">
							<text class="text-cut-2">商品已失效，您可以侧滑删除</text>
						</view>
						<view class="wanl-gray text-sm">
							<text>喜欢 0</text>
							<text class="margin-left-xs">付款 0</text>
						</view>
						<view class="function">
							<view class="text-price text-red text-df"> 0 </view>
						</view>
					</view>
					<view class="move">
						<view class="bg-red" @tap="loadFollow(item.goods_id, index)">删除</view>
					</view>
				</block>
			</view>
		</view>
		<wanl-empty text="没有发现任何收藏" src="collect_default3x" v-else/>
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
					url: '/wanlshop/product/collect',
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
					url: '/wanlshop/product/follow',
					data: {
						id: id
					},
					success: res => {
						// 从列表删除
						this.$delete(this.dataList, index);
						this.$store.commit('statistics/dynamic', {
							collection: this.$store.state.statistics.dynamic.collection - 1
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
	.wanl-collect .cu-list.menu-avatar>.cu-item {
		height: 210rpx;
	}

	.wanl-collect .cu-list.menu-avatar>.cu-item>.cu-avatar {
		width: 160rpx;
		height: 160rpx;
		left: 25rpx;
	}

	.wanl-collect .cu-list.menu-avatar>.cu-item .content {
		position: absolute;
		height: 174rpx;
		left: 210rpx;
		line-height: 1.6em;
	}

	.wanl-collect .cu-list.menu-avatar>.cu-item .content .function {
		position: absolute;
		width: 100%;
		bottom: 0;
		display: flex;
		justify-content: space-between;
		align-items: center;
	}
	
	.wanl-collect .empty{
		background-color: #f1f1f1;
		font-size: 100rpx;
	}
	.wanl-footprint .empty text{
		color: #d5d5d5;
		font-size: 100rpx;
	}
</style>
