<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:89:"/www/wwwroot/www.fdadeal.com/public/../application/admin/view/wanlshop/client/config.html";i:1617983028;s:71:"/www/wwwroot/www.fdadeal.com/application/admin/view/layout/default.html";i:1608326192;s:68:"/www/wwwroot/www.fdadeal.com/application/admin/view/common/meta.html";i:1608326192;s:70:"/www/wwwroot/www.fdadeal.com/application/admin/view/common/script.html";i:1608326190;}*/ ?>
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
                                <div class="panel panel-default panel-intro">
	<div class="panel-heading">
		<div class="panel-lead"><em>系统设置</em>全局配置实时同步客户端，用户重启客户端后生效</div>
		<ul class="nav nav-tabs">
			<li class="active"><a href="#system" data-toggle="tab">系统配置</a></li>
			<li><a href="#withdraw" data-toggle="tab">提现配置</a></li>
			<li><a href="#order" data-toggle="tab">订单配置</a></li>
			<li><a href="#return" data-toggle="tab">退货配置</a></li>

			<li><a href="#find" data-toggle="tab">发现页管理</a></li>
			<li><a href="#live" data-toggle="tab">阿里直播</a></li>
			<li><a href="#im" data-toggle="tab">IM即时通讯</a></li>

			<li><a href="#kuaidi" data-toggle="tab">快递100推送</a></li>
		</ul>
	</div>
	<div class="panel-body">
		<div id="myTabContent" class="tab-content">
			<div class="tab-pane fade active in" id="system">
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
									<td>新店铺审核</td>
									<td>
										<div class="row">
											<div class="col-sm-8 col-xs-12">
												<?php echo Form::switcher('row[config][store_audit]', $wanlshop['config']['store_audit'], ['color'=>'success', 'yes'=>'Y', 'no'=>'N']); ?>
											</div>
											<div class="col-sm-4"></div>
										</div>
									</td>
								</tr>

								<tr>

									<td>是否启用评论</td>

									<td>

										<div class="row">

											<div class="col-sm-8 col-xs-12">

												<?php echo Form::switcher('row[config][comment_switch]', $wanlshop['config']['comment_switch'], ['color'=>'success', 'yes'=>'Y', 'no'=>'N']); ?>

											</div>

											<div class="col-sm-4"></div>

										</div>

									</td>

								</tr>
								<tr>
									<td>帮助中心类目CID</td>
									<td>
										<div class="row">
											<div class="col-sm-8 col-xs-12">
												<?php echo Form::text('row[config][help_category]', $wanlshop['config']['help_category'], ['data-rule'=>'required','data-tip'=>'请填写帮助中心类目ID','placeholder'=>'类目ID，客户端读取帮助中心类目列表']); ?>
											</div>
											<div class="col-sm-4"></div>
										</div>
									</td>
								</tr>
								<tr>
									<td>头条新闻类目CID</td>
									<td>
										<div class="row">
											<div class="col-sm-8 col-xs-12">
												<?php echo Form::text('row[config][new_category]', $wanlshop['config']['new_category'], ['data-rule'=>'required','data-tip'=>'请填写头条新闻类目ID','placeholder'=>'类目ID，客户端读取头条新闻类目列表']); ?>
											</div>
											<div class="col-sm-4"></div>
										</div>
									</td>
								</tr>
								<tr>
									<td>系统消息类目CID</td>
									<td>
										<div class="row">
											<div class="col-sm-8 col-xs-12">
												<?php echo Form::text('row[config][sys_category]', $wanlshop['config']['sys_category'], ['data-rule'=>'required','data-tip'=>'请填写系统消息类目ID','placeholder'=>'类目ID，客户端读取系统消息类目列表']); ?>
											</div>
											<div class="col-sm-4"></div>
										</div>
									</td>
								</tr>
								<tr>
									<td>用户协议文章ID</td>
									<td>
										<div class="row">
											<div class="col-sm-8 col-xs-12">
												<?php echo Form::text('row[config][user_agreement]', $wanlshop['config']['user_agreement'], ['data-rule'=>'required','data-tip'=>'请填写用户协议文章ID','placeholder'=>'用户协议的文章ID']); ?>
											</div>
											<div class="col-sm-4"></div>
										</div>
									</td>
								</tr>
								<tr>
									<td>隐私保护文章ID</td>
									<td>
										<div class="row">
											<div class="col-sm-8 col-xs-12">
												<?php echo Form::text('row[config][privacy_protection]', $wanlshop['config']['privacy_protection'], ['data-rule'=>'required','data-tip'=>'请填写隐私保护文章ID','placeholder'=>'隐私保护文章ID']); ?>
											</div>
											<div class="col-sm-4"></div>
										</div>
									</td>
								</tr>
								<tr>
									<td>客服电话</td>
									<td>
										<div class="row">
											<div class="col-sm-8 col-xs-12">
												<?php echo Form::text('row[config][tel_phone]', $wanlshop['config']['tel_phone'], ['data-rule'=>'required','data-tip'=>'请填写客服电话','placeholder'=>'电话、手机号']); ?>
											</div>
											<div class="col-sm-4"></div>
										</div>
									</td>
								</tr>
								<tr>
									<td>工作时间</td>
									<td>
										<div class="row">
											<div class="col-sm-8 col-xs-12">
												<?php echo Form::text('row[config][working_hours]', $wanlshop['config']['working_hours'], ['data-rule'=>'required','data-tip'=>'请填写工作时间','placeholder'=>'09:00~22:00']); ?>
											</div>
											<div class="col-sm-4"></div>
										</div>
									</td>
								</tr>
								<tr>
									<td>小程序ID</td>
									<td>
										<div class="row">
											<div class="col-sm-8 col-xs-12">
												<?php echo Form::text('row[config][mp_weixin_id]', $wanlshop['config']['mp_weixin_id'], ['data-rule'=>'required','data-tip'=>'请填写小程序推广ID','placeholder'=>'小程序ID']); ?>
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
										<button type="submit" class="btn btn-success btn-embossed">确定</button>
										<button type="reset" class="btn btn-default btn-embossed">重置</button>
									</th>
								</tr>
							</tfoot>
						</table>
					</form>
				</div>
			</div>
			<div class="tab-pane fade" id="withdraw">
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
									<td>是否开启提现</td>
									<td>
										<div class="row">
											<div class="col-sm-8 col-xs-12">
												<?php echo Form::switcher('row[withdraw][state]', $wanlshop['withdraw']['state'], ['color'=>'success', 'yes'=>'Y', 'no'=>'N']); ?>
											</div>
											<div class="col-sm-4"></div>
										</div>
									</td>
								</tr>
								<tr>
									<td>最低提现金额</td>
									<td>
										<div class="row">
											<div class="col-sm-8 col-xs-12">
												<?php echo Form::text('row[withdraw][minmoney]', $wanlshop['withdraw']['minmoney'], ['data-rule'=>'required','data-tip'=>'设置0则不限制提现金额','placeholder'=>'设置0则不限制提现金额']); ?>
											</div>
											<div class="col-sm-4"></div>
										</div>
									</td>
								</tr>
								<tr>
									<td>每月可提现次数</td>
									<td>
										<div class="row">
											<div class="col-sm-8 col-xs-12">
												<?php echo Form::text('row[withdraw][monthlimit]', $wanlshop['withdraw']['monthlimit'], ['data-rule'=>'required','data-tip'=>'每月可提现次数，设置0不限提现次数','placeholder'=>'每月可提现次数']); ?>
											</div>
											<div class="col-sm-4"></div>
										</div>
									</td>
								</tr>
								<tr>
									<td>提现手续费(‰)</td>
									<td>
										<div class="row">
											<div class="col-sm-8 col-xs-12">
												<?php echo Form::text('row[withdraw][servicefee]', $wanlshop['withdraw']['servicefee'], ['data-rule'=>'required','data-tip'=>'每笔提现扣除手续费千分之几？','placeholder'=>'手续费‰']); ?>
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
										<button type="submit" class="btn btn-success btn-embossed">确定</button>
										<button type="reset" class="btn btn-default btn-embossed">重置</button>
									</th>
								</tr>
							</tfoot>
						</table>
					</form>
				</div>
			</div>
			<div class="tab-pane fade" id="order">

				<div class="widget-body no-padding">

					<form id="chat-form" class="edit-form form-horizontal" role="form" data-toggle="validator" method="POST" action="<?php echo url('wanlshop.client/edit'); ?>">

					    <?php echo token(); ?>	

						<table class="table table-striped">

							<thead>

								<tr>

									<th width="15%">配置项</th>

									<th width="85%">参数（天）</th>

								</tr>

							</thead>

							<tbody>

								<tr>

									<td>取消未支付时间</td>

									<td>

										<div class="row">

											<div class="col-sm-8 col-xs-12">

												<?php echo Form::text('row[order][cancel]', $wanlshop['order']['cancel'], ['data-rule'=>'required','data-tip'=>'几天后取消未支付订单','placeholder'=>'订单下单未付款，n天后自动关闭，设置0天不自动关闭']); ?>

											</div>

											<div class="col-sm-4"></div>

										</div>

									</td>

								</tr>

								<tr>

									<td>自动收货时间</td>

									<td>

										<div class="row">

											<div class="col-sm-8 col-xs-12">

												<?php echo Form::text('row[order][receiving]', $wanlshop['order']['receiving'], ['data-rule'=>'required','data-tip'=>'订单提交后几天自动收货','placeholder'=>'如果在期间未确认收货，系统自动完成收货，设置0天不自动收货']); ?>

											</div>

											<div class="col-sm-4"></div>

										</div>

									</td>

								</tr>
								
								
							   <tr>

									<td>未发货，自动退款</td>

									<td>

										<div class="row">

											<div class="col-sm-8 col-xs-12">

