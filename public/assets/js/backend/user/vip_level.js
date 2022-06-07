define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'user/vip_level/index' + location.search,
                    // add_url: 'user/vip_level/add',
                    edit_url: 'user/vip_level/edit',
                    // del_url: 'user/vip_level/del',
                    // multi_url: 'user/vip_level/multi',
                    table: 'user_vip_level',
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
                        {field: 'level', title: __('Level')},
                        {field: 'name', title: __('Name')},
                        {field: 'direct', title: __('Direct')},
                        {field: 'league_active', title: __('League_active'), operate:'BETWEEN'},
                        {field: 'team_active', title: __('Team_active'), operate:'BETWEEN'},
                        {field: 'direct_vip', title: __('Direct_vip')},
                        {field: 'ratio', title: __('Ratio'), operate:'BETWEEN'},
                        {field: 'tree.title', title: __('Upgrade_tree_id')},
                        {field: 'upgrade_active', title: __('Upgrade_active'), operate:'BETWEEN'},
                        {field: 'createtime', title: __('Createtime'), operate:'RANGE', addclass:'datetimerange', formatter: Table.api.formatter.datetime},
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
        api: {
            bindevent: function () {
                Form.api.bindevent($("form[role=form]"));
            }
        }
    };
    return Controller;
});