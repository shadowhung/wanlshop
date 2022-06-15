<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:87:"/www/wwwroot/www.fdadeal.com/public/../application/index/view/wanlshop/entry/index.html";i:1654875677;s:71:"/www/wwwroot/www.fdadeal.com/application/index/view/layout/default.html";i:1654875635;s:68:"/www/wwwroot/www.fdadeal.com/application/index/view/common/meta.html";i:1608355012;s:70:"/www/wwwroot/www.fdadeal.com/application/index/view/common/script.html";i:1612489358;}*/ ?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8">
<title><?php echo (isset($title) && ($title !== '')?$title:''); ?> – <?php echo $site['name']; ?></title>
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">
<meta name="renderer" content="webkit">

<?php if(isset($keywords)): ?>
<meta name="keywords" content="<?php echo $keywords; ?>">
<?php endif; if(isset($description)): ?>
<meta name="description" content="<?php echo $description; ?>">
<?php endif; ?>

<link rel="shortcut icon" href="/assets/img/favicon.ico" />

<link href="/assets/css/frontend<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.css?v=<?php echo \think\Config::get('site.version'); ?>" rel="stylesheet">

<!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->
<!--[if lt IE 9]>
  <script src="/assets/js/html5shiv.js"></script>
  <script src="/assets/js/respond.min.js"></script>
<![endif]-->
<script type="text/javascript">
    var require = {
        config: <?php echo json_encode($config); ?>
    };
</script>
        <link href="/assets/css/user.css?v=<?php echo \think\Config::get('site.version'); ?>" rel="stylesheet">
    </head>

    <body>

        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <div class="container">
                <div class="navbar-header">
                    <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#header-navbar">
                        <span class="sr-only">Toggle navigation</span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                        <span class="icon-bar"></span>
                    </button>
                    <!--<?php echo url('/'); ?>-->
                    <a class="navbar-brand" href="<?php echo url('/index/'); ?>"><?php echo $site['name']; ?></a>
                </div>
                <div class="collapse navbar-collapse" id="header-navbar">
                    <ul class="nav navbar-nav navbar-right">
                        <li><a href="<?php echo url('/index/'); ?>"><?php echo __('Home'); ?></a></li>
                        <li class="dropdown">
                            <?php if($user): ?>
                            <a href="<?php echo url('user/index'); ?>" class="dropdown-toggle" data-toggle="dropdown" style="padding-top: 10px;height: 50px;">
                                <span class="avatar-img"><img src="<?php echo cdnurl($user['avatar']); ?>" alt=""></span>
                            </a>
                            <?php else: ?>
                            <a href="<?php echo url('user/index'); ?>" class="dropdown-toggle" data-toggle="dropdown"><?php echo __('User center'); ?> <b class="caret"></b></a>
                            <?php endif; ?>
                            <ul class="dropdown-menu">
                                <?php if($user): ?>
                                <li><a href="<?php echo url('user/index'); ?>"><i class="fa fa-user-circle fa-fw"></i><?php echo __('User center'); ?></a></li>
                                <li><a href="<?php echo url('user/profile'); ?>"><i class="fa fa-user-o fa-fw"></i><?php echo __('Profile'); ?></a></li>
                                <li><a href="<?php echo url('user/changepwd'); ?>"><i class="fa fa-key fa-fw"></i><?php echo __('Change password'); ?></a></li>
                                <li><a href="<?php echo url('user/logout'); ?>"><i class="fa fa-sign-out fa-fw"></i><?php echo __('Sign out'); ?></a></li>
                                <?php else: ?>
                                <li><a href="<?php echo url('user/login'); ?>"><i class="fa fa-sign-in fa-fw"></i> <?php echo __('Sign in'); ?></a></li>
                                <li><a href="<?php echo url('user/register'); ?>"><i class="fa fa-user-o fa-fw"></i> <?php echo __('Sign up'); ?></a></li>
                                <?php endif; ?>

                            </ul>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>

        <main class="content" style="overflow-x: hidden;overflow-y: auto;height: 100%;">
            <link rel="stylesheet" href="/assets/addons/wanlshop/css/entry.css">

