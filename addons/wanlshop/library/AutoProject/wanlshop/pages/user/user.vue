<template>
	<view>
		<!-- #ifdef MP -->
		<view class="cu-custom text-white" :style="{color: common.appStyle.user_font_color == 'light'?'#ffffff':'#222222'}">
			<view class="cu-bar fixed" :style="{ height: wanlsys.height + 'px', paddingTop: wanlsys.top + 'px' }">
				<view class="action mp text-bold">
					<text class="wlIcon-shezhi" style="margin-right: 0.6em;" @tap="$wanlshop.auth('/pages/user/setting/setting')"></text>
					<text class="wlIcon-shiyongbangzhu1" @tap="help"></text>
				</view>
				<!-- 背景 -->
				<view class="bar-bg" v-if="headerOpacity > 0" :style="{ 
					height: wanlsys.height + 'px', 
					opacity: headerOpacity,
					backgroundColor: common.appStyle.user_nav_color?common.appStyle.user_nav_color:'#f7f7f7',
					backgroundImage: 'url(' + $wanlshop.oss(common.appStyle.user_nav_image, 414, 0, 1, 'transparent', 'png') + ')'
				}"></view>
			</view>
		</view>
		<!-- #endif -->
		<!-- #ifndef MP -->
		<view class="cu-custom" :style="{color: common.appStyle.user_font_color == 'light'?'#ffffff':'#222222'}">
			<view class="cu-bar fixed" :style="{ height: wanlsys.height + 'px', paddingTop: wanlsys.top + 'px' }">
				<view class="text-lg" @tap="$wanlshop.auth('/pages/user/setting/user')">
					<view v-if="headerOpacity == 1">
						<view class="cu-avatar round margin-right-xs" :style="{ backgroundImage: 'url(' + $wanlshop.oss(user.avatar, 35, 35, 2, 'avatar') + ')' }"></view>
						<text v-if="user.isLogin">{{ user.nickname }}</text>
						<text v-else>登录 / 注册</text>
					</view>
				</view>
				<!-- 背景 -->
				<view class="bar-bg" v-if="headerOpacity > 0" :style="{ 
					height: wanlsys.height + 'px', 
					opacity: headerOpacity,
					backgroundColor: common.appStyle.user_nav_color?common.appStyle.user_nav_color:'#f7f7f7',
					backgroundImage: 'url(' + $wanlshop.oss(common.appStyle.user_nav_image, 0, 50, 1, 'transparent', 'png') + ')',
					color: common.appStyle.user_font_color == 'light'?'#ffffff':'#222222'
				}"></view>
				<view class="action">
					<block>
						<text class="wlIcon-erweima" @tap="$wanlshop.auth('/pages/user/qrcode/qrcode')"></text>
						<text class="margin-right text-sm" @tap="$wanlshop.auth('/pages/user/qrcode/qrcode')">会员码</text>
					</block>
					<text class="wlIcon-shezhi" @tap="$wanlshop.auth('/pages/user/setting/setting')"></text>
					<text class="wlIcon-xiaoxizhongxin" @tap="$wanlshop.to('/pages/notice/notice')"></text>
					<view class="cu-tag badge" v-if="statistics.notice.notice +statistics.notice.order +statistics.notice.chat > 0">{{ statistics.notice.notice +statistics.notice.order +statistics.notice.chat }}</view>
				</view>
			</view>
		</view>
		<!-- #endif -->
		<view class="wanl-user" :style="{ 
			backgroundColor: common.appStyle.user_bg_color?common.appStyle.user_bg_color:'#f7f7f7',
			backgroundImage: 'url(' + $wanlshop.oss(common.appStyle.user_bg_image, 414, 0, 1, 'transparent', 'png') + ')',
			color: common.appStyle.user_font_color == 'light'?'#ffffff':'#222222'}">
			
			<view class="user" :style="{ paddingTop: wanlsys.height + 'px' }">
				<view class="avatar margin-right-bj" @tap="portrai"><image :src="$wanlshop.oss(user.avatar, 62, 62, 2, 'avatar')" mode="widthFix"></image></view>
				<view class="content" v-if="user.isLogin">
					<view class="text-xxl" @tap="$wanlshop.auth('/pages/user/setting/user')">{{ user.nickname }}</view>
					<view class="text-sm" @tap="$wanlshop.auth('/pages/user/signin/signin')">
						<view class="cu-tag sm radius bg-orange">
							Lv {{ user.level }}
						</view>
						<view class="cu-tag sm radius bg-orange">
							用户积分 {{ user.score }}
						</view>
					</view>
				</view>
				<view class="content" @tap="$wanlshop.auth('/pages/user/user')" v-else>
					<view class="text-xxl">登录 / 注册</view>
					<view class="cu-tag bg-orange sm radius">Hi</view>
					<view class="cu-tag bg-orange sm radius">欢迎登录</view>
				</view>
			</view>
			<view class="operate">
				<view class="text-min" @tap="$wanlshop.auth('/pages/user/collect')">
					<text class="text-bold">{{ statistics.dynamic.collection }}</text>
					收藏夹
				</view>
				<view class="text-min" @tap="$wanlshop.auth('/pages/user/follow')">
					<text class="text-bold">{{ statistics.dynamic.concern }}</text>
					关注店铺
				</view>
				<view class="text-min" @tap="$wanlshop.auth('/pages/user/footprint')">
					<text class="text-bold">{{ statistics.dynamic.footprint }}</text>
					足迹
				</view>
				<view class="text-min" @tap="$wanlshop.auth('/pages/user/order/order')">
					<text class="text-bold">{{ $wanlshop.toFormat(statistics.order.pay+statistics.order.delive+statistics.order.receiving+statistics.order.evaluate, 'hundred') }}</text>
					全部订单
				</view>
				
			</view>
			<view class="activity padding-bj">
				<view class="bg-white radius grid text-center col-2 padding-lr-bj padding-tb-sm">
					<view class="solid-right flex justify-between" @tap="$wanlshop.auth('/pages/user/coupon/list')">
						<view class="content">
							<view class="wanl-black text-sm text-bold6">红包卡券</view>
							<view class="text-min text-orange">
								领取优惠券
								<text class="wlIcon-fanhui2 margin-left-xs"></text>
							</view>
						</view>
						<view class="cu-avatar" :style="{ backgroundImage: 'url(' + $wanlshop.appstc('/user/icon_card_bag.png') + ')' }"></view>
					</view>
					<view class="flex justify-between" @tap="$wanlshop.auth('/pages/user/signin/log')">
						<view class="content margin-left-bj">
							<view class="wanl-black text-sm text-bold6">我的积分</view>
							<view class="text-min text-orange">
								查看积分明细
								<text class="wlIcon-fanhui2 margin-left-xs"></text>
							</view>
						</view>
						<view class="cu-avatar" :style="{ backgroundImage: 'url(' + $wanlshop.appstc('/user/icon_super_vip.png') + ')' }"></view>
					</view>
				</view>
			</view>
		</view>
		
		<view class="wanl-user-order padding-sm margin-bj">
			<view class="project text-min wanl-gray-dark">
				<view @tap="$wanlshop.auth('/pages/user/order/order?state=1')">
					<text class="wlIcon-31daifukuan wanl-pip"></text>
					待支付
					<view class="cu-tag badge bg-orange" v-if="statistics.order.pay > 0">{{ $wanlshop.toFormat(statistics.order.pay, 'hundred') }}</view>
				</view>
				<view @tap="$wanlshop.auth('/pages/user/order/order?state=2')">
					<text class="wlIcon-31daifahuo wanl-pip"></text>
					待发货
					<view class="cu-tag badge bg-orange" v-if="statistics.order.delive > 0">{{ $wanlshop.toFormat(statistics.order.delive, 'hundred') }}</view>
				</view>
				<view @tap="$wanlshop.auth('/pages/user/order/order?state=3')">
					<text class="wlIcon-31daishouhuo wanl-pip"></text>
					待收货
					<view class="cu-tag badge bg-orange" v-if="statistics.order.receiving > 0">{{ $wanlshop.toFormat(statistics.order.receiving, 'hundred') }}</view>
				</view>
				<view @tap="$wanlshop.auth('/pages/user/order/order?state=4')">
					<text class="wlIcon-31daipingjia wanl-pip"></text>
					待评价
					<view class="cu-tag badge bg-orange" v-if="statistics.order.evaluate > 0">{{ $wanlshop.toFormat(statistics.order.evaluate, 'hundred') }}</view>
				</view>
				<view class="solid-left" @tap="$wanlshop.auth('/pages/user/refund/lists')">
					<text class="wlIcon-31youhuiquan wanl-orange"></text>
					退货/售后
					<view class="cu-tag badge bg-orange" v-if="statistics.order.customer > 0">{{ $wanlshop.toFormat(statistics.order.customer, 'hundred') }}</view>
				</view>
			</view>
			<!-- <view class="logistics margin-top-bj padding-sm" v-if="statistics.logistics.length > 0">
				<swiper vertical autoplay circular disable-touch interval="4000" class="swiper">
					<swiper-item @tap="$wanlshop.auth('/pages/notice/logistics/details')">
						<view class="title">
							<view class="text-min">最新物流</view>
							<view class="text-min">18:00</view>
						</view>
						<view class="flex align-center">
							<view class="cu-avatar" :style="{ backgroundImage: 'url(' + $wanlshop.oss(user.avatar, 40, 40) + ')' }"></view>
							<view class="content">
								<view class="text-df">
									<text class="wlIcon-paisongtixing"></text>
									派送中
								</view>
								<view class="text-sm">【自提柜】已签收，签收人凭取件码 已取件。</view>
							</view>
						</view>
					</swiper-item>
				</swiper>
			</view> -->
		</view>
		
		<view class="wanl-user-order padding-sm margin-bj" style="margin-top: 25rpx;">
			<view class="project text-min wanl-gray-dark">
				<view style="line-height: 1.8;" @tap="$wanlshop.auth('/pages/user/coupon/mycard')">
					<view class="wanl-pip text-lg text-bold6">{{ statistics.dynamic.coupon }}</view>
					我的卡券
				</view>
				<view style="line-height: 1.8;" @tap="$wanlshop.auth('/pages/user/money/money')">
					<view class="wanl-pip text-lg text-bold6">{{ user.money?user.money:'0.00' }}</view>
					余额
				</view>
				<view style="line-height: 1.8;" @tap="$wanlshop.auth('/pages/user/bank/bank')">
					<view class="wanl-pip text-lg text-bold6">{{ statistics.dynamic.accountbank }}</view>
					银行卡
				</view>
				<view style="line-height: 1.8;" @tap="$wanlshop.auth('/pages/user/signin/log')">
					<view class="wanl-pip text-lg text-bold6">{{ user.score?user.score:0 }}</view>
					积分
				</view>
				<view class="solid-left" @tap="$wanlshop.auth('/pages/user/money/list')">
					<text class="wlIcon-hongbao wanl-orange"></text>
					账单明细
				</view>
			</view>
		</view>
		
		<view class="wanl-user-tool padding-top-bj margin-lr-bj">
			<view class="list text-min grid col-5 wanl-gray-dark">
				<view @tap="$wanlshop.auth('/pages/user/money/money')">
					<text class="wlIcon-youhuiquantuangou wanl-orange"></text>
					钱包
				</view>
				<view @tap="$wanlshop.auth('/pages/user/comment/comment')">
					<text class="wlIcon-icon_pinglun wanl-text-red"></text>
					评论
				</view>
				<!-- <view @tap="$wanlshop.auth('/pages/user/distribution/distribution')">
					<text class="wlIcon-fenxiao wanl-text-yellow"></text>
					分销
				</view>
				<view @tap="$wanlshop.auth('/pages/user/order/group')">
					<text class="wlIcon-youhuiquantuangou wanl-text-yellow"></text>
					拼团订单
				</view>
				<view @tap="$wanlshop.auth('/pages/user/order/bargain')">
					<text class="wlIcon-jiage wanl-text-light-blue"></text>
					我的砍价
				</view> -->
				<view @tap="$wanlshop.auth('/pages/user/address/address')">
					<text class="wlIcon-dizhi wanl-text-yellow"></text>
					收货地址
				</view>
				<view @tap="$wanlshop.auth('/pages/user/signin/signin')">
					<text class="wlIcon-mianxing-rili wanl-orange"></text>
					签到
				</view>
				<view @tap="$wanlshop.auth('/pages/user/feedback/lists')">
					<text class="wlIcon-pingjiazongjie wanl-text-blue"></text>
					反馈
				</view>
				<view @tap="help">
					<text class="wlIcon-bangzhu3 wanl-text-green"></text>
					帮助中心
				</view>
				<view @tap="$wanlshop.auth('/pages/user/complaint/lists')">
					<text class="wlIcon-31guanzhuxuanzhong wanl-text-light-blue"></text>
					我的举报
				</view>
				<view @tap="$wanlshop.auth('/pages/user/service')">
					<text class="wlIcon-icon-service wanl-text-purple"></text>
					智能小蜜
				</view>
				<view @tap="setting">
					<text class="wlIcon-shezhi1 wanl-text-green"></text>
					设置
				</view>
			</view>
		</view>
		<view class="wanl-you-like" :style="{ backgroundImage: 'url(' + $wanlshop.appstc('/common/guess_you_like_it.png') + ')' }"></view>
		<wanl-product :dataList="likeData"/>
		<uni-load-more :status="status" :content-text="contentText" />
		<view class="edgeInsetBottom"></view>
	</view>
