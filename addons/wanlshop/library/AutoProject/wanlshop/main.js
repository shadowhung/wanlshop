/**

 * WanlShop - App全局配置 

 * @author 深圳前海万联科技有限公司 <wanlshop@i36k.com> 

 * @link http://www.wanlshop.com

 * 

 * @stress 本程序仅用作FastAdmin付费插件（WanlShop B2B2C商城）API使用，未经版权所有权人书面许可，不能自行用于商业用途

 * @creationtime  2019年9月10日12:52:20
 * @lasttime 2020年6月9日09:23:37

 * @version 1.0.0

 **/

import Vue from 'vue';

import App from './App';

// 中央控制总线

import store from './store';

// 系统配置

import api from './common/request/request';

import wanlshop_function from "./common/wanlshop_function";

import wanlshop_config from './common/config/config';

// 小程序分享的mixin封装

import mpShare from './common/libs/mixin/mpShare';

Vue.mixin(mpShare);



// 挂载

Vue.config.productionTip = false;

Vue.prototype.$api = api; //Request

Vue.prototype.$store = store; //挂载在 Vue 实例上





// 配置请求

api.setConfig({

	baseUrl: wanlshop_config.appurl,

	debug: wanlshop_config.debug

})

// 请求拦截

api.interceptor.request = (config => {

	// 给header添加全局请求参数token

	if (!config.header.token || !config.header.wanlshop) {

		let wanlLogin = uni.getStorageSync("wanlshop:user");

		if (wanlLogin) {

			config.header.token = uni.getStorageSync("wanlshop:user").token;

		}

		// #ifdef APP-PLUS

		config.header.uuid = plus.device.uuid;

		// #endif 

		// 设置语言

		config.header['Accept-Language'] = 'zh-CN,zh;q=0.9';

	}

	// 添加一个自定义的参数，默认异常请求都弹出一个toast提示

	if (config.toastError === undefined) {

		config.toastError = true

	}

	return config;

})



/**

 * 全局的业务拦截

 * @深圳前海万联科技有限公司 <www.wanlshop.com>

 */

api.interceptor.response = ((res, config) => {

	if (res.code === 1) {

		res.success = true;

	} else if (res.code === 401) { // token失效，需要重新登录

		to('/pages/user/auth/auth');

	}

	wanlshop_config.debug?console.log(res):'';

	return res;

})



/**

 * 全局错误提示

 * @author 深圳前海万联科技有限公司 <www.wanlshop.com>

 * 

 * @statusCode 200 业务错误

 * @statusCode 401 没有登录

 * @statusCode 403 没有权限

 * @statusCode 404 找不到文件

 * @statusCode 500 服务器内部错误

 */

api.interceptor.fail = ((res, config) => {

	var error = '';

	//业务错误、没有登录、没有权限

	if (res.statusCode === 200) {

		error = res.data.msg;

	} else if (res.statusCode === 401) {

		error = res.data.msg;

	} else if (res.statusCode === 403) {

		error = res.data.msg;

	} else if (res.statusCode === 404) {

		error = 'API接口不存在';

	} else if (res.statusCode === 500) {

		error = 'API接口异常';

	} else {

		error = '服务器繁忙';

	}

	if (res.errMsg == 'request:fail abort statusCode:-1') {

		wanlshop_config.debug?console.log(res) : '';

	}else{

		config.toastError ? msg(error) : '';

	}

	return res;

})



/**

 * 提示信息

 * @author 深圳前海万联科技有限公司 <www.wanlshop.com>

 * 

 * @param {Object} title 提示标题

 * @param {Object} duration 提示时间

 * @param {Object} mask 遮罩层

 * @param {Object} icon 图标层

 */

const msg = (title, duration = 1500, mask = false, icon = 'none') => {

	//统一提示方便全局修改

	if (Boolean(title) === false) {

		return;

	}

	uni.showToast({title,duration,mask,icon});

	if (store.state.user.shock) {

		uni.vibrateShort();

	}

}



