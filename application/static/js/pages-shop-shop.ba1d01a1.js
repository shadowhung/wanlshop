(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["pages-shop-shop"],{"061e":function(t,a,e){"use strict";var i=e("3a91"),n=e.n(i);n.a},"22c9":function(t,a,e){"use strict";e.r(a);var i=e("2b52"),n=e.n(i);for(var s in i)"default"!==s&&function(t){e.d(a,t,(function(){return i[t]}))}(s);a["default"]=n.a},"2b52":function(t,a,e){"use strict";Object.defineProperty(a,"__esModule",{value:!0}),a.default=void 0;var i={name:"UniDrawer",props:{visible:{type:Boolean,default:!1},mode:{type:String,default:""},width:{type:String,default:"72%"},mask:{type:Boolean,default:!0}},data:function(){return{visibleSync:!1,showDrawer:!1,rightMode:!1,watchTimer:null}},watch:{visible:function(t){t?this.open():this.close()}},created:function(){var t=this;this.visibleSync=this.visible,setTimeout((function(){t.showDrawer=t.visible}),100),this.rightMode="right"===this.mode},methods:{close:function(){this._change("showDrawer","visibleSync",!1)},open:function(){this._change("visibleSync","showDrawer",!0)},_change:function(t,a,e){var i=this;this[t]=e,this.watchTimer&&clearTimeout(this.watchTimer),this.watchTimer=setTimeout((function(){i[a]=e,i.$emit(e?"open":"close")}),e?50:300)}}};a.default=i},"3a91":function(t,a,e){var i=e("c1f9");"string"===typeof i&&(i=[[t.i,i,""]]),i.locals&&(t.exports=i.locals);var n=e("4f06").default;n("46184696",i,!0,{sourceMap:!1,shadowMode:!1})},"3f33":function(t,a,e){"use strict";var i;e.d(a,"b",(function(){return n})),e.d(a,"c",(function(){return s})),e.d(a,"a",(function(){return i}));var n=function(){var t=this,a=t.$createElement,e=t._self._c||a;return t.visibleSync?e("v-uni-view",{staticClass:"uni-drawer",class:{"uni-drawer--visible":t.showDrawer}},[e("v-uni-view",{staticClass:"uni-drawer__mask",class:{"uni-drawer__mask--visible":t.showDrawer&&t.mask},on:{click:function(a){arguments[0]=a=t.$handleEvent(a),t.close.apply(void 0,arguments)}}}),e("v-uni-view",{staticClass:"uni-drawer__content",class:{"uni-drawer--right":t.rightMode,"uni-drawer--left":!t.rightMode,"uni-drawer__content--visible":t.showDrawer},style:{width:t.width}},[t._t("default")],2)],1):t._e()},s=[]},"5def":function(t,a,e){var i=e("ab2a");"string"===typeof i&&(i=[[t.i,i,""]]),i.locals&&(t.exports=i.locals);var n=e("4f06").default;n("ee6f653a",i,!0,{sourceMap:!1,shadowMode:!1})},"635f":function(t,a,e){"use strict";e.r(a);var i=e("eaf8"),n=e("f5fe");for(var s in n)"default"!==s&&function(t){e.d(a,t,(function(){return n[t]}))}(s);e("84cf");var o,r=e("f0c5"),l=Object(r["a"])(n["default"],i["b"],i["c"],!1,null,"e4933d8a",null,!1,i["a"],o);a["default"]=l.exports},"84cf":function(t,a,e){"use strict";var i=e("5def"),n=e.n(i);n.a},"8a19":function(t,a,e){"use strict";e.r(a);var i=e("ac76"),n=e("f33d");for(var s in n)"default"!==s&&function(t){e.d(a,t,(function(){return n[t]}))}(s);var o,r=e("f0c5"),l=Object(r["a"])(n["default"],i["b"],i["c"],!1,null,"22ac7758",null,!1,i["a"],o);a["default"]=l.exports},"96a3":function(t,a,e){"use strict";e("a9e3"),Object.defineProperty(a,"__esModule",{value:!0}),a.default=void 0;var i={name:"UniLoadMore",props:{status:{type:String,default:"more"},showIcon:{type:Boolean,default:!0},iconType:{type:String,default:"auto"},iconSize:{type:Number,default:24},color:{type:String,default:"#777777"},contentText:{type:Object,default:function(){return{contentdown:"上拉顯示更多",contentrefresh:"正在加載...",contentnomore:"没有更多數據了"}}}},data:function(){return{webviewHide:!1,platform:this.$wanlshop.wanlsys().platform}},computed:{iconSnowWidth:function(){return 2*(Math.floor(this.iconSize/24)||1)}},mounted:function(){},methods:{onClick:function(){this.$emit("clickLoadMore",{detail:{status:this.status}})}}};a.default=i},ab2a:function(t,a,e){var i=e("24fb");a=i(!1),a.push([t.i,".uni-load-more[data-v-e4933d8a]{\ndisplay:-webkit-box;display:-webkit-flex;display:flex;\n-webkit-box-orient:horizontal;-webkit-box-direction:normal;-webkit-flex-direction:row;flex-direction:row;height:%?70?%;-webkit-box-align:center;-webkit-align-items:center;align-items:center;-webkit-box-pack:center;-webkit-justify-content:center;justify-content:center}.uni-load-more__text[data-v-e4933d8a]{font-size:%?26?%}.uni-load-more__img[data-v-e4933d8a]{width:24px;height:24px;margin-right:8px}.uni-load-more__img--nvue[data-v-e4933d8a]{color:#666}.uni-load-more__img--android[data-v-e4933d8a],\n.uni-load-more__img--ios[data-v-e4933d8a]{width:24px;height:24px;-webkit-transform:rotate(0deg);transform:rotate(0deg)}\n.uni-load-more__img--android[data-v-e4933d8a]{-webkit-animation:loading-ios 1s 0s linear infinite;animation:loading-ios 1s 0s linear infinite}@-webkit-keyframes loading-android-data-v-e4933d8a{0%{-webkit-transform:rotate(0deg);transform:rotate(0deg)}100%{-webkit-transform:rotate(1turn);transform:rotate(1turn)}}.uni-load-more__img--ios-H5[data-v-e4933d8a]{position:relative;-webkit-animation:loading-ios-H5-data-v-e4933d8a 1s 0s step-end infinite;animation:loading-ios-H5-data-v-e4933d8a 1s 0s step-end infinite}.uni-load-more__img--ios-H5>uni-image[data-v-e4933d8a]{position:absolute;width:100%;height:100%;left:0;top:0}@-webkit-keyframes loading-ios-H5-data-v-e4933d8a{0%{-webkit-transform:rotate(0deg);transform:rotate(0deg)}8%{-webkit-transform:rotate(30deg);transform:rotate(30deg)}16%{-webkit-transform:rotate(60deg);transform:rotate(60deg)}24%{-webkit-transform:rotate(90deg);transform:rotate(90deg)}32%{-webkit-transform:rotate(120deg);transform:rotate(120deg)}40%{-webkit-transform:rotate(150deg);transform:rotate(150deg)}48%{-webkit-transform:rotate(180deg);transform:rotate(180deg)}56%{-webkit-transform:rotate(210deg);transform:rotate(210deg)}64%{-webkit-transform:rotate(240deg);transform:rotate(240deg)}73%{-webkit-transform:rotate(270deg);transform:rotate(270deg)}82%{-webkit-transform:rotate(300deg);transform:rotate(300deg)}91%{-webkit-transform:rotate(330deg);transform:rotate(330deg)}100%{-webkit-transform:rotate(1turn);transform:rotate(1turn)}}@keyframes loading-ios-H5-data-v-e4933d8a{0%{-webkit-transform:rotate(0deg);transform:rotate(0deg)}8%{-webkit-transform:rotate(30deg);transform:rotate(30deg)}16%{-webkit-transform:rotate(60deg);transform:rotate(60deg)}24%{-webkit-transform:rotate(90deg);transform:rotate(90deg)}32%{-webkit-transform:rotate(120deg);transform:rotate(120deg)}40%{-webkit-transform:rotate(150deg);transform:rotate(150deg)}48%{-webkit-transform:rotate(180deg);transform:rotate(180deg)}56%{-webkit-transform:rotate(210deg);transform:rotate(210deg)}64%{-webkit-transform:rotate(240deg);transform:rotate(240deg)}73%{-webkit-transform:rotate(270deg);transform:rotate(270deg)}82%{-webkit-transform:rotate(300deg);transform:rotate(300deg)}91%{-webkit-transform:rotate(330deg);transform:rotate(330deg)}100%{-webkit-transform:rotate(1turn);transform:rotate(1turn)}}\n.uni-load-more__img--android-H5[data-v-e4933d8a]{-webkit-animation:loading-android-H5-rotate-data-v-e4933d8a 2s linear infinite;animation:loading-android-H5-rotate-data-v-e4933d8a 2s linear infinite;-webkit-transform-origin:center center;transform-origin:center center}.uni-load-more__img--android-H5>circle[data-v-e4933d8a]{display:inline-block;-webkit-animation:loading-android-H5-dash-data-v-e4933d8a 1.5s ease-in-out infinite;animation:loading-android-H5-dash-data-v-e4933d8a 1.5s ease-in-out infinite;stroke:currentColor;stroke-linecap:round}@-webkit-keyframes loading-android-H5-rotate-data-v-e4933d8a{0%{-webkit-transform:rotate(0deg);transform:rotate(0deg)}100%{-webkit-transform:rotate(1turn);transform:rotate(1turn)}}@keyframes loading-android-H5-rotate-data-v-e4933d8a{0%{-webkit-transform:rotate(0deg);transform:rotate(0deg)}100%{-webkit-transform:rotate(1turn);transform:rotate(1turn)}}@-webkit-keyframes loading-android-H5-dash-data-v-e4933d8a{0%{stroke-dasharray:1,200;stroke-dashoffset:0}50%{stroke-dasharray:90,150;stroke-dashoffset:-40}100%{stroke-dasharray:90,150;stroke-dashoffset:-120}}@keyframes loading-android-H5-dash-data-v-e4933d8a{0%{stroke-dasharray:1,200;stroke-dashoffset:0}50%{stroke-dasharray:90,150;stroke-dashoffset:-40}100%{stroke-dasharray:90,150;stroke-dashoffset:-120}}\n\n\n\n\n\n",""]),t.exports=a},ac76:function(t,a,e){"use strict";e.d(a,"b",(function(){return n})),e.d(a,"c",(function(){return s})),e.d(a,"a",(function(){return i}));var i={wanlPageBanner:e("e28a").default,wanlPageImage:e("f6e9").default,wanlPageVideo:e("0d68").default,wanlPageMenu:e("acba").default,wanlPageNotice:e("55be").default,wanlPageArticle:e("77d5").default,wanlPageHeadlines:e("bad0").default,wanlPageSearch:e("71f5").default,wanlPageActivity:e("c7b2").default,wanlPageCategoryTitle:e("0e6f").default,wanlPageClassify:e("5f88").default,wanlPageLikes:e("37d2").default,wanlPageGoods:e("feaf").default,wanlPageBargain:e("26cf").default,wanlPageSeckill:e("127e").default,wanlPageEmpty:e("b987").default,wanlPageDivision:e("1d0d").default,wanlProduct:e("becb").default,uniDrawer:e("ec27").default,uniLoadMore:e("635f").default},n=function(){var t=this,a=t.$createElement,e=t._self._c||a;return e("v-uni-view",{staticClass:"wanl-shop"},[e("v-uni-view",{staticClass:"wrap"},[e("v-uni-view",{staticClass:"bg-box",style:{backgroundImage:"url("+t.$wanlshop.oss(t.background,500,0,1,"transparent","png")+")"}}),e("v-uni-view",{staticClass:"gc-1"}),e("v-uni-view",{staticClass:"gc-2"}),e("v-uni-view",{staticClass:"gc-3"})],1),e("v-uni-view",{staticClass:"cu-bar tabbar foot wanl-gray-dark"},[e("v-uni-view",{staticClass:"action",on:{click:function(a){arguments[0]=a=t.$handleEvent(a),t.navChange("home")}}},["home"==t.pageCur?e("v-uni-view",[e("v-uni-view",{staticClass:"user-pic shadow-warp"},[e("v-uni-image",{attrs:{src:t.$wanlshop.oss(t.shopData.avatar,38,38,2,"avatar"),mode:"scaleToFill"}})],1)],1):e("v-uni-view",[e("v-uni-view",{staticClass:"wlIcon-31dianpu"}),e("v-uni-view",[t._v("首頁")])],1)],1),e("v-uni-view",{staticClass:"action",on:{click:function(a){arguments[0]=a=t.$handleEvent(a),t.navChange("allgoods")}}},[e("v-uni-view",{staticClass:"wlIcon-baobei",class:"allgoods"==t.pageCur?"text-orange":""}),e("v-uni-view",{class:"allgoods"==t.pageCur?"text-orange":""},[t._v("商品")])],1),e("v-uni-view",{staticClass:"action",on:{click:function(a){arguments[0]=a=t.$handleEvent(a),t.navChange("category")}}},[e("v-uni-view",{staticClass:"wlIcon-fenlei1",class:"category"==t.pageCur?"text-orange":""}),e("v-uni-view",{class:"category"==t.pageCur?"text-orange":""},[t._v("分類")])],1),e("v-uni-view",{staticClass:"action",on:{click:function(a){arguments[0]=a=t.$handleEvent(a),t.toChat(t.shop_id)}}},[e("v-uni-view",{staticClass:"wlIcon-kefu"}),e("v-uni-view",[t._v("客服")])],1)],1),10*t.Opacity>=3?e("v-uni-view",{staticClass:"sticky bg-orange",style:{paddingTop:t.wanlsys.top+"px",backgroundColor:t.pageData.page.style.navigationBarBackgroundColor,color:t.pageData.page.style.navigationBarTextStyle,opacity:t.Opacity}},[e("v-uni-view",{staticClass:"shop-search wanl-gray-dark",on:{click:function(a){arguments[0]=a=t.$handleEvent(a),t.search.apply(void 0,arguments)}}},[e("v-uni-text",{staticClass:"wlIcon-sousuo1 margin-right-xs"}),t._v("搜索店内商品")],1),t.pageType?e("v-uni-view",{staticClass:"shop-menu text-white"},[e("v-uni-view",{staticClass:"box"},[e("v-uni-view",{staticClass:"item",class:{select:0===t.filterIndex},on:{click:function(a){arguments[0]=a=t.$handleEvent(a),t.tabClick(0)}}},[t._v("主頁")]),e("v-uni-view",{staticClass:"item",class:{select:1===t.filterIndex},on:{click:function(a){arguments[0]=a=t.$handleEvent(a),t.tabClick(1)}}},[t._v("推薦")]),e("v-uni-view",{staticClass:"item",class:{select:2===t.filterIndex},on:{click:function(a){arguments[0]=a=t.$handleEvent(a),t.tabClick(2)}}},[t._v("銷量")]),e("v-uni-view",{staticClass:"item",class:{select:3===t.filterIndex},on:{click:function(a){arguments[0]=a=t.$handleEvent(a),t.tabClick(3)}}},[t._v("新品")]),e("v-uni-view",{staticClass:"item",class:{select:4===t.filterIndex},on:{click:function(a){arguments[0]=a=t.$handleEvent(a),t.tabClick(4)}}},[e("v-uni-text",[t._v("價格")]),e("v-uni-view",{staticClass:"icon"},[e("v-uni-text",{staticClass:"wlIcon-sheng",class:{active:1===t.priceOrder&&4===t.filterIndex}}),e("v-uni-text",{staticClass:"wlIcon-jiang",class:{active:2===t.priceOrder&&4===t.filterIndex}})],1)],1)],1),0!=t.filterIndex?e("v-uni-view",{staticClass:"text-lg",on:{click:function(a){arguments[0]=a=t.$handleEvent(a),t.editStyle()}}},["col-2-10"==t.listStyle?e("v-uni-text",{staticClass:"wlIcon-listing-jf"}):e("v-uni-text",{staticClass:"wlIcon-liebiao"})],1):t._e()],1):t._e()],1):t._e(),e("v-uni-view",{staticClass:"main",style:{top:t.wanlsys.top+"px"}},[e("v-uni-view",{staticClass:"header"},[e("v-uni-view",{staticClass:"text-white",staticStyle:{flex:"1"}},[e("v-uni-view",{staticClass:"title",on:{click:function(a){arguments[0]=a=t.$handleEvent(a),t.shopInfo.apply(void 0,arguments)}}},[t._v(t._s(t.shopData.shopname)),e("v-uni-text",{staticClass:"wlIcon-fangxiang2 margin-left-xs"})],1),e("v-uni-view",{staticClass:"describe text-min"},[e("v-uni-text",[t._v("粉丝數 "+t._s(t.$wanlshop.toFormat(t.shopData.like,"thousand")))])],1)],1),e("v-uni-view",{staticClass:"border-custom"},[t.shopData.follow?e("v-uni-text",{staticClass:"wlIcon-guanzhu3 wanl-red",on:{click:function(a){arguments[0]=a=t.$handleEvent(a),t.Tofollow.apply(void 0,arguments)}}}):e("v-uni-text",{staticClass:"wlIcon-guanzhu3",on:{click:function(a){arguments[0]=a=t.$handleEvent(a),t.Tofollow.apply(void 0,arguments)}}}),e("v-uni-text",{staticClass:"wlIcon-31guanbi",on:{click:function(a){arguments[0]=a=t.$handleEvent(a),t.$wanlshop.back(1)}}})],1)],1),t.pageType?[e("v-uni-view",{staticClass:"shop-search wanl-gray-dark margin-lr-bj",on:{click:function(a){arguments[0]=a=t.$handleEvent(a),t.search.apply(void 0,arguments)}}},[e("v-uni-text",{staticClass:"wlIcon-sousuo1 margin-right-xs"}),t._v(t._s(t.pageData.page.params.navigationBarTitleText))],1),e("v-uni-view",{staticClass:"shop-menu text-white margin-lr-bj margin-tb-sm"},[e("v-uni-view",{staticClass:"box"},[e("v-uni-view",{staticClass:"item",class:{select:0==t.filterIndex},on:{click:function(a){arguments[0]=a=t.$handleEvent(a),t.tabClick(0)}}},[t._v("主頁")]),e("v-uni-view",{staticClass:"item",class:{select:1==t.filterIndex},on:{click:function(a){arguments[0]=a=t.$handleEvent(a),t.tabClick(1)}}},[t._v("推薦")]),e("v-uni-view",{staticClass:"item",class:{select:2==t.filterIndex},on:{click:function(a){arguments[0]=a=t.$handleEvent(a),t.tabClick(2)}}},[t._v("銷量")]),e("v-uni-view",{staticClass:"item",class:{select:3==t.filterIndex},on:{click:function(a){arguments[0]=a=t.$handleEvent(a),t.tabClick(3)}}},[t._v("新品")]),e("v-uni-view",{staticClass:"item",class:{select:4==t.filterIndex},on:{click:function(a){arguments[0]=a=t.$handleEvent(a),t.tabClick(4)}}},[e("v-uni-text",[t._v("價格")]),e("v-uni-view",{staticClass:"icon"},[e("v-uni-text",{staticClass:"wlIcon-sheng",class:{active:1==t.priceOrder&&4==t.filterIndex}}),e("v-uni-text",{staticClass:"wlIcon-jiang",class:{active:2==t.priceOrder&&4==t.filterIndex}})],1)],1)],1),0!=t.filterIndex?e("v-uni-view",{staticClass:"text-lg",on:{click:function(a){arguments[0]=a=t.$handleEvent(a),t.editStyle()}}},["col-2-10"==t.listStyle?e("v-uni-text",{staticClass:"wlIcon-listing-jf"}):e("v-uni-text",{staticClass:"wlIcon-liebiao"})],1):t._e()],1),0==t.filterIndex?e("v-uni-view",{staticClass:"wanl-page"},t._l(t.pageData.item,(function(a,i){return e("v-uni-view",{key:a.type},["banner"==a.type?e("v-uni-view",[e("wanl-page-banner",{attrs:{pageData:a}})],1):t._e(),"image"==a.type?e("v-uni-view",[e("wanl-page-image",{attrs:{pageData:a}})],1):t._e(),"video"==a.type?e("v-uni-view",[e("wanl-page-video",{attrs:{pageData:a}})],1):t._e(),"menu"==a.type?e("v-uni-view",[e("wanl-page-menu",{attrs:{pageData:a}})],1):t._e(),"notice"==a.type?e("v-uni-view",[e("wanl-page-notice",{attrs:{pageData:a}})],1):t._e(),"article"==a.type?e("v-uni-view",[e("wanl-page-article",{attrs:{pageData:a}})],1):t._e(),"headlines"==a.type?e("v-uni-view",[e("wanl-page-headlines",{attrs:{pageData:a}})],1):t._e(),"search"==a.type?e("v-uni-view",[e("wanl-page-search",{attrs:{pageData:a}})],1):t._e(),"activity"==a.type?e("v-uni-view",[e("wanl-page-activity",{attrs:{pageData:a}})],1):t._e(),"categoryTitle"==a.type?e("v-uni-view",[e("wanl-page-category-title",{attrs:{pageData:a}})],1):t._e(),"classify"==a.type?e("v-uni-view",[e("wanl-page-classify",{attrs:{pageData:a}})],1):t._e(),"likes"==a.type?e("v-uni-view",[e("wanl-page-likes",{attrs:{pageData:a}})],1):t._e(),"goods"==a.type?e("v-uni-view",[e("wanl-page-goods",{attrs:{pageData:a}})],1):t._e(),"bargain"==a.type?e("v-uni-view",[e("wanl-page-bargain",{attrs:{pageData:a}})],1):t._e(),"seckill"==a.type?e("v-uni-view",[e("wanl-page-seckill",{attrs:{pageData:a}})],1):t._e(),"empty"==a.type?e("v-uni-view",[e("wanl-page-empty",{attrs:{pageData:a}})],1):t._e(),"division"==a.type?e("v-uni-view",[e("wanl-page-division",{attrs:{pageData:a}})],1):t._e()],1)})),1):[e("wanl-product",{attrs:{dataList:t.goodsData,dataStyle:t.listStyle}})]]:[e("v-uni-view",{staticClass:"shop-search wanl-gray-dark margin-lr-bj",on:{click:function(a){arguments[0]=a=t.$handleEvent(a),t.search.apply(void 0,arguments)}}},[e("v-uni-text",{staticClass:"wlIcon-sousuo1 margin-right-xs"}),t._v(t._s(t.pageData.page.params.navigationBarTitleText))],1),e("v-uni-view",{staticClass:"shop-category"},t._l(t.categoryData,(function(a,i){return e("v-uni-view",{key:a.id,staticClass:"item margin-bj radius-bock"},[0==a.childlist.length?e("v-uni-view",{staticClass:"nav margin-lr-bj",on:{click:function(e){arguments[0]=e=t.$handleEvent(e),t.productCategoryList(a.id,a.name)}}},[e("v-uni-text",{staticClass:"text-df"},[t._v(t._s(a.name))]),e("v-uni-text",{staticClass:"wlIcon-fanhui2"})],1):e("v-uni-view",{staticClass:"nav margin-lr-bj"},[e("v-uni-text",{staticClass:"text-df"},[t._v(t._s(a.name))])],1),0!=a.childlist.length?e("v-uni-view",{staticClass:"action margin-lr-bj"},[t._l(a.childlist,(function(a,i){return[0==a.childlist.length?e("v-uni-view",{key:a.id+"_0",staticClass:"padding-bj",on:{click:function(e){arguments[0]=e=t.$handleEvent(e),t.productCategoryList(a.id,a.name)}}},[e("v-uni-text",[t._v(t._s(a.name))])],1):e("v-uni-view",{staticClass:"padding-bj",on:{click:function(e){arguments[0]=e=t.$handleEvent(e),t.showDrawer(a.childlist)}}},[t._v(t._s(a.name)),e("v-uni-text",{staticClass:"wlIcon-fanhui2 margin-left"})],1)]}))],2):t._e()],1)})),1)],e("uni-drawer",{attrs:{visible:t.showRight,width:"75%",mode:"right"},on:{close:function(a){arguments[0]=a=t.$handleEvent(a),t.closeDrawer.apply(void 0,arguments)}}},[e("v-uni-view",{staticClass:"drawer"},[e("v-uni-view",{staticClass:"shop-category"},t._l(t.categoryChildlistData,(function(a,i){return e("v-uni-view",{key:a.id,staticClass:"item radius-bock"},[0==a.childlist.length?e("v-uni-view",{staticClass:"nav margin-lr-bj",on:{click:function(e){arguments[0]=e=t.$handleEvent(e),t.productCategoryList(a.id,a.name)}}},[e("v-uni-text",{staticClass:"text-df"},[t._v(t._s(a.name))]),e("v-uni-text",{staticClass:"wlIcon-fanhui2"})],1):e("v-uni-view",{staticClass:"nav margin-lr-bj"},[e("v-uni-text",{staticClass:"text-df"},[t._v(t._s(a.name))])],1),e("v-uni-view",{staticClass:"action margin-lr-bj"},[t._l(a.childlist,(function(a,i){return[0==a.childlist.length?e("v-uni-view",{key:a.id+"_0",staticClass:"padding-bj",on:{click:function(e){arguments[0]=e=t.$handleEvent(e),t.productCategoryList(a.id,a.name)}}},[e("v-uni-text",[t._v(t._s(a.name))])],1):e("v-uni-view",{staticClass:"padding-bj",on:{click:function(e){arguments[0]=e=t.$handleEvent(e),t.showDrawer(a.childlist)}}},[t._v(t._s(a.name)),e("v-uni-text",{staticClass:"wlIcon-fanhui2 margin-left"})],1)]}))],2)],1)})),1)],1)],1),e("uni-load-more",{attrs:{status:t.status,"content-text":t.contentText}})],2)],1)},s=[]},b109:function(t,a,e){"use strict";var i=e("4ea4");e("99af"),e("4de4"),e("4e82"),Object.defineProperty(a,"__esModule",{value:!0}),a.default=void 0,e("96cf");var n=i(e("1da1")),s={data:function(){return{shop_id:0,wanlsys:this.$wanlshop.wanlsys(),pageCur:"home",pageType:!0,pageData:{page:{params:{navigationBarTitleText:"搜尋店內商品"},style:{navigationBarBackgroundColor:"#ff4f00",navigationBarTextStyle:"#333"}}},shopData:{shopname:"加載中..",follow:!1,like:0},categoryData:[],categoryChildlistData:[],showRight:!1,Opacity:0,WanlScroll:0,scrollStype:!1,background:this.$wanlshop.appstc("/show/page_swiper.png"),filterIndex:0,goodsData:[],priceOrder:0,listStyle:"col-2-10",params:{search:"",sort:"weigh",order:"asc",page:1,filter:{},op:{}},reload:!1,last_page:0,status:"loading",contentText:{contentdown:"",contentrefresh:"正在加載..",contentnomore:"没有更多數據了"}}},onLoad:function(t){this.shop_id=t.id,this.params.filter={shop_id:this.shop_id},this.params.op={shop_id:"="},this.loadPageData(),t.type&&this.tabClick(t.type)},onPageScroll:function(t){var a=20+this.wanlsys.top;t.scrollTop=t.scrollTop>a?a:t.scrollTop,this.Opacity=t.scrollTop*(1/a)},onPullDownRefresh:function(){this.params.page=1,this.reload=!0,this.loadData()},onReachBottom:function(){this.params.page>=this.last_page?this.status="noMore":(this.reload=!1,this.contentText.contentdown="上拉顯示更多",this.params.page=this.params.page+1,this.status="loading",this.loadData())},onUnload:function(){if(this.showRight)return this.closeDrawer(),!0},methods:{loadData:function(){var t=this;return(0,n.default)(regeneratorRuntime.mark((function a(){return regeneratorRuntime.wrap((function(a){while(1)switch(a.prev=a.next){case 0:t.$api.get({url:"/wanlshop/product/lists",data:t.params,success:function(a){uni.stopPullDownRefresh(),t.status=0==a.total?"noMore":"more",t.goodsData=t.reload?a.data:t.goodsData.concat(a.data),0==a.data.length&&t.loadlikeData(),t.params.page=a.current_page,t.last_page=a.last_page}});case 1:case"end":return a.stop()}}),a)})))()},loadPageData:function(){var t=this;return(0,n.default)(regeneratorRuntime.mark((function a(){return regeneratorRuntime.wrap((function(a){while(1)switch(a.prev=a.next){case 0:t.$api.get({url:"/wanlshop/shop/page",data:{id:t.shop_id},success:function(a){t.status="more",t.shopData=a.shop,t.categoryData=a.category,a.page?(t.pageData=a.page,t.background=a.page.page.style.pageBackgroundImage):t.tabClick(1)}});case 1:case"end":return a.stop()}}),a)})))()},Tofollow:function(){var t=this;return(0,n.default)(regeneratorRuntime.mark((function a(){return regeneratorRuntime.wrap((function(a){while(1)switch(a.prev=a.next){case 0:t.shopData.follow=!t.shopData.follow,t.shopData.follow?(t.shopData.like+=1,t.$store.commit("statistics/dynamic",{concern:t.$store.state.statistics.dynamic.concern+1})):(t.shopData.like-=1,t.$store.commit("statistics/dynamic",{concern:t.$store.state.statistics.dynamic.concern-1})),t.$api.post({url:"/wanlshop/shop/follow",data:{id:t.shopData.id},success:function(a){t.shopData.follow=a}});case 3:case"end":return a.stop()}}),a)})))()},navChange:function(t){"home"==t?this.tabClick(0):"allgoods"==t&&this.tabClick(1),this.pageType="category"!=t,this.pageCur=t},tabClick:function(t){this.filterIndex===t&&4!==t||(this.priceOrder=4===t?1===this.priceOrder?2:1:0,this.filterIndex=t,0===t?this.loadPageData():(1===t&&(this.params.sort="weigh",this.params.order="asc"),2===t&&(this.params.sort="sales",this.params.order="asc"),3===t&&(this.params.sort="createtime",this.params.order="asc"),4===t&&1===this.priceOrder&&(this.params.sort="price",this.params.order="asc"),4===t&&2===this.priceOrder&&(this.params.sort="price",this.params.order="desc"),this.params.page=1,this.reload=!0,this.loadData()),this.status="loading",uni.pageScrollTo({duration:300,scrollTop:0}))},editStyle:function(){this.listStyle="col-1-10"==this.listStyle?"col-2-10":"col-1-10"},showDrawer:function(t){this.showRight=!0,this.categoryChildlistData=t},closeDrawer:function(){this.showRight=!1},productCategoryList:function(t,a){this.$wanlshop.to("productList?shop_id="+this.shop_id+"&category_id="+t+"&category_name="+a)},search:function(){this.$wanlshop.to("productList?shop_id="+this.shop_id,"fade-in",100)},shopInfo:function(){this.$wanlshop.to("info?shop_id="+this.shop_id)}}};a.default=s},c1f9:function(t,a,e){var i=e("24fb");a=i(!1),a.push([t.i,"\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\n\t/* 抽屉宽度\n */.uni-drawer[data-v-78866c42]{\ndisplay:block;\nposition:fixed;top:0;left:0;right:0;bottom:0;overflow:hidden;z-index:9999}.uni-drawer__content[data-v-78866c42]{\ndisplay:block;\nposition:absolute;top:0;bottom:0;background-color:#fff;-webkit-transition:-webkit-transform .3s ease;transition:-webkit-transform .3s ease;transition:transform .3s ease;transition:transform .3s ease,-webkit-transform .3s ease}.uni-drawer--left[data-v-78866c42]{left:0;-webkit-transform:translateX(-320px);transform:translateX(-320px)}.uni-drawer--right[data-v-78866c42]{right:0;-webkit-transform:translateX(320px);transform:translateX(320px)}.uni-drawer__content--visible[data-v-78866c42]{-webkit-transform:translateX(0);transform:translateX(0)}.uni-drawer__mask[data-v-78866c42]{\ndisplay:block;\nopacity:0;position:absolute;top:0;left:0;bottom:0;right:0;background-color:rgba(0,0,0,.4);-webkit-transition:opacity .3s;transition:opacity .3s}.uni-drawer__mask--visible[data-v-78866c42]{\ndisplay:block;\nopacity:1}",""]),t.exports=a},eaf8:function(t,a,e){"use strict";var i;e.d(a,"b",(function(){return n})),e.d(a,"c",(function(){return s})),e.d(a,"a",(function(){return i}));var n=function(){var t=this,a=t.$createElement,e=t._self._c||a;return e("v-uni-view",{staticClass:"uni-load-more",on:{click:function(a){arguments[0]=a=t.$handleEvent(a),t.onClick.apply(void 0,arguments)}}},[!t.webviewHide&&("circle"===t.iconType||"auto"===t.iconType&&"android"===t.platform)&&"loading"===t.status&&t.showIcon?e("svg",{staticClass:"uni-load-more__img uni-load-more__img--android-H5",style:{width:t.iconSize+"px",height:t.iconSize+"px"},attrs:{width:"24",height:"24",viewBox:"25 25 50 50"}},[e("circle",{style:{color:t.color},attrs:{cx:"50",cy:"50",r:"20",fill:"none","stroke-width":3}})]):!t.webviewHide&&"loading"===t.status&&t.showIcon?e("v-uni-view",{staticClass:"uni-load-more__img uni-load-more__img--ios-H5",style:{width:t.iconSize+"px",height:t.iconSize+"px"}},[e("v-uni-image",{attrs:{src:"data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAEAAAABACAYAAACqaXHeAAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyJpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuMy1jMDExIDY2LjE0NTY2MSwgMjAxMi8wMi8wNi0xNDo1NjoyNyAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENTNiAoV2luZG93cykiIHhtcE1NOkluc3RhbmNlSUQ9InhtcC5paWQ6QzlBMzU3OTlEOUM0MTFFOUI0NTZDNERBQURBQzI4RkUiIHhtcE1NOkRvY3VtZW50SUQ9InhtcC5kaWQ6QzlBMzU3OUFEOUM0MTFFOUI0NTZDNERBQURBQzI4RkUiPiA8eG1wTU06RGVyaXZlZEZyb20gc3RSZWY6aW5zdGFuY2VJRD0ieG1wLmlpZDpDOUEzNTc5N0Q5QzQxMUU5QjQ1NkM0REFBREFDMjhGRSIgc3RSZWY6ZG9jdW1lbnRJRD0ieG1wLmRpZDpDOUEzNTc5OEQ5QzQxMUU5QjQ1NkM0REFBREFDMjhGRSIvPiA8L3JkZjpEZXNjcmlwdGlvbj4gPC9yZGY6UkRGPiA8L3g6eG1wbWV0YT4gPD94cGFja2V0IGVuZD0iciI/Pt+ALSwAAA6CSURBVHja1FsLkFZV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",mode:"widthFix"}})],1):t._e(),e("v-uni-text",{staticClass:"uni-load-more__text",style:{color:t.color}},[t._v(t._s("more"===t.status?t.contentText.contentdown:"loading"===t.status?t.contentText.contentrefresh:t.contentText.contentnomore))])],1)},s=[]},ec27:function(t,a,e){"use strict";e.r(a);var i=e("3f33"),n=e("22c9");for(var s in n)"default"!==s&&function(t){e.d(a,t,(function(){return n[t]}))}(s);e("061e");var o,r=e("f0c5"),l=Object(r["a"])(n["default"],i["b"],i["c"],!1,null,"78866c42",null,!1,i["a"],o);a["default"]=l.exports},f33d:function(t,a,e){"use strict";e.r(a);var i=e("b109"),n=e.n(i);for(var s in i)"default"!==s&&function(t){e.d(a,t,(function(){return i[t]}))}(s);a["default"]=n.a},f5fe:function(t,a,e){"use strict";e.r(a);var i=e("96a3"),n=e.n(i);for(var s in i)"default"!==s&&function(t){e.d(a,t,(function(){return i[t]}))}(s);a["default"]=n.a}}]);