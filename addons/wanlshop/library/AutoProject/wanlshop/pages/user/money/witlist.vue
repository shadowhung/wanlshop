<template>
	<view class="wanl-money">
		<view class="edgeInsetTop"></view>
		<view class="cu-list menu-avatar" v-if="dataList">
			<view class="cu-item" v-for="(item, index) in dataList" :key="item.id">
				<image class="cu-avatar" :src="`/static/images/bank/${item.type}.png`"></image>
				<view class="content">
					<view class="text-sm flex">
						<view class="text-cut">
							提现到{{bankList[item.type]}}***{{getCode(item.account)}}账户
						</view> 
					</view>
					<view>
						<text class="wanl-orange text-price">{{$wanlshop.bcadd(Number(item.money), Number(item.handingfee))}}</text>
					</view>
					<view class="wanl-gray text-sm">
						{{ $wanlshop.timeToDate(item.createtime) }}
					</view>
				</view>
				<view class="action">
					<view class="wanl-red" v-if="item.status == 'rejected'">
						拒绝 <text v-if="item.memo">{{item.memo}}</text>
					</view>
					<view class="cu-tag radius" :class="item.status == 'successed'?'bg-green':'bg-orange'" v-else>{{statusList[item.status]}}</view>
				</view>
			</view>
		</view>
		
		<!-- 空 -->
		<view v-if="dataList.length == 0">
			<wanl-empty src="ticket_default3x" text="没找到任何提现记录"/>
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
			statusList: {
				created: '申请中',
				successed: '成功',
				rejected: '已拒绝'
			},
			bankList: {
				alipay: '支付宝账户',
				ALIPAY: '支付宝账户',
				WECHAT: '微信账户',
				ICBC: '工商银行',
				ABC: '农业银行',
				PSBC: '邮储银行',
				CCB: '建设银行',
				CMB: '招商银行',
				BOC: '中国银行',
				COMM: '交通银行',
				SPDB: '浦发银行',
				GDB: '广发银行',
				CMBC: '民生银行',
				PAB: '平安银行',
				CEB: '光大银行',
				CIB: '兴业银行',
				CITIC: '中信银行'
			},
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
				url: '/wanlshop/pay/withdrawLog',
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
		getCode(str){
			str = str.replace(/\s+/g,"");
			return str.substring(str.length-4);
		}
	}
};
</script>

<style>
.wanl-money .balance {
	/* background-color: #f1f1f1; */
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
	width: 150rpx;
    text-align: right;
	padding-right: 25rpx;
}

</style>
