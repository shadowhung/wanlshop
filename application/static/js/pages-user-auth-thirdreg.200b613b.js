(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["pages-user-auth-thirdreg"],{"5fc3":function(e,t,i){var a=i("ee02");"string"===typeof a&&(a=[[e.i,a,""]]),a.locals&&(e.exports=a.locals);var n=i("4f06").default;n("cff8219e",a,!0,{sourceMap:!1,shadowMode:!1})},a742:function(e,t,i){"use strict";var a=i("5fc3"),n=i.n(a);n.a},b17d:function(e,t,i){"use strict";i.r(t);var a=i("ed57"),n=i.n(a);for(var r in a)"default"!==r&&function(e){i.d(t,e,(function(){return a[e]}))}(r);t["default"]=n.a},c319:function(e,t,i){i("c975"),i("a9e3"),i("4d63"),i("ac1f"),i("25f0"),i("1276"),e.exports={error:"",check:function(e,t){for(var i=0;i<t.length;i++){if(!t[i].checkType)return!0;if(!t[i].name)return!0;if(!t[i].errorMsg)return!0;if(!e[t[i].name])return this.error=t[i].errorMsg,!1;switch(t[i].checkType){case"string":var a=new RegExp("^.{"+t[i].checkRule+"}$");if(!a.test(e[t[i].name]))return this.error=t[i].errorMsg,!1;break;case"int":a=new RegExp("^(-[1-9]|[1-9])[0-9]{"+t[i].checkRule+"}$");if(!a.test(e[t[i].name]))return this.error=t[i].errorMsg,!1;break;case"between":if(!this.isNumber(e[t[i].name]))return this.error=t[i].errorMsg,!1;var n=t[i].checkRule.split(",");if(n[0]=Number(n[0]),n[1]=Number(n[1]),e[t[i].name]>n[1]||e[t[i].name]<n[0])return this.error=t[i].errorMsg,!1;break;case"betweenD":a=/^-?[1-9][0-9]?$/;if(!a.test(e[t[i].name]))return this.error=t[i].errorMsg,!1;n=t[i].checkRule.split(",");if(n[0]=Number(n[0]),n[1]=Number(n[1]),e[t[i].name]>n[1]||e[t[i].name]<n[0])return this.error=t[i].errorMsg,!1;break;case"betweenF":a=/^-?[0-9][0-9]?.+[0-9]+$/;if(!a.test(e[t[i].name]))return this.error=t[i].errorMsg,!1;n=t[i].checkRule.split(",");if(n[0]=Number(n[0]),n[1]=Number(n[1]),e[t[i].name]>n[1]||e[t[i].name]<n[0])return this.error=t[i].errorMsg,!1;break;case"same":if(e[t[i].name]!=t[i].checkRule)return this.error=t[i].errorMsg,!1;break;case"notsame":if(e[t[i].name]==t[i].checkRule)return this.error=t[i].errorMsg,!1;break;case"email":a=/^\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/;if(!a.test(e[t[i].name]))return this.error=t[i].errorMsg,!1;break;case"phoneno":a=/^[0-9]{8,15}$/;if(!a.test(e[t[i].name]))return this.error=t[i].errorMsg,!1;break;case"zipcode":a=/^[0-9]{6}$/;if(!a.test(e[t[i].name]))return this.error=t[i].errorMsg,!1;break;case"reg":a=new RegExp(t[i].checkRule);if(!a.test(e[t[i].name]))return this.error=t[i].errorMsg,!1;break;case"in":if(-1==t[i].checkRule.indexOf(e[t[i].name]))return this.error=t[i].errorMsg,!1;break;case"notnull":if(null==e[t[i].name]||e[t[i].name].length<1)return this.error=t[i].errorMsg,!1;break}}return!0},isNumber:function(e){var t=/^-?[1-9][0-9]?.?[0-9]*$/;return t.test(e)}}},c67b:function(e,t,i){"use strict";var a;i.d(t,"b",(function(){return n})),i.d(t,"c",(function(){return r})),i.d(t,"a",(function(){return a}));var n=function(){var e=this,t=e.$createElement,i=e._self._c||t;return i("v-uni-view",[i("v-uni-view",{staticClass:"auth"},[i("v-uni-view",{staticClass:"wanl-title"},[i("v-uni-view",[e._v(e._s(e.userInfo.nickName)+"，您好")]),i("v-uni-view",{staticClass:"titleInfo"},[e._v("請綁定一個行動電話號碼...")])],1),i("v-uni-form",{on:{submit:function(t){arguments[0]=t=e.$handleEvent(t),e.formSubmit.apply(void 0,arguments)}}},[i("v-uni-view",{staticClass:"auth-group radius-bock bg-gray wlian-grey-light"},[i("v-uni-input",{attrs:{placeholder:"請輸入行動電話號碼",type:"number",maxlength:"11","confirm-type":"next","placeholder-class":"placeholder",name:"mobile"},on:{input:function(t){arguments[0]=t=e.$handleEvent(t),e.onKeyInput.apply(void 0,arguments)}}})],1),i("v-uni-view",{staticClass:"auth-button flex flex-direction"},[i("v-uni-button",{staticClass:"cu-btn bg-orange sl radius-bock",attrs:{"form-type":"submit",disabled:e.submitDisabled}},[e._v("獲取驗證碼")])],1)],1)],1),i("v-uni-view",{staticClass:"auth-foot"},[i("v-uni-view",{staticClass:"menu text-grey"},[i("v-uni-text",{on:{click:function(t){arguments[0]=t=e.$handleEvent(t),e.register.apply(void 0,arguments)}}},[e._v("註冊")]),i("v-uni-text",{on:{click:function(t){arguments[0]=t=e.$handleEvent(t),e.help.apply(void 0,arguments)}}},[e._v("幫助")])],1)],1)],1)},r=[]},cb48:function(e,t,i){"use strict";i.r(t);var a=i("c67b"),n=i("b17d");for(var r in n)"default"!==r&&function(e){i.d(t,e,(function(){return n[e]}))}(r);i("a742");var o,c=i("f0c5"),s=Object(c["a"])(n["default"],a["b"],a["c"],!1,null,"57056ccf",null,!1,a["a"],o);t["default"]=s.exports},ed57:function(e,t,i){"use strict";var a=i("4ea4");i("99af"),Object.defineProperty(t,"__esModule",{value:!0}),t.default=void 0;var n=a(i("c319")),r={data:function(){return{userInfo:[],submitDisabled:!0,pageroute:""}},onLoad:function(e){this.userInfo=e,this.pageroute=e.url},methods:{onKeyInput:function(e){this.submitDisabled=!1},formSubmit:function(e){var t=[{name:"mobile",checkType:"phoneno",errorMsg:"請輸入正確的行動電話號碼"}],i=e.detail.value,a=n.default.check(i,t);a?this.$wanlshop.to("validcode?event=binding&mobile=".concat(e.detail.value.mobile,"&url=").concat(this.pageroute)):this.$wanlshop.msg(n.default.error)},register:function(){this.$wanlshop.to("register?url=".concat(this.pageroute))},help:function(){this.$wanlshop.to("/pages/user/help?url=".concat(this.pageroute))}}};t.default=r},ee02:function(e,t,i){var a=i("24fb");t=a(!1),t.push([e.i,"uni-page-body[data-v-57056ccf]{background-color:#fff}.wanl-title[data-v-57056ccf]{padding-bottom:%?130?%;padding-top:%?170?%;font-size:%?68?%}.wanl-title .titleInfo[data-v-57056ccf]{font-size:%?56?%}.wanl-weixin-btn-info[data-v-57056ccf]{color:#b8b8b8!important}.auth[data-v-57056ccf]{margin:0 %?60?%}.auth-group[data-v-57056ccf]{padding:%?1?% %?30?%;display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-align:center;-webkit-align-items:center;align-items:center;min-height:%?90?%;-webkit-box-pack:justify;-webkit-justify-content:space-between;justify-content:space-between;margin-bottom:%?25?%}.auth-group uni-input[data-v-57056ccf]{-webkit-box-flex:1;-webkit-flex:1;flex:1;font-size:%?33?%;color:#250f00;padding-right:%?20?%}.auth-group .placeholder[data-v-57056ccf]{color:#b3b3b3}.auth-button[data-v-57056ccf]{padding:%?25?% 0 %?50?% 0}.auth-button .cu-btn[data-v-57056ccf]{height:%?90?%}.text-center[data-v-57056ccf]{color:#3f2f21\n}.auth-clause[data-v-57056ccf]{font-size:%?25?%;color:#909090}.auth-clause uni-text[data-v-57056ccf]{margin:0 %?10?%;color:#ed6d0f}.auth-foot[data-v-57056ccf]{position:fixed;width:100%;bottom:0;z-index:1024;padding:0 %?60?%;padding-bottom:calc(env(safe-area-inset-bottom) / 2)}.auth-foot .oauth[data-v-57056ccf]{display:-webkit-box;display:-webkit-flex;display:flex;-webkit-flex-wrap:wrap;flex-wrap:wrap;-webkit-box-align:center;-webkit-align-items:center;align-items:center;min-height:%?160?%;-webkit-justify-content:space-around;justify-content:space-around}.auth-foot .oauth uni-view[data-v-57056ccf]{border:%?2?% solid #fcf7e9}.auth-foot .menu[data-v-57056ccf]{display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-align:center;-webkit-align-items:center;align-items:center;-webkit-box-pack:center;-webkit-justify-content:center;justify-content:center;margin-bottom:%?100?%;color:#3f2f21;line-height:%?28?%;font-size:%?28?%}.auth-foot uni-text[data-v-57056ccf]{width:%?180?%;text-align:center}.auth-foot uni-text[data-v-57056ccf]:nth-child(2){border-left:1px solid #ececec}\r\n\r\n/* 驗證碼 */.auth-title[data-v-57056ccf]{padding-bottom:%?30?%;padding-top:%?170?%;font-size:%?60?%}.auth-mobile[data-v-57056ccf]{color:#9a9a9a;padding-bottom:%?80?%}.auth-mobile uni-text[data-v-57056ccf]{margin-left:%?10?%}.codes[data-v-57056ccf]{display:-webkit-box;display:-webkit-flex;display:flex;-webkit-justify-content:space-around;justify-content:space-around;-webkit-box-orient:horizontal;-webkit-box-direction:normal;-webkit-flex-direction:row;flex-direction:row}.codes uni-input[data-v-57056ccf]{background:#fff;border-bottom:1px solid #c3c3c3;width:%?90?%;height:%?90?%;text-align:center}.codes .input[data-v-57056ccf]{display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-pack:center;-webkit-justify-content:center;justify-content:center;-webkit-box-align:center;-webkit-align-items:center;align-items:center;background:#fff;border-bottom:1px solid #c3c3c3;width:%?90?%;height:%?90?%;font-size:%?40?%;font-weight:500;color:#333}.codes .input .shining[data-v-57056ccf]{border:1px solid #ed6d0f;height:%?50?%;animation:shining-data-v-57056ccf 1s linear infinite;\r\n\t/* 其它瀏覽器兼容性前缀 */-webkit-animation:shining-data-v-57056ccf 1s linear infinite;-moz-animation:shining-data-v-57056ccf 1s linear infinite;-ms-animation:shining-data-v-57056ccf 1s linear infinite;-o-animation:shining-data-v-57056ccf 1s linear infinite}.codes .active[data-v-57056ccf]{border-bottom:1px solid #ed6d0f;caret-color:#ed6d0f}.oneline-codes uni-input[data-v-57056ccf]{text-align:center}.auth-again[data-v-57056ccf]{padding-top:%?50?%}.auth-again uni-text[data-v-57056ccf]{color:#ed6d0f;margin-right:%?40?%}.auth-again .time[data-v-57056ccf]{color:#9a9a9a}@-webkit-keyframes shining-data-v-57056ccf{0%{opacity:1}50%{opacity:1}50.01%{opacity:0}100%{opacity:0}}.wlIcon-QQ[data-v-57056ccf]{color:#12b8f6}.wlIcon-WeChat[data-v-57056ccf]{color:#02dc6b}.wlIcon-WeiBo[data-v-57056ccf]{color:#d32820}.wlIcon-Xiaomi[data-v-57056ccf]{color:#ff6b00}body.?%PAGE?%[data-v-57056ccf]{background-color:#fff}",""]),e.exports=t}}]);