<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:95:"/www/wwwroot/www.fdadeal.com/public/../application/admin/view/wanlshop/wholeorder/relative.html";i:1608486590;s:71:"/www/wwwroot/www.fdadeal.com/application/admin/view/layout/default.html";i:1608326192;s:68:"/www/wwwroot/www.fdadeal.com/application/admin/view/common/meta.html";i:1608326192;s:70:"/www/wwwroot/www.fdadeal.com/application/admin/view/common/script.html";i:1608326190;}*/ ?>
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

	.content{

		padding: 0;

	}

	/* 框架 */

	.wanl_kuaidi{

		background: url(/assets/addons/wanlshop/img/kuaidi/spider_search_v4.png) 0px 0px repeat-x;

		padding: 20px 15px;

	}

	.wanl_kuaidi td{

	  padding: 7px;

	}

	.wanl_kuaidi th{

		padding: 7px;

		font-weight: inherit;

		font-size: 16px;

	}

	.wanl_kuaidi .last td,  .wanl_kuaidi .last td a{

	  color: #ff7800;

	  border-bottom: none;

	}

	/* 图标线段 */

	.wanl_kuaidi .process{

		position: relative;

		color: #b3b3b3;

	    width: 60px;

	    text-align: center;

	}

	.wanl_kuaidi .process .line{

		background: #b3b3b3;

		position: absolute;

		width: 1px;

		height: 72%;

		left: 29px;

		bottom: -17px;

	}

	/* 时间 */

	.wanl_kuaidi .status {

	  width: 105px;

	  text-align: center;

	  padding-left: 14px;

	  padding-right: 0;

	}

	.wanl_kuaidi .status .day {

	  display:block;

	}

	.wanl_kuaidi .status .time {

	  font-size: 13px;

	}

	/* 内容 */

	.wanl_kuaidi .info span{

		display: block;

		font-weight: bold;

	}

</style>



<div class="wanl_kuaidi">

	



	<table class="">

		<thead>

		    <tr>

		      <th style="text-align: center;padding-left: 14px;">时间</th>

		      <th></th>

			  <th>地点和跟踪进度</th>

		    </tr>

		  </thead>

		<tbody>

		<?php switch($row['state']): case "1": ?>

				<tr>

					<td class="status"><span class="day"><?php echo date("Y.m.d",$row['createtime']); ?></span><span class="time"><?php echo date("H:i",$row['createtime']); ?></span><span class="week"><?php echo $week[date('w', $row['paymenttime'])]; ?></span></td>

					<td class="process">

						<i class="fa fa-credit-card"></i>

					</td>

					<td class="info"><span>尚未付款</span>付款后，即可将商品发出</td>

				</tr>

			<?php break; case "2": ?>

				<tr>

					<td class="status"><span class="day"><?php echo date("Y.m.d",$row['paymenttime']); ?></span><span class="time"><?php echo date("H:i",$row['paymenttime']); ?></span> <span class="week"><?php echo $week[date('w', $row['paymenttime'])]; ?></span></td>

					<td class="process">

						<i class="fa fa-shopping-cart"></i>

					</td>

					<td class="info"><span>已付款</span>商家正在处理订单</td>

				</tr>

			<?php break; default: if(empty($list) || (($list instanceof \think\Collection || $list instanceof \think\Paginator ) && $list->isEmpty())): ?>

				<tr>

					<td class="status">

						<span class="day"><?php echo date("Y.m.d",$row['paymenttime']); ?></span>

						<span class="time"><?php echo date("H:i",$row['paymenttime']); ?></span>

						<span class="week"></span>

					</td>

					<td class="process">

						<i class="fa fa-truck"></i>

					</td>

					<td class="info"><span>已发货</span>包裹正在等待快递小哥揽收~</td>

				</tr>

				<?php else: ?>

				<!-- 快递单当前状态，包括0在途，1揽收，2疑难，3签收，4退签，5派件，6退回，7转投 等7个状态 -->

					<?php if(is_array($list) || $list instanceof \think\Collection || $list instanceof \think\Paginator): $i = 0; $__LIST__ = $list;if( count($__LIST__)==0 ) : echo "" ;else: foreach($__LIST__ as $key=>$vo): $mod = ($i % 2 );++$i;?>

					<tr class="<?php if(in_array(($key), explode(',',"0"))): ?> last <?php endif; ?>">

						<td class="status"><span class="day"><?php echo date("Y.m.d",$vo['time']); ?></span><span class="time"><?php echo date("H:i",$vo['time']); ?></span><span class="week"><?php echo $vo['week']; ?></span></td>

						<td class="process">

							<?php switch($vo['status']): case "在途": ?><i class="fa fa-chevron-circle-up"></i><?php break; case "揽收": ?><i class="fa fa-archive"></i><?php break; case "疑难": ?><i class="fa fa-exclamation-circle"></i><?php break; case "签收": ?><i class="fa fa-check"></i><?php break; case "退签": ?><i class="fa fa-reply"></i><?php break; case "派件": ?><i class="fa fa-user"></i><?php break; case "退回": ?><i class="fa fa-hand-paper-o"></i><?php break; case "转投": ?><i class="fa fa-share-square"></i><?php break; endswitch; ?>

							<div class="line"></div>

						</td>

						<td class="info"><span><?php if($vo['status'] != '在途'): ?><?php echo $vo['status']; endif; ?></span><?php echo $vo['context']; ?></td>

					</tr>

					<?php endforeach; endif; else: echo "" ;endif; endif; endswitch; ?>	

		</tbody>

	</table>

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
