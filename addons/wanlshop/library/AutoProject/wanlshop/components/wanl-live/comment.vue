<!-- 
	版本声明：
	* 由于 WanlLive、WanlChat、以下代码开发难度较大，已将相关代码独立申请著作权，受法律保护！！！
	* 无论你购买任何版本，均不允许复制到第三方直接、间接使用，且也不能以学习为目的参考和借鉴！！
	* 你仅有在 WanlShop 中使用、二次开发权利，否则我们会追究法律责任 
	* 福建度虎科技有限公司 @www.i36k.com
-->
<template>
	<view class="wanl-live-operator" :style="{bottom:statusFootHeight + 60 +'px'}">
		<view class="wanl-live-comment">
			<view class="wanl-live-comment-item">
				 <scroll-view scroll-y="true" :scroll-into-view="scrollToView" :scroll-with-animation="true" class="wanl-live-comment-item-scroll">
					<!-- #ifdef APP-PLUS -->
					<view class="wanl-live-comment-item-scroll-app" v-for="(item, index) in msgList" :key="index" :id="'msg' + index">
						<view class="wanl-live-comment-item-scroll-app-item">
							<text :class="[iscolor(item.form.id)]" class="app-text">{{item.form.nickname}}：</text>
							<text class="app-context">{{item.text}}</text>
						</view>
					</view>
					<!-- #endif -->
					<!-- #ifdef H5 -->
					<div class="wanl-live-comment-item-scroll-h5" v-for="(item, index) in msgList" :key="index" :id="'msg' + index">
					 	<div class="wanl-live-comment-item-tag">
					 		<text :class="[iscolor(item.form.id)]" class="mph5-text">{{item.form.nickname}}：</text>
							<text class="mph5-context">{{item.text}}</text>
					 	</div>
					</div>
					<!-- #endif -->
                    <!-- #ifdef MP -->
					<div class="wanl-live-comment-item-scroll-mp" v-for="(item, index) in msgList" :key="index" :id="'msg' + index">
					 	<div class="wanl-live-comment-item-tag">
					 		<text :class="[iscolor(item.form.id)]" class="mph5-text">{{item.form.nickname}}：</text>
							<text class="mph5-context">{{item.text}}</text>
					 	</div>
					</div>
                    <!-- #endif -->
                </scroll-view>
			</view>
			<view class="wanl-live-comment-empty"> </view>
		</view>
		<uni-transition :mode-class="['slide-left']" :styles="{ 'position':'absolute', 'left':'0', 'top':'-60rpx', }" :show="comingShow">
			<view class="wanl-live-coming">
				<text class="wanl-live-coming-text">{{comingName}} 他来了他来了~</text>
			</view>
		</uni-transition>
	</view>
</template>

<script>
export default {
	name: "wanlLiveComment",
	props: {
		statusFootHeight: {
			default: 0
		},
		state: {
			default: 0
		},
		liveid: {
			type: String,
			default: ''
		},
		commentData: {
			type: Object,
			default: function() {
				return {};
			}
		}
	},
	data() {
		return {
			scrollToView: '',
			comingShow: false,
			comingName: '',
			watchTimer: null,
			msgList: [],
			liveData: {
				state: 0,
				liveid: ''
			}
		};
	},
	created(){
		this.liveData.state = this.state;
		this.liveData.liveid = this.liveid;
		// 监听直播消息
		uni.$on('onLive', this.updateMsg);
		// #ifndef APP-PLUS
		setTimeout(() => {
			this.msgList.push({
				form: {
					id:0,
					nickname: '平台提醒'
				},
				text: '请您在拍下时确认购买商品和主播实际描述一致，禁止线下交易，谨防上当受骗！'
			});
		}, 500);
		// #endif
	},
	methods: {
		updateMsg(msg){
			if (this.liveData.state == 1) {
				if (msg.group == this.liveData.liveid) {
					var message = msg.message;
					var form = msg.form;
					if (message.type == 'msg' || message.type == 'seek' || message.type == 'follow' || message.type == 'like' || message.type == 'review') {
						this.msgList.push({
							form: form,
							text: message.text
						});
						this.$nextTick(() => {
							this.scrollToView = 'msg' + (this.msgList.length - 1);
						});
					}
					if(message.type == 'coming'){
						if (this.comingShow ) {
							clearTimeout(this.watchTimer);
							this.comingShow = false;
						}
						this.comingName = form.nickname;
						this.openComing();
					}
				}else{
					console.log('其他直播间消息');
				}
			}
		},
		openComing(){
			this.comingShow = true;
			this.watchTimer = setTimeout(() => {
				this.comingShow = false;
			}, 1000);
		},
		iscolor(id){
			return ['text-white','text-orange','text-yellow','text-green','text-olive','text-green','text-purple','text-pink','text-pink','text-purple'][parseInt(id % 10)]
		}
	}
};
</script>

