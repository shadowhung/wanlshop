"use strict";define(["jquery","bootstrap","upload","backend","form","vue"],function(t,e,n,o,r,i){return{index:function(){new i({el:"#app",data:function(){return{state:0}},mounted:function(){this.state=Config.entry?Config.entry.state:0,console.log(this.state)},methods:{getName:function(t){return["姓名","企業名稱","企業名稱"][t]},getNumber:function(t){return["身份證號碼","統壹信用代碼","統壹信用代碼"][t]},getImage:function(t){return["手持身份證","營業執照","營業執照"][t]}}});r.api.bindevent(t("form[role=form]"),function(t,e){setTimeout(function(){location.href=Fast.api.fixurl("wanlshop/entry/stepthree.html")},500)})},stepthree:function(){r.api.bindevent(t("form[role=form]"),function(t,e){setTimeout(function(){location.href=Fast.api.fixurl("wanlshop/entry/stepfour.html")},500)})},stepfour:function(){}}});