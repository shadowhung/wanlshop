<template>
	<view class="wanl-order-list">
		<view class="navbar">
			<view class="nav-item text-df" v-for="(item, index) in navList" :key="item.state" :class="{ current: tabCurrentIndex === index }" @tap="tabClick(index)">
				{{ item.text }}
			</view>
		</view>
		<swiper :current="tabCurrentIndex" style="height: calc(100% - 80rpx)" duration="300" @change="changeTab">
			<swiper-item class="tab-content" v-for="(tag, key) in navList" :key="tag.state">
				<scroll-view class="list-scroll-content" scroll-y @scrolltolower="loadData">
					<!-- 空白页 -->
					<wanl-empty text="没有找到任何订单"v-if="tag.loaded === true && tag.orderList.length === 0"/>
					<!-- 订单列表 -->
					<view v-for="(order, okey) in tag.orderList" :key="order.id" class="order-item radius-bock">
						<view class="head">
							<view class="shop wanl-gray" @tap="onShop(order.shop_id)">
								<text class="wlIcon-dianpu1 wanl-black"></text>
								<text class="wanl-black margin-lr-xs text-30">{{ order.shop.shopname }}</text>
								<text class="wlIcon-fanhuigengduo text-sm"></text>
							</view>
							<view class="margin-right-bj text-sm">
								<text class="state" :style="{ color: order.stateTipColor }">{{ order.stateTip }}</text>
								<text v-if="order.state === 7" class="margin-left-sm wlIcon-lajitong" @tap="deleteOrder(order.id,okey)"></text>
							</view>
						</view>
						<!-- 商品 -->
						<view class="goods-box" v-for="(goods, gkey) in order.goods" :key="goods.id" @tap="orderDetails(order.id)">
							<view class="cu-avatar xl margin-right-bj radius" :style="{backgroundImage: 'url('+$wanlshop.oss(goods.image, 70, 70)+')'}"> </view>
							<view class="content margin-right-bj">
								<view class="describe">
									<view class="text-cut-2">
										{{goods.title}}
									</view>
									<view class="wanl_sku text-min">
										<text class="wanl-gray-dark">{{goods.difference}}</text>
									</view>
								</view>
								<view class="parameter">
									<view class="text-price text-sm text-black">
										{{ goods.price }}
									</view>
									<view class="text-min text-gray">
										x {{ goods.number }}
									</view>
									<!-- 退款状态:0=未退款,1=退款中,2=待退货,3=退款完成 -->
									<view class="text-min text-yellow" v-if="goods.refund_status != 0">
										{{getRefund(goods.refund_status)}}
									</view>
								</view>
							</view>
						</view>
						<!-- 底部 -->
						<view class="price-box text-xs flex">
							<view class="margin-right-sm">优惠：<text class="text-price">{{ order.pay.discount_price }}</text></view>
							<view class="margin-right-sm">快递：<text class="text-price">{{ order.pay.freight_price }}</text></view>
							<view>总价：<text class="text-price text-df">{{ order.pay.price }}</text></view>
						</view>
						<view class="action-box padding-bottom-bj" v-if="order.state == 1">
							<button class="cu-btn round line-black margin-lr-bj" @tap="editAddress(order.id)">修改地址</button>
							<button class="cu-btn round line-black" @tap="cancelOrder(order)">取消订单</button>
							<button class="cu-btn round margin-lr-bj wanl-bg-orange" @tap="paymentOrder(order.id)">立即支付</button>
						</view>
						<view class="action-box padding-bottom-bj" v-if="order.state == 2">
							<button class="cu-btn round line-black" @tap="toChat(order.shop_id)">联系商家</button>
							<button class="cu-btn round margin-lr-bj wanl-bg-orange" @tap="editAddress(order.id)">修改地址</button>
						</view>
						<view class="action-box padding-bottom-bj" v-if="order.state == 3">
							<button class="cu-btn round line-black" @tap="onLogistics(order.id)">查看物流</button>
							<button class="cu-btn round margin-lr-bj wanl-bg-orange" @tap="confirmOrder(order)">确认收货</button>
						</view>
						<view class="action-box padding-bottom-bj" v-if="order.state == 4">
							<button class="cu-btn round line-black" @tap="onLogistics(order.id)">查看物流</button>
							<button class="cu-btn round margin-lr-bj line-black" @tap="commentOrder(order.id)">评论订单</button>
						</view>
					</view>
					<uni-load-more :status="tag.loadingType" :content-text="contentText"/>
					<view class="edgeInsetBottom"></view> 
				</scroll-view>
			</swiper-item>
		</swiper>
	</view>
</template>

