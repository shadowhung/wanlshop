<template>
	<view>
		<view class="edgeInsetTop"></view>
		<view class="bg-white padding-bj flex">
			<view class="cu-avatar xl margin-right-bj" :style="{backgroundImage: 'url('+$wanlshop.oss(refund.goods.image, 70, 70)+')'}"> </view>
			<view class="text-sm" style="width: calc(100% - 128rpx);">
				<view class="margin-bottom-xs">
					<view class="text-cut-2">
						{{refund.goods.title}}
					</view>
				</view>
				<view class="wanl-gray">
					规格：{{refund.goods.difference}}
				</view>
			</view>
		</view>
		<view class="margin-top-bj">
			<view class="cu-form-group">
				<view class="title">物流状态</view>
				<picker @change="expressChange" :value="refund.expressType" :range="expressList">
					<view class="picker">
						{{expressList[refund.expressType]}}
					</view>
				</picker>
			</view>
			<view class="cu-form-group">
				<view class="title">退款类型</view>
				<picker @change="typeChange" :value="refund.type" :range="typeList">
					<view class="picker">
						{{typeList[refund.type]}}
					</view>
				</picker>
			</view>
			<view class="cu-form-group">
				<view class="title">退款原因</view>
				<picker @change="reasonChange" :value="refund.reason" :range="reasonList">
					<view class="picker">
						{{reasonList[refund.reason]}}
					</view>
				</picker>
			</view>
			<view class="cu-form-group margin-top-bj">
				<view class="title">退款金额<text class="text-price margin-left-xs"></text></view>
				<input type="digit" :placeholder="amount.info" @input="moneyInput" :value="refund.price" :disabled="amount.total == 0"></input>
			</view>
			<view class="bg-white margin-top-bj">
				<view class="cu-form-group">
					<view class="title">上传凭证</view>
				</view>
				<view class="grid col-4 grid-square flex-sub padding-lr">
					<view class="bg-img" v-for="(item, index) in refund.images" :key="index" @tap="viewImage(index)">
						<image :src="$wanlshop.oss(item, 90, 90)" mode="aspectFill"></image>
						<view class="cu-tag bg-red" @tap.stop="delImg(index)"><text class="wlIcon-31guanbi"></text></view>
					</view>
					<view class="dashed" @tap="chooseImage" v-if="refund.images.length < 4">
						<text class="wlIcon-31paishe"></text>
					</view>
				</view>
			</view>
			<view class="cu-form-group margin-top-bj">
				<view class="title">退款理由</view>
				<input placeholder="选填" v-model="refund.refund_content"></input>
			</view>
		</view>
		<view class="edgeInsetBottom"> </view>
		<view class="wanlian cu-bar tabbar foot flex flex-direction">
			<button class="cu-btn wanl-bg-orange lg" @tap="addData">确认</button>
		</view>
	</view>
</template>


<script>
export default {
	data() {
		return {
			// 退款
			refund:{
				expressType: -1,
				type: -1,
				reason: -1,
				images: [],
				goods: {},
				freight_type: 0,
			},
			expressList: ['未收到货', '已收到货'],
			typeList: ['我要退款(无需退货)', '退货退款'],
			reasonList: ['不喜欢', '空包裹', '一直未送达', '颜色/尺码不符', '质量问题', '少件漏发', '假冒品牌'],
			// 价格
			amount:{
				total: 0,
				freight: 0,
				info: ''
			}
		};
	},
	onLoad(option) {
		this.loadData(option.id);
	},
	methods: {
		async loadData(id){
			this.$api.get({
				url: '/wanlshop/refund/getRefundInfo',
				data: {id: id},
				success: res => {
					this.refund = res;
					var price = res.goods.price * res.goods.number;
					var freight_price = parseInt(res.goods.freight_price);
					this.amount.freight = freight_price;
					//计算运费价格,当只有一个商品或 运费策略累加运费可全退
					if(res.goods_number == 1 || res.freight_type == 2){
						this.amount.info = `最多退款${price + freight_price}元，包含运费${freight_price}元`;
						this.amount.total = price + freight_price;
					}else{
						this.amount.info = `最多退${price}元，运费策略不含运费${freight_price}元`;
						this.amount.total = price;
					}
				}
			});
		},
		async addData(){
			if (this.refund.price <= 0) {
				this.$wanlshop.msg('价格不能为空');
				return false;
			}
			if (this.refund.price > this.amount.total) {
				this.$wanlshop.msg('退款不能超过￥'+this.amount.total+'元');
				return false;
			}
			// 提交
			this.$api.post({
				url: '/wanlshop/refund/editRefund',
				data: {
					id: this.refund.id,
					expressType: this.refund.expressType,
					type: this.refund.type,
					reason: this.refund.reason,
					price: this.refund.price,
					images: this.refund.images,
					refund_content: this.refund.refund_content
				},
				success: res => {
					// 跳转到退款详情页,更新中央控制总线
					this.$wanlshop.to(`/pages/user/refund/details?id=${res}`);
				}
			});
		},
		
		// 退款金额
		moneyInput(e) {
			let money = e.detail.value;
			if (money > this.amount.total) {
				this.$wanlshop.msg('退款不能超过￥'+this.amount.total+'元');
			}
			// 判断是否超过订单总额,超过提示
			this.refund.price = money
		},
		
		
		
		
		
		expressChange(e) {
			this.refund.expressType = e.detail.value
		},
		typeChange(e) {
			this.refund.type = e.detail.value
		},
		reasonChange(e) {
			this.refund.reason = e.detail.value
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
												this.refund.images.push(data.fullurl);
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
		viewImage(key) {
			uni.previewImage({
				urls: this.refund.images,
				current: this.refund.images[key]
			});
		},
		delImg(key) {
			this.refund.images.splice(key, 1);
		}
	}
};
</script>

<style>
	.dashed::after {
	    border: 1px dashed #666;
	}
	.cu-btn.lg{
		width: calc(100% - 50rpx);
	}
</style>
