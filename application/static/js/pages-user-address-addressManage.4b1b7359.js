(window["webpackJsonp"]=window["webpackJsonp"]||[]).push([["pages-user-address-addressManage"],{"0761":function(e,a,n){"use strict";var t=n("1e00"),s=n.n(t);s.a},1709:function(e,a,n){var t=n("86c8");"string"===typeof t&&(t=[[e.i,t,""]]),t.locals&&(e.exports=t.locals);var s=n("4f06").default;s("22032a5c",t,!0,{sourceMap:!1,shadowMode:!1})},"1bd1":function(e,a,n){"use strict";(function(e){var t=n("4ea4");n("a15b"),n("a434"),n("ac1f"),Object.defineProperty(a,"__esModule",{value:!0}),a.default=void 0;var s=t(n("8654")),i={name:"WanlAddress",data:function(){return{isShow:!1,isShowMask:!1,dataList:["請选择"],currentIndex:0,cityData:{},cityAreaArray:[],selectIndexArr:[],indicatorStyleLeft:16}},methods:{show:function(){this.isShow=!0,this.isShowMask=!0},hidden:function(){this.isShow=!1,this.isShowMask=!1},select_top_item_click:function(e){this.currentIndex=e,this.changeIndicator(e)},swiperChange:function(e){var a=e.detail.current;this.currentIndex=a,this.changeIndicator(a)},changeIndicator:function(e){var a=this,n=30,t=uni.createSelectorQuery().in(this),s=t.selectAll(".select_top_item .address_value");s.fields({size:!0,scrollOffset:!1},(function(t){var s=10+80*e+t[e]["width"]/2,i=s-n/2;a.indicatorStyleLeft=i})).exec()},address_item_click:function(a,n){var t=this;if(this.selectIndexArr.splice(a,5,n),0===a){var s=this.cityData[n],i=s.name;this.dataList.splice(a,5,i),this.dataList.splice(a+1,0,"請选择"),this.cityAreaArray.splice(a+1,1,s["city"]),setTimeout((function(){t.currentIndex=1,t.changeIndicator(1)}),50)}else{var r=this.cityAreaArray[a],m=r[n],d=m["area"];if(void 0!==d){var o=m.name;this.dataList.splice(a,5,o),this.dataList.splice(a+1,0,"請选择"),this.cityAreaArray.splice(a+1,1,m["area"]),setTimeout((function(){t.currentIndex=a+1,t.changeIndicator(a+1)}),50)}else{var c=m.name;this.dataList.splice(a,1,c),uni.request({url:"https://restapi.amap.com/v3/geocode/geo",data:{address:this.dataList.join(""),key:this.$wanlshop.config("amapkey")},success:function(a){a.data.geocodes[0]["district"]=t.dataList[2],a.data.geocodes[0]["city"]=t.dataList[1],a.data.geocodes[0]["formatted_address"]=t.dataList.join(""),e.log(a.data.geocodes[0]),t.$emit("selectAddress",a.data.geocodes[0]),t.isShow=!1,t.isShowMask=!1}})}}}},created:function(){this.cityData=s.default,this.cityAreaArray.push(s.default)},mounted:function(){}};a.default=i}).call(this,n("5a52")["default"])},"1e00":function(e,a,n){var t=n("aee3");"string"===typeof t&&(t=[[e.i,t,""]]),t.locals&&(e.exports=t.locals);var s=n("4f06").default;s("133e63e9",t,!0,{sourceMap:!1,shadowMode:!1})},2618:function(e,a,n){"use strict";(function(e){Object.defineProperty(a,"__esModule",{value:!0}),a.default=void 0;var n={data:function(){return{addressData:{name:"",mobile:"",default:0,country:"",province:"",city:"",citycode:"",district:"",adcode:"",formatted_address:"",address:"",address_name:"",location:""},addressList:{location:"",adcode:"",tips:{}},addressType:!0}},onLoad:function(e){var a="新增地址 ";"newadd"===e.type&&(this.addressData.default=1),"edit"===e.type&&(a="编辑地址",this.addressData=JSON.parse(e.data)),this.manageType=e.type,this.$wanlshop.title(a)},methods:{switchChange:function(e){e.detail.value?this.addressData.default=1:this.addressData.default=0},btnClick:function(){this.$refs.wanlAddress.show()},successSelectAddress:function(a){this.addressData.country=a.country,this.addressData.province=a.province,this.addressData.city=a.city,this.addressData.citycode=a.citycode,this.addressData.district=a.district,this.addressData.formatted_address=a.formatted_address,this.addressData.location=a.location,this.addressData.adcode=a.adcode,this.addressList.location=a.location,this.addressList.adcode=a.adcode,e.log(this.addressList)},getInputtips:function(e){e.detail.value},blurInputtips:function(e){var a=this;this.addressData.address=e.detail.value,setTimeout((function(){a.addressType=!0}),10)},confirmInputtips:function(e){this.addressType=!0},focusInputtips:function(e){this.addressType=!1},addressTisp:function(e){this.addressData.adcode=e.adcode,this.addressData.address=e.address,this.addressData.address_name=e.name,this.addressData.location=e.location,this.addressType=!0},confirm:function(){var a=this.addressData;a.name?/^[0-9]{8,15}$/.test(a.mobile)?a.city?a.address?(e.log(this.$wanlshop.prePage()),this.$wanlshop.prePage().refreshList(a,this.manageType),this.$wanlshop.msg("地址".concat("edit"==this.manageType?"修改":"添加","成功")),this.$wanlshop.back(1)):this.$wanlshop.msg("請填寫詳細資訊"):this.$wanlshop.msg("請選擇地區"):this.$wanlshop.msg("請輸入正確的行動電話"):this.$wanlshop.msg("請填寫收貨人姓名")}}};a.default=n}).call(this,n("5a52")["default"])},"2fdf":function(e,a,n){"use strict";n.r(a);var t=n("bbc5"),s=n("5317");for(var i in s)"default"!==i&&function(e){n.d(a,e,(function(){return s[e]}))}(i);n("0761");var r,m=n("f0c5"),d=Object(m["a"])(s["default"],t["b"],t["c"],!1,null,"43edcc32",null,!1,t["a"],r);a["default"]=d.exports},5317:function(e,a,n){"use strict";n.r(a);var t=n("2618"),s=n.n(t);for(var i in t)"default"!==i&&function(e){n.d(a,e,(function(){return t[e]}))}(i);a["default"]=s.a},8654:function(e){e.exports=JSON.parse('[{"name":"臺灣","city":[{"name":"臺北市","area":[{"name":"內湖區"},{"name":"南港區"},{"name":"中正區"},{"name":"萬華區"},{"name":"大同區"},{"name":"中山區"},{"name":"松山區"},{"name":"大安區"},{"name":"信義區"},{"name":"文山區"},{"name":"士林區"},{"name":"北投區"}]},{"name":"新北市","area":[{"name":"板橋區"},{"name":"三重區"},{"name":"中和區"},{"name":"永和區"},{"name":"新莊區"},{"name":"新店區"},{"name":"樹林區"},{"name":"土城區"},{"name":"蘆洲區"},{"name":"汐止區"},{"name":"鶯歌區"},{"name":"三峽區"},{"name":"淡水區"},{"name":"瑞芳區"},{"name":"五股區"},{"name":"泰山區"},{"name":"林口區"},{"name":"深坑區"},{"name":"石碇區"},{"name":"坪林區"},{"name":"三芝區"},{"name":"石門區"},{"name":"八里區"},{"name":"平溪區"},{"name":"雙溪區"},{"name":"貢寮區"},{"name":"金山區"},{"name":"萬里區"},{"name":"烏來區"},{"name":"其他"}]},{"name":"桃园市","area":[{"name":"桃園區"},{"name":"中壢區"},{"name":"八德區"},{"name":"平鎮區"},{"name":"龜山區"},{"name":"大溪區"},{"name":"楊梅區"},{"name":"蘆竹區"},{"name":"大園區"},{"name":"龍潭區"},{"name":"新屋區"},{"name":"觀音區"},{"name":"復興區"},{"name":"其他"}]},{"name":"臺中市","area":[{"name":"豐原區"},{"name":"中區"},{"name":"大里區"},{"name":"東區"},{"name":"南區"},{"name":"太平區"},{"name":"和平區"},{"name":"西區"},{"name":"北區"},{"name":"東勢區"},{"name":"后里區"},{"name":"西屯區"},{"name":"外埔區"},{"name":"南屯區"},{"name":"北屯區"},{"name":"大甲區"},{"name":"大安區"},{"name":"清水區"},{"name":"神岡區"},{"name":"石岡區"},{"name":"新社區"},{"name":"梧棲區"},{"name":"沙鹿區"},{"name":"大雅區"},{"name":"潭子區"},{"name":"龍井區"},{"name":"大肚區"},{"name":"烏日區"},{"name":"霧峰區"},{"name":"其他"}]},{"name":"臺南市","area":[{"name":"新營區"},{"name":"安南區"},{"name":"安平區"},{"name":"永康區"},{"name":"北區"},{"name":"白河區"},{"name":"中西區"},{"name":"鹽水區"},{"name":"南區"},{"name":"柳營區"},{"name":"東區"},{"name":"後壁區"},{"name":"東山區"},{"name":"北門區"},{"name":"學甲區"},{"name":"下營區"},{"name":"六甲區"},{"name":"楠西區"},{"name":"將軍區"},{"name":"佳里區"},{"name":"麻豆區"},{"name":"官田區"},{"name":"大內區"},{"name":"玉井區"},{"name":"南化區"},{"name":"七股區"},{"name":"西港區"},{"name":"安定區"},{"name":"善化區"},{"name":"新市區"},{"name":"山上區"},{"name":"新化區"},{"name":"關廟區"},{"name":"歸仁區"},{"name":"仁德區"},{"name":"其他"}]},{"name":"屏東縣","area":[{"name":"屏東市"},{"name":"潮州鎮"},{"name":"東港鎮"},{"name":"恆春鎮"},{"name":"萬丹鄉"},{"name":"長治鄉"},{"name":"麟洛鄉"},{"name":"九如鄉"},{"name":"里港鄉"},{"name":"鹽埔鄉"},{"name":"高樹鄉"},{"name":"萬巒鄉"},{"name":"內埔鄉"},{"name":"竹田鄉"},{"name":"新埤鄉"},{"name":"枋寮鄉"},{"name":"新園鄉"},{"name":"崁頂鄉"},{"name":"林邊鄉"},{"name":"南州鄉"},{"name":"佳冬鄉"},{"name":"琉球鄉"},{"name":"車城鄉"},{"name":"滿州鄉"},{"name":"枋山鄉"},{"name":"三地門鄉"},{"name":"其他"}]},{"name":"嘉義縣","area":[{"name":"太保市"},{"name":"朴子市"},{"name":"布袋鎮"},{"name":"大林鎮"},{"name":"民雄鄉"},{"name":"溪口鄉"},{"name":"新港鄉"},{"name":"六腳鄉"},{"name":"東石鄉"},{"name":"義竹鄉"},{"name":"鹿草鄉"},{"name":"水上鄉"},{"name":"中埔鄉"},{"name":"竹崎鄉"},{"name":"梅山鄉"},{"name":"番路鄉"},{"name":"大埔鄉"},{"name":"阿里山鄉"},{"name":"其他"}]},{"name":"雲林縣","area":[{"name":"斗六市"},{"name":"斗南鎮"},{"name":"虎尾鎮"},{"name":"西螺鎮"},{"name":"土庫鎮"},{"name":"北港鎮"},{"name":"口湖鄉"},{"name":"麥寮鄉"},{"name":"崙背鄉"},{"name":"二崙鄉"},{"name":"莿桐鄉"},{"name":"林內鄉"},{"name":"古坑鄉"},{"name":"大埤鄉"},{"name":"褒忠鄉"},{"name":"元長鄉"},{"name":"東勢鄉"},{"name":"台西鄉"},{"name":"四湖鄉"},{"name":"水林鄉"},{"name":"其他"}]},{"name":"南投縣","area":[{"name":"南投市"},{"name":"埔里鎮"},{"name":"草屯鎮"},{"name":"竹山鎮"},{"name":"集集鎮"},{"name":"名間鄉"},{"name":"鹿谷鄉"},{"name":"中寮鄉"},{"name":"魚池鄉"},{"name":"國姓鄉"},{"name":"水里鄉"},{"name":"信義鄉"},{"name":"仁愛鄉"},{"name":"其他"}]},{"name":"苗栗縣","area":[{"name":"苗栗市"},{"name":"竹南鎮"},{"name":"後龍鎮"},{"name":"頭份市"},{"name":"造橋鄉"},{"name":"三灣鄉"},{"name":"頭屋鄉"},{"name":"獅潭鄉"},{"name":"南庄鄉"},{"name":"公館鄉"},{"name":"西湖鄉"},{"name":"通霄鎮"},{"name":"苑裡鎮"},{"name":"銅鑼鄉"},{"name":"大湖鄉"},{"name":"三義鄉"},{"name":"卓蘭鎮"},{"name":"泰安鄉"},{"name":"其他"}]},{"name":"新竹市","area":[{"name":"東區"},{"name":"北區"},{"name":"香山區"},{"name":"其他"}]},{"name":"新竹縣","area":[{"name":"竹北市"},{"name":"竹東鎮"},{"name":"新埔鎮"},{"name":"關西鎮"},{"name":"湖口鄉"},{"name":"新豐鄉"},{"name":"芎林鄉"},{"name":"橫山鄉"},{"name":"北埔鄉"},{"name":"寶山鄉"},{"name":"峨眉鄉"},{"name":"五峰鄉"},{"name":"其他"}]},{"name":"澎湖縣","area":[{"name":"馬公市"},{"name":"湖西鄉"},{"name":"白沙鄉"},{"name":"西嶼鄉"},{"name":"七美鄉"},{"name":"其他"}]},{"name":"台東縣","area":[{"name":"台東市"},{"name":"成功鎮"},{"name":"關山鎮"},{"name":"卑南鄉"},{"name":"鹿野鄉"},{"name":"池上鄉"},{"name":"東河鄉"},{"name":"長濱鄉"},{"name":"太麻里鄉"},{"name":"大武鄉"},{"name":"綠島鄉"},{"name":"達仁鄉"},{"name":"蘭嶼鄉"},{"name":"其他"}]},{"name":"嘉義市","area":[{"name":"東區"},{"name":"西區"},{"name":"其他"}]},{"name":"彰化縣","area":[{"name":"彰化市"},{"name":"鹿港鎮"},{"name":"伸港鄉"},{"name":"線西鄉"},{"name":"秀水鄉"},{"name":"花壇鄉"},{"name":"芬園鄉"},{"name":"福興鄉"},{"name":"埔鹽鄉"},{"name":"大村鄉"},{"name":"員林市"},{"name":"埔心鄉"},{"name":"溪湖鎮"},{"name":"芳苑鄉"},{"name":"二林鎮"},{"name":"埤頭鄉"},{"name":"田尾鄉"},{"name":"永靖鄉"},{"name":"社頭鄉"},{"name":"田中鎮"},{"name":"北斗鎮"},{"name":"二水鄉"},{"name":"溪州鄉"},{"name":"竹塘鄉"},{"name":"大城鄉"},{"name":"和美鎮"},{"name":"其他"}]},{"name":"花蓮縣","area":[{"name":"花蓮市"},{"name":"鳳林鎮"},{"name":"玉里鎮"},{"name":"新城鄉"},{"name":"吉安鄉"},{"name":"壽豐鄉"},{"name":"光復鄉"},{"name":"豐濱鄉"},{"name":"瑞穗鄉"},{"name":"富里鄉"},{"name":"秀林鄉"},{"name":"其他"}]},{"name":"宜蘭縣","area":[{"name":"宜蘭市"},{"name":"羅東鎮"},{"name":"蘇澳鎮"},{"name":"頭城鎮"},{"name":"礁溪鄉"},{"name":"壯圍鄉"},{"name":"員山鄉"},{"name":"冬山鄉"},{"name":"五結鄉"},{"name":"三星鄉"},{"name":"大同鄉"},{"name":"南澳鄉"},{"name":"其他"}]},{"name":"基隆市","area":[{"name":"中正區"},{"name":"七堵區"},{"name":"暖暖區"},{"name":"安樂區"},{"name":"中山區"},{"name":"仁愛區"},{"name":"信義區"},{"name":"其他"}]},{"name":"金門縣","area":[{"name":"金湖鎮"},{"name":"金沙鎮"},{"name":"金城鎮"},{"name":"金寧鄉"},{"name":"烈嶼鄉"},{"name":"其他"}]},{"name":"連江縣","area":[{"name":"南竿鄉"},{"name":"北竿鄉"},{"name":"莒光鄉"},{"name":"東引鄉"},{"name":"其他"}]},{"name":"高雄市","area":[{"name":"鳳山區"},{"name":"鹽埕區"},{"name":"鼓山區"},{"name":"林園區"},{"name":"大寮區"},{"name":"左營區"},{"name":"大樹區"},{"name":"楠梓區"},{"name":"三民區"},{"name":"大社區"},{"name":"新興區"},{"name":"仁武區"},{"name":"鳥松區"},{"name":"前金區"},{"name":"岡山區"},{"name":"苓雅區"},{"name":"橋頭區"},{"name":"前鎮區"},{"name":"燕巢區"},{"name":"旗津區"},{"name":"田寮區"},{"name":"阿蓮區"},{"name":"路竹區"},{"name":"湖內區"},{"name":"茄萣區"},{"name":"永安區"},{"name":"彌陀區"},{"name":"梓官區"},{"name":"旗山區"},{"name":"美濃區"},{"name":"六龜區"},{"name":"甲仙區"},{"name":"杉林區"},{"name":"內門區"},{"name":"其他"}]}]}]')},"86c8":function(e,a,n){var t=n("24fb");a=t(!1),a.push([e.i,'@charset "UTF-8";\n/* 頁面左右間距 */\n/* 文字尺寸 */\n/*文字颜色*/\n/* 边框颜色 */\n/* 圖片加載中颜色 */\n/* 行為相關颜色 */.wrapper[data-v-16eb0a8a]{z-index:9990;position:absolute;top:0;left:0;bottom:0;right:0}.wrapper .content_view[data-v-16eb0a8a]{z-index:9991;background:#fff;position:absolute;height:80%;left:0;bottom:0;right:0;-webkit-border-top-left-radius:%?20?%;border-top-left-radius:%?20?%;-webkit-border-top-right-radius:%?20?%;border-top-right-radius:%?20?%}.wrapper .content_view .title_view[data-v-16eb0a8a]{height:8%;display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-pack:justify;-webkit-justify-content:space-between;justify-content:space-between;-webkit-box-align:center;-webkit-align-items:center;align-items:center;padding:0 10px}.wrapper .content_view .title_view .title[data-v-16eb0a8a]{font-size:uni-font-size-sm}.wrapper .content_view .title_view .close_view[data-v-16eb0a8a]{height:%?40?%;width:%?40?%;display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-pack:center;-webkit-justify-content:center;justify-content:center;-webkit-box-align:center;-webkit-align-items:center;align-items:center}.wrapper .content_view .select_top[data-v-16eb0a8a]{height:8%;display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-pack:start;-webkit-justify-content:flex-start;justify-content:flex-start;-webkit-box-align:center;-webkit-align-items:center;align-items:center;padding:0 %?20?% %?20?% %?20?%;position:relative;-webkit-box-sizing:border-box;box-sizing:border-box}.wrapper .content_view .select_top .select_top_item[data-v-16eb0a8a]{width:%?160?%;font-size:%?28?%;text-overflow:ellipsis;overflow:hidden;white-space:nowrap}.wrapper .content_view .select_top .indicator[data-v-16eb0a8a]{position:absolute;width:%?60?%;height:%?4?%;background:#dd524d;left:%?32?%;bottom:0;-webkit-transition:left .5s ease;transition:left .5s ease}.wrapper .content_view .swiper[data-v-16eb0a8a]{height:80%;position:relative;left:0;top:0;bottom:0;right:0}.wrapper .content_view .swiper .swiper-item[data-v-16eb0a8a]{height:100%}.wrapper .content_view .swiper .swiper-item .scroll-view-item[data-v-16eb0a8a]{height:100%;padding:0 %?20?%}.wrapper .content_view .swiper .swiper-item .scroll-view-item .address_item[data-v-16eb0a8a]{padding:%?10?% 0;font-size:%?28?%;display:-webkit-box;display:-webkit-flex;display:flex;-webkit-box-align:center;-webkit-align-items:center;align-items:center}.wrapper .content_view .swiper .swiper-item .scroll-view-item .address_item .address_item_icon[data-v-16eb0a8a]{width:%?40?%;height:%?40?%;margin-right:%?20?%}.wrapper .mask[data-v-16eb0a8a]{position:absolute;top:0;left:0;bottom:0;right:0;background:rgba(0,0,0,.2)}.content-enter[data-v-16eb0a8a]{-webkit-transform:translateY(100%);transform:translateY(100%)}.content-enter-to[data-v-16eb0a8a]{-webkit-transform:translateY(0);transform:translateY(0)}.content-enter-active[data-v-16eb0a8a]{-webkit-transition:-webkit-transform .5s;transition:-webkit-transform .5s;transition:transform .5s;transition:transform .5s,-webkit-transform .5s}.content-leave[data-v-16eb0a8a]{-webkit-transform:translateY(0);transform:translateY(0)}.content-leave-to[data-v-16eb0a8a]{-webkit-transform:translateY(100%);transform:translateY(100%)}.content-leave-active[data-v-16eb0a8a]{-webkit-transition:-webkit-transform .5s;transition:-webkit-transform .5s;transition:transform .5s;transition:transform .5s,-webkit-transform .5s}',""]),e.exports=a},"8c45":function(e,a,n){"use strict";n.r(a);var t=n("1bd1"),s=n.n(t);for(var i in t)"default"!==i&&function(e){n.d(a,e,(function(){return t[e]}))}(i);a["default"]=s.a},"9b5b":function(e,a,n){"use strict";var t;n.d(a,"b",(function(){return s})),n.d(a,"c",(function(){return i})),n.d(a,"a",(function(){return t}));var s=function(){var e=this,a=e.$createElement,n=e._self._c||a;return n("v-uni-view",{directives:[{name:"show",rawName:"v-show",value:e.isShowMask,expression:"isShowMask"}],staticClass:"wrapper"},[n("transition",{attrs:{name:"content"}},[n("v-uni-view",{directives:[{name:"show",rawName:"v-show",value:e.isShow,expression:"isShow"}],staticClass:"content_view"},[n("v-uni-view",{staticClass:"title_view"},[n("v-uni-view",{staticClass:"title"},[e._v("請選擇所在地區")]),n("v-uni-view",{staticClass:"close_view",on:{click:function(a){arguments[0]=a=e.$handleEvent(a),e.hidden.apply(void 0,arguments)}}},[n("v-uni-icon",{staticClass:"close_icon",attrs:{type:"clear",size:"26"}})],1)],1),n("v-uni-view",{staticClass:"select_top"},[e._l(e.dataList,(function(a,t){return n("v-uni-view",{key:t,ref:"select_top_item",refInFor:!0,staticClass:"select_top_item",on:{click:function(a){arguments[0]=a=e.$handleEvent(a),e.select_top_item_click(t)}}},[n("v-uni-text",{staticClass:"address_value"},[e._v(e._s(a))])],1)})),n("v-uni-view",{ref:"indicator",staticClass:"indicator",style:{left:e.indicatorStyleLeft+"px"}})],2),n("v-uni-swiper",{staticClass:"swiper",attrs:{current:e.currentIndex},on:{change:function(a){arguments[0]=a=e.$handleEvent(a),e.swiperChange.apply(void 0,arguments)}}},e._l(e.dataList,(function(a,t){return n("v-uni-swiper-item",{key:t},[n("v-uni-view",{staticClass:"swiper-item"},[n("v-uni-scroll-view",{staticClass:"scroll-view-item",attrs:{"scroll-y":"true"}},e._l(e.cityAreaArray[t],(function(a,s){return n("v-uni-view",{key:s,staticClass:"address_item",on:{click:function(a){arguments[0]=a=e.$handleEvent(a),e.address_item_click(t,s)}}},[e.selectIndexArr[t]===s?n("v-uni-image",{staticClass:"address_item_icon",attrs:{src:e.$wanlshop.appstc("/common/img_gou3x.png"),mode:""}}):e._e(),e._v(e._s(a.name))],1)})),1)],1)],1)})),1)],1)],1),n("v-uni-view",{directives:[{name:"show",rawName:"v-show",value:e.isShowMask,expression:"isShowMask"}],staticClass:"mask",on:{click:function(a){arguments[0]=a=e.$handleEvent(a),e.hidden.apply(void 0,arguments)}}})],1)},i=[]},aee3:function(e,a,n){var t=n("24fb");a=t(!1),a.push([e.i,".cu-form-group[data-v-43edcc32]{padding:0 %?25?%}.cu-form-group .title[data-v-43edcc32]{min-width:calc(4em + 15px);font-size:%?26?%}.cu-form-group uni-input[data-v-43edcc32],.cu-form-group uni-textarea[data-v-43edcc32]{font-size:%?26?%}.cu-btn.lg[data-v-43edcc32]{font-size:%?32?%;height:%?86?%}.tipsScroll[data-v-43edcc32]{width:100%;height:%?500?%;padding:0 %?50?%}.tipsScroll .item[data-v-43edcc32]{margin:%?25?% 0}.tipsScroll .item uni-view[data-v-43edcc32]{color:#b8b8b8;font-size:%?22?%}.tipsScroll .item uni-text[data-v-43edcc32]{color:#333}",""]),e.exports=a},bbc5:function(e,a,n){"use strict";n.d(a,"b",(function(){return s})),n.d(a,"c",(function(){return i})),n.d(a,"a",(function(){return t}));var t={wanlAddress:n("c96c").default},s=function(){var e=this,a=e.$createElement,n=e._self._c||a;return n("v-uni-view",[n("v-uni-view",{staticClass:"edgeInsetTop"}),n("v-uni-view",{directives:[{name:"show",rawName:"v-show",value:e.addressType,expression:"addressType"}],staticClass:"cu-form-group"},[n("v-uni-view",{staticClass:"title"},[e._v("連絡人")]),n("v-uni-input",{attrs:{type:"text",placeholder:"姓名"},model:{value:e.addressData.name,callback:function(a){e.$set(e.addressData,"name",a)},expression:"addressData.name"}})],1),n("v-uni-view",{directives:[{name:"show",rawName:"v-show",value:e.addressType,expression:"addressType"}],staticClass:"cu-form-group"},[n("v-uni-view",{staticClass:"title"},[e._v("行動電話")]),n("v-uni-input",{attrs:{type:"number",placeholder:"行動電話號碼",maxlength:"11"},model:{value:e.addressData.mobile,callback:function(a){e.$set(e.addressData,"mobile",a)},expression:"addressData.mobile"}})],1),n("v-uni-view",{staticClass:"cu-form-group"},[n("v-uni-view",{staticClass:"title"},[e._v("所在地區")]),n("v-uni-input",{attrs:{type:"text",value:e.addressData.formatted_address,placeholder:"選擇地區",disabled:!0},on:{click:function(a){arguments[0]=a=e.$handleEvent(a),e.btnClick.apply(void 0,arguments)}}})],1),n("v-uni-view",{staticClass:"cu-form-group align-start"},[n("v-uni-view",{staticClass:"title"},[e._v("詳細地址")]),n("v-uni-textarea",{attrs:{maxlength:"-1","placeholder-style":""==e.addressData.adcode?"color: #bbb":"","adjust-position":!1,value:e.addressData.address?e.addressData.address_name+e.addressData.address:"",disabled:""==e.addressData.adcode,placeholder:""==e.addressData.adcode?"還沒有選擇地區哦~選擇地區後完成此項":"輸入社區名試試~"},on:{input:function(a){arguments[0]=a=e.$handleEvent(a),e.getInputtips.apply(void 0,arguments)},focus:function(a){arguments[0]=a=e.$handleEvent(a),e.focusInputtips.apply(void 0,arguments)},confirm:function(a){arguments[0]=a=e.$handleEvent(a),e.confirmInputtips.apply(void 0,arguments)},blur:function(a){arguments[0]=a=e.$handleEvent(a),e.blurInputtips.apply(void 0,arguments)}}})],1),n("v-uni-view",{directives:[{name:"show",rawName:"v-show",value:e.addressType,expression:"addressType"}],staticClass:"cu-form-group margin-top-bj"},[n("v-uni-view",{staticClass:"title"},[e._v("設為默認")]),n("v-uni-switch",{class:1==e.addressData.default?"checked":"",attrs:{checked:1==e.addressData.default},on:{change:function(a){arguments[0]=a=e.$handleEvent(a),e.switchChange.apply(void 0,arguments)}}})],1),n("v-uni-scroll-view",{directives:[{name:"show",rawName:"v-show",value:!e.addressType,expression:"!addressType"}],staticClass:"tipsScroll",attrs:{"scroll-y":"true"}},e._l(e.addressList.tips,(function(a,t){return n("v-uni-view",{key:t,staticClass:"item",on:{click:function(n){arguments[0]=n=e.$handleEvent(n),e.addressTisp(a)}}},[n("v-uni-view",[e._v(e._s(a.address))]),n("v-uni-text",[e._v(e._s(a.name))])],1)})),1),n("v-uni-view",{directives:[{name:"show",rawName:"v-show",value:e.addressType,expression:"addressType"}],staticClass:"padding-bj flex flex-direction margin-top"},[n("v-uni-button",{staticClass:"cu-btn wanl-bg-orange lg",on:{click:function(a){arguments[0]=a=e.$handleEvent(a),e.confirm.apply(void 0,arguments)}}},[e._v("完成")])],1),n("wanl-address",{ref:"wanlAddress",on:{selectAddress:function(a){arguments[0]=a=e.$handleEvent(a),e.successSelectAddress.apply(void 0,arguments)}}})],1)},i=[]},c96c:function(e,a,n){"use strict";n.r(a);var t=n("9b5b"),s=n("8c45");for(var i in s)"default"!==i&&function(e){n.d(a,e,(function(){return s[e]}))}(i);n("ddaf");var r,m=n("f0c5"),d=Object(m["a"])(s["default"],t["b"],t["c"],!1,null,"16eb0a8a",null,!1,t["a"],r);a["default"]=d.exports},ddaf:function(e,a,n){"use strict";var t=n("1709"),s=n.n(t);s.a}}]);