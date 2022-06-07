define(['jquery', 'bootstrap', 'backend', 'table', 'form'], function($, undefined, Backend,Table, Form) {

    var Controller = {
        deliver: function () {

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

            // 為表格綁定事件

            Table.api.bindevent(table);

			//點擊詳情

			$(document).on("click", ".detail[data-id]", function () {

			    Backend.api.open('wanlshop/order/detail/id/' + $(this).data('id'), __('詳細を確認してください'),{area:['1200px', '780px']});

			});

			//查看退款

			$(document).on("click", ".refund[data-id]", function () {

			    Backend.api.open('wanlshop/refund/detail/ids/' + $(this).data('id'), __('払い戻しを確認してください'));

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

				chatFun({user_id: $(this).data('id'),nickname: $(this).data('name'),avatar: $(this).data('avatar'),isOnline: 1}, 'fun');

			});

			// 發貨 & 批量發貨

			$(document).on("click", ".btn-delivery", function () {

				if($(this).data('id')){

					Backend.api.open('wanlshop/order/delivery/ids/' + $(this).data('id'), __('船'),{area:['1000px', '700px']});

				}else{

					Backend.api.open('wanlshop/order/delivery/ids/' + Table.api.selectedids(table), __('バッチ配達'),{area:['1000px', '700px']});

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

					Backend.api.open('wanlshop/order/invoice/ids/' + $(this).data('id'), __('船の眺め'),{area:['1100px', '750px']});

				}else{

					Backend.api.open('wanlshop/order/invoice/ids/' + Table.api.selectedids(table), __('バッチビュー出荷'),{area:['1100px', '750px']});

				}

			});

			// 查詢物流狀態

			$(document).on("click", ".kuaidisub[data-id]", function () {

			    Backend.api.open('wanlshop/order/relative/id/' + $(this).data('id'), __('エクスプレスお問い合わせ'),{area:['800px', '600px']});

			});

			// 提交雲面單

			$(document).on("click", ".btn-express", function () {

				Layer.alert('訂單' + JSON.stringify(Table.api.selectedids(table)) + 'APIインタフェースのメンテナンスのため、印刷できません。');

			});

        },

		template: function () {
            // 初始化表格參數配置
            Table.api.init({
                extend: {
                    index_url: 'wanlshop/freight/index' + location.search,
                    add_url: 'wanlshop/freight/add',
                    edit_url: 'wanlshop/freight/edit',
                    del_url: 'wanlshop/freight/del',
                    multi_url: 'wanlshop/freight/multi',
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

            // 為表格綁定事件
            Table.api.bindevent(table);
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

			            {field: 'operate', title: __('Operate'), table: table, events: Table.api.events.operate,buttons: [{name: 'detail',title: __('コメントを見る'),classname: 'btn btn-xs btn-info btn-dialog',icon: 'fa fa-eye',url: 'wanlshop/comment/detail'}],formatter: Table.api.formatter.operate}

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

			    Backend.api.open('wanlshop/order/relative/id/' + $(this).data('id'), __('エクスプレスお問い合わせ'),{area:['800px', '600px']});

			});

		},
        
        wholesale1: function () {

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