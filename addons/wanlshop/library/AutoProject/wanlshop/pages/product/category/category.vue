<template>
	<view class="category">
		<!-- 导航条 -->
		<view class="cu-custom" :style="{height: wanlsys.height + 'px' }">
			<view class="cu-bar fixed bg-white" :style="{ height: wanlsys.height + 'px', paddingTop: wanlsys.top + 'px'}">
				<view class="search-form round">
					<text class="wlIcon-sousuo1 text-bold"></text>
					<swiper class="search-swiper placeholder" vertical autoplay circular interval="3000">
						<swiper-item @tap="productSearch('')">搜索商品、类目</swiper-item>
						<swiper-item v-for="(item,index) in common.modulesData.searchModules" :key="item.keywords"  @tap="productSearch(item.keywords)">{{item.keywords}}</swiper-item>
					</swiper>
				</view>
				<!-- #ifndef MP -->
				<view class="action" @tap="showModal('menu')">
					<text class="wlIcon-gengduo"></text>
					<view class="cu-tag badge" v-if="( statistics.notice.notice + statistics.notice.order + statistics.notice.chat + statistics.order.pay + statistics.order.delive + statistics.order.receiving + statistics.order.evaluate + cart.cartnum ) > 0">{{( statistics.notice.notice + statistics.notice.order + statistics.notice.chat + statistics.order.pay + statistics.order.delive + statistics.order.receiving + statistics.order.evaluate + cart.cartnum )}}</view>
				</view>
				<!-- #endif -->
			</view>
		</view>
		<view class="wanl-category-one" v-if="common.appStyle.category_style == 1">
			<view class="margin-bottom-bj" v-for="(item,index) in common.modulesData.categoryModules" :key="item.id" @tap="productList(item.id, item.name)">
				<image :src="$wanlshop.oss(item.image, 350, 150)" class="list-image" />
				<view class="category-title">
					<view>{{ item.description }}</view>
					<text class="text-sm text-bold text-black">- {{ item.name }} -</text>
				</view>
			</view>
		</view>
		<view class="cu-list grid col-3 no-border" v-if="common.appStyle.category_style == 2">
			<view class="cu-item" v-for="(item,index) in common.modulesData.categoryModules" :key="item.id" @tap="productList(item.id, item.name)">
				<image :src="$wanlshop.oss(item.image, 80, 80)" class="list-image" />
				<text>{{ item.name }}</text>
			</view>
		</view>
		
		<view class="wanl-category two" v-if="common.appStyle.category_style == 3">
			<scroll-view scroll-y scroll-with-animation class="wanl-category-left" :scroll-top="scrollTop" :style="{ height: height + 'px' }">
				<view
					v-for="(item,index) in common.modulesData.categoryModules" :key="item.id"
					class="item"
					:class="[currentTab == index ? 'active' : '']"
					:data-current="index"
					@tap.stop="swichNav"
				>
					<text>{{ item.name }}</text>
				</view>
			</scroll-view>
			<block v-for="(item,index) in common.modulesData.categoryModules" :key="item.id">
				<scroll-view scroll-y class="wanl-category-right" :style="{ height: height + 'px'}" v-if="currentTab == index">
					<view class="list-cat">
						<swiper class="screen-swiper square-dot" indicator-dots circular autoplay interval="4000" duration="500" v-if="common.adData.categoryAdverts[item.id]">
							<swiper-item v-for="(adverts, adindex) in common.adData.categoryAdverts[item.id]" :key="adindex" @tap="onAdvert(adverts)">
								<image class="radius-bock" :src="$wanlshop.oss(adverts.media, 350, 0, 1)" mode="aspectFill"></image>
							</swiper-item>
						</swiper>
						<view class="padding-top-sm">
							<view class="list-item radius-bock">
								<view class="list-container">
									<view class="list-box" v-for="(categoryData, infokey) in item.childlist" :key="categoryData.id" @tap="productList(categoryData.id, categoryData.name)">
										<image :src="$wanlshop.oss(categoryData.image, 60, 60)" class="list-image" />
										<view class="text-sm">{{ categoryData.name }}</view>
									</view>
								</view>
							</view>
						</view>
					</view>
				</scroll-view>
			</block>
		</view>
		<view class="wanl-category" v-if="common.appStyle.category_style == 4">
			<scroll-view scroll-y scroll-with-animation class="wanl-category-left" :scroll-top="scrollTop" :style="{ height: height + 'px'}">
				<view
					v-for="(item,index) in common.modulesData.categoryModules" :key="item.id"
					class="item"
					:class="[currentTab == index ? 'active' : '']"
					:data-current="index"
					@tap.stop="swichNav"
				>
					<text>{{ item.name }}</text>
				</view>
				<view class="edgeInsetBottom"></view>
			</scroll-view>
			<block v-for="(item, index) in common.modulesData.categoryModules" :key="item.id">
				<scroll-view scroll-y class="wanl-category-right" :style="{ height: height + 'px' }" v-if="currentTab == index">
					<view class="list-cat">
						<swiper class="screen-swiper square-dot" indicator-dots circular autoplay interval="4000" duration="500" v-if="common.adData.categoryAdverts[item.id]">
							<swiper-item v-for="(adverts, adindex) in common.adData.categoryAdverts[item.id]" :key="adindex" @tap="onAdvert(adverts)">
								<image class="radius-bock" :src="$wanlshop.oss(adverts.media, 350, 0, 1)" mode="aspectFill"></image>
							</swiper-item>
						</swiper>
						<view class="padding-top-sm">
							<view class="list-item radius-bock" v-for="(childlist, childkey) in item.childlist" :key="childlist.id">
								<view class="flex justify-between text-sm" @tap="productList(childlist.id, childlist.name)">
									<text>{{childlist.name}}</text>
									<text class="wlIcon-fanhui2 wanl-gray-light"></text>
								</view>
								<view class="list-container">
									<view class="list-box" v-for="(categoryData, infokey) in childlist.childlist" :key="categoryData.id" @tap="productList(categoryData.id, categoryData.name)">
										<image :src="$wanlshop.oss(categoryData.image, 60, 60)" class="list-image" />
										<view class="text-sm">{{ categoryData.name }}</view>
									</view>
								</view>
							</view>
							<view class="edgeInsetBottom"></view>
						</view>
					</view>
				</scroll-view>
			</block>
		</view>
		<!-- 模态框 -->
		<view class="WANL-MODAL">
			<view class="cu-modal top-modal" :class="modalName == 'menu' ? 'show' : ''" @tap="hideModal">
				<view class="wanl-modal-menu cu-dialog" @tap.stop="">
					<wanl-direct  @change="hideModal"/>
				</view>
			</view>
			<!-- 分享 -->
			<view class="cu-modal bottom-modal" :class="modalName == 'share' ? 'show' : ''" @tap="hideModal">
				<view class="cu-dialog" @tap.stop="">
					<wanl-share 
						:scrollAnimation="scrollAnimation" 
						shareTitle="我发现了一个很好的线上购物商城，这是商城类目" 
						shareText="品质好而且很省钱如果自己在上面购买，每年可以省下1%~40%的钱" 
						:image="$wanlshop.appstc('/common/logo.png')"
						:href="common.appConfig.domain+'/pages/product/category/category?QRtype=category'"
					@change="hideModal"/>
				</view>
			</view>
		</view>
	</view>
