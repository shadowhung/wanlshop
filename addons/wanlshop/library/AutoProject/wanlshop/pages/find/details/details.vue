<template>
	<view>
		<!-- 导航条 -->
		<view class="cu-custom" :style="{height: wanlsys.height + 'px' }">
			<view class="cu-bar fixed bg-bgcolor" :style="{
				height: wanlsys.height + 'px', 
				paddingTop: wanlsys.top + 'px'
			}">
				<view class="action">
					<text class="wlIcon-fanhui1" style="margin-left: 0;" @tap="$wanlshop.back(1)"></text>
				</view>
				<view class="content" :style="{top: wanlsys.top + 'px'}">
					<view v-if="iShead">
						更多推荐
					</view>
					<view class="userinfo" v-else>
						<view class="cu-avatar round" :style="{ backgroundImage: 'url(' + $wanlshop.oss(data.shop.avatar, 35, 35, 2, 'avatar') + ')' }"></view>
						<view class="text-cut margin-lr-xs text-sm">
							{{data.shop.shopname}}
						</view>
						<block v-if="data.isShopBut">
							<view class="cu-btn round line-red sm"  @tap="onShop(data.shop_id)"> <text class="wlIcon-dianpu1"></text> 进店 </view>
						</block>
						<block v-else >
							<view class="cu-tag round bg-white" v-if="data.isFollow" @tap="onFollow(data.shop_id)">
								<text class="wlIcon-31xuanze"></text>已关注
							</view>
							<view class="cu-tag round bg-orange" v-else @tap="onFollow(data.shop_id)">
								<text class="wlIcon-guanzhu3"></text>关注
							</view>
						</block>
					</view>
				</view>
			</view>
		</view>
		<!-- 主体内容-->
		<view class="wanl-find bg-white" id="main">
			<!-- 内容 -->
			<view class="content padding-bj" v-if="data.type == 'new'">
				<view class="flex align-center">
					<view class="calendar text-center" :style="{ backgroundImage: 'url(' + $wanlshop.appstc('/common/calendar.png') + ')' }">
						{{data.createtime_date}}
					</view>
					<view class="margin-left-xs">
						<text class="text-bold">今日上新</text>
					</view>
				</view>
				<view class="wanl-gray-dark padding-tb-sm">
					<rich-text :nodes="data.content"></rich-text>
				</view>
				<wanl-more :goods="data.goods"/>
			</view>
			<view class="content" v-if="data.type == 'want' || data.type == 'show'">
				<view class="swiper-box">
					<swiper circular="true" autoplay="true" @change="swiperChange($event)">
						<swiper-item v-for="(swiper, index) in data.images" :key="index">
							<image :src="$wanlshop.oss(swiper, 400, 0)" mode="aspectFill"></image>
						</swiper-item>
					</swiper>
					<view class="indicator">{{ data.current + 1 }}/{{ data.images.length }}</view>
				</view>
				<scroll-view class="scroll-view padding-top-bj padding-left-bj" :class="[data.goods.length == 1 ? 'padding-right-bj':'']" scroll-x="true">
					<view class="scroll-view-item radius-bock" :class="[data.goods.length == 1 ? 'col-1':'']" v-for="(goods, sub) in data.goods" :key="goods.id" @tap="onGoods(goods.id)">
						<view class="img"><image :src="$wanlshop.oss(goods.image, 50, 50)"></image></view>
						<view class="goodsinfo text-cut text-df">
							{{goods.title}}
							<view class="flex align-center">
								<text class="text-price text-orange">{{goods.price}}</text>
							</view>
						</view>
					</view>
				</scroll-view>
				<view class="wanl-gray-dark padding-lr-bj padding-top-sm">
					<rich-text :nodes="data.content"></rich-text>
				</view>
			</view>
			<!-- 底部 -->
			<view class="flex justify-between padding-bj align-center">
				<view @tap="showModal('comments')" v-if="common.appConfig.comment_switch == 'Y'">
					<view class="cu-avatar round sm margin-right-xs" :style="{ backgroundImage: 'url(' + $wanlshop.oss(user.avatar, 35, 35, 2, 'avatar') + ')' }"></view>
					<text class="text-sm wanl-gray">快来评论吧</text>
				</view>
				<view v-else></view>
				<view class="flex">
					<view :class="[data.isLike?'wanl-orange':'']" @tap="onLike(data.id)">
						<text class="margin-right-xs" :class="[data.isLike?'wlIcon-dianzan1':'wlIcon-dianzan11']"></text>
						{{data.like}}
					</view>
					<view class="margin-left" @tap="showModal('comments')" v-if="common.appConfig.comment_switch == 'Y'">
						<text class="wlIcon-pinglun margin-right-xs"></text>
						{{data.comments}}
					</view>
					<view class="margin-left">
						<text class="wlIcon-yueduliang margin-right-xs"></text>
						{{data.views}}
					</view>
				</view>
			</view>
		</view>
		<!-- 列表内容 ######################################################################################-->
		<view class="wanl-find bg-white solid-top" v-for="(item, index) in listData" :key="item.id" v-if="item.type != 'activity'">
			<!-- 头部 -->
			<view class="userinfo padding-bj">
				<view class="avatar">
					<view @tap="onShop(find.shop_id)" class="cu-avatar round margin-right-bj" :style="{ backgroundImage: 'url(' + $wanlshop.oss(data.shop.avatar, 35, 35, 2, 'avatar') + ')' }"></view>
					<view>
						<view>
							<text @tap="onShop(data.shop_id)" class="text-df text-bold5 wanl-black margin-right-bj">{{data.shop.shopname}}</text>
							<view v-if="data.isLive" @tap="onLive(data.isLive.id)" class="cu-tag sm wanl-bg-orange round"><text class="wlIcon-zhibo"></text>直播中</view>
						</view>
						<view class="wanl-gray text-sm">{{$wanlshop.timeToDate(item.createtime)}}</view>
					</view>
				</view>
				<block v-if="data.isShopBut">
					<view class="cu-btn round line-red sm"  @tap="onShop(data.shop_id)"> <text class="wlIcon-dianpu1"></text> 进店 </view>
				</block>
				<block v-else >
					<view class="cu-tag round bg-white" v-if="data.isFollow" @tap="onFollow(data.shop_id)">
						<text class="wlIcon-31xuanze"></text>已关注
					</view>
					<view class="cu-tag round bg-orange" v-else @tap="onFollow(data.shop_id)">
						<text class="wlIcon-guanzhu3"></text>关注
					</view>
				</block>
			</view>
			<!-- 内容 -->
			<view class="content padding-lr-bj" v-if="item.type == 'new'">
				<view class="flex align-center">
					<view class="calendar text-center" :style="{ backgroundImage: 'url(' + $wanlshop.appstc('/common/calendar.png') + ')' }">
						{{item.createtime_date}}
					</view>
					<view class="margin-left-xs">
						<text class="text-bold">今日上新</text>
					</view>
				</view>
				<view class="wanl-gray-dark padding-tb-sm">
					<rich-text :nodes="item.content"></rich-text>
				</view>
				<wanl-more :goods="item.goods"/>
			</view>
			<view class="content" v-if="item.type == 'want' || item.type == 'show'">
				<view class="swiper-box">
					<swiper circular="true" @change="swiperChange($event,index)">
						<swiper-item v-for="(swiper, key) in item.images" :key="key"><image :src="$wanlshop.oss(swiper, 400, 0)" mode="aspectFill"></image></swiper-item>
					</swiper>
					<view class="indicator">{{ item.current + 1 }}/{{ item.images.length }}</view>
				</view>
				<scroll-view class="scroll-view padding-top-bj padding-left-bj" :class="[data.goods.length == 1 ? 'padding-right-bj':'']" scroll-x="true">
					<view class="scroll-view-item radius-bock" :class="[item.goods.length == 1 ? 'col-1':'']" v-for="(goods, sub) in item.goods" :key="goods.id" @tap="onGoods(goods.id)">
						<view class="img"><image :src="$wanlshop.oss(goods.image, 50, 50)"></image></view>
						<view class="goodsinfo text-cut text-df">
							{{goods.title}}
							<view class="flex align-center">
								<text class="text-price text-orange">{{goods.price}}</text>
							</view>
						</view>
					</view>
				</scroll-view>
				<view class="wanl-gray-dark padding-lr-bj padding-top-sm">
					<wanl-more :content="item.content"/>
				</view>
			</view>
			<!-- 底部 -->
			<view class="flex justify-between padding-bj align-center">
				<view @tap="showModal('comments', index)" v-if="common.appConfig.comment_switch == 'Y'">
					<view class="cu-avatar round sm margin-right-xs" :style="{ backgroundImage: 'url(' + $wanlshop.oss(user.avatar, 35, 35, 2, 'avatar') + ')' }"></view>
					<text class="text-sm wanl-gray">快来评论吧</text>
				</view>
				<view v-else> </view>
				<view class="flex">
					<view :class="[item.isLike?'wanl-orange':'']" @tap="onLike(item.id,index)">
						<text class="margin-right-xs" :class="[item.isLike?'wlIcon-dianzan1':'wlIcon-dianzan11']"></text>
						{{item.like}}
					</view>
					<view class="margin-left" @tap="showModal('comments', index)" v-if="common.appConfig.comment_switch == 'Y'">
						<text class="wlIcon-pinglun margin-right-xs"></text>
						{{item.comments}}
					</view>
					<view class="margin-left">
						<text class="wlIcon-yueduliang margin-right-xs"></text>
						{{item.views}}
					</view>
				</view>
			</view>
		</view>
		
		
		<view class="WANL-MODAL text-sm" @touchmove.stop.prevent="moveHandle">
			<view class="cu-modal bottom-modal" :class="modalName == 'comments' ? 'show' : ''" @tap="hideModal">
				<view class="cu-dialog" @tap.stop="">
					<view class="wanl-modal">
						<view class="head padding-bj">
							<view class="content"><view class="text-lg">全部评论</view></view>
						</view>
						<view class="listbox padding-lr-bj">
							 <scroll-view scroll-y="true">
								<view class="item margin-bottom-lg" v-for="(item,index) in comments" :key="index">
									<view class="flex justify-between align-center">
										<view class="avatar flex">
											<view class="cu-avatar round margin-right-sm" :style="{ backgroundImage: 'url(' + $wanlshop.oss(item.user.avatar, 35, 35, 2, 'avatar') + ')' }"></view>
											<view>
												<view>
													<text class="text-df text-bold5 wanl-black margin-right-bj">{{item.user.nickname}}</text>
												</view>
												<view class="wanl-gray text-sm">{{$wanlshop.timeToDate(item.createtime)}}</view>
											</view>
										</view>
										<view :class="[item.wanliankeji?'text-orange':'wanl-gray']" @tap="onLikeComment(index)"> <text class="wlIcon-dianzan1 margin-right-xs"></text> {{item.like}} </view>
									</view>
									<view class="margin-top-sm" style="margin-left: 80rpx;">
										{{item.content}}
									</view>
								</view>
							</scroll-view>
						</view>
						<view class="foot flex justify-between align-center">
							<view class="input">
								<input type="text" placeholder="点击回复" v-model="newComments" name="input"></input>
							</view>
							
							<view class="text-xxl text-orange" @tap="addComment()">
								<text class="wlIcon-zhifeiji"></text>
							</view>
						</view>
					</view>
				</view>
			</view>
		</view>
		<!-- 结束 -->
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
				iShead: false,
				height: 0,
				find_id: 0,
				comments_find_id: 0,
				comments_find_id_index: -1,
				data: {
					shop: {
						avatar: '',
						shopname: '加载中...'
					}
				},
				comments: [],
				newComments: '',
				modalName: null,
				listData: [], //列表
				current_page: 1, //当前页码
				last_page: 1, //总页码
				status: 'loading',
				contentText: {
					contentdown: '',
					contentrefresh: '加载中',
					contentnomore: '- 我是有底线的 -'
				}
			}
		},
		computed: {
			...mapState(['user', 'common'])
		},
		onLoad(option) {
			this.find_id = option.id;
			this.loadData();
		},
		onPageScroll(e) {
			this.iShead = e.scrollTop > this.height ? true : false;
		},
		onReachBottom() {
			//判断是否最后一页
			if (this.current_page >= this.last_page) {
				this.status = 'noMore';
			} else {
				this.current_page = this.current_page + 1; //页码+1
				this.status = 'loading';
				this.loadList();
			}
		},
		methods: {
			async loadData(){
				this.$api.get({
					url: '/wanlshop/find/details',
					data: {
						id: this.find_id
					},
					success: res => {
						this.data = res; //评论数据 追加
						this.loadList(res.shop_id);
						// 计算锚点高度
						setTimeout(() => {
							this.calcAnchor();
						}, 1000);
					}
				});
			},
			async loadList(shop_id){
				this.$api.get({
					url: '/wanlshop/find/lists',
					data: {
						id: this.data.id,
						shop_id: shop_id,
						page: this.current_page
					},
					success: res => {
						uni.stopPullDownRefresh();
						this.listData = this.listData.concat(res.data); //评论数据 追加
						this.current_page = res.current_page; //当前页码
						this.last_page = res.last_page; //总页码
						this.status = res.total == 0 ? 'noMore' : 'more';
					}
				});
			},
			// 关注 & 取消关注
			onFollow(shop_id){
				this.data.isFollow = !this.data.isFollow;
				// 后续版本遍历整个find
				this.$api.post({
					url: '/wanlshop/shop/follow',
					data: {
						id: shop_id
					},
					success: res => {
						this.data.isFollow = res;
					}
				});
			},
			// 喜欢 & 取消喜欢
			onLike(id, index = 0){
				if(index == 0){
					var find = this.data;
				}else{
					var find = this.listData[index];
				}
				find.isLike = !find.isLike;
				if (find.isLike) {
					find.like += 1;
				}else{
					find.like -= 1;
				}
				this.$api.post({
					url: '/wanlshop/find/setFollow',
					data: {id: id},
					success: res => {
						find.isLike = res;
					}
				});
			},
			//轮播图指示器
			swiperChange(e,index) {
				if (index) {
					this.listData[index].current = e.detail.current;
				}else{
					this.data.current = e.detail.current;
				}
			},
			//计算锚点高度
			calcAnchor() {
				const query = uni.createSelectorQuery().in(this);
				query.select('#main').boundingClientRect(data => {
					this.height = data.height;
				}).exec();
			},
			// 弹出层
			async showModal(name, index = null) {
				this.comments_find_id = index == null ? this.data.id : this.listData[index].id;
				this.comments_find_id_index = index == null ? '-1' : index;
				this.$api.get({
					url: '/wanlshop/find/comments',
					data: {
						find_id: this.comments_find_id,
					},
					success: res => {
						this.comments = res;
						this.modalName = name;
					}
				});
			},
			// 关闭弹出层
			hideModal() {
				this.modalName = null;
			},
			//禁止父元素滑动
			moveHandle() {
				
			},
			async onLikeComment(index){
				this.comments[index].wanliankeji = !this.comments[index].wanliankeji;
				this.$api.get({
					url: '/wanlshop/find/commentsLike',
					data: {
						id: this.comments[index].id,
						state: this.comments[index].wanliankeji
					},
					success: res => {
						if (this.comments[index].wanliankeji) {
							this.comments[index].like += 1;
						}else{
							this.comments[index].like -= 1;
						}
					}
				});
			},
			async addComment(){
				this.$api.post({
					url: '/wanlshop/find/addComments',
					data: {
						find_id: this.comments_find_id,
						content: this.newComments
					},
					success: res => {
						this.$wanlshop.msg('评论成功');
						if (this.comments_find_id_index == '-1') {
							this.data.comments += 1;
						}else{
							this.listData[this.comments_find_id_index].comments += 1;
						}
					}
				});
				this.newComments = null;
				this.hideModal();
			}
		}
	}
