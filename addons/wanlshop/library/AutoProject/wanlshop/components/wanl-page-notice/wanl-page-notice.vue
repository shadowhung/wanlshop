<template>
	<view class="wanlpage-notice" :style="[pageData.style]">
		<view @tap="$wanlshop.on(pageData.data[0].link)">
			<text class="wlIcon wlIcon-notice margin-right-xs" v-if="pageData.params.show"></text>
			<text>{{pageData.data[0].content}}</text>
		</view>
	</view>
</template>
<script>
	export default {
		name: "WanlPageNotice",
		props: {
			pageData: {
				type: Object,
				default: function() {
					return {
						name: '公告栏',
						type: 'notice',
						params: [],
						style: [],
						data: []
					}
				}
			}
		}
	}
</script>
<style>
</style>