<style scoped>


.wanl-live-operator{
	position: absolute;
	bottom: 0;
	left: 0;
	right: 0;
}
	.wanl-live-coming{
		margin-left: 25rpx;
		background-color: rgba(255,86,136,.7);
		padding-top: 8rpx;
		padding-right: 16rpx;
		padding-bottom: 8rpx;
		padding-left: 16rpx;
		border-radius: 10rpx;
	}
		.wanl-live-coming-text{
			color: #ffffff;
			font-size: 28rpx;
		}
	
	.wanl-live-comment{
		/* #ifndef APP-PLUS */
		-webkit-mask: -webkit-gradient(linear,left 30%,left top,from(#000),to(transparent));
		/* #endif */
		margin-left: 25rpx;
		flex-direction: row;
		position: relative;
	}
		.wanl-live-comment-empty{
			flex: 1;
		}
		.wanl-live-comment-item{
			flex: 2;
			overflow: hidden;
			color: #FFFFFF;
		}
			.wanl-live-comment-item-scroll{
				/* #ifdef H5 || MP */
				max-height: 500rpx;
				min-height: 60rpx;
				/* #endif */
				/* #ifdef APP-PLUS */
				height: 500rpx;
				/* #endif */
			}
			
			
				
			/* #ifdef H5 || MP */
			.wanl-live-comment-item-scroll-h5{
				margin-top: 6rpx;
				overflow: hidden;
				display: flex;
			}
			.wanl-live-comment-item-scroll-mp{
				margin-bottom: 6rpx;
				overflow: hidden; 
				display: block;
			}
				.wanl-live-comment-item-tag{
					background-color: rgba(0,0,0,.2);
					padding-top: 8rpx;
					padding-right: 16rpx;
					padding-bottom: 8rpx;
					padding-left: 16rpx;
					border-radius: 10rpx;
					overflow: hidden;
					display: inline-block;
				}
			/* #endif */
				
			
				
				
			.wanl-live-comment-item-scroll-app{
				flex-direction: row;
				margin-top: 6rpx;
			}
				.wanl-live-comment-item-scroll-app-item{
					background-color: rgba(0,0,0,.2); 
					padding-top: 8rpx;
					padding-right: 16rpx;
					padding-bottom: 8rpx;
					padding-left: 16rpx;
					border-radius: 10rpx;
					flex-direction: row;
				}
	.app-text{
		font-size: 29rpx;
	}
	.app-context{
		font-size: 29rpx;
		color: #ffffff;
	}
	.mph5-text{
		font-size: 26rpx;
	}
	.mph5-context{
		font-size: 26rpx;
		color: #ffffff;
	}

.text-white{
	color: #ffffff;
}
.text-orange{
	color: #f56f23;
}

.text-yellow{
	color: #ffee8a;
}

.text-olive{
	color: #7ed321;
}

.text-green{
	color: #50e3c2;
}

.text-purple{
	color: #9134fc;
}

.text-pink{
	color: #ff9fbf;
}
</style>