</template>

<script>
import { mapState } from 'vuex';
export default {
	data() {
		return {
			wanlsys: this.$wanlshop.wanlsys(),
			headerOpacity: 0,
			// 上拉刷新
			reload: true,
			likeData: [],
			current_page: 1, //当前页码
			last_page: 1, //总页码
			status: 'loading',
			contentText: {
				contentdown: ' ',
				contentrefresh: '正在加载...',
				contentnomore: '没有更多数据了'
			}
		};
	},
	computed: {
		...mapState(['user', 'statistics','common'])
	},
	onPullDownRefresh() {
		this.loadData();
	},
	onShow() {
		setTimeout(()=> {
			uni.setNavigationBarColor({  
				frontColor: this.$store.state.common.appStyle.user_font_color == 'light'?'#ffffff':'#000000',  
				backgroundColor: this.$store.state.common.appStyle.user_nav_color
		    })  
		}, 200);
	},
	onLoad() {
		this.loadlikeData();
	},
	onPageScroll(e) {
		let tmpY = 50;
		e.scrollTop = e.scrollTop > tmpY ? 50 : e.scrollTop; //如果当前高度大于250则250否则当前高度
		this.headerOpacity = e.scrollTop * (1 / tmpY); //$headerOpacity 赋值当前高度x（1÷250）
	},
	onReachBottom() {
		//判断是否最后一页
		if (this.current_page >= this.last_page) {
			this.status = 'noMore';
		} else {
			this.reload = false;
			this.current_page = this.current_page + 1; //页码+1
			this.status = 'loading';
			this.loadlikeData();
		}
	},
	methods: {
		async loadData() {
			this.$api.post({
				url: '/wanlshop/user/refresh',
				success: res => {
					this.$store.commit('statistics/edit', res);
				}
			});
			uni.stopPullDownRefresh();
		},
		// 滚动底部加载猜你喜欢
		async loadlikeData() {
			this.$api.get({
				url: '/wanlshop/product/likes?pages=user',
				data: {
					page: this.current_page
				},
				success: res => {
					this.likeData = this.reload ? res.data : this.likeData.concat(res.data); //评论数据 追加
					this.current_page = res.current_page; //当前页码
					this.last_page = res.last_page; //总页码
					this.status = res.total == 0 ? 'noMore' : 'more';
				}
			});
		},
		// 帮助
		help() {
			this.$wanlshop.to('/pages/user/help');
		},
		// 设置
		setting() {
			this.$wanlshop.to('/pages/user/setting/setting');
		},
		portrai() {
			this.$wanlshop.to('/pages/user/portrait/portrait');
		}
	}
};
</script>

