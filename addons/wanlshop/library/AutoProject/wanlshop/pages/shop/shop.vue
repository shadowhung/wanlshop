<template>
	<view class="wanl-shop">
		<!-- 背景 -->
		<view class="wrap">
			<view class="bg-box" :style="{ backgroundImage: 'url(' + $wanlshop.oss(background, 500, 0, 1, 'transparent', 'png') + ')' }"></view>
			<view class="gc-1"></view>
			<view class="gc-2"></view>
			<view class="gc-3"></view>
		</view>
		<!-- 底部导航 -->
		<view class="cu-bar tabbar foot wanl-gray-dark">
			<view class="action" @tap="navChange('home')">
				<view v-if="pageCur == 'home'">
					<view class="user-pic shadow-warp"><image :src="$wanlshop.oss(shopData.avatar, 38, 38, 2, 'avatar')" mode="scaleToFill"></image></view>
				</view>
				<view v-else>
					<view class="wlIcon-31dianpu"></view>
					<view>首页</view>
				</view>
			</view>
			<view class="action" @tap="navChange('allgoods')">
				<view class="wlIcon-baobei" :class="pageCur == 'allgoods' ? 'text-orange' : ''"></view>
				<view :class="pageCur == 'allgoods' ? 'text-orange' : ''">商品</view>
			</view>
			<!-- <view class="action" @tap="navChange('find')">
				<view class="wlIcon-baobei" :class="pageCur == 'find' ? 'text-orange' : ''"></view>
				<view :class="pageCur == 'find' ? 'text-orange' : ''">动态</view>
			</view> -->
			<view class="action" @tap="navChange('category')">
				<view class="wlIcon-fenlei1" :class="pageCur == 'category' ? 'text-orange' : ''"></view>
				<view :class="pageCur == 'category' ? 'text-orange' : ''">分类</view>
			</view>
			<view class="action" @tap="toChat(shop_id)">
				<view class="wlIcon-kefu"></view>
				<view>客服</view>
			</view>
		</view>
		<!-- 浮动头部 -->
		<view
			class="sticky bg-orange"
			v-if="Opacity * 10 >= 3"
			:style="{
				paddingTop: wanlsys.top + 'px',
				backgroundColor: pageData.page.style.navigationBarBackgroundColor,
				color: pageData.page.style.navigationBarTextStyle,
				opacity: Opacity
			}"
		>
			<view class="shop-search wanl-gray-dark" @tap="search">
				<text class="wlIcon-sousuo1 margin-right-xs"></text>
				搜索店内商品
			</view>
			<view class="shop-menu text-white" v-if="pageType">
				<view class="box">
					<view class="item" :class="{ select: filterIndex === 0 }" @tap="tabClick(0)">主页</view>
					<view class="item" :class="{ select: filterIndex === 1 }" @tap="tabClick(1)">推荐</view>
					<view class="item" :class="{ select: filterIndex === 2 }" @tap="tabClick(2)">销量</view>
					<view class="item" :class="{ select: filterIndex === 3 }" @tap="tabClick(3)">新品</view>
					<view class="item" :class="{ select: filterIndex === 4 }" @tap="tabClick(4)">
						<text>价格</text>
						<view class="icon">
							<text :class="{ active: priceOrder === 1 && filterIndex === 4 }" class="wlIcon-sheng"></text>
							<text :class="{ active: priceOrder === 2 && filterIndex === 4 }" class="wlIcon-jiang"></text>
						</view>
					</view>
				</view>
				<view class="text-lg" @tap="editStyle()" v-if="filterIndex != 0">
					<text class="wlIcon-listing-jf" v-if="listStyle == 'col-2-10'"></text>
					<text class="wlIcon-liebiao" v-else></text>
				</view>
			</view>
		</view>
		<!-- 主体 -->
		<view class="main" :style="{ top: wanlsys.top + 'px' }">
			<!-- 小程序 -->
			<view class="header">
				<!-- #ifdef MP -->
				<view class="border-custom margin-right-bj transparent"><text class="wlIcon-fanhui1" @tap="$wanlshop.back(1)"></text></view>
				<!-- #endif -->
				<view class="text-white" style="flex: 1;">
					<view class="title" @tap="shopInfo">
						{{ shopData.shopname }}
						<text class="wlIcon-fangxiang2 margin-left-xs"></text>
					</view>
					<view class="describe text-min">
						<text>粉丝数 {{ $wanlshop.toFormat(shopData.like, 'thousand') }}</text>
					</view>
				</view>
				<!-- #ifndef MP -->
				<view class="border-custom">
					<text class="wlIcon-guanzhu3 wanl-red" @tap="Tofollow" v-if="shopData.follow"></text>
					<text class="wlIcon-guanzhu3" @tap="Tofollow" v-else></text>
					<text class="wlIcon-31guanbi" @tap="$wanlshop.back(1)"></text>
				</view>
				<!-- #endif -->
			</view>
			<!-- 主体内容 -->
			<block v-if="pageType">
				<view class="shop-search wanl-gray-dark margin-lr-bj" @tap="search">
					<text class="wlIcon-sousuo1 margin-right-xs"></text>
					{{ pageData.page.params.navigationBarTitleText }}
				</view>
				<view class="shop-menu text-white margin-lr-bj margin-tb-sm">
					<view class="box">
						<view class="item" :class="{ select: filterIndex == 0 }" @tap="tabClick(0)">主页</view>
						<view class="item" :class="{ select: filterIndex == 1 }" @tap="tabClick(1)">推荐</view>
						<view class="item" :class="{ select: filterIndex == 2 }" @tap="tabClick(2)">销量</view>
						<view class="item" :class="{ select: filterIndex == 3 }" @tap="tabClick(3)">新品</view>
						<view class="item" :class="{ select: filterIndex == 4 }" @tap="tabClick(4)">
							<text>价格</text>
							<view class="icon">
								<text :class="{ active: priceOrder == 1 && filterIndex == 4 }" class="wlIcon-sheng"></text>
								<text :class="{ active: priceOrder == 2 && filterIndex == 4 }" class="wlIcon-jiang"></text>
							</view>
						</view>
					</view>
					<view class="text-lg" @tap="editStyle()" v-if="filterIndex != 0">
						<text class="wlIcon-listing-jf" v-if="listStyle == 'col-2-10'"></text>
						<text class="wlIcon-liebiao" v-else></text>
					</view>
				</view>
				<!-- 自定义页面 -->
				<view class="wanl-page" v-if="filterIndex == 0">
					<view v-for="(item, index) in pageData.item" :key="item.type">
						<view v-if="item.type == 'banner'"><wanl-page-banner :pageData="item" /></view>
						<view v-if="item.type == 'image'"><wanl-page-image :pageData="item" /></view>
						<view v-if="item.type == 'video'"><wanl-page-video :pageData="item" /></view>
						<view v-if="item.type == 'menu'"><wanl-page-menu :pageData="item" /></view>
						<view v-if="item.type == 'notice'"><wanl-page-notice :pageData="item" /></view>
						<view v-if="item.type == 'article'"><wanl-page-article :pageData="item" /></view>
						<view v-if="item.type == 'headlines'"><wanl-page-headlines :pageData="item" /></view>
						<view v-if="item.type == 'search'"><wanl-page-search :pageData="item" /></view>
						<view v-if="item.type == 'activity'"><wanl-page-activity :pageData="item" /></view>
						<view v-if="item.type == 'categoryTitle'"><wanl-page-category-title :pageData="item" /></view>
						<view v-if="item.type == 'classify'"><wanl-page-classify :pageData="item" /></view>
						<view v-if="item.type == 'likes'"><wanl-page-likes :pageData="item" /></view>
						<view v-if="item.type == 'goods'"><wanl-page-goods :pageData="item" /></view>
						<view v-if="item.type == 'bargain'"><wanl-page-bargain :pageData="item" /></view>
						<view v-if="item.type == 'seckill'"><wanl-page-seckill :pageData="item" /></view>
						<view v-if="item.type == 'empty'"><wanl-page-empty :pageData="item" /></view>
						<view v-if="item.type == 'division'"><wanl-page-division :pageData="item" /></view>
					</view>
				</view>
				<!-- 加载店铺商品 -->
				<block v-else>
					<wanl-product :dataList="goodsData" :dataStyle="listStyle"/>
				</block>
			</block>
			<block v-else>
				<!-- 搜索 -->
				<view class="shop-search wanl-gray-dark margin-lr-bj" @tap="search">
					<text class="wlIcon-sousuo1 margin-right-xs"></text>
					{{ pageData.page.params.navigationBarTitleText }}
				</view>
				<!-- 商家类目 -->
				<view class="shop-category">
					<view class="item margin-bj radius-bock" v-for="(item, index) in categoryData" :key="item.id">
						<view class="nav margin-lr-bj" v-if="item.childlist.length == 0" @tap="productCategoryList(item.id, item.name)">
							<text class="text-df">{{ item.name }}</text>
							<text class="wlIcon-fanhui2"></text>
						</view>
						<view class="nav margin-lr-bj" v-else>
							<text class="text-df">{{ item.name }}</text>
						</view>
						<view class="action margin-lr-bj" v-if="item.childlist.length != 0">
							<block v-for="(vo, key) in item.childlist" :key="vo.id">
								<view class="padding-bj" v-if="vo.childlist.length == 0" @tap="productCategoryList(vo.id, vo.name)">
									<text>{{ vo.name }}</text>
								</view>
								<view v-else class="padding-bj" @tap="showDrawer(vo.childlist)">
									{{ vo.name }}
									<text class="wlIcon-fanhui2 margin-left"></text>
								</view>
							</block>
						</view>
					</view>
				</view>
			</block>
			<uni-drawer :visible="showRight" width="75%" mode="right" @close="closeDrawer">
				<view class="drawer">
					<view class="shop-category">
						<view class="item radius-bock" v-for="(item, index) in categoryChildlistData" :key="item.id">
							<view class="nav margin-lr-bj" v-if="item.childlist.length == 0" @tap="productCategoryList(item.id, item.name)">
								<text class="text-df">{{ item.name }}</text>
								<text class="wlIcon-fanhui2"></text>
							</view>
							<view class="nav margin-lr-bj" v-else>
								<text class="text-df">{{ item.name }}</text>
							</view>
							<view class="action margin-lr-bj">
								<block v-for="(vo, key) in item.childlist" :key="vo.id">
									<view class="padding-bj" v-if="vo.childlist.length == 0" @tap="productCategoryList(vo.id, vo.name)">
										<text>{{ vo.name }}</text>
									</view>
									<view v-else class="padding-bj" @tap="showDrawer(vo.childlist)">
										{{ vo.name }}
										<text class="wlIcon-fanhui2 margin-left"></text>
									</view>
								</block>
							</view>
						</view>
					</view>
				</view>
			</uni-drawer>
			<uni-load-more :status="status" :content-text="contentText" />
		</view>
	</view>
