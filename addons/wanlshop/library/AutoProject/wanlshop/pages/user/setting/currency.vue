<template>
	<view>
		<view class="edgeInsetTop"></view>
		<view class="cu-form-group">
			<view class="title">截屏后提示</view>
			<switch @change="screenshot" :checked="common.config.screenshot"/>
		</view>
		<view class="cu-form-group ">
			<view class="title">开启屏幕旋转</view>
			<switch @change="position" :checked="common.config.position"/>
		</view>
		<view class="cu-form-group ">
			<view class="title">获取地理位置</view>
			<switch @change="map" :checked="common.config.map"/>
		</view>
	</view>
</template>
<script>
	import { mapState } from 'vuex';
	export default {
		computed: {
			...mapState(['common'])
		},
		methods: {
			screenshot(e){
				this.$store.commit('common/setConfig', {screenshot: e.target.value});
			},
			position(e){
				this.$store.commit('common/setConfig', {position: e.target.value});
			},
			map(e){
				this.$store.commit('common/setConfig', {map: e.target.value});
			}
		}
	}
</script>

<style>
	
</style>
