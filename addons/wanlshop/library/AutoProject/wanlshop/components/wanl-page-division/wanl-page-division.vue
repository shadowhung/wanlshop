<template>
	<!-- ok -->
	<view class="wanlpage-division" :style="[pageData.style]">
		<view class="wanl-divider-line" :style="{'width':pageData.params.lineWidth,'height':pageData.params.lineHeight,'background':pageData.params.lineBackground}"></view>
		<view class="wanl-divider-text" :style="{'color':pageData.params.lineTextColor,'font-size':pageData.params.lineTextSize,'line-height':pageData.params.lineTextSize,'background':pageData.params.lineTextBackground,'padding':pageData.params.lineTextPadding}">
			{{pageData.params.lineText}}
		</view>
	</view>
</template>
<script>
	export default {
		name: "WanlPageDivision",
		props: {
			pageData: {
				type: Object,
				default: function() {
					return {
						name: '·Ö¸ô·û',
						type: 'division',
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
	.wanlpage-division {
		width: 100%;
		position: relative;
		text-align: center;
		display: flex;
		justify-content: center;
		align-items: center;
		box-sizing: border-box;
		overflow: hidden;
	}
	
	.wanlpage-division .wanl-divider-line {
		position: absolute;
		-webkit-transform: scaleY(0.5);
		transform: scaleY(0.5);
	}
	
	.wanlpage-division .wanl-divider-text {
		position: relative;
		text-align: center;
		z-index: 1;
	}
</style>
