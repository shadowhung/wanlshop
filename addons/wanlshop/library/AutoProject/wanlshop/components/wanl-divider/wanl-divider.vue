<template>
	<view class="wanl-divider" :style="{height:height+'rpx'}">
		<view class="wanl-divider-line" :style="{width:width,background:getBgColor(gradual,gradualColor,dividerColor)}"></view>
		<view class="wanl-divider-text" :style="{color:color,fontSize:size+'rpx',lineHeight:size+'rpx',background:bgcolor}">
			<slot></slot>
		</view>
	</view>
</template>

<script>
	export default {
		name: "WanlDivider",
		props: {
			//divider占据高度
			height: {
				type: Number,
				default: 86
			},
			//divider宽度，可填写具体长度，如400rpx
			width: {
				type: String,
				default: "100%"
			},
			//divider颜色，如果为渐变线条，此属性失效
			dividerColor: {
				type: String,
				default: "#cecece"
			},
			//文字颜色
			color: {
				type: String,
				default: "#333"
			},
			//文字大小 rpx
			size: {
				type: Number,
				default: 28
			},
			//背景颜色，和当前页面背景色保持一致
			bgcolor: {
				type: String,
				default: "#f5f5f5"
			},
			//是否为渐变线条，为true，divideColor失效
			gradual: {
				type: Boolean,
				default: false
			},
			//渐变色值，to right ，提供两个色值即可，由浅至深
			gradualColor: {
				type: Array,
				default: function(){
					return ["#eee", "#ccc"]
				}
			}
		},
		methods: {
			getBgColor: function(gradual, gradualColor, dividerColor) {
				let bgColor = dividerColor;
				if (gradual) {
					bgColor = "linear-gradient(to right," + gradualColor[0] + "," + gradualColor[1] + "," + gradualColor[1] + "," +
						gradualColor[0] + ")";
				}
				return bgColor;
			}
		}
	}
</script>

<style>
	.wanl-divider {
		width: 100%;
		position: relative;
		text-align: center;
		display: flex;
		justify-content: center;
		align-items: center;
		box-sizing: border-box;
		overflow: hidden;
	}

	.wanl-divider-line {
		position: absolute;
		height: 1rpx;
		-webkit-transform: scaleY(0.5);
		transform: scaleY(0.5);
	}

	.wanl-divider-text {
		position: relative;
		text-align: center;
		padding: 0 18rpx;
		z-index: 1;
	}
</style>
