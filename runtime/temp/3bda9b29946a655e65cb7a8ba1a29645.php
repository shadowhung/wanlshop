<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:89:"/www/wwwroot/www.fdadeal.com/public/../application/admin/view/wanlshop/wholesale/add.html";i:1626210512;s:71:"/www/wwwroot/www.fdadeal.com/application/admin/view/layout/default.html";i:1608326192;s:68:"/www/wwwroot/www.fdadeal.com/application/admin/view/common/meta.html";i:1608326192;s:70:"/www/wwwroot/www.fdadeal.com/application/admin/view/common/script.html";i:1608326190;}*/ ?>
<!DOCTYPE html>
<html lang="<?php echo $config['language']; ?>">
    <head>
        <meta charset="utf-8">
<title><?php echo (isset($title) && ($title !== '')?$title:''); ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
<meta name="renderer" content="webkit">
<meta name="referrer" content="never">

<link rel="shortcut icon" href="/assets/img/favicon.ico" />
<!-- Loading Bootstrap -->
<link href="/assets/css/backend<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.css?v=<?php echo \think\Config::get('site.version'); ?>" rel="stylesheet">

<?php if(\think\Config::get('fastadmin.adminskin')): ?>
<link href="/assets/css/skins/<?php echo \think\Config::get('fastadmin.adminskin'); ?>.css?v=<?php echo \think\Config::get('site.version'); ?>" rel="stylesheet">
<?php endif; ?>

<!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
<!--[if lt IE 9]>
  <script src="/assets/js/html5shiv.js"></script>
  <script src="/assets/js/respond.min.js"></script>
<![endif]-->
<script type="text/javascript">
    var require = {
        config:  <?php echo json_encode($config); ?>
    };
</script>

    </head>

    <body class="inside-header inside-aside <?php echo defined('IS_DIALOG') && IS_DIALOG ? 'is-dialog' : ''; ?>">
        <div id="main" role="main">
            <div class="tab-content tab-addtabs">
                <div id="content">
                    <div class="row">
                        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
                            <section class="content-header hide">
                                <h1>
                                    <?php echo __('Dashboard'); ?>
                                    <small><?php echo __('Control panel'); ?></small>
                                </h1>
                            </section>
                            <?php if(!IS_DIALOG && !\think\Config::get('fastadmin.multiplenav') && \think\Config::get('fastadmin.breadcrumb')): ?>
                            <!-- RIBBON -->
                            <div id="ribbon">
                                <ol class="breadcrumb pull-left">
                                    <?php if($auth->check('dashboard')): ?>
                                    <li><a href="dashboard" class="addtabsit"><i class="fa fa-dashboard"></i> <?php echo __('Dashboard'); ?></a></li>
                                    <?php endif; ?>
                                </ol>
                                <ol class="breadcrumb pull-right">
                                    <?php foreach($breadcrumb as $vo): ?>
                                    <li><a href="javascript:;" data-url="<?php echo $vo['url']; ?>"><?php echo $vo['title']; ?></a></li>
                                    <?php endforeach; ?>
                                </ol>
                            </div>
                            <!-- END RIBBON -->
                            <?php endif; ?>
                            <div class="content">
                                <style>

	#cxselect-example .form-group {

		margin: 10px 0;

	}

	[v-cloak] {display: none;}

	.wanl-specs .add-option{

		width: 250px;

		margin-bottom: 17px;

	}

	.wanl-specs .add-option .input-group-addon{

		color: #fff;

		background-color: #2c3e50;

	}

	.wanl-specs .panel .row{

		margin: 5px 0;

	}

	.wanl-specs .panel .remove {

		display: none;

		position: absolute;

		z-index: 2;

		width: 18px;

		height: 18px;

		font-size: 14px;

		line-height: 16px;

		color: #fff;

		text-align: center;

		cursor: pointer;

		background: rgba(0,0,0,.3);

		border-radius: 50%;

	}

	.wanl-specs .panel .panel-heading {

		position: relative;

	}

	.wanl-specs .panel .panel-heading .remove {

		right: 10px;

		top: 10px;

	}

	.wanl-specs .panel .panel-heading:hover .remove {

		display:block;

	}

	.wanl-specs .panel .wanl-specs-tag{

		background-color: #f8f8f8;

		position: relative;

		padding: 6px 10px;

		display: inline-block;

		margin-right: 10px;

		text-align: center;

		border-radius: 2px;

		cursor: pointer;

	}

	.wanl-specs .panel .wanl-specs-tag .remove {

		top: -5px;

		right: -5px;

	}

	.wanl-specs .panel .wanl-specs-tag:hover .remove{

		display:block;

	}

	

	.wanl-specs .batch .input-group{

		margin: 15px 0;

		width: 66%;

	}

	.sp_result_area{

		z-index: 10000;

	}

	.form-inline .form-control{

		padding-right: 100px;

	}

	.input-sm{

		padding: 5px 0;

		text-align: center;

	}

	.sp_container {

	    margin-right: 3px;

	}

	.panel-intro > .panel-heading {

	    position: sticky;

	    top: 0;

	    z-index: 9999;

	}

	.wanl-attribute {

	    display: flex;

	    flex-wrap: wrap;

	    background: #f5f5f5;

	    border: 1px solid #ddd;

		border-radius: 3px;

	}

	.wanl-attribute>div{

		width: 50%;

	}

