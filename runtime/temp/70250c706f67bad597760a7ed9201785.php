<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:89:"/www/wwwroot/www.fdadeal.com/public/../application/admin/view/wanlshop/client/client.html";i:1608326198;s:71:"/www/wwwroot/www.fdadeal.com/application/admin/view/layout/default.html";i:1608326192;s:68:"/www/wwwroot/www.fdadeal.com/application/admin/view/common/meta.html";i:1608326192;s:70:"/www/wwwroot/www.fdadeal.com/application/admin/view/common/script.html";i:1608326190;}*/ ?>
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
                                <div class="alert alert-success-light">
	<i class="fa fa-warning"></i> 温馨提示：点击【更新】后系统将一键自动生成客户端配置文件；点击【生成源码】获取客户端源文件，导入HBuilder X中，简单配置App图标即刻直接生成各类移动设备终端；修改后需要重新生成源码导入HBuilder X
</div>
<div class="panel panel-default panel-intro">
	<div class="panel-heading">
		<div class="panel-lead"><em>应用配置</em>用于客户端（应用）全局配置</div>
		<ul class="nav nav-tabs">
			<li class="active"><a href="#ini" data-toggle="tab">全局配置</a></li>
			<li><a href="#sdk_amap" data-toggle="tab">高德SDK</a></li>
			<li><a href="#sdk_qq" data-toggle="tab">腾讯SDK</a></li>
			<li><a href="#sdk_alipay" data-toggle="tab">支付宝SDK</a></li>
			<li><a href="#sdk_weibo" data-toggle="tab">微博SDK</a></li>
		</ul>
	</div>
	<div class="panel-body">
		<div id="myTabContent" class="tab-content">
			<div class="tab-pane fade active in" id="ini">
				<div class="widget-body no-padding">
					<form id="ini-form" class="edit-form form-horizontal" role="form" data-toggle="validator" method="POST" action="<?php echo url('wanlshop.client/edit'); ?>">
					    <?php echo token(); ?>	
						<table class="table table-striped">
							<thead>
								<tr>
									<th width="15%">配置项</th>
									<th width="85%">参数</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>应用名称</td>
									<td>
										<div class="row">
											<div class="col-sm-8 col-xs-12">
												<?php echo Form::text('row[ini][name]', $wanlshop['ini']['name'], ['data-rule'=>'required','data-tip'=>'请填写应用名称','placeholder'=>'应用名称，同等于app名称']); ?>
											</div>
											<div class="col-sm-4"></div>
										</div>
									</td>
								</tr>
								<tr>
									<td>应用图标</td>
									<td>
										<div class="row">
											<div class="col-sm-8 col-xs-12">
												<?php echo Form::image('row[ini][logo]', $wanlshop['ini']['logo'], ['data-rule'=>'required','data-tip'=>'请上传应用图标','placeholder'=>'请上传应用图标']); ?>
											</div>
											<div class="col-sm-4"></div>
										</div>
									</td>
								</tr>
								<tr>
									<td>版权信息</td>
									<td>
										<div class="row">
											<div class="col-sm-8 col-xs-12">
												<?php echo Form::text('row[ini][copyright]', $wanlshop['ini']['copyright'], ['data-rule'=>'required','data-tip'=>'请填写应用版权信息','placeholder'=>'应用版权信息，用于关于软件展示信息']); ?>
											</div>
											<div class="col-sm-4"></div>
										</div>
									</td>
								</tr>
								<tr>
									<td>应用包名</td>
									<td>
										<div class="row">
											<div class="col-sm-8 col-xs-12">
												<?php echo Form::text('row[ini][package_name]', $wanlshop['ini']['package_name'], ['data-rule'=>'required','data-tip'=>'请填写应用包名','placeholder'=>'包名一般域名倒序，如com.def.abc']); ?>
											</div>
											<div class="col-sm-4"></div>
										</div>
									</td>
								</tr>
								<tr>
									<td>CDN服务器</td>
									<td>
										<div class="row">
											<div class="col-sm-8 col-xs-12">
												<?php echo Form::text('row[ini][cdnurl]', $wanlshop['ini']['cdnurl'], ['data-rule'=>'required','data-tip'=>'请填写应用CDN地址','placeholder'=>'建议https://你的域名或使用OSS地址，因为即时通讯使用wss']); ?>
											</div>
											<div class="col-sm-4"></div>
										</div>
									</td>
								</tr>
								<tr>
									<td>API服务器</td>
									<td>
										<div class="row">
											<div class="col-sm-8 col-xs-12">
												<?php echo Form::text('row[ini][appurl]', $wanlshop['ini']['appurl'], ['data-rule'=>'required','data-tip'=>'请填写应用API服务器地址','placeholder'=>'你的域名/api 或者 https://api.abc.com']); ?>
											</div>
											<div class="col-sm-4"></div>
										</div>
									</td>
								</tr>
								<tr>
									<td>IM服务器</td>
									<td>
										<div class="row">
											<div class="col-sm-8 col-xs-12">
												<?php echo Form::text('row[ini][socketurl]', $wanlshop['ini']['socketurl'], ['data-tip'=>'请填写IM服务器地址','placeholder'=>'你的ws://服务器ip:7272 或者 wss://服务器']); ?>
											</div>
											<div class="col-sm-4"></div>
										</div>
									</td>
								</tr>
								<tr>
									<td>调试</td>
									<td>
										<div class="row">
											<div class="col-sm-8 col-xs-12">
												<?php echo Form::switcher('row[ini][debug]', $wanlshop['ini']['debug'], ['color'=>'success', 'yes'=>'Y', 'no'=>'N']); ?>
											</div>
											<div class="col-sm-4"></div>
										</div>
									</td>
								</tr>
							</tbody>
							<tfoot>
								<tr>
									<th></th>
									<th>
										<button type="submit" class="btn btn-success btn-embossed"><?php echo __('更新'); ?></button>
										<a href="<?php echo url('wanlshop.client/download'); ?>" class="btn btn-default btn-embossed packing">生成源码</a>
										<button type="reset" class="btn btn-default btn-embossed">重置</button>
									</th>
								</tr>
							</tfoot>
						</table>
					</form>
				</div>
			</div>
			<div class="tab-pane fade" id="sdk_amap">
				<div class="widget-body no-padding">
					<form id="chat-form" class="edit-form form-horizontal" role="form" data-toggle="validator" method="POST" action="<?php echo url('wanlshop.client/edit'); ?>">
					    <?php echo token(); ?>	
						<table class="table table-striped">
							<thead>
								<tr>
									<th width="15%">配置项</th>
									<th width="85%">参数</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>高德网页秘钥</td>
									<td>
										<div class="row">
											<div class="col-sm-8 col-xs-12">
												<?php echo Form::text('row[sdk_amap][amapkey_web]', $wanlshop['sdk_amap']['amapkey_web'], ['data-rule'=>'required','data-tip'=>'请填写高德网页秘钥','placeholder'=>'请填写高德网页 amapkey']); ?>
											</div>
											<div class="col-sm-4"></div>
										</div>
									</td>
								</tr>
								<tr>
									<td>高德IOS秘钥</td>
									<td>
										<div class="row">
											<div class="col-sm-8 col-xs-12">
												<?php echo Form::text('row[sdk_amap][amapkey_ios]', $wanlshop['sdk_amap']['amapkey_ios'], ['data-rule'=>'required','data-tip'=>'请填写高德IOS秘钥','placeholder'=>'请填写高德IOS amapkey']); ?>
											</div>
											<div class="col-sm-4"></div>
										</div>
									</td>
								</tr>
								<tr>
									<td>高德安卓秘钥</td>
									<td>
										<div class="row">
											<div class="col-sm-8 col-xs-12">
												<?php echo Form::text('row[sdk_amap][amapkey_android]', $wanlshop['sdk_amap']['amapkey_android'], ['data-rule'=>'required','data-tip'=>'请填写高德安卓秘钥','placeholder'=>'请填写高德安卓秘钥']); ?>
											</div>
											<div class="col-sm-4"></div>
										</div>
									</td>
								</tr>
							</tbody>
							<tfoot>
								<tr>
									<th></th>
									<th>
										<button type="submit" class="btn btn-success btn-embossed"><?php echo __('更新'); ?></button>
										<a href="<?php echo url('wanlshop.client/download'); ?>" class="btn btn-default btn-embossed packing">生成源码</a>
										<button type="reset" class="btn btn-default btn-embossed">重置</button>
									</th>
								</tr>
							</tfoot>
						</table>
					</form>
				</div>
			</div>
			<div class="tab-pane fade" id="sdk_qq">
				<div class="widget-body no-padding">
					<form id="chat-form" class="edit-form form-horizontal" role="form" data-toggle="validator" method="POST" action="<?php echo url('wanlshop.client/edit'); ?>">
					    <?php echo token(); ?>	
						<table class="table table-striped">
							<thead>
								<tr>
									<th width="15%">配置项</th>
									<th width="85%">参数</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>QQ开放平台appid</td>
									<td>
										<div class="row">
											<div class="col-sm-8 col-xs-12">
												<?php echo Form::text('row[sdk_qq][qq_appid]', $wanlshop['sdk_qq']['qq_appid'], ['data-rule'=>'required','data-tip'=>'请填写QQ开放平台 appid','placeholder'=>'请填写QQ开放平台 appid']); ?>
											</div>
											<div class="col-sm-4"></div>
										</div>
									</td>
								</tr>
								<tr>
									<td>微信公众平台appid</td>
									<td>
										<div class="row">
											<div class="col-sm-8 col-xs-12">
												<?php echo Form::text('row[sdk_qq][gz_appid]', $wanlshop['sdk_qq']['gz_appid'], ['data-rule'=>'required','data-tip'=>'请填写微信公众平台 appid','placeholder'=>'请填写微信公众平台 appid']); ?>
											</div>
											<div class="col-sm-4"></div>
										</div>
									</td>
								</tr>
								<tr>
									<td>微信开放平台appid</td>
									<td>
										<div class="row">
											<div class="col-sm-8 col-xs-12">
												<?php echo Form::text('row[sdk_qq][wx_appid]', $wanlshop['sdk_qq']['wx_appid'], ['data-rule'=>'required','data-tip'=>'请填写微信开放平台 appid','placeholder'=>'请填写微信开放平台 appid']); ?>
											</div>
											<div class="col-sm-4"></div>
										</div>
									</td>
								</tr>
								<tr>
									<td>微信开放平台appsecret</td>
									<td>
										<div class="row">
											<div class="col-sm-8 col-xs-12">
												<?php echo Form::text('row[sdk_qq][wx_appsecret]', $wanlshop['sdk_qq']['wx_appsecret'], ['data-rule'=>'required','data-tip'=>'请填写微信开放平台 appsecret','placeholder'=>'请填写微信开放平台 appsecret']); ?>
											</div>
											<div class="col-sm-4"></div>
										</div>
									</td>
								</tr>
								<tr>
									<td>微信开放平台通用链接</td>
									<td>
										<div class="row">
											<div class="col-sm-8 col-xs-12">
												<?php echo Form::text('row[sdk_qq][wx_universal_links]', $wanlshop['sdk_qq']['wx_universal_links'], ['data-rule'=>'required','data-tip'=>'请填写微信开放平台通用链接','placeholder'=>'请填写微信开放平台通用链接']); ?>
											</div>
											<div class="col-sm-4"></div>
										</div>
									</td>
								</tr>
								<tr>
									<td>微信支付商户ID</td>
									<td>
										<div class="row">
											<div class="col-sm-8 col-xs-12">
												<?php echo Form::text('row[sdk_qq][mch_id]', $wanlshop['sdk_qq']['mch_id'], ['data-rule'=>'required','data-tip'=>'微信支付商户ID','placeholder'=>'微信支付商户ID']); ?>
											</div>
											<div class="col-sm-4"></div>
										</div>
									</td>
								</tr>
								<tr>
									<td>微信支付API密钥</td>
									<td>
										<div class="row">
											<div class="col-sm-8 col-xs-12">
												<?php echo Form::text('row[sdk_qq][key]', $wanlshop['sdk_qq']['key'], ['data-rule'=>'required','data-tip'=>'请填写微信支付-API安全-API密钥','placeholder'=>'请填写微信支付-API安全-API密钥']); ?>
											</div>
											<div class="col-sm-4"></div>
										</div>
									</td>
								</tr>
								<tr>
									<td>微信支付回调地址</td>
									<td>
										<div class="row">
											<div class="col-sm-8 col-xs-12">
												<?php echo Form::text('row[sdk_qq][notify_url]', $wanlshop['sdk_qq']['notify_url'], ['data-rule'=>'required','data-tip'=>'请填写微信支付-产品中心-开发配置-Native支付回调链接','placeholder'=>'请填写微信支付-产品中心-开发配置-Native支付回调链接']); ?>
											</div>
											<div class="col-sm-4"></div>
										</div>
									</td>
								</tr>
								<tr>
									<td>开启微信支付证书</td>
									<td>
										<div class="row">
											<div class="col-sm-8 col-xs-12">
												<?php echo Form::switcher('row[sdk_qq][pay_cert]', $wanlshop['sdk_qq']['pay_cert'], ['color'=>'success']); ?>
											</div>
											<div class="col-sm-4"></div>
										</div>
									</td>
								</tr>
							</tbody>
							<tfoot>
								<tr>
									<th></th>
									<th>
										<button type="submit" class="btn btn-success btn-embossed"><?php echo __('更新'); ?></button>
										<a href="<?php echo url('wanlshop.client/download'); ?>" class="btn btn-default btn-embossed packing">生成源码</a>
										<button type="reset" class="btn btn-default btn-embossed">重置</button>
									</th>
								</tr>
							</tfoot>
						</table>
					</form>
				</div>
			</div>
			<div class="tab-pane fade" id="sdk_alipay">
				<div class="widget-body no-padding">
					<form id="chat-form" class="edit-form form-horizontal" role="form" data-toggle="validator" method="POST" action="<?php echo url('wanlshop.client/edit'); ?>">
					    <?php echo token(); ?>	
						<table class="table table-striped">
							<thead>
								<tr>
									<th width="15%">配置项</th>
									<th width="85%">参数</th>
								</tr>
							</thead>
							<tbody>
								<tr>
									<td>支付宝应用app_id</td>
									<td>
										<div class="row">
											<div class="col-sm-8 col-xs-12">
												<?php echo Form::text('row[sdk_alipay][app_id]', $wanlshop['sdk_alipay']['app_id'], ['data-rule'=>'required','data-tip'=>'请填写 支付宝开放平台-网页移动应用-APPID','placeholder'=>'请填写 支付宝开放平台-网页移动应用-APPID']); ?>
											</div>
											<div class="col-sm-4"></div>
										</div>
									</td>
								</tr>
								<tr>
									<td>支付宝回调接口</td>
									<td>
										<div class="row">
											<div class="col-sm-8 col-xs-12">
												<?php echo Form::text('row[sdk_alipay][notify_url]', $wanlshop['sdk_alipay']['notify_url'], ['data-rule'=>'required','data-tip'=>'请填写 支付宝开放平台-网页移动应用-授权回调地址','placeholder'=>'请填写 支付宝开放平台-网页移动应用-授权回调地址']); ?>
											</div>
											<div class="col-sm-4"></div>
										</div>
									</td>
								</tr>
								<tr>
									<td>支付宝验证接口</td>
									<td>
										<div class="row">
											<div class="col-sm-8 col-xs-12">
												<?php echo Form::text('row[sdk_alipay][return_url]', $wanlshop['sdk_alipay']['return_url'], ['data-rule'=>'required','data-tip'=>'请填写支付宝验证接口','placeholder'=>'请填写支付宝验证接口']); ?>
											</div>
											<div class="col-sm-4"></div>
										</div>
									</td>
								</tr>
								<tr>
									<td>支付宝公钥</td>
									<td>
										<div class="row">
											<div class="col-sm-8 col-xs-12">
												<?php echo Form::textarea('row[sdk_alipay][ali_public_key]', $wanlshop['sdk_alipay']['ali_public_key'], ['data-rule'=>'required','data-tip'=>'请填写支付开放平台-应用信息-接口加签方式-支付宝公钥','placeholder'=>'请填写支付开放平台-应用信息-接口加签方式-支付宝公钥']); ?>
											</div>
											<div class="col-sm-4"></div>
										</div>
									</td>
								</tr>
								<tr>
									<td>支付应用私钥</td>
									<td>
										<div class="row">
											<div class="col-sm-8 col-xs-12">
												<?php echo Form::textarea('row[sdk_alipay][private_key]', $wanlshop['sdk_alipay']['private_key'], ['data-rule'=>'required','data-tip'=>'请填写支付宝开放平台开发助手-应用私钥','placeholder'=>'请填写支付宝开放平台开发助手-应用私钥']); ?>
											</div>
											<div class="col-sm-4"></div>
										</div>
									</td>
								</tr>
							</tbody>
							<tfoot>
								<tr>
									<th></th>
									<th>
										<button type="submit" class="btn btn-success btn-embossed"><?php echo __('更新'); ?></button>
										<a href="<?php echo url('wanlshop.client/download'); ?>" class="btn btn-default btn-embossed packing">生成源码</a>
										<button type="reset" class="btn btn-default btn-embossed">重置</button>
									</th>
								</tr>
							</tfoot>
						</table>
					</form>
				</div>
			</div>
			<div class="tab-pane fade" id="sdk_weibo">
				<div class="widget-body no-padding">
					<form id="chat-form" class="edit-form form-horizontal" role="form" data-toggle="validator" method="POST" action="<?php echo url('wanlshop.client/edit'); ?>">
					    <?php echo token(); ?>	
						<table class="table table-striped">
							<thead>
								<tr>
									<th width="15%">配置项</th>
									<th width="85%">参数</th>
								</tr>
							</thead>
							<tbody>
								
								<tr>
									<td>微博appkey</td>
									<td>
										<div class="row">
											<div class="col-sm-8 col-xs-12">
												<?php echo Form::text('row[sdk_weibo][appkey]', $wanlshop['sdk_weibo']['appkey'], ['data-rule'=>'required','data-tip'=>'请填写微博appkey','placeholder'=>'请填写微博appkey']); ?>
											</div>
											<div class="col-sm-4"></div>
										</div>
									</td>
								</tr>
								<tr>
									<td>微博appsecret</td>
									<td>
										<div class="row">
											<div class="col-sm-8 col-xs-12">
												<?php echo Form::text('row[sdk_weibo][appsecret]', $wanlshop['sdk_weibo']['appsecret'], ['data-rule'=>'required','data-tip'=>'请填写微博appsecret','placeholder'=>'请填写微博appsecret']); ?>
											</div>
											<div class="col-sm-4"></div>
										</div>
									</td>
								</tr>
								<tr>
									<td>微博回调地址</td>
									<td>
										<div class="row">
											<div class="col-sm-8 col-xs-12">
												<?php echo Form::text('row[sdk_weibo][redirect_uri]', $wanlshop['sdk_weibo']['redirect_uri'], ['data-rule'=>'required','data-tip'=>'请填写微博回调地址','placeholder'=>'请填写微博回调地址']); ?>
											</div>
											<div class="col-sm-4"></div>
										</div>
									</td>
								</tr>
							
							</tbody>
							<tfoot>
								<tr>
									<th></th>
									<th>
										<button type="submit" class="btn btn-success btn-embossed"><?php echo __('更新'); ?></button>
										<a href="<?php echo url('wanlshop.client/download'); ?>" class="btn btn-default btn-embossed packing">生成源码</a>
										<button type="reset" class="btn btn-default btn-embossed">重置</button>
									</th>
								</tr>
							</tfoot>
						</table>
					</form>
				</div>
			</div>
		</div>
	</div>
</div>
<style type="text/css">
	@media (max-width: 375px) {
		.edit-form tr td input {
			width: 100%;
		}

		.edit-form tr th:first-child,
		.edit-form tr td:first-child {
			width: 20%;
		}

		.edit-form tr th:nth-last-of-type(-n+2),
		.edit-form tr td:nth-last-of-type(-n+2) {
			display: none;
		}
	}

	.edit-form table>tbody>tr td a.btn-delcfg {
		visibility: hidden;
	}

	.edit-form table>tbody>tr:hover td a.btn-delcfg {
		visibility: visible;
	}
</style>

                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <script src="/assets/js/require<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.js" data-main="/assets/js/require-backend<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.js?v=<?php echo htmlentities($site['version']); ?>"></script>
    </body>
</html>
