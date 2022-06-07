module.exports = {
	onLoad() {
		// 设置默认的转发参数
		this.mpShare = {
			title: '', // 默认为小程序名称
			path: '', // 默认为当前页面路径
			imageUrl: '' // 默认为当前页面的截图
		}
		// #ifdef MP-WEIXIN
		wx.showShareMenu({
			withShareTicket: true,
			menus: ['shareAppMessage', 'shareTimeline']
		});
		// #endif
		// #ifdef MP-QQ
		qq.showShareMenu({
			showShareItems: ['qq', 'qzone', 'wechatFriends', 'wechatMoment']
		});
		// #endif
	},
	onShareAppMessage() {
		return this.mpShare
	},
	// #ifdef MP-WEIXIN
	onShareTimeline() {
		return this.mpShare
	}
	// #endif
}