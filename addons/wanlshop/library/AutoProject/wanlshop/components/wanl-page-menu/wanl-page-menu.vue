<template>
	<!-- ok -->
	<view class="wanlpage-menu grid text-center" 
		:class="'col-' + pageData.params.colfive" 
		:style="[pageData.style]"
		> 
		<view class="item" 
			:style="{'margin-top':pageData.params.menuMarginTop}" 
			v-for="(menu, keys) in pageData.data" 
			:key="keys"
			@tap="onLink(menu.link)">
			<view class="picicon" 
			:class="menu.bgClass" 
			:style="{'height':pageData.params.menuHeightWidth,'width':pageData.params.menuHeightWidth,'margin-bottom':pageData.params.menuMarginBottom}">
				<text 
					:class="[menu.icon,menu.iconClass]" 
					:style="{'font-size':pageData.params.menuIconSize}"></text>
			</view>
			<view :style="{'font-size':pageData.params.menuTextSize}">
				{{menu.text}}
			</view>
		</view>
	</view>
</template>
<script>
	export default {
		name: "WanlPageMenu",
		props: {
			pageData: {
				type: Object,
				default: function() {
					return {
						name: '菜单组件',
						type: 'menu',
						params: [],
						style: [],
						data: []
					}
				}
			}
		},
		// 1.0.2升级
		methods:{
			async onLink(url){
				this.$wanlshop.on(url);
			}
		}
	}
</script>
<style>
	.wanlpage-menu .picicon {
		display: inline-flex;
		align-items: center;
		justify-content: center;
		border-radius: 5000rpx;
		border: 1px solid rgba(255, 255, 255, .3);
	}
</style>
