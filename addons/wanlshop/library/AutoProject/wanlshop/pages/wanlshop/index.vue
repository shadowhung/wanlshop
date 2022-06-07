<template>
	<view class="home" :style="{
			backgroundColor : common.modulesData.homeModules.page ? common.modulesData.homeModules.page.style.pageBackgroundColor : '',
			backgroundSize : '100% auto',
			backgroundImage : 'url(' + $wanlshop.oss(common.modulesData.homeModules.page ? common.modulesData.homeModules.page.style.pageBackgroundImage : '', 414, 0, 1, 'transparent', 'png') + ')'
		}">
		<!-- 导航条 -->
		<view class="cu-custom">
			<view class="cu-bar fixed" :style="{
				height: wanlsys.height + 'px', 
				paddingTop: wanlsys.top + 'px',
				color: common.modulesData.homeModules.page ? (common.modulesData.homeModules.page.style.navigationBarTextStyle == '#ffffff'?'#ffffff':'#333333'):''
			}">
				<view class="cu-avatar round" @tap="userUser" v-if="user.isLogin" :style="{ backgroundImage: 'url(' + $wanlshop.oss(user.avatar, 32, 32, 2, 'avatar') + ')' }"></view>
				<view class="cu-avatar round" @tap="userAuth" v-else :style="{ backgroundImage: 'url(' + $wanlshop.oss(user.avatar, 32, 32, 2, 'avatar') + ')' }"></view>
				<view class="search-form round">
					<text class="wlIcon-sousuo1 text-bold"></text>
					<swiper class="search-swiper placeholder" vertical autoplay circular interval="3000">
						<swiper-item @tap="productSearch('')">搜索商品、类目</swiper-item>
						<swiper-item v-for="(item, index) in common.modulesData.searchModules" :key="item.keywords" @tap="productSearch(item.keywords)">
							{{ item.keywords }}
						</swiper-item>
					</swiper>
				</view>
				<!-- 背景 -->
				<view class="bar-bg" v-if="headerOpacity > 0" :style="{
					height: wanlsys.height + 'px', 
					opacity: headerOpacity,
					backgroundColor: common.modulesData.homeModules.page ? common.modulesData.homeModules.page.style.navigationBarBackgroundColor : '#f7f7f7',
					backgroundImage: 'url(' + $wanlshop.oss(common.modulesData.homeModules.page ? common.modulesData.homeModules.page.style.navigationBackgroundImage : '', 0, 50, 1, 'transparent', 'png') + ')'
				}"></view>
				<view class="action" @tap="scanCode">
					<text class="wlIcon-saoyisao text-white"></text>
				</view>
			</view>
		</view>
		<!-- 自定义首页 -->
		<view v-for="(item, index) in common.modulesData.homeModules.item" :key="index" v-if="common.modulesData.homeModules">
			<view v-if="item.type == 'banner'"><wanl-page-banner :pageData="item" /></view>
			<view v-if="item.type == 'image'"><wanl-page-image :pageData="item" /></view>
			<view v-if="item.type == 'advertBanner'"><wanl-page-advert-banner :pageData="item" :advertData="common.adData.pageAdverts" /></view>
			<view v-if="item.type == 'advertImage'"><wanl-page-advert-image :pageData="item" :advertData="common.adData.pageAdverts" /></view>
			<view v-if="item.type == 'video'"><wanl-page-video :pageData="item" /></view>
			<view v-if="item.type == 'menu'"><wanl-page-menu :pageData="item" /></view>
			<view v-if="item.type == 'notice'"><wanl-page-notice :pageData="item" /></view>
			<view v-if="item.type == 'article'"><wanl-page-article :pageData="item" /></view>
			<view v-if="item.type == 'headlines'"><wanl-page-headlines :pageData="item"/></view>
			<view v-if="item.type == 'search'"><wanl-page-search :pageData="item"/></view>
			<view v-if="item.type == 'activity'"><wanl-page-activity :pageData="item"/></view>
			<view v-if="item.type == 'categoryTitle'"><wanl-page-category-title :pageData="item"/></view>
			<view v-if="item.type == 'classify'"><wanl-page-classify :pageData="item" /></view>
			<view v-if="item.type == 'likes'"><wanl-page-likes :pageData="item" /></view>
			<view v-if="item.type == 'goods'"><wanl-page-goods :pageData="item" /></view>
			<view v-if="item.type == 'bargain'"><wanl-page-bargain :pageData="item" /></view>
			<view v-if="item.type == 'seckill'"><wanl-page-seckill :pageData="item" /></view>
			<view v-if="item.type == 'empty'"><wanl-page-empty :pageData="item" /></view>
			<view v-if="item.type == 'division'"><wanl-page-division :pageData="item" /></view>	
		</view>
		<view class="WANL-MODAL" @touchmove.stop.prevent="moveHandle">
			<view class="cu-modal" :class="update.update?'show':''">
				<view class="cu-dialog">
					<view class="hade">
						<image :src="$wanlshop.appstc('/common/update.png')" mode="aspectFit"></image>
						<view class="title">
							<view class="text-white text-bold5">{{update.data.title}}</view>
							<text class="text-white text-bold5">最新版本：{{update.data.versionName}}</text>
						</view>
					</view>
					
					<view class="info">
						<view class="text-lg text-bold5">
							<text>更新内容：</text>
						</view>
						<rich-text class="wanl-gray-dark" :nodes="update.data.content"/>
						<!-- 开始下载 -->
						<view class="margin-top-xl" v-if="update.download.start">
							<view class="flex margin-bottom-sm">
								<view class="cu-progress round striped active">
									<view class="bg-orange" :style="{ width: update.download.progress + '%'}"></view>
								</view>
								<text class="margin-left-sm">{{update.download.progress}}%</text>
							</view>
							<view class="wanl-gray-dark text-sm text-center">
								<text>下载中，请稍等（{{$wanlshop.conver(update.download.totalBytesWritten)}}/{{$wanlshop.conver(update.download.totalBytesExpectedToWrite)}}）</text>
							</view>
						</view>
						<!-- 开始安装 -->
						<view class="margin-top-xl text-center" v-else-if="update.download.install">
							安装中...
						</view>
						<!-- 更新提示 -->
						<view class="flex justify-around margin-top-xl" v-else>
							<button class="cu-btn radius-bock bg-gray lg" @tap="ignore">忽略升级</button>
							<button class="cu-btn radius-bock bg-blue lg" @tap="download">立刻升级</button>
						</view>
					</view>
				</view>
			</view> 
		</view>
		
		<!-- #ifdef APP-PLUS --><!-- #endif -->
		<view class="edgeInsetBottom" style="background: #f7f7f7;"></view>
	</view>
