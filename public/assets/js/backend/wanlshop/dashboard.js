define(['jquery', 'bootstrap', 'backend', 'table', 'vue', 'echarts', 'echarts-theme'], function($, undefined, Backend,Table, Vue, Echarts) {

	var Controller = {
		index: function() {
			var myChart = Echarts.init($('#echarts_order')[0], 'walden');
			myChart.setOption({
				title: {text: '订单统计',subtext: '24小时'},
				legend: {data: ['订单额', '订单数']},
				tooltip: {trigger: 'axis',formatter: "{b}<br>{a0} : {c0} 个 <br>{a1} : {c1} 元"},
				toolbox: {show: true,feature: {magicType: {show: true,type: ['line', 'bar']},restore: {show: true},saveAsImage: {show: true}}},
				calculable: true,
				xAxis: [
					{type: 'category',data: Config.orderSaleCategory}
				],
				yAxis: [
					{type: 'value'}
				],
				series: [
					{name: '订单数',type: 'line',data: Config.orderSaleNums,markPoint: {data: [{type: 'max',name: '最大值'},{type: 'min',name: '最小值'}]},markLine: {data: [{type: 'average',name: '平均值'}]}},
					{name: '订单额',type: 'bar',smooth: true,symbol: 'none',data: Config.orderSaleAmount,markPoint: {data: [{type: 'max',name: '最大值'},{type: 'min',name: '最小值'}]},markLine: {data: [{type: 'average',name: '平均值'}]}}
				]
			});
			$(window).resize(function () {
			    myChart.resize();
			});
			// 载入Vue
			new Vue({
				el:'#wanlshop',
				data: {
					refundList: Config.servicesRefundList,
					shopAuthList: Config.shopAuthList,
					refundState: ['申请退款','卖家同意','卖家拒绝','申请平台','成功退款','退款已关闭','已提交物流'],
					shopState: ['个人','企业','旗舰'],
					shopVerify: ['提交资质','提交店铺','提交审核','通过','未通过'],
				},
				methods: {
					shopAgree(index) {
						var app = this;
						layer.confirm(`确定 同意 ${app.shopAuthList[index].shopname} 店铺入驻？`, {
							btn: ['确定','取消']
						}, function(){
							Fast.api.ajax({
								url: "wanlshop/auth/agree",
								data: {
									ids: app.shopAuthList[index].id
								}
							}, function(data, ret) {
								app.shopAuthList[index].verify = 3;
								layer.msg('已同意入驻申请', {icon: 1});
								return false;
							});
						});
					},
					shopRefuse(index) {
						var app = this;
						layer.prompt({title: '请输入拒绝入驻理由', formType: 2}, function(text, key){
							Fast.api.ajax({
								url: `wanlshop/auth/refuse/ids/${app.shopAuthList[index].id}`,
								data: {
									row: {
										refuse: text
									}
								}
							}, function(data, ret) {
								layer.close(key);
								app.shopAuthList[index].verify = 4;
								layer.msg('已拒绝入驻申请', {icon: 1});
								return false;
							});
						});
					},
					refundAgree(index) {
						var app = this;
						layer.confirm(`确定 买家符合退款，直接退款给买家？`, {
							btn: ['确定','取消']
						}, function(){
							Fast.api.ajax({
								url: "wanlshop/refund/agree",
								data: {
									ids: app.refundList[index].id
								}
							}, function(data, ret) {
								app.refundList[index].state = 4;
								layer.msg('已同意退款申请', {icon: 1});
								return false;
							});
						});
					},
					refundRefuse(index) {
						var app = this;
						layer.prompt({title: '请输入拒绝退款理由', formType: 2}, function(text, key){
							console.log(text);
							Fast.api.ajax({
								url: `wanlshop/refund/refuse/ids/${app.refundList[index].id}`,
								data: {
									row: {
										refund_content: text
									}
								}
							}, function(data, ret) {
								layer.close(key);
								app.refundList[index].state = 5;
								layer.msg('已拒绝退款申请', {icon: 1});
								return false;
							});
						});
					},
					shopDetails(index) {
						Fast.api.open(`wanlshop/auth/detail/ids/${this.shopAuthList[index].id}`, "查看入驻信息", {});
					},
					refundDetails(index) {
						Fast.api.open(`wanlshop/refund/detail/ids/${this.refundList[index].id}`, "查看退款", {});
					}
				}
			});
		},
		api: {
			bindevent: function() {
				Form.api.bindevent($("form[role=form]"));
			}
		}
	};
	return Controller;
});
