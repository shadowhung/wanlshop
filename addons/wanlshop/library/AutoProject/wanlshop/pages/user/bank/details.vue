<template>
	<view>
		<view class="edgeInsetTop"></view>
		<view class="cu-list menu">
			<view class="cu-item">
				<view class="content">
					<text>账户</text>
				</view>
				<view class="action bankinfo">
					<image :src="`/static/images/bank/${bankData.bankCode}.png`"></image>
					<view class="">
						<text>{{bankData.bankName}}</text>
					</view>
				</view>
			</view>
			<view class="cu-item">
				<view class="content">
					<text>类型</text>
				</view>
				<view class="action">
					<text>储蓄账户</text>
				</view>
			</view>
			<view class="cu-item">
				<view class="content">
					<text>账号</text>
				</view>
				<view class="action">
					<text>{{bankData.cardCode}}</text>
				</view>
			</view>
			<view class="cu-item">
				<view class="content">
					<text>姓名</text>
				</view>
				<view class="action">
					<text>{{bankData.username}}</text>
				</view>
			</view>
			<view class="cu-item">
				<view class="content">
					<text>预留号码</text>
				</view>
				<view class="action">
					<text>{{bankData.mobile}}</text>
				</view>
			</view>
		</view>
		<view class="edgeInsetBottom"></view>
		<view class="wanlian cu-bar tabbar foot flex flex-direction">
			<button @tap="delBank" class="cu-btn wanl-bg-orange lg">删除账户</button>
		</view>
	</view>
</template>

<script>
export default {
	data() {
		return {
			bankData: {}
		};
	},
	onLoad(option) {
		this.bankData = JSON.parse(option.data);
	},
	methods: {
		async delBank(){
			this.$api.get({
				url: '/wanlshop/pay/delPayAccount',
				data: {
					ids: this.bankData.id
				},
				success: res => {
					this.$wanlshop.msg('删除成功');
					this.$wanlshop.prePage().loadData();
					this.$wanlshop.back(1);
				}
			});
		}
	}
};
</script>

<style>
	.wanlian.cu-bar.tabbar {
		background-color: transparent;
	}
	.wanlian.cu-bar.tabbar .cu-btn {
		width: calc(100% - 50rpx);
	}
	.wanlian.cu-bar.tabbar .cu-btn.lg {
		font-size: 32rpx;
		height: 86rpx;
	}
	.bankinfo{
		display: flex;
		align-items: center;
	}
	.bankinfo image{
		width: 50rpx;
		height: 50rpx;
		margin-right: 20rpx;
	}
</style>
