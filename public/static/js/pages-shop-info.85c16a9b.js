(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["pages-shop-info"],{4365:function(a,t,n){"use strict";n.r(t);var i=n("a363"),e=n("f549");for(var s in e)"default"!==s&&function(a){n.d(t,a,(function(){return e[a]}))}(s);var o,r=n("f0c5"),u=Object(r["a"])(e["default"],i["b"],i["c"],!1,null,"25098ac9",null,!1,i["a"],o);t["default"]=u.exports},4391:function(a,t,n){"use strict";var i=n("4ea4");n("ac1f"),n("5319"),Object.defineProperty(t,"__esModule",{value:!0}),t.default=void 0,n("96cf");var e=i(n("1da1")),s={data:function(){return{shopData:{}}},onLoad:function(a){this.loadPageData(a.shop_id)},methods:{loadPageData:function(a){var t=this;return(0,e.default)(regeneratorRuntime.mark((function n(){return regeneratorRuntime.wrap((function(n){while(1)switch(n.prev=n.next){case 0:t.$api.get({url:"/wanlshop/shop/page",data:{id:a},success:function(a){a.shop.bio=a.shop.bio.replace(/<img/g,"<img style='display: block;'"),t.shopData=a.shop}});case 1:case"end":return n.stop()}}),n)})))()},follow:function(){var a=this;return(0,e.default)(regeneratorRuntime.mark((function t(){return regeneratorRuntime.wrap((function(t){while(1)switch(t.prev=t.next){case 0:a.shopData.follow=!a.shopData.follow,a.shopData.follow?a.shopData.like+=1:a.shopData.like-=1,a.$api.post({url:"/wanlshop/shop/follow",data:{id:a.shopData.id},success:function(t){a.shopData.follow=t}});case 3:case"end":return t.stop()}}),t)})))()}}};t.default=s},a363:function(a,t,n){"use strict";var i;n.d(t,"b",(function(){return e})),n.d(t,"c",(function(){return s})),n.d(t,"a",(function(){return i}));var e=function(){var a=this,t=a.$createElement,n=a._self._c||t;return n("v-uni-view",{staticClass:"wanl-shop"},[n("v-uni-view",{staticClass:"edgeInsetTop"}),n("v-uni-view",{staticClass:"shop_synopsis bg-white"},[n("v-uni-view",{staticClass:"margin-left-bj shopuser"},[n("v-uni-view",{staticClass:"cu-avatar round margin-right lg",style:{backgroundImage:"url("+a.$wanlshop.oss(a.shopData.avatar,52,52,2,"avatar")+")"}}),n("v-uni-view",{},[n("v-uni-view",{staticClass:"text-df"},[a._v(a._s(a.shopData.shopname||"ロードの中..."))]),n("v-uni-view",{staticClass:"wanl-gray text-min"},[a._v("ファンの数 "+a._s(a.shopData.like))]),n("v-uni-view",{staticClass:"wanl-gray text-min"},[a._v(a._s(a.shopData.city))])],1)],1),n("v-uni-view",{staticClass:"margin-right-bj cu-btn round wanl-bg-orange margin-top",on:{click:function(t){arguments[0]=t=a.$handleEvent(t),a.follow.apply(void 0,arguments)}}},[a.shopData.follow?n("v-uni-text",[a._v("すでに關の註")]):n("v-uni-view",[n("v-uni-text",{staticClass:"wlIcon-yiguanzhu1"}),a._v("関心を持つ")],1)],1)],1),n("v-uni-view",{staticClass:"shop_info bg-white margin-top-bj padding-lr-bj"},[n("v-uni-view",{staticClass:"padding-tb-bj solid-bottom"},[a._v("店鋪介紹")])],1),n("v-uni-view",{staticClass:"bg-white padding-bj"},[n("v-uni-rich-text",{attrs:{nodes:a.shopData.bio}})],1)],1)},s=[]},f549:function(a,t,n){"use strict";n.r(t);var i=n("4391"),e=n.n(i);for(var s in i)"default"!==s&&function(a){n.d(t,a,(function(){return i[a]}))}(s);t["default"]=e.a}}]);