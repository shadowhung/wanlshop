(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["pages-notice-notice"],{1229:function(t,i,a){var n=a("8883");"string"===typeof n&&(n=[[t.i,n,""]]),n.locals&&(t.exports=n.locals);var e=a("4f06").default;e("f697017a",n,!0,{sourceMap:!1,shadowMode:!1})},"253d":function(t,i,a){"use strict";Object.defineProperty(i,"__esModule",{value:!0}),i.default=void 0;var n={name:"WanlEmpty",props:{src:{type:String,default:""},text:{type:String,default:"沒有找到任何內容"}}};i.default=n},"7e9f":function(t,i,a){"use strict";a.d(i,"b",(function(){return e})),a.d(i,"c",(function(){return s})),a.d(i,"a",(function(){return n}));var n={wanlEmpty:a("b5754").default},e=function(){var t=this,i=t.$createElement,a=t._self._c||i;return a("v-uni-view",{staticClass:"notice"},[a("v-uni-view",{staticClass:"cu-custom",style:{height:t.wanlsys.height+"px"}},[a("v-uni-view",{staticClass:"cu-bar fixed bg-bgcolor",style:{height:t.wanlsys.height+"px",paddingTop:t.wanlsys.top+"px"}},[a("v-uni-view",{staticClass:"action"},[a("v-uni-text",{staticClass:"wlIcon-fanhui1",staticStyle:{"margin-left":"0"},on:{click:function(i){arguments[0]=i=t.$handleEvent(i),t.$wanlshop.back(1)}}})],1),a("v-uni-view",{staticClass:"content",style:{top:t.wanlsys.top+"px"}},[t._v("メッセージセンター")]),a("v-uni-view",{staticClass:"action"},[a("v-uni-text",{staticClass:"wlIcon-qingkong",on:{click:function(i){arguments[0]=i=t.$handleEvent(i),t.empty()}}}),a("v-uni-text",{staticClass:"wlIcon-shezhi",on:{click:function(i){arguments[0]=i=t.$handleEvent(i),t.$wanlshop.to("/pages/user/setting/notice")}}})],1)],1)],1),a("v-uni-view",{staticClass:"wanl-notice bg-bgcolor"},[a("v-uni-view",{staticClass:"tool"},[t.statistics.notice.chat>0?a("v-uni-view",{staticClass:"text-sm margin-right"},[t._v(t._s(t.statistics.notice.chat)+"論文 未読メッセージ")]):a("v-uni-view",{staticClass:"text-sm margin-right"},[t._v("未読メッセージはありません")])],1),a("v-uni-view",{staticClass:"mode padding-bj"},[a("v-uni-view",{staticClass:"flex text-sm wanl-pip shadow-warp"},[a("v-uni-view",{staticClass:"logistics",on:{click:function(i){arguments[0]=i=t.$handleEvent(i),t.$wanlshop.auth("/pages/notice/logistics/logistics")}}},[a("v-uni-text",{staticClass:"wlIcon-wuliuqiache2"}),t._v("ぶつりゅう"),0!=t.statistics.notice.order?a("v-uni-view",{staticClass:"cu-tag badge"},[t._v(t._s(t.statistics.notice.order))]):t._e()],1),a("v-uni-view",{staticClass:"notice",on:{click:function(i){arguments[0]=i=t.$handleEvent(i),t.$wanlshop.auth("/pages/notice/notify/notify")}}},[a("v-uni-text",{staticClass:"wlIcon-tongzhi"}),t._v("通知する"),0!=t.statistics.notice.notice?a("v-uni-view",{staticClass:"cu-tag badge"},[t._v(t._s(t.statistics.notice.notice))]):t._e()],1),a("v-uni-view",{staticClass:"Interaction",on:{click:function(i){arguments[0]=i=t.$handleEvent(i),t.$wanlshop.to("/pages/notice/system/system")}}},[a("v-uni-text",{staticClass:"wlIcon-liuyan-fill"}),t._v("システム")],1)],1)],1)],1),0!=t.chat.list.length?a("v-uni-view",{staticClass:"wanl-msg"},[a("v-uni-view",{staticClass:"cu-list menu-avatar"},t._l(t.chat.list,(function(i,n){return a("v-uni-view",{key:n,staticClass:"cu-item",class:t.modalName=="move-box-"+i.id?"move-cur":"",attrs:{"data-target":"move-box-"+i.id},on:{touchstart:function(i){arguments[0]=i=t.$handleEvent(i),t.ListTouchStart.apply(void 0,arguments)},touchmove:function(i){arguments[0]=i=t.$handleEvent(i),t.ListTouchMove.apply(void 0,arguments)},touchend:function(i){arguments[0]=i=t.$handleEvent(i),t.ListTouchEnd.apply(void 0,arguments)},click:function(a){arguments[0]=a=t.$handleEvent(a),t.toChat(i.id)}}},[a("v-uni-view",{staticClass:"cu-avatar round lg",style:{backgroundImage:"url("+t.$wanlshop.oss(i.avatar,100,100)+")"}}),a("v-uni-view",{staticClass:"content"},[a("v-uni-view",{staticClass:"wanl-black"},[t._v(t._s(i.name))]),a("v-uni-view",{staticClass:"wanl-gray text-sm flex"},[a("v-uni-view",{staticClass:"text-cut wanl-gray-light"},[t._v(t._s(i.content))])],1)],1),a("v-uni-view",{staticClass:"action"},[a("v-uni-view",{staticClass:"text-gray text-sm"},[t._v(t._s(t.$wanlshop.timeToChat(i.createtime)))]),i.count>0?a("v-uni-view",{staticClass:"cu-tag bg-red"},[t._v(t._s(i.count))]):t._e()],1),a("v-uni-view",{staticClass:"move"},[a("v-uni-view",{staticClass:"bg-red",on:{click:function(i){i.stopPropagation(),arguments[0]=i=t.$handleEvent(i),t.del(n)}}},[t._v("ローカルを削除")])],1)],1)})),1)],1):a("wanl-empty",{attrs:{src:"notice_default3x",text:"まだニュースはありません"}}),a("v-uni-view",{staticClass:"edgeInsetBottom"})],1)},s=[]},8740:function(t,i,a){"use strict";var n=a("4ea4");Object.defineProperty(i,"__esModule",{value:!0}),i.default=void 0;var e=n(a("5530")),s=a("2f62"),c={data:function(){return{wanlsys:this.$wanlshop.wanlsys(),modalName:null,listTouchStart:0,listTouchDirection:null}},computed:(0,e.default)({},(0,s.mapState)(["chat","statistics"])),methods:(0,e.default)((0,e.default)({},(0,s.mapActions)({del:"chat/del",empty:"chat/empty"})),{},{ListTouchStart:function(t){this.listTouchStart=t.touches[0].pageX},ListTouchMove:function(t){this.listTouchDirection=t.touches[0].pageX-this.listTouchStart>0?"right":"left"},ListTouchEnd:function(t){"left"==this.listTouchDirection?this.modalName=t.currentTarget.dataset.target:this.modalName=null,this.listTouchDirection=null}})};i.default=c},8883:function(t,i,a){var n=a("24fb");i=n(!1),i.push([t.i,".cu-bar .search-form[data-v-57b4220a]{background-color:#f2f2f2}\n\n",""]),t.exports=i},a083:function(t,i,a){var n=a("24fb");i=n(!1),i.push([t.i,".empty-content[data-v-c168e81c]{display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-align:center;-webkit-align-items:center;align-items:center;-webkit-box-pack:center;-webkit-justify-content:center;justify-content:center;width:100%;padding:%?300?% %?130?%}.empty-content uni-image[data-v-c168e81c]{width:%?320?%;height:%?320?%}",""]),t.exports=i},b1c1:function(t,i,a){"use strict";var n=a("1229"),e=a.n(n);e.a},b5754:function(t,i,a){"use strict";a.r(i);var n=a("b933"),e=a("ed9c");for(var s in e)"default"!==s&&function(t){a.d(i,t,(function(){return e[t]}))}(s);a("c7c5");var c,o=a("f0c5"),l=Object(o["a"])(e["default"],n["b"],n["c"],!1,null,"c168e81c",null,!1,n["a"],c);i["default"]=l.exports},b933:function(t,i,a){"use strict";var n;a.d(i,"b",(function(){return e})),a.d(i,"c",(function(){return s})),a.d(i,"a",(function(){return n}));var e=function(){var t=this,i=t.$createElement,a=t._self._c||i;return a("v-uni-view",{staticClass:"empty-content"},[a("v-uni-view",{staticClass:"wanl-gray text-center"},[a("v-uni-image",{staticClass:"animation-scale-down",attrs:{src:t.src?t.$wanlshop.appstc("/default/"+t.src+".png"):t.$wanlshop.appstc("/default/default3x.png")}}),a("v-uni-view",{staticClass:"text-30"},[t._v(t._s(t.text))])],1)],1)},s=[]},bea0:function(t,i,a){var n=a("a083");"string"===typeof n&&(n=[[t.i,n,""]]),n.locals&&(t.exports=n.locals);var e=a("4f06").default;e("58f621c7",n,!0,{sourceMap:!1,shadowMode:!1})},c7c5:function(t,i,a){"use strict";var n=a("bea0"),e=a.n(n);e.a},cdc9:function(t,i,a){"use strict";a.r(i);var n=a("8740"),e=a.n(n);for(var s in n)"default"!==s&&function(t){a.d(i,t,(function(){return n[t]}))}(s);i["default"]=e.a},e941:function(t,i,a){"use strict";a.r(i);var n=a("7e9f"),e=a("cdc9");for(var s in e)"default"!==s&&function(t){a.d(i,t,(function(){return e[t]}))}(s);a("b1c1");var c,o=a("f0c5"),l=Object(o["a"])(e["default"],n["b"],n["c"],!1,null,"57b4220a",null,!1,n["a"],c);i["default"]=l.exports},ed9c:function(t,i,a){"use strict";a.r(i);var n=a("253d"),e=a.n(n);for(var s in n)"default"!==s&&function(t){a.d(i,t,(function(){return n[t]}))}(s);i["default"]=e.a}}]);