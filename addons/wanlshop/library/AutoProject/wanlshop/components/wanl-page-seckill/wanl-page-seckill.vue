<template>
	<view class="wanlpage-seckill">
		{{pageData.name}}wanlpage-seckill
	</view>
</template>
<script>
	export default {
		name: "WanlPageSeckill",
		props: {
			pageData: {
				type: Object,
				default: function() {
					return {
						name: '',
						type: '',
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
