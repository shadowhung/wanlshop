(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["pages-user-coupon-apply"],{"02e5":function(t,e,i){"use strict";i.r(e);var n=i("8ad9"),a=i("8eb7");for(var s in a)"default"!==s&&function(t){i.d(e,t,(function(){return a[t]}))}(s);i("cece");var c,u=i("f0c5"),o=Object(u["a"])(a["default"],n["b"],n["c"],!1,null,"6ff37c24",null,!1,n["a"],c);e["default"]=o.exports},"0e80":function(t,e,i){"use strict";i.d(e,"b",(function(){return a})),i.d(e,"c",(function(){return s})),i.d(e,"a",(function(){return n}));var n={wanlWaterfall:i("02e5").default},a=function(){var t=this,e=t.$createElement,i=t._self._c||e;return i("v-uni-view",[i("v-uni-view",{staticClass:"wanl-product"},["col-2-10"==t.dataStyle||"col-2-15"==t.dataStyle||"col-2-20"==t.dataStyle||"col-2-25"==t.dataStyle||"col-2-30"==t.dataStyle?i("v-uni-view",{staticClass:"product_warter",class:t.dataStyle},[i("wanl-waterfall",{attrs:{flowList:t.dataList},scopedSlots:t._u([{key:"left",fn:function(e){var n=e.leftList;return t._l(n,(function(e,n){return i("v-uni-view",{key:n,staticClass:"warter left",on:{click:function(i){arguments[0]=i=t.$handleEvent(i),t.onGoods(e.id)}}},[i("v-uni-view",{staticClass:"img-wrap"},[i("v-uni-image",{staticClass:"image",attrs:{src:e.image,mode:"widthFix"}})],1),i("v-uni-view",{staticClass:"content padding-bj"},[i("v-uni-view",{staticClass:"text-cut-2"},[1==e.shop.isself?[i("v-uni-view",{staticClass:"cu-tag radius margin-right-xs sm bg-red"},[t._v("自营")])]:t._e(),i("v-uni-text",[t._v(t._s(e.title))])],2),i("v-uni-view",{staticClass:"goods-tag"},[1==e.shop.isself?i("v-uni-view",{staticClass:"cu-tag radius sm line-red"},[t._v("官方放心購")]):t._e(),e.isLive?i("v-uni-view",{staticClass:"cu-tag radius sm line-gray",on:{click:function(i){arguments[0]=i=t.$handleEvent(i),t.onLive(e.isLive)}}},[t._v("LIVE")]):t._e()],1),i("v-uni-view",{staticClass:"flex align-center justify-between"},[i("v-uni-view",{staticClass:"text-red text-bold text-lg"},[i("v-uni-text",{staticClass:"text-price"},[t._v(t._s(e.price))])],1),i("v-uni-view",{staticClass:"text-sm wanl-gray"},[i("v-uni-text",[t._v(t._s(e.sales>9999?"9999+":e.sales)+" 銷量")])],1)],1)],1)],1)}))}},{key:"right",fn:function(e){var n=e.rightList;return t._l(n,(function(e,n){return i("v-uni-view",{key:n,staticClass:"warter right",on:{click:function(i){arguments[0]=i=t.$handleEvent(i),t.onGoods(e.id)}}},[i("v-uni-view",{staticClass:"img-wrap"},[i("v-uni-image",{staticClass:"image",attrs:{src:e.image,mode:"widthFix"}})],1),i("v-uni-view",{staticClass:"content padding-bj"},[i("v-uni-view",{staticClass:"text-cut-2"},[1==e.shop.isself?[i("v-uni-view",{staticClass:"cu-tag radius margin-right-xs sm bg-red"},[t._v("自营")])]:t._e(),i("v-uni-text",[t._v(t._s(e.title))])],2),i("v-uni-view",{staticClass:"goods-tag"},[1==e.shop.isself?i("v-uni-view",{staticClass:"cu-tag radius sm line-red"},[t._v("官方放心購")]):t._e(),e.isLive?i("v-uni-view",{staticClass:"cu-tag radius sm line-gray",on:{click:function(i){arguments[0]=i=t.$handleEvent(i),t.onLive(e.isLive)}}},[t._v("LIVE")]):t._e()],1),i("v-uni-view",{staticClass:"flex align-center justify-between"},[i("v-uni-view",{staticClass:"text-red text-bold text-lg"},[i("v-uni-text",{staticClass:"text-price"},[t._v(t._s(e.price))])],1),i("v-uni-view",{staticClass:"text-sm wanl-gray"},[i("v-uni-text",[t._v(t._s(e.sales>9999?"9999+":e.sales)+" 銷量")])],1)],1)],1)],1)}))}}],null,!1,3549764905)})],1):i("v-uni-view",{staticClass:"product_list",class:t.dataStyle},t._l(t.dataList,(function(e,n){return i("v-uni-view",{key:n,staticClass:"item",on:{click:function(i){arguments[0]=i=t.$handleEvent(i),t.onGoods(e.id)}}},[i("v-uni-view",{staticClass:"img-wrap"},[i("v-uni-image",{attrs:{src:t.$wanlshop.oss(e.image,125,125)}})],1),i("v-uni-view",{staticClass:"content padding-sm"},[i("v-uni-view",{},[i("v-uni-view",{staticClass:"text-cut-2"},[1==e.shop.isself?[i("v-uni-view",{staticClass:"cu-tag radius margin-right-xs sm bg-red"},[t._v("自营")])]:t._e(),i("v-uni-text",[t._v(t._s(e.title))])],2),i("v-uni-view",{staticClass:"goods-tag"},[1==e.shop.isself?i("v-uni-view",{staticClass:"cu-tag radius sm line-red"},[t._v("官方放心購")]):t._e(),e.isLive?i("v-uni-view",{staticClass:"cu-tag radius sm line-gray",on:{click:function(i){arguments[0]=i=t.$handleEvent(i),t.onLive(e.isLive)}}},[t._v("LIVE")]):t._e()],1)],1),i("v-uni-view",{staticClass:"flex align-center justify-between"},[i("v-uni-view",{staticClass:"text-red text-bold text-lg"},[i("v-uni-text",{staticClass:"text-price"},[t._v(t._s(e.price))])],1),i("v-uni-view",{staticClass:"text-sm wanl-gray"},[i("v-uni-text",{staticClass:"margin-right"},[t._v(t._s(e.sales>9999?"9999+":e.sales)+" 銷量")]),i("v-uni-text",[t._v(t._s(e.comment>0?parseInt(e.praise/e.comment*100):0)+"% 好評")])],1)],1)],1)],1)})),1)],1)],1)},s=[]},"284f":function(t,e,i){"use strict";i.d(e,"b",(function(){return a})),i.d(e,"c",(function(){return s})),i.d(e,"a",(function(){return n}));var n={wanlProduct:i("becb").default},a=function(){var t=this,e=t.$createElement,i=t._self._c||e;return i("v-uni-view",{staticClass:"wanl-coupon"},[i("v-uni-view",{staticClass:"edgeInsetTop"}),i("v-uni-view",{staticClass:"padding-bj bg-red text-black"},[t.coupon?i("v-uni-view",{staticClass:"item radius-bock",class:t.coupon.type,on:{click:function(e){arguments[0]=e=t.$handleEvent(e),t.onDetails(t.coupon)}}},[i("v-uni-image",{staticClass:"coupon-bg",attrs:{src:t.$wanlshop.appstc("/coupon/bg_coupon_3x.png")}}),t.coupon_state?i("v-uni-image",{staticClass:"coupon-sign",attrs:{src:t.$wanlshop.appstc("/coupon/img_couponcentre_received_3x.png")}}):t._e(),i("v-uni-view",{staticClass:"item-left"},["reduction"==t.coupon.type||"vip"==t.coupon.type&&"reduction"==t.coupon.usertype?[i("v-uni-view",{staticClass:"colour"},[i("v-uni-text",{staticClass:"text-price"}),i("v-uni-text",{staticClass:"price"},[t._v(t._s(Number(t.coupon.price)))])],1),i("v-uni-view",{staticClass:"cu-tag wanl-gray-dark radius text-sm"},[t._v("滿"+t._s(Number(t.coupon.limit))+"减"+t._s(Number(t.coupon.price)))])]:t._e(),"discount"==t.coupon.type||"vip"==t.coupon.type&&"discount"==t.coupon.usertype?[i("v-uni-view",{staticClass:"colour"},[i("v-uni-text",{staticClass:"price"},[t._v(t._s(Number(t.coupon.discount)))]),i("v-uni-text",{staticClass:"discount"},[t._v("折")])],1),i("v-uni-view",{staticClass:"cu-tag wanl-gray-dark radius text-sm"},[t._v("滿"+t._s(Number(t.coupon.limit))+"打"+t._s(Number(t.coupon.discount))+"折")])]:t._e(),"shipping"==t.coupon.type?[i("v-uni-view",{staticClass:"colour"},[i("v-uni-text",{staticClass:"price"},[t._v("包郵")])],1),i("v-uni-view",{staticClass:"cu-tag wanl-gray-dark radius text-sm"},[t._v("滿"+t._s(Number(t.coupon.limit))+"NT$包郵")])]:t._e()],2),i("v-uni-view",{staticClass:"item-right padding-bj"},[i("v-uni-view",{staticClass:"title"},[i("v-uni-view",{staticClass:"cu-tag sm radius margin-right-xs tagstyle"},[t._v(t._s(t.coupon.type_text))]),i("v-uni-text",{staticClass:"text-cut wanl-gray text-min"},[t._v(t._s(t.coupon.name))])],1),i("v-uni-view",{staticClass:"content text-min"},[i("v-uni-view",{staticClass:"wanl-gray"},[i("v-uni-view",[i("v-uni-text",{staticClass:"wlIcon-dot"}),t._v("當前頁面所有商品可用")],1),"fixed"==t.coupon.pretype?[i("v-uni-view",[i("v-uni-text",{staticClass:"wlIcon-dot"}),t._v("生效 "+t._s(t.coupon.startdate))],1),i("v-uni-view",[i("v-uni-text",{staticClass:"wlIcon-dot"}),t._v("结束 "+t._s(t.coupon.enddate))],1)]:t._e(),"appoint"==t.coupon.pretype?[0==t.coupon.validity?i("v-uni-view",[i("v-uni-text",{staticClass:"wlIcon-dot"}),t._v("未使用前 永久 有效")],1):i("v-uni-view",[i("v-uni-text",{staticClass:"wlIcon-dot"}),t._v("領取後 "+t._s(t.coupon.validity)+" 天有效")],1)]:t._e()],2),t.coupon_state?t._e():i("v-uni-view",{staticClass:"cu-btn sm round",on:{click:function(e){e.stopPropagation(),arguments[0]=e=t.$handleEvent(e),t.onReceive(t.coupon.id)}}},[t._v("立即領取")])],1)],1)],1):t._e()],1),i("v-uni-view",{},[i("wanl-product",{attrs:{dataList:t.dataList}})],1)],1)},s=[]},"6a88":function(t,e,i){"use strict";i.r(e);var n=i("b825"),a=i.n(n);for(var s in n)"default"!==s&&function(t){i.d(e,t,(function(){return n[t]}))}(s);e["default"]=a.a},"8ad9":function(t,e,i){"use strict";var n;i.d(e,"b",(function(){return a})),i.d(e,"c",(function(){return s})),i.d(e,"a",(function(){return n}));var a=function(){var t=this,e=t.$createElement,i=t._self._c||e;return i("v-uni-view",{staticClass:"wanl-waterfall"},[i("v-uni-view",{staticClass:"wanl-cloumn",attrs:{id:"wanl-left-cloumn"}},[t._t("left",null,{leftList:t.leftList})],2),i("v-uni-view",{staticClass:"wanl-cloumn",attrs:{id:"wanl-right-cloumn"}},[t._t("right",null,{rightList:t.rightList})],2)],1)},s=[]},"8eb7":function(t,e,i){"use strict";i.r(e);var n=i("d017"),a=i.n(n);for(var s in n)"default"!==s&&function(t){i.d(e,t,(function(){return n[t]}))}(s);e["default"]=a.a},"95ad":function(t,e,i){"use strict";i.r(e);var n=i("284f"),a=i("cfd5");for(var s in a)"default"!==s&&function(t){i.d(e,t,(function(){return a[t]}))}(s);var c,u=i("f0c5"),o=Object(u["a"])(a["default"],n["b"],n["c"],!1,null,"4238cf0f",null,!1,n["a"],c);e["default"]=o.exports},"97fc":function(t,e,i){var n=i("24fb");e=n(!1),e.push([t.i,'@charset "UTF-8";\n/* 頁面左右間距 */\n/* 文字尺寸 */\n/*文字颜色*/\n/* 边框颜色 */\n/* 圖片加載中颜色 */\n/* 行為相關颜色 */.wanl-waterfall[data-v-6ff37c24]{display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-orient:horizontal;-webkit-box-direction:normal;-webkit-flex-direction:row;flex-direction:row;-webkit-box-align:start;-webkit-align-items:flex-start;align-items:flex-start}.wanl-cloumn[data-v-6ff37c24]{display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-flex:1;-webkit-flex:1;flex:1;-webkit-box-orient:vertical;-webkit-box-direction:normal;-webkit-flex-direction:column;flex-direction:column;height:auto;width:50%}.wanl-image[data-v-6ff37c24]{width:100%}',""]),t.exports=e},b825:function(t,e,i){"use strict";Object.defineProperty(e,"__esModule",{value:!0}),e.default=void 0;var n={name:"wanlProduct",props:{dataList:{type:Array,required:!0,default:function(){return[]}},dataStyle:{type:String,default:"col-2-20"}}};e.default=n},becb:function(t,e,i){"use strict";i.r(e);var n=i("0e80"),a=i("6a88");for(var s in a)"default"!==s&&function(t){i.d(e,t,(function(){return a[t]}))}(s);var c,u=i("f0c5"),o=Object(u["a"])(a["default"],n["b"],n["c"],!1,null,"4d55350f",null,!1,n["a"],c);e["default"]=o.exports},cece:function(t,e,i){"use strict";var n=i("d656"),a=i.n(n);a.a},cfc0:function(t,e,i){"use strict";var n=i("4ea4");i("99af"),Object.defineProperty(e,"__esModule",{value:!0}),e.default=void 0,i("96cf");var a=n(i("1da1")),s={data:function(){return{coupon_id:0,coupon_state:!1,coupon:null,dataList:[],reload:!1,total:0,current_page:1,last_page:1,status:"more",contentText:{contentdown:" ",contentrefresh:"加載中",contentnomore:""}}},onLoad:function(t){this.coupon_id=t.id,this.coupon_state=!!t.state,this.loadData()},onPullDownRefresh:function(){this.current_page=1,this.reload=!0,this.loadData()},onReachBottom:function(){this.current_page>=this.last_page?this.status="noMore":(this.reload=!1,this.current_page=this.current_page+1,this.status="loading",this.loadData())},methods:{loadData:function(){var t=this;return(0,a.default)(regeneratorRuntime.mark((function e(){return regeneratorRuntime.wrap((function(e){while(1)switch(e.prev=e.next){case 0:t.$api.get({url:"/wanlshop/coupon/apply",data:{id:t.coupon_id,page:t.current_page},success:function(e){uni.stopPullDownRefresh(),t.coupon=e.coupon,t.dataList=t.reload?e.goods.data:t.dataList.concat(e.goods.data),t.total=e.goods.total,t.current_page=e.goods.current_page,t.last_page=e.goods.last_page,t.status=0==e.goods.total?"noMore":"more"}});case 1:case"end":return e.stop()}}),e)})))()},onReceive:function(t){var e=this;return(0,a.default)(regeneratorRuntime.mark((function i(){return regeneratorRuntime.wrap((function(i){while(1)switch(i.prev=i.next){case 0:e.$api.post({url:"/wanlshop/coupon/receive",loadingTip:"領取中",data:{id:t},success:function(t){e.coupon_state=!0,e.$wanlshop.msg(t),e.$store.commit("statistics/dynamic",{coupon:e.$store.state.statistics.dynamic.coupon+1})}});case 1:case"end":return i.stop()}}),i)})))()}}};e.default=s},cfd5:function(t,e,i){"use strict";i.r(e);var n=i("cfc0"),a=i.n(n);for(var s in n)"default"!==s&&function(t){i.d(e,t,(function(){return n[t]}))}(s);e["default"]=a.a},d017:function(t,e,i){"use strict";var n=i("4ea4");i("99af"),i("fb6a"),i("a434"),i("a9e3"),i("d3b7"),i("e25e"),i("ac1f"),Object.defineProperty(e,"__esModule",{value:!0}),e.default=void 0,i("96cf");var a=n(i("1da1")),s={name:"wanlWaterfall",props:{flowList:{type:Array,required:!0,default:function(){return[]}},addTime:{type:[Number,String],default:20}},data:function(){return{leftList:[],rightList:[],tempList:[],children:[]}},watch:{copyFlowList:function(t,e){var i=Array.isArray(e)&&e.length>0?e.length:0;0==t.slice(i).length?(this.leftList=[],this.rightList=[],this.tempList=this.cloneData(this.copyFlowList)):this.tempList=this.tempList.concat(this.cloneData(t.slice(i))),this.splitData()}},mounted:function(){this.tempList=this.cloneData(this.copyFlowList),this.splitData()},computed:{copyFlowList:function(){return this.cloneData(this.flowList)}},methods:{splitData:function(){var t=this;return(0,a.default)(regeneratorRuntime.mark((function e(){var i,n,a;return regeneratorRuntime.wrap((function(e){while(1)switch(e.prev=e.next){case 0:if(t.tempList.length){e.next=2;break}return e.abrupt("return");case 2:return e.next=4,t.getRect("#wanl-right-cloumn");case 4:return i=e.sent,e.next=7,t.getRect("#wanl-left-cloumn");case 7:if(n=e.sent,a=t.tempList[0],a){e.next=11;break}return e.abrupt("return");case 11:a.image=t.$wanlshop.oss(a.image,172,0,1),a.comment=t.$wanlshop.toFormat(a.comment,"hundred"),a.praise=a.comment>0?parseInt(a.praise/a.comment*100):0,n.height<i.height?t.leftList.push(a):n.height>i.height?t.rightList.push(a):t.leftList.length<=t.rightList.length?t.leftList.push(a):t.rightList.push(a),t.tempList.splice(0,1),t.tempList.length&&setTimeout((function(){t.splitData()}),t.addTime);case 17:case"end":return e.stop()}}),e)})))()},cloneData:function(t){return JSON.parse(JSON.stringify(t))},getRect:function(t,e){var i=this;return new Promise((function(n){var a=null;a=uni.createSelectorQuery().in(i),a[e?"selectAll":"select"](t).boundingClientRect((function(t){e&&Array.isArray(t)&&t.length&&n(t),!e&&t&&n(t)})).exec()}))}}};e.default=s},d656:function(t,e,i){var n=i("97fc");"string"===typeof n&&(n=[[t.i,n,""]]),n.locals&&(t.exports=n.locals);var a=i("4f06").default;a("014de3ab",n,!0,{sourceMap:!1,shadowMode:!1})}}]);