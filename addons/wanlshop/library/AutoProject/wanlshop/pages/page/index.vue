<template>
	<view class="wanl-page" :style="{
			backgroundColor : pageData.style.pageBackgroundColor,
			backgroundSize : '100% auto',
			backgroundImage : 'url(' + $wanlshop.oss(pageData.style.pageBackgroundImage, 0, 50, 1, 'transparent', 'png') + ')'
		}">
		<!-- 导航条 -->
		<view class="cu-custom" :style="{height: wanlsys.height + 'px' }">
			<view class="cu-bar fixed" :style="{
				height: wanlsys.height + 'px', 
				paddingTop: wanlsys.top + 'px',
				color: pageData.style.navigationBarTextStyle == '#ffffff'?'#ffffff':'#333333',
				backgroundColor: pageData.style.navigationBarBackgroundColor,
				backgroundImage : 'url(' + $wanlshop.oss(pageData.style.navigationBackgroundImage, 414, 0, 1, 'transparent', 'png') + ')'
			}">
				<view class="action" @tap="$wanlshop.back(1)">
					<text class="wlIcon-fanhui1"></text>
				</view>
				<view class="content" :style="{top: wanlsys.top + 'px'}">
					{{pageData.params.navigationBarTitleText}}
				</view>
				<view class="action" @tap="showModal('share')">
					<text class="wlIcon wlIcon-fenxiang"></text>
				</view>
			</view>
		</view>
		<!-- 页面组件 -->
		<view v-for="(item, index) in itemData" :key="item.type">
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
		<view class="edgeInsetBottom"></view>
		<!-- 模态框 -->
		<view class="WANL-MODAL">
			<!-- 分享 -->
			<view class="cu-modal bottom-modal" :class="modalName == 'share' ? 'show' : ''" @tap="hideModal">
				<view class="cu-dialog" @tap.stop="">
					<wanl-share 
						:scrollAnimation="scrollAnimation" 
						:shareTitle="pageData.params.share_title" 
						:shareText="pageData.params.navigationBarTitleText" 
						:image="$wanlshop.appstc('/common/logo.png')" 
						:href="common.appConfig.domain+'/pages/page/index?id='+pageId+'&QRtype=page'"
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
			pageId: null,
			// 页面组件
			itemData: [] ,
			// 页面参数
			pageData: {
				params: {
					navigationBarTitleText: '加载中..',
					share_title: '分享'
				},
				style:{}
			},
			wanlsys: this.$wanlshop.wanlsys(),
			modalName: '',
			scrollAnimation: 300
		};
	},
	computed: {
		...mapState(['common'])
	},
	onLoad(option) {
		this.pageId = option.id;
		this.loadData(option);
	},
	onShow() {
		// #ifdef MP-WEIXIN
		wx.showShareMenu({
			withShareTicket: true,
			menus: ['shareAppMessage', 'shareTimeline']
		});
		// #endif
		setTimeout(()=> {
			uni.setNavigationBarColor({  
				frontColor: this.pageData.style.navigationBarTextStyle,  
				backgroundColor: this.pageData.style.navigationBarBackgroundColor
		    })  
		}, 200);
	},
	methods: {
		// 异步加载
		async loadData(option) {
			this.$api.get({
				url: '/wanlshop/page/index',
				data: option,
				success: res => {
					this.itemData = res.item;
					this.pageData = res.page;
					//修改页面标题、导航条前景色frontColor和背景backgroundColor
					this.$wanlshop.title(res.page.params.navigationBarTitleText,{
						frontColor: res.page.style.navigationBarTextStyle,
						backgroundColor: res.page.style.navigationBarBackgroundColor
					});
				}
			});
		},
		// 弹出层
		showModal(name) {
			// 滚动下分享
			setTimeout(() => {
				this.scrollAnimation= 0;
			}, 300);
			this.modalName = name;
		},
		hideModal() {
			this.modalName = null;
		}
	}
};
</script>

<style>
</style>
