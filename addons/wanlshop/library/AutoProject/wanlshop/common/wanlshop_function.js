 /**

  * A Request useing App network request design {@link http://www.wanlshop.com}

  * @author 深圳前海万联科技有限公司 <wanlshop@i36k.com> < 本程序仅用作FastAdmin付费插件（多用户分销商城）测试使用，未经版权所有权人书面许可，不能自行用于商业用途！>

  * @2019年9月10日12:52:20

  * @version 1.0.1

  * 

  **/

class wanlfun {

	

	/**

	 * 保存聊天记录

	 * @author 深圳前海万联科技有限公司 <www.wanlshop.com>

	 */

	setChat(data,send) {

		let uid = send == 'send' ? data.to_id : data.form.id;

		uni.getStorage({

		    key: 'wanlchat:message_' + uid,

		    success: function (res) {

				// 储存所有消息

				// let arr = res.data;

				// 优化,只储存 100条数据,超过100条,通过接口获取历史记录

				let arr = res.data.slice(-96);

				arr.push(data);

				uni.setStorageSync('wanlchat:message_' + uid, arr);

		    },

			fail: function (res) {

				uni.setStorageSync('wanlchat:message_' + uid, [data]);

		    }

		});

		// 返回原始数据

		return data;

	}

	

	/**

	 * 加法精度计算

	 * @author 深圳前海万联科技有限公司 <www.wanlshop.com>

	 * 

	 * @param {Object} number 数字

	 */

	bcadd(a, b){

	    var c, d, e;

	    try {

	        c = a.toString().split(".")[1].length

	    } catch(f) {

	        c = 0

	    }

	    try {

	        d = b.toString().split(".")[1].length

	    } catch(f) {

	        d = 0

	    }

	    return e = Math.pow(10, Math.max(c, d)),(this.bcmul(a, e) + this.bcmul(b, e)) / e

	}

	

	/**

	 * 减法精度计算

	 * @author 深圳前海万联科技有限公司 <www.wanlshop.com>

	 * 

	 * @param {Object} number 数字

	 */

	bcsub(a, b){

	    var c, d, e;

	    try {

	        c = a.toString().split(".")[1].length

	    } catch(f) {

	        c = 0

	    }

	    try {

	        d = b.toString().split(".")[1].length

	    } catch(f) {

	        d = 0

	    }

	    return e = Math.pow(10, Math.max(c, d)),(this.bcmul(a, e) - this.bcmul(b, e)) / e

	}

	

	/**

	 * 乘法精度计算

	 * @author 深圳前海万联科技有限公司 <www.wanlshop.com>

	 * 

	 * @param {Object} number 数字

	 */

	bcmul(a, b){

	    var c = 0,

	    d = a.toString(),

	    e = b.toString();

	    try {

	        c += d.split(".")[1].length

	    } catch(f) {}

	    try {

	        c += e.split(".")[1].length

	    } catch(f) {}

	    return Number(d.replace(".", "")) * Number(e.replace(".", "")) / Math.pow(10, c)

	}

	

	/**

	 * 除法精度计算

	 * @author 深圳前海万联科技有限公司 <www.wanlshop.com>

	 * 

	 * @param {Object} number 数字

	 */

	bcdiv(a, b){

	    var c, d, e = 0,

	    f = 0;

	    try {

	        e = a.toString().split(".")[1].length

	    } catch(g) {}

	    try {

	        f = b.toString().split(".")[1].length

	    } catch(g) {}

	    return c = Number(a.toString().replace(".", "")),d = Number(b.toString().replace(".", "")),this.bcmul(c / d, Math.pow(10, f - e))

	}

}

export default new wanlfun();