<?php echo Form::text('row[order][wftuitime]', $wanlshop['order']['wftuitime'], ['data-rule'=>'required','data-tip'=>'超過未处理天数','placeholder'=>'卖家店铺有订单之后，超過未处理自动取消订单']); ?>

											</div>

											<div class="col-sm-4"></div>

										</div>

									</td>

								</tr>

								<tr>

									<td>自动评论时间</td>

									<td>

										<div class="row">

											<div class="col-sm-8 col-xs-12">

												<?php echo Form::text('row[order][comment]', $wanlshop['order']['comment'], ['data-rule'=>'required','data-tip'=>'收货后几天自动评论','placeholder'=>'如果在期间未自动评论，系统自动完成评论，设置0天不自动评论']); ?>

											</div>

											<div class="col-sm-4"></div>

										</div>

									</td>

								</tr>

								<tr>

									<td>最后售后时间</td>

									<td>

										<div class="row">

											<div class="col-sm-8 col-xs-12">

												<?php echo Form::text('row[order][customer]', $wanlshop['order']['customer'], ['data-rule'=>'required','data-tip'=>'几天内支持售后','placeholder'=>'订单完成后 ，用户在n天内可以发起售后申请，设置0天不允许申请售后']); ?>

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

										<button type="submit" class="btn btn-success btn-embossed">确定</button>

										<button type="reset" class="btn btn-default btn-embossed">重置</button>

									</th>

								</tr>

							</tfoot>

						</table>

					</form>

				</div>

			</div>

			<div class="tab-pane fade" id="return">

				<div class="widget-body no-padding">

					<form id="chat-form" class="edit-form form-horizontal" role="form" data-toggle="validator" method="POST" action="<?php echo url('wanlshop.client/edit'); ?>">

					    <?php echo token(); ?>	

						<table class="table table-striped">

							<thead>

								<tr>

									<th width="15%">配置项</th>

									<th width="85%">参数（天）</th>

								</tr>

							</thead>

							<tbody>

								<tr>

									<td>卖家自动同意时间</td>

									<td>

										<div class="row">

											<div class="col-sm-8 col-xs-12">

												<?php echo Form::text('row[order][autoagree]', $wanlshop['order']['autoagree'], ['data-rule'=>'required','data-tip'=>'自动同意售后时间','placeholder'=>'买家提交退款后商家处理时间，超出n天后自动同意，设置0天不自动关闭']); ?>

											</div>

											<div class="col-sm-4"></div>

										</div>

									</td>

								</tr>

								<tr>

									<td>买家退货时间</td>

									<td>

										<div class="row">

											<div class="col-sm-8 col-xs-12">

												<?php echo Form::text('row[order][returntime]', $wanlshop['order']['returntime'], ['data-rule'=>'required','data-tip'=>'卖家同意售后，退货时间','placeholder'=>'退货时间，如果超过则关闭售后']); ?>

											</div>

											<div class="col-sm-4"></div>

										</div>

									</td>

								</tr>

								<tr>

									<td>卖家收货时间</td>

									<td>

										<div class="row">

											<div class="col-sm-8 col-xs-12">

												<?php echo Form::text('row[order][receivingtime]', $wanlshop['order']['receivingtime'], ['data-rule'=>'required','data-tip'=>'买家退回商品，自动收货时间','placeholder'=>'买家退货后，超出指定天数后自动完成售后']); ?>

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

										<button type="submit" class="btn btn-success btn-embossed">确定</button>

										<button type="reset" class="btn btn-default btn-embossed">重置</button>

									</th>

								</tr>

							</tfoot>

						</table>

					</form>

				</div>

			</div>

			<div class="tab-pane fade" id="find">

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

									<td>APP发现页开启项</td>

									<td>

										<div class="row">

											<div class="col-sm-8 col-xs-12">

												 <?php echo Form::checkboxs('row[find][app_switch]', ['all'=>'关注', 'new'=>'上新', 'live'=>'直播', 'want'=>'种草', 'show'=>'买家秀'], $wanlshop['find']['app_switch']); ?>

											</div>

											<div class="col-sm-4"></div>

										</div>

									</td>

								</tr>

								<tr>

									<td>小程序发现页开启项</td>

									<td>

										<div class="row">

											<div class="col-sm-8 col-xs-12">

												 <?php echo Form::checkboxs('row[find][mp_switch]', ['all'=>'关注', 'new'=>'上新', 'live'=>'直播', 'want'=>'种草', 'show'=>'买家秀'], $wanlshop['find']['mp_switch']); ?>

											</div>

											<div class="col-sm-4"></div>

										</div>

									</td>

								</tr>

								<tr>

									<td>H5发现页开启项</td>

									<td>

										<div class="row">

											<div class="col-sm-8 col-xs-12">

												 <?php echo Form::checkboxs('row[find][h5_switch]', ['all'=>'关注', 'new'=>'上新', 'live'=>'直播', 'want'=>'种草', 'show'=>'买家秀'], $wanlshop['find']['h5_switch']); ?>

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

										<button type="submit" class="btn btn-success btn-embossed">确定</button>

										<button type="reset" class="btn btn-default btn-embossed">重置</button>

									</th>

								</tr>

							</tfoot>

						</table>

					</form>

				</div>

			</div>

			<div class="tab-pane fade" id="live">

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

									<td>播流域名</td>

									<td>

										<div class="row">

											<div class="col-sm-8 col-xs-12">

												<?php echo Form::text('row[live][liveDomain]', $wanlshop['live']['liveDomain'], ['data-rule'=>'required','data-tip'=>'播流域名','placeholder'=>'例如：live.wanlshop.com，不要添加http和/']); ?>

											</div>

											<div class="col-sm-4"></div>

										</div>

									</td>

								</tr>

								<tr>

									<td>播流KEY</td>

									<td>

										<div class="row">

											<div class="col-sm-8 col-xs-12">

												<?php echo Form::text('row[live][liveKey]', $wanlshop['live']['liveKey'], ['data-rule'=>'required','data-tip'=>'请在阿里云直播后台获取','placeholder'=>'例如：323We1sdf1']); ?>

											</div>

											<div class="col-sm-4"></div>

										</div>

									</td>

								</tr>

								<tr>

									<td>录制OSS域名</td>

									<td>

										<div class="row">

											<div class="col-sm-8 col-xs-12">

												<?php echo Form::text('row[live][liveCnd]', $wanlshop['live']['liveCnd'], ['data-rule'=>'required','data-tip'=>'请在阿里云OSS配置或使用OSS提供域名','placeholder'=>'例如：https://play.wanlshop.com']); ?>

											</div>

											<div class="col-sm-4"></div>

										</div>

									</td>

								</tr>

								<tr>

									<td>直播推流域名</td>

									<td>

										<div class="row">

											<div class="col-sm-8 col-xs-12">

												<?php echo Form::text('row[live][pushDomain]', $wanlshop['live']['pushDomain'], ['data-rule'=>'required','data-tip'=>'推流流域名','placeholder'=>'例如：rtmp.wanlshop.com，不要添加http和/']); ?>

											</div>

											<div class="col-sm-4"></div>

										</div>

									</td>

								</tr>

								<tr>

									<td>推流KEY</td>

									<td>

										<div class="row">

											<div class="col-sm-8 col-xs-12">

												<?php echo Form::text('row[live][pushKey]', $wanlshop['live']['pushKey'], ['data-rule'=>'required','data-tip'=>'请在阿里云直播后台获取','placeholder'=>'例如：323We1sdf1']); ?>

											</div>

											<div class="col-sm-4"></div>

										</div>

									</td>

								</tr>

								<tr>

									<td>鉴权有效分钟</td>

									<td>

										<div class="row">

											<div class="col-sm-8 col-xs-12">

												<?php echo Form::text('row[live][builderTime]', $wanlshop['live']['builderTime'], ['data-rule'=>'required','data-tip'=>'请输入分钟数，推荐60分钟最多360分钟','placeholder'=>'例如：60']); ?>

											</div>

											<div class="col-sm-4"></div>

										</div>

									</td>

								</tr>

								<tr>

									<td>AppName</td>

									<td>

										<div class="row">

											<div class="col-sm-8 col-xs-12">

												<?php echo Form::text('row[live][appName]', $wanlshop['live']['appName'], ['data-rule'=>'required','data-tip'=>'具体请看文档','placeholder'=>'例如：wanlshop']); ?>

											</div>

											<div class="col-sm-4"></div>

										</div>

									</td>

								</tr>

								<tr>

									<td>转码模板</td>

									<td>

										<div class="row">

											<div class="col-sm-8 col-xs-12">

												<?php echo Form::text('row[live][transTemplate]', $wanlshop['live']['transTemplate'], ['data-rule'=>'required','data-tip'=>'请填写模板英文名','placeholder'=>'例如：lld，为选择标清播放']); ?>

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

										<button type="submit" class="btn btn-success btn-embossed">确定</button>

										<button type="reset" class="btn btn-default btn-embossed">重置</button>

									</th>

								</tr>

							</tfoot>

						</table>

					</form>

				</div>

			</div>

			<div class="tab-pane fade" id="im">
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
									<td>客服初始消息</td>
									<td>
										<div class="row">
											<div class="col-sm-8 col-xs-12">
												<?php echo Form::text('row[config][auth_reply]', $wanlshop['config']['auth_reply'], ['data-rule'=>'required','data-tip'=>'请填写客服初始消息','placeholder'=>'例如：欢迎使用在线客服']); ?>
											</div>
											<div class="col-sm-4"></div>
										</div>
									</td>
								</tr>
								<tr>
									<td>人工未在线</td>
									<td>
										<div class="row">
											<div class="col-sm-8 col-xs-12">
												<?php echo Form::text('row[config][not_online]', $wanlshop['config']['not_online'], ['data-rule'=>'required','data-tip'=>'请填写人工未在线','placeholder'=>'例如：[汗] 非工作时间8:00-22:00 或客服繁忙！请稍后再试~']); ?>
											</div>
											<div class="col-sm-4"></div>
										</div>
									</td>
								</tr>
								<tr>
									<td>客服首消息</td>
									<td>
										<div class="row">
											<div class="col-sm-8 col-xs-12">
												<?php echo Form::text('row[config][service_initial]', $wanlshop['config']['service_initial'], ['data-rule'=>'required','data-tip'=>'请填写客服首消息','placeholder'=>'例如：您好 [微笑] 请用一句话简短描述问题~']); ?>
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
										<button type="submit" class="btn btn-success btn-embossed">确定</button>
										<button type="reset" class="btn btn-default btn-embossed">重置</button>
									</th>
								</tr>
							</tfoot>
						</table>
					</form>
				</div>
			</div>
			<div class="tab-pane fade" id="kuaidi">

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

									<td>快递100 Key</td>

									<td>

										<div class="row">

											<div class="col-sm-8 col-xs-12">

												<?php echo Form::text('row[kuaidi][secretKey]', $wanlshop['kuaidi']['secretKey'], ['data-rule'=>'required','data-tip'=>'请填写快递100 Key','placeholder'=>'请填写快递100 Key']); ?>

											</div>

											<div class="col-sm-4"></div>

										</div>

									</td>

								</tr>

								<tr>

									<td>回调地址</td>

									<td>

										<div class="row">

											<div class="col-sm-8 col-xs-12">

												<?php echo Form::text('row[kuaidi][callbackUrl]', $wanlshop['kuaidi']['callbackUrl'], ['data-rule'=>'required','data-tip'=>'请填写回调地址','placeholder'=>'请填写回调地址']); ?>

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

										<button type="submit" class="btn btn-success btn-embossed">确定</button>

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
