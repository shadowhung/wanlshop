define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'finance/user_cash/index' + location.search,
                    del_url: 'finance/user_cash/del',
                    table: 'user_cash',
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
                        {field: 'order_sn', title: __('Order_sn')},
                        {field: 'user_id', title: __('User_id')},
                        {field: 'payment_id', title: __('收款账号ID')},
                        {field: 'payment.type_text', title: __('收款方式')},
                        {field: 'payment.name', title: __('姓名')},
                        {field: 'payment.nickname', title: __('昵称'), operate: false},
                        {field: 'user.name', title: __('身份证姓名'), operate: false},
                        {field: 'user.front', title: __('身份证正面照'), operate: false, events: Table.api.events.image, formatter: Table.api.formatter.image},
                        {field: 'payment.account', title: __('收款账号')},
                        {field: 'payment.qrcode', title: __('收款二维码'), operate: false, events: Table.api.events.image, formatter: Table.api.formatter.image},
                        {field: 'payment.bankname', title: __('银行名称'), operate: false},
                        {field: 'amount', title: __('Amount'), operate: 'BETWEEN'},
                        {field: 'fee_ratio', title: __('Fee_ratio'), operate: 'BETWEEN'},
                        {field: 'fee', title: __('Fee'), operate: 'BETWEEN'},
                        {
                            field: 'real_amount', title: __('Real_amount'), operate: 'BETWEEN', formatter: function (value) {
                                return parseFloat(value)
                            }
                        },
                        {field: 'createtime', title: __('Createtime'), operate: 'RANGE', addclass: 'datetimerange', formatter: Table.api.formatter.datetime},
                        {field: 'confirm_time', title: __('Confirm_time'), operate: 'RANGE', addclass: 'datetimerange', formatter: Table.api.formatter.datetime},
                        {field: 'pay_time', title: __('Pay_time'), operate: 'RANGE', addclass: 'datetimerange', formatter: Table.api.formatter.datetime},
                        {field: 'status', title: __('Status'), searchList: {"0": __('Status 0'), "1": __('Status 1'), "2": __('Status 2'), "3": __('Status 3')}, formatter: Table.api.formatter.status},
                        {
                            field: 'buttons',
                            title: '快捷操作',
                            table: table,
                            events: Table.api.events.operate,
                            buttons: [
                                {
                                    name: 'pass',
                                    text: '通过',
                                    title: '通过',
                                    classname: 'btn btn-xs btn-success btn-ajax',
                                    icon: 'fa fa-info',
                                    url: 'finance/user_cash/status?status=1',
                                    confirm: '确认要通过该提现申请吗？',
                                    refresh: true,
                                    visible: function (row) {
                                        return row.status == 0 ? true : false;
                                    }
                                },
                                {
                                    name: 'nopass',
                                    text: '不通过',
                                    title: '不通过',
                                    classname: 'btn btn-xs btn-warning btn-ajax',
                                    icon: 'fa fa-info',
                                    url: 'finance/user_cash/status?status=2',
                                    confirm: '确认拒绝该提现申请吗？',
                                    refresh: true,
                                    visible: function (row) {
                                        return row.status == 0 ? true : false;
                                    }
                                },
                                {
                                    name: 'sendmoney',
                                    text: '确认打款',
                                    title: '确认打款',
                                    classname: 'btn btn-xs btn-danger btn-ajax',
                                    icon: 'fa fa-info',
                                    url: 'finance/user_cash/status?status=3',
                                    confirm: '确定已经给用户打款了吗？',
                                    refresh: true,
                                    visible: function (row) {
                                        return row.status == 1 ? true : false;
                                    }
                                }
                            ],
                            formatter: Table.api.formatter.buttons,
                            operate: false
                        },
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