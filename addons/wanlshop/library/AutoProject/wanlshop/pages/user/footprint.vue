<template>
	<view class="wanl-footprint">
		<view class="edgeInsetTop"></view>
		<view v-if="isData" v-for="(item, footprint) in arrData.groups" :key="footprint">
			<view class="wanl-gray text-sm margin-sm">
				{{ footprint }}
			</view>
			<view class="box">
				<view class="item" v-for="(data, goods) in item" :key="goods">
					<block v-if="data.goods.price">
						<image :src="$wanlshop.oss(data.goods.image, 136, 126)" @tap="onGoods(data.goods_id)"></image>
						<view class="text-price margin-sm text-orange">{{data.goods.price}}</view>
					</block>
					<block v-else>
						<view class="empty">
							<text class="wlIcon-fuwuqi1"></text>
						</view>
						<view class="margin-sm wanl-gray-light">商品不存在</view>
					</block>
				</view>
			</view>
		</view>
		<view v-if="dataList.length == 0">
			<wanl-empty src="find_default3x" text="没有发现任何足迹"/>
		</view>
		<uni-load-more :status="status" :content-text="contentText" />
	</view>
</template>

<script>
export default {
	data() {
		return {
			dataList: [],
			isData: true, //判断是否存在数据
			arrData: [],
			reload: false, //判断是否上拉
			total: 0, //数据量
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
			this.$api.get({
				url: '/wanlshop/product/footprint',
				data: {
					page: this.current_page
				},
				success: res => {
					uni.stopPullDownRefresh();
					this.dataList = this.reload ? res.data : this.dataList.concat(res.data); //数据 追加
					this.isData = this.dataList.length == 0 ? false : true; //判断是否存在数据
					this.arrData = this.formatData(this.dataList);
					this.total = res.total; //数据量
					this.current_page = res.current_page; //当前页码
					this.last_page = res.last_page; //总页码
					this.status = res.total == 0 ? 'noMore':'more';
				}
			});
		},
		formatData(data) {
			var groups = {},
				categories = [];
			data.forEach(res => {
				var cate = this.getLocalTime(res.createtime);
				if (!groups[cate]) {
					groups[cate] = [];
					categories.push(cate);
				}
				groups[cate].push(res);
			});
			return { groups, categories };
		},
		getLocalTime(nS) {  
			return new Date(parseInt(nS) * 1000).toLocaleDateString().replace(/\//g, '-')
		}
	}
};
</script>

<style>
.wanl-footprint .box {
	display: flex;
	flex-wrap: wrap;
	justify-content: space-between;
}
.wanl-footprint .box:after { 
	content: ""; 
	width: 33%;
}  
.wanl-footprint .box .item {
	width: 33%;
	background-color: #ffffff;
	margin-bottom: 5rpx;
}
.wanl-footprint .box .item image{
	height: 230rpx;
}
.wanl-footprint .empty{
	background-color: #f2f2f2;
	line-height: 230rpx;
	text-align: center;
	height: 230rpx;
	width: 100%;
	font-size: 100rpx;
}
.wanl-footprint .empty text{
	color: #d5d5d5;
}
</style>
