(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["pages-page-success"],{"032f":function(t,n,e){"use strict";e.r(n);var i=e("0c20"),a=e("424d");for(var s in a)"default"!==s&&function(t){e.d(n,t,(function(){return a[t]}))}(s);e("e4c4");var c,o=e("f0c5"),l=Object(o["a"])(a["default"],i["b"],i["c"],!1,null,"bfdded58",null,!1,i["a"],c);n["default"]=l.exports},"0c20":function(t,n,e){"use strict";var i;e.d(n,"b",(function(){return a})),e.d(n,"c",(function(){return s})),e.d(n,"a",(function(){return i}));var a=function(){var t=this,n=t.$createElement,e=t._self._c||n;return e("v-uni-view",{staticClass:"wanl-success"},[e("v-uni-view",{staticClass:"cu-custom",style:{height:t.wanlsys.height+"px"}},[e("v-uni-view",{staticClass:"cu-bar bg-bgcolor fixed",style:{height:t.wanlsys.height+"px",paddingTop:t.wanlsys.top+"px"}},[e("v-uni-view",{staticClass:"action",on:{click:function(n){arguments[0]=n=t.$handleEvent(n),t.onBackUser.apply(void 0,arguments)}}},[e("v-uni-text",{staticClass:"wlIcon-fanhui1"})],1),e("v-uni-view",{staticClass:"content",style:{top:t.wanlsys.top+"px"}},[e("v-uni-text",[t._v(t._s(t.title)+"完成")])],1)],1)],1),e("v-uni-view",{staticClass:"content"},[e("v-uni-text",{staticClass:"icon wlIcon-pintuantuangouchenggong"}),e("v-uni-text",{staticClass:"text-lg margin-tb"},[t._v(t._s(t.title)+"已成功")]),e("v-uni-view",{staticClass:"button padding-xl margin-top-lg"},["comment"==t.type?e("v-uni-button",{staticClass:"cu-btn block wanl-bg-orange margin-tb-sm lg",on:{click:function(n){arguments[0]=n=t.$handleEvent(n),t.$wanlshop.to("/pages/user/comment/comment")}}},[t._v("查看評論")]):t._e(),"pay"==t.type?e("v-uni-button",{staticClass:"cu-btn block wanl-bg-orange margin-tb-sm lg",on:{click:function(n){arguments[0]=n=t.$handleEvent(n),t.$wanlshop.to("/pages/user/order/order")}}},[t._v("查看訂單")]):t._e(),"feedback"==t.type?e("v-uni-button",{staticClass:"cu-btn block wanl-bg-orange margin-tb-sm lg",on:{click:function(n){arguments[0]=n=t.$handleEvent(n),t.$wanlshop.to("/pages/user/feedback/lists")}}},[t._v("查看反饋")]):t._e(),"complaint"==t.type?e("v-uni-button",{staticClass:"cu-btn block wanl-bg-orange margin-tb-sm lg",on:{click:function(n){arguments[0]=n=t.$handleEvent(n),t.$wanlshop.to("/pages/user/complaint/lists")}}},[t._v("查看舉報")]):t._e(),"withdraw"==t.type?e("v-uni-button",{staticClass:"cu-btn block wanl-bg-orange margin-tb-sm lg",on:{click:function(n){arguments[0]=n=t.$handleEvent(n),t.$wanlshop.to("/pages/user/money/witlist")}}},[t._v("查看提現列表")]):t._e(),"recharge"==t.type?e("v-uni-button",{staticClass:"cu-btn block wanl-bg-orange margin-tb-sm lg",on:{click:function(n){arguments[0]=n=t.$handleEvent(n),t.$wanlshop.to("/pages/user/money/money")}}},[t._v("查看錢包")]):t._e(),e("v-uni-button",{staticClass:"cu-btn block line-gray margin-tb-sm lg",on:{click:function(n){arguments[0]=n=t.$handleEvent(n),t.onIndex.apply(void 0,arguments)}}},[t._v("返回首頁")])],1)],1)],1)},s=[]},"424d":function(t,n,e){"use strict";e.r(n);var i=e("790a"),a=e.n(i);for(var s in i)"default"!==s&&function(t){e.d(n,t,(function(){return i[t]}))}(s);n["default"]=a.a},4948:function(t,n,e){var i=e("9c2a");"string"===typeof i&&(i=[[t.i,i,""]]),i.locals&&(t.exports=i.locals);var a=e("4f06").default;a("fe9ec5cc",i,!0,{sourceMap:!1,shadowMode:!1})},"790a":function(t,n,e){"use strict";Object.defineProperty(n,"__esModule",{value:!0}),n.default=void 0;var i={data:function(){return{wanlsys:this.$wanlshop.wanlsys(),type:"",title:""}},onLoad:function(t){"pay"==t.type?this.title="支付":"comment"==t.type?this.title="評論":"feedback"==t.type?this.title="反饋":"withdraw"==t.type?this.title="請等待后台审核，提交":"recharge"==t.type?this.title="充值":"complaint"==t.type&&(this.title="舉報"),this.type=t.type},methods:{onIndex:function(){uni.switchTab({url:"/pages/twshop/index"})},onBackUser:function(){uni.switchTab({url:"/pages/user/user"})}}};n.default=i},"9c2a":function(t,n,e){var i=e("24fb");n=i(!1),n.push([t.i,".wanl-success .content[data-v-bfdded58]{display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-orient:vertical;-webkit-box-direction:normal;-webkit-flex-direction:column;flex-direction:column;-webkit-box-pack:center;-webkit-justify-content:center;justify-content:center;-webkit-box-align:center;-webkit-align-items:center;align-items:center}.wanl-success .content .icon[data-v-bfdded58]{font-size:%?180?%;color:#3aa112;margin-top:%?150?%}.wanl-success .content .button[data-v-bfdded58]{width:100%}",""]),t.exports=n},e4c4:function(t,n,e){"use strict";var i=e("4948"),a=e.n(i);a.a}}]);