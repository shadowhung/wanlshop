define(['jquery', 'bootstrap', 'backend', 'table', 'form', 'template', 'jquery-jqprint', 'jquery-migrate'], function ($, undefined, Backend, Table, Form, Template, Jqprint, Migrate) {



    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'wanlshop/wholeorder/index' + location.search,
                    add_url: '',
                    edit_url: '',
                    del_url: 'wanlshop/wholeorder/del',
                    multi_url: 'wanlshop/wholeorder/multi',
                    table: 'wanlshop_order',
                }
            });
            var table = $("#table");

			Template.helper("Moment", Moment);

			Template.helper("cdnurl", function(image) {

				return Fast.api.cdnurl(image); 

			}); 

            // 初始化表格
            table.bootstrapTable({
                url: $.fn.bootstrapTable.defaults.extend.index_url,

				templateView: true,
                pk: 'id',
                sortName: 'id',
                columns: [
                    [
                        {checkbox: true},
                        {field: 'id', title: __('Id')},
                        {field: 'user.nickname', title: __('User.nickname'), align: 'left', formatter: Table.api.formatter.search},
                        {field: 'order_no', title: __('Order_no')},
                        {field: 'express_no', title: __('Express_no')},
                        {field: 'state', title: __('State'), searchList: {"1":__('State 1'),"2":__('State 2'),"3":__('State 3'),"4":__('State 4'),"6":__('State 6'),"7":__('State 7')}, formatter: Table.api.formatter.normal},
                        {field: 'createtime', title: __('Createtime'), operate:'RANGE', addclass:'datetimerange', formatter: Table.api.formatter.datetime},
                        {field: 'paymenttime', title: __('Paymenttime'), operate:'RANGE', addclass:'datetimerange', formatter: Table.api.formatter.datetime},
                        {field: 'delivertime', title: __('Delivertime'), operate:'RANGE', addclass:'datetimerange', formatter: Table.api.formatter.datetime},
                        {field: 'dealtime', title: __('Dealtime'), operate:'RANGE', addclass:'datetimerange', formatter: Table.api.formatter.datetime},
                        {field: 'status', title: __('Status'), searchList: {"normal":__('Normal'),"hidden":__('Hidden')}, formatter: Table.api.formatter.status},
                        {field: 'operate', title: __('Operate'), table: table, events: Table.api.events.operate, formatter: Table.api.formatter.operate}
                    ]
                ]
            });
            // 为表格绑定事件
            Table.api.bindevent(table);

			//点击详情

			$(document).on("click", ".detail[data-id]", function () {

			    Backend.api.open('wanlshop/wholeorder/detail/id/' + $(this).data('id'), __('查看详情'),{area:['1200px', '780px']});

			});

			//查看退款

			$(document).on("click", ".refund[data-id]", function () {

			    Backend.api.open('wanlshop/wholerefund/detail/ids/' + $(this).data('id'), __('查看退款'));

			});

			// 查看评论

			$(document).on("click", ".comment[data-id]", function () {

			    Backend.api.open('wanlshop/commentfront/detail/type/1/ids/' + $(this).data('id'), __('查看评论'));

			});

			// 查看退款

			$(document).on("click", ".btn-selected", function () {

			    Backend.api.open('wanlshop/wholerefund/detail/type/1/ids/' + $(this).data('id'), __('查看退款'));

			});

			// 即时沟通

			$(document).on("click", ".btn-delone", function () {

				chatFun({

					user_id: $(this).data('id'),

					nickname: $(this).data('name'),

					avatar: $(this).data('avatar'),

					isOnline: 1

				}, 'fun');

			});

			// 发货 & 批量发货

			$(document).on("click", ".btn-delivery", function () {

				if($(this).data('id')){

					Backend.api.open('wanlshop/wholeorder/delivery/ids/' + $(this).data('id'), __('发货'),{area:['1000px', '700px']});

				}else{

					Backend.api.open('wanlshop/wholeorder/delivery/ids/' + Table.api.selectedids(table), __('批量发货'),{area:['1000px', '700px']});

				}

			});

			// 打印 & 批量打印订单 自动关闭窗口parent.Layer.closeAll();

			$(document).on("click", ".btn-invoice", function () {

				if($(this).data('id')){

					Backend.api.open('wanlshop/wholeorder/invoice/ids/' + $(this).data('id'), __('查看发货单'),{area:['1100px', '750px']});

				}else{

					Backend.api.open('wanlshop/wholeorder/invoice/ids/' + Table.api.selectedids(table), __('批量查看发货单'),{area:['1100px', '750px']});

				}

			});

			// 查询物流状态

			$(document).on("click", ".kuaidisub[data-id]", function () {

			    Backend.api.open('wanlshop/wholeorder/relative/id/' + $(this).data('id'), __('快递查询'),{area:['800px', '600px']});

			});

			// 提交云面单

			$(document).on("click", ".btn-express", function () {

				Layer.alert('订单' + JSON.stringify(Table.api.selectedids(table)) + '无法云打印,因为API接口维护中...');

			});

        },

		comment: function () {

			// 初始化表格参数配置

			Table.api.init({

			    extend: {

			        index_url: 'wanlshop/commentfront/index' + location.search,

			        add_url: '',

			        edit_url: '',

			        del_url: '',

			        multi_url: '',

			        table: 'wanlshop_goods_comment',

			    }

			});

			

			var table = $("#table");

			

			// 初始化表格

			table.bootstrapTable({

			    url: $.fn.bootstrapTable.defaults.extend.index_url,

			    pk: 'id',

			    sortName: 'id',

				searchFormVisible:true,

			    columns: [

			        [

			            {checkbox: true},

			            {field: 'id', title: __('Id')},

			            {field: 'user.nickname', title: __('User.nickname'), formatter: Table.api.formatter.search},

			            {field: 'goods.title', title: __('goods.title'), formatter: Table.api.formatter.search},

			            {field: 'state', title: __('States'), searchList: {"0":__('States 0'),"1":__('States 1'),"2":__('States 2')}, formatter: Table.api.formatter.normal},

			            {field: 'images', title: __('Images'), events: Table.api.events.image, formatter: Table.api.formatter.images},

			            {field: 'score', title: __('Score'), operate:'BETWEEN'},

			            {field: 'score_describe', title: __('Score_describe'), operate:'BETWEEN'},

			            {field: 'score_service', title: __('Score_service'), operate:'BETWEEN'},

			            {field: 'score_deliver', title: __('Score_deliver'), operate:'BETWEEN'},

			            {field: 'score_logistics', title: __('Score_logistics'), operate:'BETWEEN'},

			            {field: 'createtime', title: __('Createtime'), operate:'RANGE', addclass:'datetimerange', formatter: Table.api.formatter.datetime},

			            {field: 'updatetime', title: __('Updatetime'), operate:'RANGE', addclass:'datetimerange', formatter: Table.api.formatter.datetime},

			            {field: 'status', title: __('Status'), searchList: {"normal":__('Normal'),"hidden":__('Hidden')}, formatter: Table.api.formatter.status},

			            {field: 'operate', title: __('Operate'), table: table, events: Table.api.events.operate,buttons: [{name: 'detail',title: __('查看评论'),classname: 'btn btn-xs btn-info btn-dialog',icon: 'fa fa-eye',url: 'wanlshop/commentfront/detail'}],formatter: Table.api.formatter.operate}

			        ]

			    ]

			});

			

			// 为表格绑定事件

			Table.api.bindevent(table);

		},
		invoice: function () {

			$(document).on("click", ".btn-embossed", function () {

				$("#print_html").jqprint();

				$(".btn-embossed").text("初始化打印..");

				setTimeout(function() { 
					parent.Layer.closeAll();
				},1000);

			});

        },

		relative: function () {

			

		},

		detail: function () {

			// 查询物流状态

			$(document).on("click", ".kuaidisub[data-id]", function () {

			    Backend.api.open('wanlshop/wholeorder/relative/id/' + $(this).data('id'), __('快递查询'),{area:['800px', '600px']});

			});

		},

        delivery: function () {

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