</template>

<script>
export default {
	data() {
		return {
			shop_id: 0,
			wanlsys: this.$wanlshop.wanlsys(),
			pageCur: 'home',
			pageType: true,
			pageData: {
				page: {
					params: {
						navigationBarTitleText: '搜索店内商品'
					},
					style: {
						navigationBarBackgroundColor: '#ff4f00',
						navigationBarTextStyle: '#333'
					}
				}
			},
			shopData: {
				shopname: '加载中..',
				follow: false,
				like: 0
			},
			categoryData: [],
			categoryChildlistData: [],
			showRight: false,
			Opacity: 0,
			WanlScroll: 0, //记录页面滚动
			scrollStype: false, //滚动状态
			background: this.$wanlshop.appstc('/show/page_swiper.png'),
			// 列表
			filterIndex: 0, //当前页面
			goodsData: [],
			priceOrder: 0, //1 价格从低到高 2价格从高到低
			listStyle: 'col-2-10',
			params: {
				search: '',
				sort: 'weigh',
				order: 'asc',
				page: 1,
				filter: {},
				op: {}
			},
			reload: false, //判断是否上拉
			last_page: 0,
			status: 'loading',
			contentText: {
				contentdown: '',
				contentrefresh: '正在加载..',
				contentnomore: '没有更多数据了'
			}
		};
	},
	onLoad(option) {
		this.shop_id = option.id;
		this.params.filter = { shop_id: this.shop_id };
		this.params.op = { shop_id: '=' };
		this.loadPageData();
		// 如果传来type
		if (option.type) {
			this.tabClick(option.type);
		}
	},
	onPageScroll(e) {
		let tmpY = 20 + this.wanlsys.top;
		e.scrollTop = e.scrollTop > tmpY ? tmpY : e.scrollTop; //如果当前高度大于250则250否则当前高度
		this.Opacity = e.scrollTop * (1 / tmpY); //$headerOpacity 赋值当前高度x（1÷250）
	},
	// 监听上拉
	onPullDownRefresh() {
		this.params.page  = 1;
		this.reload = true;
		this.loadData();
	},
	// 下拉刷新
	onReachBottom() {
		if (this.params.page >= this.last_page) {
			this.status = 'noMore';
		} else {
			this.reload = false;
			this.contentText.contentdown = '上拉显示更多';
			this.params.page = this.params.page + 1; //页码+1
			this.status = 'loading';
			this.loadData();
		}
	},
	// 监听返回
	onUnload() {
		if (this.showRight) {
			this.closeDrawer();
			return true;
		}
	},
	methods: {
		async loadData() {
			this.$api.get({
				url: '/wanlshop/product/lists',
				data: this.params,
				success: res => {
					uni.stopPullDownRefresh();
					this.status = res.total == 0 ? 'noMore' : 'more';
					this.goodsData = this.reload ? res.data : this.goodsData.concat(res.data); //数据 追加
					if (res.data.length == 0) {
						this.loadlikeData();
					}
					this.params.page = res.current_page; //当前页码
					this.last_page = res.last_page; //总页码
				}
			});
		},
		async loadPageData() {
			this.$api.get({
				url: '/wanlshop/shop/page',
				data: {
					id: this.shop_id
				},
				success: res => {
					this.status = 'more';
					this.shopData = res.shop;
					this.categoryData = res.category;
					if (res.page) {
						this.pageData = res.page;
						this.background = res.page.page.style.pageBackgroundImage;
					} else {
						this.tabClick(1);
					}
				}
			});
		},
		// 关注
		async Tofollow() {
			this.shopData.follow = !this.shopData.follow;
			if (this.shopData.follow) {
				this.shopData.like += 1;
				this.$store.commit('statistics/dynamic', {
					concern: this.$store.state.statistics.dynamic.concern + 1
				});
				
			} else {
				this.shopData.like -= 1;
				this.$store.commit('statistics/dynamic', {
					concern: this.$store.state.statistics.dynamic.concern - 1
				});
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
		},
		// 切换底部菜单
		navChange(name) {
			if (name == 'home') {
				this.tabClick(0);
			} else if (name == 'allgoods') {
				this.tabClick(1);
			}
			this.pageType = name == 'category' ? false : true;
			this.pageCur = name;
		},
		//筛选点击
		tabClick(index) {
			if (this.filterIndex === index && index !== 4) {
				return;
			}
			if (index === 4) {
				this.priceOrder = this.priceOrder === 1 ? 2 : 1;
			} else {
				this.priceOrder = 0;
			}
			this.filterIndex = index;
			// 排序方式
			if (index === 0) {
				this.loadPageData();
			} else {
				if (index === 1) {
					this.params.sort = 'weigh';
					this.params.order = 'asc';
				}
				if (index === 2) {
					this.params.sort = 'sales';
					this.params.order = 'asc';
				}
				if (index === 3) {
					this.params.sort = 'createtime';
					this.params.order = 'asc';
				}
				if (index === 4 && this.priceOrder === 1) {
					this.params.sort = 'price';
					this.params.order = 'asc';
				}
				if (index === 4 && this.priceOrder === 2) {
					this.params.sort = 'price';
					this.params.order = 'desc';
				}
				this.params.page = 1;
				this.reload = true;
				this.loadData();
			}
			this.status = 'loading';
			uni.pageScrollTo({
				duration: 300,
				scrollTop: 0
			});
		},
		// 修改布局样式
		editStyle() {
			this.listStyle = this.listStyle == 'col-1-10' ? 'col-2-10' : 'col-1-10';
		},
		// 打开抽屉，并且加载品牌和类目属性
		showDrawer(data) {
			this.showRight = true;
			this.categoryChildlistData = data;
		},
		// 关闭抽屉
		closeDrawer() {
			this.showRight = false;
		},
		//跳转类目列表
		productCategoryList(cid, name) {
			this.$wanlshop.to('productList?shop_id=' + this.shop_id + '&category_id=' + cid + '&category_name=' + name);
		},
		search() {
			this.$wanlshop.to('productList?shop_id=' + this.shop_id, 'fade-in', 100);
		},
		shopInfo() {
			this.$wanlshop.to('info?shop_id=' + this.shop_id);
		}
	}
};
</script>

<style></style>
