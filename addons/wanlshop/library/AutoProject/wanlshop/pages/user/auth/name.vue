<template>
	<view>
		<view class="auth">
			<view class="wanl-title">欢迎登陆账号</view>
			<form @submit="formSubmit">
				<view class="auth-group radius-bock bg-gray wlian-grey-light">
					<input 
						type="text"
						placeholder="请输入用户名" 
						confirm-type="next" 
						maxlength="16"
						placeholder-class="placeholder" 
						name="account"
						:value="account"
					></input>
				</view>
				<view class="auth-group radius-bock bg-gray wlian-grey-light">
					<input 
						type="text"
						placeholder="请输入登录密码" 
						password="true" 
						confirm-type="done"
						maxlength="16"
						placeholder-class="placeholder" 
						name="password"
						@input="onKeyInput"
					></input>
				</view>
				<view class="text-right" @tap="retrieve">
					忘记密码
				</view>
				<view class="auth-button flex flex-direction">
					<button class="cu-btn bg-orange sl radius-bock" form-type="submit" :disabled="submitDisabled">登 录</button>
				</view>
				<view class="text-center" @tap="phone">
					短信验证码登录
				</view>
			</form>
		</view>
		<view class="auth-foot">
			<view class="menu text-grey">
				<text @tap="register">注册</text>
				<text @tap="help">帮助</text>
			</view>
		</view>
	</view>
</template>
<script>
import graceChecker from '@/common/graceChecker';//来自 graceUI 的表单验证， 使用说明见手册 http://grace.hcoder.net/doc/info/73-3.html
export default {
	data() {
		return {
			submitDisabled: true,
			account: '',
			pageroute: ''
		};
	},
	onLoad(option){
		// 用户名
		this.account = option.name;
		this.pageroute = option.url;
	},
	methods: {
		onKeyInput: function(e) {
			this.submitDisabled = false
		},
		formSubmit: function(e) {
			//定义表单规则
			var rule = [
				{ name: 'account', checkType: 'notnull', errorMsg: '请输入用户名' },
				{ name: 'password', checkType: 'string', checkRule: '6,16', errorMsg: '密码至少6位' }
			];
			//进行表单检查
			var formData = e.detail.value;
			var checkRes = graceChecker.check(formData, rule);
			if (checkRes) {
				this.$api.post({
					url: '/wanlshop/user/login', 
					data: {
						account: formData.account,
						password: formData.password,
						client_id: uni.getStorageSync("wanlshop:chat_client_id")?uni.getStorageSync("wanlshop:chat_client_id") : null
					},
					success: res => {
						this.$store.dispatch('user/login', res);
						this.$store.dispatch('cart/login');
						this.$store.dispatch('chat/get');
						uni.reLaunch({url: decodeURIComponent(this.pageroute)});
					}
				});
			} else {
				this.$wanlshop.msg(graceChecker.error);
			}
		},
		retrieve(){
			this.$wanlshop.to(`retrieve?url=${this.pageroute}`);
		},
		phone() {
			this.$wanlshop.to(`phone?url=${this.pageroute}`);
		},
		register() {
			this.$wanlshop.to(`register?url=${this.pageroute}`);
		},
		help() {
			this.$wanlshop.to(`/pages/user/help?url=${this.pageroute}`);
		}
	}
};
</script>

<style>
	@import url("auth.css");
</style>
