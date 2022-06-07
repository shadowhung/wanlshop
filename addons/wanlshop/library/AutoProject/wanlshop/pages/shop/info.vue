<template>
	<view class="wanl-shop">
		<view class="edgeInsetTop"></view>
		<view class="shop_synopsis bg-white">
			<view class="margin-left-bj shopuser">
				<view class="cu-avatar round margin-right lg" :style="{backgroundImage: 'url('+ $wanlshop.oss(shopData.avatar, 52, 52, 2, 'avatar') +')'}"></view>
				<view class="">
					<view class="text-df">{{shopData.shopname || '加载中...'}}</view>
					<view class="wanl-gray text-min">粉丝数 {{shopData.like}}</view>
					<view class="wanl-gray text-min">{{shopData.city}}</view>
				</view>
			</view>
			<view class="margin-right-bj cu-btn round wanl-bg-orange margin-top"  @tap="follow">
				<text v-if="shopData.follow">已关注</text>
				<view v-else><text class="wlIcon-yiguanzhu1"></text>  关注</view>
			</view>
		</view>
		<view class="shop_info bg-white margin-top-bj padding-lr-bj">
			<view class="padding-tb-bj solid-bottom"> 店铺介绍 </view>
		</view>
		<view class="bg-white padding-bj">
			<rich-text :nodes="shopData.bio"></rich-text>
		</view>
	</view>
</template>

<script>
	export default {
		data() {
			return {
				shopData: {}
			}
		},
		onLoad(option) {
			this.loadPageData(option.shop_id); 
		},
		methods: {
			async loadPageData(shop_id) {
				this.$api.get({
					url: '/wanlshop/shop/page',
					data: {
						id: shop_id
					},
					success: res => {
						res.shop.bio = res.shop.bio.replace(/<img/g, "<img style='display: block;'");
						this.shopData = res.shop;
					}
				});
			},
			// 关注
			async follow() {
				this.shopData.follow = !this.shopData.follow;
				if (this.shopData.follow) {
					this.shopData.like += 1;
				} else {
					this.shopData.like -= 1;
				}
				this.$api.post({
					url: '/wanlshop/shop/follow',
					data: {
						id: this.shopData.id
					},
					success: res => {
						this.shopData.follow = res;
					}
				});
			}
		}
	}
</script>

<style>

</style>

