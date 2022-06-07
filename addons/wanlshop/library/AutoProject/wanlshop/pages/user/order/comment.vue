<template>
	<view class="wanl-comment">
		<view class="edgeInsetTop"></view>
		<view class="subject margin-lr-bj bg-white radius-bock margin-bottom-bj" v-for="(item, index) in goodsList" :key="item.id">
			<view class="goods padding-bj">
				<view class="cu-avatar radius-bock" :style="{ backgroundImage: 'url(' + $wanlshop.oss(item.image, 40,40) + ')' }"></view>
				<view class="content">
					<view class="text-lg text-cut">
						<text>{{item.title}}</text>
					</view>
					<view class="wanl-gray-dark">{{item.difference}}</view>
				</view>
			</view>
			<view class="comment padding-lr-bj padding-top-bj">
				<view class="comment-title">商品评价</view>
				<view class="comment-operate">
					<view class="item" :class="{action:item.state==0}"  @tap="stateType(0,index)">
						<text class="wlIcon-haoping"></text>
						好评
					</view>
					<view class="item" :class="{action:item.state==1}" @tap="stateType(1,index)">
						<text class="wlIcon-chaping"></text>
						中评
					</view>
					<view class="item" :class="{action:item.state==2}" @tap="stateType(2,index)">
						<text class="wlIcon-chaping"></text>
						差评
					</view>
				</view>
			</view>
			<view class="describe cu-form-group margin-bj radius-bock padding-bj">
				<textarea maxlength="-1" v-model="item.comment" placeholder="评价下商品~"></textarea>
			</view>
			<view class=""></view>
			<view class="upload cu-form-group padding-lr-bj">
				<view class="grid col-4 grid-square flex-sub">
					<view class="bg-img" v-for="(vo, key) in item.imgList" :key="key" @tap="viewImage(index,key)">
						<image :src="$wanlshop.oss(vo, 40,40)" mode="aspectFill"></image>
						<view class="cu-tag bg-red" @tap.stop="delImg(index, key)"><text class="wlIcon-31guanbi"></text></view>
					</view>
					<view class="solids" @tap="chooseImage(index)" v-if="item.imgList.length < 4">
						<text class="wlIcon-tupian1"></text>
					</view>
				</view>
			</view>
		</view>
		<view class="operate margin-bj padding-bj bg-white radius-bock" v-if="shop.shopname">
			<view class="operate-title" @tap="onShop(shop.id)">
				<text class="wlIcon-dianpu1 margin-right-sm"></text>
				{{shop.shopname}}
			</view>
			<view class="score">
				<view class="title">描述相符</view>
				<wanl-rate :quantity="5" :current="shop.describe" :size="25" normal="#cad0cc" active="#ff4e02" :hollow="true" @change="describeChange" />
				<view class="margin-left wanl-gray-light">
					{{shop.describeInfo}}
				</view>
			</view>
			<view class="score">
				<view class="title">物流服务</view>
				<wanl-rate :quantity="5" :current="shop.logistics" :size="25" normal="#cad0cc" active="#ff4e02" :hollow="true" @change="logisticsChange" />
				<view class="margin-left wanl-gray-light">
					{{shop.logisticsInfo}}
				</view>
			</view>
			<view class="score">
				<view class="title">发货速度</view>
				<wanl-rate :quantity="5" :current="shop.service" :size="25" normal="#cad0cc" active="#ff4e02" :hollow="true" @change="serviceChange" />
				<view class="margin-left wanl-gray-light">
					{{shop.serviceInfo}}
				</view>
			</view>
			<view class="score">
				<view class="title">服务态度</view>
				<wanl-rate :quantity="5" :current="shop.deliver" :size="25" normal="#cad0cc" active="#ff4e02" :hollow="true" @change="deliverChange" />
				<view class="margin-left wanl-gray-light">
					{{shop.deliverInfo}}
				</view>
			</view>
		</view>
		<view class="edgeInsetBottom"> </view>
		<view class="wanlian cu-bar tabbar foot flex flex-direction"><button @tap="addData()" class="cu-btn wanl-bg-orange lg">发布评论</button></view>
	</view>
</template>

