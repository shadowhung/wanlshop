(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["pages-product-category-category~pages-product-goods"],{"01f5":function(n,t,e){"use strict";var a=e("b305"),i=e.n(a);i.a},"0e12":function(n,t,e){"use strict";var a=e("4ea4");e("4e82"),e("a9e3"),Object.defineProperty(t,"__esModule",{value:!0}),t.default=void 0,e("96cf");var i=a(e("1da1")),s={name:"WanlShare",props:{scrollAnimation:{type:Number,default:300},shareType:{type:Number,default:0},shareTitle:{type:String,default:""},shareText:{type:String,default:""},image:{type:String,default:""},href:{type:String,default:""},isReport:{type:Boolean,default:!1}},data:function(){return{providerList:[]}},created:function(){var n=this;uni.getProvider({service:"share",success:function(t){var e=[];e.push({name:"生成海報",id:"poster",icon:"wlIcon-classify",background:"gray",sort:4},{name:"鏈接",id:"link",icon:"wlIcon-lianjie",background:"gray",sort:5}),n.isReport&&e.push({name:"舉報",id:"report",icon:"wlIcon-jubao",background:"gray",sort:6}),n.providerList=e.sort((function(n,t){return n.sort-t.sort}))},fail:function(n){uni.showModal({content:"獲取分享通道失败",showCancel:!1})}})},methods:{share:function(n){var t=this;return(0,i.default)(regeneratorRuntime.mark((function e(){var a,i,s;return regeneratorRuntime.wrap((function(e){while(1)switch(e.prev=e.next){case 0:if("poster"!=n.id){e.next=4;break}t.$wanlshop.to("/pages/user/qrcode/qrcode?url="+encodeURIComponent(t.href)),e.next=40;break;case 4:if("link"!=n.id){e.next=8;break}t.$wanlshop.msg("暂不支持，請手動複製"),e.next=40;break;case 8:if("report"!=n.id){e.next=12;break}t.complaint(),e.next=40;break;case 12:if(t.shareTitle||1!==t.shareType&&0!==t.shareType){e.next=15;break}return uni.showModal({content:"分享内容不能為空",showCancel:!1}),e.abrupt("return");case 15:if(t.image||2!==t.shareType&&0!==t.shareType){e.next=18;break}return uni.showModal({content:"分享图片不能為空",showCancel:!1}),e.abrupt("return");case 18:a={provider:n.id,scene:n.type&&"WXSenceTimeline"===n.type?"WXSenceTimeline":"WXSceneSession",type:t.shareType,success:function(n){uni.showModal({content:"已分享",showCancel:!1})},fail:function(n){uni.showModal({content:n.errMsg,showCancel:!1})}},e.t0=t.shareType,e.next=0===e.t0?22:1===e.t0?27:2===e.t0?29:5===e.t0?31:37;break;case 22:return a.summary=t.shareText,a.imageUrl=t.image,a.title=t.shareTitle,a.href=t.href,e.abrupt("break",38);case 27:return a.summary=t.shareText,e.abrupt("break",38);case 29:return a.imageUrl=t.image,e.abrupt("break",38);case 31:return i=getCurrentPages(),s=i[i.length-1].route,a.imageUrl=t.image?t.image:$wanlshop.appstc("/qrcode/logo.png"),a.title=t.shareTitle,a.miniProgram={id:t.$store.state.common.appConfig.mp_weixin_id,path:s,webUrl:t.href,type:0},e.abrupt("break",38);case 37:return e.abrupt("break",38);case 38:1===a.type&&"qq"===a.provider&&(a.href=t.href,a.title=t.shareTitle),uni.share(a);case 40:t.close();case 41:case"end":return e.stop()}}),e)})))()},close:function(){this.$emit("change")},complaint:function(){this.$emit("change","complaint")}}};t.default=s},"10cf":function(n,t,e){"use strict";e.r(t);var a=e("0e12"),i=e.n(a);for(var s in a)"default"!==s&&function(n){e.d(t,n,(function(){return a[n]}))}(s);t["default"]=i.a},"3b1a":function(n,t,e){"use strict";var a=e("cea5"),i=e.n(a);i.a},4457:function(n,t,e){"use strict";var a;e.d(t,"b",(function(){return i})),e.d(t,"c",(function(){return s})),e.d(t,"a",(function(){return a}));var i=function(){var n=this,t=n.$createElement,e=n._self._c||t;return e("v-uni-view",[e("v-uni-view",{staticClass:"wanl-direct"},[e("v-uni-view",{staticClass:"menu-header",style:{paddingTop:n.wanlsys.top+"px"}},[e("v-uni-view",[n._v("功能直达")]),e("v-uni-view",{on:{click:function(t){arguments[0]=t=n.$handleEvent(t),n.close.apply(void 0,arguments)}}},[e("v-uni-text",{staticClass:"wlIcon-31guanbi"})],1)],1),e("v-uni-view",{staticClass:"menu-box"},[e("v-uni-view",{staticClass:"menu-item",attrs:{"hover-class":"wanl-opcity"},on:{click:function(t){arguments[0]=t=n.$handleEvent(t),n.$wanlshop.on("/pages/notice/notice")}}},[e("v-uni-view",{staticClass:"badge-box"},[e("v-uni-text",{staticClass:"wlIcon-xiaoxizhongxin"}),n.statistics.notice.notice+n.statistics.notice.order+n.statistics.notice.chat>0?e("v-uni-view",{staticClass:"cu-tag badge"},[n._v(n._s(n.statistics.notice.notice+n.statistics.notice.order+n.statistics.notice.chat))]):n._e()],1),e("v-uni-view",{staticClass:"menu-text"},[n._v("消息")])],1),e("v-uni-view",{staticClass:"menu-item",attrs:{"hover-class":"wanl-opcity"},on:{click:function(t){arguments[0]=t=n.$handleEvent(t),n.$wanlshop.on("/pages/wanlshop/index")}}},[e("v-uni-view",{staticClass:"badge-box"},[e("v-uni-text",{staticClass:"wlIcon-31shouye"})],1),e("v-uni-view",{staticClass:"menu-text"},[n._v("首頁")])],1),e("v-uni-view",{staticClass:"menu-item",attrs:{"hover-class":"wanl-opcity"},on:{click:function(t){arguments[0]=t=n.$handleEvent(t),n.$wanlshop.on("/pages/user/user")}}},[e("v-uni-view",{staticClass:"badge-box"},[e("v-uni-text",{staticClass:"wlIcon-31wode"}),n.statistics.order.pay+n.statistics.order.delive+n.statistics.order.receiving+n.statistics.order.evaluate>0?e("v-uni-view",{staticClass:"cu-tag badge"},[n._v(n._s(n.statistics.order.pay+n.statistics.order.delive+n.statistics.order.receiving+n.statistics.order.evaluate))]):n._e()],1),e("v-uni-view",{staticClass:"menu-text"},[n._v("我的")])],1),e("v-uni-view",{staticClass:"menu-item",attrs:{"hover-class":"wanl-opcity"},on:{click:function(t){arguments[0]=t=n.$handleEvent(t),n.$wanlshop.on("/pages/cart/cart")}}},[e("v-uni-view",{staticClass:"badge-box"},[e("v-uni-text",{staticClass:"wlIcon-gouwuche"}),n.cart.cartnum>0?e("v-uni-view",{staticClass:"cu-tag badge"},[n._v(n._s(n.cart.cartnum))]):n._e()],1),e("v-uni-view",{staticClass:"menu-text"},[n._v("購物車")])],1),e("v-uni-view",{staticClass:"menu-item",attrs:{"hover-class":"wanl-opcity"},on:{click:function(t){arguments[0]=t=n.$handleEvent(t),n.$wanlshop.on("/pages/user/service")}}},[e("v-uni-view",{staticClass:"badge-box"},[e("v-uni-text",{staticClass:"wlIcon-unie737"})],1),e("v-uni-view",{staticClass:"menu-text"},[n._v("客服小蜜")])],1),e("v-uni-view",{staticClass:"menu-item",attrs:{"hover-class":"wanl-opcity"},on:{click:function(t){arguments[0]=t=n.$handleEvent(t),n.$wanlshop.on("/pages/user/feedback/feedback")}}},[e("v-uni-view",{staticClass:"badge-box"},[e("v-uni-text",{staticClass:"wlIcon-xiugaioryijian"})],1),e("v-uni-view",{staticClass:"menu-text"},[n._v("我要反饋")])],1),e("v-uni-view",{staticClass:"menu-item",attrs:{"hover-class":"wanl-opcity"},on:{click:function(t){arguments[0]=t=n.$handleEvent(t),n.$emit("change","share")}}},[e("v-uni-view",{staticClass:"badge-box"},[e("v-uni-text",{staticClass:"wlIcon-fenxiang"})],1),e("v-uni-view",{staticClass:"menu-text"},[n._v("分享")])],1)],1)],1)],1)},s=[]},"62b0":function(n,t,e){"use strict";e.r(t);var a=e("fbcc"),i=e("10cf");for(var s in i)"default"!==s&&function(n){e.d(t,n,(function(){return i[n]}))}(s);e("01f5");var r,c=e("f0c5"),o=Object(c["a"])(i["default"],a["b"],a["c"],!1,null,"2d0b51c7",null,!1,a["a"],r);t["default"]=o.exports},"7bc0":function(n,t,e){"use strict";var a=e("4ea4");e("a9e3"),Object.defineProperty(t,"__esModule",{value:!0}),t.default=void 0;var i=a(e("5530")),s=e("2f62"),r={name:"WanlDirect",props:{scrollAnimation:{type:Number,default:0}},data:function(){return{wanlsys:this.$wanlshop.wanlsys()}},computed:(0,i.default)({},(0,s.mapState)(["statistics","cart"])),methods:{close:function(){this.$emit("change")}}};t.default=r},"88d3":function(n,t,e){var a=e("24fb");t=a(!1),t.push([n.i,"\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n/* 分享 */.wanl-share[data-v-2d0b51c7]{min-height:%?50?%;padding-bottom:0;padding-bottom:env(safe-area-inset-bottom)}.wanl-share .head[data-v-2d0b51c7]{padding:%?25?% %?25?% %?10?% %?25?%}.wanl-share .head .content[data-v-2d0b51c7]{-webkit-box-pack:left;-webkit-justify-content:left;justify-content:left;margin-left:%?16?%}.wanl-share .scroll-x[data-v-2d0b51c7]{white-space:nowrap;width:100%;padding:%?32?% 0;text-align:left;height:%?250?%}.wanl-share .scroll-x .scroll-item[data-v-2d0b51c7]{display:inline-block;font-size:%?36?%;margin-left:%?36?%;text-align:center}.wanl-share .scroll-x .scroll-item uni-button[data-v-2d0b51c7]{line-height:1;background-color:transparent;border:0;padding:0}.wanl-share .scroll-x .scroll-item uni-button[data-v-2d0b51c7]:after{border:0}.wanl-share .scroll-x .scroll-item[data-v-2d0b51c7]:last-child{margin-right:%?36?%}.wanl-share .scroll-x .scroll-item .icons[data-v-2d0b51c7]{width:%?100?%;height:%?100?%;line-height:%?100?%;-webkit-border-radius:%?9999?%;border-radius:%?9999?%;margin:0 auto;font-size:%?40?%;display:block}.wanl-share .scroll-x .scroll-item .icons.gray[data-v-2d0b51c7]{color:#606060;background-color:#f5f5f5}.wanl-share .scroll-x .scroll-item .icons.red[data-v-2d0b51c7]{color:#fff;background-color:#e6162c}.wanl-share .scroll-x .scroll-item .icons.blue[data-v-2d0b51c7]{color:#fff;background-color:#3e92e8}.wanl-share .scroll-x .scroll-item .project[data-v-2d0b51c7]{margin-top:%?25?%}.wanl-share .footer[data-v-2d0b51c7]{height:%?90?%;line-height:%?90?%;font-size:%?30?%}",""]),n.exports=t},"930c":function(n,t,e){var a=e("24fb");t=a(!1),t.push([n.i,".wanl-direct .menu-header[data-v-789c98b2]{font-size:%?34?%;color:#fff;display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-pack:justify;-webkit-justify-content:space-between;justify-content:space-between}.wanl-direct .menu-box[data-v-789c98b2]{color:#fff;padding:%?40?% %?1?% 0 %?1?%;-webkit-box-sizing:border-box;box-sizing:border-box;display:-webkit-box;display:-webkit-flex;display:flex;-webkit-flex-wrap:wrap;flex-wrap:wrap;font-size:%?26?%}.wanl-direct .menu-box .menu-item[data-v-789c98b2]{width:22%;height:%?160?%;-webkit-border-radius:%?24?%;border-radius:%?24?%;display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-align:center;-webkit-align-items:center;align-items:center;-webkit-box-orient:vertical;-webkit-box-direction:normal;-webkit-flex-direction:column;flex-direction:column;-webkit-box-pack:center;-webkit-justify-content:center;justify-content:center;background:rgba(0,0,0,.4);margin-right:4%;margin-bottom:4%}.wanl-direct .menu-box .menu-item[data-v-789c98b2]:nth-of-type(4n){margin-right:0}.wanl-direct .menu-box .menu-item .badge-box[data-v-789c98b2]{position:relative;font-size:%?52?%}.wanl-direct .menu-box .menu-item .badge-box .cu-tag[data-v-789c98b2]{right:%?-25?%}.wanl-direct .menu-box .menu-item .menu-text[data-v-789c98b2]{padding-top:%?12?%}.wanl-direct .menu-up[data-v-789c98b2]{width:100%;text-align:center;font-size:%?38?%;margin-bottom:%?2?%;color:#fff}.wanl-direct .menu-box .wanl-opcity .menu-text[data-v-789c98b2],\n.wanl-direct .menu-box .wanl-opcity .badge-box[data-v-789c98b2]{opacity:.5;-webkit-transition:opacity .2s ease-in-out;transition:opacity .2s ease-in-out}",""]),n.exports=t},9831:function(n,t,e){"use strict";e.r(t);var a=e("7bc0"),i=e.n(a);for(var s in a)"default"!==s&&function(n){e.d(t,n,(function(){return a[n]}))}(s);t["default"]=i.a},"985f":function(n,t,e){"use strict";e.r(t);var a=e("4457"),i=e("9831");for(var s in i)"default"!==s&&function(n){e.d(t,n,(function(){return i[n]}))}(s);e("3b1a");var r,c=e("f0c5"),o=Object(c["a"])(i["default"],a["b"],a["c"],!1,null,"789c98b2",null,!1,a["a"],r);t["default"]=o.exports},b305:function(n,t,e){var a=e("88d3");"string"===typeof a&&(a=[[n.i,a,""]]),a.locals&&(n.exports=a.locals);var i=e("4f06").default;i("2c3938f3",a,!0,{sourceMap:!1,shadowMode:!1})},cea5:function(n,t,e){var a=e("930c");"string"===typeof a&&(a=[[n.i,a,""]]),a.locals&&(n.exports=a.locals);var i=e("4f06").default;i("f563d62e",a,!0,{sourceMap:!1,shadowMode:!1})},fbcc:function(n,t,e){"use strict";var a;e.d(t,"b",(function(){return i})),e.d(t,"c",(function(){return s})),e.d(t,"a",(function(){return a}));var i=function(){var n=this,t=n.$createElement,e=n._self._c||t;return e("v-uni-view",[e("v-uni-view",{staticClass:"wanl-share"},[e("v-uni-view",{staticClass:"head"},[e("v-uni-view",{staticClass:"content"},[e("v-uni-view",{staticClass:"text-lg"},[n._v("分享到")])],1)],1),e("v-uni-scroll-view",{staticClass:"scroll-x solid-bottom",attrs:{"scroll-x":"true","show-scrollbar":"false","scroll-left":n.scrollAnimation,"scroll-with-animation":!0}},n._l(n.providerList,(function(t,a){return t?e("v-uni-view",{key:a,staticClass:"scroll-item",on:{click:function(e){arguments[0]=e=n.$handleEvent(e),n.share(t)}}},[e("v-uni-view",{staticClass:"icons",class:t.background},[e("v-uni-text",{class:t.icon})],1),e("v-uni-view",{staticClass:"project text-sm"},[e("v-uni-text",[n._v(n._s(t.name))])],1)],1):n._e()})),1),e("v-uni-view",{staticClass:"footer",on:{click:function(t){arguments[0]=t=n.$handleEvent(t),n.close.apply(void 0,arguments)}}},[e("v-uni-text",[n._v("取消")])],1)],1)],1)},s=[]}}]);