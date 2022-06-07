<template>
	<view>
		<view class="edgeInsetTop"></view>
		<view class="wanl-goods-comment">
			<view class="padding-bj bg-white margin-bottom-bj head">
				<view class="padding-bottom-bj solid-bottom">
					好评率
					<text class="margin-left-xs">{{ statisticsData.rate }}%</text>
				</view>
				<!-- 标签 -->
				<view>
					<view @tap="onTag('')" class="cu-tag round" :class="{ active: tag == '' }">全部 ({{ statisticsData.total }})</view>
					<view @tap="onTag('good')" class="cu-tag round" :class="{ active: tag == 'good' }">好评 ({{ statisticsData.good }})</view>
					<view @tap="onTag('pertinent')" class="cu-tag round" :class="{ active: tag == 'pertinent' }">中评 ({{ statisticsData.pertinent }})</view>
					<view @tap="onTag('poor')" class="cu-tag round" :class="{ active: tag == 'poor' }">差评 ({{ statisticsData.poor }})</view>
					<view @tap="onTag('figure')" class="cu-tag round" :class="{ active: tag == 'figure' }">有图 ({{ statisticsData.figure }})</view>
					<!-- <view @tap="onTag(index)" class="cu-tag round" :class="{ active: tag == index }" v-for="(number, index) in tagData" :key="number">
						{{ index }}({{ number }})
					</view> -->
				</view>
			</view>
			<view class="list padding-bj radius-bock" v-for="item in listData" :key="item.id">
				<view class="userinfo">
					<view class="avatar">
						<view class="cu-avatar round margin-right-xs" :style="{ backgroundImage: 'url(' + $wanlshop.oss(item.user.avatar, 35, 35, 2, 'avatar') + ')' }"></view>
						<view class="text-sm">
							<view>{{ item.user.nickname }}</view>
							<view class="text-gray">{{ $wanlshop.timeToDate(item.createtime) }}</view>
						</view>
					</view>
					<wanl-rate :current="item.score" :disabled="true" />
				</view>

				<view class="details">
					<view class="margin-bottom-sm">{{ item.content }}</view>
					<view class="text-gray text-sm">规格：{{ item.suk }}</view>
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
			</view>
			<uni-load-more :status="status" :content-text="contentText" />
		</view>
	</view>
</template>

<script>
export default {
	data() {
		return {
			listData: [], //列表
			// tagData: [], //标签数据
			statisticsData: {
				rate: 0,
				good: 0,
				pertinent: 0,
				poor: 0,
				figure: 0
			}, //统计
			reload: false, //判断是否上拉
			total: 0, //数据量
			current_page: 1, //当前页码
			last_page: 1, //总页码
			goods_id: 0, //商品ID
			tag: '', //查询的标签
			status: 'loading',
			contentText: {
				contentdown: ' ',
				contentrefresh: '加载中',
				contentnomore: ''
			}
		};
	},
	onLoad(option) {
		this.goods_id = option.id;
		this.tag = option.tag ? option.tag : '';
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
			//加载商品
			this.$api.get({
				url: '/wanlshop/product/comment',
				data: {
					id: this.goods_id,
					page: this.current_page,
					tag: this.tag
				},
				success: res => {
					uni.stopPullDownRefresh();
					this.listData = this.reload ? res.comment.data : this.listData.concat(res.comment.data); //评论数据 追加
					this.total = res.comment.total; //数据量
					this.current_page = res.comment.current_page; //当前页码
					this.last_page = res.comment.last_page; //总页码
					this.statisticsData = res.statistics; // 统计数据
					// this.tagData = res.tag; //标签数据
					this.status = res.comment.total == 0 ? 'noMore':'more';
				}
			});
		},
		/**
		 * @param {Object} image 图片数组
		 * @param {Object} index 键名
		 */
		previewImage(image, index) {
			//预览图片
			var imgArr = [];
			for (var item of image) {
				imgArr = imgArr.concat(this.$wanlshop.oss(item, 500, 0));
			}
			uni.previewImage({
				urls: imgArr,
				current: imgArr[index],
				indicator: 'number'
			});
		},
		/**
		 * 搜索标签- 跟下拉刷新同理
		 * @param {Object} tag
		 */
		onTag(tag) {
			this.current_page = 1;
			this.reload = true;
			this.tag = tag;
			this.loadData();
		}
	}
};
</script>

<style></style>