<div id="content-container" class="container">

	<div class="row" id="app" v-cloak>

		<form class="form-horizontal" role="form" data-toggle="validator" method="POST">

			<div class="wanl-entry col-md-12">

				<div class="head">

					<div class="title">

						<p>ストアアプリケーション</p>

					</div>

					<div class="entry-content">

						<ol class="ui-step ui-step-4">

							<li class="step-start step-done">

								<div class="ui-step-line"></div>

								<div class="ui-step-cont">

									<span class="ui-step-cont-number">1</span>

									<span class="ui-step-cont-text">アカウント登録</span>

								</div>

							</li>

							<li class="step-active">

								<div class="ui-step-line"></div>

								<div class="ui-step-cont">

									<span class="ui-step-cont-number">2</span>

									<span class="ui-step-cont-text">対象資格</span>

								</div>

							</li>

							<li class="step-start">

								<div class="ui-step-line"></div>

								<div class="ui-step-cont">

									<span class="ui-step-cont-number">3</span>

									<span class="ui-step-cont-text">店舗情報</span>

								</div>

							</li>

							<li class="step-end">

								<div class="ui-step-line"></div>

								<div class="ui-step-cont">

									<span class="ui-step-cont-number">4</span>

									<span class="ui-step-cont-text">監査のために提出する</span>

								</div>

							</li>

						</ol>

						

					</div>

				</div>

				<div>

					<div class="title-container">

						<span class="title">資格認定</span>

					</div>

					<div class="entry-content">

						<div class="form-group" style="display: none;">

							<label class="control-label col-xs-12 col-sm-2"><?php echo __('店舗タイプ'); ?>:</label>

							<div class="col-xs-12 col-sm-8">

								<div class="radio">

									<label for="state-0"><input id="state-0" name="state" type="radio" value="0" v-model="state"> 個人</label> 

									<!--<label for="state-1"><input id="state-1" name="state" type="radio" value="1" v-model="state"> 企业</label> 

									<label for="state-2"><input id="state-2" name="state" type="radio" value="2" v-model="state"> 旗舰店</label>-->

								</div>

							</div>

						</div>

						<div class="form-group">

							<label class="control-label col-xs-12 col-sm-2"><span id="t-name">氏名</span>:</label>

							<div class="col-xs-12 col-sm-8">

								<?php echo Form::text('name', $entry['name'], ['data-rule'=>'required']); ?>

							</div>

						</div>

						<!--<div class="form-group">

							<label class="control-label col-xs-12 col-sm-2"><span id="t-identify">ID番号{{getNumber(state)}}</span>:</label>

							<div class="col-xs-12 col-sm-8">

								<?php echo Form::text('number', $entry['number'], ['data-rule'=>'required']); ?>

							</div>

						</div>-->

						

						<!--<div class="form-group">

						    <label class="control-label col-xs-12 col-sm-2"><span id="t-image">{{getImage(state)}}</span>:</label>

						    <div class="col-xs-12 col-sm-8">

						        <div class="input-group">

						            <input id="c-image" data-rule="required" class="form-control" size="50" name="image" type="text" value="<?php echo $entry['image']; ?>">

						            <div class="input-group-addon no-border no-padding">

						                <span><button type="button" id="plupload-image" class="btn btn-danger plupload" data-input-id="c-image" data-mimetype="image/gif,image/jpeg,image/png,image/jpg,image/bmp" data-multiple="false" data-preview-id="p-image"><i class="fa fa-upload"></i> <?php echo __('Upload'); ?></button></span>

						            </div>

						            <span class="msg-box n-right" for="c-image"></span>

						        </div>

						        <ul class="row list-inline plupload-preview" id="p-image"></ul>

						    </div>

						</div>-->

						<div class="form-group" v-show="state == 2">

							<label class="control-label col-xs-12 col-sm-2"><?php echo __('商標証明書'); ?>:</label>

							<div class="col-xs-12 col-sm-8">

							    <div class="input-group">

							        <input id="c-trademark"  class="form-control" size="50" name="trademark" type="text" value="<?php echo $entry['trademark']; ?>">

							        <div class="input-group-addon no-border no-padding">

							            <span><button type="button" id="plupload-trademark" class="btn btn-danger plupload" data-input-id="c-trademark" data-mimetype="image/gif,image/jpeg,image/png,image/jpg,image/bmp" data-multiple="false" data-preview-id="p-trademark"><i class="fa fa-upload"></i> <?php echo __('Upload'); ?></button></span>

							        </div>

							        <span class="msg-box n-right" for="c-trademark"></span>

							    </div>

							    <ul class="row list-inline plupload-preview" id="p-trademark"></ul>

							</div>

						</div>

						

						

						<div class="form-group">

							<label class="control-label col-xs-12 col-sm-2">Line:</label>

							<div class="col-xs-12 col-sm-8">

								<?php echo Form::text('wechat', $entry['wechat'], ['data-rule'=>'required']); ?>

							</div>

						</div>

						<div class="form-group">

							<label class="control-label col-xs-12 col-sm-2">招待はを積み重ねて:</label>

							<div class="col-xs-12 col-sm-8">

								<?php echo Form::text('invitation', 88888888, ['data-rule'=>'required']); ?>

							</div>

						</div>

						<?php if($mobile == ''): ?>

						<div class="form-group">

							<label class="control-label col-xs-12 col-sm-2"><?php echo __('携帯番号'); ?>:</label>

							<div class="col-xs-12 col-sm-8">

								<!-- 判断是否存在手机号？ -->

								<?php echo Form::text('mobile', $entry['mobile'], ['data-rule'=>'required']); ?>

							</div>

						</div>

						<?php else: ?>

						<div class="form-group">

							<label class="control-label col-xs-12 col-sm-2"><?php echo __('携帯番号'); ?>:</label>

							<div class="col-xs-12 col-sm-8">

								<!-- 判断是否存在手机号？ -->

								<input type="text" class="form-control" id="mobile" name="mobile" value="<?php echo $mobile; ?>" readonly="" placeholder="">

							</div>

						</div>

						<?php endif; ?>

					</div>

				</div>

				<div align="center">

					<div class="entry-content">

						<button type="submit" class="btn btn-success btn-lg">次のステップ</button>

					</div>

				</div>

			</div>

		</form>

	</div>

</div>


        </main>

        <footer class="footer" style="clear:both">
            <p class="copyright">Copyright&nbsp;©&nbsp;2017-2020 <?php echo $site['name']; ?> All Rights Reserved <a href="http://www.beian.miit.gov.cn" target="_blank"><?php echo htmlentities($site['beian']); ?></a></p>
        </footer>

        <script src="/assets/js/require<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.js" data-main="/assets/js/require-frontend<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.js?v=<?php echo htmlentities($site['version']); ?>"></script>

    </body>

</html>