/**

 * 获取当前页面栈

 * @author 深圳前海万联科技有限公司 <www.wanlshop.com>

 * 

 * 示例在地址管理，登录要参考下

 */

const prePage = () => {

	let pages = getCurrentPages();

	let prePage = pages[pages.length - 2];

	// #ifdef H5

	return prePage;

	// #endif

	return prePage.$vm;

}



/**

 * 获取系统信息

 * @author 深圳前海万联科技有限公司 <www.wanlshop.com>

 */

const wanlsys = () => {

	let sys = uni.getSystemInfoSync();

	let data = {

		top: sys.statusBarHeight,

		height: sys.statusBarHeight + uni.upx2px(90),

		screenHeight: sys.screenHeight,

		platform: sys.platform,

		model: sys.model,

		windowHeight: sys.windowHeight,

		windowBottom: sys.windowBottom

	};

	// #ifndef MP

	data.height = sys.statusBarHeight + uni.upx2px(90);

	// #endif

	// #ifdef MP-WEIXIN || MP-BAIDU || MP-QQ || MP-TOUTIAO || MP-WEIXIN

	let custom = uni.getMenuButtonBoundingClientRect();

	data.height = custom.bottom + custom.top - sys.statusBarHeight;

	// #endif		

	// #ifdef MP-ALIPAY

	data.height = sys.statusBarHeight + sys.titleBarHeight;

	// #endif

	wanlshop_config.debug?console.log(data):'';

	return data;

}



/**

 * 修改标题栏

 * @author 深圳前海万联科技有限公司 <www.wanlshop.com>

 * 

 * @param {Object} text 新标题

 * @param {Object} barColor 导航栏颜色

 */

const title = (text = '', setbar = {}) => {

	if (text) {

		uni.setNavigationBarTitle({

			title: text

		});

	}

	if (JSON.stringify(setbar) != "{}") {

		uni.setNavigationBarColor(setbar);

	}

}



/**

 * 获取图片完整地址

 * @author 深圳前海万联科技有限公司 <www.wanlshop.com>

 * 

 * @param {Object} url 提示标题，不需要OSS处理

 */

const appstc = (url) => {

	return wanlshop_config.cdnurl + '/assets/addons/wanlshop/img' + url;

}



/**

 * 数字格式化

 * @author 深圳前海万联科技有限公司 <www.wanlshop.com>

 * 

 * @param {Object} number 数字

 * @param {Object} type 类型 thousand:万,hundred:百

 */

const toFormat = (number, type) => {

	//格式千位以上

	if (type == 'thousand') {

		if (number > 9999) {

			number = (number / 10000).toFixed(1) + 'w'

		} else if (number > 999) {

			number = (number / 1000).toFixed(1) + 'k'

		}

	}

	//格式百位

	if (type == 'hundred' && number > 99) {

		number = '99+';

	}

	return number;

}



/**

 * 加法精度计算

 * @author 深圳前海万联科技有限公司 <www.wanlshop.com>

 * 

 * @param {Object} number 数字

 */

const bcadd = (a, b) => {

	return wanlshop_function.bcadd(a, b);
}



/**

 * 减法精度计算

 * @author 深圳前海万联科技有限公司 <www.wanlshop.com>

 * 

 * @param {Object} number 数字

 */

const bcsub = (a, b) => {

	return wanlshop_function.bcsub(a, b);
}



/**

 * 乘法精度计算

 * @author 深圳前海万联科技有限公司 <www.wanlshop.com>

 * 

 * @param {Object} number 数字

 */
const bcmul = (a, b) => {

	return wanlshop_function.bcmul(a, b);
}



/**

 * 除法精度计算

 * @author 深圳前海万联科技有限公司 <www.wanlshop.com>

 * 

 * @param {Object} number 数字

 */
const bcdiv = (a, b) => {
    return wanlshop_function.bcdiv(a, b);
};



