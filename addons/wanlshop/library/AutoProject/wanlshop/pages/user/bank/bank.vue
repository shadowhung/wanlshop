<template>
	<view>
		<view class="edgeInsetTop"></view>
		<view class="margin-bj">
			<view class="item" v-for="(item, key) in bankList" :key="item.id" @tap="checkBank(key)">
				<wanl-bank :bankCode="item.bankCode" :bankName="item.bankName" :cardCode="item.cardCode" />
				<view class="choice text-xl" v-if="choice == 1">
					<text class="wlIcon-xuanze-danxuan" v-if="index == key"></text>
					<text class="wlIcon-xuanze" v-else></text>
				</view>
			</view>
		</view>
		<view v-if="bankList.length == 0">
			<wanl-empty text="没找到任何账户"/>
		</view>
		<view class="edgeInsetBottom"></view>
		<view class="wanlian cu-bar tabbar foot flex flex-direction"><button @tap="addBank('add')" class="cu-btn wanl-bg-orange lg">新增新账户</button></view>
	</view>
</template>

<script>
export default {
	data() {
		return {
			bankList: [],
			index: null,
			choice: 0
		};
	},
	onLoad(option) {
		this.choice = option.choice;
		this.loadData();
	},
	methods: {
		async loadData() {
			this.$api.post({
				url: '/wanlshop/pay/getPayAccount',
				success: res => {
					this.bankList = res;
				}
			});
		},
		async refreshList(data) {
			uni.showLoading({
			    title: '更新中..'
			});
			this.$api.post({
				url: '/wanlshop/pay/addPayAccount',
				data: data,
				success: res => {
					this.loadData();
					uni.hideLoading();
					this.$store.commit('statistics/dynamic', {
						accountbank: this.$store.state.statistics.dynamic.accountbank + 1
					});
				}
			});
		},
		addBank(type, item) {
			this.$wanlshop.to(`/pages/user/bank/add?type=${type}&data=${JSON.stringify(item)}`);
		},
		//选择银行卡
		checkBank(key) {
			if(this.choice == 1){
				this.index = key;
				this.$wanlshop.prePage().bankData = this.bankList[key];
				this.$wanlshop.back(1);
			}else{
				//进入银行卡详情 删除/查看
				this.$wanlshop.to(`/pages/user/bank/details?data=${JSON.stringify(this.bankList[key])}`);
			}
		},
	}
};
</script>

<style>
.item {
	position: relative;
}
.item .choice {
	color: rgba(255, 255, 255, 0.8);
	position: absolute;
	right: 20rpx;
	top: 20rpx;
}
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
</style>