</template>
<script>
import { mapState, mapActions } from 'vuex';
export default {
	computed: { 
		...mapState(['user', 'common', 'update'])
	},
	data() {
		return {
			headerOpacity: 0,
			wanlsys: this.$wanlshop.wanlsys()
		};
	},
	onShow() {
		setTimeout(()=> {
			uni.setNavigationBarColor({  
				frontColor: this.$store.state.common.modulesData.homeModules.page ? this.$store.state.common.modulesData.homeModules.page.style.navigationBarTextStyle:'',  
				backgroundColor: this.$store.state.common.modulesData.homeModules.page ? this.$store.state.common.modulesData.homeModules.page.style.navigationBarBackgroundColor:''
		    })  
		}, 200);
	},
	onReady() {
		// #ifdef APP-PLUS
		plus.navigator.setFullscreen(false);
		// #endif
		// 判断网络类型
		uni.getNetworkType({
		    success: (res) => {
				if (res.networkType == '2g' || res.networkType == '3g' || res.networkType == '4g') {
					this.$wanlshop.msg('当前使用非WIFI环境，请注意流量使用');
				}else if(res.networkType == 'none'){
					this.$wanlshop.msg('没有网络');
				}
		    }
		});
	},
	onPageScroll(e) {
		let tmpY = 300;
		e.scrollTop = e.scrollTop > tmpY ? 300 : e.scrollTop; //如果当前高度大于250则250否则当前高度
		this.headerOpacity = e.scrollTop * (1 / tmpY); //$headerOpacity 赋值当前高度x（1÷250）
	},
	methods: {
		...mapActions({
			download: 'update/download', // 立即下载
			ignore: 'update/ignore'// 忽略更新
		}),
		productSearch(text) {
			this.$wanlshop.to(`/pages/product/search?keywords=${text}`,'fade-in',100);
		},
		userUser() {
			uni.switchTab({
				url: '/pages/user/user'
			});
		},
		userAuth() {
			this.$wanlshop.to('/pages/user/auth/auth?url=/pages/wanlshop/index');
		},
		scanCode() {
			// #ifndef H5
			uni.scanCode({
				success: (res) => {
					var QRcode = this.getUrlParam(res.result);
					switch(QRcode.QRtype) {
						case 'goods':
					        this.onGoods(QRcode.id);
							break;
						case 'user':
							this.$wanlshop.to(`/pages/user/info?id=${QRcode.id}`);
							break;
						case 'category':
							this.$wanlshop.on('/pages/product/category/category');
							break;
						case 'page':
							this.$wanlshop.to(`/pages/page/index?id=${QRcode.id}`);
							break;
						case 'shop':
						    this.onShop(QRcode.id);
							break;
						case 'live':
							// #ifdef APP-PLUS || MP-WEIXIN
							this.$wanlshop.auth(`/pages/shop/live/live`);
							// #endif
							// #ifndef APP-PLUS || MP-WEIXIN
							this.$wanlshop.msg('目前只开放App和微信小程序直播')
							// #endif
							break;
						case 'chat':
						    this.toChat(QRcode.id);
							break;
					}
				}
			});
			// #endif
			// #ifdef H5
			this.$wanlshop.msg('暂不支持H5扫码');
			// #endif
		},
		// 解析Url
		getUrlParam(url) {
			var obj = {};
			var data = url.split("?")[1].split("&");
			for(var i=0 ; i < data.length; i++){
		　　　　var res = data[i].split("=");
		　　　　obj[res[0]] = res[1];
		　　}
		　　return obj;
		},
		//禁止父元素滑动 1.0.3升级
		moveHandle() {}
	}
};
</script>
<style>
	.cu-dialog{
		width: 80%;
		overflow: initial;
		text-align: left;
		border-radius: 25rpx;
	}
	.cu-dialog .hade{
		position: relative;
		width: 100%;
		top: -128rpx;
	}
	.cu-dialog .hade .title{
		position: relative;
		top: -280rpx;
		text-align: right;
		padding-right: 50rpx;
		overflow: hidden;
		height: 110rpx;
		margin-bottom: -110rpx;
	}
	.cu-dialog .hade .title>view{
		font-size: 50rpx;
	}
	.cu-dialog .info{
		position: relative;
		display: block;
		top: -170rpx;
		margin: 0 30rpx -140rpx 30rpx;
		line-height: 1.8;
	}
	
	
	.cu-bar .search-form{
		background-color: rgba(242, 242, 242, 0.9);
	}
	
	/* #ifdef MP */
	.cu-bar .action:last-child{
		margin-right: 0;
	}
	/* #endif */
</style>
