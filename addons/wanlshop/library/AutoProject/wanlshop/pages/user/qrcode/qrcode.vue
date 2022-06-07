<template>
	<view>
		<view class="edgeInsetTop"></view>
		<view class="page-background"></view>
		<canvas class="qrcode-canvas" canvas-id="qrcode" style="width: 200px;height: 200px;" />
		<view class="page-container">
			<view class="content">
				<view class="poster-image"><image v-if="posterSrc" :src="posterSrc" mode="aspectFit"></image></view>
				<canvas class="poster-canvas" canvas-id="poster" :style="{ width: `${postercanvas_width}px`, height: `${postercanvas_height}px` }" />
			</view>
		</view>
		<view class="page-foot">
			<view class="template-list">
				<view class="template-item" v-for="(x, xi) in posterTemplates" :key="xi" @tap="create(x)" :class="{ checked: x.checked }" :style="{ width: x.thumbnail_width+'px' }">
					<image :src="$wanlshop.oss(x.thumbnail_url, 0, 88)" />
				</view>
				<!-- #ifdef H5 -->
					<view class="tips text-sm wanl-gray">
						<text class="wlIcon-31tishi"></text> 长按图片保存
					</view>
				<!-- #endif -->
				<!-- #ifndef H5 -->
					<view class="tips text-sm wanl-orange" @tap="save()">
						<text class="wlIcon-image margin-right-xs"></text>保存到相册
					</view>
				<!-- #endif -->
			</view>
		</view>
	</view>
</template>

<script>
import uQRCode from '@/common/uqrcode.js';
export default {
	data() {
		return {
			QRCodeText: '水电费水电费水电费是的是的发送到发送到',
			QRCodeSrc: '',
			posterSrc: '',
			postercanvas_width: 0, // 画布宽度
			postercanvas_height: 0, // 画布高度
			posterTemplates: []
		};
	},
	onLoad(option) {
		// 提示
		uni.showLoading({
			title: '二维码生成中',
			mask: true
		});
		if(option.url){
			this.QRCodeText = option.url
		}else{
			this.QRCodeText = this.$store.state.common.appConfig.domain +'/pages/user/info?id='+ this.$store.state.user.id +'&QRtype=user';
		}
		this.loadData();
	},
	methods: {
		// 二维码配置
		async loadData(option) {
			this.$api.post({
				url: '/wanlshop/common/qrcode',
				success: res => {
					// 下载到本地
					res.forEach((item, index, arr) => {
						if (item.template != 'wanlshopqr') {
							// 远程下载背景
							uni.downloadFile({
								url: this.$wanlshop.oss(item.background_url, 350, 0),
								success: e => {
									item.background_url = e.tempFilePath;
								}
							});
							// 远程下载图标
							uni.downloadFile({
								url: this.$wanlshop.oss(item.logo_src, 40, 40),
								success: e => {
									item.logo_src = e.tempFilePath;
								}
							});
						}
					});
					// 赋值
					this.posterTemplates = res;
					if(res.length == 0){
						uni.showModal({
						    title: '重要提示',
						    content: '平台尚未配置二维码，请到后台系统管理【配置二维码】',
						    success: (r)=> {
								this.$wanlshop.back(1);
						    }
						});
					}else{
						uni.showLoading({
							title: '加载配置中',
							mask: true
						});
					}
					// 生成二维码
					uQRCode.make({
						canvasId: 'qrcode',
						text: this.QRCodeText,
						size: 200,
						success: res => {
							this.QRCodeSrc = res;
							// 默认生成第一张海报
							this.create(this.posterTemplates[0]);
						}
					});
				}
			});
		},
		create(posterTemplate) {
			if (posterTemplate.checked) {
				return;
			}
			uni.showLoading({
				title: '海报生成中',
				mask: true
			});
			this.posterTemplates.forEach(x => {
				x.checked = false;
			});
			posterTemplate.checked = true;

			this.postercanvas_width = posterTemplate.canvas_width;
			this.postercanvas_height = posterTemplate.canvas_height;

			this.posterSrc = '';
			setTimeout(() => {
				switch (posterTemplate.template) {
					case 'wanlshopqrlist001':
						this.wanlshopqrlist001({
							canvasId: 'poster',
							canvas_width: posterTemplate.canvas_width,
							canvas_height: posterTemplate.canvas_height,
							backgroundSrc: posterTemplate.background_url,
							logoSrc: posterTemplate.logo_src,
							name: this.$store.state.user.username,
							text: '长按扫描二维码~',
							QRCodeSrc: this.QRCodeSrc,
							success: res => {
								this.posterSrc = res;
								uni.hideLoading();
							}
						});
						break;
					case 'wanlshopqr':
						this.wanlshopqr({
							canvasId: 'poster',
							canvas_width: posterTemplate.canvas_width,
							canvas_height: posterTemplate.canvas_height,
							QRCodeSrc: this.QRCodeSrc,
							success: res => {
								this.posterSrc = res;
								uni.hideLoading();
							}
						});
						break;
				}
			}, 100);
		},
		save() {
			uni.saveImageToPhotosAlbum({
				filePath: this.posterSrc,
				success: () => {
					this.$wanlshop.msg('保存成功');
				}
			});
		},
		wanlshopqrlist001(options) {
			let { canvas_width, canvas_height, backgroundSrc, logoSrc, name, text, QRCodeSrc } = options;
			// 绑定画布
			var ctx = uni.createCanvasContext(options.canvasId);
			// 清除画布
			ctx.clearRect(0, 0, canvas_width, canvas_height);

			// 获取背景图片信息
			let backgroundImageInfo = {
				width: '500',
				height: '667'
			};
			// 设置背景图片宽高
			let backgroundWidth = canvas_width;
			let backgroundHeight = (backgroundImageInfo.height * canvas_width) / backgroundImageInfo.width;
			// 填充背景图片
			ctx.drawImage(backgroundSrc, 0, 0, backgroundWidth, backgroundHeight);
			// 设置标志图片宽高坐标
			let logoWidth = 80;
			let logoHeight = 80;
			let logoX = 36;
			let logoY = backgroundHeight + (canvas_height - backgroundHeight) / 2 - logoHeight / 2;
			// 绘制为圆形标志
			ctx.save();
			ctx.beginPath();
			// 先画个圆  前两个参数确定了圆心 （x,y） 坐标  第三个参数是圆的半径  四参数是绘图方向  默认是false，即顺时针
			ctx.arc(logoWidth / 2 + logoX, logoHeight / 2 + logoY, logoWidth / 2, 0, Math.PI * 2, false);
			ctx.closePath();
			// 画好了圆 剪切  原始画布中剪切任意形状和尺寸。一旦剪切了某个区域，则所有之后的绘图都会被限制在被剪切的区域内 这也是我们要save上下文的原因
			ctx.clip();
			// 填充标志图片
			ctx.drawImage(logoSrc, logoX, logoY, logoWidth, logoHeight);
			// 恢复之前保存的绘图上下文 恢复之前保存的绘图上下午即状态 还可以继续绘制
			ctx.restore();

			// 名称最大长度限制 10，超出为省略号
			if (name.length > 10) {
				name = name.substring(0, 10) + '...';
			}
			// 计算文字定位距离
			let nameX = logoX + logoWidth + 10;
			let nameY = logoY + 32;
			let nameFontSize = 20;
			// 设置名称文字样式
			ctx.setFillStyle('#000000');
			ctx.setFontSize(nameFontSize);
			// 填充名称到画布
			ctx.fillText(name, nameX, nameY);

			// 计算文字定位距离
			let textX = nameX;
			let textY = nameY + 32;
			let textFontSize = 16;
			// 设置分享文案文字样式
			ctx.setFillStyle('#999999');
			ctx.setFontSize(textFontSize);
			// 填充分享文案到画布
			ctx.fillText(text, textX, textY);

			// 设置二维码图片宽高
			let QRCodeWidth = 100;
			let QRCodeHeight = 100;
			// 计算二维码图片定位距离
			let QRCodeX = canvas_width - QRCodeWidth - 36;
			let QRCodeY = backgroundHeight + (canvas_height - backgroundHeight) / 2 - QRCodeHeight / 2;
			// 填充二维码图片
			ctx.drawImage(QRCodeSrc, QRCodeX, QRCodeY, QRCodeWidth, QRCodeHeight);

			// 输出到画布中
			ctx.draw(false, () => {
				// 绘图全部完成后生成文件路径
				uni.canvasToTempFilePath({
					canvasId: options.canvasId,
					fileType: 'jpg',
					success: res => {
						options.success && options.success(res.tempFilePath);
					}
				});
			});
		},
		wanlshopqr(options) {
			let { canvas_width, canvas_height, QRCodeSrc } = options;
			// 绑定画布
			var ctx = uni.createCanvasContext(options.canvasId);
			// 清除画布
			ctx.clearRect(0, 0, canvas_width, canvas_height);
			// 填充二维码图片，并设置边距
			ctx.drawImage(QRCodeSrc, 15, 15, canvas_width - 30, canvas_height - 30);
			// 输出到画布中
			ctx.draw(false, () => {
				// 绘图全部完成后生成文件路径
				uni.canvasToTempFilePath({
					canvasId: options.canvasId,
					fileType: 'jpg',
					success: res => {
						options.success && options.success(res.tempFilePath);
					}
				});
			});
		}
	}
};
</script>