<script>
export default {
	data() {
		return {
			order_id: 0,
			shop: {
				id: 0,
				shopname: '',
				describe: 0,
				describeInfo:'',
				logistics: 0,
				logisticsInfo:'',
				service: 0,
				serviceInfo:'',
				deliver: 0,
				deliverInfo:''
			},
			goodsList: []
		};
	},
	onLoad(option) {
		this.loadData(option.order_id);
	},
	methods: {
		async loadData(order_id) {
			this.$api.get({
				url: '/wanlshop/order/getOrderInfo',
				data: {
					id: order_id
				},
				success: res => {
					this.order_id = res.id;
					this.shop.id = res.shop_id;
					this.shop.shopname = res.shop.shopname;
					var newItems = [];
					res.goods.forEach((item,index)=>{
						newItems.push({
							id: item['id'],
							goods_id: item['goods_id'],
							difference: item['difference'],
							image: item['image'],
							title: item['title'],
							imgList: [],
							comment: '',
							state: 0
						});
					})
					this.goodsList = newItems;
				}
			});
		},
		// 提交评论
		async addData() {
			// 判断是否给店铺评分，其他可以不填写，默认好评
			if (this.shop.describe == 0 || this.shop.logistics == 0 || this.shop.service == 0 || this.shop.deliver == 0) {
				this.$wanlshop.msg('请给店铺评分');
				return false;
			}
			let data = {
				order_id : this.order_id,
				shop : {
					id : this.shop.id,
					describe : this.shop.describe,
					logistics : this.shop.logistics,
					service : this.shop.service,
					deliver : this.shop.deliver
				},
				goodsList : this.goodsList
			};
			this.$api.post({
				url: '/wanlshop/order/commentOrder',
				data: data,
				success: res => {
					this.$store.commit('statistics/order', {
						evaluate: this.$store.state.statistics.order.evaluate - 1
					});
					this.$wanlshop.to('/pages/page/success?type=comment');
				}
			});
		},
		stateType(type, index){
			this.goodsList[index].state = type;
		},
		viewImage(index,key) {
			uni.previewImage({
				urls: this.goodsList[index].imgList,
				current: this.goodsList[index].imgList[key]
			});
		},
		delImg(index,key) {
			this.goodsList[index].imgList.splice(key, 1);
		},
		chooseImage(index) {
			uni.chooseImage({
				count: 4, //默认9
				sizeType: ['original', 'compressed'], //可以指定是原图还是压缩图，默认二者都有
				sourceType: ['album'], //从相册选择
				success: res => {
					this.$api.get({
						url: '/wanlshop/common/uploadData',
						success: updata => {
							for (let i = 0; i < res.tempFilePaths.length; i++) {
								// 读取图片宽高
								uni.getImageInfo({
									src: res.tempFilePaths[i],
									success: image => {
										this.$api.upload({
											url: updata.uploadurl,
											filePath: image.path,
											name: 'file',
											formData: updata.storage == 'local' ? null : updata.multipart,
											success: data => {
												this.goodsList[index].imgList.push(data.fullurl);
											}
										});
									}
								});
							}
						}
					});
				}
			});
		},
		describeChange(e) {
			this.shop.describe = e.index;
			this.shop.describeInfo = this.scoreInfo(e.index);
		},
		logisticsChange(e) {
			this.shop.logistics = e.index;
			this.shop.logisticsInfo = this.scoreInfo(e.index);
		},
		serviceChange(e) {
			this.shop.service = e.index;
			this.shop.serviceInfo = this.scoreInfo(e.index);
		},
		deliverChange(e) {
			this.shop.deliver = e.index;
			this.shop.deliverInfo = this.scoreInfo(e.index);
		},
		scoreInfo(index){
			if(index == 1){
				return '极差';
			}else if(index == 2){
				return '差';
			}else if(index == 3){
				return '一般';
			}else if(index == 4){
				return '好';
			}else if(index == 5){
				return '极好';
			}
		}
	}
};
</script>

<style>
	.edgeInsetBottom {
		height: 100rpx;
		height: calc(var(--window-bottom) + 100rpx);
	}
	.wanlian.cu-bar.tabbar {
		background-color: #F7F7F7;
	}
	.wanlian.cu-bar.tabbar .cu-btn {
		width: calc(100% - 50rpx);
	}
	.wanlian.cu-bar.tabbar .cu-btn.lg {
		font-size: 32rpx;
		height: 86rpx;
	}
</style>
