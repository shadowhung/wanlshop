<template>
	<view>
		<view class="edgeInsetTop"></view>
		<view class="wanl-order"> 
			<!-- 头部 -->
			<view class="header">
				<image :src="$wanlshop.appstc('/order/img_detail_bg.png')" class="img-bg"></image>
				<view class="content">
					<view>
						<view class="status-text">{{getStatusText(orderData.state)}}</view>
						<view class="reason"><text class="reason-text">{{orderData.statetime}}</text></view>
					</view>
					<image :src="$wanlshop.appstc('/order/'+getImg(orderData.state))" class="status-img" mode="widthFix"></image>
				</view>
			</view>
			<!-- 详情 -->
			<view class="address cu-list menu-avatar">
				<!-- 物流状态 -->
				<view class="cu-item" @tap="onLogistics(orderData.id)" v-if="orderData.state != 7 && orderData.state != 1 && orderData.state != 2 && logisticsType">
					<view class="cu-avatar round wanl-bg-blue"><text class="wlIcon-yunshuzhong"></text></view>
					<view class="content">
						<view>
							<text class="text-cut-2 text-sm wanl-pip">{{orderData.logistics.status}} - {{orderData.logistics.context}}</text>
						</view>
						<view class="wanl-gray">
							<text class="text-sm">{{orderData.logistics.time}}</text>
						</view>
					</view>
					<view class="action">
						<text class="wlIcon-fanhui2 wanl-gray"></text>
					</view>
				</view>
				<!-- 地址 -->
				<view class="cu-item">
					<view class="cu-avatar round wanl-bg-orange"><text class="wlIcon-weizhi1"></text></view>
					<view class="content">
						<view>
							<text class="wanl-pip margin-right-sm">{{orderData.address.name}}</text>
							<text class="wanl-gray text-sm">{{orderData.address.mobile}}</text>
						</view>
						<view class="wanl-pip text-cut-2 text-sm">
							{{orderData.address.address.replace(/\//g,' ')}}
							<text class="margin-left-xs" v-if="orderData.address.address_name">（{{orderData.address.address_name}}）附近</text>
						</view>
					</view>
				</view>
			</view>
			<view class="lists bg-white"  v-if="orderData.order_no">
				<view class="shopname text-sm padding-top-bj" @tap="onShop(orderData.shop_id)">
					<text class="wlIcon-dianpu1 margin-right-sm"></text>
					<text class="padding-right-xs wanl-black">{{orderData.shop.shopname}}</text>
					<text class="wlIcon-fanhuigengduo"></text>
				</view>
				<view class="cu-list menu-avatar">
					<block v-for="(item, index) in orderData.goods" :key="item.id">
						<view class="cu-item">
							<view class="cu-avatar radius" :style="{ backgroundImage: 'url(' + $wanlshop.oss(item.image, 77, 77) + ')' }" @tap="onGoods(item.goods_id)"></view>
							<view class="content" @tap="onGoods(item.goods_id)">
								<view class="text-cut-2">{{item.title}}</view>
								<view class="wanl_sku text-min">
									<text class="wanl-gray-dark">{{item.difference}}</text>
								</view>
							</view>
							<view class="action">
								<view class="text-orange text-price">{{item.price}}</view>
								<view class="wanl-gray text-min">x {{item.number}}</view>
							</view>
						</view>
						<view class="flex justify-end padding-lr-bj padding-bottom-sm">
							<!-- 1.0.2升级 取消订单后去掉退款按钮 -->
							<button class="cu-btn line-black sm" @tap="onRefund(orderData.id, item.refund_status, item.refund_id, index)" v-if="orderData.state == 2 || orderData.state == 3 || orderData.state == 4 || orderData.state == 6 "> {{getRefund(item.refund_status)}}</button>
						</view>
					</block>
				</view>
				<!-- 价格信息 -->
				<view class="price padding-lr-bj padding-bottom-bj text-min">
					<view> <text> 商品总价 </text> <text class="text-price"> {{orderData.pay.order_price}} </text> </view>
					<view> <text> 运费 </text> <text class="text-price"> {{orderData.pay.freight_price}} </text> </view>
					<view> <text> 优惠 </text> <text class="text-price"> {{orderData.pay.discount_price}} </text> </view>
					<view> <text> 总价 </text> <text class="text-price"> {{orderData.pay.price}} </text> </view>
					<view class="text-sm" v-if="orderData.pay.actual_payment != 0"> <text> 实付款 </text> <text class="text-price wanl-orange"> {{orderData.pay.actual_payment}} </text> </view>
				</view>
			</view>
			<view class="order bg-white margin-top-bj padding-bj" v-if="orderData.order_no">
				<view class="title" @tap="toMore">
					<view class="text-sm">订单详情</view>
					<view>
						<text class="wlIcon-fanhui3" v-if="infoMore"></text>
						<text class="wlIcon-fanhui4" v-else></text>
					</view>
				</view>
				<view class="text-sm">
					<view class="item">
						<text class="wanl-gray" style="width: 160rpx">订单编号：</text>
						<text> {{orderData.order_no}} </text>
					</view>
					<view class="item">
						<text class="wanl-gray" style="width: 160rpx">支付交易号：</text>
						<text> {{orderData.pay.pay_no}} </text>
					</view>
					<view class="item">
						<text class="wanl-gray" style="width: 160rpx">创建时间：</text>
						<text> {{orderData.createtime_text}} </text>
					</view>
					<block v-if="infoMore">
						<view class="item" v-if="orderData.paymenttime">
							<text class="wanl-gray-dark" style="width: 160rpx">付款时间：</text>
							<text> {{orderData.paymenttime_text}} </text>
						</view>
						<view class="item" v-if="orderData.delivertime">
							<text class="wanl-gray-dark" style="width: 160rpx">发货时间：</text>
							<text> {{orderData.delivertime_text}} </text>
						</view>
						<view class="item" v-if="orderData.taketime">
							<text class="wanl-gray-dark" style="width: 160rpx">收货时间：</text>
							<text> {{orderData.taketime_text}} </text>
						</view>
					</block>
				</view>
				<view class="foot solid-top" >
					<view @tap="toChat(orderData.shop_id)">
						<text class="wlIcon-xiaoxizhongxin text-min"></text>联系卖家
					</view>
				</view>
			</view>
			<view class="edgeInsetBottom"> </view>
		</view>
	</view>
</template>

<script>
export default {
	data() {
		return {
			orderData: {
				order_no: '',
				address: {
					name: '加载中...',
					mobile: '',
					address: '',
					address_name: ''
				},
				logistics: {
					context: '',
					status: '',
					time: ''
				},
				statetime: ''
			},
			logisticsType: false,
			infoMore: false
		};
	},
	onLoad(option) {
		this.loadData({id:option.id});
	},
	methods: {
		// 获取订单
		async loadData(data) {
			this.$api.get({
				url: '/wanlshop/order/getOrderInfo',
				data: data,
				success: res => {
					this.orderData = res;
					this.logisticsType = true;
					if(res.state == 0){
						this.orderData.statetime = '剩余时间0';
					}else if(res.state == 1){
						var diff = (res.createtime + res.config.cancel * 86400) - Date.parse(new Date()) / 1000;
						var days = Math.floor(diff / 86400);
						var hours = Math.floor(diff % 86400 / 3600); 
						var minutes = Math.floor(diff % 86400 % 3600 / 60);
						if (minutes > 0) {
							this.orderData.statetime = '还剩' +minutes+ '分自动关闭订单';
						}
						if (hours > 0) {
							this.orderData.statetime = '还剩' +hours+ '天' +minutes+ '分自动关闭订单';
						}
						if (days > 0) {
							this.orderData.statetime = '还剩' +days+ '天' +hours+ '小时' +minutes+ '分自动关闭订单';
						}
					}else if(res.state == 2){
						this.orderData.statetime = '等待卖家发货';
					}else if(res.state == 3){
						var diff = (res.delivertime + res.config.receiving * 86400) - Date.parse(new Date()) / 1000;
						var days = Math.floor(diff / 86400);
						var hours = Math.floor(diff % 86400 / 3600); 
						var minutes = Math.floor(diff % 86400 % 3600 / 60);
						if (minutes > 0) {
							this.orderData.statetime = '还剩' +minutes+ '分自动确认收货';
						}
						if (hours > 0) {
							this.orderData.statetime = '还剩' +hours+ '天' +minutes+ '分自动确认收货';
						}
						if (days > 0) {
							this.orderData.statetime = '还剩' +days+ '天' +hours+ '小时' +minutes+ '分自动确认收货';
						}
					}else if(res.state == 4){
						var diff = (res.taketime + res.config.comment * 86400) - Date.parse(new Date()) / 1000;
						var days = Math.floor(diff / 86400);
						var hours = Math.floor(diff % 86400 / 3600); 
						var minutes = Math.floor(diff % 86400 % 3600 / 60);
						if (minutes > 0) {
							this.orderData.statetime = '还剩' +minutes+ '分自动评论';
						}
						if (hours > 0) {
							this.orderData.statetime = '还剩' +hours+ '天' +minutes+ '分自动评论';
						}
						if (days > 0) {
							this.orderData.statetime = '还剩' +days+ '天' +hours+ '小时' +minutes+ '分自动评论';
						}
					}else if(res.state == 6){	
						this.orderData.statetime = res.dealtime_text;
					}else if(res.state == 7){	
						this.orderData.statetime = '订单已取消';
					}
				}
			});
		},
		getImg(status) {
			return ["img_order_payment3x.png", "img_order_send3x.png", "img_order_received3x.png", "img_order_signed3x.png", "img_order_closed3x.png", "img_order_signed3x.png", "img_order_closed3x.png"][status - 1];
		},
		getStatusText(status) {
			return ["等待您付款", "付款成功", "待收货", "待评论", "退款订单", "订单已完成", "交易关闭"][status - 1];
		},
		getRefund(status) {
			return ["退款", "退款中", "待退货", "退款完成", "退款关闭", "退款被拒"][status];
		},
		/**
		 * 进入退款
		 * @param {Object} order_id 订单ID 
		 * @param {Object} status 售后状态:0=未退款,1=退款中,2=待退货,3=退款完成
		 */
		onRefund(order_id, refund_status, refund_id, index){
			if (refund_status == 0) { //申请退款
				this.$wanlshop.to(`/pages/user/refund/apply?data=${JSON.stringify({
						order_id: this.orderData.id,
						goods: this.orderData.goods[index],
						freight_type: this.orderData.freight_type,
						discount_price: this.orderData.pay.discount_price,
						goods_number: this.orderData.goods.length
					})}`);
			}else{ // 查看详情
				this.$wanlshop.to(`/pages/user/refund/details?id=${refund_id}`);
			}
		},
		// 折叠项
		toMore(){
			this.infoMore = !this.infoMore;
		}
	}
};
</script>

<style>
	.wanl-order .header {
		width: 100%;
		height: 180rpx;
		position: relative;
		background-color: #f72b36;
	}
	
	.wanl-order .header .img-bg {
		width: 100%;
		height: 180rpx;
	}
	
	.wanl-order .header .content {
		width: 100%;
		height: 180rpx;
		position: absolute;
		z-index: 10;
		left: 0;
		top: 0;
		display: flex;
		align-items: center;
		justify-content: space-between;
		padding: 0 60rpx;
		box-sizing: border-box;
	}
	
	.wanl-order .header .status-text {
		font-size: 34rpx;
		line-height: 34rpx;
		color: #FEFEFE;
	}
	
	.wanl-order .header .reason {
		font-size: 24rpx;
		line-height: 24rpx;
		color: rgba(254, 254, 254, 0.75);
		padding-top: 15rpx;
		display: flex;
		align-items: center;
	}
	
	.wanl-order .header .reason-text {
		padding-right: 12rpx;
	}
	
	.wanl-order .header .status-img {
		width: 100rpx;
		height: 100rpx;
		display: block;
	}
	
	
	
	
	.wanl-order .lists .shopname {
	    margin: 25rpx 25rpx 30rpx 25rpx;
	}
	.wanl-order .lists .price>view{
		display: flex;
		align-items: center;
		justify-content:space-between;
		height: 40rpx;
	}
	
	.wanl-order .lists .cu-btn{
		font-size: 22rpx;
		padding: 0 14rpx;
	}
	
	
	
	
	.cu-list.menu-avatar>.cu-item{
		height: 160rpx;
	}
	.cu-list.menu-avatar>.cu-item .content{
		line-height: 1.4;
	}
	
	.wanl-order .order .title{
		display: flex;
		align-items: center;
		justify-items: center;
		justify-content: space-between;
	}
	.wanl-order .order .item{
		display: flex;
		padding-top: 30rpx;
	}
	.wanl-order .order .foot{
		display: flex;
		justify-content: space-around;
		justify-items: center;
		align-items: center;
		padding-top: 25rpx;
		margin-top: 20rpx;
	}
	.wanl-order .order .foot text[class*="wlIcon-"]{
		color: #0081FF;
		margin-right: 10rpx;
		font-size: 32rpx;
	}
	
	
</style>
