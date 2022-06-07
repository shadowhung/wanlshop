<template>
	<view class="wanl-order-list">
		<view class="navbar">
			<view class="nav-item text-df" v-for="(item, index) in navList" :key="index" :class="{ current: tabCurrentIndex === index }" @tap="tabClick(index)"> {{ item.text }} </view>
		</view>
		<swiper :current="tabCurrentIndex" style="height: calc(100% - 60rpx)" duration="300" @change="changeTab">
			<swiper-item class="tab-content" v-for="(tag, key) in navList" :key="key">
				<scroll-view class="list-scroll-content" scroll-y @scrolltolower="loadData">
					<!-- 空白页 -->
					<wanl-empty text="没有找到任何优惠券" src="ticket_default3x" v-if="tag.loaded === true && tag.cardList.length === 0"/>
					<!-- 订单列表 -->
					<view class="wanl-coupon">
						<view v-for="(coupon, seat) in tag.cardList" :key="seat" :class="coupon.type" class="item margin-bj radius-bock"  @tap="onDetails(coupon)">
							<image :src="$wanlshop.appstc('/coupon/bg_coupon_3x.png')" class="coupon-bg"></image>
							<image :src="$wanlshop.appstc('/coupon/img_couponcentre_received_3x.png')" class="coupon-sign" v-if="coupon.state"></image>
							<view class="item-left">
								<block v-if="coupon.type == 'reduction' || (coupon.type == 'vip' && coupon.usertype == 'reduction')">
									<view class="colour">
										<text class="text-price"></text>
										<text class="price">{{Number(coupon.price)}}</text>
									</view>
									<view class="cu-tag wanl-gray-dark radius text-sm">
										满{{Number(coupon.limit)}}减{{Number(coupon.price)}}
									</view>
								</block>
								<block v-if="coupon.type == 'discount' || (coupon.type == 'vip' && coupon.usertype == 'discount')">
									<view class="colour">
										<text class="price">{{Number(coupon.discount)}}</text>
										<text class="discount">折</text>
									</view>
									<view class="cu-tag wanl-gray-dark radius text-sm">
										满{{Number(coupon.limit)}}打{{Number(coupon.discount)}}折
									</view>
								</block>
								<block v-if="coupon.type == 'shipping'">
									<view class="colour">
										<text class="price">包邮</text>
									</view>
									<view class="cu-tag wanl-gray-dark radius text-sm">
										满{{Number(coupon.limit)}}元包邮
									</view>
								</block>
							</view>
							<view class="item-right padding-bj">
								<view class="shop" @tap="onShop(coupon.shop_id)">
									<view class="name">
										<text class="wlIcon-dianpu margin-right-xs"></text> {{coupon.shop.shopname}}
									</view>
									<view>
										<text class="wlIcon-fanhui2"></text>
									</view>
								</view>
								<view class="title">
									<view class="cu-tag sm radius margin-right-xs tagstyle">
										{{coupon.type_text}}
									</view>
									<text class="text-cut wanl-gray text-min">{{coupon.name}}</text>
								</view>
								<view class="content text-min">
									<view class="wanl-gray">
										
										<view v-if="coupon.grant != '-1'">
											<text class="wlIcon-dot"></text>目前仅剩余 {{coupon.surplus}} 张
										</view>
										
										<view v-if="coupon.drawlimit != 0">
											<text class="wlIcon-dot"></text>每人仅限领取 {{coupon.drawlimit}} 张
										</view>
										<block v-if="coupon.pretype == 'fixed'">
											<view>
												<text class="wlIcon-dot"></text>生效 {{coupon.startdate}}
											</view>
											<view>
												<text class="wlIcon-dot"></text>结束 {{coupon.enddate}}
											</view>
										</block>
										<block v-if="coupon.pretype == 'appoint'">
											<view v-if="coupon.validity == 0">
												<text class="wlIcon-dot"></text>未使用前 永久 有效
											</view>
											<view v-else>
												<text class="wlIcon-dot"></text>领取后 {{coupon.validity}} 天有效
											</view>
										</block>
									</view>
									<view class="cu-btn sm round line-colour" @tap.stop="onApply(coupon.id)" v-if="coupon.state">
										立即使用
									</view>
									<view class="cu-btn sm round" @tap.stop="onReceive(key,seat)" v-else>
										立即领取
									</view>
								</view>
							</view>
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
					type: 'reduction',
					text: '满减券',
					loadingType: 'more',
					current_page: 1,
					cardList: []
				},
				{
					type: 'discount',
					text: '折扣券',
					loadingType: 'more',
					current_page: 1,
					cardList: []
				},
				{
					type: 'shipping',
					text: '包邮券',
					loadingType: 'more',
					current_page: 1,
					cardList: []
				}
			],
			contentText: {
				contentdown: ' ',
				contentrefresh: '正在加载...',
				contentnomore: ''
			}
		};
	},
	onLoad(options) {
		this.loadData();
	},
	methods: {
		//swiper 切换
		changeTab(e) {
			this.tabCurrentIndex = e.target.current;
			this.loadData('tabChange');
		},
		//顶部tab点击
		tabClick(index) {
			this.tabCurrentIndex = index;
		},
		//获取订单列表
		async loadData(source) {
			//这里是将订单挂载到tab列表下
			let index = this.tabCurrentIndex;
			let navItem = this.navList[index];
			let type = navItem.type;
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
				url: '/wanlshop/coupon/getList',
				data: {
					type: type,
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
					let cardList = res.data.filter(item => {
						item = Object.assign(item, {
							state: false
						});
						return item.type === type;
					});
					cardList.forEach(item => {
						navItem.cardList.push(item);
					});
					//loaded新字段用于表示数据加载完毕，如果为空可以显示空白页
					this.$set(navItem, 'loaded', true);
				}
			});
		},
		// 领取优惠券
		async onReceive(key,seat) {
			let coupon = this.navList[key].cardList[seat];
			this.$api.post({
				url: '/wanlshop/coupon/receive',
				loadingTip: '领取中',
				data: {
					id: coupon.id
				},
				success: res => {
					coupon.id = res.id;
					coupon.state = true;
					this.$wanlshop.msg(res.msg);
					this.$store.commit('statistics/dynamic', {
						coupon: this.$store.state.statistics.dynamic.coupon + 1
					});
				}
			});
		},
		onApply(id){
			this.$wanlshop.to(`/pages/user/coupon/apply?id=${id}&state=true`);
		},
		onDetails(data){
			// this.$wanlshop.to(`/pages/user/coupon/details?data=${JSON.stringify(data)}`);
		}
	}
};
</script>

<style>
page {
	height: 100%;
}
</style>