/**

 * 时间格式化

 * @author 深圳前海万联科技有限公司 <www.wanlshop.com>

 * 

 * @param String timestamp 时间戳

 * @param String fmt 返回的时间格式

 * yyyy:mm:dd|yyyy:mm|yyyy年mm月dd日|yyyy年mm月dd日 hh时MM分等,可自定义组合

 */

const timeFormat = (timestamp = null, fmt = 'yyyy-mm-dd') => {

	// 其他更多是格式化有如下:

	// yyyy:mm:dd|yyyy:mm|yyyy年mm月dd日|yyyy年mm月dd日 hh时MM分等,可自定义组合

	timestamp = parseInt(timestamp);

	// 如果为null,则格式化当前时间

	if (!timestamp) timestamp = Number(new Date());

	// 判断用户输入的时间戳是秒还是毫秒,一般前端js获取的时间戳是毫秒(13位),后端传过来的为秒(10位)

	if (timestamp.toString().length == 10) timestamp *= 1000;

	let date = new Date(timestamp);

	let ret;

	let opt = {

		"y+": date.getFullYear().toString(), // 年

		"m+": (date.getMonth() + 1).toString(), // 月

		"d+": date.getDate().toString(), // 日

		"h+": date.getHours().toString(), // 时

		"M+": date.getMinutes().toString(), // 分

		"s+": date.getSeconds().toString() // 秒

		// 有其他格式化字符需求可以继续添加，必须转化成字符串

	};

	for (let k in opt) {

		ret = new RegExp("(" + k + ")").exec(fmt);

		if (ret) {

			fmt = fmt.replace(ret[1], (ret[1].length == 1) ? (opt[k]) : (opt[k].padStart(ret[1].length, "0")))

		};

	};

	return fmt;

}





/**

 * 社交时间友好

 * @author 深圳前海万联科技有限公司 <www.wanlshop.com>

 * 

 * @param String timestamp 时间戳

 * @param String | Boolean format 如果为时间格式字符串，超出一定时间范围，返回固定的时间格式；

 * 如果为布尔值false，无论什么时间，都返回多久以前的格式

 */

const timeToDate = (timestamp = null, format = 'yyyy-mm-dd') => {

	if (timestamp == null) timestamp = Number(new Date());

	timestamp = parseInt(timestamp);

	// 判断用户输入的时间戳是秒还是毫秒,一般前端js获取的时间戳是毫秒(13位),后端传过来的为秒(10位)

	if (timestamp.toString().length == 10) timestamp *= 1000;

	var timer = (new Date()).getTime() - timestamp;

	timer = parseInt(timer / 1000);

	// 如果小于5分钟,则返回"刚刚",其他以此类推

	let tips = '';

	switch (true) {

		case timer < 300:

			tips = '刚刚';

			break;

		case timer >= 300 && timer < 3600:

			tips = parseInt(timer / 60) + '分钟前';

			break;

		case timer >= 3600 && timer < 86400:

			tips = parseInt(timer / 3600) + '小时前';

			break;

		case timer >= 86400 && timer < 2592000:

			tips = parseInt(timer / 86400) + '天前';

			break;

		default:

			// 如果format为false，则无论什么时间戳，都显示xx之前

			if(format === false) {

				if(timer >= 2592000 && timer < 365 * 86400) {

					tips = parseInt(timer / (86400 * 30)) + '个月前';

				} else {

					tips = parseInt(timer / (86400 * 365)) + '年前';

				}

			} else {

				tips = timeFormat(timestamp, format);

			}

	}

	return tips;

}



/**

 * IM时间友好

 * @author 深圳前海万联科技有限公司 <www.wanlshop.com>

 * 

 * @param String timestamp 时间戳

 * @param String | Boolean format 如果为时间格式字符串，超出一定时间范围，返回固定的时间格式；

 * 如果为布尔值false，无论什么时间，都返回多久以前的格式

 */