<style>
.cu-bar .action.mp:first-child > text[class*='wlIcon-'] {
	margin-left: 0;
}

.wanl-user {
	background-repeat: no-repeat;
	background-size: 100%;
	position: relative;
}

.wanl-user .user {
	display: flex;
	align-items: center;
	justify-content: space-between;
	padding: 0 30rpx;
	padding-bottom: 30rpx;
}

.wanl-user .user .avatar {
	position: relative;
	height: 123rpx;
	width: 123rpx;
	border-radius: 50%;
	overflow: hidden;
	border: 3px solid rgba(255, 255, 255, .25);
}

.wanl-user .user .avatar image {
	height: 120rpx;
}

.wanl-user .user .avatar .tag {
	position: absolute;
	bottom: 0;
	right: 0;
}

.wanl-user .user .content {
	flex: 1;
}

/* 操作 */
.wanl-user .operate {
	display: flex;
	justify-content: space-around;
	text-align: center;
	padding-bottom: 70rpx;
	line-height: 1.3;
}

.wanl-user .operate text {
	display: block;
	font-size: 32rpx;
}

/* 活动 */
.wanl-user .activity {
	position: absolute;
	width: 100%;
	bottom: -80rpx;
}

.wanl-user .activity .radius {
	border-radius: 24rpx;
}