</template>

<script>
import { mapState } from 'vuex';
export default {
	data() {
		return {
			wanlsys: this.$wanlshop.wanlsys(),
			height: 0, //scroll-view高度
			currentTab: 0, //预设当前项的值
			scrollTop: 0 ,//tab标题的滚动条位置
			modalName: null,
			scrollAnimation: 300
		};
	},
	computed: {
		...mapState(['common','statistics','cart'])
	},
	onLoad() {
		// #ifdef APP-PLUS
		this.height = this.wanlsys.windowHeight + this.wanlsys.windowBottom - this.wanlsys.height;
		// #endif
		// #ifdef H5
		this.height = this.wanlsys.windowHeight + this.wanlsys.windowBottom - this.wanlsys.height - 50;
		// #endif
		// #ifdef MP
		this.height = this.wanlsys.windowHeight - this.wanlsys.height;
		// #endif
		// #ifdef MP-WEIXIN
		wx.showShareMenu({
			withShareTicket: true,
			menus: ['shareAppMessage', 'shareTimeline']
		});
		// #endif
	},
	methods: {
		// 点击标题切换当前页时改变样式
		swichNav(e) {
			let cur = e.currentTarget.dataset.current;
			if (this.currentTab == cur) {
				return false;
			} else {
				this.currentTab = cur;
				this.checkCor();
			}
		},
		// 弹出层
		showModal(name) {
			// 滚动下分享
			if(name == 'share' && this.modalName != 'share'){
				setTimeout(() => {
					this.scrollAnimation= 0;
				}, 300);
			}
			this.modalName = name;
		},
		hideModal(name) {
			if (name) {
				this.showModal(name);
			}else{
				this.modalName = null;
			}
		},
		//判断当前滚动超过一屏时，设置tab标题滚动条。
		checkCor() {
			if (this.currentTab > 7) {
				this.scrollTop = 500;
			} else {
				this.scrollTop = 0;
			}
		},
		productList(category_id, category_name) {
			this.$wanlshop.to(`/pages/product/list?data=${JSON.stringify({ category_id: category_id, category_name: category_name })}`);
		},
		productSearch(text) {
			this.$wanlshop.to(`/pages/product/search?keywords=${text}`,'fade-in',100);
		}
	}
};
</script>

<style>
	.cu-list.grid.no-border{
		padding: 25rpx;
	}
	.cu-list.grid.no-border>.cu-item {
		padding: 25rpx 0;
		align-items: center;
	}
	.cu-list.grid.no-border>.cu-item image{
		width: 160rpx;
		height: 160rpx;
		margin-bottom: 10rpx; 
	}
	.cu-custom .cu-bar{
		z-index: 99;
	}
	/* #ifdef MP */
	.cu-bar .search-form{
		margin: 0 0 0 25rpx;
	}
	/* #endif */
</style>
