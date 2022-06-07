"use strict";
define(["jquery", "bootstrap", "backend", "table", "form", "template"],
function(e, t, a, i, r, n) {
    var o = {
        index: function() {
            i.api.init({
                extend: {
                    index_url: "wanlshop/order/index" + location.search,
                    add_url: "",
                    edit_url: "",
                    del_url: "wanlshop/order/del",
                    multi_url: "wanlshop/order/multi",
                    table: "wanlshop_order"
                }
            });
            var t = e("#table");
            n.helper("cdnurl",
            function(e) {
                return Fast.api.cdnurl(e)
            }),
            n.helper("Moment", Moment),
            t.bootstrapTable({
                url: e.fn.bootstrapTable.defaults.extend.index_url,
                templateView: !0,
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
                    field: "user.nickname",
                    title: __("User.nickname"),
                    align: "left",
                    formatter: i.api.formatter.search
                },
                {
                    field: "user.isshua",
                    title: '是否刷单',
                    searchList: {
                        0 : '否',
                        1 : '是'
                    },
                    formatter: i.api.formatter.normal
                },
                {
                    field: "user.username",
                    title: '用户电话',
                    align: "left",
                    formatter: i.api.formatter.search
                },
                {
                    field: "shop.shopname",
                    title: __("Shop_id"),
                    align: "left",
                    formatter: i.api.formatter.search
                },
                {
                    field: "order_no",
                    title: __("Order_no")
                },
                {
                    field: "express_no",
                    title: __("Express_no")
                },
                {
                    field: "state",
                    title: __("State"),
                    searchList: {
                        1 : __("State 1"),
                        2 : __("State 2"),
                        3 : __("State 3"),
                        4 : __("State 4"),
                        6 : __("State 6"),
                        7 : __("State 7")
                    },
                    formatter: i.api.formatter.normal
                },
                {
                    field: "createtime",
                    title: __("Createtime"),
                    operate: "RANGE",
                    addclass: "datetimerange",
                    formatter: i.api.formatter.datetime
                },
                {
                    field: "paymenttime",
                    title: __("Paymenttime"),
                    operate: "RANGE",
                    addclass: "datetimerange",
                    formatter: i.api.formatter.datetime
                },
                {
                    field: "delivertime",
                    title: __("Delivertime"),
                    operate: "RANGE",
                    addclass: "datetimerange",
                    formatter: i.api.formatter.datetime
                },
                {
                    field: "dealtime",
                    title: __("Dealtime"),
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
            i.api.bindevent(t),
            e(document).on("click", ".detail[data-id]",
            function() {
                a.api.open("wanlshop/order/detail/id/" + e(this).data("id"), __("查看详情"), {
                    area: ["1200px", "780px"]
                })
            }),
            e(document).on("click", ".comment[data-id]",
            function() {
                a.api.open("wanlshop/comment/detail/type/1/ids/" + e(this).data("id"), __("查看详情"))
            }),
            e(document).on("click", ".kuaidisub[data-id]",
            function() {
                a.api.open("wanlshop/order/relative/id/" + e(this).data("id"), __("快递查询"), {
                    area: ["800px", "600px"]
                })
            })
        },
        recyclebin: function() {
            i.api.init({
                extend: {
                    dragsort_url: ""
                }
            });
            var t = e("#table");
            t.bootstrapTable({
                url: "wanlshop/order/recyclebin" + location.search,
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
                        url: "wanlshop/order/restore",
                        refresh: !0
                    },
                    {
                        name: "Destroy",
                        text: __("Destroy"),
                        classname: "btn btn-xs btn-danger btn-ajax btn-destroyit",
                        icon: "fa fa-times",
                        url: "wanlshop/order/destroy",
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
        relative: function() {},
        detail: function() {
            e(document).on("click", ".kuaidisub[data-id]",
            function() {
                a.api.open("wanlshop/order/relative/id/" + e(this).data("id"), __("快递查询"), {
                    area: ["800px", "600px"]
                })
            })
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
function selectAll(){
    var isCheck=$("#order_0").is(':checked');  //获得全选复选框是否选中
    $("input[name='checkbox']").each(function() {  
        var i = this.getAttribute('data-id');
        if(i!=0){
            console.log(i)
            this.click()
            //this.checked = isCheck;   
        }
    });
}