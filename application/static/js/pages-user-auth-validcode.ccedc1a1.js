(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["pages-user-auth-validcode"],{"1a49":function(e,t,i){"use strict";i("99af"),i("a15b"),i("a434"),Object.defineProperty(t,"__esModule",{value:!0}),t.default=void 0;var n={data:function(){return{config:{count:[{index:1,key:"valid-code-input-1"},{index:2,key:"valid-code-input-2"},{index:3,key:"valid-code-input-3"},{index:4,key:"valid-code-input-4"},{index:5,key:"valid-code-input-5"},{index:6,key:"valid-code-input-6"}]},keyboardVisible:!0,currentFocus:1,mobile:"",code:[],style:{inputWidth:"40upx",inputHeight:"100upx"},countdown:60,cTimer:null,event:"",pageroute:""}},onLoad:function(e){this.mobile=e.mobile,this.event=e.event,this.pageroute=e.url,this.sendMessage(),this.startTimer()},methods:{inputCode:function(e){this.code[this.currentFocus-1]=e,6==this.currentFocus&&this.login(),this.currentFocus<=6&&this.currentFocus++},login:function(){var e=this;uni.showLoading(),"resetpwd"==this.event&&(this.$wanlshop.to("resetpwd?mobile=".concat(this.mobile,"&captcha=").concat(this.code.join(""),"&url=").concat(this.pageroute)),uni.hideLoading()),this.event,"mobilelogin"==this.event&&this.$api.post({url:"/wanlshop/user/mobilelogin",data:{mobile:this.mobile,captcha:this.code.join(""),client_id:uni.getStorageSync("wanlshop:chat_client_id")?uni.getStorageSync("wanlshop:chat_client_id"):null},success:function(t){uni.hideLoading(),e.$store.dispatch("user/login",t),e.$store.dispatch("cart/login"),uni.reLaunch({url:decodeURIComponent(e.pageroute)})}}),"register"==this.event&&this.$api.post({url:"/wanlshop/user/register",data:{mobile:this.mobile,captcha:this.code.join(""),client_id:uni.getStorageSync("wanlshop:chat_client_id")?uni.getStorageSync("wanlshop:chat_client_id"):null},success:function(t){uni.hideLoading(),e.$store.dispatch("user/login",t),e.$store.dispatch("cart/login"),e.$store.dispatch("chat/get"),uni.reLaunch({url:decodeURIComponent(e.pageroute)})}}),this.currentFocus=0,this.code=[]},deleteCode:function(){this.currentFocus--,this.code.splice(-1,1)},emptyCode:function(){this.code=[],this.currentFocus=0},hanldeOpenKeyboard:function(){this.keyboardVisible=!0},sendMessage:function(){var e=this;this.$api.get({url:"/wanlshop/sms/send",data:{event:this.event,mobile:this.mobile},loadingTip:"驗證碼發送中...",success:function(t){e.$wanlshop.msg("驗證碼發送成功")}})},startTimer:function(){var e=this;null==this.cTimer&&(this.cTimer=setInterval((function(){e.countdown--,0==e.countdown&&e.clearTimer()}),1e3))},clearTimer:function(){clearInterval(this.cTimer),this.cTimer=null},resend:function(){this.startTimer(),this.code=[],this.currentFocus=0,this.countdown=60,this.sendMessage()}}};t.default=n},"2aed":function(e,t,i){"use strict";i.r(t);var n=i("9af4"),a=i("c848");for(var o in a)"default"!==o&&function(e){i.d(t,e,(function(){return a[e]}))}(o);i("99f5");var c,r=i("f0c5"),d=Object(r["a"])(a["default"],n["b"],n["c"],!1,null,"250d67d8",null,!1,n["a"],c);t["default"]=d.exports},"2f1a":function(e,t,i){var n=i("3812");"string"===typeof n&&(n=[[e.i,n,""]]),n.locals&&(e.exports=n.locals);var a=i("4f06").default;a("001fa319",n,!0,{sourceMap:!1,shadowMode:!1})},"33c5":function(e,t,i){var n=i("24fb");t=n(!1),t.push([e.i,"uni-page-body[data-v-790e579f]{background-color:#fff}.wanl-title[data-v-790e579f]{padding-bottom:%?130?%;padding-top:%?170?%;font-size:%?68?%}.wanl-title .titleInfo[data-v-790e579f]{font-size:%?56?%}.wanl-weixin-btn-info[data-v-790e579f]{color:#b8b8b8!important}.auth[data-v-790e579f]{margin:0 %?60?%}.auth-group[data-v-790e579f]{padding:%?1?% %?30?%;display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-align:center;-webkit-align-items:center;align-items:center;min-height:%?90?%;-webkit-box-pack:justify;-webkit-justify-content:space-between;justify-content:space-between;margin-bottom:%?25?%}.auth-group uni-input[data-v-790e579f]{-webkit-box-flex:1;-webkit-flex:1;flex:1;font-size:%?33?%;color:#250f00;padding-right:%?20?%}.auth-group .placeholder[data-v-790e579f]{color:#b3b3b3}.auth-button[data-v-790e579f]{padding:%?25?% 0 %?50?% 0}.auth-button .cu-btn[data-v-790e579f]{height:%?90?%}.text-center[data-v-790e579f]{color:#3f2f21\n}.auth-clause[data-v-790e579f]{font-size:%?25?%;color:#909090}.auth-clause uni-text[data-v-790e579f]{margin:0 %?10?%;color:#ed6d0f}.auth-foot[data-v-790e579f]{position:fixed;width:100%;bottom:0;z-index:1024;padding:0 %?60?%;padding-bottom:calc(env(safe-area-inset-bottom) / 2)}.auth-foot .oauth[data-v-790e579f]{display:-webkit-box;display:-webkit-flex;display:flex;-webkit-flex-wrap:wrap;flex-wrap:wrap;-webkit-box-align:center;-webkit-align-items:center;align-items:center;min-height:%?160?%;-webkit-justify-content:space-around;justify-content:space-around}.auth-foot .oauth uni-view[data-v-790e579f]{border:%?2?% solid #fcf7e9}.auth-foot .menu[data-v-790e579f]{display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-align:center;-webkit-align-items:center;align-items:center;-webkit-box-pack:center;-webkit-justify-content:center;justify-content:center;margin-bottom:%?100?%;color:#3f2f21;line-height:%?28?%;font-size:%?28?%}.auth-foot uni-text[data-v-790e579f]{width:%?180?%;text-align:center}.auth-foot uni-text[data-v-790e579f]:nth-child(2){border-left:1px solid #ececec}\r\n\r\n/* 驗證碼 */.auth-title[data-v-790e579f]{padding-bottom:%?30?%;padding-top:%?170?%;font-size:%?60?%}.auth-mobile[data-v-790e579f]{color:#9a9a9a;padding-bottom:%?80?%}.auth-mobile uni-text[data-v-790e579f]{margin-left:%?10?%}.codes[data-v-790e579f]{display:-webkit-box;display:-webkit-flex;display:flex;-webkit-justify-content:space-around;justify-content:space-around;-webkit-box-orient:horizontal;-webkit-box-direction:normal;-webkit-flex-direction:row;flex-direction:row}.codes uni-input[data-v-790e579f]{background:#fff;border-bottom:1px solid #c3c3c3;width:%?90?%;height:%?90?%;text-align:center}.codes .input[data-v-790e579f]{display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-pack:center;-webkit-justify-content:center;justify-content:center;-webkit-box-align:center;-webkit-align-items:center;align-items:center;background:#fff;border-bottom:1px solid #c3c3c3;width:%?90?%;height:%?90?%;font-size:%?40?%;font-weight:500;color:#333}.codes .input .shining[data-v-790e579f]{border:1px solid #ed6d0f;height:%?50?%;animation:shining-data-v-790e579f 1s linear infinite;\r\n\t/* 其它瀏覽器兼容性前缀 */-webkit-animation:shining-data-v-790e579f 1s linear infinite;-moz-animation:shining-data-v-790e579f 1s linear infinite;-ms-animation:shining-data-v-790e579f 1s linear infinite;-o-animation:shining-data-v-790e579f 1s linear infinite}.codes .active[data-v-790e579f]{border-bottom:1px solid #ed6d0f;caret-color:#ed6d0f}.oneline-codes uni-input[data-v-790e579f]{text-align:center}.auth-again[data-v-790e579f]{padding-top:%?50?%}.auth-again uni-text[data-v-790e579f]{color:#ed6d0f;margin-right:%?40?%}.auth-again .time[data-v-790e579f]{color:#9a9a9a}@-webkit-keyframes shining-data-v-790e579f{0%{opacity:1}50%{opacity:1}50.01%{opacity:0}100%{opacity:0}}.wlIcon-QQ[data-v-790e579f]{color:#12b8f6}.wlIcon-WeChat[data-v-790e579f]{color:#02dc6b}.wlIcon-WeiBo[data-v-790e579f]{color:#d32820}.wlIcon-Xiaomi[data-v-790e579f]{color:#ff6b00}body.?%PAGE?%[data-v-790e579f]{background-color:#fff}",""]),e.exports=t},3812:function(e,t,i){var n=i("24fb");t=n(!1),t.push([e.i,".numberkeyboard[data-v-250d67d8]{position:fixed;width:100%;bottom:0}.numberkeyboard .title[data-v-250d67d8]{display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-pack:center;-webkit-justify-content:center;justify-content:center;-webkit-box-align:center;-webkit-align-items:center;align-items:center;height:%?50?%;background:#f9f9f9}.numberkeyboard .keys[data-v-250d67d8]{display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-orient:horizontal;-webkit-box-direction:normal;-webkit-flex-direction:row;flex-direction:row;-webkit-flex-wrap:wrap;flex-wrap:wrap}.numberkeyboard .keys .key[data-v-250d67d8]{width:%?250?%;height:%?120?%;display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-pack:center;-webkit-justify-content:center;justify-content:center;-webkit-box-align:center;-webkit-align-items:center;align-items:center;border-right:1px solid #f5f5f5;-webkit-box-sizing:border-box;box-sizing:border-box;font-size:%?40?%}.numberkeyboard .keys .key[data-v-250d67d8]:nth-child(n + 4){border-top:1px solid #f5f5f5;-webkit-box-sizing:border-box;box-sizing:border-box}.numberkeyboard .keys .key[data-v-250d67d8]:active{background:#ddd}.iPhonex[data-v-250d67d8]{padding-bottom:calc(env(safe-area-inset-bottom) * 1.5);background-color:#f5f5f5}.keys .key[data-v-250d67d8]{background-color:#fff}",""]),e.exports=t},"52e4":function(e,t,i){var n=i("33c5");"string"===typeof n&&(n=[[e.i,n,""]]),n.locals&&(e.exports=n.locals);var a=i("4f06").default;a("0d027da4",n,!0,{sourceMap:!1,shadowMode:!1})},"52eb":function(e,t,i){"use strict";i.r(t);var n=i("1a49"),a=i.n(n);for(var o in n)"default"!==o&&function(e){i.d(t,e,(function(){return n[e]}))}(o);t["default"]=a.a},"798e":function(e,t,i){"use strict";i.r(t);var n=i("ad29"),a=i("52eb");for(var o in a)"default"!==o&&function(e){i.d(t,e,(function(){return a[e]}))}(o);i("e2b8");var c,r=i("f0c5"),d=Object(r["a"])(a["default"],n["b"],n["c"],!1,null,"790e579f",null,!1,n["a"],c);t["default"]=d.exports},"99f5":function(e,t,i){"use strict";var n=i("2f1a"),a=i.n(n);a.a},"9af4":function(e,t,i){"use strict";var n;i.d(t,"b",(function(){return a})),i.d(t,"c",(function(){return o})),i.d(t,"a",(function(){return n}));var a=function(){var e=this,t=e.$createElement,i=e._self._c||t;return i("v-uni-view",{directives:[{name:"show",rawName:"v-show",value:e.numberKeyboardPopupVisible,expression:"numberKeyboardPopupVisible"}],staticClass:"numberkeyboard",attrs:{id:"number-keyboard-component"}},[i("v-uni-view",{staticClass:"title",on:{click:function(t){arguments[0]=t=e.$handleEvent(t),e.close.apply(void 0,arguments)}}},[i("v-uni-image",{staticStyle:{width:"30upx",height:"30upx"},attrs:{src:e.$wanlshop.appstc("/common/img_down3x.png")}})],1),i("v-uni-view",{staticClass:"keys"},[e._l(e.config.loop,(function(t){return i("v-uni-view",{key:t.key,staticClass:"key button",on:{click:function(i){arguments[0]=i=e.$handleEvent(i),e.number(t.number)}}},[e._v(e._s(t.number))])})),i("v-uni-view",{staticClass:"key button",staticStyle:{background:"#f5f5f5"},on:{click:function(t){arguments[0]=t=e.$handleEvent(t),e.empty.apply(void 0,arguments)}}},[i("v-uni-image",{staticStyle:{width:"50upx",height:"50upx"},attrs:{src:e.$wanlshop.appstc("/common/img_empty3x.png")}})],1),i("v-uni-view",{staticClass:"key button",on:{click:function(t){arguments[0]=t=e.$handleEvent(t),e.number(0)}}},[e._v("0")]),i("v-uni-view",{staticClass:"key button",staticStyle:{background:"#f5f5f5"},on:{click:function(t){arguments[0]=t=e.$handleEvent(t),e.del.apply(void 0,arguments)}}},[i("v-uni-image",{staticStyle:{width:"50upx",height:"50upx"},attrs:{src:e.$wanlshop.appstc("/common/img_delete3x.png")}})],1)],2),i("v-uni-view",{staticClass:"iPhonex"})],1)},o=[]},ad29:function(e,t,i){"use strict";i.d(t,"b",(function(){return a})),i.d(t,"c",(function(){return o})),i.d(t,"a",(function(){return n}));var n={wanlKeyboard:i("2aed").default},a=function(){var e=this,t=e.$createElement,i=e._self._c||t;return i("v-uni-view",[i("v-uni-view",{staticClass:"auth"},[i("v-uni-view",{staticClass:"auth-title"},[e._v("輸入短信驗證碼")]),i("v-uni-view",{staticClass:"auth-mobile"},[e._v("短信驗證碼至"),i("v-uni-text",[e._v(e._s(e.mobile))])],1),i("v-uni-view",{staticClass:"codes"},e._l(e.config.count,(function(t){return i("v-uni-view",{key:t.key},[i("v-uni-view",{staticClass:"input",class:{active:e.currentFocus==t.index},on:{click:function(t){arguments[0]=t=e.$handleEvent(t),e.hanldeOpenKeyboard.apply(void 0,arguments)}}},[void 0!=e.code[t.index-1]?[e._v(e._s(e.code[t.index-1]))]:[e.currentFocus==t.index?i("v-uni-view",{staticClass:"shining"}):e._e()]],2)],1)})),1),i("v-uni-view",{staticClass:"auth-again"},[e.countdown>0?i("v-uni-text",{staticClass:"time"},[e._v(e._s(e.countdown)+"秒後重新發送")]):e._e(),0==e.countdown?i("v-uni-text",{on:{click:function(t){arguments[0]=t=e.$handleEvent(t),e.resend.apply(void 0,arguments)}}},[e._v("重新發送")]):e._e(),e.countdown<50?i("v-uni-text",[e._v("没有收到驗證碼？")]):e._e()],1)],1),i("wanl-keyboard",{attrs:{open:e.keyboardVisible},on:{number:function(t){arguments[0]=t=e.$handleEvent(t),e.inputCode.apply(void 0,arguments)},delete:function(t){arguments[0]=t=e.$handleEvent(t),e.deleteCode.apply(void 0,arguments)},empty:function(t){arguments[0]=t=e.$handleEvent(t),e.emptyCode.apply(void 0,arguments)},close:function(t){arguments[0]=t=e.$handleEvent(t),e.keyboardVisible=!1}}})],1)},o=[]},c848:function(e,t,i){"use strict";i.r(t);var n=i("cc21"),a=i.n(n);for(var o in n)"default"!==o&&function(e){i.d(t,e,(function(){return n[e]}))}(o);t["default"]=a.a},cc21:function(e,t,i){"use strict";(function(e){Object.defineProperty(t,"__esModule",{value:!0}),t.default=void 0;var i={name:"WanlKeyboard",props:{open:{type:Boolean,default:!1},color:{type:String,default:"#04BE02"}},data:function(){return{config:{loop:[{number:1,key:"number-1"},{number:2,key:"number-2"},{number:3,key:"number-3"},{number:4,key:"number-4"},{number:5,key:"number-5"},{number:6,key:"number-6"},{number:7,key:"number-7"},{number:8,key:"number-8"},{number:9,key:"number-9"}]},numberKeyboardPopupVisible:this.open}},watch:{numberKeyboardPopupVisible:function(e,t){0==e&&this.$emit("close")},open:function(t,i){e.log(t),this.numberKeyboardPopupVisible=t}},methods:{close:function(){this.numberKeyboardPopupVisible=!1,this.$emit("close")},del:function(){this.$emit("delete")},empty:function(){this.$emit("empty")},number:function(e){this.$emit("number",e)}}};t.default=i}).call(this,i("5a52")["default"])},e2b8:function(e,t,i){"use strict";var n=i("52e4"),a=i.n(n);a.a}}]);