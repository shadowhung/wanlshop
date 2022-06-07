<!-- 2020年2月17日18:18:53 完成 -->
<template>
	<view>
		<view class="edgeInsetTop"></view>
		<view class="cu-form-group" v-show="addressType">
			<view class="title">联系人</view>
			<input type="text" placeholder="姓名" v-model="addressData.name"></input>
		</view>
		<view class="cu-form-group" v-show="addressType">
			<view class="title">手机号</view>
			<input type="number" placeholder="手机号码" maxlength="11" v-model="addressData.mobile"></input>
		</view>
		<view class="cu-form-group">
			<view class="title">所在地区</view>
			<input type="text" @tap="btnClick" :value="addressData.formatted_address" placeholder="选择地区" disabled/>
		</view>
		<view class="cu-form-group align-start">
			<view class="title">详细地址</view>
			<textarea maxlength="-1"  
				@input="getInputtips"  
				@focus="focusInputtips"
				@confirm="confirmInputtips"
				@blur="blurInputtips"
				:placeholder-style="addressData.adcode==''?'color: #bbb':''"
				:adjust-position="false"
				:value="addressData.address?(addressData.address_name+addressData.address):''"
				:disabled="addressData.adcode==''?true:false"
				:placeholder="addressData.adcode==''?'还没有选择地区哦~ 选择地区后完成此项':'支持智能联想，输入小区名试试~'"
			></textarea>
		</view>
		<view class="cu-form-group margin-top-bj" v-show="addressType">
			<view class="title">设为默认</view>
			<switch @change="switchChange" :class="addressData.default == 1?'checked':''" :checked="addressData.default == 1"></switch>
		</view>	
		<scroll-view scroll-y="true" class="tipsScroll" v-show="!addressType">
		    <view class="item" v-for="(item,index) in addressList.tips" :key="index" @tap="addressTisp(item)">
				<view>{{item.address}}</view>
				<text>{{item.name}}</text>
		    </view>
		</scroll-view>
		<view class="padding-bj flex flex-direction margin-top" v-show="addressType">
			<button @tap="confirm" class="cu-btn wanl-bg-orange lg">完成</button>
		</view>
		<wanl-address ref='wanlAddress' @selectAddress="successSelectAddress"></wanl-address>
	</view>
</template>

<script>
	export default {
		data() {
			return {
				addressData: {
					name: '',
					mobile: '',
					default: 0,
					//地区
					country: '', // 国家
					province: '', //省份
					city: '', // 城市
					citycode: '', // 城市代码
					district: '', // 县
					adcode: '', // 地区代码
					formatted_address: '', //详细地区
					//详情
					address: '', //详细地址
					address_name: '' ,// 地址名称
					location: '' //经纬度
				},
				addressList: {
					location: '',
					adcode: '',
					tips: {}
				},
				addressType: true
			}
		},
		onLoad(option){
			let title = '新增地址 ';
			if(option.type==='newadd'){
				this.addressData.default = 1
			}
			if(option.type==='edit'){
				title = '编辑地址'
				this.addressData = JSON.parse(option.data)
			}
			this.manageType = option.type;
			this.$wanlshop.title(title);
		},
		methods: {
			switchChange(e){
				if(e.detail.value){
					this.addressData.default = 1;
				}else{
					this.addressData.default = 0;
				}
			},
			btnClick() {
				this.$refs.wanlAddress.show()
			},
			successSelectAddress(address){
				this.addressData.country = address.country;
				this.addressData.province = address.province;
				this.addressData.city = address.city;
				this.addressData.citycode = address.citycode;
				this.addressData.district = address.district;
				this.addressData.formatted_address = address.formatted_address;
				this.addressData.location = address.location;
				this.addressData.adcode = address.adcode;
				this.addressList.location = address.location;
				this.addressList.adcode = address.adcode;
			},
			//调用高德地图搜索相关地址
			getInputtips(event) {
				let keywords = event.detail.value;
				if (keywords) {
					uni.request({
					    url: 'https://restapi.amap.com/v3/assistant/inputtips',
					    data: {
							key: this.$wanlshop.config('amapkey'),
							keywords: keywords,
							location: this.addressList.location,
							city: this.addressList.adcode
					    },
					    success: (res) => {
							let addressList = [];
							res.data.tips.forEach(item => {
								if (item.address.length == 0) {
									item.address = '暂未收录地址';
									item.location = '113.294701,22.666562';
								}
								addressList.push(item);
							});
							this.addressList.tips = addressList;
					    }
					});
				}
			},
			// 详细地址失去焦点
			blurInputtips(event){
				this.addressData.address = event.detail.value;
				setTimeout(() => {
					this.addressType = true;
				}, 10);
			},
			// 详细地址已完成
			confirmInputtips(event){
				this.addressType = true;
			},
			// 详细地址获取焦点
			focusInputtips(event){
				this.addressType = false;
			},
			// 详细地址替换
			addressTisp(data){
				this.addressData.adcode = data.adcode;
				this.addressData.address = data.address;
				this.addressData.address_name = data.name;
				this.addressData.location = data.location;
				this.addressType = true;
			},
			//提交
			confirm(){
				let data = this.addressData;
				if(!data.name){
					this.$wanlshop.msg('请填写收货人姓名');
					return;
				}
				if(!/^[0-9]{8,15}$/.test(data.mobile)){ // 1.0.2升级
					this.$wanlshop.msg('请输入正确的手机号码');
					return;
				}
				if(!data.city){
					this.$wanlshop.msg('请选择地区');
					return;
				}
				if(!data.address){
					this.$wanlshop.msg('请填写详细信息');
					return;
				}
				this.$wanlshop.prePage().refreshList(data, this.manageType);
				this.$wanlshop.msg(`地址${this.manageType=='edit' ? '修改': '添加'}成功`);
				this.$wanlshop.back(1);
			}
		}
	}
</script>

<style>
	.cu-form-group{
		padding: 0 25rpx;
	}
	.cu-form-group .title {
		min-width: calc(4em + 15px);
		font-size: 26rpx;
	}
	.cu-form-group input,.cu-form-group textarea{
		font-size: 26rpx;
	}
	.cu-btn.lg {
	    font-size: 32rpx;
	    height: 86rpx;
	}
	.tipsScroll{
		width: 100%;
		height: 500rpx;
		padding: 0 50rpx;
	}
	.tipsScroll .item{
		margin: 25rpx 0;
	}
	.tipsScroll .item view{
		color: #B8B8B8;
		font-size: 22rpx;
	}
	.tipsScroll .item text{
		color: #333;
	}
</style>
