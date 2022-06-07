<template>
	<view>
		<view class="edgeInsetTop"></view>
		<view class="cu-bar">
			<view class="action sub-title">
				<text class="text-xl text-bold text-orange">商家入驻流程</text>
				<text class="text-ABC text-orange">Settled</text>
			</view>
		</view>
		<view class="wanl-apply margin-xl">
			<view class="flow">
				<view class="item">
					<view class="project">
						<view class="text-center">
							<view class="cu-avatar xl round solid text-black margin-tb-sm">
								<text class="wlIcon-wo"></text>
							</view>
							<view class="text-lg text-bold ">
								<text>01 注册登录</text>
							</view>
						</view>
						<view class="text-min text-gray">
							<view> <text>1）进入系统注册账户</text> </view>
							<view> <text>2）设置账户密码</text> </view>
							<view> <text>3）进入PC用户中心或在本业提交申请</text> </view>
						</view>
					</view>
					<view class="point right">
						<view class="line"> </view>
						<view class="arrow"> </view>
					</view>
				</view>
				<view class="item">
					<view class="project">
						<view class="text-center">
							<view class="cu-avatar xl round solid text-black margin-tb-sm">
								<text class="wlIcon-xiugaioryijian"></text>
							</view>
							<view class="text-lg text-bold ">
								<text>02 填写提交信息</text>
							</view>
						</view>
						<view class="text-min text-gray">
							<view> <text>1）选择运营主体，填写与运营主体相关资质</text> </view>
							<view> <text>2）提交店铺资质审核</text> </view>
						</view>
					</view>
					<view class="point bottom">
						<view class="line"> </view>
						<view class="arrow"> </view>
					</view>
				</view>
				<view class="item">
					<view class="project">
						<view class="text-center">
							<view class="cu-avatar xl round solid text-black margin-tb-sm">
								<text class="wlIcon-guanzhu1"></text>
							</view>
							<view class="text-lg text-bold ">
								<text>04 签署入驻协议</text>
							</view>
						</view>
						<view class="text-min text-gray">
							<view> <text>1）签署入驻协议</text> </view>
							<view> <text>2）进入PC端用户中心点击商家控制台进入后台</text> </view>
						</view>
					</view>
					<view class="point left">
						<view class="arrow"> </view>
						<view class="line"> </view>
					</view>
					<view class="point bottom">
						<view class="line"> </view>
						<view class="arrow"> </view>
					</view>
				</view>
				<view class="item">
					<view class="project">
						<view class="text-center">
							<view class="cu-avatar xl round solid text-black margin-tb-sm">
								<text class="wlIcon-shijian"></text>
							</view>
							<view class="text-lg text-bold ">
								<text>03 等待系统审核</text>
							</view>
						</view>
						<view class="text-min text-gray">
							<view> <text>1）7个工作日内反馈审核</text> </view>
							<view> <text>2）查看审核结果，重新提交或进入下一步</text> </view>
							<view> <text>3）联系平台或等客服联系</text> </view>
						</view>
					</view>
				</view>
				<view class="item">
					<view class="project">
						<view class="text-center">
							<view class="cu-avatar xl round solid text-black margin-tb-sm">
								<text class="wlIcon-dianpu"></text>
							</view>
							<view class="text-lg text-bold ">
								<text>05 管理商家</text>
							</view>
						</view>
						<view class="text-min text-gray">
							<view> <text>1）系统学习商家后台使用</text> </view>
							<view> <text>1）恭喜您！入驻成功</text> </view>
						</view>
					</view>
				</view>
			</view>
			<view class="cu-bar">
				<view class="action sub-title">
					<text class="text-xl text-bold text-orange">资质要求</text>
					<text class="text-ABC text-orange">dqizon</text>
				</view>
			</view>
			<view class="details">
				<view class="details-item">
					<view class="title">
						<text>个人店（公民身份证）</text>
					</view>
					<view class="center text-sm">
						<view> <text>1.手持身份证照片</text> </view>
						<view> <text>2.姓名、手机号、微信号</text> </view>
					</view>
				</view>
				<view class="details-item">
					<view class="title">
						<text>企业店（企业资质）</text>
					</view>
					<view class="center text-sm">
						<view> <text>1.企业营业执照复印件</text> </view>
						<view> <text>2.企业统一信用代码</text> </view>
						<view> <text>3.法人身份证正反面</text> </view>
					</view>
				</view>
				<view class="details-item">
					<view class="title">
						<text>旗舰店（商标持有方或子公司）</text>
					</view>
					<view class="center text-sm">
						<view> <text>1.企业营业执照复印件</text> </view>
						<view> <text>2.企业统一信用代码</text> </view>
						<view> <text>3.国家商标总局颁发的商标注册证或商标受理通知书</text> </view>
						<view> <text>4.法人身份证正反面</text> </view>
					</view>
				</view>
			</view>
		</view>
		<view class="safeAreaBottom"></view>
		<view class="wanlian cu-bar tabbar foot flex flex-direction">
			<button @tap="onApply()" class="cu-btn wanl-bg-orange lg">{{verify_text[shopdata.verify]}}</button>
		</view>
	</view>
