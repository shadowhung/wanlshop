(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["pages-user-money-withdraw"],{"21c3":function(t,e,n){var a=n("9ef7");"string"===typeof a&&(a=[[t.i,a,""]]),a.locals&&(t.exports=a.locals);var i=n("4f06").default;i("576c1fe4",a,!0,{sourceMap:!1,shadowMode:!1})},5603:function(t,e,n){"use strict";var a=n("21c3"),i=n.n(a);i.a},"78fd":function(t,e,n){"use strict";n.r(e);var a=n("f24b"),i=n.n(a);for(var s in a)"default"!==s&&function(t){n.d(e,t,(function(){return a[t]}))}(s);e["default"]=i.a},"9ef7":function(t,e,n){var a=n("24fb");e=a(!1),e.push([t.i,".wanl-withdraw .money .symbol[data-v-7602330a]{font-size:%?60?%;margin-right:%?10?%}.wanl-withdraw .money .price[data-v-7602330a]{display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-align:center;-webkit-align-items:center;align-items:center}.wanl-withdraw .money .price uni-input[data-v-7602330a]{\n\nwidth:100%;font-size:%?100?%}.wanl-withdraw .bank[data-v-7602330a]{display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-pack:justify;-webkit-justify-content:space-between;justify-content:space-between;-webkit-box-align:center;-webkit-align-items:center;align-items:center;background-color:#fff;padding:%?20?% %?25?%}.wanl-withdraw .bank uni-image[data-v-7602330a]{width:%?100?%;height:%?100?%;margin-right:%?25?%}.wanl-withdraw .bank .content[data-v-7602330a]{-webkit-box-flex:1;-webkit-flex:1;flex:1}",""]),t.exports=e},cc99:function(t,e,n){"use strict";n.r(e);var a=n("fed8"),i=n("78fd");for(var s in i)"default"!==s&&function(t){n.d(e,t,(function(){return i[t]}))}(s);n("5603");var o,c=n("f0c5"),l=Object(c["a"])(i["default"],a["b"],a["c"],!1,null,"7602330a",null,!1,a["a"],o);e["default"]=l.exports},f24b:function(t,e,n){"use strict";var a=n("4ea4");n("b680"),n("ac1f"),n("5319"),Object.defineProperty(e,"__esModule",{value:!0}),e.default=void 0,n("96cf");var i=a(n("1da1")),s={data:function(){return{bankData:null,usermoney:0,money:null,servicemoney:0,servicefee:0}},onLoad:function(){this.loadData()},methods:{loadData:function(){var t=this;return(0,i.default)(regeneratorRuntime.mark((function e(){return regeneratorRuntime.wrap((function(e){while(1)switch(e.prev=e.next){case 0:t.$api.post({url:"/wanlshop/pay/initialWithdraw",success:function(e){t.setMoney(e.money),t.bankData=e.bank,t.servicefee=e.servicefee}});case 1:case"end":return e.stop()}}),e)})))()},tips:function(){uni.showModal({title:"提示",content:"活動時間：2021.01.01--2021.12.31"})},withdraw:function(){var t=this;this.bankData?this.money<=0?this.$wanlshop.msg("請填寫正確金額"):this.money>this.usermoney?this.$wanlshop.msg("提現金額不能超過 "+this.usermoney+" NT$"):this.$api.post({url:"/wanlshop/pay/withdraw",data:{money:this.money,account_id:this.bankData.id},success:function(e){t.setMoney(e),t.$wanlshop.to("/pages/page/success?type=withdraw")}}):this.$wanlshop.msg("請選擇帳號")},setMoney:function(t){this.usermoney=t,this.$store.commit("user/setUserInfo",{money:t})},replaceInput:function(t){this.money=t.target.value,this.servicemoney=t.target.value>0?(t.target.value*this.servicefee/1e3).toFixed(2):0},emptyInput:function(){this.money=null},moneyAll:function(){this.money=this.usermoney},getCode:function(t){return t=t.replace(/\s+/g,""),t.substring(t.length-4)},getType:function(t){return["儲蓄卡","信用卡"][t]}}};e.default=s},fed8:function(t,e,n){"use strict";var a;n.d(e,"b",(function(){return i})),n.d(e,"c",(function(){return s})),n.d(e,"a",(function(){return a}));var i=function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("v-uni-view",{staticClass:"wanl-withdraw"},[n("v-uni-view",{staticClass:"edgeInsetTop"}),n("v-uni-view",{staticClass:"padding-tb-bj",on:{click:function(e){arguments[0]=e=t.$handleEvent(e),t.$wanlshop.to("/pages/user/bank/bank?choice=1")}}},[t.bankData?n("v-uni-view",{staticClass:"bank"},[n("v-uni-image",{attrs:{src:"/static/images/bank/"+t.bankData.bankCode+".png"}}),n("v-uni-view",{staticClass:"content"},[n("v-uni-text",[t._v(t._s(t.bankData.bankName))]),n("v-uni-view",{staticClass:"wanl-gray"},[n("v-uni-text",[t._v("尾號 "+t._s(t.getCode(t.bankData.cardCode))+" "+t._s(t.getType(t.bankData.cardType)))])],1)],1),n("v-uni-view",{staticClass:"action"},[n("v-uni-text",{staticClass:"wlIcon-fanhui2"})],1)],1):n("v-uni-view",{staticClass:"bank"},[n("v-uni-view",{staticClass:"content",staticStyle:{height:"80rpx","line-height":"80rpx"}},[n("v-uni-text",[t._v("選擇提現帳戶")])],1),n("v-uni-view",{staticClass:"action"},[n("v-uni-text",{staticClass:"wlIcon-fanhui2"})],1)],1)],1),n("v-uni-view",{staticClass:"padding-bj bg-white money"},[n("v-uni-view",{staticClass:"text-lg"},[n("v-uni-text",[t._v("提現金額")]),n("v-uni-text",{staticClass:"text-sm wanl-gray"},[t._v("（服務費率 2%）")])],1),n("v-uni-view",{staticClass:"margin-tb-bj price"},[n("v-uni-view",{staticClass:"symbol"},[n("v-uni-text",[t._v("NT$")])],1),n("v-uni-input",{attrs:{type:"digit",maxlength:"5",focus:!0},on:{input:function(e){arguments[0]=e=t.$handleEvent(e),t.replaceInput.apply(void 0,arguments)}}}),t.money?n("v-uni-view",{staticClass:"text-lg wanl-gray-light",on:{click:function(e){arguments[0]=e=t.$handleEvent(e),t.emptyInput.apply(void 0,arguments)}}},[n("v-uni-text",{staticClass:"wlIcon-shibai"})],1):t._e()],1),n("v-uni-view",{staticClass:"solid-top padding-top-bj"},[[n("v-uni-text",{staticClass:"wanl-gray-light"},[t._v("服務費")]),n("v-uni-text",{staticClass:"text-price text-orange margin-left-xs"},[t._v(t._s(t.servicemoney>0?t.servicemoney:"0.00"))]),n("v-uni-text",{staticStyle:{color:"green"},on:{click:function(e){arguments[0]=e=t.$handleEvent(e),t.tips.apply(void 0,arguments)}}},[t._v("（活動）")]),n("v-uni-text",{staticClass:"wanl-gray-light"},[t._v("，")])],n("v-uni-text",{staticClass:"wanl-gray-light"},[t._v("可用餘額")]),n("v-uni-text",{staticClass:"wanl-gray-light margin-lr-xs text-price"},[t._v(t._s(t.usermoney))]),t.usermoney>0?n("v-uni-text",{staticClass:"text-orange",on:{click:function(e){arguments[0]=e=t.$handleEvent(e),t.moneyAll.apply(void 0,arguments)}}},[t._v("全部")]):t._e()],2)],1),n("v-uni-view",{staticClass:"padding-bj margin-top"},[n("v-uni-button",{staticClass:"mix-btn wanl-bg-redorange",on:{click:function(e){arguments[0]=e=t.$handleEvent(e),t.withdraw.apply(void 0,arguments)}}},[t._v("提現")])],1),n("v-uni-view",{staticClass:"padding-bj bg-white money",staticStyle:{color:"red"}},[n("p",[t._v("溫馨提示：")]),n("p",[t._v("Shopptw或其合作之金流服務商僅在工作日處理提領需求，每一次提領需2至5個工作日的作業時間")])])],1)},s=[]}}]);