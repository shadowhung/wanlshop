<template>
	<view class="wanl-image">
		<image 
			class="wanl-image-image"
			:lazy-load="true" 
			:fade-show="false" 
			:src="stcOss(image)" 
			mode="aspectFill" 
			:style="{ height: screenHeight + 'px', width: screenWidth + 'px'}"
		></image>
	</view>
</template>

<script>
export default {
	name: 'wanlLiveEmpty',
	props: {
		screenHeight: {
			default: 0
		},
		screenWidth: {
			default: 0
		},
		image: {
			type: String,
			default: ''
		}
	},
	methods: {
		stcOss(url) {
			let oss = this.$store.state.common.appUrl.oss;
			let image = '';
			if (url) {
				if (/^(http|https):\/\/.+/.test(url)) {
					image = url;
				} else {
					image = oss + url;
				}
			} else {
				image = '';
			}
			return image;
		}
	}
};
</script>

<style>
.wanl-image {
	position: absolute;
	left: 0;
	right: 0;
	top: 0;
	bottom: 0;
	align-items: center;
	justify-content: center;
}
.wanl-image-image{
	/* #ifndef APP-PLUS */
	filter: blur(10px);
	/* #endif */
	background-color: #000000;
}
</style>
