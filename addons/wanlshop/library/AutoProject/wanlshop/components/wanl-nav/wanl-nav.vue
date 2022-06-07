<template>
	<view>
		<view class="cu-custom">
			<view class="cu-bar search fixed">
				<slot name="left"></slot>
				<slot name="content"></slot>
				<view class="action">
					<slot name="right"></slot>
				</view>
			</view>
		</view>
	</view>
</template>

<script>
	export default {
		
		props: {
			bgColor: {
				type: String,
				default: ''
			},
			bgImage: {
				type: String,
				default: ''
			}
		}
	}
</script>

<style>

</style>
