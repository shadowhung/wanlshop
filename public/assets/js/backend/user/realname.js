define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'user/realname/index',
                    add_url: 'user/realname/add',
                    edit_url: 'user/realname/edit',
                    del_url: 'user/realname/del',
                    multi_url: 'user/realname/multi',
                    table: 'user',
                }
            });

            var table = $("#table");

            // 初始化表格
            table.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.index_url,
                pk: 'id',
                sortName: 'id',
                // sortName: 'user.id',
                columns: [
                    [
                        {checkbox: true},
                        {field: 'id', title: __('Id'), sortable: true},
                        // {field: 'group.name', title: __('Group')},
                        // {field: 'username', title: __('Username'), operate: 'LIKE'},
                        {field: 'mobile', title: __('Mobile'), operate: 'LIKE'},
                        {field: 'nickname', title: __('Nickname'), operate: false},
                        // {field: 'successions', title: __('Successions'), visible: false, operate: 'BETWEEN', sortable: true},
                        // {field: 'maxsuccessions', title: __('Maxsuccessions'), visible: false, operate: 'BETWEEN', sortable: true},
                        // {field: 'logintime', title: __('Logintime'), formatter: Table.api.formatter.datetime, operate: 'RANGE', addclass: 'datetimerange', sortable: true},
                        // {field: 'loginip', title: __('Loginip'), formatter: Table.api.formatter.search},
                        // {field: 'jointime', title: __('Jointime'), formatter: Table.api.formatter.datetime, operate: 'RANGE', addclass: 'datetimerange', sortable: true},
                        // {field: 'joinip', title: __('Joinip'), formatter: Table.api.formatter.search},
                        {field: 'is_verification', title: __('Is_verification'), formatter: Table.api.formatter.status, searchList: {0: __('Is_verification 0'), 1: __('Is_verification 1')}},
                        {
                            field: 'buttons',
                            title: '人工审核',
                            table: table,
                            events: Table.api.events.operate,
                            buttons: [
                                {
                                    name: 'yes',
                                    text: '通过',
                                    title: '审核通过',
                                    classname: 'btn btn-xs btn-success btn-ajax',
                                    url: 'user/realname/checkVerification?status=1',
                                    confirm:'确定要通过吗？',
                                    visible: function (row) {
                                        console.log(row.idcard)
                                        if (row.is_verification == 0 && row.idcard != '') {
                                            return true
                                        }
                                        return false
                                    },
                                    refresh: true
                                },
                                {
                                    name: 'no',
                                    text: '不通过',
                                    title: '审核不通过',
                                    classname: 'btn btn-xs btn-danger btn-ajax',
                                    url: 'user/realname/checkVerification?status=0',
                                    confirm:'确定审核不通过吗？',
                                    visible: function (row) {
                                        if (row.is_verification == 0 && row.idcard != '') {
                                            return true
                                        }
                                        return false
                                    },
                                    refresh: true
                                },
                            ],
                            formatter: Table.api.formatter.buttons,
                            operate: false
                        },
                        {field: 'name', title: __('Name'), operate: 'like'},
                        {field: 'idcard', title: __('Idcard'), operate: 'like'},
                        {field: 'person_verification_time', title: __('Person_verification_time'), formatter: Table.api.formatter.datetime, operate: 'RANGE', addclass: 'datetimerange', sortable: true},
                        {field: 'is_shop_verification', title: __('Is_shop_verification'), formatter: Table.api.formatter.status, searchList: {0: __('Is_shop_verification 0'), 1: __('Is_shop_verification 1')}},
                        {
                            field: 'buttons',
                            title: '认证信息',
                            table: table,
                            events: Table.api.events.operate,
                            buttons: [
                                {
                                    name: 'detail',
                                    text: '查看',
                                    title: '认证信息',
                                    classname: 'btn btn-xs btn-success btn-dialog',
                                    url: 'user/realname/verification',
                                },
                                {
                                    name: 'detail',
                                    text: '修改',
                                    title: '修改认证信息',
                                    classname: 'btn btn-xs btn-danger btn-dialog',
                                    url: 'user/realname/editVerification',
                                    visible: function (row) {
                                        return row.is_verification == 1 ? true : false;
                                    }
                                },
                                {
                                    name: 'detail',
                                    text: '人工认证',
                                    title: '人工认证',
                                    classname: 'btn btn-xs btn-warning btn-dialog',
                                    url: 'user/realname/humanVerification',
                                    visible: function (row) {
                                        return row.is_verification == 1 ? false : true;
                                    }
                                },
                            ],
                            formatter: Table.api.formatter.buttons,
                            operate: false
                        },
                        {field: 'province.name', title: __('Province'), operate: 'like'},
                        {field: 'city.name', title: __('City'), operate: 'like'},
                        {field: 'county.name', title: __('County'), operate: 'like'},
                        {field: 'is_agent', title: __('Is agent'),formatter: Table.api.formatter.toggle, searchList: {1: __('Is agent 1'), 0: __('Is agent 0')}},
                        {field: 'status', title: __('Status'), formatter: Table.api.formatter.status, searchList: {1: __('Status 1'), 0: __('Status 0')}},
                        {field: 'operate', title: __('Operate'), table: table, events: Table.api.events.operate, formatter: Table.api.formatter.operate}
                    ]
                ]
            });

            $('.btn-clear').click(function () {
                layer.confirm('确定要清理么？', {
                    btn: ['确定', '算了']
                }, function (index) {
                    Fast.api.ajax({
                        'url': 'user/realname/clear',
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

            // 为表格绑定事件
            Table.api.bindevent(table);
        },
        add: function () {
            Controller.api.bindevent();
        },
        edit: function () {
            Controller.api.bindevent();
        },
        verification: function () {
            $(document).on('click', '.image', function () {
                window.open($(this).attr('src'), '_blank');
            });

            Controller.api.bindevent();
        },
        editverification: function () {
            Controller.api.bindevent();
        },
        humanverification: function () {
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