</style>

<?php if(($row['brand'] == 0) OR ($row['shopsort'] == 0) OR ($row['freight'] == 0) OR ($row['config']['sendPhoneNum'] == '') OR ($row['config']['returnPhoneNum'] == '')): ?>

<!--<div class="alert alert-danger-light">

	<strong>暂不可发布商品：</strong>

	<?php if(in_array(($row['brand']), explode(',',"0"))): ?><p> 系统中没有任何品牌，请到【总后台】> 多用户商城 > 商品管理 > 品牌管理添加。</p><?php endif; if(in_array(($row['shopsort']), explode(',',"0"))): ?><p> 尚未创建 “店铺分类”，请 <a class="btn-shopsort" href="#">点击创建</a>。</p><?php endif; if(in_array(($row['freight']), explode(',',"0"))): ?><p> 尚未创建 “运费模板”，请 <a class="btn-freight" href="#">点击创建</a>。</p><?php endif; if(empty($row['config']['sendPhoneNum']) || (($row['config']['sendPhoneNum'] instanceof \think\Collection || $row['config']['sendPhoneNum'] instanceof \think\Paginator ) && $row['config']['sendPhoneNum']->isEmpty())): ?><p> 尚未填写完整 “寄件人信息”，请 <a class="btn-send" href="#">点击填写</a> 寄件人信息。</p><?php endif; if(empty($row['config']['returnPhoneNum']) || (($row['config']['returnPhoneNum'] instanceof \think\Collection || $row['config']['returnPhoneNum'] instanceof \think\Paginator ) && $row['config']['returnPhoneNum']->isEmpty())): ?><p> 尚未填写完整 “退货信息”，请 <a class="btn-return" href="#">点击填写</a> 退货信息。</p><?php endif; ?>

</div>-->

<?php endif; ?>

