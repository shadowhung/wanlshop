<template>
	<view class="wanl-success">
		<!-- 导航条 -->
		<view class="cu-custom" :style="{height: wanlsys.height + 'px' }">
			<view class="cu-bar bg-bgcolor fixed" :style="{ height: wanlsys.height + 'px', paddingTop: wanlsys.top + 'px'}">
				<view class="action" @tap="onBackUser">
					<text class="wlIcon-fanhui1"></text>
				</view>
				<view class="content" :style="{top: wanlsys.top + 'px'}">
					<text>{{title}}完成</text>
				</view>
			</view>
		</view>
		
		<view class="content">
			<text class="icon wlIcon-pintuantuangouchenggong"></text>
			<text class="text-lg margin-tb">{{ title }}已成功</text>
			<view class="button padding-xl margin-top-lg">
				<button class="cu-btn block wanl-bg-orange margin-tb-sm lg" v-if="type == 'comment'" @tap="$wanlshop.to('/pages/user/comment/comment')">查看评论</button>
				<button class="cu-btn block wanl-bg-orange margin-tb-sm lg" v-if="type == 'pay'" @tap="$wanlshop.to('/pages/user/order/order')">查看订单</button>
				<button class="cu-btn block wanl-bg-orange margin-tb-sm lg" v-if="type == 'feedback'" @tap="$wanlshop.to('/pages/user/feedback/lists')">查看反馈</button>
				<button class="cu-btn block wanl-bg-orange margin-tb-sm lg" v-if="type == 'complaint'" @tap="$wanlshop.to('/pages/user/complaint/lists')">查看举报</button>
				<button class="cu-btn block wanl-bg-orange margin-tb-sm lg" v-if="type == 'withdraw'" @tap="$wanlshop.to('/pages/user/money/witlist')">查看提现列表</button>
				<button class="cu-btn block wanl-bg-orange margin-tb-sm lg" v-if="type == 'recharge'" @tap="$wanlshop.to('/pages/user/money/money')">查看钱包</button>
				<button class="cu-btn block line-gray margin-tb-sm lg" @tap="onIndex">返回首页</button>
			</view>
		</view>
	</view>
</template>

<script>
export default {
	data() {
		return {
			wanlsys: this.$wanlshop.wanlsys(),
			type: '',
			title: ''
		};
	},
	onLoad(options) {
		if (options.type == 'pay') {
			this.title = '支付';
		} else if (options.type == 'comment') {
			this.title = '评论';
		} else if (options.type == 'feedback') {
			this.title = '反馈';
		} else if (options.type == 'withdraw') {
			this.title = '请等待后台审核，提交';
		} else if (options.type == 'recharge') {
			this.title = '充值';
		} else if (options.type == 'complaint') {
			this.title = '举报';
		}
		this.type = options.type;
	},
	methods: {
		onIndex() {
			uni.switchTab({
				url: '/pages/wanlshop/index'
			});
		},
		onBackUser(){
			uni.switchTab({
			    url: '/pages/user/user'
			});
		}
	}
};
</script>

<style>
.wanl-success .content {
	display: flex;
	flex-direction: column;
	justify-content: center;
	align-items: center;
}

.wanl-success .content .icon {
	font-size: 180rpx;
	color: #3aa112;
	margin-top: 150rpx;
}
.wanl-success .content .button {
	width: 100%;
}
</style>
