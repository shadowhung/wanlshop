<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:93:"/www/wwwroot/www.fdadeal.com/public/../application/admin/view/wanlshop/freightfront/edit.html";i:1608476112;s:71:"/www/wwwroot/www.fdadeal.com/application/admin/view/layout/default.html";i:1608326192;s:68:"/www/wwwroot/www.fdadeal.com/application/admin/view/common/meta.html";i:1608326192;s:70:"/www/wwwroot/www.fdadeal.com/application/admin/view/common/script.html";i:1608326190;}*/ ?>
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
                                <style type="text/css">
	.choice {
		display: none;
	}
	.choice .link-muted {
	    color: #666;
	}
	/* 全局 */
	.choice .clearfloat {
		zoom: 1;
	}
	.choice .clearfloat:after {
		display: block;
		clear: both;
		content: "";
		visibility: hidden;
		height: 0;
	}
	.choice label {
		font-weight: 400;
		font-size: 1.4rem;
	}
	.choice input[type=checkbox] {
		margin-right: .3rem;
	}
	/* 主体 */
	.choice .list{
		margin: 0 40px;
	}
	.choice .subject .ratio {
		color: red;
	}
	.choice .subject label {
		padding-right: 10px;
		text-align: left;
		width: auto;
		float: left;
		cursor: pointer;
	}
	.choice .subject .citys {
		width: auto;
		background-color: #fff;
		position: absolute;
		top: 35px;
		border: 1px solid #ccc;
		z-index: 100;
		visibility: hidden;
	}
	.choice .subject .citys>i.jt {
		width: 0;
		height: 0;
		border-left: 8px solid transparent;
		border-right: 8px solid transparent;
		border-bottom: 10px solid #ccc;
		position: absolute;
		top: -10px;
		left: 20px;
	}
	.choice .subject .citys>i.jt i {
		width: 0;
		height: 0;
		border-left: 8px solid transparent;
		border-right: 8px solid transparent;
		border-bottom: 10px solid #fff;
		position: absolute;
		top: 2px;
		left: -8px;
	}
	.choice .subject .citys .row-div {
		min-width: 250px;
		padding: 10px;
		box-sizing: border-box;
	}
	.choice .subject .citys .row-div label span {
		max-width: 175px;
		white-space: nowrap;
		vertical-align: middle;
		font-size: 1.4rem;
	}
	.choice .subject .choice-tooltips:hover .citys {
		visibility: visible;
	}
	.choice .subject p {
		float: left;
		width: auto;
		margin: 2px 0;
	}
	.choice .subject>div {
		float: left;
		width: 170px;
		margin: 0;
		padding-bottom: 10px;
		padding-top: 5px;
		position: relative;
	}
	
	.choice .operation{
		display: flex;
		align-items: center;
		background: #f3f3f3;
		height: 50px;
		margin-bottom: 10px;
		padding-left: 40px;
	}
	.choice .city-empty{
		margin-left: 10px;
	}
	
