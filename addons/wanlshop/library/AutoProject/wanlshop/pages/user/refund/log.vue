<template>
	<view>
		<view class="edgeInsetTop"></view>
		<view class="wanl-log bg-white margin-bottom-bj padding-bj flex" v-for="(item, index) in logData" :key="item.id">
			<view class="cu-avatar radius margin-right-bj" :style="{backgroundImage:'url('+$wanlshop.oss(item.avatar, 40, 40)+')'}"></view>
			<view class="content">
				<view class="">{{item.name}}</view>
				<view class="text-sm wanl-gray-light">
					{{item.createtime_text}}
				</view>
				<view class="text-sm margin-top-bj">
					{{item.content}}
				</view>
			</view>
		</view>
		<view class="edgeInsetBottom"> </view>
	</view>
</template>


<script>
export default {
	data() {
		return {
			logData: []
		};
	},
	onLoad(option) {
		this.loadData(option.id);
	},
	methods: {
		async loadData(id){
			// 提交
			this.$api.get({
				url: '/wanlshop/refund/getRefundLog',
				data: {id:id},
				success: res => {
					this.logData = res;
				}
			});
		}
	}
};
</script>

<style>
	.wanl-log .cu-avatar{
		margin-top: 4rpx;
	}
	
	
	.wanl-log .content{
		flex: 1;
	}
</style>
