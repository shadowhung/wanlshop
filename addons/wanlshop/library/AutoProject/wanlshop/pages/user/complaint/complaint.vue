<template>
	<view>
		<view class="edgeInsetTop"></view>
		<view class="complaint-title">
		    <view>举报{{typeName}}理由 </view>
			<view class="complaint-quick text-red">
				<text class="margin-right-xs">{{typeName}}ID:{{complaintId}}</text>
			</view>
		</view>
		<view class="cu-form-group">
			<picker @change="pickerChange" :value="complaint.reason" :range="picker">
				<view class="picker">
					{{complaint.reason>-1?picker[complaint.reason]:'请选择举报理由'}}
				</view>
			</picker>
		</view>
		
		
		<view class="complaint-title">
		    <text>{{typeName}}举报截图</text>
		</view>
		<view class="cu-bar bg-white">
			<view class="action">
				点击预览图片
			</view>
			<view class="action">
				{{complaint.images.length}}/8
			</view>
		</view>
		<view class="cu-form-group">
			<view class="grid col-4 grid-square flex-sub">
				<view class="bg-img" v-for="(image,index) in complaint.images" :key="index">
				 <image :src="image" @tap="previewImage(complaint.images, index)" mode="aspectFill"></image>
					<view class="cu-tag bg-red" @tap.stop="close(index)">
						<text class='wlIcon-shanchu2'></text>
					</view>
				</view>
				<view class="solids" @tap="chooseImg" v-if="complaint.images.length<8">
					<text class="wlIcon-31paishe"></text>
				</view>
			</view>
		</view>
		<view class="complaint-title">
		    <view>{{typeName}}举报详情</view>
		</view>
		<view class="cu-form-group">
			<textarea maxlength="-1" v-model="complaint.content" placeholder-class="placeholder" placeholder="请详细描述举报内容..."></textarea>
		</view>
		<view class="wanlian cu-bar tabbar foot flex flex-direction">
			<button class="cu-btn wanl-bg-redorange lg" @tap="submit">发起举报</button>
		</view>
	</view>
</template>

<script>
	export default {
		data() {
			return {
				index: -1,
				picker: ['虚假交易', '诈骗欺诈', '收到空包裹', '假冒盗版', '泄露信息', '违禁物品', '未按成交价交易', '未按约定时间发货', '垃圾营销', '涉黄信息', '不实信息', '人身攻击', '违法信息', '诈骗信息'],
				complaintId: 0,
				typeName: '',
				complaint:{
					type: 0,
					complaint_user_id: 0,
					complaint_shop_id: 0,
					complaint_goods_id: 0,
					images: [],
					content: '',
					reason: -1
				}
			};
		},
		onLoad(option) {
			this.complaint.type = option.type;
			this.complaintId = option.id;
			if(option.type == 0){
				this.typeName = '用户';
				this.complaint.complaint_user_id = option.id;
			}else if(option.type == 1){
				this.typeName = '商品';
				this.complaint.complaint_goods_id = option.id;
			}else if(option.type == 2){
				this.typeName = '店铺';
				this.complaint.complaint_shop_id = option.id;
			}
		},
		methods: {
			pickerChange(e){
				if(e.detail.value == -1){
					this.complaint.reason = 0;
				}else{
					this.complaint.reason = e.detail.value;
				}
			},
			chooseImg() { //选择图片
			    uni.chooseImage({
			        sourceType: ["camera", "album"],
			        sizeType: "compressed",
			        count: 8 - this.complaint.images.length,
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
													this.complaint.images.push(data.fullurl);
												}
											});
										}
									});
								}
							}
						});
			        }
			    })
			},
			close(e){
			    this.complaint.images.splice(e,1);
			},
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
			},
			submit() { 
				if(this.complaint.reason == -1){
					this.$wanlshop.msg('请选择举报理由');
					return false;
				}
				if(!this.complaint.content){
					this.$wanlshop.msg('请填写举报内容');
					return false;
				}
			    this.$api.post({
			    	url: '/wanlshop/complaint/add',
					data: this.complaint,
			    	success: res => {
			    		this.$wanlshop.to('/pages/page/success?type=complaint');
			    	}
			    });
			}
		}
	}
</script>

<style>
	.complaint-title {
		display: flex;
		flex-direction: row;
		justify-content: space-between;
		align-items: center;
		padding: 20rpx 25rpx;
		color: #666;
	}
	.complaint-star-view.complaint-title {
		justify-content: flex-start;
		margin: 0;
	}
	.cu-form-group picker .picker{
		text-align: left;
	}
	.solids::after {
	    border: 2px dashed #c5c5c5;
	}
	.wanlian.cu-bar.tabbar {
		background-color: transparent;
	}
	.wanlian.cu-bar.tabbar .cu-btn {
		width: calc(100% - 50rpx);
	}
	.wanlian.cu-bar.tabbar .cu-btn.lg {
		font-size: 32rpx;
		height: 86rpx;
	}
</style>
