"use strict";
define(["jquery", "bootstrap", "backend", "table", "form"],
function(e, t, a, i, r) {
    var n = {
        index: function() {
            i.api.init({
                extend: {
                    index_url: "wanlshop/auth/index" + location.search,
                    edit_url: "",
                    del_url: "wanlshop/auth/del",
                    multi_url: "wanlshop/auth/multi",
                    table: "wanlshop_auth"
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
                {
                    field: "name",
                    title: __("Name")
                },
                /*{
                    field: "image",
                    title: __("Image"),
                    events: i.api.events.image,
                    formatter: i.api.formatter.image
                },*/
                {
                    field: "state",
                    title: __("State"),
                    searchList: {
                        0 : __("State 0"),
                        1 : __("State 1"),
                        2 : __("State 2")
                    },
                    formatter: i.api.formatter.normal
                },
                {
                    field: "shopname",
                    title: __("Shopname")
                },
                {
                    field: "invitation",
                    title: __("邀请人id")
                },
                {
                    field: "avatar",
                    title: __("Avatar"),
                    events: i.api.events.image,
                    formatter: i.api.formatter.image
                },
                {
                    field: "number",
                    title: __("Number")
                },
                {
                    field: "mobile",
                    title: __("Mobile")
                },
                {
                    field: "wechat",
                    title: __("Wechat")
                },
                {
                    field: "verify",
                    title: __("Verify"),
                    searchList: {
                        0 : __("Verify 0"),
                        1 : __("Verify 1"),
                        2 : __("Verify 2"),
                        3 : __("Verify 3"),
                        4 : __("Verify 4")
                    },
                    formatter: i.api.formatter.status
                },
                {
                    field: "operate",
                    title: __("Operate"),
                    table: t,
                    events: i.api.events.operate,
                    buttons: [{
                        name: "agree",
                        title: __("通过店铺审核"),
                        classname: "btn btn-xs btn-success btn-magic btn-ajax",
                        icon: "fa fa-check",
                        text: "通过",
                        confirm: "确认点击通过，通过店铺审核？",
                        url: "wanlshop/auth/agree",
                        visible: function(e) {
                            if (2 == e.verify) return ! 0
                        },
                        success: function(e, a) {
                            return t.bootstrapTable("refresh"),
                            !1
                        },
                        error: function(e, t) {
                            return console.log(e, t),
                            Layer.alert(t.msg),
                            !1
                        }
                    },
                    {
                        name: "refuse",
                        title: __("店铺审核不通过"),
                        classname: "btn btn-xs btn-danger btn-dialog",
                        icon: "fa fa-times",
                        text: "不通过",
                        url: "wanlshop/auth/refuse",
                        visible: function(e) {
                            if (2 == e.verify) return ! 0
                        },
                        extend: 'data-area=["500px","270px"]'
                    },
                    {
                        name: "detail",
                        title: __("详情"),
                        classname: "btn btn-xs btn-info btn-dialog",
                        icon: "fa fa-eye",
                        url: "wanlshop/auth/detail"
                    }],
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
                url: "wanlshop/auth/recyclebin" + location.search,
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
                    field: "name",
                    title: __("Name"),
                    align: "left"
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
                        url: "wanlshop/auth/restore",
                        refresh: !0
                    },
                    {
                        name: "Destroy",
                        text: __("Destroy"),
                        classname: "btn btn-xs btn-danger btn-ajax btn-destroyit",
                        icon: "fa fa-times",
                        url: "wanlshop/auth/destroy",
                        refresh: !0
                    }],
                    formatter: i.api.formatter.operate
                }]]
            }),
            i.api.bindevent(t)
        },
        refuse: function() {
            n.api.bindevent()
        },
        edit: function() {
            n.api.bindevent()
        },
        api: {
            bindevent: function() {
                r.api.bindevent(e("form[role=form]"))
            }
        }
    };
    return n
});