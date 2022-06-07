<!-- 
	版本声明：
	* 由于 WanlLive、WanlChat、以下代码开发难度较大，已将相关代码独立申请著作权，受法律保护！！！
	* 无论你购买任何版本，均不允许复制到第三方直接、间接使用，且也不能以学习为目的参考借鉴
	* 你仅有在 WanlShop 中使用、二次开发权利，否则我们会追究法律责任 
	* 福建度虎科技有限公司 @www.i36k.com
-->
<template>
	<view class="wanl-live-footer" :style="{bottom:statusFootHeight +'px'}">
		<view class="wanl-live-footer-bottom_msg">
			<input type="text" 
				v-if="state == 1"
				class="wanl-live-footer-bottom_msg_input" 
				confirm-type="send" 
				v-model="message" 
				@confirm="sendLive('msg')"
				placeholder-style="color:#FFFFFF"
				placeholder-class="wanl-live-footer-bottom_msg_input-placeholder" 
				placeholder="问什么都告诉你~" 
			/>
		</view>
		<!-- H5 页面需要发送按钮 -->
		<!-- #ifndef MP-WEIXIN || MP-ALIPAY || MP-BAIDU || APP-PLUS -->
		<view class="wanl-live-footer-bottom_send" v-if="state == 1">
			<view class="wanl-live-footer-bottom_send-btn" @tap="sendLive('msg')">
				<text class="wanl-live-footer-bottom_send-btn-text">发送</text>
			</view>
		</view>
		<!-- #endif -->
		<!-- <view class="wanl-live-footer-bottom_controll"> </view> -->
		<view class="wanl-live-footer-bottom_goods" @tap="onPopup">
			<image class="wanl-live-footer-bottom_goods-btn" src="/static/images/live/shop.png" mode=""></image>
			<view class="wanl-live-footer-bottom_goods-tag" v-if="goods.length != 0">
				<text class="wanl-live-footer-bottom_goods-tag-text">{{numFormat(goods.length)}}</text>
			</view>
		</view>
		<!-- 发送点赞 -->
		<view class="wanl-live-footer-bottom_praise" @tap="sendLive('like')" v-if="state == 1">
			<image class="wanl-live-footer-bottom_praise-btn" src="/static/images/live/like.png" mode=""></image>
			<view class="wanl-live-footer-bottom_praise-tag" v-if="like != 0">
				<text class="wanl-live-footer-bottom_praise-tag-text">{{numFormat(like)}}</text>
			</view>
		</view>
		<uni-popup ref="wanlLivePopup" type="bottom">
			<view class="wanl-live-popup">
				<view class="wanl-live-popup-title">
					<text class="wanl-live-popup-title-text">共 {{goods.length}} 件商品</text>
				</view>
				<scroll-view scroll-y="true" class="wanl-live-popup-list">
					<view class="wanl-live-popup-list-item" v-for="(item, index) in goods" :key="item.id">
						<view class="wanl-live-popup-list-item-img">
							<image :src="stcOss(item.image)" class="wanl-live-popup-list-item-image"></image>
							<view class="wanl-live-popup-list-item-img-tag">
								<text class="wanl-live-popup-list-item-img-tag-text">{{index + 1}}</text>
							</view>
						</view>
						<view class="wanl-live-popup-list-item-subject">
							<view class="wanl-live-popup-list-item-subject-title">
								<text class="wanl-live-popup-list-item-subject-title-text">{{item.title}}</text>
							</view>
							<view class="wanl-live-popup-list-item-subject-operation">
								<view class="wanl-live-popup-list-item-subject-operation-price">
									<text class="wanl-live-popup-list-item-subject-operation-price-text">￥{{item.price}}</text>
								</view>
								<view class="wanl-live-popup-list-item-subject-operation-button">
									<view class="wanl-live-popup-list-item-subject-operation-button-seek" @tap="sendLive('seek',index+1)" v-if="state == 1">
										<text class="wanl-live-popup-list-item-subject-operation-button-seek-text">求讲解</text>
									</view>
									<view class="wanl-live-popup-list-item-subject-operation-button-shopping" @tap="toGoods(item.id)">
										<image src="/static/images/live/cart.png" class="wanl-live-popup-list-item-subject-operation-button-shopping-img" mode=""></image>
									</view>
								</view>
							</view>
						</view>
					</view>
				</scroll-view>
				<!-- 多终端兼容性 -->
				<view :style="{height: statusFootHeight + 'px'}"></view>
			</view>
		</uni-popup>
	</view>
</template>