</template>

<script>
	export default {
		data() {
			return {
				shopdata:{verify: 0},
				verify_text: ['立即入驻','入驻审核中','入驻审核中','已入驻 查看','未通过审核 修改']
			}
		},
		onLoad() {
			this.loadData();
			if (this.$store.state.user.isLogin) {
				this.loadData();
			}
		},
		methods: {
			async loadData() {
				this.$api.get({
					url: '/wanlshop/shop/apply',
					success: res => {
						if (res) {
							this.shopdata = res;	
						}
					}
				});
			},
			onApply(){
				this.$wanlshop.auth(`/pages/shop/apply/apply?data=${JSON.stringify(this.shopdata)}`)
			}
		}
	}
</script>

<style>
	.cu-bar{
		justify-content: center;
	}
	.wanlian.cu-bar.tabbar {
		background-color: #ffffff;
	}
	.wanlian.cu-bar.tabbar .cu-btn {
		width: calc(100% - 50rpx);
	}
	.wanlian.cu-bar.tabbar .cu-btn.lg {
		font-size: 32rpx;
		height: 86rpx;
	}
	.cu-form-group .title, .cu-form-group uni-input{
		font-size: 28rpx;
	}
	.wanl-apply .flow{
		display: flex;
		flex-wrap: wrap;
		justify-content: space-between;
	}
	.wanl-apply .flow .item{
		width: 46%;
		height: 590rpx;
		position: relative;
	}
	
	.wanl-apply .flow .item:last-child{
		height: 400rpx;
	}
	
	.wanl-apply .flow .item .project {
		line-height: 2.2;
	}
	
	.wanl-apply .flow .item .point{
		display: flex;
	}
	.wanl-apply .flow .item .point .line{
		width: 120rpx;
		height: 4rpx;
		background-color: #ccc;
	}
	.wanl-apply .flow .item .point .arrow{
		border: 14rpx solid transparent;
		border-left: 30rpx solid #ccc;
	}
	
	/* 指向右 */
	.wanl-apply .flow .item .point.right{
		position: absolute;
		align-items: center;
		right: -110rpx;
		top: 76rpx;
	}
	/* 指向左 */
	.wanl-apply .flow .item .point.left{
		position: absolute;
		align-items: center;
		right: -96rpx;
		top: 76rpx;
	}
	.wanl-apply .flow .item .point.left .arrow{
		border: 14rpx solid transparent;
		border-right: 30rpx solid #ccc;
	}
	/* 指向下 */
	.wanl-apply .flow .item .point.bottom{
		position: absolute;
		justify-content: center;
		bottom: 0;
		right: 0;
		left: 0;
	}
	.wanl-apply .flow .item .point.bottom .line{
		width: 4rpx;
		height: 120rpx;
		margin-bottom: 45rpx;
	}
	.wanl-apply .flow .item .point.bottom .arrow{
		position: absolute;
		bottom: 0;
		border: 14rpx solid transparent;
		border-top: 30rpx solid #ccc;
	}
	.wanl-apply .details {
		background-color: #f1efec;
		margin: 50rpx 0;
	}
	.wanl-apply .details .details-item {
		display: flex;
		border-bottom: 2rpx solid #fff;
	}
	.wanl-apply .details .details-item .title{
		background-color: #e6e6e6;
		width: 40%;
		padding: 25rpx;
		display: flex;
		align-items: center;
		justify-content: center;
	}
	.wanl-apply .details .details-item .center{
		width: 100%;
		color: #474747;
	}
	.wanl-apply .details .details-item .center>view{
		border-bottom: 2rpx solid #fff;
		padding: 25rpx;
		line-height: 1.5;
	}
	.wanl-apply .details .details-item .center>view:last-child{
		border: 0;
	}
	
</style>