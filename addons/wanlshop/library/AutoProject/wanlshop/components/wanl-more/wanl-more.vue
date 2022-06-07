<template>
	<view>
		<view class="wanl-content">
			<!-- 商品内容 -->
			<view class="flex flex-wrap justify-between" v-if="goods.length != 0">
				<view class="item radius-bock bg-bgcolor margin-bottom-bj" v-for="(item,index) in goodsData" :key="item.id" @tap="onGoods(item.id)">
					<view class="img">
						<image :src="$wanlshop.oss(item.image, 180, 180)" mode=""></image>
					</view>
					<view class="padding-sm">
						<view class="text-cut-2">
							{{item.title}}
						</view>
						<view class="margin-top-xs">
							<text class="text-price text-orange text-bold">{{item.price}}</text>
						</view>
					</view>
				</view>
			</view>
			<!-- 文本内容 -->
			<view v-if="content" :class="[iSinfo ? 'put' : '']">
				<rich-text :nodes="content"></rich-text>
			</view>
			<!-- 按钮 -->
			<view class="text-center text-sm more" v-if="iSmore" @tap="showinfo">
				<view v-if="iSinfo"> 展开更多 <text class="wlIcon-fanhui4 margin-left-sm"></text> </view>
				<view v-else> 收起更多 <text class="wlIcon-fanhui3 margin-left-sm"></text> </view>
			</view>
		</view>
	</view>
</template>

<script>
/**
 * WanlMore 展开更多
 * @description 缺省页组件 福建度虎科技有限公司 https://www.wanlshop.com（除万联官方内嵌系统，未经授权严禁使用）
 * @著作权：WanlShop 登记号：2020SR0255711 版本：V1.0.0
 *
 * @property {String} text 文本内容
 * @property {Object} goods 商品列表
 *
 * @example <wanl-more content="" goods=""/>
 */
export default {
	name: 'WanlMore',
	props: {
		content: {
			type: String,
			default: ''
		},
		goods: {
			type: Array,
			default: function() {
				return [];
			}
		}
	},
	data() {
		return {
			iSmore: false,
			iSinfo: false,
			goodsData: [],
			quantity: 4,
			height: 0
		};
	},
	mounted() {
		if (this.goods.length != 0) {
			if (this.goods.length > this.quantity) {
				this.iSmore = true;
				this.iSinfo = true;
				this.goodsData = this.goods.slice(0, this.quantity);
			}else{
				this.goodsData = this.goods.slice(0, this.quantity);
			}
		}
		if (this.content) {
			this.selectView();
		}
	},
	methods: {
		showinfo() {
			this.iSinfo = !this.iSinfo;
			this.goodsData = this.iSinfo ? this.goods.slice(0, this.quantity) : this.goods;
		},
		selectView() {
			const query = uni.createSelectorQuery().in(this);
			query.select('.wanl-content').boundingClientRect(data => {
				if (data.height > 63) {
					this.iSinfo = true;
					this.iSmore = true;
				}
			}).exec();
		}
	}
};
</script>

<style>
.wanl-content .item {
	width: calc(50% - 12rpx);
}
.wanl-content .item .img {
	width: 100%;
	height: 360rpx;
	background-color: #f9f9f9;
}
.wanl-content .item .img image{
	height: 360rpx;
}



.wanl-content .put {
	width: 100%;
	/* #ifdef APP-PLUS */
	height: 128rpx;
	/* #endif */
	overflow: hidden;
	text-overflow: ellipsis;
	display: -webkit-box;
	-webkit-box-orient: vertical;
	-webkit-line-clamp: 3;
	-webkit-mask: -webkit-gradient(linear, left 30%, left bottom, from(#000), to(transparent));
}
.wanl-content .more {
	height: 60rpx;
	line-height: 60rpx;
	color: #adadad;
}
</style>