<script>
export default {
	data() {
		return {
			tabCurrentIndex: 0,
			navList: [
				{
					state: 0,
					text: '全部',
					loadingType: 'more',
					current_page: 1,
					orderList: []
				},
				{
					state: 1,
					text: '待支付',
					loadingType: 'more',
					current_page: 1,
					orderList: []
				},
				{
					state: 2,
					text: '待发货',
					loadingType: 'more',
					current_page: 1,
					orderList: []
				},
				{
					state: 3,
					text: '待收货',
					loadingType: 'more',
					current_page: 1,
					orderList: []
				},
				{
					state: 4,
					text: '待评论',
					loadingType: 'more',
					current_page: 1,
					orderList: []
				}
				// ,{
				// 	state: 7,
				// 	text: '已关闭',
				// 	loadingType: 'more',
				// 	current_page: 1,
				// 	orderList: []
				// }
			],
			contentText: {
				contentdown: ' ',
				contentrefresh: '正在加载...',
				contentnomore: ''
			}
		};
	},
	onLoad(options) {
		if (!options.state) {
			options.state = 0;
		}
		this.tabCurrentIndex = +options.state;
		// #ifndef MP
		this.loadData();
		// #endif
		// #ifdef MP
		if (options.state == 0) {
			this.loadData();
		}
		// #endif
	},
	methods: {
		//获取订单列表
		loadData(source) {
			//这里是将订单挂载到tab列表下
			let index = this.tabCurrentIndex;
			let navItem = this.navList[index];
			let state = navItem.state;
			//判断是否最后一页
			if (navItem.loadingType == 'noMore') {
				return;
			}
			//tab切换只有第一次需要加载数据
			if (source === 'tabChange' && navItem.loaded === true) {
				return;
			}
			//防止重复加载
			if (navItem.loadingType === 'loading') {
				return;
			}
			navItem.loadingType = 'loading';
			// 获取列表
			this.$api.get({
				url: '/wanlshop/order/getOrderList',
				data: {
					state: state,
					page: navItem.current_page
				},
				success: res => {
					navItem.current_page = res.current_page; //当前页码
					if (res.last_page === res.current_page) {
						navItem.loadingType = 'noMore';
					} else {
						navItem.loadingType = 'more';
						navItem.current_page++;
					}
					let orderList = res.data.filter(item => {
						//添加不同状态下订单的表现形式
						item = Object.assign(item, this.orderStateExp(item.state));
						//演示数据所以自己进行状态筛选
						if (state === 0) {
							//0为全部订单
							return item;
						}
						return item.state === state;
					});
					orderList.forEach(item => {
						navItem.orderList.push(item);
					});
					//loaded新字段用于表示数据加载完毕，如果为空可以显示空白页
					this.$set(navItem, 'loaded', true);
				}
			});
		},

		//swiper 切换
		changeTab(e) {
			this.tabCurrentIndex = e.target.current;
			this.loadData('tabChange');
		},
		//顶部tab点击
		tabClick(index) {
			this.tabCurrentIndex = index;
		},
		//删除订单
		deleteOrder(order_id, key) {
			uni.showLoading({
				title: '请稍后'
			});
			this.$api.post({
				url: '/wanlshop/order/delOrder',
				data: {
					id: order_id
				},
				success: res => {
					this.navList[this.tabCurrentIndex].orderList.splice(key, 1);
					uni.hideLoading();
				}
			});
		},
		//取消订单- 设置为7 -全局
		cancelOrder(item) {
			uni.showLoading({
				title: '请稍后'
			});
			// 获取列表
			this.$api.post({
				url: '/wanlshop/order/cancelOrder',
				data: {
					id: item.id
				},
				success: res => {
					let { stateTip, stateTipColor } = this.orderStateExp(7);
					item = Object.assign(item, {
						state: 7,
						stateTip,
						stateTipColor
					});
					this.$store.commit('statistics/order', {
						pay: this.$store.state.statistics.order.pay - 1
					});
					// 取消订单后删除待付款中该项，并修改全部中的状态 1.0.2升级
					let list = this.navList[1].orderList;
					let index = list.findIndex(val => val.id === item.id);
					index !== -1 && list.splice(index, 1);
					// 删除后修改全部中的为7
					if (this.tabCurrentIndex == 1) {
						let list = this.navList[0].orderList;
						let index = list.findIndex(val => val.id === item.id);
						if (index !== -1) {
							list[index].state = 7;
						}
					}
					uni.hideLoading();
				}
			});
		},
		commentOrder(id){
			this.$wanlshop.to('/pages/user/order/comment?order_id=' + id);
		},
		//支付订单
		paymentOrder(id){
			this.$wanlshop.to('/pages/user/money/pay?order_id=' + id);
		},
		//确认收货- 全局
		confirmOrder(item){
			uni.showLoading({
				title: '请稍后'
			});
			// 获取列表
			this.$api.post({
				url: '/wanlshop/order/confirmOrder',
				data: {
					id: item.id
				},
				success: res => {
					let { stateTip, stateTipColor } = this.orderStateExp(4);
					item = Object.assign(item, {
						state: 4,
						stateTip,
						stateTipColor
					});
					this.$store.commit('statistics/order', {
						receiving: this.$store.state.statistics.order.receiving - 1,
						evaluate: this.$store.state.statistics.order.evaluate + 1
					});
					uni.hideLoading();
				}
			});
		},
		//订单状态文字和颜色
		orderStateExp(state) {
			let stateTip = '',
				stateTipColor = '#ff5000';
			switch (+state) {
				case 1:
					stateTip = '等待支付';
					break;
				case 2:
					stateTip = '等待卖家发货';
					break;
				case 3:
					stateTip = '卖家已发货';
					break;
				case 4:
					stateTip = '交易成功';
					break;
				case 5:
					stateTip = '交易成功';
					break;
				case 6:
					stateTip = '已完成';
					break;
				case 7:
					stateTip = '订单已关闭';
					stateTipColor = '#909399';
					break;
				//更多自定义
			}
			return {
				stateTip,
				stateTipColor
			};
		},
		getRefund(status) {
			return ["退款", "退款中", "待退货", "退款完成", "退款关闭", "退款被拒"][status];
		},
		// 修改地址
		editAddress(id) {
			this.$wanlshop.to('/pages/user/address/address?source=2&order_id=' + id);
		},
		//添加或修改成功之后回调
		async refreshList(address_id, order_id) {
			uni.showLoading({
				title: '正在提交新地址'
			});
			// 获取列表
			this.$api.post({
				url: '/wanlshop/order/editOrderAddress',
				data: {
					id: order_id,
					address_id: address_id
				},
				success: res => {
					this.$wanlshop.msg('地址修改成功');
					uni.hideLoading();
				}
			});
		}
	}
};
</script>

<style>
page {
	height: 100%;
}
</style>
