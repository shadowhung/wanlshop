<template>
	<view id="number-keyboard-component" class="numberkeyboard" v-show="numberKeyboardPopupVisible">
		<view class="title" @tap="close"><image :src="$wanlshop.appstc('/common/img_down3x.png')" style="width: 30upx;height: 30upx;"></image></view>
		<view class="keys">
			<view class="key button" v-for="num in config.loop" :key="num.key" @tap="number(num.number)">{{ num.number }}</view>
			<view class="key button" @tap="empty" style="background: #f5f5f5;"><image :src="$wanlshop.appstc('/common/img_empty3x.png')" style="width: 50upx;height: 50upx;"></image></view>
			<view class="key button" @tap="number(0)">0</view>
			<view class="key button" @tap="del" style="background: #f5f5f5;"><image :src="$wanlshop.appstc('/common/img_delete3x.png')" style="width: 50upx;height: 50upx;"></image></view>
		</view>
		<view class="iPhonex"></view>
	</view>
</template>

<script>
export default {
	name: 'WanlKeyboard',
	props: {
		open: {
			type: Boolean,
			default: false
		},
		color: {
			type: String,
			default: '#04BE02'
		}
	},

	data() {
		return {
			config: {
				loop: [
					{
						number: 1,
						key: 'number-1'
					},
					{
						number: 2,
						key: 'number-2'
					},
					{
						number: 3,
						key: 'number-3'
					},
					{
						number: 4,
						key: 'number-4'
					},
					{
						number: 5,
						key: 'number-5'
					},
					{
						number: 6,
						key: 'number-6'
					},
					{
						number: 7,
						key: 'number-7'
					},
					{
						number: 8,
						key: 'number-8'
					},
					{
						number: 9,
						key: 'number-9'
					}
				]
			},
			numberKeyboardPopupVisible: this.open
		};
	},
	watch: {
		numberKeyboardPopupVisible: function(value, oldValue) {
			if (value == false) {
				this.$emit('close');
			}
		},
		open: function(value, oldValue) {
			console.log(value);
			this.numberKeyboardPopupVisible = value;
		}
	},
	methods: {
		close() {
			this.numberKeyboardPopupVisible = false;
			this.$emit('close');
		},
		del() {
			this.$emit('delete');
		},
		empty() {
			this.$emit('empty');
		},
		number(number) {
			this.$emit('number', number);
		}
	}
};
</script>

<style>
.numberkeyboard {
	position: fixed;
	width: 100%;
	bottom: 0;
}
.numberkeyboard .title {
	display: flex;
	justify-content: center;
	align-items: center;
	height: 50upx;
	background: #f9f9f9;
}
.numberkeyboard .keys {
	display: flex;
	flex-direction: row;
	flex-wrap: wrap;
}
.numberkeyboard .keys .key {
	width: 250upx;
	height: 120upx; 
	display: flex;
	justify-content: center;
	align-items: center;
	border-right: 1px solid #f5f5f5;
	box-sizing: border-box;
	font-size: 40upx;
}
.numberkeyboard .keys .key:nth-child(n + 4) {
	border-top: 1px solid #f5f5f5;
	box-sizing: border-box;
}

.numberkeyboard .keys .key:active {
	background: #dddddd;
}

.iPhonex {
	padding-bottom: calc(env(safe-area-inset-bottom) * 1.5);
	background-color: #f5f5f5;
}
</style>
