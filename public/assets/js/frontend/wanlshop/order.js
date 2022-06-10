define(['jquery', 'bootstrap', 'backend', 'table', 'form', 'template', 'jquery-jqprint', 'jquery-migrate'], function ($, undefined, Backend, Table, Form, Template, Jqprint, Migrate) {



    var Controller = {
        index: function () {
            // 初始化表格參數配置
            Table.api.init({
                extend: {
                    index_url: 'wanlshop/order/index' + location.search,
                    add_url: '',
                    edit_url: '',
                    del_url: 'wanlshop/order/del',
                    multi_url: 'wanlshop/order/multi',
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
                        {field: 'state', title: __('State'), searchList: {"1":__('State 1'), "8":__('State 8'),"2":__('State 2'),"3":__('State 3'),"4":__('State 4'),"6":__('State 6'),"7":__('State 7')}, formatter: Table.api.formatter.normal},
                        {field: 'createtime', title: __('Createtime'), operate:'RANGE', addclass:'datetimerange', formatter: Table.api.formatter.datetime},
                        {field: 'paymenttime', title: __('Paymenttime'), operate:'RANGE', addclass:'datetimerange', formatter: Table.api.formatter.datetime},
                        {field: 'delivertime', title: __('Delivertime'), operate:'RANGE', addclass:'datetimerange', formatter: Table.api.formatter.datetime},
                        {field: 'dealtime', title: __('Dealtime'), operate:'RANGE', addclass:'datetimerange', formatter: Table.api.formatter.datetime},
                        {field: 'status', title: __('Status'), searchList: {"normal":__('Normal'),"hidden":__('Hidden')}, formatter: Table.api.formatter.status},
                        {field: 'operate', title: __('Operate'), table: table, events: Table.api.events.operate, formatter: Table.api.formatter.operate}
                    ]
                ]
            });
            // 為表格綁定事件
            Table.api.bindevent(table);

			//點擊詳情

			$(document).on("click", ".detail[data-id]", function () {

			    Backend.api.open('wanlshop/order/detail/id/' + $(this).data('id'), __('Order detail'),{area:['1200px', '780px']});

			});

			//查看退款

			$(document).on("click", ".refund[data-id]", function () {

			    Backend.api.open('wanlshop/refund/detail/ids/' + $(this).data('id'), __('Please check the refund'));

			});

			// 查看評論

			$(document).on("click", ".comment[data-id]", function () {

			    Backend.api.open('wanlshop/comment/detail/type/1/ids/' + $(this).data('id'), __('コメントを見る'));

			});

			// 查看退款

			$(document).on("click", ".btn-selected", function () {

			    Backend.api.open('wanlshop/refund/detail/type/1/ids/' + $(this).data('id'), __('払い戻しを確認してください'));

			});

			// 即時溝通

			$(document).on("click", ".btn-delone", function () {

				chatFun({

					user_id: $(this).data('id'),

					nickname: $(this).data('name'),

					avatar: $(this).data('avatar'),

					isOnline: 1

				}, 'fun');

			});

			// 發貨 & 批量發貨

			$(document).on("click", ".btn-delivery", function () {

				if($(this).data('id')){

					Backend.api.open('wanlshop/order/delivery/ids/' + $(this).data('id'), __('船'),{area:['1000px', '700px']});

				}else{

					Backend.api.open('wanlshop/order/delivery/ids/' + Table.api.selectedids(table), __('バッチ配達'),{area:['1000px', '700px']});

				}

			});
			
			
			// 修改價格

			$(document).on("click", ".btn-editprice", function () {
			    //alert('wanlshop/order/wholesale1/id/' + $(this).data('id'));
				if($(this).data('id')){
                    Backend.api.open('wanlshop/order/detail1/id/' + $(this).data('id'), __('価格を変更します'),{area:['1000px', '700px']});
				}else{
				    alert('wanlshop/order/detail1/id/' + $(this).data('id'));
				}
			});
			
			// 壹鍵批發

			$(document).on("click", ".btn-wholesale1", function () {
			    //alert('wanlshop/order/wholesale1/id/' + $(this).data('id'));
				if($(this).data('id')){
                    Backend.api.open('wanlshop/order/wholesale1/id/' + $(this).data('id'), __('键卸売'),{area:['1000px', '700px']});
				}else{
				    alert('wanlshop/order/wholesale1/id/' + $(this).data('id'));
				}
			});

			// 打印 & 批量打印訂單 自動關閉窗口parent.Layer.closeAll();

			$(document).on("click", ".btn-invoice", function () {

				if($(this).data('id')){

					Backend.api.open('wanlshop/order/invoice/ids/' + $(this).data('id'), __('Shipment'),{area:['1100px', '750px']});

				}else{

					Backend.api.open('wanlshop/order/invoice/ids/' + Table.api.selectedids(table), __('Batch view invoice'),{area:['1100px', '750px']});

				}

			});

			// 查詢物流狀態

			$(document).on("click", ".kuaidisub[data-id]", function () {

			    Backend.api.open('wanlshop/order/relative/id/' + $(this).data('id'), __('Shipment progress'),{area:['800px', '600px']});

			});

			// 提交雲面單

			$(document).on("click", ".btn-express", function () {

				Layer.alert('訂單' + JSON.stringify(Table.api.selectedids(table)) + 'APIインタフェースのメンテナンスのため、印刷できません。');

			});

        },

		comment: function () {

			// 初始化表格參數配置

			Table.api.init({

			    extend: {

			        index_url: 'wanlshop/comment/index' + location.search,

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

			            {field: 'operate', title: __('Operate'), table: table, events: Table.api.events.operate,buttons: [{name: 'detail',title: __('View detail'),classname: 'btn btn-xs btn-info btn-dialog',icon: 'fa fa-eye',url: 'wanlshop/comment/detail'}],formatter: Table.api.formatter.operate}

			        ]

			    ]

			});

			

			// 為表格綁定事件

			Table.api.bindevent(table);

		},
		invoice: function () {

			$(document).on("click", ".btn-embossed", function () {

				$("#print_html").jqprint();

				$(".btn-embossed").text("初期化印刷");

				setTimeout(function() { 
					parent.Layer.closeAll();
				},1000);

			});

        },

		relative: function () {

			

		},

		detail: function () {

			// 查詢物流狀態

			$(document).on("click", ".kuaidisub[data-id]", function () {

			    Backend.api.open('wanlshop/order/relative/id/' + $(this).data('id'), __('Shipment progress'),{area:['800px', '600px']});

			});

		},

        delivery: function () {

            Controller.api.bindevent();

        },
        
        wholesale1: function () {

            Controller.api.bindevent();

        },
        
        detail1: function () {

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