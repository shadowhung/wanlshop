(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["pages-user-bank-add"],{"434d":function(a,e,n){var t=n("24fb");e=t(!1),e.push([a.i,".picker .flex uni-image[data-v-64315371]{width:%?40?%;height:%?40?%}",""]),a.exports=e},"50c47":function(a,e,n){"use strict";n.r(e);var t=n("e6c0"),i=n("b0df");for(var s in i)"default"!==s&&function(a){n.d(e,a,(function(){return i[a]}))}(s);n("9f2e");var o,u=n("f0c5"),l=Object(u["a"])(i["default"],t["b"],t["c"],!1,null,"64315371",null,!1,t["a"],o);e["default"]=l.exports},"679d":function(a,e,n){var t=n("434d");"string"===typeof t&&(t=[[a.i,t,""]]),t.locals&&(a.exports=t.locals);var i=n("4f06").default;i("7641e2b8",t,!0,{sourceMap:!1,shadowMode:!1})},"9f2e":function(a,e,n){"use strict";var t=n("679d"),i=n.n(t);i.a},b0df:function(a,e,n){"use strict";n.r(e);var t=n("d94d"),i=n.n(t);for(var s in t)"default"!==s&&function(a){n.d(e,a,(function(){return t[a]}))}(s);e["default"]=i.a},d94d:function(a,e,n){"use strict";Object.defineProperty(e,"__esModule",{value:!0}),e.default=void 0;var t={data:function(){return{bankData:{username:"",mobile:"",bankCode:"",bankName:"",cardCode:""},index:-1,bankList:[{bankCode:"ALIPAY",bankName:"支付宝帳戶"},{bankCode:"WECHAT",bankName:"微信帳戶"},{bankCode:"ICBC",bankName:"工商銀行"},{bankCode:"ABC",bankName:"農业銀行"},{bankCode:"PSBC",bankName:"邮储銀行"},{bankCode:"CCB",bankName:"建設銀行"},{bankCode:"CMB",bankName:"招商銀行"},{bankCode:"BOC",bankName:"中国銀行"},{bankCode:"COMM",bankName:"交通銀行"},{bankCode:"SPDB",bankName:"浦發銀行"},{bankCode:"GDB",bankName:"广發銀行"},{bankCode:"CMBC",bankName:"民生銀行"},{bankCode:"PAB",bankName:"平安銀行"},{bankCode:"CEB",bankName:"光大銀行"},{bankCode:"CIB",bankName:"兴业銀行"},{bankCode:"CITIC",bankName:"中信銀行"}]}},methods:{confirm:function(){var a=this.bankData;if(a.bankCode)if(a.cardCode)if(a.username){var e=/^[1][3,4,5,7,8,9][0-9]{9}$/;a.mobile&&e.test(a.mobile)?(this.$wanlshop.prePage().refreshList(a),this.$wanlshop.back(1)):this.$wanlshop.msg("請填写正确手机号")}else this.$wanlshop.msg("請填写真实姓名");else this.$wanlshop.msg("請选择帳号");else this.$wanlshop.msg("請选择銀行卡")},bankChange:function(a){this.index=a.detail.value,this.bankData.bankCode=this.bankList[a.detail.value].bankCode,this.bankData.bankName=this.bankList[a.detail.value].bankName}}};e.default=t},e6c0:function(a,e,n){"use strict";var t;n.d(e,"b",(function(){return i})),n.d(e,"c",(function(){return s})),n.d(e,"a",(function(){return t}));var i=function(){var a=this,e=a.$createElement,n=a._self._c||e;return n("v-uni-view",[n("v-uni-view",{staticClass:"edgeInsetTop"}),n("v-uni-view",{staticClass:"cu-form-group"},[n("v-uni-view",{staticClass:"title"},[a._v("选择銀行")]),n("v-uni-picker",{attrs:{value:a.index,range:a.bankList,"range-key":"bankName"},on:{change:function(e){arguments[0]=e=a.$handleEvent(e),a.bankChange.apply(void 0,arguments)}}},[n("v-uni-view",{staticClass:"picker"},[a.index>-1?n("v-uni-view",{staticClass:"flex justify-end align-center"},[n("v-uni-image",{attrs:{src:"/static/images/bank/"+a.bankList[a.index].bankCode+".png"}}),n("v-uni-view",{staticClass:"margin-left-xs"},[a._v(a._s(a.bankList[a.index].bankName))])],1):n("v-uni-view",[a._v("請选择")])],1)],1)],1),n("v-uni-view",{staticClass:"cu-form-group"},[n("v-uni-view",{staticClass:"title"},[a._v("銀行帳号")]),n("v-uni-input",{attrs:{type:"text",placeholder:"填写銀行卡 / 支付宝微信帳号"},model:{value:a.bankData.cardCode,callback:function(e){a.$set(a.bankData,"cardCode",e)},expression:"bankData.cardCode"}})],1),n("v-uni-view",{staticClass:"cu-form-group"},[n("v-uni-view",{staticClass:"title"},[a._v("持卡姓名")]),n("v-uni-input",{attrs:{type:"text",maxlength:"4",placeholder:"持帳戶人姓名"},model:{value:a.bankData.username,callback:function(e){a.$set(a.bankData,"username",e)},expression:"bankData.username"}})],1),n("v-uni-view",{staticClass:"cu-form-group"},[n("v-uni-view",{staticClass:"title"},[a._v("手机号碼")]),n("v-uni-input",{attrs:{type:"number",maxlength:"11",placeholder:"持帳戶人手机号"},model:{value:a.bankData.mobile,callback:function(e){a.$set(a.bankData,"mobile",e)},expression:"bankData.mobile"}})],1),n("v-uni-view",{staticClass:"padding-bj flex flex-direction margin-top"},[n("v-uni-button",{staticClass:"cu-btn wanl-bg-orange lg",on:{click:function(e){arguments[0]=e=a.$handleEvent(e),a.confirm.apply(void 0,arguments)}}},[a._v("完成")])],1)],1)},s=[]}}]);