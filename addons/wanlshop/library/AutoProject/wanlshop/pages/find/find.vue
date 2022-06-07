<template>
	<view class="find" :style="{
		backgroundColor: common.appStyle.find_bg_color ? common.appStyle.find_bg_color : '#f7f7f7',
		backgroundImage: 'url(' + $wanlshop.oss(common.appStyle.find_bg_image, 0, 50, 1, 'transparent', 'png') + ')'
	}">
		<!-- 导航条 -->
		<view class="cu-custom" :style="{ height: wanlsys.height + 'px' }">
			<view class="cu-bar" :style="{ height: wanlsys.height + 'px', paddingTop: wanlsys.top + 'px', color: common.appStyle.find_font_color == 'light' ? '#ffffff' : '#333333' }" >
				<view class="action">
					<!-- #ifndef MP -->
					<text class="wlIcon-guanzhu4" style="margin-left: 0;" @tap="$wanlshop.auth('/pages/user/follow')"></text>
					<!-- #endif -->
					<!-- #ifdef MP -->
					<text class="wlIcon-zan1" style="margin-left: 0; margin-right: 0;" @tap="$wanlshop.auth('/pages/find/lists')"></text>
					<text class="wlIcon-xiaoxizhongxin" @tap="$wanlshop.to('/pages/notice/notice')"></text>
					<view class="cu-tag badge" v-if="statistics.notice.chat > 0">{{ statistics.notice.chat }}</view>
					<!-- #endif -->
				</view>
				<view class="content" :style="{top: wanlsys.top + 'px'}">
					<text class="text-xl">社区种草</text>
				</view>
				<!-- #ifndef MP -->
				<view class="action">
					<text class="wlIcon-zan1" @tap="$wanlshop.auth('/pages/find/lists')"></text>
					<text class="wlIcon-xiaoxizhongxin" @tap="$wanlshop.to('/pages/notice/notice')"></text>
					<view class="cu-tag badge" v-if="statistics.notice.chat > 0">{{ statistics.notice.chat }}</view>
				</view>
				<!-- #endif -->
			</view>
		</view>
		
		<!-- 选项卡 -->
		<scroll-view class="navTab" :style="{color: common.appStyle.find_font_color == 'light' ? '#ffffff' : '#333333'}" scroll-x scroll-with-animation :scroll-left="scrollLeft">
			<view class="flex text-center">
				<view class="flex-sub" v-for="(item, index) in tabData" :key="item.id" @tap="tabSelect(index)">
					<view class="text-30" v-if="item.id == 'live'"><text class="wlIcon-zhibozhong-0 margin-right-xs"></text> {{item.name}}</view>
					<view class="text-30" v-else>{{item.name}}</view>
					<view v-if="index == tabCur" class="wlIcon-weixiao" style="margin-top: -16rpx;"></view>
				</view>
			</view>
		</scroll-view>
		<!-- 主体 -->
		<view class="main">
			<swiper :current="tabCur" class="swiper-box" :style="{height: height + 'px'}" :duration="300" @change="onTabchange">
				<swiper-item class="swiper-item" v-for="(item, index) in tabData" :key="item.id">
					<!-- 当前页 -->
					<scroll-view class="swiper-box" 
					:style="{height: height + 'px'}"
					scroll-y="true" 
					refresher-enabled="true" 
					:lower-threshold="50" 
					refresher-background="#f7f7f7" 
					:refresher-threshold="100" 
					:refresher-triggered="item.triggered" @scrolltolower="onTolower" @refresherrefresh="onRefresh" @scroll="onScroll">
						
						<view class="bg-white margin-bj radius-bock flex align-center justify-center padding-lr padding-tb-xl" v-if="item.id == 'all' && !user.isLogin">
							<view class="text-center">
								<text class="wanl-gray">登录后才能看到您关注店铺的动态哦</text>
								<view class="margin-top-sm">
									<button class="cu-btn bg-orange" @tap="$wanlshop.auth('/pages/find/find')">马上登陆</button>
								</view>
							</view>
						</view>
						
						<view class="wanl-find margin-top-sm" v-for="(find, key) in item.data" :key="find.id">
							<view class="margin-lr-bj margin-bottom-bj m bg-white radius-bock padding-lr-bj padding-top-bj">
								<view class="margin-bottom-sm wanl-gray-light text-min flex justify-between" v-if="item.id == 'all' && !find.isShopBut">
									<text>你可能喜欢的内容</text>
									<text class="wlIcon-fanhui4"></text>
								</view>
								<view class="userinfo">
									<view class="avatar">
										<view @tap="onShop(find.shop_id)" class="cu-avatar round margin-right-bj" :style="{ backgroundImage: 'url(' + $wanlshop.oss(find.shop.avatar, 35, 35, 2, 'avatar') + ')' }"></view>
										<view>
											<view class="wanl-find-head">
												<text @tap="onShop(find.shop_id)" class="wanl-black margin-right-bj shopname">{{find.shop.shopname}}</text>
												<view v-if="find.isLive" @tap="onLive(find.isLive.id)" class="cu-tag sm wanl-bg-orange round"><text class="wlIcon-zhibo"></text>直播中</view>
											</view>
											<view class="wanl-gray text-min">{{$wanlshop.timeToDate(find.createtime)}}</view>
										</view>
									</view>
									<block v-if="find.isShopBut">
										<view class="cu-btn round line-red sm"  @tap="onShop(find.shop_id)"> <text class="wlIcon-dianpu1"></text> 进店 </view>
									</block>
									<block v-else >
										<view class="cu-tag round bg-white" v-if="find.isFollow" @tap="onFollow(index, key)">
											<text class="wlIcon-31xuanze"></text>已关注
										</view>
										<view class="cu-tag round bg-orange" v-else @tap="onFollow(index, key)">
											<text class="wlIcon-guanzhu3"></text>关注
										</view>
									</block>
								</view>
								<view class="content margin-tb-bj wanl-gray-dark text-cut-2" @tap="onFind(find)">
									<view class="cu-tag sm radius margin-right-xs" :class="[typeList[find.type]]">{{find.type_text}}</view>
									<!-- <view class="cu-tag sm radius margin-right-xs" v-if="item.id != 'live'" :class="[typeList[find.type]]">{{find.type_text}}</view> -->
									<!-- <view class="cu-tag sm radius margin-right-xs" v-else :class="[typeList[find.type]]">直播示例</view> -->
									{{formatHtml(find.content)}}
								</view>
								<view class="container radius-bock">
									<block v-for="(img, kes) in find.images" :key="kes">
										<block v-if="find.type == 'live'">
											<view class="item" @tap="onFind(find)" :class="[kes == 0 ? 'item-live':'']" :style="{ backgroundImage: 'url(' + $wanlshop.oss(img, 200, 0) + ')' }">
												<block v-if="kes == 0">
													<view class="play">
														<text :class="[find.live.state == 1?'wlIcon-icon_zhibo-mian':'wlIcon-guijihuifang']"></text>
													</view>
													<view class="state text-white" v-if="find.live.state == 1">
														<view class="tags wanl-bg-orange"><text class="wlIcon-zhibo"></text> <text class="text-min">直播</text></view>
														<view class="text-sm">{{find.live.views}} 在看</view>
													</view>
													<view class="state text-white" v-else>
														<view class="tags bg-grey"><text class="text-min">回放</text></view>
														<view class="text-sm">{{find.live.views}} 看过</view>
													</view>
													<!-- <view class="number text-white">
														<view>{{$wanlshop.toFormat(find.live.goods_ids.split(',').length,'hundred')}}</view>
														<text>商品</text> 
													</view> -->
													<view class="like text-center text-white" v-if="find.live.state == 1">
														<view class="likebut">
															<text class="wlIcon-yiguanzhu1"></text>
														</view>
														<text class="text-min">{{find.live.like}}</text>
													</view>
												</block>
											</view>
										</block>
										
										<block v-else>
											<block v-if="find.images.length == 1">
												<view class="item item-1" @tap="previewImage(find.images, kes)" :style="{ backgroundImage: 'url(' + $wanlshop.oss(img, 200, 0) + ')' }"></view>
											</block>
											<block v-else-if="find.images.length == 3">
												<view class="item" @tap="previewImage(find.images, kes)" :class="[kes == 0 ? 'item-3':'']" :style="{ backgroundImage: 'url(' + $wanlshop.oss(img, 200, 0) + ')' }"></view>
											</block>
											<block v-else>
												<view class="item" @tap="previewImage(find.images, kes)" :style="{ backgroundImage: 'url(' + $wanlshop.oss(img, 200, 200) + ')' }"></view>
											</block>
										</block>
									</block>
								</view>
								<scroll-view class="scroll-view margin-top-sm" scroll-x="true">
									<view class="scroll-view-item radius-bock" 
									:class="[find.goods.length == 1 ? 'col-1':'']" v-for="(goods, sub) in find.goods" :key="goods.id" @tap="onGoods(goods.id)">
										<view class="img"><image :src="$wanlshop.oss(goods.image, 50, 50)"></image></view>
										<view class="content padding-left-bj text-cut text-df">
											{{goods.title}}
											<view class="flex align-center">
												<text class="text-price text-orange">{{goods.price}}</text>
											</view>
										</view>
										<view class="icon text-lg wanl-gray-light"><text class="wlIcon-fanhui6"></text></view>
									</view>
								</scroll-view>
								<view class="flex justify-between padding-tb-bj align-center">
									<view class="wanl-gray-light text-sm" v-if="find.type == 'live'" @tap="onFind(find)">{{find.live.views}} 阅读</view>
									<view class="wanl-gray-light text-sm" v-else @tap="onFind(find)">{{find.views}} 阅读</view>
									<view class="flex">
										<view :class="[find.isLike?'wanl-orange':'']" @tap="onLike(index, key)">
											<text :class="[find.isLike?'wlIcon-dianzan1':'wlIcon-dianzan11']"></text>
											<text class="margin-left-xs">{{find.like}}</text>
										</view>
										<view class="margin-left" @tap="onFind(find)" v-if="common.appConfig.comment_switch == 'Y'">
											<text class="wlIcon-pinglun"></text>
											<text class="margin-left-xs">{{find.comments}}</text>
										</view>
									</view>
								</view>
								<view class="padding-tb-bj solid-top text-center text-orange" v-if="find.newGoods > 0" @tap="onShop(find.shop_id)">
									进店查看 {{find.newGoods}} 件新品
									<text class="wlIcon-fanhui6 margin-left-xs"></text>
								</view>
							</view>
						</view>
						<view v-if="item.data.length == 0">
							<wanl-empty src="find_default3x" :text="'没有找到任何 ' + item.name"/>
						</view>
						<uni-load-more v-else :status="item.status" :content-text="item.contentText" />
						<view class="edgeInsetBottom"></view>
					</scroll-view>
				</swiper-item>
			</swiper>
		</view>
	</view>
