define(['jquery', 'bootstrap', 'backend', 'table', 'form', 'vue'], function($, undefined, Backend,Table, Form, Vue) {

	var Controller = {

		index: function() {

			// 初始化表格參數配置

			Table.api.init({

				extend: {

					index_url: 'wanlshop/wholesale/index' + location.search,

					add_url: 'wanlshop/wholesale/add',

					edit_url: 'wanlshop/wholesale/edit',

					del_url: 'wanlshop/wholesale/del',

					multi_url: 'wanlshop/wholesale/multi',

					dragsort_url: "",

					table: 'wanlshop_goods',

				}

			});

			var table = $("#table");

			

			table.on('post-common-search.bs.table', function (event, table) {

			    $('ul.nav-tabs li a[data-value="normal"]').trigger('click');

			    $(".form-commonsearch select[name=status]").val("normal");

			});

			// 初始化表格

			table.bootstrapTable({

				url: $.fn.bootstrapTable.defaults.extend.index_url,

				pk: 'id',

				sortName: 'weigh',

				columns: [

					[

						{checkbox: true},

						{field: 'id',title: __('Id')},

						{field: 'category.name', title: __('Category.name'), formatter: Table.api.formatter.search},

						{field: 'title',title: __('Title')},

						{field: 'image',title: __('Image'),events: Table.api.events.image,formatter: Table.api.formatter.image},

						{field: 'images',title: __('Images'),events: Table.api.events.image,formatter: Table.api.formatter.images},

						// {field: 'flag',title: __('Flag'),searchList: {"hot": __('Flag hot'),"index": __('Flag index'),"recommend": __('Flag recommend')},operate: 'FIND_IN_SET',formatter: Table.api.formatter.label},

						{field: 'shopsort.name', title: __('Shopsort.name'), formatter: Table.api.formatter.search},

						{field: 'price',title: __('Price'),operate: 'BETWEEN'},

						// {field: 'distribution',title: __('Distribution'),searchList: {"true": __('Distribution true'),"false": __('Distribution false')},formatter: Table.api.formatter.normal},

						// {field: 'activity',title: __('Activity'),searchList: {"true": __('Activity true'),"false": __('Activity false')},formatter: Table.api.formatter.normal},

						{field: 'views',title: __('Views')},{field: 'sales',title: __('Sales')},{field: 'comment',title: __('Comment')},{field: 'praise',title: __('Praise')},

						{field: 'like',title: __('Like')},{field: 'createtime',title: __('Createtime'),operate: 'RANGE',addclass: 'datetimerange',formatter: Table.api.formatter.datetime},

						{field: 'updatetime',title: __('Updatetime'),operate: 'RANGE',addclass: 'datetimerange',formatter: Table.api.formatter.datetime},

						//{field: 'status',title: __('Status'),searchList: {"normal": __('Normal'),"hidden": __('Hidden')},formatter: Table.api.formatter.status},
						
						{
						    field: 'operate',
						    title: '注文',
						    table: table, 
						    events: Table.api.events.operate,
						    buttons: [
                            {
                                name: 'detail',
                                text: '注文',
                                title: '注文',
                                extend: 'data-area=\'["375px","812px"]\' data-shade=\'[0.5,"#000"]\'',
                                classname: 'btn btn-xs btn-primary btn-dialog',
                                icon: 'fa fa-list',
                                url: function (row) {
                                    var url = 'https://twshop.duhugou.com/wholesale/pages/product/goods?id='+row.id;
                                    //返回true時按鈕顯示,返回false隱藏
                                    return url;
                                },
                                callback: function (data) {
                                    Layer.alert("返品データを受け取りました：" + JSON.stringify(data), {title: "ポストパスデータ"});
                                },
                                visible: function (row) {
                                    //返回true時按鈕顯示,返回false隱藏
                                    return true;
                                }
                            }
                            ],
						    formatter: Table.api.formatter.operate
						},

						{
						    field: 'operate',
						    title: __('Operate'),
						    table: table, 
						    events: Table.api.events.operate,
						    buttons: [
                            {
                                name: "detail",
                                title: __("充電"),
                                classname: "btn btn-xs btn-success btn-magic btn-ajax",
                                icon: "fa fa-check",
                                url: "wanlshop/wholesale/import"
                            },
                            {
                                name: "detail",
                                title: __("詳細"),
                                classname: "btn btn-xs btn-info btn-dialog",
                                icon: "fa fa-eye",
                                url: "wanlshop/wholesale/edit"
                            }],
						    formatter: Table.api.formatter.operate
						}

					]

				]

			});

			// 為表格綁定事件

			Table.api.bindevent(table);

			table.on('load-success.bs.table',function(data){
			   $(".btn-editone").data("area", ["90%","80%"]);
			});

		},

		stock: function() {

			// 初始化表格參數配置

			Table.api.init({

				extend: {

					index_url: 'wanlshop/wholesale/index' + location.search,

					add_url: 'wanlshop/wholesale/add',

					edit_url: 'wanlshop/wholesale/edit',

					del_url: 'wanlshop/wholesale/del',

					multi_url: 'wanlshop/wholesale/multi',

					dragsort_url: "",

					table: 'wanlshop_goods',

				}

			});

			var table = $("#table");

			

			table.on('post-common-search.bs.table', function (event, table) {

			    $('ul.nav-tabs li a[data-value="hidden"]').trigger('click');

			    $(".form-commonsearch select[name=status]").val("hidden");

			});

			// 初始化表格

			table.bootstrapTable({

				url: $.fn.bootstrapTable.defaults.extend.index_url,

				pk: 'id',

				sortName: 'weigh',

				columns: [

					[

						{checkbox: true},

						{field: 'id',title: __('Id')},

						{field: 'category.name', title: __('Category.name'), formatter: Table.api.formatter.search},

						{field: 'title',title: __('Title')},

						{field: 'image',title: __('Image'),events: Table.api.events.image,formatter: Table.api.formatter.image},

						{field: 'images',title: __('Images'),events: Table.api.events.image,formatter: Table.api.formatter.images},

						// {field: 'flag',title: __('Flag'),searchList: {"hot": __('Flag hot'),"index": __('Flag index'),"recommend": __('Flag recommend')},operate: 'FIND_IN_SET',formatter: Table.api.formatter.label},

						{field: 'shopsort.name', title: __('Shopsort.name'), formatter: Table.api.formatter.search},

						{field: 'price',title: __('Price'),operate: 'BETWEEN'},

						// {field: 'distribution',title: __('Distribution'),searchList: {"true": __('Distribution true'),"false": __('Distribution false')},formatter: Table.api.formatter.normal},

						// {field: 'activity',title: __('Activity'),searchList: {"true": __('Activity true'),"false": __('Activity false')},formatter: Table.api.formatter.normal},

						{field: 'views',title: __('Views')},{field: 'sales',title: __('Sales')},{field: 'comment',title: __('Comment')},{field: 'praise',title: __('Praise')},

						{field: 'like',title: __('Like')},{field: 'createtime',title: __('Createtime'),operate: 'RANGE',addclass: 'datetimerange',formatter: Table.api.formatter.datetime},

						{field: 'updatetime',title: __('Updatetime'),operate: 'RANGE',addclass: 'datetimerange',formatter: Table.api.formatter.datetime},

						{field: 'status',title: __('Status'),searchList: {"normal": __('Normal'),"hidden": __('Hidden')},formatter: Table.api.formatter.status},

						{field: 'operate',title: __('Operate'),table: table,events: Table.api.events.operate,formatter: Table.api.formatter.operate}

					]

				]

			});

			// 為表格綁定事件

			Table.api.bindevent(table);

		},

		recyclebin: function() {

			// 初始化表格參數配置

			Table.api.init({

				extend: {

					'dragsort_url': ''

				}

			});

			var table = $("#table");

			// 初始化表格

			table.bootstrapTable({

				url: 'wanlshop/wholesale/recyclebin' + location.search,

				pk: 'id',

				sortName: 'id',

				columns: [

					[{

							checkbox: true

						},

						{

							field: 'id',

							title: __('Id')

						},

						{

							field: 'title',

							title: __('Title'),

							align: 'left'

						},

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

							buttons: [{

									name: 'Restore',

									text: __('Restore'),

									classname: 'btn btn-xs btn-info btn-ajax btn-restoreit',

									icon: 'fa fa-rotate-left',

									url: 'wanlshop/wholesale/restore',

									refresh: true

								},

								{

									name: 'Destroy',

									text: __('Destroy'),

									classname: 'btn btn-xs btn-danger btn-ajax btn-destroyit',

									icon: 'fa fa-times',

									url: 'wanlshop/wholesale/destroy',

									refresh: true

								}

							],

							formatter: Table.api.formatter.operate

						}

					]

				]

			});



			// 為表格綁定事件

			Table.api.bindevent(table);

		},

		select: function () {

		    // 初始化表格參數配置

		    Table.api.init({

		        extend: {

		            index_url: 'wanlshop/wholesale/select',

		        }

		    });

		    var idArr = [];

			var dataArr = [];

		    var table = $("#table");

			

			table.on('check.bs.table uncheck.bs.table check-all.bs.table uncheck-all.bs.table', function (e, row) {

			    if (e.type == 'check' || e.type == 'uncheck') {

			        row = [row];

			    } else {

			        idArr = [];

					dataArr = [];

			    }

			    $.each(row, function (i, j) {

			        if (e.type.indexOf("uncheck") > -1) {

			            var index = idArr.indexOf(j.id);

			            if (index > -1) {

			                idArr.splice(index, 1);

							$.each(dataArr, function(key,value){

								if(value.id == j.id){

									dataArr.splice(key, 1);

								}

							})    

			            }

			        } else {

						if(idArr.indexOf(j.id) == -1){

							idArr.push(j.id);

							dataArr.push({

								id: j.id,

								image: j.image,

								price: j.price,

								title: j.title

							});

						}

			        }

			    });

			});

		

		    // 初始化表格

		    table.bootstrapTable({

		        url: $.fn.bootstrapTable.defaults.extend.index_url,

		        sortName: 'id',

		        showToggle: false,

		        showExport: false,

		        columns: [

		            [

		                {checkbox: true},

						{field: 'id', title: __('Id')},

						{field: 'image', title: __('Image'), events: Table.api.events.image, formatter: Table.api.formatter.image},

						{field: 'title', title: __('Title')},

						{field: 'updatetime', title: __('Updatetime'), operate:'RANGE', addclass:'datetimerange', formatter: Table.api.formatter.datetime},

		                {

		                    field: 'operate', title: __('Operate'), events: {

		                        'click .btn-chooseone': function (e, value, row, index) {

		                            var multiple = Backend.api.query('multiple');

		                            multiple = multiple == 'true' ? true : false;

		                            Fast.api.close({url: row.id, data: [{

										id: row.id,

										image: row.image,

										price: row.price,

										title: row.title

									}], multiple: multiple});

		                        },

		                    }, formatter: function () {

		                        return '<a href="javascript:;" class="btn btn-danger btn-chooseone btn-xs"><i class="fa fa-check"></i> ' + __('Choose') + '</a>';

		                    }

		                }

		            ]

		        ]

		    });

		

		    // 選中多個

		    $(document).on("click", ".btn-choose-multi", function () {

		        var multiple = Backend.api.query('multiple');

		        multiple = multiple == 'true' ? true : false;

		        Fast.api.close({

					url: idArr.length == 0 ? '': idArr.join(","), 

					data: dataArr,

					multiple: multiple

				});

		    });

		

		    // 為表格綁定事件

		    Table.api.bindevent(table);

		},

		add: function() {

			var vm = new Vue({

				el: '#app',

				data() {

					return {

						spu: [],

						spuItem: [],

						sku: [],

						batch: 0,

						categoryId: '',

						categoryList :Config.channelList,

						categoryOne: null,

						categoryTwo: null,

						categoryThree: null,

						categoryFour: null,

						categoryFive: null,

						attributeData: []

					}

				},

				methods: {

					getCategory(e){

						if(e == 1){

							this.categoryTwo = null;

							this.categoryThree = null;

							this.categoryFour = null;

							this.categoryFive = null;

						}

						if(this.categoryOne != null){

							this.categoryId = this.categoryList[this.categoryOne].id;

						}

						if(this.categoryTwo != null){

							this.categoryId = this.categoryList[this.categoryOne].childlist[this.categoryTwo].id;

						}

						if(this.categoryThree != null){

							this.categoryId = this.categoryList[this.categoryOne].childlist[this.categoryTwo].childlist[this.categoryThree].id;

						}

						if(this.categoryFour != null){

							this.categoryId = this.categoryList[this.categoryOne].childlist[this.categoryTwo].childlist[this.categoryThree].childlist[this.categoryFour].id;

						}

						if(this.categoryFive != null){

							this.categoryId = this.categoryList[this.categoryOne].childlist[this.categoryTwo].childlist[this.categoryThree].childlist[this.categoryFour].childlist[this.categoryFive].id;

						}

						// 查詢類目屬性

						Fast.api.ajax("wanlshop.goods/attribute?id=" + this.categoryId, (data, ret) =>{

							this.attributeData = data;

						    //返回false時將不再有右上角的操作成功的提示

						    return false;

						});

					},

					// 添加屬性

					spuAdd(){

						var str = this.$refs['specs-name'].value || ''

						str = str.trim();

						if (!str){

							Toastr.error("產品屬性不能為空");

							return

						}

						// 遍歷

						var arr = str.split(/\s+/);

						for (var i=0;i<arr.length;i++)

						{ 

						    this.spu.push(arr[i])

						}

						// 清空表單

						this.$refs['specs-name'].value = ''

					},

					// 刪除屬性

					spuRemove(key){

						Vue.delete(vm.spuItem, key); 

						Vue.delete(vm.spu, key); 

						this.skuCreate();

					},

					// 添加規格

					skuAdd(index) {

						var str = this.$refs['specs-name-' + index][0].value || ''

						str = str.trim();

						if (!str){

							Toastr.error("產品屬性不能為空")

							return

						}

						// 遍歷

						var arr = str.split(/\s+/);

						for (var i=0;i<arr.length;i++)

						{ 

							if (this.spuItem[index]) {

								this.spuItem[index].push(arr[i])

							} else {

								this.spuItem.push([arr[i]])

							}

						}

						// 清空表單

						this.$refs['specs-name-' + index][0].value = ""

						this.skuCreate();

					},

					// 刪除規格

					skuRemove(i,key){

						Vue.delete(vm.spuItem[i], key); 

						this.skuCreate();

					},

					// 生成Sku

					skuCreate() {

						this.sku = this.skuDesign(this.spuItem)

					},

					skuDesign(array) {

						if (array.length == 0) return []

						if (array.length < 2) {

							var res = []

							array[0].forEach(function(v) {

								res.push([v])

							})

							return res

						}

						return [].reduce.call(array, function(col, set) {

							var res = [];

							col.forEach(function(c) {

								set.forEach(function(s) {

									var t = [].concat(Array.isArray(c) ? c : [c]);

									t.push(s);

									res.push(t);

								})

							});

							return res;

						});

					},

					// 是否開啟批量

					skuBatch(){

						this.batch = this.batch == 0 ? 1 : 0;

					}

				}

			})

			window.batchSet = function(field) {

				$('.wanl-' + field).val($('#batch-' + field).val())

			}

			// 完善寄件信息

			$(document).on("click", ".btn-send", function () {

				Backend.api.open('wanlshop/config/index/type/mailing/', __('完善寄件人信息'), {

					callback:function(value){

						console.log(value);

					}

				});

			});

			// 完善退件信息

			$(document).on("click", ".btn-return", function () {

				Backend.api.open('wanlshop/config/index/type/return/', __('完善退貨信息'), {

					callback:function(value){

						console.log(value);

					}

				});

			});

			// 申請品牌

			$(document).on("click", ".btn-brand", function () {

				Backend.api.open('wanlshop/brand/add/', __('申請品牌'), {

					callback:function(value){

						console.log(value);

					}

				});

			});

			// 新建運費模板

			$(document).on("click", ".btn-freight", function () {

				Backend.api.open('wanlshop/freight/add', __('新建運費模板'), {

					callback:function(value){

						console.log(value);

					}

				});

			});

			// 新建店鋪分類

			$(document).on("click", ".btn-shopsort", function () {

				Backend.api.open('wanlshop/shopsort/add', __('新建店鋪分類'), {

					callback:function(value){

						console.log(value);

					}

				});

			});

			// 打開方式

			if(Config.isdialog){

				Controller.api.bindevent();

			}else{

				Form.api.bindevent($("form[role=form]"), function (data, ret) {

				    setTimeout(function () {

				    	location.href = Fast.api.fixurl('wanlshop.goods/index.html');

				    }, 500);

				});

			}

		},

		edit: function() {

			Controller.api.bindevent();

			var vm = new Vue({

				el: '#app',

				data() {

					return {

						spu: Config.spu,

						spuItem: Config.spuItem,

						sku: Config.sku,

						skuItem: Config.skuItem,

						categoryId: Config.categoryId,

						categoryList :Config.channelList,

						categoryOne: null,

						categoryTwo: null,

						categoryThree: null,

						categoryFour: null,

						categoryFive: null,

						attribute: Config.attribute,

						attributeData: [],

						batch: 0

					}

				},

				mounted() {

					this.categoryList.forEach((item,index)=>{

						if (item.id == Config.categoryId ) {

							this.categoryOne = index;

						}else{

							item.childlist.forEach((item1,index1)=>{

								if (item1.id == Config.categoryId ) {

									this.categoryOne = index;

									this.categoryTwo = index1;

								}else{

									item1.childlist.forEach((item2,index2)=>{

										if (item2.id == Config.categoryId ) {

											this.categoryOne = index;

											this.categoryTwo = index1;

											this.categoryThree = index2;

										}else{

											item2.childlist.forEach((item3,index3)=>{

												if (item3.id == Config.categoryId ) {

													this.categoryOne = index;

													this.categoryTwo = index1;

													this.categoryThree = index2;

													this.categoryFour = index3;

												}else{

													item3.childlist.forEach((item4,index4)=>{

														if (item4.id == Config.categoryId ) {

															this.categoryOne = index;

															this.categoryTwo = index1;

															this.categoryThree = index2;

															this.categoryFour = index3;

															this.categoryFive = index4;

														}

													});

												}

											});

										}

									});

								}

							});

						}

					});

                    Fast.api.ajax("wanlshop.goods/attribute?id=" + this.categoryId, (data, ret) =>{

                    	this.attributeData = data;

                        //返回false時將不再有右上角的操作成功的提示

                        return false;

                    });
                },

				methods: {

					getCategory(e){

						if(e == 1){

							this.categoryTwo = null;

							this.categoryThree = null;

							this.categoryFour = null;

							this.categoryFive = null;

						}

						if(this.categoryOne != null){

							this.categoryId = this.categoryList[this.categoryOne].id;

						}

						if(this.categoryTwo != null){

							this.categoryId = this.categoryList[this.categoryOne].childlist[this.categoryTwo].id;

						}

						if(this.categoryThree != null){

							this.categoryId = this.categoryList[this.categoryOne].childlist[this.categoryTwo].childlist[this.categoryThree].id;

						}

						if(this.categoryFour != null){

							this.categoryId = this.categoryList[this.categoryOne].childlist[this.categoryTwo].childlist[this.categoryThree].childlist[this.categoryFour].id;

						}

						if(this.categoryFive != null){

							this.categoryId = this.categoryList[this.categoryOne].childlist[this.categoryTwo].childlist[this.categoryThree].childlist[this.categoryFour].childlist[this.categoryFive].id;

						}

						// 查詢類目屬性

						Fast.api.ajax("wanlshop.goods/attribute?id=" + this.categoryId, (data, ret) =>{

							this.attributeData = data;

						    //返回false時將不再有右上角的操作成功的提示

						    return false;

						});

					},

					// 添加屬性

					spuAdd(){

						var str = this.$refs['specs-name'].value || ''

						str = str.trim();

						if (!str){

							Toastr.error("產品屬性不能為空");

							return

						}

						// 遍歷

						var arr = str.split(/\s+/);

						for (var i=0;i<arr.length;i++)

						{ 

						    this.spu.push(arr[i])

						}

						// 清空表單

						this.$refs['specs-name'].value = ''

					},

					// 添加規格

					skuAdd(index) {

						var str = this.$refs['specs-name-' + index][0].value || ''

						str = str.trim();

						if (!str){

							Toastr.error("產品屬性不能為空")

							return

						}

						// 遍歷

						var arr = str.split(/\s+/);

						for (var i=0;i<arr.length;i++)

						{ 

							if (this.spuItem[index]) {

								this.spuItem[index].push(arr[i])

							} else {

								this.spuItem.push([arr[i]])

							}

						}

						// 清空表單

						this.$refs['specs-name-' + index][0].value = ""

						this.skuCreate();

					},

					

					

					// 刪除屬性

					spuRemove(key){

						Vue.delete(vm.spuItem, key); 

						Vue.delete(vm.spu, key); 

						this.skuCreate();

					},

					// 刪除規格

					skuRemove(i,key){

						Vue.delete(vm.spuItem[i], key); 

						this.skuCreate();

					},

					// 生成Sku

					skuCreate() {

						this.sku = this.skuDesign(this.spuItem)

					},

					skuDesign(array) {

						if (array.length == 0) return []

						if (array.length < 2) {

							var res = []

							array[0].forEach(function(v) {

								res.push([v])

							})

							return res

						}

						return [].reduce.call(array, function(col, set) {

							var res = [];

							col.forEach(function(c) {

								set.forEach(function(s) {

									var t = [].concat(Array.isArray(c) ? c : [c]);

									t.push(s);

									res.push(t);

								})

							});

							return res;

						});

					},

					// 是否開啟批量

					skuBatch(){

						this.batch = this.batch == 0 ? 1 : 0;

					}

				}

			})

			window.batchSet = function(field) {

				$('.wanl-' + field).val($('#batch-' + field).val())

			}

			// 申請品牌

			$(document).on("click", ".btn-brand", function () {

				Backend.api.open('wanlshop/brand/add/', __('申請品牌'), {
					callback:function(value){
						console.log(value);
					}
				});

			});

			// 新建運費模板

			$(document).on("click", ".btn-freight", function () {

				Backend.api.open('wanlshop/freight/add', __('新建運費模板'), {
					callback:function(value){
						console.log(value);
					}
				});

			});

			// 新建店鋪分類

			$(document).on("click", ".btn-shopsort", function () {

				Backend.api.open('wanlshop/shopsort/add', __('新建店鋪分類'), {
					callback:function(value){
						console.log(value);
					}
				});

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
