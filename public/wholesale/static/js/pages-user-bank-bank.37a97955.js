(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["pages-user-bank-bank"],{"0fec":function(t,a,n){"use strict";n.r(a);var e=n("86b8"),i=n.n(e);for(var r in e)"default"!==r&&function(t){n.d(a,t,(function(){return e[t]}))}(r);a["default"]=i.a},"2dfa":function(t,a,n){"use strict";n.d(a,"b",(function(){return i})),n.d(a,"c",(function(){return r})),n.d(a,"a",(function(){return e}));var e={wanlBank:n("d613").default,wanlEmpty:n("3774").default},i=function(){var t=this,a=t.$createElement,n=t._self._c||a;return n("v-uni-view",[n("v-uni-view",{staticClass:"edgeInsetTop"}),n("v-uni-view",{staticClass:"margin-bj"},t._l(t.bankList,(function(a,e){return n("v-uni-view",{key:a.id,staticClass:"item",on:{click:function(a){arguments[0]=a=t.$handleEvent(a),t.checkBank(e)}}},[n("wanl-bank",{attrs:{bankCode:a.bankCode,bankName:a.bankName,cardCode:a.cardCode}}),1==t.choice?n("v-uni-view",{staticClass:"choice text-xl"},[t.index==e?n("v-uni-text",{staticClass:"wlIcon-xuanze-danxuan"}):n("v-uni-text",{staticClass:"wlIcon-xuanze"})],1):t._e()],1)})),1),0==t.bankList.length?n("v-uni-view",[n("wanl-empty",{attrs:{text:"没找到任何帳戶"}})],1):t._e(),n("v-uni-view",{staticClass:"edgeInsetBottom"}),n("v-uni-view",{staticClass:"wanlian cu-bar tabbar foot flex flex-direction"},[n("v-uni-button",{staticClass:"cu-btn wanl-bg-orange lg",on:{click:function(a){arguments[0]=a=t.$handleEvent(a),t.addBank("add")}}},[t._v("新增新帳戶")])],1)],1)},r=[]},3774:function(t,a,n){"use strict";n.r(a);var e=n("743a"),i=n("f873");for(var r in i)"default"!==r&&function(t){n.d(a,t,(function(){return i[t]}))}(r);n("eb43");var c,o=n("f0c5"),s=Object(o["a"])(i["default"],e["b"],e["c"],!1,null,"63e85916",null,!1,e["a"],c);a["default"]=s.exports},"42c6":function(t,a,n){"use strict";var e;n.d(a,"b",(function(){return i})),n.d(a,"c",(function(){return r})),n.d(a,"a",(function(){return e}));var i=function(){var t=this,a=t.$createElement,n=t._self._c||a;return n("v-uni-view",{staticClass:"bank-item",style:t.bankThem},[t.showCanvas?n("v-uni-canvas",{staticClass:"bank-icon",attrs:{id:t.uuid,"canvas-id":t.uuid}}):t._e(),n("v-uni-view",{staticClass:"bank-head"},[n("v-uni-image",{attrs:{src:t.image}}),n("v-uni-view",{staticClass:"bank-info"},[n("v-uni-text",{staticClass:"bank-name"},[t._v(t._s(t.bankName))]),n("v-uni-text",{staticClass:"card-type"},[t._v(t._s(t.cardType))])],1)],1),n("v-uni-view",{staticClass:"card-code"},[n("v-uni-text",{staticClass:"omit"},[t._v("****")]),n("v-uni-text",{staticClass:"omit"},[t._v("****")]),n("v-uni-text",{staticClass:"omit"},[t._v("****")]),n("v-uni-text",[t._v(t._s(t.endNumber))])],1),n("v-uni-image",{staticClass:"bank-watermark",attrs:{src:t.waterMark}})],1)},r=[]},"5bd5":function(t,a,n){var e=n("6028");"string"===typeof e&&(e=[[t.i,e,""]]),e.locals&&(t.exports=e.locals);var i=n("4f06").default;i("7c3844c7",e,!0,{sourceMap:!1,shadowMode:!1})},6028:function(t,a,n){var e=n("24fb");a=e(!1),a.push([t.i,".item[data-v-56799fa2]{position:relative}.item .choice[data-v-56799fa2]{color:hsla(0,0%,100%,.8);position:absolute;right:%?20?%;top:%?20?%}.wanlian.cu-bar.tabbar[data-v-56799fa2]{background-color:transparent}.wanlian.cu-bar.tabbar .cu-btn[data-v-56799fa2]{width:calc(100% - %?50?%)}.wanlian.cu-bar.tabbar .cu-btn.lg[data-v-56799fa2]{font-size:%?32?%;height:%?86?%}",""]),t.exports=a},"61c0":function(t,a,n){"use strict";var e=n("854e"),i=n.n(e);i.a},"6868b":function(t,a,n){var e=n("24fb");a=e(!1),a.push([t.i,'.omit[data-v-5bcb28a6]{font-size:%?48?%;margin-right:%?30?%}.card-code[data-v-5bcb28a6]{margin-top:%?15?%;display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-pack:end;-webkit-justify-content:flex-end;justify-content:flex-end;color:#fff;font-size:%?38?%}.flex-1[data-v-5bcb28a6]{-webkit-box-flex:1;-webkit-flex:1;flex:1}.card-type[data-v-5bcb28a6]{font-size:%?24?%;color:#f1f1f1}.bank-name[data-v-5bcb28a6]{font-size:%?32?%;color:#fff}.bank-info[data-v-5bcb28a6]{display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-orient:vertical;-webkit-box-direction:normal;-webkit-flex-direction:column;flex-direction:column;margin-left:%?30?%}.bank-head[data-v-5bcb28a6]{display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-flex:1;-webkit-flex:1;flex:1;-webkit-box-align:center;-webkit-align-items:center;align-items:center}.bank-head uni-image[data-v-5bcb28a6]{width:%?100?%;height:%?100?%;padding:%?15?%;background-color:#fff;-webkit-border-radius:50%;border-radius:50%;overflow:hidden}.bank-icon[data-v-5bcb28a6]{position:absolute;top:%?20?%;left:%?20?%;width:%?100?%;height:%?100?%}.bank-watermark[data-v-5bcb28a6]{position:absolute;right:%?60?%;bottom:%?-30?%;width:%?120?%;height:%?120?%;-webkit-filter:grayscale(100%) brightness(400%);filter:grayscale(100%) brightness(400%);opacity:.1}.bank-item[data-v-5bcb28a6]{-webkit-box-flex:1;-webkit-flex:1;flex:1;margin-top:%?20?%;position:relative;-webkit-border-radius:%?20?%;border-radius:%?20?%;padding:%?20?%}\n/* .bank-item:after {\n\tcontent: "";\n\tdisplay: block;\n\tbackground: inherit;\n\tfilter: blur(10rpx);\n\tposition: absolute;\n\twidth: 100%;\n\theight: 100%;\n\ttop: 10rpx;\n\tleft: 10rpx;\n\tz-index: -1;\n\topacity: 0.4;\n\ttransform-origin: 0 0;\n\tborder-radius: inherit;\n\ttransform: scale(1, 1);\n} */',""]),t.exports=a},"69de":function(t,a,n){"use strict";n.r(a);var e=n("a435"),i=n.n(e);for(var r in e)"default"!==r&&function(t){n.d(a,t,(function(){return e[t]}))}(r);a["default"]=i.a},7108:function(t,a,n){"use strict";Object.defineProperty(a,"__esModule",{value:!0}),a.default=void 0;var e={name:"WanlEmpty",props:{src:{type:String,default:""},text:{type:String,default:"没有找到任何内容"}}};a.default=e},"743a":function(t,a,n){"use strict";var e;n.d(a,"b",(function(){return i})),n.d(a,"c",(function(){return r})),n.d(a,"a",(function(){return e}));var i=function(){var t=this,a=t.$createElement,n=t._self._c||a;return n("v-uni-view",{staticClass:"empty-content"},[n("v-uni-view",{staticClass:"wanl-gray text-center"},[n("v-uni-image",{staticClass:"animation-scale-down",attrs:{src:t.src?t.$wanlshop.appstc("/default/"+t.src+".png"):t.$wanlshop.appstc("/default/default3x.png")}}),n("v-uni-view",{staticClass:"text-30"},[t._v(t._s(t.text))])],1)],1)},r=[]},"854e":function(t,a,n){var e=n("6868b");"string"===typeof e&&(e=[[t.i,e,""]]),e.locals&&(t.exports=e.locals);var i=n("4f06").default;i("36d5f1ae",e,!0,{sourceMap:!1,shadowMode:!1})},"86b8":function(t,a,n){"use strict";(function(t){var e=n("4ea4");n("99af"),n("cb29"),n("4160"),n("a15b"),n("d81d"),n("b64b"),n("d3b7"),n("e25e"),n("ac1f"),n("1276"),n("159b"),Object.defineProperty(a,"__esModule",{value:!0}),a.default=void 0,n("96cf");var i=e(n("1da1")),r={name:"wanlBank",props:{bankCode:{type:String,required:!0},bankName:{type:String,required:!0},cardType:{type:String,default:"储蓄卡"},cardCode:{type:String,required:!0}},computed:{waterMark:function(){return this.image},endNumber:function(){var t=this.cardCode.length;return this.cardCode.substr(t-4,t)}},data:function(){var t=function(){return"bank_"+parseInt(1e8*Math.random())};return{bankThem:"",image:"",showCanvas:!0,uuid:t()}},methods:{buildItem:function(){var t=this;return(0,i.default)(regeneratorRuntime.mark((function a(){return regeneratorRuntime.wrap((function(a){while(1)switch(a.prev=a.next){case 0:return t.bankThem=uni.getStorageSync("BANK_".concat(t.bankCode)),t.image="/static/images/bank/".concat(t.bankCode,".png"),a.next=4,t.getThemColor();case 4:t.showCanvas=!1;case 5:case"end":return a.stop()}}),a)})))()},getThemColor:function(){var t=this;return(0,i.default)(regeneratorRuntime.mark((function a(){var n,e,i,r,c;return regeneratorRuntime.wrap((function(a){while(1)switch(a.prev=a.next){case 0:if(null==t.bankThem||""==t.bankThem){a.next=2;break}return a.abrupt("return");case 2:return n=uni.upx2px(100),e=uni.upx2px(72),t.iconContext=uni.createCanvasContext(t.uuid,t),t.iconContext.width=n,t.iconContext.height=n,t.iconContext.fillStyle="#FFFFFF",t.iconContext.beginPath(),i=n/2,t.iconContext.arc(i,i,i-1,0,2*Math.PI,0,!0),t.iconContext.closePath(),t.iconContext.fill(),r=n/2-e/2,t.iconContext.drawImage(t.image,r,r,e,e),a.next=17,t.draw(t.iconContext);case 17:return a.next=19,t.getImageData(r,e);case 19:c=a.sent,t.parsingImageData(c);case 21:case"end":return a.stop()}}),a)})))()},parsingImageData:function(t){for(var a={},n=0,e=t.length;n<e;n+=4){var i=t[n],r=t[n+1],c=t[n+2];if(i+r+c<400){var o=[i,r,c],s=o.join(", ");a[s]=null==a[s]?1:a[s]+1}}var u="";Object.keys(a).forEach((function(t){u=""===u?t:a[u]>a[t]?u:t}));var d=u.split(", ").map((function(t,a){if(t=parseInt(t),a>1)return t;var n=t+50;return n>255?255:n})).join(", ");this.bankThem="background-image: linear-gradient(45deg, rgba(".concat(d,", 1), rgba(").concat(u,", 1));"),uni.setStorageSync("BANK_".concat(this.bankCode),this.bankThem)},getImageData:function(a,n){var e=this;return new Promise((function(i,r){uni.canvasGetImageData({canvasId:e.uuid,x:a,y:a,width:n,height:n,success:function(t){i(t.data)},fail:function(a){t.log(a),r()}},e)}))},getBankLogo:function(){var a=this;return new Promise((function(n,e){uni.downloadFile({url:a.$wanlshop.appstc("/bank/".concat(a.bankCode,".png")),success:function(t){n(t.tempFilePath)},fail:function(a){t.log(a),e()}})}))},draw:function(t){var a=arguments.length>1&&void 0!==arguments[1]&&arguments[1];return new Promise((function(n){t.draw(a,(function(){n()}))}))}},created:function(){var t=this;this.$nextTick((function(){t.buildItem()}))}};a.default=r}).call(this,n("5a52")["default"])},a435:function(t,a,n){"use strict";var e=n("4ea4");n("99af"),Object.defineProperty(a,"__esModule",{value:!0}),a.default=void 0,n("96cf");var i=e(n("1da1")),r={data:function(){return{bankList:[],index:null,choice:0}},onLoad:function(t){this.choice=t.choice,this.loadData()},methods:{loadData:function(){var t=this;return(0,i.default)(regeneratorRuntime.mark((function a(){return regeneratorRuntime.wrap((function(a){while(1)switch(a.prev=a.next){case 0:t.$api.post({url:"/wanlshop/pay/getPayAccount",success:function(a){t.bankList=a}});case 1:case"end":return a.stop()}}),a)})))()},refreshList:function(t){var a=this;return(0,i.default)(regeneratorRuntime.mark((function n(){return regeneratorRuntime.wrap((function(n){while(1)switch(n.prev=n.next){case 0:uni.showLoading({title:"更新中.."}),a.$api.post({url:"/wanlshop/pay/addPayAccount",data:t,success:function(t){a.loadData(),uni.hideLoading(),a.$store.commit("statistics/dynamic",{accountbank:a.$store.state.statistics.dynamic.accountbank+1})}});case 2:case"end":return n.stop()}}),n)})))()},addBank:function(t,a){this.$wanlshop.to("/pages/user/bank/add?type=".concat(t,"&data=").concat(JSON.stringify(a)))},checkBank:function(t){1==this.choice?(this.index=t,this.$wanlshop.prePage().bankData=this.bankList[t],this.$wanlshop.back(1)):this.$wanlshop.to("/pages/user/bank/details?data=".concat(JSON.stringify(this.bankList[t])))}}};a.default=r},a822:function(t,a,n){"use strict";var e=n("5bd5"),i=n.n(e);i.a},ba20:function(t,a,n){var e=n("24fb");a=e(!1),a.push([t.i,".empty-content[data-v-63e85916]{display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-align:center;-webkit-align-items:center;align-items:center;-webkit-box-pack:center;-webkit-justify-content:center;justify-content:center;width:100%;padding:%?300?% %?130?%}.empty-content uni-image[data-v-63e85916]{width:%?320?%;height:%?320?%}",""]),t.exports=a},cb29:function(t,a,n){var e=n("23e7"),i=n("81d5"),r=n("44d2");e({target:"Array",proto:!0},{fill:i}),r("fill")},d613:function(t,a,n){"use strict";n.r(a);var e=n("42c6"),i=n("0fec");for(var r in i)"default"!==r&&function(t){n.d(a,t,(function(){return i[t]}))}(r);n("61c0");var c,o=n("f0c5"),s=Object(o["a"])(i["default"],e["b"],e["c"],!1,null,"5bcb28a6",null,!1,e["a"],c);a["default"]=s.exports},eb43:function(t,a,n){"use strict";var e=n("f992"),i=n.n(e);i.a},f83c:function(t,a,n){"use strict";n.r(a);var e=n("2dfa"),i=n("69de");for(var r in i)"default"!==r&&function(t){n.d(a,t,(function(){return i[t]}))}(r);n("a822");var c,o=n("f0c5"),s=Object(o["a"])(i["default"],e["b"],e["c"],!1,null,"56799fa2",null,!1,e["a"],c);a["default"]=s.exports},f873:function(t,a,n){"use strict";n.r(a);var e=n("7108"),i=n.n(e);for(var r in e)"default"!==r&&function(t){n.d(a,t,(function(){return e[t]}))}(r);a["default"]=i.a},f992:function(t,a,n){var e=n("ba20");"string"===typeof e&&(e=[[t.i,e,""]]),e.locals&&(t.exports=e.locals);var i=n("4f06").default;i("4878184a",e,!0,{sourceMap:!1,shadowMode:!1})}}]);