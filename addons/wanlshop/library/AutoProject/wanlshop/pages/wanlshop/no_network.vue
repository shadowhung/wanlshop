<template>
	<view>
		<view class="no_network">
			<image src="../../static/images/default/network_default3x.png" mode="widthFix"></image>
			<view class="text-30 text-gray margin-bottom margin-top-lg">没有网络，请打开3G、4G或WIFI</view>
			<button class="cu-btn round lg line-gray" @tap="refresh">刷新页面</button>
		</view>
	</view>
</template>

<script>
	export default {
		data() {
			return {
				number: 0
			}
		},
		methods: {
			refresh(){
				this.number += 1;
				uni.getNetworkType({
				    success: (res)=> {
				        if (res.networkType == 'none') {
				        	if (this.number == 5) {
				        		uni.showModal({
				        		    title: '提示',
				        		    content: '哎呀，刷新了好多次还是没有网络，是否要直接进入系统',
				        		    success: (res)=> {
				        		        if (res.confirm) {
				        		            this.$wanlshop.on('/pages/wanlshop/index');
											this.$store.dispatch('common/init');
				        		        } else if (res.cancel) {
				        		            this.number = 0;
				        		        }
				        		    }
				        		});
				        	}else{
								this.$wanlshop.msg('正在检测网络，请稍等');
							}
				        }else{
							this.$wanlshop.on('/pages/wanlshop/index');
							this.$store.dispatch('common/init');
						}
				    }
				});
			}
		}
	}
</script>

<style>
	page{
		background-color: #fff;
	}
	
	.no_network{
		display: flex;
		align-items: center;
		justify-content: center;
		flex-direction: column;
		position: fixed;
		left: 0;
		top: 0;
		right: 0;
		bottom: 0;
		margin-bottom: 200rpx;
	}
	
	.no_network image{
		width: 360rpx;
	}
	
	.no_network .cu-btn.lg {
	    padding: 0 50rpx;
	    font-size: 28rpx;
	    height: 70rpx;
	}
	
</style>