</script>

<style>
	
	.listbox scroll-view{
		height: 560rpx;
	}
	.wanl-modal {
		padding-bottom: 125rpx !important;
	}
	.wanl-modal .foot{
		text-align: left;
		padding: 0 25rpx;
		height: 100rpx !important;
		background-color: #f2f2f2;
	}
	.input{
		width: calc(100% - 70rpx);
	}
	.wanl-modal .foot input{
		background-color: #fff;
		height: 70rpx;
		padding: 0 25rpx;
		border-radius: 10rpx;
	}
	
	
	
	
	
	
	
	
	
	.wanl-find .content .calendar{
		width: 50rpx;
		height: 50rpx;
		line-height: 60rpx;
		background-size: 100%;
		font-size: 22rpx;
		font-weight: 600;
	}
	.cu-custom .cu-bar .content {
	    width: calc(100% - 450rpx);
	}
	.cu-custom .userinfo{
		display: flex;
		align-items: center;
		justify-content: space-between;
	}
	.cu-custom .userinfo .cu-avatar{
		flex-shrink: 0;
		width: 56rpx;
		height: 56rpx;
		overflow: hidden;
		border-radius: 1000px;
		margin: 0 !important;
	}
	.swiper-box {
		position: relative;
		background-color: #f7f7f7;
		width: 100%;
		height: 100vw;
	}
	
	.swiper-box swiper {
		width: 100%;
		height: 100vw;
	}
	
	.swiper-box swiper swiper-item image {
		width: 100%;
		height: 100vw;
	}
	
	.swiper-box .indicator {
		display: flex;
		justify-content: center;
		align-items: center;
		padding: 0 25upx;
		height: 40upx;
		border-radius: 40upx;
		font-size: 22upx;
		position: absolute;
		bottom: 20upx;
		right: 20upx;
		color: #fff;
		background-color: rgba(0, 0, 0, 0.2);
	}
	.wanl-find .scroll-view-item .img{
		margin: 0 10rpx;
	}
	.wanl-find .scroll-view-item .img,
	.wanl-find .scroll-view-item .img image
	{
		height: 80rpx;
		width: 80rpx;
		border-radius: 18rpx;
	}
	.scroll-view-item .goodsinfo{
		line-height: 1.2;
	}
</style>
