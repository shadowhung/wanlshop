(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["pages-user-setting-paypass"],{"011d":function(e,r,t){"use strict";t.r(r);var s=t("8a1e"),a=t.n(s);for(var n in s)"default"!==n&&function(e){t.d(r,e,(function(){return s[e]}))}(n);r["default"]=a.a},"706f":function(e,r,t){"use strict";var s;t.d(r,"b",(function(){return a})),t.d(r,"c",(function(){return n})),t.d(r,"a",(function(){return s}));var a=function(){var e=this,r=e.$createElement,t=e._self._c||r;return t("v-uni-view",[t("v-uni-view",{staticClass:"edgeInsetTop"}),t("v-uni-form",{on:{submit:function(r){arguments[0]=r=e.$handleEvent(r),e.formSubmit.apply(void 0,arguments)}}},[1==e.issetpass?t("v-uni-view",{staticClass:"cu-form-group"},[t("v-uni-view",{staticClass:"title"},[e._v("舊密碼")]),t("v-uni-input",{attrs:{placeholder:"請輸入舊密碼",type:"number",maxlength:"6",name:"oldpay",value:e.user.oldpay}})],1):e._e(),t("v-uni-view",{staticClass:"cu-form-group"},[t("v-uni-view",{staticClass:"title"},[e._v("新密碼")]),t("v-uni-input",{attrs:{placeholder:"請輸入新密碼",type:"number",maxlength:"6",name:"newpay",value:e.user.newpay}})],1),t("v-uni-view",{staticClass:"cu-form-group"},[t("v-uni-view",{staticClass:"title"},[e._v("確認新密碼")]),t("v-uni-input",{attrs:{placeholder:"請確認新密碼",type:"number",maxlength:"6",name:"renewpay",value:e.user.renewpay}})],1),t("v-uni-view",{staticClass:"padding-bj flex flex-direction"},[t("v-uni-button",{staticClass:"cu-btn wanl-bg-redorange margin-tb lg",attrs:{"form-type":"submit"}},[e._v("保存")])],1)],1)],1)},n=[]},"8a1e":function(e,r,t){"use strict";(function(e){var s=t("4ea4");Object.defineProperty(r,"__esModule",{value:!0}),r.default=void 0;var a=s(t("5530")),n=s(t("c319")),i=t("2f62"),u={computed:(0,a.default)({},(0,i.mapState)(["user"])),data:function(){return{gender:!0,genderdata:0,issetpass:0}},onLoad:function(){var e=this;this.$api.post({url:"/wanlshop/user/getpaypass",success:function(r){e.issetpass=r}}),this.gender=0==this.$store.state.user.gender,this.genderdata=this.$store.state.user.gender},methods:{logout:function(){var e=this;this.$api.get({url:"/wanlshop/user/logout",data:{client_id:uni.getStorageSync("wanlshop:chat_client_id")?uni.getStorageSync("wanlshop:chat_client_id"):null},success:function(r){e.$store.dispatch("user/logout"),e.$wanlshop.msg("退出成功"),e.$wanlshop.back(1)}})},DateChange:function(e){this.$store.state.user.birthday=e.detail.value},Gender:function(e){1==e.detail.value?(this.gender=!0,this.genderdata=0):(this.gender=!1,this.genderdata=1)},Avatar:function(){this.$wanlshop.to("/pages/user/portrait/portrait")},formSubmit:function(r){var t=this,s=[{name:"newpay",checkType:"string",checkRule:"6,6",errorMsg:"請輸入6位支付密碼"},{name:"renewpay",checkType:"string",checkRule:"6,6",errorMsg:"請輸入6位支付密碼"}],a=r.detail.value,i=n.default.check(a,s);if(e.log(a),a.newpay!=a.renewpay)return this.$wanlshop.msg("兩次密碼輸入不一致"),!1;i?this.$api.post({url:"/wanlshop/user/resetpass",data:a,success:function(e){t.$store.commit("user/setUserInfo",a),1==t.issetpass?t.$wanlshop.msg("修改成功"):t.$wanlshop.msg("添加成功")}}):this.$wanlshop.msg(n.default.error)}}};r.default=u}).call(this,t("5a52")["default"])},"996e":function(e,r,t){var s=t("ca77");"string"===typeof s&&(s=[[e.i,s,""]]),s.locals&&(e.exports=s.locals);var a=t("4f06").default;a("0ee77edb",s,!0,{sourceMap:!1,shadowMode:!1})},a0e6:function(e,r,t){"use strict";var s=t("996e"),a=t.n(s);a.a},c319:function(e,r,t){t("c975"),t("a9e3"),t("4d63"),t("ac1f"),t("25f0"),t("1276"),e.exports={error:"",check:function(e,r){for(var t=0;t<r.length;t++){if(!r[t].checkType)return!0;if(!r[t].name)return!0;if(!r[t].errorMsg)return!0;if(!e[r[t].name])return this.error=r[t].errorMsg,!1;switch(r[t].checkType){case"string":var s=new RegExp("^.{"+r[t].checkRule+"}$");if(!s.test(e[r[t].name]))return this.error=r[t].errorMsg,!1;break;case"int":s=new RegExp("^(-[1-9]|[1-9])[0-9]{"+r[t].checkRule+"}$");if(!s.test(e[r[t].name]))return this.error=r[t].errorMsg,!1;break;case"between":if(!this.isNumber(e[r[t].name]))return this.error=r[t].errorMsg,!1;var a=r[t].checkRule.split(",");if(a[0]=Number(a[0]),a[1]=Number(a[1]),e[r[t].name]>a[1]||e[r[t].name]<a[0])return this.error=r[t].errorMsg,!1;break;case"betweenD":s=/^-?[1-9][0-9]?$/;if(!s.test(e[r[t].name]))return this.error=r[t].errorMsg,!1;a=r[t].checkRule.split(",");if(a[0]=Number(a[0]),a[1]=Number(a[1]),e[r[t].name]>a[1]||e[r[t].name]<a[0])return this.error=r[t].errorMsg,!1;break;case"betweenF":s=/^-?[0-9][0-9]?.+[0-9]+$/;if(!s.test(e[r[t].name]))return this.error=r[t].errorMsg,!1;a=r[t].checkRule.split(",");if(a[0]=Number(a[0]),a[1]=Number(a[1]),e[r[t].name]>a[1]||e[r[t].name]<a[0])return this.error=r[t].errorMsg,!1;break;case"same":if(e[r[t].name]!=r[t].checkRule)return this.error=r[t].errorMsg,!1;break;case"notsame":if(e[r[t].name]==r[t].checkRule)return this.error=r[t].errorMsg,!1;break;case"email":s=/^\w+([-+.']\w+)*@\w+([-.]\w+)*\.\w+([-.]\w+)*$/;if(!s.test(e[r[t].name]))return this.error=r[t].errorMsg,!1;break;case"phoneno":s=/^[0-9]{8,15}$/;if(!s.test(e[r[t].name]))return this.error=r[t].errorMsg,!1;break;case"zipcode":s=/^[0-9]{6}$/;if(!s.test(e[r[t].name]))return this.error=r[t].errorMsg,!1;break;case"reg":s=new RegExp(r[t].checkRule);if(!s.test(e[r[t].name]))return this.error=r[t].errorMsg,!1;break;case"in":if(-1==r[t].checkRule.indexOf(e[r[t].name]))return this.error=r[t].errorMsg,!1;break;case"notnull":if(null==e[r[t].name]||e[r[t].name].length<1)return this.error=r[t].errorMsg,!1;break}}return!0},isNumber:function(e){var r=/^-?[1-9][0-9]?.?[0-9]*$/;return r.test(e)}}},ca77:function(e,r,t){var s=t("24fb");r=s(!1),r.push([e.i,".cu-form-group .title[data-v-56e42fe4]{min-width:calc(4em + 15px)}",""]),e.exports=r},f837:function(e,r,t){"use strict";t.r(r);var s=t("706f"),a=t("011d");for(var n in a)"default"!==n&&function(e){t.d(r,e,(function(){return a[e]}))}(n);t("a0e6");var i,u=t("f0c5"),o=Object(u["a"])(a["default"],s["b"],s["c"],!1,null,"56e42fe4",null,!1,s["a"],i);r["default"]=o.exports}}]);