</style>
<form id="add-form" class="form-horizontal" role="form" data-toggle="validator" method="POST" action="">
    <div class="form-group">
        <label class="control-label col-xs-12 col-sm-2"><?php echo __('Name'); ?>:</label>
        <div class="col-xs-12 col-sm-8">
            <input id="c-name" data-rule="required" class="form-control" name="row[name]" type="text" value="<?php echo htmlentities($row['name']); ?>">
        </div>
    </div>
	<div id="app" v-cloak>
		<div class="form-group">
			<label class="control-label col-xs-12 col-sm-2"><?php echo __('Delivery'); ?>:</label>
			<div class="col-xs-12 col-sm-8">
				<select  id="c-delivery" data-rule="required" class="form-control selectpicker" name="row[delivery]">
				    <?php if(is_array($deliveryList) || $deliveryList instanceof \think\Collection || $deliveryList instanceof \think\Paginator): if( count($deliveryList)==0 ) : echo "" ;else: foreach($deliveryList as $key=>$vo): ?>
				        <option value="<?php echo $key; ?>" <?php if(in_array(($key), is_array($row['delivery'])?$row['delivery']:explode(',',$row['delivery']))): ?>selected<?php endif; ?>><?php echo $vo; ?></option>
				    <?php endforeach; endif; else: echo "" ;endif; ?>
				</select>
			</div>
		</div>
		<!-- 是否包邮 -->
		<div class="form-group">
			<label class="control-label col-xs-12 col-sm-2"><?php echo __('Isdelivery'); ?>:</label>
			<div class="col-xs-12 col-sm-8">
				<div class="radio">
				<?php if(is_array($isdeliveryList) || $isdeliveryList instanceof \think\Collection || $isdeliveryList instanceof \think\Paginator): if( count($isdeliveryList)==0 ) : echo "" ;else: foreach($isdeliveryList as $key=>$vo): ?>
				<label for="row[isdelivery]-<?php echo $key; ?>"><input id="row[isdelivery]-<?php echo $key; ?>" name="row[isdelivery]" type="radio" value="<?php echo $key; ?>" <?php if(in_array(($key), is_array($row['isdelivery'])?$row['isdelivery']:explode(',',$row['isdelivery']))): ?>checked<?php endif; ?> v-model="isdelivery"/> <?php echo $vo; ?></label> 
				<?php endforeach; endif; else: echo "" ;endif; ?>
				</div>
			</div>
		</div>
		<!-- 计价方式 -->
		<div class="form-group" v-if="isdelivery == 0">
			<label class="control-label col-xs-12 col-sm-2"><?php echo __('Valuation'); ?>:</label>
			<div class="col-xs-12 col-sm-8">
				<div class="radio">
				<?php if(is_array($valuationList) || $valuationList instanceof \think\Collection || $valuationList instanceof \think\Paginator): if( count($valuationList)==0 ) : echo "" ;else: foreach($valuationList as $key=>$vo): ?>
				<label for="row[valuation]-<?php echo $key; ?>"><input id="row[valuation]-<?php echo $key; ?>" name="row[valuation]" type="radio" value="<?php echo $key; ?>" <?php if(in_array(($key), is_array($row['valuation'])?$row['valuation']:explode(',',$row['valuation']))): ?>checked<?php endif; ?> v-model="valuation"/> <?php echo $vo; ?></label> 
				<?php endforeach; endif; else: echo "" ;endif; ?>
				</div>
			</div>
		</div>
		<!-- 运费模板 -->
		<div class="form-group" v-if="isdelivery == 0">
			<label class="control-label col-xs-12 col-sm-2"><?php echo __('运费数据'); ?>:</label>
			<div class="col-xs-12 col-sm-8">
				<div class="table-responsive">
					<table class="table table-bordered">
					    <thead>
					        <tr height="45">
					            <th style="text-align: center; vertical-align: middle;" width="42%">可配送区域</th>
					            <th style="text-align: center; vertical-align: middle;"> 
									<span class="first" v-if="valuation == 0"> 首件 (个) </span>
									<span class="first" v-else-if="valuation == 1"> 首重 (Kg) </span>
									<span class="first" v-else-if="valuation == 2"> 首面积 (m³) </span>
								</th>
					            <th style="text-align: center; vertical-align: middle;">运费 (元)</th>
					            <th style="text-align: center; vertical-align: middle;">
									<span class="additional" v-if="valuation == 0">续件 (个)</span>
									<span class="additional" v-if="valuation == 1">续重 (Kg)</span>
									<span class="additional" v-if="valuation == 2">续面积 (m³)</span>
								</th>
					            <th style="text-align: center; vertical-align: middle;">续费 (元)</th>
					        </tr>
					    </thead>
					    <tbody>
					        <tr v-for="(item, formIndex) in forms">
					            <td>
									<div>
										<span v-if="item.citys.length == 407">全国</span>
										<template v-else v-for="(province, index) in item.treeData">
											<span>{{ province.name }}</span>
											<template v-if="!province.isAllCitys">
												(<span class="link-muted">
													<template v-for="(city, index) in province.citys">
														<span>{{ city.name }}</span><span v-if="(index + 1) < province.citys.length">、</span>
													</template>
												</span>)
											</template>
										</template>
									</div>
									<div align="right"> 
										<a @click.stop="onEditerForm(formIndex, item)" href="javascript:void(0);">编辑</a> 
										<a href="javascript:void(0);" @click.stop="onDeleteForm(formIndex)">删除</a> 
									</div>
									<input type="hidden" name="row[rule][province][]" :value="item.province">
									<input type="hidden" name="row[rule][citys][]" :value="item.citys">
								</td>
					            <td> <input id="c-rule-first" data-rule="required" class="form-control" name="row[rule][first][]" v-model="item.first" value="" type="number"> </td>
					            <td> <input id="c-rule-first_fee" data-rule="required" class="form-control" name="row[rule][first_fee][]" v-model="item.first_fee" value="" type="number"> </td>
					            <td> <input id="c-rule-additional" data-rule="required" class="form-control" name="row[rule][additional][]" v-model="item.additional" value="" type="number"> </td>
					            <td> <input id="c-rule-additional_fee" data-rule="required" class="form-control" name="row[rule][additional_fee][]" v-model="item.additional_fee" value="" type="number"> </td>
					        </tr>
							<tr>
								<td colspan="5">
									<a class="btn btn-default" href="javascript:void(0);" @click.stop="onAddRegionEvent">
										<i class="fa fa-map-marker"></i> 点击添加可配送区域和运费
									</a>
								</td>
							</tr>
					    </tbody>
					</table>
				</div>
			</div>
		</div>
		<!-- 地区选择 -->
		<div ref="choice" class="choice">
			<div class="operation">
				<label> <input type="checkbox" @change="onCheckAll(!checkAll)" :checked="checkAll"> 全选</label>
				<a class="city-empty" href="javascript:void(0);" @click="onCheckAll(false)">清空</a>
			</div>
			<div class="list clearfloat">
				<div class="subject clearfloat">
					<div v-for="item in regions" v-if="!isPropertyExist(item.id, disable.treeData) || !disable.treeData[item.id].isAllCitys" class="choice-tooltips">
						<label>
							<input type="checkbox" class="province" :value="item.id" :checked="inArray(item.id, checked.province)" @change="onCheckedProvince">
							<span class="province_name">{{ item.name }}</span><span class="ratio"></span>
						</label>
						<div class="citys">
							<i class="jt"><i></i></i>
							<div class="row-div clearfloat">
								<p v-for="city in item.city" v-if="!inArray(city.id, disable.citys)">
									<label>
										<input class="city" type="checkbox" :value="city.id" :checked="inArray(city.id, checked.citys)" @change="onCheckedCity($event, item.id)">
										<span>{{ city.name }}</span>
									</label>
								</p>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>	
	<div class="form-group layer-footer">
        <label class="control-label col-xs-12 col-sm-2"></label>
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
        <script src="/assets/js/require<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.js" data-main="/assets/js/require-backend<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.js?v=<?php echo htmlentities($site['version']); ?>"></script>
    </body>
</html>
