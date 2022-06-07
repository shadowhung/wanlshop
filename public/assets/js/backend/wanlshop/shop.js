"use strict";
define(["jquery", "bootstrap", "backend", "table", "form"],
function(e, t, a, i, r) {
    var o = {
        index: function() {
            i.api.init({
                extend: {
                    index_url: "wanlshop/shop/index" + location.search,
                    add_url: "wanlshop/shop/add",
                    edit_url: "wanlshop/shop/edit",
                    del_url: "wanlshop/shop/del",
                    multi_url: "wanlshop/shop/multi",
                    table: "wanlshop_shop"
                }
            });
            var t = e("#table");
            t.bootstrapTable({
                url: e.fn.bootstrapTable.defaults.extend.index_url,
                pk: "id",
                sortName: "id",
                columns: [[{
                    checkbox: !0
                },
                {
                    field: "id",
                    title: __("Id")
                },
                /*{
                    field: "state",
                    title: __("State"),
                    searchList: {
                        0 : __("State 0"),
                        1 : __("State 1"),
                        2 : __("State 2")
                    },
                    formatter: i.api.formatter.normal
                },*/
                {
                    field: "shopname",
                    title: __("Shopname")
                },
                {
                    field: "auth1.name",
                    title: '企业名/姓名',
                    formatter: i.api.formatter.search
                },
                {
                    field: "auth1.mobile",
                    title: '店铺手机号码',
                },
                {
                    field: "user.username",
                    title: '所属用户名',
                    formatter: i.api.formatter.search,
                    operate:false
                },
                {
                    field: "user.id",
                    title: '所属用户id',
                    formatter: i.api.formatter.search
                },
                {
                    field: "auth1.invitation",
                    title: '邀请人id',
                    formatter: i.api.formatter.search
                },
                {
                    field: "auth1.username",
                    title: "邀请人用户名",
                    operate:false
                },
                {
                    field: "auth1.usermobile",
                    title: "邀请人电话号码"
                },
                {
                    field: "auth1.wechat",
                    title: 'Line',
                },
                {
                    field: "mobile",
                    title: '下级手机号码',
                    operate:false
                },
                {
                    field: "shopname1",
                    title: '下级商铺名',
                    operate:false
                },
                {
                    field: "invitation",
                    title: '下级用户id',
                    operate: false
                },
                {
                    field: "avatar",
                    title: __("Avatar"),
                    events: i.api.events.image,
                    formatter: i.api.formatter.image
                },
                {
                    field: "city",
                    title: __("City")
                },
                {
                    field: "score_describe",
                    title: __("Score_describe"),
                    operate: "BETWEEN"
                },
                {
                    field: "score_service",
                    title: __("Score_service"),
                    operate: "BETWEEN"
                },
                {
                    field: "score_logistics",
                    title: __("Score_logistics"),
                    operate: "BETWEEN"
                },
                /*{
                    field: "islive",
                    title: __("Islive"),
                    searchList: {
                        1 : __("Yes"),
                        0 : __("No")
                    },
                    formatter: i.api.formatter.toggle
                },
                {
                    field: "isself",
                    title: __("IsSelf"),
                    searchList: {
                        1 : __("Yes"),
                        0 : __("No")
                    },
                    formatter: i.api.formatter.toggle
                },*/
                {
                    field: "createtime",
                    title: __("Createtime"),
                    operate: "RANGE",
                    addclass: "datetimerange",
                    formatter: i.api.formatter.datetime
                },
                {
                    field: "updatetime",
                    title: __("Updatetime"),
                    operate: "RANGE",
                    addclass: "datetimerange",
                    formatter: i.api.formatter.datetime
                },
                {
                    field: "like",
                    title: __("Like")
                },
                {
                    field: "status",
                    title: __("Status"),
                    searchList: {
                        normal: __("Normal"),
                        hidden: __("Hidden")
                    },
                    formatter: i.api.formatter.status
                },
                {
                    field: "operate",
                    title: __("Operate"),
                    table: t,
                    events: i.api.events.operate,
                    formatter: i.api.formatter.operate
                }]]
            }),
            i.api.bindevent(t)
        },
        recyclebin: function() {
            i.api.init({
                extend: {
                    dragsort_url: ""
                }
            });
            var t = e("#table");
            t.bootstrapTable({
                url: "wanlshop/shop/recyclebin" + location.search,
                pk: "id",
                sortName: "id",
                columns: [[{
                    checkbox: !0
                },
                {
                    field: "id",
                    title: __("Id")
                },
                {
                    field: "deletetime",
                    title: __("Deletetime"),
                    operate: "RANGE",
                    addclass: "datetimerange",
                    formatter: i.api.formatter.datetime
                },
                {
                    field: "operate",
                    width: "130px",
                    title: __("Operate"),
                    table: t,
                    events: i.api.events.operate,
                    buttons: [{
                        name: "Restore",
                        text: __("Restore"),
                        classname: "btn btn-xs btn-info btn-ajax btn-restoreit",
                        icon: "fa fa-rotate-left",
                        url: "wanlshop/shop/restore",
                        refresh: !0
                    },
                    {
                        name: "Destroy",
                        text: __("Destroy"),
                        classname: "btn btn-xs btn-danger btn-ajax btn-destroyit",
                        icon: "fa fa-times",
                        url: "wanlshop/shop/destroy",
                        refresh: !0
                    }],
                    formatter: i.api.formatter.operate
                }]]
            }),
            i.api.bindevent(t)
        },
        add: function() {
            o.api.bindevent()
        },
        edit: function() {
            o.api.bindevent()
        },
        api: {
            bindevent: function() {
                r.api.bindevent(e("form[role=form]"))
            }
        }
    };
    return o
});