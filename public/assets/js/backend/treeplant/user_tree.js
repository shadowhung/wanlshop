define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'treeplant/user_tree/index' + location.search,
                    // add_url: 'treeplant/user_tree/add',
                    // edit_url: 'treeplant/user_tree/edit',
                    del_url: 'treeplant/user_tree/del',
                    // multi_url: 'treeplant/user_tree/multi',
                    table: 'user_tree',
                }
            });

            var table = $("#table");

            // 初始化表格
            table.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.index_url,
                pk: 'id',
                sortName: 'id',
                columns: [
                    [
                        {checkbox: true},
                        {field: 'id', title: __('Id')},
                        {field: 'type', title: __('Type'), searchList: {"1": __('Type 1'), "2": __('Type 2')}, formatter: Table.api.formatter.normal},
                        {field: 'order_sn', title: __('Order_sn')},
                        {field: 'user_id', title: __('User_id')},
                        {field: 'tree_id', title: __('Tree_id')},
                        {field: 'title', title: __('Title')},
                        {field: 'output', title: __('Output'), operate: 'BETWEEN'},
                        {field: 'cycle', title: __('Cycle')},
                        {field: 'expire', title: __('Expire')},
                        {field: 'active', title: __('Active')},
                        {field: 'released', title: __('Released'), operate: 'BETWEEN'},
                        {field: 'remain', title: __('Remain'), operate: 'BETWEEN'},
                        {field: 'create_time', title: __('Create_time'), operate: 'RANGE', addclass: 'datetimerange', formatter: Table.api.formatter.datetime},
                        {field: 'expire_time', title: __('Expire_time'), operate: 'RANGE', addclass: 'datetimerange', formatter: Table.api.formatter.datetime},
                        {field: 'last_release_time', title: __('Last_release_time'), operate: 'RANGE', addclass: 'datetimerange', formatter: Table.api.formatter.datetime},
                        {field: 'status', title: __('Status'), searchList: {"1": __('Status 1'), "0": __('Status 0')}, formatter: Table.api.formatter.status},
                        {field: 'last_cutdown_time', title: __('Last_cutdown_time'), operate: 'RANGE', addclass: 'datetimerange', formatter: Table.api.formatter.datetime},
                        {field: 'operate', title: __('Operate'), table: table, events: Table.api.events.operate, formatter: Table.api.formatter.operate}
                    ]
                ]
            });

            // 为表格绑定事件
            Table.api.bindevent(table);
        },
        add: function () {
            Controller.api.bindevent();
        },
        edit: function () {
            Controller.api.bindevent();
        },
        clear: function () {
            var flag = false;
            var timer
            $('#start').click(function () {
                timer = setInterval(function () {
                    if (flag) return false;

                    flag = true;
                    $.post('treeplant/user_tree/clear', {}, function (res) {
                        $('#res').html('').html(res)
                        flag = false;
                        return false;
                    }, 'html');
                }, 3000);
            })

            $('#end').click(function () {
                clearInterval(timer)
            })

            Controller.api.bindevent();
        },
        api: {
            bindevent: function () {
                Form.api.bindevent($("form[role=form]"));
            }
        }
    };
    return Controller;
});