.wanl-user .activity .cu-avatar {
	width: 69rpx;
	height: 69rpx;
	margin-right: 30rpx;
	background-color: transparent;
	/* border: 1px solid rgba(255,255,255,.6); */
}

.wanl-user .activity .content {
	text-align: left;
	height: 68rpx;
}

/* 订单 */
.wanl-user-order {
	margin-top: 80rpx;
	border-radius: 24rpx;
	background-color: white;
}

.wanl-user-order .title {
	display: flex;
	justify-content: space-between;
	align-items: flex-end;
}

.wanl-user-order .title text {}



/* 状态 */
.wanl-user-order .project {
	display: flex;
	justify-content: space-around;
	text-align: center;
}

.wanl-user-order .project>view {
	position: relative;
	flex: 1;
}

.wanl-user-order .project>view .cu-tag {
	top: -4rpx;
	right: 26rpx;
}

.wanl-user-order .project text {
	display: block;
	font-size: 50rpx;
	margin-bottom: 6rpx;
}

/* 物流 */
.wanl-user-order .logistics {
	background-color: #f9f9f9;
	border-radius: 24rpx;
}

.wanl-user-order .logistics .swiper {
	height: 120rpx;
}

.wanl-user-order .logistics .swiper .title {
	display: flex;
	justify-content: space-between;
	margin-bottom: 10rpx;
	color: #999999;
}

.wanl-user-order .logistics .swiper .cu-avatar {
	margin-right: 10rpx;
	height: 66rpx;
	width: 66rpx;
	border-radius: 12rpx;
	background-color: #ffffff;
}

.wanl-user-order .logistics .swiper .content .text-df {
	color: #3797e0;
	font-size: 27rpx;
	margin-bottom: 2rpx;
}

.wanl-user-order .logistics .swiper .content .text-sm {
	color: #999999;
}

.wanl-user-order .logistics .swiper .content text {
	font-size: 32rpx;
	margin-left: 15rpx;
	margin-right: 10rpx;
}

/* 工具箱 */
.wanl-user-tool {
	background-color: #ffffff;
	border-radius: 24rpx;
}

.wanl-user-tool .title {
	display: flex;
	justify-content: space-between;
	align-items: flex-end;
}

.wanl-user-tool .title text {
	margin-left: 2rpx;
}

/* 状态 */
.wanl-user-tool .list {
	text-align: center;
}

.wanl-user-tool .list>view {
	margin-bottom: 28rpx;
}

.wanl-user-tool .list text {
	display: block;
	font-size: 54rpx;
	margin-bottom: 8rpx;
}
</style>
