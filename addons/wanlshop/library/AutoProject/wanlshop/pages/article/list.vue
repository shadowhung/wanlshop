<template>
	<view class="wanl-news">
		<view class="edgeInsetTop"> </view>
		<!-- 幻灯片 -->
		<!-- <view class="">
			<swiper class="screen-swiper square-dot" :indicator-dots="true" :circular="true" :autoplay="true" interval="5000" duration="500">
				<swiper-item v-for="(item,index) in swiperList" :key="index">
					<image :src="item.url" mode="aspectFill" v-if="item.type=='image'"></image>
					<video :src="item.url" autoplay loop muted :show-play-btn="false" :controls="false" objectFit="cover" v-if="item.type=='video'"></video>
				</swiper-item>
			</swiper>
		</view> -->
		<!-- 文章列表 -->
		<view class="box">
			<view class="bg-white text-df padding-bj" v-for="(item,index) in dataList" :key="item.id" @tap="onDetails(item.id, item.title)">
				<view class="flex flex-direction" v-if="item.images.length > 2">
					<view class="wanl-news-image justify-between">
						<block v-for="(img, key) in item.images" :key="key" v-if="key<= 2">
							<image :src="$wanlshop.oss(img, 125, 100)" mode=""></image>
						</block>
						<view class="tag">{{item.images.length}}图</view>
					</view>
				
					<view class="wanl-news-box flex-direction justify-between">
						<view class="title padding-top-sm text-lg">{{item.title}}</view>
						<view class="wanl-sub-box padding-top-sm">
							<view class="text-sm">{{item.createtime_text}}</view>
							<view class="cmt">
								<view>{{item.views}} 浏览</view>
								<block v-if="item.flag">
									<view v-if="item.flag == 'hot'" class="cu-tag sm bg-orange radius margin-left-xs"><view>{{item.flag_text}}</view></view>
									<view v-if="item.flag == 'index'" class="cu-tag sm bg-blue radius margin-left-xs"><view>{{item.flag_text}}</view></view>
									<view v-if="item.flag == 'recommend'" class="cu-tag sm bg-red radius margin-left-xs"><view>{{item.flag_text}}</view></view>
								</block>
							</view>
						</view>
					</view>
				</view>
				<block v-else>
					<view class="flex align-start" v-if="item.image">
						<view class="wanl-news-image"><image :src="$wanlshop.oss(item.image, 120, 100)" mode=""></image></view>
						<view class="wanl-news-box flex-direction justify-between padding-left-sm">
							<view class="title text-lg">{{item.title}}</view>
							<view class="wanl-sub-box">
								<view class="text-sm">{{item.createtime_text}}</view>
								<view class="cmt">
									<view>{{item.views}} 浏览</view>
									<block v-if="item.flag">
										<view v-if="item.flag == 'hot'" class="cu-tag sm bg-orange radius margin-left-xs"><view>{{item.flag_text}}</view></view>
										<view v-if="item.flag == 'index'" class="cu-tag sm bg-blue radius margin-left-xs"><view>{{item.flag_text}}</view></view>
										<view v-if="item.flag == 'recommend'" class="cu-tag sm bg-red radius margin-left-xs"><view>{{item.flag_text}}</view></view>
									</block>
								</view>
							</view>
						</view>
					</view>
					<view class="flex flex-direction" v-else>
						<view class="wanl-news-box flex-direction justify-between">
							<view class="title padding-top-sm text-lg">{{item.title}}</view>
							<view class="wanl-sub-box padding-top-sm">
								<view class="text-sm">{{item.createtime_text}}</view>
								<view class="cmt">
									<view>{{item.views}} 浏览</view>
									<block v-if="item.flag">
										<view v-if="item.flag == 'hot'" class="cu-tag sm bg-orange radius margin-left-xs"><view>{{item.flag_text}}</view></view>
										<view v-if="item.flag == 'index'" class="cu-tag sm bg-blue radius margin-left-xs"><view>{{item.flag_text}}</view></view>
										<view v-if="item.flag == 'recommend'" class="cu-tag sm bg-red radius margin-left-xs"><view>{{item.flag_text}}</view></view>
									</block>
								</view>
							</view>
						</view>
					</view>
				</block>
			</view>
		</view>
		<!-- 加载更多 -->
		<view class="edgeInsetBottom"></view>
		<uni-load-more :status="status" :content-text="contentText" />
	</view>
</template>

<script>
export default {
	data() {
		return {
			dataList: [],
			reload: false, //判断是否上拉
			total: 0, //数据量
			current_page: 1, //当前页码
			last_page: 1, //总页码
			status: 'more',
			contentText: {
				contentdown: ' ',
				contentrefresh: '加载中',
				contentnomore: ''
			}
		};
	},
	onLoad() {
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
			this.$api.post({
				url: '/wanlshop/article/getList',
				data: {
					type: 'new',
					page: this.current_page
				},
				success: res => {
					uni.stopPullDownRefresh();
					this.dataList = this.reload ? res.data : this.dataList.concat(res.data); //数据 追加
					this.total = res.total; //数据量
					this.current_page = res.current_page; //当前页码
					this.last_page = res.last_page; //总页码
					this.status = res.total == 0 ? 'noMore' : 'more';
				}
			});
		}
	}
};
</script>

<style>
	.wanl-news-image {
		display: flex;
		position: relative;
	}
	
.flex.align-start .wanl-news-image {
	width: 220rpx;
	height: 180rpx;
}
.flex.align-start .wanl-news-box {
	height: 180rpx;
}
.wanl-news-image image{
	height: 180rpx;
}

.wanl-news-image.justify-between image {
	width: 32%;
	height: 180rpx;
}



.wanl-news-image .tag {
	position: absolute;
	right: 0;
	bottom: 0;
	font-size: 24rpx;
	color: #fff;
	padding: 2rpx 12rpx;
	background: rgba(0, 0, 0, 0.6);
	z-index: 20;
	transform: scale(0.8);
	transform-origin: 100% 100%;
}
.wanl-news-image.video image {
	height: 280rpx;
	width: 100%;
}
.wanl-news-image.video .icon {
	position: absolute;
	z-index: 10;
	display: flex;
	align-items: center;
	justify-content: center;
	left: 50%;
	top: 50%;
	transform: translate(-50%, -50%);
	transform-origin: 0 0;
}
.wanl-news-image.video .icon text[class*='wlIcon-'] {
	background: rgba(0, 0, 0, 0.5);
	border-radius: 50%;
	padding: 26rpx;
}

.wanl-news-box {
	flex: 1;
	width: 100%;
	box-sizing: border-box;
	display: flex;
}
.wanl-news-box .title {
	width: 100%;
	word-break: break-all;
	word-wrap: break-word;
	overflow: hidden;
	text-overflow: ellipsis;
	display: -webkit-box;
	-webkit-box-orient: vertical;
	-webkit-line-clamp: 2;
	box-sizing: border-box;
}
.wanl-sub-box {
	display: flex;
	align-items: center;
	justify-content: space-between;
	color: #999;
	box-sizing: border-box;
	line-height: 24rpx;
}
.wanl-sub-box .cmt {
	font-size: 24rpx;
	line-height: 24rpx;
	display: flex;
	align-items: center;
}
</style>