<div class="panel panel-default panel-intro">

	<div class="panel-heading">

		<ul class="nav nav-tabs">

			<li class="active"><a href="#basics">基础信息</a></li>

			<li><a href="#sale">销售信息</a></li>

			<li><a href="#wanlinfo">图文描述</a></li>

			<li><a href="#payment">支付信息</a></li>

			<li><a href="#logistics">物流信息</a></li>

			<li><a href="#service">售后信息</a></li>

		</ul>

	</div>

	<div class="panel-body">

		<div id="myTabContent" class="tab-content">

			<div class="tab-pane fade active in" id="one">

				<div class="widget-body no-padding" id="cxselect-example">

					<form id="add-form" class="form-horizontal" role="form" data-toggle="validator" method="POST" action="">

						

						<div id="app" v-cloak>

							<div class="row" id="basics">

								<div class="col-md-12">

									<div class="panel panel-default">

										<div class="panel-heading">基础信息</div>

										<div class="panel-body">

											<div class="form-group">

												<label class="control-label col-xs-12 col-sm-2"><?php echo __('Title'); ?>:</label>

												<div class="col-xs-12 col-sm-8">

													<input id="c-title" data-rule="required" class="form-control" name="row[title]" type="text"  placeholder="请输入商品标题">

												</div>

											</div>
											
											<div class="form-group">

											    <label class="control-label col-xs-12 col-sm-2"><?php echo __('Category_id'); ?>:</label>

											    <div class="col-xs-12 col-sm-8">

													<div class="form-inline">

														<select id="c-category_1" data-rule="required" v-model="categoryOne" class="form-control" @change="getCategory(1)">

														    <option :value="key" v-for="(item,key) in categoryList" :key="item.id">{{item.name}}</option>                                    

														</select>

														<select id="c-category_2" data-rule="required" v-if="categoryOne != null && categoryList[categoryOne].childlist.length != 0" v-model="categoryTwo" class="form-control" @change="getCategory()">

														    <option :value="key" v-for="(item,key) in categoryList[categoryOne].childlist" :key="item.id">{{item.name}}</option>                                    

														</select>

														<select id="c-category_3" data-rule="required" v-if="categoryTwo != null && categoryList[categoryOne].childlist[categoryTwo].childlist.length != 0" v-model="categoryThree" class="form-control" @change="getCategory()">

														    <option :value="key" v-for="(item,key) in categoryList[categoryOne].childlist[categoryTwo].childlist" :key="item.id">{{item.name}}</option>                                    

														</select>

														<select id="c-category_4" data-rule="required" v-if="categoryThree != null && categoryList[categoryOne].childlist[categoryTwo].childlist[categoryThree].childlist.length != 0" v-model="categoryFour" class="form-control" @change="getCategory()">

														    <option :value="key" v-for="(item,key) in categoryList[categoryOne].childlist[categoryTwo].childlist[categoryThree].childlist" :key="item.id">{{item.name}}</option>                                    

														</select>

														<select id="c-category_5" data-rule="required" v-if="categoryFour != null && categoryList[categoryOne].childlist[categoryTwo].childlist[categoryThree].childlist[categoryFour].childlist.length != 0" v-model="categoryFive" class="form-control" @change="getCategory()">

														    <option :value="key" v-for="(item,key) in categoryList[categoryOne].childlist[categoryTwo].childlist[categoryThree].childlist[categoryFour].childlist" :key="item.id">{{item.name}}</option>                                    

														</select>

														<input class="form-control" name="row[category_id]" type="hidden" :value="categoryId">

													</div>

											    </div>

											</div>

											<div class="form-group">

												<label class="control-label col-xs-12 col-sm-2"><?php echo __('商品品牌'); ?>:</label>

												<div class="col-xs-12 col-sm-8">

													<input id="c-brand" data-rule="required" value="其他" class="form-control" name="row[brand]" type="text"  placeholder="请输入商品品牌">

												</div>

											</div>

											<!--<div class="form-group">

											    <label class="control-label col-xs-12 col-sm-2"><?php echo __('商品品牌'); ?>:</label>

											    <div class="col-xs-12 col-sm-8">

													<div class="input-group">

														<input id="c-brand_id" data-rule="required" 

														data-source="wanlshop/brandfront/selectpage" 

														class="form-control selectpage" 

														name="row[brand_id]" 

														type="text" placeholder="点击获取品牌列表">

														<div class="input-group-addon no-border no-padding">

															<span><button type="button" class="btn btn-danger btn-brand" ><?php echo __('申请品牌'); ?></button></span>

														</div>

													</div>

											    </div>

											</div>-->

											

											<div class="form-group">

												<label class="control-label col-xs-12 col-sm-2"><?php echo __('Manufacturer'); ?>:</label>

												<div class="col-xs-12 col-sm-8">

													<input id="c-title" class="form-control" name="row[manufacturer]" type="text"  placeholder="请输入生产厂家 例子:淘淘棉被厂">

												</div>

											</div>
											
											<div class="form-group">

												<label class="control-label col-xs-12 col-sm-2"><?php echo __('Sourceurl'); ?>:</label>

												<div class="col-xs-12 col-sm-8">

													<input id="c-title" class="form-control" name="row[sourceurl]" type="text"  placeholder="请输入商品来源 例子:https://baidu.com">

												</div>

											</div>

											

											<div class="form-group" v-if="attributeData.length != 0">

												<label class="control-label col-xs-12 col-sm-2"><?php echo __('类目属性'); ?>:</label>

												<div class="col-xs-12 col-sm-8">

													<div class="wanl-attribute">

														<div class="form-group" v-for="(item,index) in attributeData" :key="index">

														  <label for="inputPassword" class="col-sm-3 control-label">{{item.name}}</label>

														  <div class="col-sm-9">

															<select :id="'c-attribute_' + item.name" :name="'row[attribute]['+item.name+']'" data-rule="required" class="form-control">

															    <option :value="data.name" v-for="(data,key) in item.value" :key="key">{{data.name}}</option>                                   

															</select>

														  </div>

														</div>

													</div>

												</div>

											</div>

											

											

											

										</div>

									</div>

									

								</div>

							</div>

							<div class="row" id="sale">

								<div class="col-md-12">

									<div class="panel panel-default">

										<div class="panel-heading">销售信息</div>

										<div class="panel-body">

											<div class="form-group wanl-specs">

												<label class="control-label col-xs-12 col-sm-2"><?php echo __('产品属性'); ?>:</label>

												<div class="col-xs-12 col-sm-8">

													<div class="input-group add-option">

														<input type="text" class="form-control" ref="specs-name" placeholder="多个产品属性以空格隔开">

														<span class="input-group-addon pointer" @click="spuAdd">新增属性</span>

													</div>

							

													<div class="panel panel-default" v-for="(item, i) in spu" :key="i">

														<header class="panel-heading">

															<b>{{item}}</b>

															<span class="remove" title="移除" @click="spuRemove(i)">×</span>

														</header>

														<div class="row">

															<div class="col-md-5 col-sm-5 col-xs-5">

																<div class="input-group">

																	<input type="text" class="form-control" :ref="'specs-name-' + i" placeholder="多规格以空格隔开">

																	<span class="input-group-addon pointer" @click="skuAdd(i)"><i class="fa fa-plus"></i></span>

																</div>

															</div>

															<div class="col-md-7 col-sm-7 col-xs-7">

																<div class="wanl-specs-tag" v-for="(v, j) in spuItem[i]" :key="j">

																	{{v}}<span class="remove" title="移除" @click="skuRemove(i, j)">×</span>

																</div>

															</div>

														</div>

													</div>

													<div>

														<div v-for="itemm in sku">

															<input type="hidden" name="row[sku][]" v-model="itemm" />

														</div>

														<input type="hidden" name="row[spu]" v-model="spu" />

														<div v-for="items in spuItem">

															<input type="hidden" name="row[spuItem][]" v-model="items" />

														</div>

													</div>

													<div class="row" v-show="sku.length">

														<div class="col-md-12">

															<table class="table table-bordered">

																<thead>

																	<tr class="info text-info">

																		<th v-for="item in spu"> {{item}} </th>

																		<th width="80">原价</th>

																		<th width="80">现价</th>
																		
																		<th width="80">批发价</th>

																		<th width="80">库存</th>

																		<th width="80">重量(kg)</th>

																		<th width="80">编码</th>

																	</tr>

																</thead>

																<tbody>

																	<tr v-for="item in sku">

																		<td v-for="v in item">{{v}}</td>

																		<td width="80"> <input type="number" data-rule="required" name="row[market_price][]" class="input-sm form-control wanl-market_price"> </td>

																		<td width="80"> <input type="number" data-rule="required" name="row[price][]" class="input-sm form-control wanl-price"> </td>
																		
																		<td width="80"> <input type="number" data-rule="required" name="row[wholesale_price][]" class="input-sm form-control wanl-wholesale_price"> </td>

																		<td width="80"><input type="number" data-rule="required" name="row[stocks][]" class="input-sm form-control wanl-stock"></td>

																		<td width="80"><input type="number" name="row[weigh][]" class="input-sm form-control wanl-weigh"></td>

																		<td width="80"><input type="text" name="row[sn][]" class="input-sm form-control wanl-sn"></td>

																	</tr>

																</tbody>

															</table>

															<div @click="skuBatch()">

																<span v-if="batch == 0">

																	是否要批量设置？

																</span>

																<span v-else>

																	取消批量设置？

																</span>

															</div>

														</div>

													</div>

							

													<div class="batch" v-show="batch == 1">
													    
													    <div class="input-group">

															<div class="input-group-addon">导入价 ￥</div>

															<input type="number" class="form-control" id="batch-pprice" placeholder="自动生成原价，现价和批发价">

															<div class="input-group-addon" onclick="batchSet('pprice')">批量设置</div>

														</div>

														<!--<div class="input-group">

															<div class="input-group-addon">原价 ￥</div>

															<input type="number" class="form-control" id="batch-market_price" placeholder="一键设置原价">

															<div class="input-group-addon" onclick="batchSet('market_price')">批量设置</div>

														</div>

														<div class="input-group">

															<div class="input-group-addon">现价 ￥</div>

															<input type="number" class="form-control" id="batch-price" placeholder="一键设置现价">

															<div class="input-group-addon" onclick="batchSet('price')">批量设置</div>

														</div>
														
														<div class="input-group">

															<div class="input-group-addon">批发价 ￥</div>

															<input type="number" class="form-control" id="batch-wholesale_price" placeholder="一键设置批发价">

															<div class="input-group-addon" onclick="batchSet('wholesale_price')">批量设置</div>

														</div>-->

														<div class="input-group">

															<div class="input-group-addon">库存</div>

															<input type="number" class="form-control" id="batch-stock" placeholder="一键设置库存">

															<div class="input-group-addon" onclick="batchSet('stock')">批量设置</div>

														</div>

														<div class="input-group">

															<div class="input-group-addon">重量</div>

															<input type="number" class="form-control" id="batch-weigh" placeholder="一键设置重量">

															<div class="input-group-addon" onclick="batchSet('weigh')">批量设置</div>

														</div>

														<!--<div class="input-group">

															<div class="input-group-addon">编码</div>

															<input type="text" class="form-control" id="batch-sn" placeholder="一键设置编码">

															<div class="input-group-addon" onclick="batchSet('sn')">批量设置</div>

														</div>-->

													</div>

							

												</div>

											</div>

							

										</div>

									</div>

								</div>

							</div>

							

						</div>

						

						<div class="row" id="wanlinfo">

							<div class="col-md-12">

								<div class="panel panel-default">

									<div class="panel-heading">图文描述</div>

									<div class="panel-body">

										<div class="form-group">

											<label class="control-label col-xs-12 col-sm-2"><?php echo __('Image'); ?>:</label>

											<div class="col-xs-12 col-sm-8">

												<div class="input-group">

													<input id="c-image" data-rule="required" class="form-control" size="50" name="row[image]" type="text" placeholder="请上传商品主图">

													<div class="input-group-addon no-border no-padding">

														<span><button type="button" id="plupload-image" class="btn btn-danger plupload" data-input-id="c-image" data-mimetype="image/gif,image/jpeg,image/png,image/jpg,image/bmp" data-multiple="false" data-preview-id="p-image"><i class="fa fa-upload"></i> <?php echo __('Upload'); ?></button></span>

														<span><button type="button" id="fachoose-image" class="btn btn-primary fachoose" data-input-id="c-image" data-mimetype="image/*" data-multiple="false"><i class="fa fa-list"></i> <?php echo __('Choose'); ?></button></span>

													</div>

													<span class="msg-box n-right" for="c-image"></span>

												</div>

												<ul class="row list-inline plupload-preview" id="p-image"></ul>

											</div>

										</div>

										<div class="form-group">

											<label class="control-label col-xs-12 col-sm-2"><?php echo __('Images'); ?>:</label>

											<div class="col-xs-12 col-sm-8">

												<div class="input-group">

													<input id="c-images" data-rule="required" class="form-control" size="50" name="row[images]" type="text" placeholder="请上传商品相册">

													<div class="input-group-addon no-border no-padding">

														<span><button type="button" id="plupload-images" class="btn btn-danger plupload" data-input-id="c-images" data-mimetype="image/gif,image/jpeg,image/png,image/jpg,image/bmp" data-multiple="true" data-preview-id="p-images"><i class="fa fa-upload"></i> <?php echo __('Upload'); ?></button></span>

														<span><button type="button" id="fachoose-images" class="btn btn-primary fachoose" data-input-id="c-images" data-mimetype="image/*" data-multiple="true"><i class="fa fa-list"></i> <?php echo __('Choose'); ?></button></span>

													</div>

													<span class="msg-box n-right" for="c-images"></span>

												</div>

												<ul class="row list-inline plupload-preview" id="p-images"></ul>

											</div>

										</div>

										<!--<div class="form-group">

										    <label class="control-label col-xs-12 col-sm-2"><?php echo __('Description'); ?>:</label>

										    <div class="col-xs-12 col-sm-8">

										        <input id="c-description" data-rule="required" class="form-control" name="row[description]" type="text" placeholder="请输入商品描述">

										    </div>

										</div>-->

										<div class="form-group">

											<label class="control-label col-xs-12 col-sm-2"><?php echo __('Content'); ?>:</label>

											<div class="col-xs-12 col-sm-8">

												<textarea id="c-content" data-rule="required" class="form-control editor" rows="5" name="row[content]" cols="50"></textarea>

											</div>

										</div>

										<!--<div class="form-group">

											<label class="control-label col-xs-12 col-sm-2"><?php echo __('店铺中分类'); ?>:</label>

											<div class="col-xs-12 col-sm-8">

												<div class="input-group">

													<input id="c-shop_category_id" data-rule="required"

													data-source="wanlshop/shopsortfront"

													data-params='{"isTree":1}'

													data-multiple="true"

													data-pagination="true"

													data-page-size="1"

													class="form-control selectpage"

													name="row[shop_category_id]"

													type="text"

													placeholder="点击选择店铺分类">

													<div class="input-group-addon no-border no-padding">

														<span><button type="button" class="btn btn-danger btn-shopsort" ><?php echo __('新建分类'); ?></button></span>

													</div>

												</div>

											</div>

										</div>-->

									</div>

								</div>

							</div>

						</div>

						<div class="row" id="payment">

							<div class="col-md-12">

								<div class="panel panel-default">

									<div class="panel-heading">支付信息</div>

									<div class="panel-body">

										<div class="form-group">

										    <label class="control-label col-xs-12 col-sm-2"><?php echo __('Stock'); ?>:</label>

										    <div class="col-xs-12 col-sm-8">

										        <select  id="c-stock" data-rule="required" class="form-control selectpicker" name="row[stock]">

										            <?php if(is_array($stockList) || $stockList instanceof \think\Collection || $stockList instanceof \think\Paginator): if( count($stockList)==0 ) : echo "" ;else: foreach($stockList as $key=>$vo): ?>

										                <option value="<?php echo $key; ?>"><?php echo $vo; ?></option>

										            <?php endforeach; endif; else: echo "" ;endif; ?>

										        </select>

										    </div>

										</div>





									</div>

								</div>

							</div>

						</div>

						<!--<div class="row" id="logistics">

							<div class="col-md-12">

								<div class="panel panel-default">

									<div class="panel-heading">物流信息</div>

									<div class="panel-body">

										<div class="form-group">

										    <label class="control-label col-xs-12 col-sm-2"><?php echo __('Freight_id'); ?>:</label>

										    <div class="col-xs-12 col-sm-8">

												<div class="input-group">

													<input id="c-freight_id" data-rule="required" data-source="wanlshop/freightfront" class="form-control selectpage" name="row[freight_id]" type="text" placeholder="点击选择运费模板">

													<div class="input-group-addon no-border no-padding">

														<span><button type="button" class="btn btn-danger btn-freight" ><?php echo __('新建模板'); ?></button></span>

													</div>

												</div>

										    </div>

										</div>

										



									</div>

								</div>

							</div>

						</div>-->

						<div class="row" id="service">

							<div class="col-md-12">

								<div class="panel panel-default">

									<div class="panel-heading">售后信息</div>

									<div class="panel-body">

										<div class="form-group">

										    <label class="control-label col-xs-12 col-sm-2"><?php echo __('Status'); ?>:</label>

										    <div class="col-xs-12 col-sm-8">

										        <div class="radio">

										        <?php if(is_array($statusList) || $statusList instanceof \think\Collection || $statusList instanceof \think\Paginator): if( count($statusList)==0 ) : echo "" ;else: foreach($statusList as $key=>$vo): ?>

										        <label for="row[status]-<?php echo $key; ?>"><input id="row[status]-<?php echo $key; ?>" name="row[status]" type="radio" value="<?php echo $key; ?>" <?php if(in_array(($key), explode(',',"normal"))): ?>checked<?php endif; ?> /> <?php echo $vo; ?></label> 

										        <?php endforeach; endif; else: echo "" ;endif; ?>

										        </div>

										    </div>

										</div>

										



									</div>

								</div>

							</div>

						</div>



						<div class="form-group layer-footer">

							<div class="col-xs-12 col-sm-8">

								<button type="submit" class="btn btn-success btn-embossed disabled"><?php echo __('OK'); ?></button>

								<button type="reset" class="btn btn-default btn-embossed"><?php echo __('Reset'); ?></button>

							</div>

						</div>

					</form>

				</div>

			</div>

		</div>

	</div>

</div>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="/assets/js/require<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.js" data-main="/assets/js/require-backend<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.js?v=<?php echo htmlentities($site['version']); ?>"></script>
    </body>
</html>