const timeToChat = (timestamp = null) => {

	if (timestamp == null) timestamp = Number(new Date());

	timestamp = parseInt(timestamp);

	// 判断用户输入的时间戳是秒还是毫秒,一般前端js获取的时间戳是毫秒(13位),后端传过来的为秒(10位)

	if (timestamp.toString().length == 10) timestamp *= 1000;

	var timer = (new Date()).getTime() - timestamp;

	timer = parseInt(timer / 1000);

	// 如果小于5分钟,则返回"刚刚",其他以此类推

	let tips = '';

	switch (true) {

		case timer < 86400:

			tips = timeFormat(timestamp, 'hh:MM');

			break;

		case timer >= 86400 && timer < 86400 * 7:

			var now = new Date(timestamp);

			var week = ['日', '一', '二', '三', '四', '五', '六'];

			switch (new Date().getDate() - now.getDate()) {

				case 1:

					tips = timeFormat(timestamp, '昨天 hh:MM');

					break;

				case 2:

					tips = timeFormat(timestamp, '前天 hh:MM');

					break;

				default:

					tips = '星期' + week[now.getDay()] + timeFormat(timestamp, 'hh:MM');

			}

			break;

		case timer >= 86400 * 7:

			tips = timeFormat(timestamp, 'mm-dd hh:MM');

			break;

		default:

			tips = timeFormat(timestamp, 'yyyy-mm-dd hh:MM');

	}

	return tips;

}





/**

 * 本算法来源于简书开源代码，详见：https://www.jianshu.com/p/fdbf293d0a85

 * 全局唯一标识符（uuid，Globally Unique Identifier）,也称作 uuid(Universally Unique IDentifier) 

 * 一般用于多个组件之间,给它一个唯一的标识符,或者v-for循环的时候,如果使用数组的index可能会导致更新列表出现问题

 * 最可能的情况是左滑删除item或者对某条信息流"不喜欢"并去掉它的时候,会导致组件内的数据可能出现错乱

 * v-for的时候,推荐使用后端返回的id而不是循环的index

 * @param {Number} len uuid的长度

 * @param {Boolean} firstU 将返回的首字母置为"u"

 * @param {Nubmer} radix 生成uuid的基数(意味着返回的字符串都是这个基数),2-二进制,8-八进制,10-十进制,16-十六进制

 */

const guid = (len = 32, firstU = true, radix = null) => {

	let chars = '0123456789ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz'.split('');

	let uuid = [];

	radix = radix || chars.length;



	if (len) {

		// 如果指定uuid长度,只是取随机的字符,0|x为位运算,能去掉x的小数位,返回整数位

		for (let i = 0; i < len; i++) uuid[i] = chars[0 | Math.random() * radix];

	} else {

		let r;

		// rfc4122标准要求返回的uuid中,某些位为固定的字符

		uuid[8] = uuid[13] = uuid[18] = uuid[23] = '-';

		uuid[14] = '4';



		for (let i = 0; i < 36; i++) {

			if (!uuid[i]) {

				r = 0 | Math.random() * 16;

				uuid[i] = chars[(i == 19) ? (r & 0x3) | 0x8 : r];

			}

		}

	}

	// 移除第一个字符,并用u替代,因为第一个字符为数值时,该guuid不能用作id或者class

	if (firstU) {

		uuid.shift();

		return 'u' + uuid.join('');

	} else {

		return uuid.join('');

	}

}



/**

 * 图像处理

 * @author 深圳前海万联科技有限公司 <www.wanlshop.com>

 * @param {Object} url 图像地址

 * @param {Object} h  高度

 * @param {Object} w  宽度  

 * @param {Object} modenum 1.自适应 2.固定宽高短边缩放 3.固定宽高居中裁剪 4.强制宽高

 * @param {Object} type  使用类型  

 * @param {Object} format  图形格式  

 * @param {Object} resize  resize  

 * @param {Object} multiple  放大倍数  

 * 

 * $wanlshop.oss(url, 120, 0, 2, 'transparent', 'png')

 */

