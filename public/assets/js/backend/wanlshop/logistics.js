define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function($, undefined, Backend,Table, Form) {

    var Controller = {
        deliver: function () {

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

			Template.helper("cdnurl", function(image) {

				return Fast.api.cdnurl(image); 

			}); 

        	Template.helper("Moment", Moment);

        	

			table.on('post-common-search.bs.table', function (event, table) {

			    $('ul.nav-tabs li a[data-value="2"]').trigger('click');

			    $(".form-commonsearch select[name=state]").val("2");

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

                        {field: 'user.username', title: __('User.username'), align: 'left', formatter: Table.api.formatter.search},

                        {field: 'order_no', title: __('Order_no')},
                        
                        {field: 'shop.shopname', title: '商户名', align: 'left', formatter: Table.api.formatter.search},

                        {field: 'express_no', title: __('Express_no')},

                        {field: 'state', title: __('State'), searchList: {"2":__('State 2'),"3":__('State 3'),"4":__('State 4'),"5":__('State 5'),"6":__('State 6'),"7":__('State 7')}, formatter: Table.api.formatter.normal},

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

			    Backend.api.open('wanlshop/comment/detail/type/1/ids/' + $(this).data('id'), __('查看评论'));

			});

			// 查看退款

			$(document).on("click", ".btn-selected", function () {

			    Backend.api.open('wanlshop/wholerefund/detail/type/1/ids/' + $(this).data('id'), __('查看退款'));

			});

			// 即时沟通

			$(document).on("click", ".btn-delone", function () {

				chatFun({user_id: $(this).data('id'),nickname: $(this).data('name'),avatar: $(this).data('avatar'),isOnline: 1}, 'fun');

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

		template: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'wanlshop/freightfront/index' + location.search,
                    add_url: 'wanlshop/freightfront/add',
                    edit_url: 'wanlshop/freightfront/edit',
                    del_url: 'wanlshop/freightfront/del',
                    multi_url: 'wanlshop/freightfront/multi',
                    table: 'wanlshop_shop_freight',
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
                        {field: 'name', title: __('Name')},
                        {field: 'delivery', title: __('Delivery'), searchList: {"0":__('Delivery 0'),"1":__('Delivery 1'),"2":__('Delivery 2'),"3":__('Delivery 3'),"4":__('Delivery 4'),"5":__('Delivery 5'),"6":__('Delivery 6'),"7":__('Delivery 7'),"8":__('Delivery 8'),"9":__('Delivery 9'),"10":__('Delivery 10'),"11":__('Delivery 11'),"12":__('Delivery 12'),"13":__('Delivery 13'),"14":__('Delivery 14'),"15":__('Delivery 15'),"16":__('Delivery 16'),"17":__('Delivery 17'),"18":__('Delivery 18')}, formatter: Table.api.formatter.normal},
                        {field: 'isdelivery', title: __('Isdelivery'), searchList: {"0":__('Isdelivery 0'),"1":__('Isdelivery 1')}, formatter: Table.api.formatter.normal},
                        {field: 'valuation', title: __('Valuation'), searchList: {"0":__('Valuation 0'),"1":__('Valuation 1'),"2":__('Valuation 2')}, formatter: Table.api.formatter.normal},
                        {field: 'createtime', title: __('Createtime'), operate:'RANGE', addclass:'datetimerange', formatter: Table.api.formatter.datetime},
                        {field: 'updatetime', title: __('Updatetime'), operate:'RANGE', addclass:'datetimerange', formatter: Table.api.formatter.datetime},
                        {field: 'status', title: __('Status'), searchList: {"normal":__('Normal'),"hidden":__('Hidden')}, formatter: Table.api.formatter.status},
                        {field: 'operate', title: __('Operate'), table: table, events: Table.api.events.operate, formatter: Table.api.formatter.operate}
                    ]
                ]
            });

            // 为表格绑定事件
            Table.api.bindevent(table);
        },
        api: {
            bindevent: function () {
                Form.api.bindevent($("form[role=form]"));
            }
        }
    };
    return Controller;
});