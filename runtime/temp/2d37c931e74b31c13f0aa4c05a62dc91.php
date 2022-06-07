<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:87:"/www/wwwroot/www.fdadeal.com/public/../application/admin/view/wanlshop/coupon/edit.html";i:1611680402;s:71:"/www/wwwroot/www.fdadeal.com/application/admin/view/layout/default.html";i:1608326192;s:68:"/www/wwwroot/www.fdadeal.com/application/admin/view/common/meta.html";i:1608326192;s:70:"/www/wwwroot/www.fdadeal.com/application/admin/view/common/script.html";i:1608326190;}*/ ?>
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
                                <form id="edit-form" class="form-horizontal" role="form" data-toggle="validator" method="POST" action="">	<div class="alert alert-warning-light"> 溫馨提示：商品詳情會自動加載店鋪所有優惠券，用戶端用戶中心僅推薦[可用範圍]為[全部商品]詳情 </div>	<div id="app" v-cloak>		<div class="form-group">			<label class="control-label col-xs-12 col-sm-2"><?php echo __('Type'); ?>:</label>			<div class="col-xs-12 col-sm-8">				<select  id="c-type" data-rule="required" class="form-control selectpicker" name="row[type]" v-model="type">					<?php if(is_array($typeList) || $typeList instanceof \think\Collection || $typeList instanceof \think\Paginator): if( count($typeList)==0 ) : echo "" ;else: foreach($typeList as $key=>$vo): ?>						<option value="<?php echo $key; ?>" <?php if(in_array(($key), is_array($row['type'])?$row['type']:explode(',',$row['type']))): ?>selected<?php endif; ?>><?php echo $vo; ?></option>					<?php endforeach; endif; else: echo "" ;endif; ?>				</select>			</div>		</div>		<div class="form-group">			<label class="control-label col-xs-12 col-sm-2"><?php echo __('Name'); ?>:</label>			<div class="col-xs-12 col-sm-8">				<input id="c-name" data-rule="required" class="form-control" name="row[name]" type="text" value="<?php echo htmlentities($row['name']); ?>">			</div>		</div>						<block v-if="type == 'vip'">			<div class="form-group">				<label class="control-label col-xs-12 col-sm-2"><?php echo __('Userlevel'); ?>:</label>				<div class="col-xs-12 col-sm-8">					<input id="c-userlevel" class="form-control" name="row[userlevel]" type="number" value="<?php echo htmlentities($row['userlevel']); ?>">				</div>			</div>			<div class="form-group">				<label class="control-label col-xs-12 col-sm-2"><?php echo __('Usertype'); ?>:</label>				<div class="col-xs-12 col-sm-8">													<select id="c-usertype" class="form-control selectpicker" name="row[usertype]" v-model="usertype">						<?php if(is_array($usertypeList) || $usertypeList instanceof \think\Collection || $usertypeList instanceof \think\Paginator): if( count($usertypeList)==0 ) : echo "" ;else: foreach($usertypeList as $key=>$vo): ?>							<option value="<?php echo $key; ?>" <?php if(in_array(($key), is_array($row['usertype'])?$row['usertype']:explode(',',$row['usertype']))): ?>selected<?php endif; ?>><?php echo $vo; ?></option>						<?php endforeach; endif; else: echo "" ;endif; ?>					</select>				</div>			</div>		</block>				<block v-if="type != 'vip'">			<div class="form-group">				<label class="control-label col-xs-12 col-sm-2"><?php echo __('Grant'); ?>:</label>				<div class="col-xs-12 col-sm-8">					<input id="c-grant" data-rule="required" class="form-control" name="row[grant]" type="number" value="<?php echo htmlentities($row['grant']); ?>">					<p class="text-gray" style="margin-top: 5px;">溫馨提示：設定為-1則不限數量</p>				</div>			</div>		</block>		<block v-if="type == 'reduction' || (type == 'vip' && usertype == 'reduction')">			<div class="form-group">				<label class="control-label col-xs-12 col-sm-2"><?php echo __('Price'); ?>:</label>				<div class="col-xs-12 col-sm-8">					<input id="c-price" class="form-control" step="0.01" name="row[price]" type="number" value="<?php echo htmlentities($row['price']); ?>">				</div>			</div>		</block>		<block v-if="type == 'discount' || (type == 'vip' && usertype == 'discount')">			<div class="form-group">				<label class="control-label col-xs-12 col-sm-2"><?php echo __('Discount'); ?>:</label>				<div class="col-xs-12 col-sm-8">					<input id="c-discount" class="form-control" step="0.1" name="row[discount]" type="number" value="<?php echo htmlentities($row['discount']); ?>">					<p class="text-gray" style="margin-top: 5px;">溫馨提示：9.8代表9.8折，0代表不折扣</p>				</div>			</div>		</block>		<div class="form-group">			<label class="control-label col-xs-12 col-sm-2"><?php echo __('Limit'); ?>:</label>			<div class="col-xs-12 col-sm-8">				<input id="c-limit" data-rule="required" class="form-control" step="0.01" name="row[limit]" type="number" value="<?php echo htmlentities($row['limit']); ?>">			</div>		</div>		<div class="form-group">			<label class="control-label col-xs-12 col-sm-2"><?php echo __('Rangetype'); ?>:</label>			<div class="col-xs-12 col-sm-8">											<select  id="c-rangetype" data-rule="required" class="form-control selectpicker" name="row[rangetype]" v-model="rangetype">					<?php if(is_array($rangetypeList) || $rangetypeList instanceof \think\Collection || $rangetypeList instanceof \think\Paginator): if( count($rangetypeList)==0 ) : echo "" ;else: foreach($rangetypeList as $key=>$vo): ?>						<option value="<?php echo $key; ?>" <?php if(in_array(($key), is_array($row['rangetype'])?$row['rangetype']:explode(',',$row['rangetype']))): ?>selected<?php endif; ?>><?php echo $vo; ?></option>					<?php endforeach; endif; else: echo "" ;endif; ?>				</select>			</div>		</div>		<block v-if="rangetype == 'goods' || rangetype == 'category'">			<div class="form-group">				<label class="control-label col-xs-12 col-sm-2">{{rangename[rangetype]}}:</label>				<div class="col-xs-12 col-sm-8">					<div class="input-group">						<input id="c-range" class="form-control" name="row[range]" type="text" v-model="range">						<div class="input-group-addon no-border" style="padding: 0; padding-left: 6px;">							<sapn v-if="rangetype == 'goods'" @click="goodsLink">								<div type="button" class="btn btn-primary"><i class="fa fa-list"></i> 選擇</div>							</sapn>							<sapn v-else @click="categoryLink">								<div type="button" class="btn btn-primary"><i class="fa fa-list"></i> 選擇</div>							</sapn>						</div>					</div>				</div>			</div>		</block>				<block v-if="type != 'vip'">			<div class="form-group">				<label class="control-label col-xs-12 col-sm-2"><?php echo __('Pretype'); ?>:</label>				<div class="col-xs-12 col-sm-8">													<select  id="c-pretype" data-rule="required" class="form-control selectpicker" name="row[pretype]"  v-model="pretype">						<?php if(is_array($pretypeList) || $pretypeList instanceof \think\Collection || $pretypeList instanceof \think\Paginator): if( count($pretypeList)==0 ) : echo "" ;else: foreach($pretypeList as $key=>$vo): ?>							<option value="<?php echo $key; ?>" <?php if(in_array(($key), is_array($row['pretype'])?$row['pretype']:explode(',',$row['pretype']))): ?>selected<?php endif; ?>><?php echo $vo; ?></option>						<?php endforeach; endif; else: echo "" ;endif; ?>					</select>							</div>			</div>		</block>		<block v-if="type == 'vip' || pretype == 'appoint'">			<div class="form-group">				<label class="control-label col-xs-12 col-sm-2"><?php echo __('Validity'); ?>:</label>				<div class="col-xs-12 col-sm-8">					<input id="c-validity" class="form-control" name="row[validity]" type="number" value="<?php echo htmlentities($row['validity']); ?>">					<p class="text-gray" style="margin-top: 5px;">溫馨提示：設定為0標識不會過期</p>				</div>			</div>		</block>		<block v-show="type != 'vip' && pretype == 'fixed'">			<div class="form-group">				<label class="control-label col-xs-12 col-sm-2"><?php echo __('Startdate'); ?>:</label>				<div class="col-xs-12 col-sm-8">					<input id="c-startdate" class="form-control datetimepicker" data-date-format="YYYY-MM-DD" data-use-current="true" name="row[startdate]" type="text" value="<?php echo $row['startdate']; ?>">				</div>			</div>			<div class="form-group">				<label class="control-label col-xs-12 col-sm-2"><?php echo __('Enddate'); ?>:</label>				<div class="col-xs-12 col-sm-8">					<input id="c-enddate" class="form-control datetimepicker" data-date-format="YYYY-MM-DD" data-use-current="true" name="row[enddate]" type="text" value="<?php echo $row['enddate']; ?>">				</div>			</div>		</block>		<div class="form-group">			<label class="control-label col-xs-12 col-sm-2"><?php echo __('Drawlimit'); ?>:</label>			<div class="col-xs-12 col-sm-8">				<input id="c-drawlimit" data-rule="required" class="form-control" name="row[drawlimit]" type="number" value="<?php echo htmlentities($row['drawlimit']); ?>">				<p class="text-gray" style="margin-top: 5px;">溫馨提示：設定為0則不限領取數量</p>			</div>		</div>				<div class="form-group">			<label class="control-label col-xs-12 col-sm-2"><?php echo __('Content'); ?>:</label>			<div class="col-xs-12 col-sm-8">				<textarea id="c-content" class="form-control editor" rows="5" name="row[content]" cols="50"><?php echo htmlentities($row['content']); ?></textarea>			</div>		</div>		<div class="form-group layer-footer">			<label class="control-label col-xs-12 col-sm-2"></label>			<div class="col-xs-12 col-sm-8">				<button type="submit" class="btn btn-success btn-embossed disabled"><?php echo __('OK'); ?></button>				<button type="reset" class="btn btn-default btn-embossed"><?php echo __('Reset'); ?></button>			</div>		</div>	</div></form>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="/assets/js/require<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.js" data-main="/assets/js/require-backend<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.js?v=<?php echo htmlentities($site['version']); ?>"></script>
    </body>
</html>
