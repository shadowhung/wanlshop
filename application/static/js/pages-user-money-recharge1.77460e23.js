(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["pages-user-money-recharge1"],{"612f":function(e,t,n){"use strict";n.r(t);var a=n("b8eb"),i=n.n(a);for(var s in a)"default"!==s&&function(e){n.d(t,e,(function(){return a[e]}))}(s);t["default"]=i.a},"63dc":function(e,t,n){var a=n("da2d");"string"===typeof a&&(a=[[e.i,a,""]]),a.locals&&(e.exports=a.locals);var i=n("4f06").default;i("000c3a73",a,!0,{sourceMap:!1,shadowMode:!1})},"77fa":function(e,t,n){"use strict";var a;n.d(t,"b",(function(){return i})),n.d(t,"c",(function(){return s})),n.d(t,"a",(function(){return a}));var i=function(){var e=this,t=e.$createElement,n=e._self._c||t;return n("v-uni-view",[n("v-uni-view",{staticClass:"edgeInsetTop"}),n("v-uni-view",{staticClass:"wanl-pay"},[n("v-uni-view",{staticClass:"money bg-white"},[n("v-uni-text",{staticClass:"title"},[e._v("儲值金額")]),n("v-uni-view",{staticClass:"margin-top price"},[n("v-uni-view",{staticClass:"symbol"},[n("v-uni-text",[e._v("NT$")])],1),n("v-uni-view",{staticClass:"symbol"},[n("v-uni-text",[e._v(e._s(e.money))])],1)],1)],1),n("v-uni-view",{staticClass:"list-box"},e._l(e.payList,(function(t,a){return n("v-uni-view",{key:a,staticClass:"item"},[n("v-uni-view",{staticClass:"action"},[n("v-uni-text",{staticClass:"title wanl-pip"},[e._v(e._s(t.name))]),n("v-uni-view",[e._v(e._s(t.describe))])],1),t.state?n("v-uni-view",{staticClass:"radio text-xxl",on:{click:function(t){arguments[0]=t=e.$handleEvent(t),e.onSelect(a)}}},[t.select?n("v-uni-text",{staticClass:"wlIcon-xuanze-danxuan wanl-orange"}):n("v-uni-text",{staticClass:"wlIcon-xuanze wanl-gray-light"})],1):n("v-uni-view",{staticClass:"radio text-xxl"},[n("v-uni-text",{staticClass:"wlIcon-xuanze-danxuan wanl-gray-light"})],1)],1)})),1),n("v-uni-button",{staticClass:"mix-btn wanl-bg-redorange",attrs:{loading:e.loading},on:{click:function(t){arguments[0]=t=e.$handleEvent(t),e.confirm()}}},[e._v("儲值")]),n("v-uni-view",{staticClass:"list-box",staticStyle:{color:"red"}},[n("p",[e._v("溫馨提示：")]),n("p",[e._v("1、完成儲值後，2h內到達帳戶餘額")]),n("p",[e._v("2、下午21:00之後儲值的系統有可能延遲至第二天上午09:00後到達帳戶餘額")]),n("p",[e._v("3、有任何問題，請及時咨詢在線客服小蜜")])]),n("v-uni-view",{staticClass:"footer text-center"},[n("v-uni-view",[e._v("© shopptw支付")])],1)],1)],1)},s=[]},b8eb:function(e,t,n){"use strict";(function(e){var a=n("4ea4");n("d81d"),Object.defineProperty(t,"__esModule",{value:!0}),t.default=void 0,n("96cf");var i=a(n("1da1")),s={data:function(){return{loading:!1,disabled:!1,money:null,payList:[]}},onLoad:function(t){e.log(t.money),this.money=t.money;var n="wap";this.payList.push({name:"銀行帳號",describe:"推荐使用銀行帳號",Pay_zg:"2",method:n,state:!0,select:!0},{name:"超商繳費",describe:"",Pay_zg:"4",method:n,state:!0,select:!1})},methods:{confirm:function(){var e=null;this.disabled||(this.money<=0?this.$wanlshop.msg("請輸入儲值金額"):(this.payList.map((function(t,n,a){t.select&&(e=t)})),e={name:"台湾支付",describe:"",Pay_zg:e.Pay_zg,type:"twpay",method:"wap",state:!0,select:!1},e?(this.loading=!0,this.disabled=!0,this.wanlPay(e)):this.$wanlshop.msg("請選擇支付方式")))},wanlPay:function(t){var n=arguments,a=this;return(0,i.default)(regeneratorRuntime.mark((function i(){var s;return regeneratorRuntime.wrap((function(i){while(1)switch(i.prev=i.next){case 0:s=n.length>1&&void 0!==n[1]?n[1]:null,a.$api.post({url:"/wanlshop/pay/recharge",data:{type:t.type,method:t.method,code:s,money:a.money,Pay_zg:t.Pay_zg},success:function(n){if("twpay"==t.type&&"wap"==t.method&&(window.location.href=n,a.loading=!1),"wechat"==t.type&&"wap"==t.method&&(a.loading=!1,uni.showModal({title:"微信支付",content:"是否已完成支付",success:function(t){t.confirm?a.paySuccess():t.cancel&&e.log("用戶点击取消")}}),window.location.href=n),"wechat"==t.type&&"miniapp"==t.method&&uni.requestPayment({appId:n.appId,nonceStr:n.nonceStr,package:n.package,paySign:n.paySign,signType:n.signType,timeStamp:n.timeStamp,success:function(e){a.paySuccess()},fail:function(e){uni.showModal({content:"支付失败,原因為: "+e.errMsg,showCancel:!1})},complete:function(){a.loading=!1,a.disabled=!1}}),"alipay"==t.type&&"wap"==t.method&&(a.loading=!1,document.write(n)),("alipay"==t.type||"wechat"==t.type)&&"app"==t.method){var i=t.type;"wechat"==t.type&&(i="wxpay"),uni.requestPayment({provider:i,orderInfo:n,success:function(t){e.log("success",t),a.paySuccess()},fail:function(e){uni.showModal({content:"支付失败,原因為: "+e.errMsg,showCancel:!1})},complete:function(){a.loading=!1,a.disabled=!1}})}}});case 2:case"end":return i.stop()}}),i)})))()},onSelect:function(e){this.payList.map((function(t,n,a){t.select=n==e&&!t.select}))},emptyInput:function(){this.money=null},paySuccess:function(){this.loading=!1,this.$store.commit("user/setUserInfo",{money:this.$wanlshop.bcadd(this.$store.state.user.money,this.money)}),this.$wanlshop.to("/pages/page/success?type=recharge")}}};t.default=s}).call(this,n("5a52")["default"])},c234:function(e,t,n){"use strict";var a=n("63dc"),i=n.n(a);i.a},c553:function(e,t,n){"use strict";n.r(t);var a=n("77fa"),i=n("612f");for(var s in i)"default"!==s&&function(e){n.d(t,e,(function(){return i[e]}))}(s);n("c234");var o,c=n("f0c5"),l=Object(c["a"])(i["default"],a["b"],a["c"],!1,null,"7e2b3ee0",null,!1,a["a"],o);t["default"]=l.exports},da2d:function(e,t,n){var a=n("24fb");t=a(!1),t.push([e.i,"uni-radio-group[data-v-7e2b3ee0]{display:block}.wanl-pay .money[data-v-7e2b3ee0]{padding:%?25?% %?40?% %?25?% %?60?%}.wanl-pay .money .symbol[data-v-7e2b3ee0]{font-size:%?60?%;margin-right:%?20?%}.wanl-pay .money .price[data-v-7e2b3ee0]{display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-align:center;-webkit-align-items:center;align-items:center}.wanl-pay .money .price uni-input[data-v-7e2b3ee0]{\n\nwidth:100%;font-size:%?100?%}",""]),e.exports=t}}]);