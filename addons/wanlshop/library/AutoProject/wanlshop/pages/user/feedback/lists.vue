<template>
	<view>
		<view class="edgeInsetTop"></view>
		<view class="wanl-goods-comment">
			<wanl-empty text="没有找到任何反馈" v-if="listData.length == 0"></wanl-empty>
			<view class="list padding-bj radius-bock" v-for="item in listData" :key="item.id">
				<view class="userinfo">
					<view class="avatar">
						<view class="cu-avatar round margin-right-xs" :style="{ backgroundImage: 'url(' + $wanlshop.oss(user.avatar, 35, 35, 2, 'avatar') + ')' }"></view>
						<view class="text-sm">
							<view>{{ user.nickname }}</view>
							<view class="text-gray">{{ $wanlshop.timeToDate(item.createtime) }}</view>
						</view>
					</view>
					<wanl-rate :current="item.score" :disabled="true" />
				</view>
				<view class="details">
					<view class="margin-bottom-sm">
						<text class="cu-tag sm radius margin-right-xs wanl-bg-orange">
							{{item.status_text}}  
						</text>
						{{ item.content || '没有反馈内容~'}}
					</view>
				</view>
				<view class="grid flex-sub grid-square" :class="[item.images.length > 3 ? 'col-3' : 'col-' + item.images.length]">
					<view
						class="bg-img"
						v-for="(image, index) in item.images"
						:key="index"
						@tap="previewImage(item.images, index)"
						:style="{ backgroundImage: 'url(' + $wanlshop.oss(image, 248, 0) + ')' }"
					></view>
				</view>
				<view class="goods margin-bottom-bj padding-bj radius" v-if="item.contact">
					官方回复：{{item.contact}}
				</view>
			</view>
		</view>
		<uni-load-more :status="status" :content-text="contentText" />
		<view class="edgeInsetBottom"></view>
		
	</view>
</template>

<script>
import { mapState } from 'vuex';
export default {
	computed: { ...mapState(['user']) },
	data() {
		return {
			listData: [], //列表
			reload: false, //判断是否上拉
			current_page: 1, //当前页码
			last_page: 1, //总页码
			status: 'loading',
			contentText: {
				contentdown: ' ',
				contentrefresh: '加载中',
				contentnomore: ''
			}
		};
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
				url: '/wanlshop/feedback/lists',
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

<style></style>
