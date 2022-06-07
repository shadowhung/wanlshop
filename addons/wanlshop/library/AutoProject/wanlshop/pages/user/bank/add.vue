<template>
	<view>
		<view class="edgeInsetTop"></view>
		<view class="cu-form-group">
			<view class="title">选择银行</view>
			<picker @change="bankChange" :value="index" :range="bankList" range-key="bankName">
				<view class="picker">
					<view class="flex justify-end align-center" v-if="index > -1">
						<image :src="`/static/images/bank/${bankList[index].bankCode}.png`"></image>
						<view class="margin-left-xs">{{bankList[index].bankName}}</view>
					</view>
					<view v-else>
						请选择
					</view>
				</view>
			</picker>
		</view>
		<view class="cu-form-group">
			<view class="title">银行账号</view>
			<input type="text" placeholder="填写银行卡 / 支付宝微信账号" v-model="bankData.cardCode"/>
		</view>
		<view class="cu-form-group">
			<view class="title">持卡姓名</view>
			<input type="text" maxlength="4" placeholder="持账户人姓名" v-model="bankData.username"/>
		</view>
		<view class="cu-form-group">
			<view class="title">手机号码</view>
			<input type="number" maxlength="11" placeholder="持账户人手机号" v-model="bankData.mobile"/>
		</view>
		<view class="padding-bj flex flex-direction margin-top">
			<button @tap="confirm" class="cu-btn wanl-bg-orange lg">完成</button>
		</view>
	</view>
</template>

<script>
	export default {
		data() {
			return {
				bankData: {
					username: '',
					mobile: '',
					bankCode: '',
					bankName: '',
					cardCode: ''
				},
				index: -1,
				bankList: [
					{bankCode: 'ALIPAY', bankName: '支付宝账户'},
					{bankCode: 'WECHAT', bankName: '微信账户'},
					{bankCode: 'ICBC', bankName: '工商银行'},
					{bankCode: 'ABC', bankName: '农业银行'},
					{bankCode: 'PSBC', bankName: '邮储银行'},
					{bankCode: 'CCB', bankName: '建设银行'},
					{bankCode: 'CMB', bankName: '招商银行'},
					{bankCode: 'BOC', bankName: '中国银行'},
					{bankCode: 'COMM', bankName: '交通银行'},
					{bankCode: 'SPDB', bankName: '浦发银行'},
					{bankCode: 'GDB', bankName: '广发银行'},
					{bankCode: 'CMBC', bankName: '民生银行'},
					{bankCode: 'PAB', bankName: '平安银行'},
					{bankCode: 'CEB', bankName: '光大银行'},
					{bankCode: 'CIB', bankName: '兴业银行'},
					{bankCode: 'CITIC', bankName: '中信银行'}
				]
			}
		},
		methods: {
			// 后续版本添加第三方API接口，自动获取银行，验证银行卡三要素
			confirm(){
				let data = this.bankData;
				if(!data.bankCode){
					this.$wanlshop.msg('请选择银行卡');
					return;
				}
				if(!data.cardCode){
					this.$wanlshop.msg('请选择账号');
					return;
				}
				if(!data.username){
					this.$wanlshop.msg('请填写真实姓名');
					return;
				}
				var myreg = /^[1][3,4,5,7,8,9][0-9]{9}$/;
				if(!data.mobile || !myreg.test(data.mobile)){
					this.$wanlshop.msg('请填写正确手机号');
					return;
				}
				this.$wanlshop.prePage().refreshList(data);
				this.$wanlshop.back(1);
			},
			bankChange(e) {
				this.index = e.detail.value;
				this.bankData.bankCode = this.bankList[e.detail.value].bankCode;
				this.bankData.bankName = this.bankList[e.detail.value].bankName;
			}
		}
	}
</script>

<style>
	.picker .flex image{
		width: 40rpx;
		height: 40rpx;
	}

</style>