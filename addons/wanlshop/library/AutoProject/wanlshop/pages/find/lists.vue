<template>
	<view>
		<view class="edgeInsetTop"></view>
		<view class="wanl-find" v-for="(find, index) in listData" :key="find.id">
			<view class="margin-bj bg-white radius-bock padding-lr-bj padding-top-bj">
				<view class="userinfo">
					<view class="avatar">
						<view @tap="onShop(find.shop_id)" class="cu-avatar round margin-right-bj" :style="{ backgroundImage: 'url(' + $wanlshop.oss(find.shop.avatar, 35, 35, 2, 'avatar') + ')' }"></view>
						<view>
							<view>
								<text @tap="onShop(find.shop_id)" class="text-30 wanl-black margin-right-bj">{{find.shop.shopname}}</text>
								<view v-if="find.isLive" @tap="onLive(find.isLive.id)" class="cu-tag sm bg-red round"><text class="wlIcon-zhibo"></text>直播中</view>
							</view>
							<view class="text-gray text-sm">{{$wanlshop.timeToDate(find.createtime)}}</view>
						</view>
					</view>
					<view class="cu-btn round line-red sm"  @tap="onShop(find.shop_id)"> <text class="wlIcon-dianpu1"></text> 进店 </view>
				</view>
				<view class="content margin-tb-sm wanl-gray-dark text-cut-2" @tap="onFind(find)">
					<view class="cu-tag sm radius margin-right-xs" :class="[typeList[find.type]]">{{find.type_text}}</view> {{formatHtml(find.content)}}
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
									<view class="number text-white">
										<view>{{$wanlshop.toFormat(find.live.goods_ids.split(',').length,'hundred')}}</view>
										<text>商品</text> 
									</view>
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
				<scroll-view class="scroll-view margin-top-xs" scroll-x="true">
					<view class="scroll-view-item radius-bock" 
					:class="[find.goods.length == 1 ? 'col-1':'']" v-for="(goods, sub) in find.goods" :key="goods.id" @tap="onGoods(goods.id)">
						<view class="img"><image :src="$wanlshop.oss(goods.image, 50, 50)"></image></view>
						<view class="content padding-left-bj text-cut text-30">
							{{goods.title}}
							<view class="flex align-center">
								<text class="text-price text-orange">{{goods.price}}</text>
							</view>
						</view>
						<view class="icon text-lg wanl-gray-light"><text class="wlIcon-fanhui6"></text></view>
					</view>
				</scroll-view>
				<view class="flex justify-between padding-tb-bj align-center">
					<view class="wanl-gray-light text-sm" @tap="onFind(find)">{{find.views}} 阅读</view>
					<view class="flex">
						<view class="margin-right" :class="[find.isLike?'wanl-orange':'']" @tap="onLike(index)">
							<text class="margin-right-xs" :class="[find.isLike?'wlIcon-dianzan1':'wlIcon-dianzan11']"></text>
							{{find.like}}
						</view>
						<view @tap="onFind(find)">
							<text class="wlIcon-pinglun margin-right-xs"></text>
							{{find.comments}}
						</view>
					</view>
				</view>
				<view class="padding-tb-bj solid-top text-center text-orange" v-if="find.newGoods != 0" @tap="onShop(find.shop_id)">
					进店查看 {{find.newGoods}} 件新品
					<text class="wlIcon-fanhui6 margin-left-xs"></text>
				</view>
			</view>
		</view>
		
		
		
		<view v-if="listData.length == 0">
			<wanl-empty src="find_default3x" :text="'没有找到任何点赞'"/>
		</view>
		<uni-load-more v-else :status="status" :content-text="contentText" />
		<view class="edgeInsetBottom"></view>
	</view>
</template>

<script>
	export default {
		data() {
			return {
				listData: [], //列表
				typeList: {
					new: 'bg-gradual-yellow',
					live: 'bg-gradual-orange',
					want: 'bg-gradual-green',
					activity: 'bg-gradual-orange',
					show: 'wanl-bg-pink'
				},
				reload: false, //判断是否上拉
				current_page: 1, //当前页码
				last_page: 1, //总页码
				status: 'loading',
				contentText: {
					contentdown: ' ',
					contentrefresh: '加载中',
					contentnomore: '- 我是有底线的 -'
				}
			}
		},
		onLoad(option) {
			this.loadData();
		},
		onPullDownRefresh() {
			this.current_page = 1;
			this.reload = true;
			this.loadData();
		},
		onReachBottom() {
			//判断是否最后一页
			if (this.current_page >= this.last_page) {
				this.status = 'noMore';
			} else {
				this.reload = false;
				this.current_page = this.current_page + 1; //页码+1
				this.status = 'loading';
				this.loadData();
			}
		},
		methods: {
			async loadData() {
				this.$api.get({
					url: '/wanlshop/find/follow',
					data: {
						page: this.current_page
					},
					success: res => {
						uni.stopPullDownRefresh();
						this.listData = this.reload ? res.data : this.listData.concat(res.data); //评论数据 追加
						this.current_page = res.current_page; //当前页码
						this.last_page = res.last_page; //总页码
						this.status = res.total == 0 ? 'noMore' : 'more';
					}
				});
			},
			// 喜欢 & 取消喜欢
			onLike(index){
				var find = this.listData[index];
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
			// 格式化html
			formatHtml(content){
				return (content.replace(/<\/?.+?>/g,"").replace(/ /g,""));
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
	}
</script>

<style>

</style>