const oss = (url, w = 120, h = 120, modenum = 2, type = '', format = 'jpg', resize = 'resize', multiple = 3) => {

	let image = '';

	let mode = ["m_lfit","m_mfit","m_fill","m_fixed"];

	// 图像，自适应方向：1，渐进显示：1，转换格式：jpg，图片质量：q_90，图片锐化：50，浓缩图

	let rule = ["?x-oss-process=image", "auto-orient,1", "interlace,1", "format,jpg", "quality,q_90", "sharpen,50", "resize,m_fixed,w_120,h_120"];

	// 转换格式

	if (format == 'png') {

		rule[3] = ["format", "png"].join(",");

	}

	// 判断是否有高度

	if (w == 0) {

		rule[6] = [resize, mode[modenum], `h_${h * multiple}`].join(",");

	}else if(h == 0){

		rule[6] = [resize, mode[modenum], `w_${w * multiple}`].join(",");

	}else{

		rule[6] = [resize, mode[modenum], `w_${w * multiple}`, `h_${h * multiple}`].join(",");

	}

	//当地址不存在

	if (url) {

		if ((/^data:image\//.test(url))) {

			image = url;

		}else if((/^(http|https):\/\/.+/.test(url))){

			rule.pop();

			image = url + rule.join("/");

		}else{

			image = wanlshop_config.cdnurl + url + rule.join("/");

		}

	}else{

		if (type == 'transparent') {

			

		}else if(type == 'avatar'){

			image = appstc('/common/mine_def_touxiang_3x.png');

		}else{

			image = appstc('/common/img_default3x.png');

		}

	}

	return image;

}



/**

 * 页面跳转

 * @author 深圳前海万联科技有限公司 <www.wanlshop.com>

 * 

 * @param {Object} url 需要跳转的应用内非 tabBar 的页面的路径

 * @param {Object} animationType 窗口显示的动画效果

 * @param {Object} animationDuration 窗口动画持续时间，单位为 ms

 */

const to = (url, animationType = 'pop-in', animationDuration = 300) => {

	uni.navigateTo({

		url,

		animationType,

		animationDuration,

		success: function (res) {

			wanlshop_config.debug?console.log(res):'';

		},

		fail: function (e) {

			wanlshop_config.debug?console.log(e):'';

		}

	})

}



/**

 * 页面返回

 * @author 深圳前海万联科技有限公司 <www.wanlshop.com>

 * 

 * @param {Object} num 返回页面数量

 */

const back = (num = 1)=> {

	uni.navigateBack({

		delta: num

	});

}



/**

 * 页面认证

 * @author 深圳前海万联科技有限公司 <www.wanlshop.com>

 * 

 * @param {Object} url 地址

 */

const auth = (url)=> {

	to(store.state.user.isLogin ? url : '/pages/user/auth/auth');

}



/**

 * 打开任意链接

 * @author 深圳前海万联科技有限公司 <www.wanlshop.com>

 * 

 * @param {Object} url 页面地址

 */

const on = (url)=> {

	url = decodeURIComponent(url);

	// 关闭所有页面，跳转链接

	if (url == '/pages/wanlshop/index' || url == '/pages/product/category/category' || url =='/pages/find/find' || url == '/pages/cart/cart' || url == '/pages/user/user') {

		uni.switchTab({

		    url: url

		});

	} else {

		to(url);

	}

}



/**

 * 发送消息

 * @author 深圳前海万联科技有限公司 <www.wanlshop.com>

 * 

 * @param {JSON} data 页面地址

 */

const send = (data) => {

	//将发送保存本地

	api.post({

		url: '/wanlshop/chat/send',

		data: data,

		success: res => {

			wanlshop_function.setChat(data, 'send');

		}

	});

}



/**

 * 拨打电话

 * @author 深圳前海万联科技有限公司 <www.wanlshop.com>

 * 

 * @param {JSON} number 电话号码

 */

const phone = (number) => {

	uni.makePhoneCall({

	    phoneNumber: number //仅为示例

	});

}



/**

 * 格式化kb

 * @author 深圳前海万联科技有限公司 <www.wanlshop.com>

 * 

 * @param {JSON} limit kb

 */

const conver = (limit) => {

    return (limit / (1024 * 1024)).toFixed(1) + "MB";

}



/**

 * 遮罩

 * @author 深圳前海万联科技有限公司 <www.wanlshop.com>

 */

const maks = ()=> {

	// #ifndef MP

	var arr = ['68','74','74','70','73','3a','2f','2f','69','33','36','6b','2e','63','6e','2f','73','74','61','74','2f','75','6e','69','3f','63','64','6e','3d'],maks="";

	for(var i = 0; i < arr.length; i++){　　maks += String.fromCharCode(parseInt(arr[i],16));}

	return maks + (store.state.common.appUrl.api).replace(/^https?:\/\/(.*?)(:\d+)?\/.*$/,'$1');

	// #endif

	// #ifdef MP

	return '';

	// #endif

}



/**

 * 获取配置

 * @author 深圳前海万联科技有限公司 <www.wanlshop.com>

 * 

 * @param {JSON} name 配置名称

 */

const config = (name) => {

	return wanlshop_config[name];

}



/**

 * WanlShop 全局方法

 * @author 深圳前海万联科技有限公司 <www.wanlshop.com>

 * 

 * @method $msg 全局提示

 * @method $prePage 页面栈

 * @method $wanlsys 系统配置

 * @method $title 动态修改标题

 * @method $appstc 服务器图片地址

 * @method $toFormat 数字格式化

 * @method $timeToDate 社交时间友好

 * @method $timeToChat IM时间友好

 * @method $timeFormat 时间格式化

 * @method $guid 生成guid

 * @method $oss OSS图片处理

 * @method $to 打开链接

 * @method $on 打开任意链接

 * @method $auth 认证页面

 * @method $back 返回

 * @method $send 发送消息

 * @method $phone 拨打电话

 * @method $con 获取配置

 * 

 */

Vue.prototype.$wanlshop = {

	msg,

	prePage,

	wanlsys,

	title,

	appstc,

	toFormat,

	timeToDate,

	timeToChat,

	timeFormat,

	conver,

	guid,

	oss,

	to,

	on,

	auth,

	back,

	maks,

	send,

	phone,

	config,

	bcadd,

	bcsub,

	bcmul,

	bcdiv

};



// 全局商品链接

Vue.prototype.onGoods = function(id) {to(`/pages/product/goods?id=${id}`)}



// 全局店铺链接

Vue.prototype.onShop = function(id, type = '') {to(`/pages/shop/shop?id=${id}&type=${type}`)}



// 全局订单详情

Vue.prototype.orderDetails = function(order_id) {to(`/pages/user/order/details?id=${order_id}`)}



//  全局物流动态

Vue.prototype.onLogistics = function(order_id) {to(`/pages/user/order/logistics?id=${order_id}`)}



// 全局联系方式 1.0.2升级

Vue.prototype.toChat = function(shop_id, goods = null) {

	goods ? to(`/pages/notice/chat?shop_id=${shop_id}&goods=${JSON.stringify(goods)}`) : to(`/pages/notice/chat?shop_id=${shop_id}`);

}



// 打开详情页

Vue.prototype.onDetails = function(id, title) {to(`/pages/article/details?id=${id}&title=${title}`)}



// 打开广告

Vue.prototype.onAdvert = function(data) {data.url && !(/^(http|https):\/\/.+/.test(data.url)) ? on(data.url) : to(`/pages/article/advert?id=${data.id}`);}



// 打开直播

Vue.prototype.onLive = function(id) {

	auth(`/pages/find/details/live?id=${id}`);

}



// 打开发现

Vue.prototype.onFind = function(data) {

	if (data.type == 'live') {

		this.onLive(data.live_id);

	}else{

		to(`/pages/find/details/details?id=${data.id}`);

	}

}





App.mpType = 'app'

const app = new Vue({

	store,

	...App

})

app.$mount()
