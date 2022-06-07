define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function ($, undefined, Backend, Table, Form) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'wanlshop/link/index' + location.search,
                    add_url: 'wanlshop/link/add',
                    edit_url: 'wanlshop/link/edit',
                    del_url: 'wanlshop/link/del',
                    multi_url: 'wanlshop/link/multi',
                    table: 'wanlshop_link',
                }
            });

            var table = $("#table");

            // 初始化表格
            table.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.index_url,
                pk: 'id',
                sortName: 'weigh',
                columns: [
                    [
                        {checkbox: true},
                        {field: 'id', title: __('Id')},
						{field: 'type', title: __('Type'), searchList: {"system":__('Type system'),"activity":__('Type activity'),"user":__('Type user'),"product":__('Type product'),"page":__('Type page')}, formatter: Table.api.formatter.normal},
                        {field: 'title', title: __('Title')},
                        {field: 'route', title: __('Route')},
                        {field: 'createtime', title: __('Createtime'), operate:'RANGE', addclass:'datetimerange', formatter: Table.api.formatter.datetime},
                        {field: 'updatetime', title: __('Updatetime'), operate:'RANGE', addclass:'datetimerange', formatter: Table.api.formatter.datetime},
                        {field: 'weigh', title: __('Weigh')},
                        {field: 'status', title: __('Status'), searchList: {"normal":__('Normal'),"hidden":__('Hidden')}, formatter: Table.api.formatter.status},
                        {field: 'operate', title: __('Operate'), table: table, events: Table.api.events.operate, formatter: Table.api.formatter.operate}
                    ]
                ]
            });

            // 为表格绑定事件
            Table.api.bindevent(table);
        },
		select: function () {
		    // 初始化表格参数配置
		    Table.api.init({
		        extend: {
		            index_url: 'wanlshop/link/select',
		        }
		    });
		    var urlArr = [];
		
		    var table = $("#table");
		
		    table.on('check.bs.table uncheck.bs.table check-all.bs.table uncheck-all.bs.table', function (e, row) {
		        if (e.type == 'check' || e.type == 'uncheck') {
		            row = [row];
		        } else {
		            urlArr = [];
		        }
		        $.each(row, function (i, j) {
		            if (e.type.indexOf("uncheck") > -1) {
		                var index = urlArr.indexOf(j.route);
		                if (index > -1) {
		                    urlArr.splice(index, 1);
		                }
		            } else {
		                urlArr.indexOf(j.route) == -1 && urlArr.push(j.route);
		            }
		        });
		    });
		
		    // 初始化表格
		    table.bootstrapTable({
		        url: $.fn.bootstrapTable.defaults.extend.index_url,
		        sortName: 'id',
				pagination: false,
				search: false,
		        showToggle: false,
		        showExport: false,
		        columns: [
		            [
		                {field: 'state', checkbox: true},
						{field: 'type', title: __('Type'), searchList: {"system":__('Type system'),"activity":__('Type activity'),"user":__('Type user'),"product":__('Type product'),"page":__('Type page')}, formatter: Table.api.formatter.normal},
						{field: 'image', title: __('Image'), events: Table.api.events.image, formatter: Table.api.formatter.image},
						{field: 'title', title: __('Title')},
						{field: 'route', title: __('Route'), operate: false},
		                {
		                    field: 'operate', title: __('Operate'), events: {
		                        'click .btn-chooseone': function (e, value, row, index) {
		                            var multiple = Backend.api.query('multiple');
		                            multiple = multiple == 'true' ? true : false;
		                            Fast.api.close({url: row.route, multiple: multiple});
		                        },
		                    }, formatter: function () {
		                        return '<a href="javascript:;" class="btn btn-danger btn-chooseone btn-xs"><i class="fa fa-check"></i> ' + __('Choose') + '</a>';
		                    }
		                }
		            ]
		        ]
		    });
		
		    // 选中多个
		    $(document).on("click", ".btn-choose-multi", function () {
		        var multiple = Backend.api.query('multiple');
		        multiple = multiple == 'true' ? true : false;
		        Fast.api.close({url: urlArr.join(","), multiple: multiple});
		    });
		
		    // 为表格绑定事件
		    Table.api.bindevent(table);
		},
        recyclebin: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    'dragsort_url': ''
                }
            });

            var table = $("#table");

            // 初始化表格
            table.bootstrapTable({
                url: 'wanlshop/link/recyclebin' + location.search,
                pk: 'id',
                sortName: 'id',
                columns: [
                    [
                        {checkbox: true},
                        {field: 'id', title: __('Id')},
                        {field: 'title', title: __('Title'), align: 'left'},
                        {
                            field: 'deletetime',
                            title: __('Deletetime'),
                            operate: 'RANGE',
                            addclass: 'datetimerange',
                            formatter: Table.api.formatter.datetime
                        },
                        {
                            field: 'operate',
                            width: '130px',
                            title: __('Operate'),
                            table: table,
                            events: Table.api.events.operate,
                            buttons: [
                                {
                                    name: 'Restore',
                                    text: __('Restore'),
                                    classname: 'btn btn-xs btn-info btn-ajax btn-restoreit',
                                    icon: 'fa fa-rotate-left',
                                    url: 'wanlshop/link/restore',
                                    refresh: true
                                },
                                {
                                    name: 'Destroy',
                                    text: __('Destroy'),
                                    classname: 'btn btn-xs btn-danger btn-ajax btn-destroyit',
                                    icon: 'fa fa-times',
                                    url: 'wanlshop/link/destroy',
                                    refresh: true
                                }
                            ],
                            formatter: Table.api.formatter.operate
                        }
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