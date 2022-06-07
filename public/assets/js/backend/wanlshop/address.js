"use strict";
define(["jquery", "bootstrap", "backend", "table", "form"],
function(e, t, a, i, d) {
    var r = {
        index: function() {
            i.api.init({
                extend: {
                    index_url: "wanlshop/address/index" + location.search,
                    add_url: "wanlshop/address/add",
                    edit_url: "wanlshop/address/edit",
                    del_url: "wanlshop/address/del",
                    multi_url: "wanlshop/address/multi",
                    table: "wanlshop_address"
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
                    title: __("Name")
                },
                {
                    field: "mobile",
                    title: __("Mobile")
                },
                {
                    field: "default",
                    title: __("Default"),
                    searchList: {
                        1 : __("Default 1"),
                        0 : __("Default 0")
                    },
                    formatter: i.api.formatter.normal
                },
                {
                    field: "country",
                    title: __("Country")
                },
                {
                    field: "province",
                    title: __("Province")
                },
                {
                    field: "city",
                    title: __("City")
                },
                {
                    field: "citycode",
                    title: __("Citycode")
                },
                {
                    field: "district",
                    title: __("District")
                },
                {
                    field: "adcode",
                    title: __("Adcode")
                },
                {
                    field: "formatted_address",
                    title: __("Formatted_address")
                },
                {
                    field: "address",
                    title: __("Address")
                },
                {
                    field: "address_name",
                    title: __("Address_name")
                },
                {
                    field: "location",
                    title: __("Location")
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
                url: "wanlshop/address/recyclebin" + location.search,
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
                        url: "wanlshop/address/restore",
                        refresh: !0
                    },
                    {
                        name: "Destroy",
                        text: __("Destroy"),
                        classname: "btn btn-xs btn-danger btn-ajax btn-destroyit",
                        icon: "fa fa-times",
                        url: "wanlshop/address/destroy",
                        refresh: !0
                    }],
                    formatter: i.api.formatter.operate
                }]]
            }),
            i.api.bindevent(t)
        },
        add: function() {
            r.api.bindevent()
        },
        edit: function() {
            r.api.bindevent()
        },
        api: {
            bindevent: function() {
                d.api.bindevent(e("form[role=form]"))
            }
        }
    };
    return r
});