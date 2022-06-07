"use strict";
define(["jquery", "bootstrap", "backend", "table", "form"],
function(e, t, a, i, r) {
    var l = {
        index: function() {
            i.api.init({
                extend: {
                    index_url: "wanlshop/goods/index" + location.search,
                    add_url: "",
                    edit_url: "",
                    del_url: "wanlshop/goods/del",
                    multi_url: "wanlshop/goods/multi",
                    table: "wanlshop_goods"
                }
            });
            var t = e("#table");
            t.bootstrapTable({
                url: e.fn.bootstrapTable.defaults.extend.index_url,
                pk: "id",
                sortName: "weigh",
                columns: [[{
                    checkbox: !0
                },
                {
                    field: "id",
                    title: __("Id")
                },
                {
                    field: "shop_id",
                    title: __("Shop_Id")
                },
                {
                    field: "shop.shopname",
                    title: __("Shop.shopname"),
                    formatter: i.api.formatter.search
                },
                {
                    field: "wholesale_id",
                    title: '是否批发',
                    searchList: {"0": '否'},
                    formatter: i.api.formatter.normal
                },
                {
                    field: "title",
                    title: __("Title")
                },
                {
                    field: "image",
                    title: __("Image"),
                    events: i.api.events.image,
                    formatter: i.api.formatter.image
                },
                {
                    field: "images",
                    title: __("Images"),
                    events: i.api.events.image,
                    formatter: i.api.formatter.images
                },
                {
                    field: "category.name",
                    title: __("Category.name"),
                    formatter: i.api.formatter.search
                },
                {
                    field: "shopsort.name",
                    title: __("Shopsort.name"),
                    formatter: i.api.formatter.search
                },
                {
                    field: "stock",
                    title: __("Stock"),
                    searchList: {
                        porder: __("Stock porder"),
                        payment: __("Stock payment")
                    },
                    formatter: i.api.formatter.normal
                },
                {
                    field: "price",
                    title: __("Price"),
                    operate: "BETWEEN"
                },
                {
                    field: "specs",
                    title: __("Specs"),
                    searchList: {
                        single: __("Specs single"),
                        multi: __("Specs multi")
                    },
                    formatter: i.api.formatter.normal
                },
                {
                    field: "views",
                    title: __("Views")
                },
                {
                    field: "sales",
                    title: __("Sales")
                },
                {
                    field: 'buttons',
                    title: '快捷操作',
                    table: t,
                    events: i.api.events.operate,
                    buttons: [
                        {
                            name: 'sales',
                            text: '修改销量',
                            title: '修改销量',
                            classname: 'btn btn-xs btn-success btn-click',
                            url: 'wanlshop/goods/sales',
                            refresh: true,
                            click: function (data, row) {
                                layer.prompt({title: '请输入新的销量',}, function (value, index, elem) {
                                    if (parseFloat(value) < 0 || value - row.sales == 0) {
                                        //alert('没有改变');
                                        Toastr.error("没有改变")
                                        //layer.close(index);
                                        return false;
                                    }

                                    Fast.api.ajax({
                                        url: 'wanlshop/goods/sales',
                                        data: {'ids': row.id, 'sales': parseFloat(value)}
                                    });
                                    layer.close(index);
                                });
                            }
                        }
                    ],
                    formatter: i.api.formatter.buttons,
                    operate: false
                },
                {
                    field: "comment",
                    title: __("Comment")
                },
                {
                    field: "praise",
                    title: __("Praise")
                },
                {
                    field: "like",
                    title: __("Like")
                },
                {
                    field: "weigh",
                    title: __("Weigh")
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
                url: "wanlshop/goods/recyclebin" + location.search,
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
                    field: "title",
                    title: __("Title"),
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
                        url: "wanlshop/goods/restore",
                        refresh: !0
                    },
                    {
                        name: "Destroy",
                        text: __("Destroy"),
                        classname: "btn btn-xs btn-danger btn-ajax btn-destroyit",
                        icon: "fa fa-times",
                        url: "wanlshop/goods/destroy",
                        refresh: !0
                    }],
                    formatter: i.api.formatter.operate
                }]]
            }),
            i.api.bindevent(t)
        },
        select: function() {
            i.api.init({
                extend: {
                    index_url: "wanlshop/goods/select"
                }
            });
            var t = [],
            r = e("#table");
            r.on("check.bs.table uncheck.bs.table check-all.bs.table uncheck-all.bs.table",
            function(a, i) {
                "check" == a.type || "uncheck" == a.type ? i = [i] : t = [],
                e.each(i,
                function(e, i) {
                    if (a.type.indexOf("uncheck") > -1) {
                        var r = t.indexOf(i.id);
                        r > -1 && t.splice(r, 1)
                    } else - 1 == t.indexOf(i.id) && t.push(i.id)
                })
            }),
            r.bootstrapTable({
                url: e.fn.bootstrapTable.defaults.extend.index_url,
                sortName: "id",
                showToggle: !1,
                showExport: !1,
                columns: [[{
                    checkbox: !0
                },
                {
                    field: "id",
                    title: __("Id")
                },
                {
                    field: "image",
                    title: __("Image"),
                    events: i.api.events.image,
                    formatter: i.api.formatter.image
                },
                {
                    field: "title",
                    title: __("Title")
                },
                {
                    field: "updatetime",
                    title: __("Updatetime"),
                    operate: "RANGE",
                    addclass: "datetimerange",
                    formatter: i.api.formatter.datetime
                },
                {
                    field: "operate",
                    title: __("Operate"),
                    events: {
                        "click .btn-chooseone": function(e, t, i, r) {
                            var l = a.api.query("multiple");
                            l = "true" == l,
                            Fast.api.close({
                                url: i.id,
                                multiple: l
                            })
                        }
                    },
                    formatter: function() {
                        return '<a href="javascript:;" class="btn btn-danger btn-chooseone btn-xs"><i class="fa fa-check"></i> ' + __("Choose") + "</a>"
                    }
                }]]
            }),
            e(document).on("click", ".btn-choose-multi",
            function() {
                var e = a.api.query("multiple");
                e = "true" == e,
                Fast.api.close({
                    url: t.join(","),
                    multiple: e
                })
            }),
            i.api.bindevent(r)
        },
        add: function() {
            l.api.bindevent()
        },
        edit: function() {
            l.api.bindevent()
        },
        api: {
            bindevent: function() {
                r.api.bindevent(e("form[role=form]"))
            }
        }
    };
    return l
});