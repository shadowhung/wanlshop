<template>
	<view>
		<view class="edgeInsetTop"></view>
		<view class="cu-list menu sm-border">
			<view class="cu-item arrow" @tap="$wanlshop.auth(`/pages/user/auth/validcode?event=resetpwd&mobile=${user.mobile}`)">
				<view class="content">
					<text>修改登录密码</text>
				</view>
			</view>
			<view class="cu-item arrow" @tap="noMobile">
				<view class="content">
					<text>修改手机号码</text>
				</view>
			</view>
			<view class="cu-item arrow" @tap="noPay">
				<view class="content">
					<text>修改支付密码</text>
				</view>
			</view>
		</view>
		
		<!-- <view class="cu-list menu sm-border">
			<view class="cu-item arrow">
				<view class="content">
					<text>安全中心</text>
				</view>
			</view>
		</view> -->
		
		<view class="cu-list menu sm-border" @tap="noUser">
			<view class="cu-item arrow">
				<view class="content">
					<text>注销账户</text>
				</view>
			</view>
		</view>
		
		
	</view>
</template>

<script>
	import { mapState} from 'vuex';
	export default {
		data() {
			return {

			}
		},
		computed: {
			...mapState(['user'])
		},
		methods: {
			noPay(){
				this.$wanlshop.msg('暂无支付密码')
			},
			noUser(){
				this.$wanlshop.msg('暂不支持注销账户')
			},
			noMobile(){
				this.$wanlshop.msg('暂不支持修改手机号码')
			}
		}
	}
</script>

<style>
	
</style>
