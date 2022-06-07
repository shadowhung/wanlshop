<template>
	<view>
		<view class="edgeInsetTop"></view>
		<view class="cu-list menu-avatar">
			<view class="cu-item" v-for="(item, index) in ranklist" :key="item.id">
				<view class="cu-avatar lg round" :style="{ backgroundImage: 'url(' + $wanlshop.oss(item.user.avatar, 52, 52, 2, 'avatar') + ')' }"></view>
				<view class="content">
					<view class="text-sm flex">
						<view class="text-cut">
							{{item.user.nickname}}
						</view> 
					</view>
					<view class="wanl-gray text-sm">积分：{{item.user.score}}<text class="margin-left">签到：{{item.days}}天</text></view>
				</view>
				<view class="action">
					<view class="cu-tag round bg-red" v-if="index == 0">
						{{index+1}}
					</view>
					<view class="cu-tag round bg-orange" v-else-if="index == 1">
						{{index+1}}
					</view>
					<view class="cu-tag round bg-yellow" v-else-if="index == 2">
						{{index+1}}
					</view>
					<view class="cu-tag round bg-olive" v-else-if="index == 3">
						{{index+1}}
					</view>
					<view class="cu-tag round bg-green" v-else-if="index == 4">
						{{index+1}}
					</view>
					<view class="cu-tag round bg-grey" v-else>
						{{index+1}}
					</view>
				</view>
			</view>
		</view>
	</view>
</template>

<script>
	export default {
		data() {
			return {
				ranklist: {}
			}
		},
		onLoad() {
			this.loadData();
		},
		methods: {
			async loadData() {
				this.$api.post({
					url: '/wanlshop/signin/rank',
					success: res => {
						this.ranklist = res.ranklist;
					}
				});
			}
		}
	}
</script>

<style>
	.cu-list .cu-tag{
	    padding: 0 18rpx;
	}
</style>
