(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["pages-user-refund-apply"],{"0ade":function(t,e,n){"use strict";n.r(e);var a=n("98d2"),s=n("a415");for(var i in s)"default"!==i&&function(t){n.d(e,t,(function(){return s[t]}))}(i);n("317e");var o,r=n("f0c5"),u=Object(r["a"])(s["default"],a["b"],a["c"],!1,null,"5a3625f0",null,!1,a["a"],o);e["default"]=u.exports},1655:function(t,e,n){"use strict";var a=n("4ea4");n("99af"),n("a434"),n("e25e"),Object.defineProperty(e,"__esModule",{value:!0}),e.default=void 0,n("96cf");var s=a(n("1da1")),i={data:function(){return{freight_type:0,goods:{},expressList:["未收到貨","已收到貨"],typeList:["我要退款(無需退貨)","退貨退款"],reasonList:["不喜歡","空包裹","一直未送达","颜色/尺碼不符","质量问题","少件漏發","假冒品牌"],refund:{order_id:0,expressType:-1,type:-1,reason:-1,goods:0,money:0,images:[],refund_content:""},amount:{total:0,placeholder:"",info:""}}},onLoad:function(t){var e=JSON.parse(t.data);if(this.goods=e.goods,this.refund.order_id=e.order_id,this.refund.goods=e.goods.id,this.freight_type=e.freight_type,this.goods_number=e.goods_number,1==this.goods_number||2==this.freight_type){var n=this.$wanlshop.bcadd(this.$wanlshop.bcsub(this.$wanlshop.bcmul(e.goods.price,e.goods.number),e.discount_price),e.goods.freight_price),a="最多￥".concat(n);parseInt(e.discount_price)>0&&(a+="，其中总额￥".concat(this.$wanlshop.bcmul(e.goods.price,e.goods.number),"，優惠￥").concat(e.discount_price)),parseInt(e.goods.freight_price)>0&&(a+="，运费￥".concat(e.goods.freight_price)),this.amount.info=a,this.amount.placeholder="退款不能超过 ￥".concat(n," 元"),this.amount.total=n}else{var s=this.$wanlshop.bcsub(this.$wanlshop.bcmul(e.goods.price,e.goods.number),e.discount_price),i="最多￥".concat(s);parseInt(e.discount_price)>0&&(i+="，其中总额￥".concat(this.$wanlshop.bcmul(e.goods.price,e.goods.number),"，優惠￥").concat(e.discount_price)),parseInt(e.goods.freight_price)>0&&(i+="，策略策略不包含运费￥".concat(e.goods.freight_price)),this.amount.info=i,this.amount.placeholder="退款不能超过 ￥".concat(s," 元"),this.amount.total=s}},methods:{addData:function(){var t=this;return(0,s.default)(regeneratorRuntime.mark((function e(){return regeneratorRuntime.wrap((function(e){while(1)switch(e.prev=e.next){case 0:if(!(t.refund.money<0)){e.next=3;break}return t.$wanlshop.msg("退款金额不能小於 0元"),e.abrupt("return",!1);case 3:if(!(t.refund.money>t.amount.total)){e.next=6;break}return t.$wanlshop.msg(t.amount.info),e.abrupt("return",!1);case 6:t.$api.post({url:"/wanlshop/refund/addApply",data:t.refund,success:function(e){t.$store.commit("statistics/order",{customer:t.$store.state.statistics.order.customer+1}),t.$wanlshop.to("/pages/user/refund/details?id=".concat(e))}});case 7:case"end":return e.stop()}}),e)})))()},chooseImage:function(t){var e=this;uni.chooseImage({count:4,sizeType:["original","compressed"],sourceType:["album"],success:function(t){e.$api.get({url:"/wanlshop/common/uploadData",success:function(n){for(var a=0;a<t.tempFilePaths.length;a++)uni.getImageInfo({src:t.tempFilePaths[a],success:function(t){e.$api.upload({url:n.uploadurl,filePath:t.path,name:"file",formData:"local"==n.storage?null:n.multipart,success:function(t){e.refund.images.push(t.fullurl)}})}})}})}})},expressChange:function(t){this.refund.expressType=t.detail.value},typeChange:function(t){this.refund.type=t.detail.value},reasonChange:function(t){this.refund.reason=t.detail.value},moneyInput:function(t){var e=t.detail.value;e>this.amount.total&&this.$wanlshop.msg(this.amount.info),this.refund.money=t.detail.value},viewImage:function(t){uni.previewImage({urls:this.refund.images,current:this.refund.images[t]})},delImg:function(t){this.refund.images.splice(t,1)}}};e.default=i},"2a47":function(t,e,n){var a=n("b0aa");"string"===typeof a&&(a=[[t.i,a,""]]),a.locals&&(t.exports=a.locals);var s=n("4f06").default;s("3a6fec5c",a,!0,{sourceMap:!1,shadowMode:!1})},"317e":function(t,e,n){"use strict";var a=n("2a47"),s=n.n(a);s.a},"98d2":function(t,e,n){"use strict";var a;n.d(e,"b",(function(){return s})),n.d(e,"c",(function(){return i})),n.d(e,"a",(function(){return a}));var s=function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("v-uni-view",[n("v-uni-view",{staticClass:"edgeInsetTop"}),n("v-uni-view",{staticClass:"bg-white padding-bj flex"},[n("v-uni-view",{staticClass:"cu-avatar xl margin-right-bj",style:{backgroundImage:"url("+t.$wanlshop.oss(t.goods.image,70,70)+")"}}),n("v-uni-view",{staticClass:"text-sm",staticStyle:{width:"calc(100% - 128rpx)"}},[n("v-uni-view",{staticClass:"margin-bottom-xs"},[n("v-uni-view",{staticClass:"text-cut-2"},[t._v(t._s(t.goods.title))])],1),n("v-uni-view",{staticClass:"wanl-gray"},[t._v("规格："+t._s(t.goods.difference))])],1)],1),n("v-uni-view",{staticClass:"margin-top-bj"},[n("v-uni-view",{staticClass:"cu-form-group"},[n("v-uni-view",{staticClass:"title"},[t._v("物流状态")]),n("v-uni-picker",{attrs:{value:t.refund.expressType,range:t.expressList},on:{change:function(e){arguments[0]=e=t.$handleEvent(e),t.expressChange.apply(void 0,arguments)}}},[n("v-uni-view",{staticClass:"picker"},[t.refund.expressType>-1?n("v-uni-text",[t._v(t._s(t.expressList[t.refund.expressType]))]):n("v-uni-text",{staticClass:"wanl-gray-light"},[t._v("是否收到貨")])],1)],1)],1),n("v-uni-view",{staticClass:"cu-form-group"},[n("v-uni-view",{staticClass:"title"},[t._v("退款類型")]),n("v-uni-picker",{attrs:{value:t.refund.type,range:t.typeList},on:{change:function(e){arguments[0]=e=t.$handleEvent(e),t.typeChange.apply(void 0,arguments)}}},[n("v-uni-view",{staticClass:"picker"},[t.refund.type>-1?n("v-uni-text",[t._v(t._s(t.typeList[t.refund.type]))]):n("v-uni-text",{staticClass:"wanl-gray-light"},[t._v("选择退款類型")])],1)],1)],1),n("v-uni-view",{staticClass:"cu-form-group"},[n("v-uni-view",{staticClass:"title"},[t._v("退款原因")]),n("v-uni-picker",{attrs:{value:t.refund.reason,range:t.reasonList},on:{change:function(e){arguments[0]=e=t.$handleEvent(e),t.reasonChange.apply(void 0,arguments)}}},[n("v-uni-view",{staticClass:"picker"},[t.refund.reason>-1?n("v-uni-text",[t._v(t._s(t.reasonList[t.refund.reason]))]):n("v-uni-text",{staticClass:"wanl-gray-light"},[t._v("退款的原因")])],1)],1)],1),n("v-uni-view",{staticClass:"cu-form-group margin-top-bj"},[n("v-uni-view",{staticClass:"title"},[t._v("退款金额"),n("v-uni-text",{staticClass:"text-price margin-left-xs"})],1),n("v-uni-input",{attrs:{type:"digit",placeholder:t.amount.placeholder,disabled:0==t.amount.total},on:{input:function(e){arguments[0]=e=t.$handleEvent(e),t.moneyInput.apply(void 0,arguments)}}})],1),n("v-uni-view",{staticClass:"bg-white margin-top-bj"},[n("v-uni-view",{staticClass:"cu-form-group"},[n("v-uni-view",{staticClass:"title"},[t._v("上傳凭證")])],1),n("v-uni-view",{staticClass:"grid col-4 grid-square flex-sub padding-lr"},[t._l(t.refund.images,(function(e,a){return n("v-uni-view",{key:a,staticClass:"bg-img",on:{click:function(e){arguments[0]=e=t.$handleEvent(e),t.viewImage(a)}}},[n("v-uni-image",{attrs:{src:t.$wanlshop.oss(e,90,90),mode:"aspectFill"}}),n("v-uni-view",{staticClass:"cu-tag bg-red",on:{click:function(e){e.stopPropagation(),arguments[0]=e=t.$handleEvent(e),t.delImg(a)}}},[n("v-uni-text",{staticClass:"wlIcon-31guanbi"})],1)],1)})),t.refund.images.length<4?n("v-uni-view",{staticClass:"dashed",on:{click:function(e){arguments[0]=e=t.$handleEvent(e),t.chooseImage.apply(void 0,arguments)}}},[n("v-uni-text",{staticClass:"wlIcon-31paishe"})],1):t._e()],2)],1),n("v-uni-view",{staticClass:"cu-form-group margin-top-bj"},[n("v-uni-view",{staticClass:"title"},[t._v("退款理由")]),n("v-uni-input",{attrs:{placeholder:"选填"},model:{value:t.refund.refund_content,callback:function(e){t.$set(t.refund,"refund_content",e)},expression:"refund.refund_content"}})],1)],1),n("v-uni-view",{staticClass:"edgeInsetBottom"}),n("v-uni-view",{staticClass:"wanlian cu-bar tabbar foot flex flex-direction"},[n("v-uni-button",{staticClass:"cu-btn wanl-bg-orange lg",on:{click:function(e){arguments[0]=e=t.$handleEvent(e),t.addData.apply(void 0,arguments)}}},[t._v("确认")])],1)],1)},i=[]},a415:function(t,e,n){"use strict";n.r(e);var a=n("1655"),s=n.n(a);for(var i in a)"default"!==i&&function(t){n.d(e,t,(function(){return a[t]}))}(i);e["default"]=s.a},b0aa:function(t,e,n){var a=n("24fb");e=a(!1),e.push([t.i,".dashed[data-v-5a3625f0]::after{border:1px dashed #666}.cu-btn.lg[data-v-5a3625f0]{width:calc(100% - %?50?%)}",""]),t.exports=e}}]);