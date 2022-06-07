define(['jquery', 'bootstrap', 'backend', 'table', 'form', 'vue'], function ($, undefined, Backend, Table, Form, Vue) {

    var Controller = {
        index: function () {
            // 初始化表格参数配置
            Table.api.init({
                extend: {
                    index_url: 'wanlshop/money/index' + location.search,
                    add_url: '',
                    edit_url: '',
                    del_url: 'wanlshop/money/del',
                    multi_url: '',
                    import_url: 'wanlshop/money/import',
                    table: 'user_money_log',
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
                        {field: 'user_id', title: __('User_id')},
						{field: 'user.username', title: __('User.username'), operate: 'LIKE'},
                        {field: 'money', title: __('Money'), operate:'BETWEEN'},
                        {field: 'before', title: __('Before'), operate:'BETWEEN'},
                        {field: 'after', title: __('After'), operate:'BETWEEN'},
                        {field: 'memo', title: __('Memo'), operate: 'LIKE'},
                        {field: 'type', title: __('Type'), searchList: {"pay":__('Type pay'),"recharge":__('Type recharge'),"withdraw":__('Type withdraw'),"refund":__('Type refund'),"sys":__('Type sys')}, formatter: Table.api.formatter.normal},
                        {field: 'service_ids', title: __('Service_ids'), operate: 'LIKE'},
                        {field: 'createtime', title: __('Createtime'), operate:'RANGE', addclass:'datetimerange', autocomplete:false, formatter: Table.api.formatter.datetime},
                        {field: 'operate', title: __('Operate'), table: table, events: Table.api.events.operate,buttons: [{name: 'detail',title: __('资金详情'),classname: 'btn btn-xs btn-info btn-dialog',icon: 'fa fa-eye',url: 'wanlshop/money/detail'}],formatter: Table.api.formatter.operate}
                    ]
                ]
            });
            // 为表格绑定事件
            Table.api.bindevent(table);
        },
		detail: function () {
		    var vm = new Vue({
		    	el: '#app',
		    	data() {
		    		return {
		    			moneyData: Config.row,
						data: Config.service,
						bankList: {
							alipay: '支付宝',
							wechat: '微信',
							ALIPAY: '支付宝',
							WECHAT: '微信',
							ICBC: '工商银行',
							ABC: '农业银行',
							PSBC: '邮储银行',
							CCB: '建设银行',
							CMB: '招商银行',
							BOC: '中国银行',
							COMM: '交通银行',
							SPDB: '浦发银行',
							GDB: '广发银行',
							CMBC: '民生银行',
							PAB: '平安银行',
							CEB: '光大银行',
							CIB: '兴业银行',
							CITIC: '中信银行'
						},
						withdrawStatus: {
							created: '申请中',
							successed: '成功',
							rejected: '已拒绝',
						}
		    		}
		    	},
		    	methods: {
		    		getType(e){
		    			return ['无需退货','退货退款'][e];
		    		},
		    		getReason(e){
		    			return ['不喜欢','空包裹','一直未送达','颜色/尺码不符','质量问题','少件漏发','假冒品牌'][e];
		    		},
					cdnurl(url) {
						return Fast.api.cdnurl(url);
					},
					timeFormat(timestamp = null, fmt = 'yyyy-mm-dd'){
						// yyyy:mm:dd|yyyy:mm|yyyy年mm月dd日|yyyy年mm月dd日 hh时MM分等,可自定义组合
						timestamp = parseInt(timestamp);
						// 如果为null,则格式化当前时间
						if (!timestamp) timestamp = Number(new Date());
						// 判断用户输入的时间戳是秒还是毫秒,一般前端js获取的时间戳是毫秒(13位),后端传过来的为秒(10位)
						if (timestamp.toString().length == 10) timestamp *= 1000;
						let date = new Date(timestamp);
						let ret;
						let opt = {
							"y+": date.getFullYear().toString(), // 年
							"m+": (date.getMonth() + 1).toString(), // 月
							"d+": date.getDate().toString(), // 日
							"h+": date.getHours().toString(), // 时
							"M+": date.getMinutes().toString(), // 分
							"s+": date.getSeconds().toString() // 秒
							// 有其他格式化字符需求可以继续添加，必须转化成字符串
						};
						for (let k in opt) {
							ret = new RegExp("(" + k + ")").exec(fmt);
							if (ret) {
								fmt = fmt.replace(ret[1], (ret[1].length == 1) ? (opt[k]) : (opt[k].padStart(ret[1].length, "0")))
							};
						};
						return fmt;
					}
		    	}
		    });
		},
        api: {
            bindevent: function () {
                Form.api.bindevent($("form[role=form]"));
            }
        }
    };
    return Controller;
});