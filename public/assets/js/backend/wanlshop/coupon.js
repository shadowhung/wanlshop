"use strict";
define(["jquery", "bootstrap", "backend", "table", "form", "vue"],
function(e, t, a, r, n, i) {
    var o = {
        index: function() {
            r.api.init({
                extend: {
                    index_url: "wanlshop/coupon/index" + location.search,
                    add_url: "wanlshop/coupon/add",
                    edit_url: "wanlshop/coupon/edit",
                    del_url: "wanlshop/coupon/del",
                    multi_url: "",
                    import_url: "",
                    table: "wanlshop_coupon"
                }
            });
            var t = e("#table");
            t.bootstrapTable({
                url: e.fn.bootstrapTable.defaults.extend.index_url,
                pk: "id",
                fixedColumns: !0,
                fixedNumber: 3,
                fixedRightNumber: 2,
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
                    align: "left",
                    operate: "LIKE"
                },
                {
                    field: "usenum",
                    title: __("Usenum"),
                    formatter: o.api.formatter.alreadygrant
                },
                {
                    field: "type",
                    title: __("Type"),
                    searchList: {
                        reduction: __("Type reduction"),
                        discount: __("Type discount"),
                        shipping: __("Type shipping"),
                        vip: __("Type vip")
                    },
                    formatter: r.api.formatter.normal
                },
                {
                    field: "rangetype",
                    title: __("Rangetype"),
                    searchList: {
                        all: __("Rangetype all"),
                        goods: __("Rangetype goods"),
                        category: __("Rangetype category")
                    },
                    formatter: r.api.formatter.normal
                },
                {
                    field: "limit",
                    title: __("Limit"),
                    operate: "BETWEEN"
                },
                {
                    field: "id",
                    title: __("优惠方式"),
                    operate: !1,
                    formatter: o.api.formatter.mode
                },
                {
                    field: "grant",
                    title: __("Grant"),
                    operate: !1,
                    formatter: o.api.formatter.grant
                },
                {
                    field: "alreadygrant",
                    title: __("Alreadygrant"),
                    formatter: o.api.formatter.alreadygrant
                },
                {
                    field: "id",
                    title: __("有效期"),
                    formatter: o.api.formatter.overdue
                },
                {
                    field: "invalid",
                    title: __("Invalid"),
                    formatter: o.api.formatter.invalid
                },
                {
                    field: "createtime",
                    title: __("Createtime"),
                    operate: "RANGE",
                    addclass: "datetimerange",
                    formatter: r.api.formatter.datetime
                },
                {
                    field: "operate",
                    title: __("Operate"),
                    table: t,
                    events: r.api.events.operate,
                    formatter: r.api.formatter.operate
                }]]
            }),
            r.api.bindevent(t)
        },
        recyclebin: function() {
            r.api.init({
                extend: {
                    dragsort_url: ""
                }
            });
            var t = e("#table");
            t.bootstrapTable({
                url: "wanlshop/coupon/recyclebin" + location.search,
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
                    formatter: r.api.formatter.datetime
                },
                {
                    field: "operate",
                    width: "130px",
                    title: __("Operate"),
                    table: t,
                    events: r.api.events.operate,
                    buttons: [{
                        name: "Restore",
                        text: __("Restore"),
                        classname: "btn btn-xs btn-danger btn-ajax btn-restoreit",
                        icon: "fa fa-rotate-left",
                        url: "wanlshop/coupon/restore",
                        refresh: !0
                    }],
                    formatter: r.api.formatter.operate
                }]]
            }),
            r.api.bindevent(t)
        },
        add: function() {
            o.api.bindevent();
            new i({
                el: "#app",
                data: {
                    type: "reduction",
                    rangetype: "all",
                    rangename: {
                        goods: "选择商品",
                        category: "选择类目"
                    },
                    range: "",
                    usertype: "reduction",
                    pretype: "appoint"
                },
                methods: {
                    rangeChange: function(e) {
                        this.range = ""
                    },
                    categoryLink: function() {
                        var e = this;
                        parent.Fast.api.open("wanlshop/shopsort/select?multiple=true", __("选择类目链接"), {
                            area: ["800px", "600px"],
                            callback: function(t) {
                                e.range = t.url
                            }
                        })
                    },
                    goodsLink: function() {
                        var e = this;
                        parent.Fast.api.open("wanlshop/goods/select?multiple=true", __("选择商品链接"), {
                            area: ["800px", "600px"],
                            callback: function(t) {
                                e.range = t.url
                            }
                        })
                    }
                }
            })
        },
        edit: function() {
            o.api.bindevent();
            new i({
                el: "#app",
                data: {
                    data: Config.row.data,
                    type: Config.row.type,
                    rangetype: Config.row.rangetype,
                    rangename: {
                        goods: "选择商品",
                        category: "选择类目"
                    },
                    range: Config.row.range,
                    usertype: Config.row.usertype,
                    pretype: Config.row.pretype
                },
                methods: {
                    rangeChange: function(e) {
                        this.range = ""
                    },
                    categoryLink: function() {
                        var e = this;
                        parent.Fast.api.open("wanlshop/shopsort/select?multiple=true", __("选择类目链接"), {
                            area: ["800px", "600px"],
                            callback: function(t) {
                                e.range = t.url
                            }
                        })
                    },
                    goodsLink: function() {
                        var e = this;
                        parent.Fast.api.open("wanlshop/goods/select?multiple=true", __("选择商品链接"), {
                            area: ["800px", "600px"],
                            callback: function(t) {
                                e.range = t.url
                            }
                        })
                    }
                }
            })
        },
        api: {
            formatter: {
                mode: function(e, t, a) {
                    var r = "";
                    return ("reduction" == t.type || "vip" == t.type && "reduction" == t.usertype) && (r = "<span>满 " + Number(t.limit) + " 元减" + Number(t.price) + "</span>"),
                    ("discount" == t.type || "vip" == t.type && "discount" == t.usertype) && (r = '<span class="text-success">满 ' + Number(t.limit) + " 元打" + Number(t.discount) + "折</span>"),
                    "shipping" == t.type && (r = '<span class="text-danger">满 ' + Number(t.limit) + " 元包邮</span>"),
                    r
                },
                invalid: function(e, t, a) {
                    return 0 == e ? "fixed" == t.pretype && new Date(t.startdate).getTime() > (new Date).getTime() ? '<span class="text-primary"><i class="fa fa-circle"></i> 尚未开始</span>': '<span class="text-success"><i class="fa fa-circle"></i> 发放中</span>': 1 == e ? '<span class="text-danger"><i class="fa fa-circle"></i> 已失效</span>': void 0
                },
                usenum: function(e, t, a) {
                    return 0 == e ? e: '<span class="label label-danger">' + e + "</span>"
                },
                alreadygrant: function(e, t, a) {
                    return 0 == e ? e: '<span class="label label-success">' + e + "</span>"
                },
                overdue: function(e, t, a) {
                    return "fixed" == t.pretype ? t.enddate: 0 == t.validity ? "长期有效": "领取 " + t.validity + " 天"
                },
                grant: function(e, t, a) {
                    return "-1" == e ? "不限": e + " 张"
                }
            },
            bindevent: function() {
                n.api.bindevent(e("form[role=form]"))
            }
        }
    };
    return o
});