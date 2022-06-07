define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'finance/bonus/index' + location.search,
                    add_url: 'finance/bonus/add',
                    edit_url: 'finance/bonus/edit',
                    del_url: 'finance/bonus/del',
                    multi_url: 'finance/bonus/multi',
                    table: 'bonus',
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
                        {field: 'bonus_amount', title: __('Bonus_amount'), operate: 'BETWEEN'},
                        {field: 'person', title: __('Person')},
                        {field: 'createtime', title: __('Createtime'), operate: 'RANGE', addclass: 'datetimerange', formatter: Table.api.formatter.datetime},
                        {field: 'operate', title: __('Operate'), table: table, events: Table.api.events.operate, formatter: Table.api.formatter.operate}
                    ]
                ]
            });

            // 为表格绑定事件
            Table.api.bindevent(table);
        },
        add: function () {
            $('.btn-dobonus').click(function () {
                layer.confirm('确定要分红？', {
                    btn: ['确定', '算了']
                }, function (index) {
                    Fast.api.ajax({
                        'url': 'finance/bonus/add',
                        data: $('#add-form').serialize()
                    }, function (res) {
                        layer.close(index)
                        setTimeout(function () {
                            $('#btn').remove()
                            parent.location.reload()
                        }, 1000)
                    })
                });
            })
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