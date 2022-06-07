<template>
	<view class="bank-item" :style="bankThem">
		<!-- #ifndef MP -->
		<canvas v-if="showCanvas" class="bank-icon" :id="uuid" :canvas-id="uuid" />
		<!-- #endif -->
		<!-- #ifdef MP -->
		<canvas v-if="showCanvas" class="bank-icon" id="bankIcon" canvas-id="bankIcon" />
		<!-- #endif -->
		<view class="bank-head">
			<image :src="image"></image>
			<view class="bank-info">
				<text class="bank-name">{{bankName}}</text>
				<text class="card-type">{{cardType}}</text>
			</view>
		</view>
		<view class="card-code">
			<text class="omit">****</text>
			<text class="omit">****</text>
			<text class="omit">****</text>
			<text>{{endNumber}}</text>
		</view>
		<image class="bank-watermark" :src="waterMark"></image>
	</view>
</template>

<script>
	export default {
		name: 'wanlBank',
		props: {
			bankCode: { type: String, required: true},
			bankName: { type: String, required: true},
			cardType: { type: String, default: '储蓄卡' },
			cardCode: { type: String, required: true}
		},
		computed: {
			waterMark() {
				return this.image;
			},
			endNumber() {
				let length = this.cardCode.length;
				return this.cardCode.substr(length - 4, length);
			}
		},
		data() {
			// #ifndef MP
			const buildUuid = () => {
				return 'bank_' + parseInt(Math.random() * 100000000);
			};
			// #endif
			return {
				bankThem: '',
				image: '',
				showCanvas: true,
				// #ifdef MP
				uuid: 'bankIcon',
				// #endif
				// #ifndef MP
				uuid: buildUuid()
				// #endif
			};
		},
		methods: {
			async buildItem() {
				this.bankThem = uni.getStorageSync(`BANK_${this.bankCode}`);
				
				this.image = `/static/images/bank/${this.bankCode}.png`;
				
				await this.getThemColor();
				this.showCanvas = false;
			},
			async getThemColor() {
				if(this.bankThem != null && this.bankThem != '') return;
				let bgSize = uni.upx2px(100);
				let iconSize = uni.upx2px(72);
				this.iconContext = uni.createCanvasContext(this.uuid, this);
				this.iconContext.width = bgSize;
				this.iconContext.height = bgSize;
				this.iconContext.fillStyle = '#FFFFFF';
				this.iconContext.beginPath();
				let bgRadio = bgSize / 2;
				this.iconContext.arc(bgRadio, bgRadio, bgRadio - 1 , 0, 2 * Math.PI, 0, true);
				this.iconContext.closePath();
				this.iconContext.fill();
				let iconRadio =  bgSize / 2 - iconSize / 2;
				this.iconContext.drawImage(this.image, iconRadio, iconRadio, iconSize, iconSize);
				await this.draw(this.iconContext);
				let imageData = await this.getImageData(iconRadio, iconSize);
				this.parsingImageData(imageData);
			},
			parsingImageData(imageData) {
				let statistics = {};
				for (let i = 0, length = imageData.length; i < length; i += 4) {
					let r = imageData[i];
					let g = imageData[i + 1];
					let b = imageData[i + 2];
					if((r + g + b) < 400) {
						let rgb = [r, g, b];
						let key = rgb.join(', ');
						statistics[key] = statistics[key] == null ? 1 : statistics[key] + 1;
					}	
				}
				let maxKey = '';
				Object.keys(statistics).forEach(key => {
					if (maxKey === '') {
						maxKey = key;
					} else {
						maxKey = statistics[maxKey] > statistics[key] ? maxKey : key;
					}
				});
				let beginColor =  maxKey.split(', ').map((item, index) => {
					item = parseInt(item);
					if(index > 1) return item;
					let newColor = item + 50;
					return newColor > 255 ? 255 : newColor;
				}).join(', ');
				this.bankThem = `background-image: linear-gradient(45deg, rgba(${beginColor}, 1), rgba(${maxKey}, 1));`;
				uni.setStorageSync(`BANK_${this.bankCode}`, this.bankThem);
			},
			getImageData(radio, size) {
				return new Promise((resolve, reject) => {
					uni.canvasGetImageData({
							canvasId: this.uuid,
							x: radio,
							y: radio,
							width: size,
							height: size,
							success(res) {
								resolve(res.data);
							},
							fail(err) {
								console.log(err);
								reject();
							}
						},
						this
					);
				});
			},
			getBankLogo() {
				return new Promise((resolve, reject) => {
					uni.downloadFile({
						url: this.$wanlshop.appstc(`/bank/${this.bankCode}.png`),
						success(res) {
							resolve(res.tempFilePath);
						},
						fail(err) {
							console.log(err);
							reject();
						}
					});
				});
			},
			draw(context, reserve = false) {
				return new Promise((resolve) => {
					context.draw(reserve, () => {
						resolve();
					});
				});
			}
		},
		created() {
			this.$nextTick(() => {
				this.buildItem();
			});
		}
	};
</script>

<style>
	.omit {
		font-size: 48rpx;
		margin-right: 30rpx;
	}
	.card-code {
		margin-top: 15rpx;
		display: flex;
		justify-content: flex-end;
		color: #FFFFFF;
		font-size: 38rpx;
		
	}
	.flex-1 {
		flex: 1;
	}
	.card-type {
		font-size: 24rpx;
		color: #F1F1F1;
	}
	.bank-name {
		font-size: 32rpx;
		color: #FFFFFF;
	}
	.bank-info {
		display: flex;
		flex-direction: column;
		margin-left: 30rpx;
	}
	.bank-head {
		display: flex;
		flex: 1;
		align-items: center;
	}
	.bank-head image {
		width: 100rpx;
		height: 100rpx;
		padding: 15rpx;
		background-color: #FFFFFF;
		border-radius: 50%;
		overflow: hidden;
	}
	.bank-icon {
		position: absolute;
		top: 20rpx;
		left: 20rpx;
		width: 100rpx;
		height: 100rpx;
	}

	.bank-watermark {
		position: absolute;
		right: 60rpx;
		bottom: -30rpx;
		width: 120rpx;
		height: 120rpx;
		filter: grayscale(100%) brightness(400%);
		opacity: 0.1;
	}

	.bank-item {
		flex: 1;
		margin-top: 20rpx;
		position: relative;
		border-radius: 20rpx;
		padding: 20rpx;
	}
	
	/* .bank-item:after {
		content: "";
		display: block;
		background: inherit;
		filter: blur(10rpx);
		position: absolute;
		width: 100%;
		height: 100%;
		top: 10rpx;
		left: 10rpx;
		z-index: -1;
		opacity: 0.4;
		transform-origin: 0 0;
		border-radius: inherit;
		transform: scale(1, 1);
	} */
</style>