<script>
export default {
	name: "wanlLiveFooter",
	props: {
		statusFootHeight: {
			type: Number,
			default: 0
		},
		like:{
			type: Number,
			default: 0
		},
		state:{
			default: 0
		},
		goods: {
			type: Array,
			default: () => []
		}
	},
	data() {
		return {
			message: ''
		};
	},
	methods: {
		// 传入进popup
		onPopup(){
			this.$refs.wanlLivePopup.open();
		},
		stcOss(url){
			let oss = this.$store.state.common.appUrl.oss;
			let image = '';
			if (url) {
				if((/^(http|https):\/\/.+/.test(url))){
					image = url;
				}else{
					image = oss + url;
				}
			}else{
				image = oss + '/assets/addons/wanlshop/img/common/img_default3x.png';
			}
			return image;
		},
		// 传递给live 消息
		sendLive(type, index){
			switch(type) {
				// 发送消息
				case 'msg': 
					if (this.message) {
						this.$emit('change',{
							type: 'msg',
							message: this.message
						});
						this.message = '';
					}
					// 收起键盘
					uni.hideKeyboard();
					break;
				// 点赞
				case 'like':
					this.$emit('change',{type: 'like'});
					break;
				// 求讲解
				case 'seek':
					this.$emit('change',{
						type: 'seek',
						key: index
					});
					this.$refs.wanlLivePopup.close();
					break;
			} 
		},
		toGoods(id){
			uni.navigateTo({
				url: `/pages/product/goods?id=${id}`
			})
			this.$refs.wanlLivePopup.close();
		},
		numFormat(num){
			return num > 9999 ? ((num-num%1000)/10000 + '万') : num
		}
	}
};
</script>
<style scoped>
.wanl-live-footer {
	position: absolute;
	left: 0;
	right: 0;
	bottom: 0;
	align-items: center;
	justify-content: space-between;
	flex-direction: row;
	padding-top: 18rpx;
	padding-bottom: 18rpx;
}
	/* 消息按钮 */
	.wanl-live-footer-bottom_msg {
		/* #ifndef MP-WEIXIN || MP-ALIPAY || MP-BAIDU || APP-PLUS */
		flex: 3;
		/* #endif */
		/* #ifdef MP-WEIXIN || MP-ALIPAY || MP-BAIDU || APP-PLUS */
		flex: 4;
		/* #endif */
		margin-left: 25rpx;
		margin-right: 25rpx;
	}
		.wanl-live-footer-bottom_msg_input{
			height: 76rpx;
			background-color: rgba(0,0,0,.2);
			border-radius: 100px;
			color: #fff;
			padding-left: 25rpx;
			padding-right: 25rpx;
			font-size: 28rpx;
		}
		.wanl-live-footer-bottom_msg_input-placeholder{
			color: #FFFFFF;
		}
	/* 发送按钮 */
	.wanl-live-footer-bottom_send {
		flex: 1;
		align-items: flex-start;
	}
		.wanl-live-footer-bottom_send-btn{
			background-color: #f02b57;
			border-radius: 100px;
			height: 50rpx;
			width: 100rpx;
			justify-content: center;
			align-items: center;
		}
		.wanl-live-footer-bottom_send-btn-text{
			color: #ffffff;
			font-size: 28rpx;
		}
		
		
	/* 进度条 */
	.wanl-live-footer-bottom_controll {
		justify-content: center;
		align-items: center;
		color: #fff;
		flex: 4;
		z-index: 100;
		position: relative;
		height: 76rpx;
		line-height: 76rpx;
	}
		.wanl-live-footer-bottom_controll-play{
			width: 76rpx;
			height: 76rpx;
			position: relative;
		}
	/* 商品 */
	.wanl-live-footer-bottom_goods {
		position: relative;
		flex: 1;
		justify-content: center;
		align-items: center;
	}
		.wanl-live-footer-bottom_goods-btn{
			height: 76rpx;
			width: 76rpx;
		}
		.wanl-live-footer-bottom_goods-tag{
			position: absolute;
			top: -16rpx;
			right: 12rpx;
			background-color: #f02b57;
			border-radius: 100px;
			padding-left: 10rpx;
			padding-right: 10rpx;
			padding-top: 2rpx;
			padding-bottom: 2rpx;
		}
		.wanl-live-footer-bottom_goods-tag-text{
			color: #ffffff;
			font-size: 22rpx;
		}
		
	/* 点赞 */
	.wanl-live-footer-bottom_praise {
		position: relative;
		justify-content: center;
		align-items: center;
		flex: 1;
	}
		.wanl-live-footer-bottom_praise-btn{
			height: 76rpx;
			width: 76rpx;
		}
		.wanl-live-footer-bottom_praise-tag{
			position: absolute;
			top: -16rpx;
			left: 12rpx;
			background-color: #f02b57;
			border-radius: 100px;
			padding-left: 6rpx;
			padding-right: 6rpx;
			padding-top: 2rpx;
			padding-bottom: 2rpx;
		}
		.wanl-live-footer-bottom_praise-tag-text{
			color: #ffffff;
			font-size: 22rpx;
		}
		
	/* POPUP */
	.wanl-live-popup{
		background-color: #ffffff;
		border-top-left-radius: 18rpx;
		border-top-right-radius: 18rpx;
		overflow: hidden;
	}
		.wanl-live-popup-title{
			position: relative;
			align-items: center;
			margin-top: 30rpx;
			margin-bottom: 40rpx;
		}
		.wanl-live-popup-title-text{
			font-size: 30rpx;
			color: #333;
			font-weight: 500;
		}
		
	.wanl-live-popup-list{
		padding-left: 25rpx;
		padding-right: 25rpx;
		
		/* #ifdef APP-PLUS */
		height: 690rpx;
		/* #endif */
		
		/* #ifdef H5 || MP */
		max-height: 1000rpx;
		min-height: 200rpx;
		/* #endif */
	}	
		.wanl-live-popup-list-item{
			flex-direction: row;
			margin-bottom: 25rpx;
		}
			.wanl-live-popup-list-item-img{
				position: relative;
				width: 180rpx;
				height: 180rpx;
				border-top-left-radius: 12rpx;
				border-top-right-radius: 12rpx;
				border-bottom-right-radius: 12rpx;
				border-bottom-left-radius: 12rpx;
				overflow: hidden;
				background-color: #f7f7f7;
				margin-right: 20rpx;
			}
				.wanl-live-popup-list-item-image{
					width: 180rpx;
					height: 180rpx;
				}
				.wanl-live-popup-list-item-img-tag{
					position: absolute;
					align-items: center;
					justify-content: center;
					top: 0;
					left: 0;
					background-color: rgba(50,50,50,.5);
					padding-left: 14rpx;
					padding-right: 14rpx;
					padding-top: 2rpx;
					padding-bottom: 2rpx;
					border-bottom-right-radius: 12rpx;
				}
				
				.wanl-live-popup-list-item-img-tag-text{
					color: #ffffff;
					font-size: 24rpx;
				}
				
			.wanl-live-popup-list-item-subject{
				flex: 1;
				justify-content: space-between;
			}
				
				.wanl-live-popup-list-item-subject-title{
					/* #ifdef MP || H5 */
					width: 100%;
					overflow: hidden;
					text-overflow: ellipsis;
					display: -webkit-box;
					-webkit-box-orient: vertical;
					-webkit-line-clamp: 2;
					/* #endif */
				}
				.wanl-live-popup-list-item-subject-title-text{
					color: #222222;
					font-size: 28rpx;
					lines:2;
					text-overflow:ellipsis;
					/* #ifdef APP-PLUS */
					line-height: 36rpx;
					/* #endif */
				}
				
				.wanl-live-popup-list-item-subject-operation{
					align-items: center;
					justify-content: space-between;
					flex-direction: row;
				}
				.wanl-live-popup-list-item-subject-operation-price{
					
				}
					.wanl-live-popup-list-item-subject-operation-price-text{
						color: #f72b36;
						font-size: 32rpx;
						font-weight: 500;
					}
				.wanl-live-popup-list-item-subject-operation-button{
					flex-direction: row;
					
				}
					.wanl-live-popup-list-item-subject-operation-button-seek{
						margin-right: 18rpx;
						border-radius: 100px;
						justify-content: center;
						align-items: center;
						height: 54rpx;
						width: 130rpx;
						    border-top-color: #6200ff;
						    border-top-style: solid;
						    border-top-width: 1px;
						    border-right-color: #6200ff;
						    border-right-style: solid;
						    border-right-width: 1px;
						    border-bottom-color: #6200ff;
						    border-bottom-style: solid;
						    border-bottom-width: 1px;
						    border-left-color: #6200ff;
						    border-left-style: solid;
						    border-left-width: 1px;
					}
						.wanl-live-popup-list-item-subject-operation-button-seek-text{
							color: #6200ff;
							font-size: 27rpx;
						}
					.wanl-live-popup-list-item-subject-operation-button-shopping{
						background-color: #f72b36;
						border-radius: 100px;
						justify-content: center;
						align-items: center;
						width: 54rpx;
						height: 54rpx;
					}
						.wanl-live-popup-list-item-subject-operation-button-shopping-img{
							width: 36rpx;
							height: 36rpx;
						}
				
</style>