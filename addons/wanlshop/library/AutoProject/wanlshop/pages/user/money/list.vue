<template>
	<view class="wanl-money">
		<view class="edgeInsetTop"></view>
		<view class="cu-list menu-avatar" v-if="dataList">
			<view class="cu-item" v-for="(item, index) in dataList" :key="item.id" @tap="toMoney(item)" >
				<view class="cu-avatar round bg-blue" v-if="item.type == 'pay'">
					<text class="wlIcon-baojiadan"></text>
				</view>
				<view class="cu-avatar round bg-cyan" v-else-if="item.type == 'recharge'">
					<text class="wlIcon-zhanghuyue"></text>
				</view>
				<view class="cu-avatar round bg-orange" v-else-if="item.type == 'withdraw'">
					<text class="wlIcon-jinbitixian"></text>
				</view>
				<view class="cu-avatar round bg-pink" v-else-if="item.type == 'refund'">
					<text class="wlIcon-jingjiachenggong"></text>
				</view>
				<view class="cu-avatar round bg-red" v-else>
					<text class="wlIcon-fuwuqi1"></text>
				</view>
				<view class="content">
					<view class="text-sm flex">
						<view class="text-cut">
							{{item.memo}}
						</view> 
					</view>
					<view class="wanl-gray text-sm text-bold">{{getType(item.type)}}</view>
					<view class="wanl-gray text-sm">
						{{ $wanlshop.timeToDate(item.createtime) }}
					</view>
				</view>
				<view class="action">
					<view class="text-lg" :class="item.money > 0 ? 'wanl-orange' : 'wanl-black'">{{ item.money > 0 ? '+'+item.money:item.money}}</view>
				</view>
			</view>
		</view>
		<!-- 空 -->
		<view v-if="dataList.length == 0">
			<wanl-empty src="ticket_default3x" text="没找到任何账单明细"/>
		</view>
		<view class="edgeInsetBottom"></view>
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
		};
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
				url: '/wanlshop/pay/moneyLog',
				data: {
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
		},
		getType(type){
			let typename = '';
			if(type == 'pay'){
				typename = '商品交易';
			}else if(type == 'recharge'){
				typename = '充值';
			}else if(type == 'withdraw'){
				typename = '提现';
			}else if(type == 'refund'){
				typename = '退款';
			}else{
				typename = '系统';
			}
			return typename;
		},
		toMoney(item){
			this.$wanlshop.to(`/pages/user/money/details?data=${JSON.stringify(item)}`);
		}
	}
};
</script>

<style>
.wanl-money .balance {
	margin: 10rpx 25rpx 25rpx 25rpx;
}

.wanl-money .balance .details {
	padding: 50rpx 0;
}

.wanl-money .balance .operate {
	display: flex;
	align-items: center;
	justify-content: space-around;
	background: rgba(0, 0, 0, 0.1);
	height: 80rpx;
	color: #fff;
}

.wanl-money .cu-list.menu-avatar>.cu-item{
	height: 180rpx;
	align-items: flex-start;
	padding: 25rpx 0;
}

.wanl-money .cu-list.menu-avatar>.cu-item .cu-avatar {
    width: 75rpx;
    height: 75rpx;
	left: 25rpx;
	margin-top: 6rpx;
}

.wanl-money .cu-list.menu-avatar>.cu-item .content {
    left: 120rpx;
    width: calc(100% - 75rpx - 25rpx -150rpx);
    line-height: 1.5em;
}

.wanl-money .cu-list.menu-avatar>.cu-item .action{
	width: 220rpx;
    text-align: right;
	padding-right: 25rpx;
}

</style>
