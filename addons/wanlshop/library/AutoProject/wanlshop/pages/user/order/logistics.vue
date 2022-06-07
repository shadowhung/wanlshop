<template>
	<view>
		<view class="edgeInsetTop"></view>
		<!-- <view class="wanl-order-goods margin-bj bg-white radius-bock">
			<view class="padding-lr-bj padding-top-bj text-sm flex justify-between">
				<view>
					订单号：{{data.order_no}}
				</view>
				<view class="wanl-gray text-sm" v-if="data.goods.length != 0">
					共 {{data.goods.length}} 件
				</view>
			</view>
			<scroll-view class="scroll-view padding-bj" scroll-x="true">
		        <view class="list">
		        	<view class="item" v-for="(item, index) in data.goods" :key="item.id" @tap="onGoods(item.goods_id)">
		        		<view class="cu-avatar lg radius-bock" :style="{ backgroundImage: 'url(' + $wanlshop.oss(item.image, 'order') + ')' }"></view>
					</view>
		        </view>
		    </scroll-view>
		</view> -->
		<!-- 物流详情 -->
		<view class="margin-bj bg-white radius-bock" v-if="isLoad">
			<view class="flex align-center margin-bj" @tap="phoneCall(data.kuaidi.tel)">
				<view class="cu-avatar lg radius-bock bg-white" :style="{ backgroundImage: 'url(' + $wanlshop.oss(data.kuaidi.logo, 40,40) + ')' }"></view>
				<view class="margin-left-bj">
					<view>{{data.kuaidi.name}}</view>
					<view class="text-min">
						官方电话
						<text class="margin-lr-xs">{{data.kuaidi.tel}}</text>
						<text class="wlIcon-fanhuigengduo"></text>
					</view>
				</view>
			</view>
			<view class="courier-number" @tap="onCopy(data.express_no)">
				{{data.kuaidi.name}} <text class="margin-lr-xs">{{data.express_no}}</text> <text class="wlIcon-lianjie"></text>
			</view>
		</view>
		
		<!-- 运单详情 -->
		<view class="margin-bj bg-white radius-bock" v-if="isLoad">
			<view class="padding-left-bj padding-top-bj text-sm">
				运单详情
			</view>
			<view class="order-tracking">
				<view class="time-axis wanl-gray">
					<!-- <view class="timeaxis-item">
						<view class="text-min">[收货地址]</view>
						<view class="timeaxis-node">
							<view class="cu-tag round"><text>收</text></view>
						</view>
					</view> -->
					<view class="timeaxis-item" v-for="(item, index) in data.express" :key="item.id">
						<block v-if="index == 0">
							<view class="wanl-black">
								<view>{{ item.status }}</view>
								<view class="text-min">{{ item.context }}</view>
								<view class="text-min margin-top-xs">{{ item.time }}</view>
							</view>
							<view class="timeaxis-node">
								<view class="cu-tag round wanl-bg-orange">
									<text class="wlIcon-dot" v-if="item.status == '在途'"></text>
									<text class="wlIcon-wuliuqiache2" v-else-if="item.status == '揽收'"></text>
									<text class="wlIcon-31xuanze" v-else-if="item.status == '签收'"></text>
									<text class="wlIcon-paisongtixing" v-else-if="item.status == '派件'"></text>
									<text class="wlIcon-shiyongbangzhu1" v-else-if="item.status == '疑难'"></text>
									<text class="wlIcon-daifahuo" v-else-if="item.status == '退签'"></text>
									<text class="wlIcon-guanbi" v-else-if="item.status == '退回'"></text>
									<text class="wlIcon-jiangjia" v-else-if="item.status == '转投'"></text>
									<text class="wlIcon-31daifukuan" v-else-if="item.status == '尚未付款'"></text>
									<text class="wlIcon-chanpincanshu" v-else-if="item.status == '已下单'"></text>
									<text class="wlIcon-shijian" v-else-if="item.status == '仓库处理中'"></text>
								</view>
							</view>
						</block>
						<block v-else>
							<view>
								<view v-if="item.status != '在途'">{{ item.status }}</view>
								<view class="text-min">{{ item.context }}</view>
								<view class="text-min margin-top-xs">{{ item.time }}</view>
							</view>
							<view class="timeaxis-node">
								<text class="wlIcon-dot" v-if="item.status == '在途'"></text>
								<view class="cu-tag round" v-else-if="item.status == '揽收'"><text class="wlIcon-wuliuqiache2"></text></view>
								<text class="wlIcon-shiyongbangzhu1" v-else-if="item.status == '疑难'"></text>
								<text class="wlIcon-daifahuo" v-else-if="item.status == '退签'"></text>
								<view class="cu-tag round" v-else-if="item.status == '派件'"><text class="wlIcon-paisongtixing"></text></view>
								<text class="wlIcon-guanbi" v-else-if="item.status == '退回'"></text>
								<text class="wlIcon-jiangjia" v-else-if="item.status == '转投'"></text>
								<text class="wlIcon-31daifukuan" v-else-if="item.status == '尚未付款'"></text>
								<text class="wlIcon-chanpincanshu" v-else-if="item.status == '已下单'"></text>
								<text class="wlIcon-shijian" v-else-if="item.status == '仓库处理中'"></text>
							</view>
						</block>
					</view>

					<view class="timeaxis-item">
						<view class="text-min">包裹等待揽收</view>
						<view class="timeaxis-node"><text class="wlIcon-dot"></text></view>
					</view>
				</view>
			</view>
		</view>
	</view>