</template>

<script>
import { mapState } from 'vuex';
export default {
	computed: {
		...mapState(['common', 'user', 'statistics'])
	},
	data() {
		return {
			wanlsys: this.$wanlshop.wanlsys(),
			height: null,
			typeList: {
				new: 'bg-gradual-yellow',
				live: 'wanl-bg-orange',
				want: 'bg-gradual-green',
				activity: 'bg-gradual-orange',
				show: 'wanl-bg-pink'
			},
			tabCur: 0,
			scrollLeft: 0,
			scrollTop: 0,
			tabData: []
		};
	}, 
	onShow() {
		setTimeout(()=> {
			uni.setNavigationBarColor({  
				frontColor: this.$store.state.common.appStyle.find_font_color == 'light'?'#ffffff':'#000000',  
				backgroundColor: this.$store.state.common.appStyle.find_bg_color
		    })  
		}, 200);
	},
	onLoad() {
		// #ifdef APP-PLUS
		this.height = this.wanlsys.windowHeight + this.wanlsys.windowBottom - this.wanlsys.height - 32;
		// #endif
		// #ifdef H5
		this.height = this.wanlsys.windowHeight + this.wanlsys.windowBottom - this.wanlsys.height - 50 - 32;
		// #endif
		// #ifdef MP
		this.height = this.wanlsys.windowHeight - this.wanlsys.height - 32;
		// #endif
		this.loadMenu();
	},
	methods: {
		// 点击选择
		tabSelect(key) {
			this.tabCur = key;
			this.scrollLeft = (key - 1) * 60;
		},
		// 监听滑动选择
		onTabchange(e) {
			this.tabCur = e.detail.current;
			if (this.tabData[this.tabCur].data.length == 0) {
				this.loadData();
			}
		},
		async loadMenu() {
			this.$api.get({
				url: '/wanlshop/find/menu',
				data: {
					// #ifdef APP-PLUS
					device: 'app',
					// #endif
					// #ifdef MP
					device: 'mp',
					// #endif
					// #ifdef H5
					device: 'h5',
					// #endif
				},
				success: res => {
					this.tabData = res;
					this.loadData();
				}
			});
		},
		async loadData() {
			let find = this.tabData[this.tabCur];
			this.$api.get({
				url: '/wanlshop/find/find',
				data: {
					page: find.current_page,
					type: find.id
				},
				success: res => {
					// 判断是否上拉状态
					if (find.triggered) {
						//触发onRestore，并关闭刷新图标
						find.triggered = false; 
						find._freshing = false;
						find.data = res.data;
					}else{
						find.data = find.data.concat(res.data);
					}
					//当前页码
					find.current_page = res.current_page; 
					//总页码
					find.last_page = res.last_page; 
					find.status = res.total == 0 ? 'noMore':'more';
				}
			});
		},
		// 下拉刷新
		onRefresh() {
			if (this.tabData[this.tabCur]._freshing) return;
			this.tabData[this.tabCur]._freshing = true;
			if (!this.tabData[this.tabCur].triggered)
				//界面下拉触发，triggered可能不是true，要设为true
				this.tabData[this.tabCur].triggered = true;
				this.tabData[this.tabCur].current_page = 1;
				this.loadData();
		},
		// 上拉加载更多
		onTolower() {
			//判断是否最后一页
			if (this.tabData[this.tabCur].current_page >= this.tabData[this.tabCur].last_page) {
				this.tabData[this.tabCur].status = 'noMore';
			} else {
				this.tabData[this.tabCur].current_page = this.tabData[this.tabCur].current_page + 1; //页码+1
				this.tabData[this.tabCur].status = 'loading';
				this.loadData();
			}
		},
		// 监听滚动
		onScroll(e){
			this.scrollTop = e.detail.scrollTop;
		},
		// 格式化html
		formatHtml(content){
			return (content.replace(/<\/?.+?>/g,"").replace(/ /g,""));
		},
		// 关注 & 取消关注
		onFollow(index, key){
			var find = this.tabData[index].data;
			find[key].isFollow = !find[key].isFollow;
			// 后续版本遍历整个find
			this.$api.post({
				url: '/wanlshop/shop/follow',
				data: {
					id: find[key].shop_id
				},
				success: res => {
					find[key].isFollow = res;
				}
			});
		},
		// 喜欢 & 取消喜欢
		onLike(index, key){
			var find = this.tabData[index].data[key];
			find.isLike = !find.isLike;
			if (find.isLike) {
				find.like += 1;
			}else{
				find.like -= 1;
			}
			this.$api.post({
				url: '/wanlshop/find/setFollow',
				data: {
					id: find.id
				},
				success: res => {
					find.isLike = res;
				}
			});
		},
		//预览图片
		previewImage(image, index) {
			var imgArr = [];
			for (var item of image) {
				imgArr = imgArr.concat(this.$wanlshop.oss(item, 500));
			}
			uni.previewImage({
				urls: imgArr,
				current: imgArr[index],
				indicator: 'number'
			});
		}
	}
};
</script>

<style>
	.navTab{
		padding: 10rpx 80rpx 0rpx 80rpx;
	}
	.find{
		background-repeat: no-repeat;
		background-size: 100%;
	}
	.cu-custom .cu-bar .action {
		position: relative;
	}
	.userinfo .avatar .cu-tag{
		padding: 0px 6rpx;
		height: 34rpx;
	}
	.wanl-find-head{
		line-height: 1;
	}
	.wanl-find-head .shopname{
		font-size: 31rpx;
		color: #000000;
	}
</style>
