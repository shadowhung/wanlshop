(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["pages-user-setting-notice"],{"0997":function(t,e,s){"use strict";s.r(e);var n=s("0f1f"),a=s.n(n);for(var i in n)"default"!==i&&function(t){s.d(e,t,(function(){return n[t]}))}(i);e["default"]=a.a},"0f1f":function(t,e,s){"use strict";(function(t){var n=s("4ea4");Object.defineProperty(e,"__esModule",{value:!0}),e.default=void 0,s("96cf");var a=n(s("1da1")),i=n(s("5530")),u=s("2f62"),c={computed:(0,i.default)({},(0,u.mapState)(["user"])),methods:{loadData:function(e){var s=this;return(0,a.default)(regeneratorRuntime.mark((function e(){return regeneratorRuntime.wrap((function(e){while(1)switch(e.prev=e.next){case 0:t.log("需要修改Fastadmin User數據表，原生版本暂不可以同步"),uni.setStorageSync("wanlshop:user",s.$store.state.user);case 2:case"end":return e.stop()}}),e)})))()},pushs:function(t){var e={pushs:t.target.value};this.$store.commit("user/setUserInfo",e),this.loadData(e)},voice:function(t){var e={voice:t.target.value};this.$store.commit("user/setUserInfo",e),this.loadData(e)},shock:function(t){var e={shock:t.target.value};this.$store.commit("user/setUserInfo",e),this.loadData(e)}}};e.default=c}).call(this,s("5a52")["default"])},d678:function(t,e,s){"use strict";var n;s.d(e,"b",(function(){return a})),s.d(e,"c",(function(){return i})),s.d(e,"a",(function(){return n}));var a=function(){var t=this,e=t.$createElement,s=t._self._c||e;return s("v-uni-view",[s("v-uni-view",{staticClass:"edgeInsetTop"}),s("v-uni-view",{staticClass:"cu-form-group margin-top"},[s("v-uni-view",{staticClass:"title"},[t._v("横幅消息通知")]),s("v-uni-switch",{class:t.user.pushs?"checked":"",attrs:{checked:!!t.user.pushs},on:{change:function(e){arguments[0]=e=t.$handleEvent(e),t.pushs.apply(void 0,arguments)}}})],1),s("v-uni-view",{staticClass:"cu-form-group margin-top"},[s("v-uni-view",{staticClass:"title"},[t._v("系统聲音")]),s("v-uni-switch",{class:t.user.voice?"checked":"",attrs:{checked:!!t.user.voice},on:{change:function(e){arguments[0]=e=t.$handleEvent(e),t.voice.apply(void 0,arguments)}}})],1),s("v-uni-view",{staticClass:"cu-form-group "},[s("v-uni-view",{staticClass:"title"},[t._v("系统震動")]),s("v-uni-switch",{class:t.user.shock?"checked":"",attrs:{checked:!!t.user.shock},on:{change:function(e){arguments[0]=e=t.$handleEvent(e),t.shock.apply(void 0,arguments)}}})],1)],1)},i=[]},e49b:function(t,e,s){"use strict";s.r(e);var n=s("d678"),a=s("0997");for(var i in a)"default"!==i&&function(t){s.d(e,t,(function(){return a[t]}))}(i);var u,c=s("f0c5"),r=Object(c["a"])(a["default"],n["b"],n["c"],!1,null,"64d60c5c",null,!1,n["a"],u);e["default"]=r.exports}}]);