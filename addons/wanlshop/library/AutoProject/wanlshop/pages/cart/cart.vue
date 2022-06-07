<template>
	<view>
		<!-- 导航条 -->
		<view class="cu-custom" :style="{height: wanlsys.height + 'px' }">
			<view class="cu-bar fixed bg-bgcolor" :style="{
				height: wanlsys.height + 'px', 
				paddingTop: wanlsys.top + 'px', 
				backgroundColor: common.appStyle.cart_nav_color ? common.appStyle.cart_nav_color : '#f7f7f7',
				backgroundImage: 'url(' + $wanlshop.oss(common.appStyle.cart_nav_image, 0, 50, 1, 'transparent', 'png') + ')',
				color: common.appStyle.cart_font_color == 'light' ? '#ffffff' : '#333333'
			}">
				<view class="action" @tap="operate()">
					<text v-if="cart.operate">完成</text>
					<text v-else>管理</text>
				</view>
				<view class="content" :style="{top: wanlsys.top + 'px'}">
					购物车
					<text class="text-sm">（共{{ cart.cartnum }}件商品）</text>
				</view>
			</view>
		</view>
		<block  v-if="cart.list.length > 0">
			<view class="wanl-cart-shop radius-bock margin-bj padding-bj" v-for="(item, index) in cart.list" :key="index">
				<view class="shop margin-bottom" @tap="onShop(item.shop_id)">
					<!-- 店铺选择 -->
					<view class="text-xxl margin-right-sm" @tap.stop="shopchoose(item)">
						<text v-if="item.check" class="wlIcon-xuanze-danxuan wanl-orange"></text>
						<text v-else class="wlIcon-xuanze wanl-gray-light"></text>
					</view>
					<view class="shopname">
						<text class="wlIcon-dianpu1 margin-right-xs"></text>
						<text class="text-30">{{ item.shop_name }}</text>
					</view>
					<view class="info"><text class="wlIcon-fanhui2 margin-left-xs"></text></view>
				</view>
				<view class="wanl-cart-goods" v-for="(goods, keys) in item.products" :key="keys">
					<!-- 商品选择 -->
					<view class="text-xxl margin-right-sm" @tap="choose({ index: index, keys: keys })">
						<text v-if="goods.checked" class="wlIcon-xuanze-danxuan wanl-orange"></text>
						<text v-else class="wlIcon-xuanze wanl-gray-light"></text>
					</view>
					<view class="picture" @tap="onGoods(goods.goods_id)"><image :src="$wanlshop.oss(goods.image, 100, 100 ,1)" mode="aspectFill"></image></view>
					<view class="content">
						<view class="text-cut-2 wanl-gray-dark" @tap="onGoods(goods.goods_id)">
							{{ goods.title }}
						</view>
						<view class="cu-tag wanl-gray opt">
							规格：{{ goods.sku.difference.join(" ")}}
						</view>
						<view class="flex justify-between align-center">
							<view class="text-price wanl-orange text-lg">{{ goods.sku.price }}</view>
							<view class="wanl-numberBox solid">
								<view @tap="bcsub(goods)"><text class="wlIcon-jian round text-gray"></text></view>
								<view>{{ goods.number }}</view>
								<view @tap="bcadd(goods)"><text class="wlIcon-tianjia round"></text></view>
							</view>
						</view>
					</view>
				</view>
			</view>
		</block>
		<block class="margin-bj padding-bj" v-else>
			<wanl-empty src="cart_default3x" text="哎呀，购物车空空如也！"/>
			<wanl-product :dataList="likeData"/>
		</block>
		<uni-load-more :status="status" :content-text="contentText" />
		<!-- #ifdef APP-PLUS -->
		<view style="height: 100rpx;"></view>
		<!-- #endif -->
		<view class="safeAreaBottom"></view>
		<!-- 操作栏 -->
		<view class="wanl-cart-foot fixedView solid-top edit" v-if="cart.operate">
			<view class="flex align-center" @tap="toCartchoose()">
				<view class="text-xxl">
					<text v-if="cart.status" class="wlIcon-xuanze-danxuan wanl-orange"></text>
					<text v-else class="wlIcon-xuanze wanl-gray-light"></text>
				</view>
				<view class="margin-left-sm"> <text>{{ cart.status ? '取消' : '全选' }}</text> </view>
			</view>
			<view class="flex">
				<button v-if="cart.allnum == 0" class="cu-btn round line-gray">移动关注</button>
				<button v-else class="cu-btn round line-orange" @tap="move()">移动关注</button>
				<button class="cu-btn round line-orange" @tap="toEmpty()">快速清理</button>
				<button v-if="cart.allnum == 0" class="cu-btn round line-gray">删除</button>
				<button v-else class="cu-btn round bg-gradual-orange" @tap="del()">删除</button>
			</view>
		</view>
		<view class="wanl-cart-foot fixedView solid-top account" v-else>
			<view class="flex align-center" @tap="toCartchoose()">
				<view class="text-xxl">
					<text v-if="cart.status" class="wlIcon-xuanze-danxuan wanl-orange"></text>
					<text v-else class="wlIcon-xuanze wanl-gray-light"></text>
				</view>
				<view class="margin-left-sm"> <text>{{ cart.status ? '取消' : '全选' }}</text> </view>
			</view>
			<view class="flex">
				<view class="text-sm text-right">
					<view> 合计： <text class="text-price wanl-orange text-lg">{{ cart.allsum }}</text> </view>
					<view> 不含运费 </view>
				</view>
				<button v-if="cart.allnum == 0" class="cu-btn round line-gray">去结算</button>
				<button v-else class="cu-btn round bg-gradual-orange" @tap="settlement()">去结算 ({{ cart.allnum }})</button>
			</view>
		</view>
	</view>
