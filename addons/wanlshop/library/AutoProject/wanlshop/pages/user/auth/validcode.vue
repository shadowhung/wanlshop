<template>
	<view>
		<view class="auth">
			<view class="auth-title">输入短信验证码</view>
			<view class="auth-mobile">
				短信验证码至<text>{{mobile}}</text>
			</view>
			<view class="codes">
				<view v-for="item in config.count" :key="item.key">
					<view class="input" @tap="hanldeOpenKeyboard" :class="{ active: currentFocus == item.index }">
						<template v-if="code[item.index - 1] != undefined">
							{{ code[item.index - 1] }}
						</template>
						<template v-else>
							<view v-if="currentFocus == item.index" class="shining"></view>
						</template>
					</view>
				</view>
			</view>
			<view class="auth-again">
				<text v-if="countdown > 0" class="time">{{countdown}}秒后重新发送</text>
				<text v-if="countdown == 0" @tap="resend">重新发送</text>
				<text v-if="countdown < 50">没有收到验证码？</text>
				
			</view>
		</view>
		<wanl-keyboard :open="keyboardVisible" @number="inputCode" @delete="deleteCode" @empty="emptyCode" @close="keyboardVisible = false" />
	</view>
</template>
<script>
export default {
	data() {
		return {
			config: {
				count: [
					{
						index: 1,
						key: 'valid-code-input-1'
					},
					{
						index: 2,
						key: 'valid-code-input-2'
					},
					{
						index: 3,
						key: 'valid-code-input-3'
					},
					{
						index: 4,
						key: 'valid-code-input-4'
					},
					{
						index: 5,
						key: 'valid-code-input-5'
					},
					{
						index: 6,
						key: 'valid-code-input-6'
					}
				]
			},
			keyboardVisible: true,
			currentFocus: 1,
			mobile: '',
			code: [],
			style: {
				inputWidth: '40upx',
				inputHeight: '100upx'
			},
			countdown: 60,
			cTimer: null,
			event: '',
			pageroute: ''
		};
	},
	onLoad(options) {
		this.mobile = options.mobile;
		this.event = options.event;
		this.pageroute = options.url;
		this.sendMessage();
		this.startTimer();
	},
	methods: {
		inputCode(e) {
			this.code[this.currentFocus - 1] = e;
			if (this.currentFocus == 6) {
				this.login();
			}
			if (this.currentFocus <= 6) {
				this.currentFocus++;
			}
		},
		login() {
			uni.showLoading();
			// 找回密码
			if (this.event == 'resetpwd') {
				this.$wanlshop.to(`resetpwd?mobile=${this.mobile}&captcha=${this.code.join("")}&url=${this.pageroute}`);
				uni.hideLoading();
			}
			// 绑定手机号
			if (this.event == 'binding') {
				
			}
			// 验证码登录
			if (this.event == 'mobilelogin') {
				this.$api.post({
				    url: '/wanlshop/user/mobilelogin', 
					data:{
						mobile: this.mobile,
						captcha: this.code.join(""),
						client_id: uni.getStorageSync("wanlshop:chat_client_id")?uni.getStorageSync("wanlshop:chat_client_id") : null
					},
				    success: res => {
						uni.hideLoading();
						// 中央控制总线
						this.$store.dispatch('user/login', res);
				        this.$store.dispatch('cart/login');
				        uni.reLaunch({url: decodeURIComponent(this.pageroute)});
				    }
				});
			}
			// 用户注册
			if (this.event == 'register') {
				this.$api.post({
				    url: '/wanlshop/user/register', 
					data:{
						mobile: this.mobile,
						captcha: this.code.join(""),
						client_id: uni.getStorageSync("wanlshop:chat_client_id")?uni.getStorageSync("wanlshop:chat_client_id") : null
					},
				    success: res => {
						uni.hideLoading();
						// 中央控制总线
						this.$store.dispatch('user/login', res);
						this.$store.dispatch('cart/login');
						this.$store.dispatch('chat/get');
				        uni.reLaunch({url: decodeURIComponent(this.pageroute)});
				    }
				});
			}
			this.currentFocus = 0;
			this.code = [];
		},
		deleteCode() {
			this.currentFocus--;
			this.code.splice(-1, 1);
		},
		emptyCode(){
			this.code = [];
			this.currentFocus = 0;
		},
		hanldeOpenKeyboard() {
			this.keyboardVisible = true;
		},
		sendMessage() {
			this.$api.get({
			    url: '/wanlshop/sms/send', 
				data:{
					event: this.event,  
					mobile: this.mobile
				},
				loadingTip: '验证码发送中...',
			    success: res => {
					this.$wanlshop.msg('验证码发送成功');
			    }
			});
		},
		startTimer() {
			if (this.cTimer == null) {
				this.cTimer = setInterval(() => {
					this.countdown--;
					if (this.countdown == 0) {
						this.clearTimer();
					}
				}, 1000)
			}
		},
		clearTimer() {
			clearInterval(this.cTimer);
			this.cTimer = null;
		},
		resend(){
			this.startTimer();
			this.code = [];
			this.currentFocus = 0;
			this.countdown = 60;
			this.sendMessage();
		}
	}
};
</script>

<style>
	@import url("auth.css");
</style>