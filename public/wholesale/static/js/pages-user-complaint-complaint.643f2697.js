(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["pages-user-complaint-complaint"],{"0189":function(t,e,i){"use strict";i.r(e);var n=i("8750"),a=i("b6e9");for(var o in a)"default"!==o&&function(t){i.d(e,t,(function(){return a[t]}))}(o);i("57c2");var c,s=i("f0c5"),l=Object(s["a"])(a["default"],n["b"],n["c"],!1,null,"418347dd",null,!1,n["a"],c);e["default"]=l.exports},4526:function(t,e,i){var n=i("dc4c");"string"===typeof n&&(n=[[t.i,n,""]]),n.locals&&(t.exports=n.locals);var a=i("4f06").default;a("359b2484",n,!0,{sourceMap:!1,shadowMode:!1})},"57c2":function(t,e,i){"use strict";var n=i("4526"),a=i.n(n);a.a},8750:function(t,e,i){"use strict";var n;i.d(e,"b",(function(){return a})),i.d(e,"c",(function(){return o})),i.d(e,"a",(function(){return n}));var a=function(){var t=this,e=t.$createElement,i=t._self._c||e;return i("v-uni-view",[i("v-uni-view",{staticClass:"edgeInsetTop"}),i("v-uni-view",{staticClass:"complaint-title"},[i("v-uni-view",[t._v("舉報"+t._s(t.typeName)+"理由")]),i("v-uni-view",{staticClass:"complaint-quick text-red"},[i("v-uni-text",{staticClass:"margin-right-xs"},[t._v(t._s(t.typeName)+"ID:"+t._s(t.complaintId))])],1)],1),i("v-uni-view",{staticClass:"cu-form-group"},[i("v-uni-picker",{attrs:{value:t.complaint.reason,range:t.picker},on:{change:function(e){arguments[0]=e=t.$handleEvent(e),t.pickerChange.apply(void 0,arguments)}}},[i("v-uni-view",{staticClass:"picker"},[t._v(t._s(t.complaint.reason>-1?t.picker[t.complaint.reason]:"請选择舉報理由"))])],1)],1),i("v-uni-view",{staticClass:"complaint-title"},[i("v-uni-text",[t._v(t._s(t.typeName)+"舉報截图")])],1),i("v-uni-view",{staticClass:"cu-bar bg-white"},[i("v-uni-view",{staticClass:"action"},[t._v("点击预覽图片")]),i("v-uni-view",{staticClass:"action"},[t._v(t._s(t.complaint.images.length)+"/8")])],1),i("v-uni-view",{staticClass:"cu-form-group"},[i("v-uni-view",{staticClass:"grid col-4 grid-square flex-sub"},[t._l(t.complaint.images,(function(e,n){return i("v-uni-view",{key:n,staticClass:"bg-img"},[i("v-uni-image",{attrs:{src:e,mode:"aspectFill"},on:{click:function(e){arguments[0]=e=t.$handleEvent(e),t.previewImage(t.complaint.images,n)}}}),i("v-uni-view",{staticClass:"cu-tag bg-red",on:{click:function(e){e.stopPropagation(),arguments[0]=e=t.$handleEvent(e),t.close(n)}}},[i("v-uni-text",{staticClass:"wlIcon-shanchu2"})],1)],1)})),t.complaint.images.length<8?i("v-uni-view",{staticClass:"solids",on:{click:function(e){arguments[0]=e=t.$handleEvent(e),t.chooseImg.apply(void 0,arguments)}}},[i("v-uni-text",{staticClass:"wlIcon-31paishe"})],1):t._e()],2)],1),i("v-uni-view",{staticClass:"complaint-title"},[i("v-uni-view",[t._v(t._s(t.typeName)+"舉報詳情")])],1),i("v-uni-view",{staticClass:"cu-form-group"},[i("v-uni-textarea",{attrs:{maxlength:"-1","placeholder-class":"placeholder",placeholder:"請詳細描述舉報内容..."},model:{value:t.complaint.content,callback:function(e){t.$set(t.complaint,"content",e)},expression:"complaint.content"}})],1),i("v-uni-view",{staticClass:"wanlian cu-bar tabbar foot flex flex-direction"},[i("v-uni-button",{staticClass:"cu-btn wanl-bg-redorange lg",on:{click:function(e){arguments[0]=e=t.$handleEvent(e),t.submit.apply(void 0,arguments)}}},[t._v("發起舉報")])],1)],1)},o=[]},b6e9:function(t,e,i){"use strict";i.r(e);var n=i("fdb6"),a=i.n(n);for(var o in n)"default"!==o&&function(t){i.d(e,t,(function(){return n[t]}))}(o);e["default"]=a.a},b85c:function(t,e,i){"use strict";i("a4d3"),i("e01a"),i("d28b"),i("d3b7"),i("3ca3"),i("ddb0"),Object.defineProperty(e,"__esModule",{value:!0}),e.default=o;var n=a(i("06c5"));function a(t){return t&&t.__esModule?t:{default:t}}function o(t,e){var i;if("undefined"===typeof Symbol||null==t[Symbol.iterator]){if(Array.isArray(t)||(i=(0,n.default)(t))||e&&t&&"number"===typeof t.length){i&&(t=i);var a=0,o=function(){};return{s:o,n:function(){return a>=t.length?{done:!0}:{done:!1,value:t[a++]}},e:function(t){throw t},f:o}}throw new TypeError("Invalid attempt to iterate non-iterable instance.\nIn order to be iterable, non-array objects must have a [Symbol.iterator]() method.")}var c,s=!0,l=!1;return{s:function(){i=t[Symbol.iterator]()},n:function(){var t=i.next();return s=t.done,t},e:function(t){l=!0,c=t},f:function(){try{s||null==i["return"]||i["return"]()}finally{if(l)throw c}}}}},dc4c:function(t,e,i){var n=i("24fb");e=n(!1),e.push([t.i,".complaint-title[data-v-418347dd]{display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-orient:horizontal;-webkit-box-direction:normal;-webkit-flex-direction:row;flex-direction:row;-webkit-box-pack:justify;-webkit-justify-content:space-between;justify-content:space-between;-webkit-box-align:center;-webkit-align-items:center;align-items:center;padding:%?20?% %?25?%;color:#666}.complaint-star-view.complaint-title[data-v-418347dd]{-webkit-box-pack:start;-webkit-justify-content:flex-start;justify-content:flex-start;margin:0}.cu-form-group uni-picker .picker[data-v-418347dd]{text-align:left}.solids[data-v-418347dd]::after{border:2px dashed #c5c5c5}.wanlian.cu-bar.tabbar[data-v-418347dd]{background-color:transparent}.wanlian.cu-bar.tabbar .cu-btn[data-v-418347dd]{width:calc(100% - %?50?%)}.wanlian.cu-bar.tabbar .cu-btn.lg[data-v-418347dd]{font-size:%?32?%;height:%?86?%}",""]),t.exports=e},fdb6:function(t,e,i){"use strict";var n=i("4ea4");i("99af"),i("a434"),Object.defineProperty(e,"__esModule",{value:!0}),e.default=void 0;var a=n(i("b85c")),o={data:function(){return{index:-1,picker:["虚假交易","诈骗欺诈","收到空包裹","假冒盗版","泄露信息","违禁物品","未按成交价交易","未按约定时間發貨","垃圾营销","涉黄信息","不实信息","人身攻击","违法信息","诈骗信息"],complaintId:0,typeName:"",complaint:{type:0,complaint_user_id:0,complaint_shop_id:0,complaint_goods_id:0,images:[],content:"",reason:-1}}},onLoad:function(t){this.complaint.type=t.type,this.complaintId=t.id,0==t.type?(this.typeName="用戶",this.complaint.complaint_user_id=t.id):1==t.type?(this.typeName="商品",this.complaint.complaint_goods_id=t.id):2==t.type&&(this.typeName="店铺",this.complaint.complaint_shop_id=t.id)},methods:{pickerChange:function(t){-1==t.detail.value?this.complaint.reason=0:this.complaint.reason=t.detail.value},chooseImg:function(){var t=this;uni.chooseImage({sourceType:["camera","album"],sizeType:"compressed",count:8-this.complaint.images.length,success:function(e){t.$api.get({url:"/wanlshop/common/uploadData",success:function(i){for(var n=0;n<e.tempFilePaths.length;n++)uni.getImageInfo({src:e.tempFilePaths[n],success:function(e){t.$api.upload({url:i.uploadurl,filePath:e.path,name:"file",formData:"local"==i.storage?null:i.multipart,success:function(e){t.complaint.images.push(e.fullurl)}})}})}})}})},close:function(t){this.complaint.images.splice(t,1)},previewImage:function(t,e){var i,n=[],o=(0,a.default)(t);try{for(o.s();!(i=o.n()).done;){var c=i.value;n=n.concat(this.$wanlshop.oss(c,500))}}catch(s){o.e(s)}finally{o.f()}uni.previewImage({urls:n,current:n[e],indicator:"number"})},submit:function(){var t=this;return-1==this.complaint.reason?(this.$wanlshop.msg("請选择舉報理由"),!1):this.complaint.content?void this.$api.post({url:"/wanlshop/complaint/add",data:this.complaint,success:function(e){t.$wanlshop.to("/pages/page/success?type=complaint")}}):(this.$wanlshop.msg("請填写舉報内容"),!1)}}};e.default=o}}]);