<style>
.page-background {
	position: fixed;
	top: 0;
	right: 0;
	bottom: 0;
	left: 0;
	z-index: 10;
	background-color: #f1f1f1;
}

.page-container {
	position: relative;
	z-index: 20;
}

.qrcode-canvas {
	position: fixed;
	right: 100vw;
	bottom: 100vh;
	z-index: -999;
}

.content {
	width: 100%;
	height: calc(100vh - 44px - 150px);
	overflow-y: scroll;
}

.poster-image {
	width: 100%;
	height: 100%;
	min-height: 500rpx;
	padding: 80rpx;
	box-sizing: border-box;
}

.poster-image image {
	width: 100%;
	height: 100%;
}

.poster-canvas {
	position: fixed;
	right: 100vw;
	bottom: 100vh;
}

.page-foot {
	position: fixed;
	right: 0;
	bottom: 0;
	left: 0;
	z-index: 30;
	background-color: #e5e5e5;
	padding-bottom: env(safe-area-inset-bottom);
}

.template-list {
	display: flex;
	position: relative;
	height: 100px;
}
.template-list .tips {
	position: absolute;
	display: flex;
	align-items: center;
	justify-items: center;
	justify-content: center;
	top: -60rpx;
	width: 100%;
}
.template-list .tips .wlIcon-31tishi{
	font-size: 32rpx;
}
.template-item {
	position: relative;
	height: 88px;
	margin: 6px 0 6px 6px;
}

.template-item::before {
	content: '';
	position: absolute;
	z-index: 10;
	top: 0;
	right: 0;
	bottom: 0;
	left: 0;
}

.template-item.checked::before {
	border: 2px solid #44aa33;
}

.template-item image {
	display: block;
	width: 100%;
	height: 100%;
}
</style>