</template>

<script>
import { mapState, mapActions } from 'vuex';
export default {
	data() {
		return {
			wanlsys: this.$wanlshop.wanlsys(),
			reload: true,
			likeData: [],
			current_page: 1, //当前页码
			last_page: 1, //总页码
			status: 'loading',
			contentText: {
				contentdown: '',
				contentrefresh: '正在加载...',
				contentnomore: ''
			}
		};
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
	computed: {
		...mapState(['cart','common'])
	},
	onShow() {
		setTimeout(()=> {
			uni.setNavigationBarColor({  
				frontColor: this.$store.state.common.appStyle.cart_font_color == 'light'?'#ffffff':'#000000',  
				backgroundColor: this.$store.state.common.appStyle.cart_nav_color
		    })  
		}, 200);
	},
	onLoad() {
		// 加载猜你喜欢
		this.loadlikeData();
	},
	methods: {
		...mapActions({
			operate: 'cart/operate', // 管理购物车
			choose: 'cart/choose', // 选择商品
			shopchoose: 'cart/shopchoose', // 选择店铺
			bcadd: 'cart/bcadd', // 添加数量
			bcsub: 'cart/bcsub',// 减少数量
			move: 'cart/move', // 移动购物车
			settlement: 'cart/settlement', // 结算购物车
			del: 'cart/del' // 删除选中购物车
		}),
		async loadlikeData() {
			this.$api.get({
				url: '/wanlshop/product/likes?pages=cart',
				data: {
					page: this.current_page
				},
				success: res => {
					this.likeData = this.reload ? res.data : this.likeData.concat(res.data); //评论数据 追加
					this.current_page = res.current_page; //当前页码
					this.last_page = res.last_page; //总页码
					this.status = 'more';
				}
			});
		},
		// 禁止空购物车点击全选
		toCartchoose(){
			if (this.$store.state.cart.list.length == 0) {
				uni.showModal({
				    content: '购物车没有任何商品，马上去选一个心仪的商品吧~',
				    success: res => {
				        if (res.confirm) {
							this.$wanlshop.on('/pages/product/category/category');
				        }
				    }
				});
			}else{
				this.$store.dispatch('cart/cartchoose');
			}
		},
		toEmpty(){
			uni.showModal({
			    content: '确定清空购物车？',
			    success: res => {
			        if (res.confirm) {
						this.$store.dispatch('cart/empty');
			        }
			    }
			});
		}
	}
};
</script>

<style>
	.wanl-gray-light{
		color: #eee;
	}
	.wanl-cart-shop {
		background-color: #ffffff;
	}
	/* #ifndef MP-ALIPAY */
	.wanl-cart-shop radio::before,
	.wanl-cart-shop checkbox::before {
		margin-top: -7px;
		right: 1px;
	}
	.wanl-cart-shop radio .wx-radio-input,
	.wanl-cart-shop checkbox .wx-checkbox-input,
	.wanl-cart-shop radio .uni-radio-input,
	.wanl-cart-shop checkbox .uni-checkbox-input {
		margin: 0;
		width: 16px;
		height: 16px;
	}
	/* #endif */
	.wanl-cart-shop checkbox-group {
		margin-right: 25rpx;
	}

	.wanl-cart-shop .shop {
		position: relative;
		display: flex;
		justify-content: space-between;
		align-items: center;
	}

	.wanl-cart-shop .shop .shopname {
		position: absolute;
		display: flex;
		align-items: center;
		left: 60rpx;
	}

	.wanl-cart-shop .shop uni-checkbox .uni-checkbox-input {
		border: 1px solid #cccccc;
	}

	/* 商品 */
	.wanl-cart-goods {
		display: flex;
		align-items: center;
		margin-bottom: 30rpx;
	}

	.wanl-cart-goods:last-child {
		margin-bottom: 18rpx;
	}

	.wanl-cart-goods .picture {
		width: 180rpx;
		height: 180rpx;
	}

	.wanl-cart-goods .picture image {
		width: 180rpx;
		height: 180rpx;
		overflow: hidden;
		border-radius: 20rpx;
	}

	.wanl-cart-goods .content {
		padding-left: 25rpx;
		width: 100%;
	}

	.wanl-cart-goods .content .opt {
		font-size: 24rpx;
		padding: 0;
		color: #000000;
		height: 32rpx;
		background-color: #f6f6f6;
		font-weight: 300;
		margin-top: 10rpx;
		margin-bottom: 25rpx;
		border-radius: 4rpx;
	}

	.wanl-cart-goods .content .opt text {
		padding-right: 6rpx;
		padding-left: 10rpx;
	}

	/* 操作条 */
	.wanl-cart-foot {
		width: 100%;
		display: flex;
		align-items: center;
		justify-content: space-between;
		z-index: 997;
		min-height: 52px;
		background-color: #ffffff;
		padding: 0 25rpx;
	}
	.wanl-cart-foot.solid:after {
		
	}
	/* #ifndef MP-ALIPAY */
	.wanl-cart-foot radio:before,
	.wanl-cart-foot checkbox:before {
		margin-top: -7px;
		right: 1px;
	}

	.wanl-cart-foot radio .wx-radio-input,
	.wanl-cart-foot checkbox .wx-checkbox-input,
	.wanl-cart-foot radio .uni-radio-input,
	.wanl-cart-foot checkbox .uni-checkbox-input {
		margin: 0;
		width: 16px;
		height: 16px;
	}

	/* #endif */
	.wanl-cart-foot.account button {
		margin-left: 25rpx;
	}

	.wanl-cart-foot.edit button {
		margin-left: 20rpx;
	}

	.wanl-cart-foot.account .cu-btn {
		padding: 0 25rpx;
		font-size: 32rpx;
		height: 72rpx;
		margin-top: 6rpx;
		/* border-radius: 20rpx; */
	}

	.wanl-cart-foot.edit .cu-btn {
		padding: 0 30rpx;
		font-size: 24rpx;
		height: 56rpx;
	}
</style>
