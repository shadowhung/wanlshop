<template>
	<view class="wanlpage-bargain">
		{{pageData.name}}wanlpage-bargain
	</view>
</template>
<script>
	export default {
		name: "WanlPageBargain",
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
