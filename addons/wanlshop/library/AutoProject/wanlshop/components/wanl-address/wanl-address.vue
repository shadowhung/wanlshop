<template>
	<view class="wrapper" v-show="isShowMask">
		<transition name="content">
			<view class="content_view" v-show="isShow">
				<view class="title_view">
					<view class="title">请选择所在地区</view>
					<view class="close_view" @tap="hidden">
						<icon class="close_icon" :type="'clear'" size="26"/>
					</view>
				</view>
				<view class="select_top">
					<view class="select_top_item" ref="select_top_item" v-for="(item,index) in dataList" :key="index" @tap="select_top_item_click(index)">
						<text class="address_value">{{item}}</text>
					</view>
					<view class="indicator" :style="{ left: indicatorStyleLeft + 'px' }" ref="indicator"></view>
				</view>
				<swiper class="swiper" :current="currentIndex" @change="swiperChange">
					<swiper-item v-for="(swiper_item,swiper_index) in dataList" :key="swiper_index">
						<view class="swiper-item">
							<scroll-view class="scroll-view-item" scroll-y="true">
								<view class="address_item" v-for="(item,index) in cityAreaArray[swiper_index]" :key="index" @tap="address_item_click(swiper_index,index)">
									<image v-if="selectIndexArr[swiper_index] === index" class="address_item_icon" :src="$wanlshop.appstc('/common/img_gou3x.png')" mode=""></image>
									{{item.name}}
								</view>
							</scroll-view>
						</view>
					</swiper-item>
				</swiper>
			</view>
		</transition>
		<view class="mask" @tap="hidden" v-show="isShowMask"></view>
	</view>
</template>

<script>
	import cityData from '../../static/json/city.json'
	export default {
		name: 'WanlAddress',
		data() {
			return {
				isShow: false,
				isShowMask: false,
				dataList: ['请选择'],
				currentIndex: 0,
				cityData: {},
				cityAreaArray: [],
				selectIndexArr: [],
				indicatorStyleLeft: 16
			};
		},
		methods:{
			show(){
				this.isShow = true
				this.isShowMask = true
			},
			hidden() {
				this.isShow = false
				this.isShowMask = false
			},
			select_top_item_click(index) {
				this.currentIndex = index
				
				this.changeIndicator(index)
				
			},
			swiperChange(event){
				let index = event.detail.current
				this.currentIndex = index
				this.changeIndicator(index)
			},
			changeIndicator(index){
			   let indicatorWidth = 30
			   const query = uni.createSelectorQuery().in(this);
			   let arr = query.selectAll('.select_top_item .address_value')
			   arr.fields({
			     size: true,
			     scrollOffset: false
			   }, data => {

				 let itemCenterX = 10 + index * 80 + data[index]["width"] / 2
				 let left = itemCenterX - indicatorWidth / 2

				 this.indicatorStyleLeft = left
			   }).exec();
		
			   
			},
			address_item_click(swiper_index,index){
				// console.log(swiper_index,index)
				this.selectIndexArr.splice(swiper_index, 5,index)
				
				//判断当前是否为最下一级
				if (swiper_index === 0){//第一级
				
					let currentObj = this.cityData[index]
					let city = currentObj.name
					this.dataList.splice(swiper_index,5,city)
					this.dataList.splice(swiper_index + 1,0,'请选择')
					this.cityAreaArray.splice(swiper_index + 1, 1,currentObj["city"])
					// console.log(this.dataList)
					setTimeout(() => {
						this.currentIndex = 1
						this.changeIndicator(1)
						}, 50);
					
		
				}else {
					let currentAreaArray = this.cityAreaArray[swiper_index]
					let currentObj = currentAreaArray[index]
					let area = currentObj["area"]
					// console.log(currentAreaArray)
					if (area !== undefined){
						
						let city = currentObj.name
			
						this.dataList.splice(swiper_index,5,city)
						this.dataList.splice(swiper_index + 1,0,'请选择')
						this.cityAreaArray.splice(swiper_index + 1,1,currentObj["area"])
						
						setTimeout(() => {
							this.currentIndex = swiper_index + 1
							this.changeIndicator(swiper_index + 1)
							}, 50);
					}else{//是最下一级
						let city = currentObj.name;
						this.dataList.splice(swiper_index,1,city);
						uni.request({
						    url: 'https://restapi.amap.com/v3/geocode/geo',
						    data: {
						        address: this.dataList.join(''),
								key: this.$wanlshop.config('amapkey')
						    },
						    success: (res) => {
								this.$emit("selectAddress", res.data.geocodes[0]);
								this.isShow = false;
								this.isShowMask = false;
						    }
						});
					}
					
				}
				
			}
		},
		created() {
			this.cityData = cityData
			this.cityAreaArray.push(cityData)
		},
		mounted() {
			
			// this.changeIndicator(0)
		}
	}
</script>

<style lang="scss">
// 不换行
@mixin no-wrap(){
	text-overflow: ellipsis;
	overflow: hidden;
	white-space: nowrap;
}
.wrapper{
	z-index: 9990;
	position: absolute;
	top: 0;
	left: 0;
	bottom: 0;
	right: 0;
	.content_view{
		z-index: 9991;
		background: white;
		position: absolute;
		height: 80%;
		left: 0;
		bottom: 0;
		right: 0;
		border-top-left-radius: 20rpx;
		border-top-right-radius: 20rpx;
		.title_view{
			height: 8%;
			display: flex;
			justify-content: space-between;
			align-items: center;
			padding: 0 $uni-spacing-row-sm;
			.title{
				font-size: uni-font-size-sm;
			}
			.close_view{
				height: 40rpx;
				width: 40rpx;
				display: flex;
				justify-content: center;
				align-items: center;
			}
		}
		.select_top{
			height: 8%;
			display: flex;
			justify-content: flex-start;
			align-items: center;
			padding: 0 20rpx 20rpx 20rpx;
			position: relative;
			box-sizing: border-box;
			.select_top_item{
				width: 160rpx;
				font-size: 28rpx;
				@include no-wrap();
			}
			.indicator{
				position: absolute;
				width: 60rpx;
				height: 4rpx;
				background: $uni-color-error;
				left: 32rpx;
				bottom: 0;
				transition: left 0.5s ease;
			}
		}
		.swiper{
			height: 80%;
			position: relative;
			left: 0;
			top: 0;
			bottom: 0;
			right: 0;
			.swiper-item{
				height: 100%;
				.scroll-view-item{
					height: 100%;
					padding: 0 20rpx;
					.address_item{
						padding: 10rpx 0;
						font-size: 28rpx;
						display: flex;
						align-items: center;
						.address_item_icon{
							width: 40rpx;
							height: 40rpx;
							margin-right: 20rpx;
						}
					}
				}
			}
		}
	}
	.mask{
		position: absolute;
		top: 0;
		left: 0;
		bottom: 0;
		right: 0;
		background: rgba(0,0,0,.2);
	}
}

.content-enter{
  transform: translateY(100%);
}
.content-enter-to{
  transform: translateY(0%);
}
.content-enter-active{
  transition: transform 0.5s;
}
.content-leave{
  transform: translateY(0%);
}
.content-leave-to{
  transform: translateY(100%);
}
.content-leave-active{
  transition: transform 0.5s;
}

</style>
