<!-- 
	版本声明：
	* 由于 WanlLive、WanlChat、以下代码开发难度较大，已将相关代码独立申请著作权，受法律保护！！！
	* 无论你购买任何版本，均不允许复制到第三方直接、间接使用，且也不能以学习为目的参考和借鉴！！
	* 你仅有在 WanlShop 中使用、二次开发权利，否则我们会追究法律责任 
	* 福建度虎科技有限公司 @www.i36k.com
-->
<!--  -->
<template>
	<view style="flex: 1;">
		<!-- #ifndef H5 -->
		<!-- 基本所有小程序都支持m3u8，但m3u8延迟较高，App使用rtmp -->
		<video
			:style="{ height: screenHeight + 'px',width: screenWidth + 'px'}"
			:src="source"
			:controls="false"
			object-fit="fill"
			loop
			autoplay
		></video>
		<!-- #endif -->
		<!-- #ifdef H5 -->
		<!-- 因Flash业务调整，Flash播放已停止更新，很遗憾不能使用rtmp播放，可以选择m3u8、flv -->
		<wanl-player
			:autoplay="true"
			:source="source"
			:height="screenHeight + 'px'"
			:videoHeight="screenHeight + 'px'"
			:width="screenWidth + 'px'"
			videoWidth="auto"
			:isLive="true"
		></wanl-player>
		<!-- #endif -->
	</view>
</template>

<script>
export default {
	name: "wanlLivePlay",
	props: {
		screenHeight: {
			default: 0
		},
		screenWidth: {
			default: 0
		},
		source: {
			type: String,
			default: ''
		}
	}
};
</script>

<style></style>
