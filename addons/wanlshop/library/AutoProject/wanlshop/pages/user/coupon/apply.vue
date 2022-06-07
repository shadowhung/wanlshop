<template>
	<view class="wanl-coupon">
		<view class="edgeInsetTop"></view>
		<view class="padding-bj bg-red text-black">
			<view :class="coupon.type" class="item radius-bock" @tap="onDetails(coupon)" v-if="coupon">
				<image :src="$wanlshop.appstc('/coupon/bg_coupon_3x.png')" class="coupon-bg"></image>
				<image :src="$wanlshop.appstc('/coupon/img_couponcentre_received_3x.png')" class="coupon-sign" v-if="coupon_state"></image>
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
					<view class="title">
						<view class="cu-tag sm radius margin-right-xs tagstyle">
							{{coupon.type_text}}
						</view>
						<text class="text-cut wanl-gray text-min">{{coupon.name}}</text>
					</view>
					<view class="content text-min">
						<view class="wanl-gray">
							<view>
								<text class="wlIcon-dot"></text>当前页面所有商品可用
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
						<view class="cu-btn sm round" @tap.stop="onReceive(coupon.id)" v-if="!coupon_state">
							立即领取
						</view>
					</view>
				</view>
			</view>
		</view>
		<view class="">
			<wanl-product :dataList="dataList"/>
		</view>
	</view>
</template>

<script>
	export default {
		data() {
			return {
				coupon_id: 0,
				coupon_state: false,
				coupon: null,
				dataList: [],
				reload: false, //判断是否上拉
				total: 0, //数据量
				current_page: 1, //当前页码
				last_page: 1, //总页码
				status: 'more',
				contentText: {
					contentdown: ' ',
					contentrefresh: '加载中',
					contentnomore: ''
				}
			}
		},
		onLoad(option) {
			this.coupon_id = option.id;
			this.coupon_state = option.state ? true : false;
			this.loadData();
		},
		onPullDownRefresh() {
			this.current_page = 1;
			this.reload = true;
			this.loadData();
		},
		onReachBottom() {
			//判断是否最后一页
			if (this.current_page >= this.last_page) {
				this.status = 'noMore';
			} else {
				this.reload = false;
				this.current_page = this.current_page + 1; //页码+1
				this.status = 'loading';
				this.loadData();
			}
		},
		methods: {
			//获取优惠券和商品列表
			async loadData() {
				this.$api.get({
					url: '/wanlshop/coupon/apply',
					data: {
						id: this.coupon_id,
						page: this.current_page
					},
					success: res => {
						uni.stopPullDownRefresh();
						this.coupon = res.coupon;
						this.dataList = this.reload ? res.goods.data : this.dataList.concat(res.goods.data); //数据 追加
						this.total = res.goods.total; //数据量
						this.current_page = res.goods.current_page; //当前页码
						this.last_page = res.goods.last_page; //总页码
						this.status = res.goods.total == 0 ? 'noMore' : 'more';
					}
				});
			},
			// 领取优惠券
			async onReceive(coupon_id) {
				this.$api.post({
					url: '/wanlshop/coupon/receive',
					loadingTip: '领取中',
					data: {
						id: coupon_id
					},
					success: res => {
						this.coupon_state = true;
						this.$wanlshop.msg(res);
						this.$store.commit('statistics/dynamic', {
							coupon: this.$store.state.statistics.dynamic.coupon + 1
						});
					}
				});
			}
		}
	}
</script>

<style>

</style>
