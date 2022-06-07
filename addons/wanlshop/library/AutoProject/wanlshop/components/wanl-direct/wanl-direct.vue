<template>
	<view>
		<view class="wanl-direct">
			<view class="menu-header" :style="{paddingTop: wanlsys.top + 'px'}">
				<view>
					功能直达
				</view>
				<view @tap="close">
					<text class="wlIcon-31guanbi"></text>
				</view>
			</view>
			<view class="menu-box">
				<view class="menu-item" hover-class="wanl-opcity" @tap="$wanlshop.on('/pages/notice/notice')">
					<view class="badge-box">
						<text class="wlIcon-xiaoxizhongxin"></text>
						<view class="cu-tag badge" v-if="statistics.notice.notice +statistics.notice.order +statistics.notice.chat > 0">{{statistics.notice.notice +statistics.notice.order +statistics.notice.chat}}</view>
					</view>
					<view class="menu-text">消息</view>
				</view>
				<view class="menu-item" hover-class="wanl-opcity" @tap="$wanlshop.on('/pages/wanlshop/index')">
					<view class="badge-box">
						<text class="wlIcon-31shouye"></text>
					</view>
					<view class="menu-text">首页</view>
				</view>
				<view class="menu-item" hover-class="wanl-opcity" @tap="$wanlshop.on('/pages/user/user')">
					<view class="badge-box">
						<text class="wlIcon-31wode"></text>
						<view class="cu-tag badge" v-if="statistics.order.pay +statistics.order.delive +statistics.order.receiving +statistics.order.evaluate > 0">{{statistics.order.pay +statistics.order.delive +statistics.order.receiving +statistics.order.evaluate}}</view>
					</view>
					<view class="menu-text">我的</view>
				</view>
				<view class="menu-item" hover-class="wanl-opcity" @tap="$wanlshop.on('/pages/cart/cart')">
					<view class="badge-box">
						<text class="wlIcon-gouwuche"></text>
						<view class="cu-tag badge" v-if="cart.cartnum > 0">{{cart.cartnum}}</view>
					</view>
					<view class="menu-text">购物车</view>
				</view>
				<view class="menu-item" hover-class="wanl-opcity" @tap="$wanlshop.on('/pages/user/service')">
					<view class="badge-box">
						<text class="wlIcon-unie737"></text>
					</view>
					<view class="menu-text">客服小蜜</view>
				</view>
				<view class="menu-item" hover-class="wanl-opcity" @tap="$wanlshop.on('/pages/user/feedback/feedback')">
					<view class="badge-box">
						<text class="wlIcon-xiugaioryijian"></text>
					</view>
					<view class="menu-text">我要反馈</view>
				</view>
				<view class="menu-item" hover-class="wanl-opcity" @tap="$emit('change','share')">
					<view class="badge-box">
						<text class="wlIcon-fenxiang"></text>
					</view>
					<view class="menu-text">分享</view>
				</view>
			</view>
		</view>
	</view>
</template>
<script>
	/**
	 * WanlShare 直达
	 * @description 直达组件 福建度虎科技有限公司 https://www.wanlshop.com（除万联官方内嵌系统，未经授权严禁使用）
	 * @著作权：WanlShop 登记号：2020SR0255711 版本：V1.0.0
	 * @property {Number} scrollAnimation 滚动位置 
	 * @event {Function} change 关闭弹窗
	 * @example <wanl-direct  @change="hideModal"/>
	 */
	import { mapState } from 'vuex';
	export default {
		name: "WanlDirect",
		props: {
			scrollAnimation: {
				type: Number,
				default: 0
			}
		},
		data() {
			return {
				wanlsys: this.$wanlshop.wanlsys(),
			};
		},
		computed: {
			...mapState(['statistics','cart'])
		},
		methods: {
			close() {
				this.$emit('change')
			}
		}
	}
</script>
<style>
	.wanl-direct .menu-header {font-size: 34rpx;color: #fff;display: flex;justify-content: space-between;}
	.wanl-direct .menu-box {color: #fff;padding: 40rpx 1rpx 0 1rpx;box-sizing: border-box;display: flex;flex-wrap: wrap;font-size: 26rpx;}
	.wanl-direct .menu-box .menu-item {width: 22%;height: 160rpx;border-radius: 24rpx;display: flex;align-items: center;flex-direction: column;justify-content: center;background: rgba(0, 0, 0, 0.4);margin-right: 4%;margin-bottom: 4%;}
	.wanl-direct .menu-box .menu-item:nth-of-type(4n) {margin-right: 0;}
	.wanl-direct .menu-box .menu-item .badge-box {position: relative;font-size: 52rpx;}
	.wanl-direct .menu-box .menu-item .badge-box .cu-tag {right: -25rpx;}
	.wanl-direct .menu-box .menu-item .menu-text {padding-top: 12rpx;}
	.wanl-direct .menu-up {width: 100%;text-align: center;font-size: 38rpx;margin-bottom: 2rpx;color: #ffffff;}
	.wanl-direct .menu-box .wanl-opcity .menu-text,
	.wanl-direct .menu-box .wanl-opcity .badge-box {opacity: 0.5;transition: opacity 0.2s ease-in-out;}
</style>
