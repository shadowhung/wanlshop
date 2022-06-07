"use strict";
define(["jquery", "bootstrap", "backend", "table", "form"],
function(e, t, a, i, r) {
    var n = {
        index: function() {
            i.api.init({
                extend: {
                    index_url: "wanlshop/recharge/index" + location.search,
                    add_url: "",
                    edit_url: "",
                    del_url: "wanlshop/recharge/del",
                    multi_url: "wanlshop/recharge/multi",
                    table: "wanlshop_recharge"
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
                    field: "user_id",
                    title: __("User_id")
                },
                {
                    field: "name",
                    title: "用户名"
                },
                {
                    field: "mobile",
                    title: "用户电话号码"
                },
                {
                    field: "images",
                    title: __("Images"),
                    events: i.api.events.image,
                    formatter: i.api.formatter.images
                },
                {
                    field: "money",
                    title: __("Money")
                },
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
                    field: "status",
                    title: __("Status"),
                    searchList: {
                        created: __("Status created"),
                        successed: __("Status successed"),
                        rejected: __("Status rejected")
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
                        title: __("同意充值申请"),
                        classname: "btn btn-xs btn-success btn-magic btn-ajax",
                        icon: "fa fa-check",
                        text: "同意",
                        confirm: "确认点击同意，通过充值申请？",
                        url: "wanlshop/recharge/agree",
                        visible: function(e) {
                            if ("created" == e.status) return ! 0
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
                        title: __("拒绝充值申请"),
                        classname: "btn btn-xs btn-danger btn-dialog",
                        icon: "fa fa-times",
                        text: "拒绝",
                        url: "wanlshop/recharge/refuse",
                        visible: function(e) {
                            if ("created" == e.status) return ! 0
                        },
                        extend: 'data-area=["500px","270px"]'
                    },
                    {
                        name: "detail",
                        title: __("详情"),
                        classname: "btn btn-xs btn-info btn-dialog",
                        icon: "fa fa-eye",
                        url: "wanlshop/recharge/detail"
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
                url: "wanlshop/recharge/recyclebin" + location.search,
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
                        url: "wanlshop/recharge/restore",
                        refresh: !0
                    },
                    {
                        name: "Destroy",
                        text: __("Destroy"),
                        classname: "btn btn-xs btn-danger btn-ajax btn-destroyit",
                        icon: "fa fa-times",
                        url: "wanlshop/recharge/destroy",
                        refresh: !0
                    }],
                    formatter: i.api.formatter.operate
                }]]
            }),
            i.api.bindevent(t)
        },
        detail: function() {
            n.api.bindevent()
        },
        refuse: function() {
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