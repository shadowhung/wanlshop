<template>
	<!-- ok -->
	<view class="wanlpage-empty" :style="[pageData.style]"></view>
</template>
<script>
	export default {
		name: "WanlPageEmpty",
		props: {
			pageData: {
				type: Object,
				default: function() {
					return {
						name: '空白行',
						type: 'empty',
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