</template>

<script>
const thorui = require("@/components/tui-clipboard/tui-clipboard.js")
export default {
	data() {
		return {
			data: {
				order_no: "加载中...",
				goods:[]
			},
			isLoad: false
		};
	},
	onLoad(option) {
		this.loadData({
			id: option.id
		});
	},
	methods: {
		// 获取订单
		async loadData(data) {
			this.$api.post({
				url: '/wanlshop/order/getLogistics',
				loadingTip: '加载中',
				data: data,
				success: res => {
					this.data = res;
					this.isLoad = true;
				}
			});
		},
		phoneCall(number){
			uni.makePhoneCall({
			    phoneNumber: number
			});
		},
		onCopy(text) {
			thorui.getClipboardData(text, (res) => {
				// #ifdef H5 || MP-ALIPAY
				if (res) {
					this.$wanlshop.msg('单号复制成功');
				} else {
					this.$wanlshop.msg('单号复制失败');
				}
				// #endif
			})
		}
	}
};
</script>

<style>
	.wanl-order-goods .scroll-view{
		white-space: nowrap;
		width: 100%;
		display: flex;
	}
	.wanl-order-goods .scroll-view .list{
		display: flex;
	}
	.wanl-order-goods .scroll-view .list .item{
		margin-right: 10rpx;
	}
	.wanl-order-goods .scroll-view .list .item .cu-avatar{
		width: 150rpx;
		height: 150rpx;
	}
.courier-number {
	font-size: 22rpx;
	padding: 20rpx 25rpx;
	background-color: #fbfbfb;
}
.order-tracking {
	box-sizing: border-box;
	padding: 25rpx;
	padding-left: 50rpx;
	padding-top: 25rpx;
}
.order-tracking .cu-tag {
	font-size: 22rpx;
	padding: 0 10rpx;
	height: 40rpx;
	display: flex;
	align-items: center;
	justify-content: center;
	justify-items: center;
}
.order-tracking .time-axis {
	padding-left: 20px;
	box-sizing: border-box;
	position: relative;
}

.order-tracking .time-axis::before {
	content: ' ';
	position: absolute;
	left: 0;
	top: 0;
	width: 1px;
	bottom: 0;
	border-left: 1px solid #ddd;
	-webkit-transform-origin: 0 0;
	transform-origin: 0 0;
	-webkit-transform: scaleX(0.5);
	transform: scaleX(0.5);
}
.order-tracking .time-axis .timeaxis-item {
	position: relative;
	width: 100%;
	display: flex;
	flex-direction: column;
	margin-bottom: 25px;
}

.order-tracking .time-axis .timeaxis-item .timeaxis-node {
	position: absolute;
	top: 0;
	left: -20px;
	transform-origin: 0;
	transform: translateX(-50%);
	display: flex;
	align-items: center;
	justify-content: center;
	z-index: 99;
}
</style>
