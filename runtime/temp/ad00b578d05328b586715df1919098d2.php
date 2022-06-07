<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:85:"/www/wwwroot/www.fdadeal.com/public/../application/index/view/wanlshop/page/edit.html";i:1635785896;s:72:"/www/wwwroot/www.fdadeal.com/application/index/view/layout/wanlshop.html";i:1636510733;}*/ ?>
<!DOCTYPE html>

<html lang="<?php echo $config['language']; ?>">

	<head>

		<meta charset="utf-8">

		<title><?php echo (isset($title) && ($title !== '')?$title:'売り手コンソール'); ?></title>

		<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no">

		<meta name="renderer" content="webkit">

		<meta name="author" content="FastAdmin">

		<link rel="shortcut icon" href="/assets/img/favicon.ico" />

		<link href="/assets/css/backend<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.css?v=<?php echo \think\Config::get('site.version'); ?>" rel="stylesheet">

		<link rel="stylesheet" href="/assets/css/skins/skin-red-light.css" type="text/css">

		<link rel="stylesheet" href="/assets/addons/wanlshop/css/chat.css" type="text/css">

		<!-- HTML5 shim, for IE6-8 support of HTML5 elements. All other JS at the end of file. -->

		<!--[if lt IE 9]>

		  <script src="/assets/js/html5shiv.js"></script>

		  <script src="/assets/js/respond.min.js"></script>

		<![endif]-->

		<script type="text/javascript">

			var require = {config: <?php echo json_encode($config ); ?>};

		</script>

		<style type="text/css">

			@media (max-width: 767px) {

				.fixed .content-wrapper,

				.fixed .right-side {

					padding-top: 50px;

				}

			}

			#main {

				height: 100%;

				background: #f1f4f6;

				overflow-x: hidden;

				overflow-y: auto;

			}

			.skin-red-light .treeview-menu>li.active>a {

				color: #e74c3c;

			}

			[v-cloak] {

				display: none !important;

			}

			.text-cut {

				overflow: hidden;

				white-space: nowrap;

				text-overflow: ellipsis;

			}

			/* 修改默認樣式 */

			.bootstrap-table .table:not(.table-condensed),

			.bootstrap-table .table:not(.table-condensed)>tbody>tr>td,

			.bootstrap-table .table:not(.table-condensed)>tbody>tr>th,

			.bootstrap-table .table:not(.table-condensed)>tfoot>tr>td,

			.bootstrap-table .table:not(.table-condensed)>tfoot>tr>th,

			.bootstrap-table .table:not(.table-condensed)>thead>tr>td {

				padding: 10px 8px;

			}

		</style>

	</head>



	<?php if(!IS_DIALOG): ?>

	<!-- <body class="skin-green sidebar-mini fixed" id="tabs"> -->

	<body class="sidebar-mini fixed skin-red-light <?php if($config['controllername'].$config['actionname']=='wanlshop.consoleindex'){;?>sidebar-open<?php }?>" id="tabs">

		<div class="wrapper">

			<div id="wanlchat">

				<!-- 頭部區域 -->

				<header id="header" class="main-header">

					<a href="javascript:;" class="logo">

						<!-- 迷妳模式下Logo的大小為50X50 -->

						<span class="logo-mini">商人</span>

						<!-- 普通模式下Logo -->

						<span class="logo-lg">売り手センター</span>

					</a>

					<!-- 頂部通欄樣式 -->

					<nav class="navbar navbar-static-top">

						<!--第壹級菜單-->

						<div id="firstnav">

							<a href="#" class="sidebar-toggle" data-toggle="offcanvas" role="button">

								<span class="sr-only"><?php echo __('Toggle navigation'); ?></span><!-- 邊欄切換按鈕-->

							</a>
							<?php $agent = strtolower($_SERVER['HTTP_USER_AGENT']);$is_iphone = (strpos($agent, 'iphone')) ? true : false; if($is_iphone){?>
                            <a href="javascript:history.back(-1)" style="position: absolute;width: 45px;text-align: center;height: 50px;line-height: 50px;padding: 4px;left: 50px;color: white;"><i class="fa fa fa-angle-left" style="font-size:20px;"></i></a> 
                            <?php }?>

							<div class="navbar-custom-menu">

								<ul class="nav navbar-nav">
								    
								    <!--<?php echo url('index/wanlshop.console/index'); ?>-->

									<li class="dropdown">

										<a href="#" class="dropdown-toggle" data-toggle="dropdown">

											<i class="fa fa-paper-plane margin-r-5"></i>

										</a>

										<ul class="dropdown-menu wipecache">

											<li><a href="<?php echo url('index/wanlshop.goods/add'); ?>"><i class="fa fa-circle-o"></i> 商品を公開する</a></li>

											<li class="divider"></li>

											<li><a href="javascript:;" @click="toFind('new')"><i class="fa fa-circle-o"></i> 新製品を投稿する</a></li>

											<!--<li><a href="javascript:;" @click="toFind('want')"><i class="fa fa-circle-o"></i> 發佈種草</a></li>-->

											<li><a href="javascript:;" @click="toFind('show')"><i class="fa fa-circle-o"></i> ポストバイヤーショー</a></li>

										</ul>

									</li>

									<!-- 即時通訊  open-->

									<li class="dropdown messages-menu" v-cloak>

										<a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-expanded="true">

											<i class="fa fa-comments margin-r-5"></i>

											<span class="label label-success" v-if="count > 0">{{count}}</span>

										</a>

										<div class="dropdown-menu wanl-chat-list">

											<div class="head">

												<div class="title">

													<div>

														<h3>{{shop.shopname}}</h3>

														<span v-if="shopOnline == 1"><i class="fa fa-circle text-success margin-r-5"></i> H5オンライン</span>

														<span v-else><i class="fa fa-circle text-gray margin-r-5"></i> IM接続異常</span>

													</div>

													<div style="font-size: 14px;">

														<span class="active" @click="onAudio" v-if="isAudio"><i class="fa fa-volume-up text-red"></i></span> 

														<span v-else @click="onAudio"><i class="fa fa-volume-off text-gray"></i></span>

													</div>

												</div>

											</div>

											<div class="list">

												<div class="empty" v-if="chatlist.length == 0">

													<div class="main">

														<img src="/assets/addons/wanlshop/img/default/find_default3x.png">

														<p>連絡先が見つかりませんでした</p>

													</div>

												</div>

												<div class="item" v-for="(item, index) in chatlist" :key="index" @click="otChat(index, 'main')">

													<div class="portrait">

														<img :src="cdnurl(item.avatar)"> 

														<span class="online">

															<i class="fa fa-circle text-success" v-if="item.isOnline == 1"></i>

															<i class="fa fa-circle text-gray" v-else></i>

														</span>

													</div>

													<div class="main">

														<div class="user">

															<span class="username text-cut">{{item.nickname}}</span>

															<span class="time">{{timefriendly(item.createtime)}}</span>

														</div>

														<div class="info text-cut">

															<span v-if="item.count > 0">

																[未読{{item.count}}論文]

															</span> 

															<span v-html="item.content"></span>

														</div>

													</div>

												</div>

											</div>

										</div>

									</li>
				                    <li> <a href="<?php echo url('/index/'); ?>"><i class="fa fa-home" style="font-size:20px;"></i></a> </li>
									<!-- 賬號信息下拉框 -->

									<li class="dropdown user user-menu">

										<a href="#" class="dropdown-toggle" data-toggle="dropdown">

											<img src="<?php echo htmlentities(cdnurl($user['avatar'])); ?>" class="user-image" alt="<?php echo $user['username']; ?>">

											<span class="hidden-xs"><?php echo htmlentities($user['username']); ?></span>

										</a>

										<ul class="dropdown-menu">

											<!-- User image -->

											<li class="user-header">

												<img src="<?php echo htmlentities(cdnurl($user['avatar'])); ?>" class="img-circle" alt="<?php echo $user['username']; ?>">

												<p>

													<?php echo htmlentities($user['username']); ?>

													<small><?php echo date("Y-m-d H:i:s",$user['logintime']); ?></small>

												</p>

											</li>

											<!-- Menu Body -->

											<li class="user-body">

												<div class="row">

													<div class="col-xs-4 text-center">残高：<?php echo htmlentities($user['money']); ?></div>

													<div class="col-xs-4 text-center">積分：<?php echo htmlentities($user['score']); ?></div>

													<div class="col-xs-4 text-center">ログインする<?php echo htmlentities($user['successions']); ?>次</div>

												</div>

											</li>

											<!-- Menu Footer-->

											<li class="user-footer">

												

												<div class="pull-left" style="margin-left: 10px;">

													<a href="<?php echo url('index/wanlshop.shop/profile'); ?>" class="btn btn-primary"><i class="fa fa-user"></i>

														<?php echo __('店舗情報'); ?></a>

												</div>

												<div class="pull-right">

													<a href="<?php echo url('index/user/logout'); ?>" class="btn btn-danger"><i class="fa fa-sign-out"></i> <?php echo __('Logout'); ?></a>

												</div>

											</li>

										</ul>

									</li>

								</ul>

							</div>

						</div>

					</nav>

				</header>

				

				

				

				

				<!-- 聊天窗口 -->

				<div class="wanl-chat" :class="{full: onFull}" :style="{left:screenWidth+'px', top:screenHeight+'px'}" ref="moveBtn" v-show="chatWindow" v-cloak>

					<div class="list">

						<ul>

							<li v-for="(item, index) in wanlchat" :key="index" :class="{checked: chatSelect == index}" @click="onChat(index)">

								<div class="portrait">

									<img :src="cdnurl(item.avatar)">

									<span class="badge bg-red" v-if="item.count > 0">{{item.count}}</span>

								</div>

								<div class="user-msg">

									<p>{{item.nickname}}</p>

									<div class="text-cut" v-html="item.content"></div>

								</div>

								<div class="list-close" @click.stop="delChat(index)">

									<div class="hover">

										<span class="fa fa-times-circle"></span>

									</div>

								</div>

							</li>

						</ul>

					</div>

					

					<div class="main" v-if="chatSelect != null">

						<div class="msgHead" @mousedown="down" @touchstart="down" @mousemove="move" @touchmove="move" @mouseup="end" @touchend="end" @touchcancel="end">

							<img :src="cdnurl(wanlchat[chatSelect].avatar)">

							<div>

								<span class="name">{{wanlchat[chatSelect].nickname}}</span>

								<p v-if="wanlchat[chatSelect].isOnline == 1"><i class="fa fa-circle text-success"></i> オンライン</p>

								<p v-else><i class="fa fa-circle text-gray"></i> オフライン</p>

							</div>

							<!-- 窗口操作 -->

							<span class="layui-layer-setwin">

								<block v-if="onFull">

									<a class="layui-layer-ico layui-layer-max layui-layer-maxmin" href="javascript:;" @click="full"></a>

								</block>

								<block v-else>

									<a class="layui-layer-min" href="javascript:;" @click="miniChat"><cite></cite></a>

									<a class="layui-layer-ico layui-layer-max" href="javascript:;" @click="full"></a>

								</block>

								<a class="layui-layer-ico layui-layer-close layui-layer-close1" href="javascript:;" @click="closeChat"></a>

							</span>

						</div>

						

						<div class="msgList" id="talk">

							<ul>

								<li :class="{my: item.form.id == shop.user_id}" v-for="(item, index) in chatContent" :key="index">

									<div class="chat-user">

										<img :src="cdnurl(item.form.id == shop.user_id ? shop.avatar : item.form.avatar)">

										<cite>

											<span>{{timefriendly(item.createtime)}}</span>

										</cite>

									</div>

									<!-- 文字消息 -->

									<div class="chat-text" v-if="item.message.type == 'text'" v-html="item.message.content.text"></div>

									<!-- 語音消息 -->

									<div class="chat-voice" v-if="item.message.type == 'voice'" @click="playVoice(item.message.content.url)">

										<span :style="{marginRight: item.message.content.length * 8 +'px'}"></span>{{item.message.content.length}} ”

									</div>

									<!-- 圖片消息 -->

									<div class="chat-img" v-if="item.message.type == 'img'">

										<a :href="item.message.content.url" target="_blank"><img :src="cdnurl(item.message.content.url)" data-tips-image></a>

									</div>

									<!-- 商品消息 -->

									<div class="chat-goods" v-if="item.message.type == 'goods'">

										<img :src="cdnurl(item.message.content.image)">

										<div class="price text-orange">

											￥ <span>{{item.message.content.price}}</span>

										</div>

										<div class="title">

											{{item.message.content.title}}

										</div>

									</div>

									<!-- 訂單消息 -->

									<div class="chat-order" v-if="item.message.type == 'order'" @click="onOrder(item.message.content.id)">

										<div> 注文詳細：</div>

										<div class="product">

											<div class="item" v-for="(order, index) in item.message.content.goods" :key="index">

												<img :src="cdnurl(order.image)"></img>

												<div class="details">

													<div>

														<span>{{order.title}}</span>

													</div>

													<div class="attribute">

														<div class="text-orange">

															￥ {{order.price * order.number}}

														</div>

														<div>

															<span>{{order.difference}} x {{order.number}}</span>

															<span v-if="item.refund_status > 0">({{refundStatusText[item.refund_status]}})</span>

														</div>

													</div>

												</div>

											</div>

										</div>

										<div class="describe">

											<div> <span>{{stateText[item.message.content.state-1]}}</span> </div>

											<div> <span>ID：</span> <span>{{item.message.content.order_no}}</span> </div>

										</div>

									</div>

								</li>

							</ul>

						</div>

						<form class="inputBox" id="form">

							<div class="tool">

								<span class="fa fa-smile-o" @click="toggleBox"></span>

								<label for="upImage" class="fa fa-picture-o upImage"></label>

								<input type="file" id="upImage" @change="chatImage" style="display:none">

							</div>

							<div class="input">

								<textarea id="content" placeholder="メッセージを入力してください" v-model="textarea" @keyup.ctrl.enter="submit" autofocus></textarea>

							</div>

							<div class="operation">

								<button type="button" class="btn btn-danger" @click="submit">送信 Ctrl+Enter</button>

							</div>

						</form>

						<div class="box-container" v-if="showBox" @click.self="toggleBox"> </div>

						<div class="wanl-emoji" v-if="showBox">

							<div class="title">

								<div> {{TabCur}} </div>

							</div>

							<div class="subject" v-for="(emoji, groups) in emojiList.groups" :key="groups" v-if="TabCur == groups">

								<div class="item">

									<span v-for="(item, index) in emoji" :key="index" @click="addEmoji(item.value)">

										<img :src="item.url" >

									</span>

								</div>

							</div>

							<div class="emojiNav">

								<div :class="item == TabCur ? 'emojibg' : ''" class="item" v-for="(item, index) in emojiList.categories" :key="index" :data-id="item" @click="tabSelect" >

									<img :src="emojiList.groups[item][0].url" >

								</div>

							</div>

						</div>

					</div>

				</div>

				<!-- 客服按鈕 -->

				<div class="wanl-chat-mini-button" v-if="chatMiniWindow" @click="miniChat" v-cloak></div>

				<aside class="main-sidebar">

					<!-- 左側菜單欄 -->

					<div class="slimScrollDiv" style="position: relative; overflow: hidden; width: auto; height: 897px;">

						<section class="sidebar" style="height: 897px; overflow: hidden; width: auto;">

							<!-- 管理員信息 -->

							<div class="user-panel hidden-xs">

								<div class="pull-left image">

									<a href="<?php echo url('index/wanlshop.shop/profile'); ?>"><img src="<?php echo htmlentities(cdnurl($shop['avatar'])); ?>" class="img-circle"></a>

								</div>

								<div class="pull-left info">

									<p><?php echo $shop['shopname']; ?></p>

									<div v-cloak>

										<span v-if="shopOnline == 1"><i class="fa fa-circle text-success margin-r-5"></i> 私はオンラインです</span>

										<span v-else><i class="fa fa-circle text-gray margin-r-5"></i> IM接続異常</span>

									</div>

								</div>

							</div>

							<!-- 菜單搜索 -->

							<form action="" method="get" class="sidebar-form" onsubmit="return false;">

								<div class="input-group">

									<input type="text" name="q" class="form-control" placeholder="蒐索選單">

									<span class="input-group-btn">

										<button type="submit" name="search" id="search-btn" class="btn btn-flat"><i class="fa fa-search"></i>

										</button>

									</span>

									<div class="menuresult list-group sidebar-form hide" style="width: 210px;">

									</div>

								</div>

							</form>

							<!-- 移動端壹級菜單 -->

							<div class="mobilenav visible-xs"> </div>

							<!--如果想始終顯示子菜單,則給ul加上show-submenu類即可,當multiplenav開啟的情況下默認為展開-->

							<ul class="sidebar-menu ">

								<li class="treeview <?php echo in_array($config['controllername'],['wanlshop.console'])?'active':''; ?>">

									<a href="<?php echo url('index/wanlshop.console/index'); ?>">

										<i class="fa fa-dashboard fa-fw"></i> <span>コンソール</span>

										<span class="pull-right-container"><small class="label pull-right bg-blue">hot</small></span>

									</a>

								</li>
								
								<li class="treeview <?php echo in_array($config['controllername'].'.'.$config['actionname'],['wanlshop.user.index','wanlshop.user.profile','wanlshop.user.changepwd'])?'active':''; ?>">

									<a href="javascript:;">

										<i class="fa fa-user"></i> <span>個人情報</span>

										<span class="pull-right-container"><i class="fa fa-angle-left"></i></span>

									</a>

									<ul class="treeview-menu <?php echo in_array($config['controllername'].'.'.$config['actionname'],['wanlshop.user.index','wanlshop.user.profile','wanlshop.user.changepwd'])?'menu-open':''; ?>"

									 style="display: <?php echo in_array($config['controllername'].'.'.$config['actionname'],['wanlshop.user.index','wanlshop.user.profile','wanlshop.user.changepwd'])?'block':'none'; ?>;">

										<li class="<?php echo $config['controllername'].'.'.$config['actionname']=='wanlshop.user.index'?'active':''; ?>">

											<a href="<?php echo url('index/wanlshop.user/index'); ?>">

												<i class="fa fa-circle-o fa-fw"></i><span>メンバーセンター</span>

											</a>

										</li>

										<!--<li class="<?php echo $config['controllername'].'.'.$config['actionname']=='wanlshop.user.profile'?'active':''; ?>">

											<a href="<?php echo url('index/wanlshop.user/profile'); ?>">

												<i class="fa fa-circle-o fa-fw"></i><span>個人資料</span>

											</a>

										</li>-->
										<li class="<?php echo $config['controllername'].'.'.$config['actionname']=='wanlshop.user.changepwd2'?'active':''; ?>">

											<a href="<?php echo url('index/wanlshop.user/changepwd2'); ?>">

												<i class="fa fa-circle-o fa-fw"></i><span>支払いパスワードを変更する</span>

											</a>

										</li>

										<li class="<?php echo $config['controllername'].'.'.$config['actionname']=='wanlshop.user.changepwd'?'active':''; ?>">

											<a href="<?php echo url('index/wanlshop.user/changepwd'); ?>">

												<i class="fa fa-circle-o fa-fw"></i><span>パスワードを変更する</span>

											</a>

										</li>

									</ul>

								</li>
								
								<!--<li>

									<a href="/pages/user/money/money1?userid=<?php echo $user['id']; ?>">

										<i class="fa fa-money"></i> <span>モールウォレット</span>

										<span class="pull-right-container"></span>

									</a>

								</li>-->
								
								<li>

									<a href="<?php echo url('index/wanlshop.shop/invitation'); ?>">

										<i class="fa fa-wpforms"></i> <span>お友達招待</span>

										<span class="pull-right-container"></span>

									</a>

								</li>

								<li class="treeview <?php echo in_array($config['controllername'],['wanlshop.order','wanlshop.refund'])?'active':''; ?>">

									<a href="javascript:;">

										<i class="fa fa-leaf fa-fw"></i> <span>トランザクション管理</span>

										<span class="pull-right-container"><i class="fa fa-angle-left"></i></span>

									</a>

									<ul class="treeview-menu <?php echo in_array($config['controllername'],['wanlshop.order','wanlshop.refund'])?'menu-open':''; ?>"

									 style="display: <?php echo in_array($config['controllername'],['wanlshop.order','wanlshop.refund'])?'block':'none'; ?>;">

										<li class="<?php echo $config['controllername'].'.'.$config['actionname']=='wanlshop.order.index'?'active':''; ?>">

											<a href="<?php echo url('index/wanlshop.order/index'); ?>">

												<i class="fa fa-circle-o fa-fw"></i><span>注文管理</span>

											</a>

										</li>

										<li class="<?php echo $config['controllername'].'.'.$config['actionname']=='wanlshop.order.comment'?'active':''; ?>">

											<a href="<?php echo url('index/wanlshop.order/comment'); ?>">

												<i class="fa fa-circle-o fa-fw"></i><span>コメント管理</span>

											</a>

										</li>

										<li class="<?php echo $config['controllername'].'.'.$config['actionname']=='wanlshop.refund.index'?'active':''; ?>">

											<a href="<?php echo url('index/wanlshop.refund/index'); ?>">

												<i class="fa fa-circle-o fa-fw"></i><span>払い戻し管理</span>

											</a>

										</li>

									</ul>

								</li>

								<li class="treeview <?php echo in_array($config['controllername'],['wanlshop.logistics']) ?'active':''; ?>">

									<a href="javascript:;">

										<i class="fa fa-rocket fa-fw"></i> <span>ロジスティクス管理</span>

										<span class="pull-right-container"><i class="fa fa-angle-left"></i> </span>

									</a>

									<ul class="treeview-menu <?php echo in_array($config['controllername'],['wanlshop.logistics']) ?'menu-open':''; ?>" style="display: <?php echo in_array($config['controllername'],['wanlshop.logistics']) ?'block':'none'; ?>;">

										<li class="<?php echo $config['controllername'].'.'.$config['actionname']=='wanlshop.logistics.deliver'?'active':''; ?>">

											<a href="<?php echo url('index/wanlshop.logistics/deliver'); ?>">

												<i class="fa fa-circle-o fa-fw"></i><span>輸送する</span>

											</a>

										</li>

										<li class="<?php echo $config['controllername'].'.'.$config['actionname']=='wanlshop.logistics.template'?'active':''; ?>">

											<a href="<?php echo url('index/wanlshop.logistics/template'); ?>">

												<i class="fa fa-circle-o fa-fw"></i><span>配送テンプレート</span>

											</a>

										</li>

									</ul>

								</li>

								<li class="treeview <?php echo in_array($config['controllername'],['wanlshop.goods'])?'active':''; ?>">

									<a href="javascript:;">

										<i class="fa fa-shopping-bag fa-fw"></i> <span>商品管理</span>

										<span class="pull-right-container"><i class="fa fa-angle-left"></i> </span>

									</a>

									<ul class="treeview-menu <?php echo in_array($config['controllername'],['wanlshop.goods'])?'menu-open':''; ?>" style="display: <?php echo in_array($config['controllername'],['wanlshop.goods'])?'block':'none'; ?>;">

										<!--<li class="<?php echo $config['controllername'].'.'.$config['actionname']=='wanlshop.goods.add'?'active':''; ?>">

											<a href="<?php echo url('index/wanlshop.goods/add'); ?>">

												<i class="fa fa-circle-o fa-fw"></i><span>商品を公開する</span>

											</a>

										</li>-->

										<li class="<?php echo $config['controllername'].'.'.$config['actionname']=='wanlshop.goods.index'?'active':''; ?>">

											<a href="<?php echo url('index/wanlshop.goods/index'); ?>">

												<i class="fa fa-circle-o fa-fw"></i><span>セール品</span>

											</a>

										</li>

										<li class="<?php echo $config['controllername'].'.'.$config['actionname']=='wanlshop.goods.stock'?'active':''; ?>">

											<a href="<?php echo url('index/wanlshop.goods/stock'); ?>">

												<i class="fa fa-circle-o fa-fw"></i><span>倉庫内の商品</span>

											</a>

										</li>

									</ul>

								</li>

								<li class="treeview <?php echo in_array($config['controllername'],['wanlshop.shop','wanlshop.config'])?'active':''; ?>">

									<a href="javascript:;">

										<i class="fa fa-archive fa-fw"></i> <span>店舗管理</span>

										<span class="pull-right-container"><i class="fa fa-angle-left"></i> </span>

									</a>

									<ul class="treeview-menu <?php echo in_array($config['controllername'],['wanlshop.shop','wanlshop.config'])?'menu-open':''; ?>"

									 style="display: <?php echo in_array($config['controllername'],['wanlshop.shop','wanlshop.config'])?'block':'none'; ?>;">

										<li class="<?php echo $config['controllername'].'.'.$config['actionname']=='wanlshop.shop.attachment'?'active':''; ?>">

											<a href="<?php echo url('index/wanlshop.shop/attachment'); ?>">

												<i class="fa fa-circle-o fa-fw"></i><span>画像スペース</span>

											</a>

										</li>

										<li class="<?php echo $config['controllername'].'.'.$config['actionname']=='wanlshop.shop.index'?'active':''; ?>">

											<a href="<?php echo url('index/wanlshop.shop/index'); ?>">

												<i class="fa fa-circle-o fa-fw"></i><span>店舗建設</span>

											</a>

										</li>

										<li class="<?php echo $config['controllername'].'.'.$config['actionname']=='wanlshop.shop.category'?'active':''; ?>">

											<a href="<?php echo url('index/wanlshop.shop/category'); ?>">

												<i class="fa fa-circle-o fa-fw"></i><span>カテゴリー管理</span>

											</a>

										</li>

										<li class="<?php echo $config['controllername'].'.'.$config['actionname']=='wanlshop.shop.brand'?'active':''; ?>">

											<a href="<?php echo url('index/wanlshop.shop/brand'); ?>">

												<i class="fa fa-circle-o fa-fw"></i><span>ブランド管理</span>

											</a>

										</li>

										<li class="<?php echo $config['controllername'].'.'.$config['actionname']=='wanlshop.shop.profile'?'active':''; ?>">

											<a href="<?php echo url('index/wanlshop.shop/profile'); ?>">

												<i class="fa fa-circle-o fa-fw"></i><span>店舗情報</span>

											</a>

										</li>

										<li class="<?php echo $config['controllername'].'.'.$config['actionname']=='wanlshop.config.index'?'active':''; ?>">

											<a href="<?php echo url('index/wanlshop.config/index'); ?>">

												<i class="fa fa-circle-o fa-fw"></i><span>ストア構成</span>

											</a>

										</li>

									</ul>

								</li>

								<!-- <li class="treeview">

									<a href="<?php echo url('index/user/index'); ?>">

										<i class="fa fa-user fa-fw"></i> <span>會員中心</span> 

										<span class="pull-right-container"> </span>

									</a> 

								</li>-->

								<li class="treeview <?php echo in_array($config['controllername'],['wanlshop.find','wanlshop.coupon']) ? 'active':''; ?>">

									<a href="javascript:;">

										<i class="fa fa-th fa-fw text-red"></i> <span>アプリケーションセンター</span>

										<span class="pull-right-container"><i class="fa fa-angle-left"></i> </span>

									</a>

									<ul class="treeview-menu <?php echo in_array($config['controllername'],['wanlshop.find','wanlshop.coupon']) ? 'menu-open':''; ?>"

									 style="display: <?php echo in_array($config['controllername'],['wanlshop.find','wanlshop.coupon']) ? 'block':'none'; ?>;">

										<!--<li class="<?php echo $config['controllername'].'.'.$config['actionname']=='wanlshop.find.index'?'active':''; ?>">

											<a href="<?php echo url('index/wanlshop.find/index'); ?>">

												<i class="fa fa-circle-o fa-fw"></i><span>社區種草</span>

											</a>

										</li>-->

										<li class="<?php echo $config['controllername'].'.'.$config['actionname']=='wanlshop.coupon.index'?'active':''; ?>">

											<a href="<?php echo url('index/wanlshop.coupon/index'); ?>">

												<i class="fa fa-circle-o fa-fw"></i><span>クーポン</span>

											</a>

										</li>

										<!-- <li class="<?php echo $config['controllername'].'.'.$config['actionname']=='wanlshop.operate.index'?'active':''; ?>">

											<a href="<?php echo url('index/wanlshop.operate/index'); ?>">

												<i class="fa fa-circle-o fa-fw"></i><span>分銷</span> 

											</a> 

										</li>

								 		<li class="<?php echo $config['controllername'].'.'.$config['actionname']=='wanlshop.operate.index'?'active':''; ?>">

								 			<a href="<?php echo url('index/wanlshop.operate/index'); ?>">

								 				<i class="fa fa-circle-o fa-fw"></i><span>拼團</span> 

								 			</a> 

								 		</li>

										<li class="<?php echo $config['controllername'].'.'.$config['actionname']=='wanlshop.operate.index'?'active':''; ?>">

											<a href="<?php echo url('index/wanlshop.operate/index'); ?>">

												<i class="fa fa-circle-o fa-fw"></i><span>砍價</span> 

											</a> 

										</li>

										<li class="<?php echo $config['controllername'].'.'.$config['actionname']=='wanlshop.operate.index'?'active':''; ?>">

											<a href="<?php echo url('index/wanlshop.operate/index'); ?>">

												<i class="fa fa-circle-o fa-fw"></i><span>限時秒殺</span> 

											</a> 

										</li>

								 		-->

									</ul>

								</li>

								<li class="header">関連リンク</li>
								<li class="<?php echo $config['controllername'].'.'.$config['actionname']=='wanlshop.wholesale.index'?'active':''; ?>"><a href="<?php echo url('index/wanlshop.wholesale/index'); ?>?order=desc&offset=0&limit=10"><i class="fa fa-list text-red"></i> <span>卸売センター</span></a></li>

								<!--li class="<?php echo $config['controllername'].'.'.$config['actionname']=='wanlshop.user.line'?'active':''; ?>"><a href="<?php echo url('index/wanlshop.user/line'); ?>"><i class="fa fa-qq text-aqua"></i> <span>line交流群</span></a></li-->


								<!--<li class="header">相關鏈接</li>

								<?php if(empty($config['document']) || (($config['document'] instanceof \think\Collection || $config['document'] instanceof \think\Paginator ) && $config['document']->isEmpty())): ?>

								<li><a href="javascript:;" onclick="layer.msg('平一尚未配置官方文檔')"><i class="fa fa-list text-red"></i> <span>官方文檔</span></a></li>

								<?php else: ?>

								<li><a href="<?php echo $config['document']; ?>" target="_blank"><i class="fa fa-list text-red"></i> <span>官方文檔</span></a></li>

								<?php endif; if(empty($config['qun']) || (($config['qun'] instanceof \think\Collection || $config['qun'] instanceof \think\Paginator ) && $config['qun']->isEmpty())): ?>

								<li><a href="javascript:;" onclick="layer.msg('平一尚未配置QQ交流群')"><i class="fa fa-qq text-aqua"></i> <span>QQ交流群</span></a></li>

								<?php else: ?>

								<li><a href="<?php echo $config['qun']; ?>" target="_blank"><i class="fa fa-qq text-aqua"></i> <span>QQ交流群</span></a></li>

								<?php endif; ?>-->

							</ul>

						</section>

						<div class="slimScrollBar" style="background: rgba(0, 0, 0, 0.2); width: 8px; position: absolute; top: 0px; opacity: 0.4; display: none; border-radius: 7px; z-index: 99; right: 1px; height: 897px;"></div>

						<div class="slimScrollRail" style="width: 8px; height: 100%; position: absolute; top: 0px; display: none; border-radius: 7px; background: rgb(51, 51, 51); opacity: 0.2; z-index: 90; right: 1px;"></div>

					</div>

				</aside>

			</div>

			

			

			

			

			

			<div class="content-wrapper tab-content tab-addtabs">

				<div class="tab-pane active">

					<div id="main" role="main">

						<div class="tab-content tab-addtabs">

							<div id="content">

								<div class="row">

									<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">



										<!-- RIBBON -->

										<div id="ribbon">

											<ol class="breadcrumb pull-left">

												<li><a href="dashboard" class="addtabsit"><i class="fa fa-dashboard"></i> コンソール</a></li>

											</ol>

											<ol class="breadcrumb pull-right">

												<li><a href="javascript:;"><?php echo (isset($title1) && ($title1 !== '')?$title1:''); ?></a></li>

											</ol>

										</div>



										<!-- END RIBBON -->

										<div class="content">

											<link href="/assets/addons/wanlshop/css/appUI.css?v=<?php echo $site['version']; ?>" rel="stylesheet">

<link href="/assets/addons/wanlshop/css/page.css?v=<?php echo $site['version']; ?>" rel="stylesheet">

<link href="/assets/addons/wanlshop/css/iconfont.css?v=<?php echo $site['version']; ?>" rel="stylesheet">

<div class="panel panel-default panel-intro" id="app" v-cloak>

	<div class="panel-body" style="padding: 0;">

		<div id="myTabContent" class="tab-content">

			<div class="tab-pane fade active in" id="one">

				<div class="widget-body no-padding">

					<div class="wanl-page" :class="device">

						<!-- 左侧 -->

						<div class="left">

							<div class="wanl-tool">

								<div class="menu">

									<div class="dropdown">

										<div class="bnt" id="dLabel" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

											<span>{{device}}</span><span class="caret"></span>

										</div>

										<ul class="dropdown-menu" aria-labelledby="dLabel">

											<li><a @click="onDevice('huaweiMate30')">Huawei Mate30</a></li>

											<li role="separator" class="divider"></li>

											<li><a @click="onDevice('iPhoneX')">iPhoneX</a></li>

											<li><a @click="onDevice('iPhoneXmax')">iPhoneXmax</a></li>

											<li><a @click="onDevice('iPhone7')">iPhone7</a></li>

											<li><a @click="onDevice('iPhone7plus')">iPhone7plus</a></li>

											<li role="separator" class="divider"></li>

											<li><a @click="onDevice('OPPORenoAce')">OPPORenoAce</a></li>

											<li><a @click="onDevice('vivoNEX3')">vivoNEX3</a></li>

											<li><a @click="onDevice('xiaomi9Pro')">xiaomi9Pro</a></li>

										</ul>

									</div>

									<div class="dropdown">

										<div class="bnt" id="dLabel2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

											<span>{{signal}}</span><span class="caret"></span>

										</div>

										<ul class="dropdown-menu" aria-labelledby="dLabel2">

											<li><a @click="onSignal('WIFI')">WIFI</a></li>

											<li role="separator" class="divider"></li>

											<li><a @click="onSignal('3G')">3G</a></li>

											<li><a @click="onSignal('4G')">4G</a></li>

											<li><a @click="onSignal('5G')">5G</a></li>

										</ul>

									</div>



									<!-- <div class="dropdown">

										<div class="bnt" id="dLabel3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

											<span>关于系统</span><span class="caret"></span>

										</div>

										<ul class="dropdown-menu" aria-labelledby="dLabel3">

											<li><a>使用教程</a></li>

											<li role="separator" class="divider"></li>

											<li><a>万联科技</a></li>

											<li><a>WANLSHOP v1.0.1</a></li>

										</ul>

									</div> -->

								</div>

								<div class="Button">

									<div class="dropdown">

										<div class="bnt" id="dLabel3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

											<span>リリース</span><span class="caret"></span>

										</div>

										<ul class="dropdown-menu" aria-labelledby="dLabel3">

											<li @click="publish"><a href="javascript:void(0);">ページを公開</a></li>

											<li role="separator" class="divider"></li>

											<li v-if="pageRecover.length == 0"><a href="javascript:void(0);"><i class="wlIcon wlIcon-31tishi"></i> 履歴が見つかりません</a></li>

											<li v-for="list in pageRecover" @click="recover(list.id)"><a href="javascript:void(0);">再開 {{list.createtime|formatDate}} バージョン</a></li>

										</ul>

									</div>

								</div>

							</div>

							<!-- 手机 -->

							<div class="frame">

								<div class="preview">

									<div ref="parant" class="page" :style="{'background-color': pageData.page.style.pageBackgroundColor,'background-image': 'url('+pageData.page.style.pageBackgroundImage+')'}">

										<!-- 导航 -->

										<div class="navigation" :class="{action: type == 'page'}" :style="{'background-color': pageData.page.style.navigationBarBackgroundColor,color:pageData.page.style.navigationBarTextStyle}" @click="onType('page')">

											<div class="Statusbar">

												<div class="time"> {{nowTime}} </div>

												<div class="bangs">

													<div class="sub"></div>

												</div>

												<div class="device">

													<i class="wlIcon wlIcon-xinhao"></i>

													<i v-if="signal == '3G'">3G</i>

													<i v-if="signal == '4G'">4G</i>

													<i v-if="signal == '5G'">5G</i>

													<i v-if="signal == 'WIFI'" class="wlIcon wlIcon-WIFI"></i>

													<i class="wlIcon wlIcon-dianchifull"></i>

												</div>

											</div>

											<div class="page-head">

												<span class="wanlicon">

													<i class="wlIcon wlIcon-fanhui1"></i>

												</span>

												<span class="title">

													{{pageData.page.params.navigationBarTitleText}}

												</span>

												<span class="wanlicon">

													<i class="wlIcon wlIcon-fenxiang"></i>

												</span>

											</div>

										</div>

										<!-- 模块&拖动 -->

										<wanldraggable class="draggable" v-model="pageData.item" v-bind="{animation:500}">

											<div class="wanlshop" v-for="(item,index) in pageData.item" :key="index" @click="onType(index)" :class="{action: type == index}">

												<!-- 轮播组件 -->

												<div class="banner" v-if="item.type == 'banner'" :style="item.style">

													<img :src="cdnurl(item.data[0].image)">

													<div class="indicator">

														<div class="item">

															<span v-for="indic in item.data"></span>

														</div>

													</div>

												</div>

												<!-- 单图 -->

												<div class="image" v-if="item.type == 'image'" :style="item.style">

													<img :src="cdnurl(item.data[0].image)">

												</div>

												<!-- 广告轮播组件 -->

												<div class="advertBanner" v-if="item.type == 'advertBanner'" :style="item.style">

													<img src="/assets/addons/wanlshop/img/page/advert-banner.png">

													<div class="indicator">

														<div class="item">

															<span v-for="indic in item.data"></span>

														</div>

													</div>

												</div>

												<!-- 广告单图 -->

												<div class="advertImage" v-if="item.type == 'advertImage'" :style="item.style">

													<img src="/assets/addons/wanlshop/img/page/advert-image.png">

												</div>

												<!-- 视频 -->

												<div class="video" v-if="item.type == 'video'" :style="item.style">

													<img :src="cdnurl(item.data[0].image)">

													<div class="play"><i class="wlIcon wlIcon-bofang"></i></div>

												</div>

												<!-- 菜单组件 -->

												<div class="menu" v-if="item.type == 'menu'" :style="item.style">

													<div class="grid text-center" :class="'col-' + item.params.colfive">

														<div class="item" v-for="meun in item.data" :style="{'margin-top':item.params.menuMarginTop}">

															<div class="picicon" :class="meun.bgClass" :style="{'height':item.params.menuHeightWidth,'width':item.params.menuHeightWidth,'margin-bottom':item.params.menuMarginBottom}">

																<span :class="meun.iconClass"><i class="wlIcon" :class="meun.icon" :style="{'font-size':item.params.menuIconSize}"></i></span>

															</div>

															<div :style="{'font-size':item.params.menuTextSize}">{{meun.text}}</div>

														</div>

													</div>

												</div>

												<!-- 公告栏 -->

												<div class="notice" v-if="item.type == 'notice'" :style="item.style">

													<i class="wlIcon wlIcon-notice margin-right-xs" v-if="item.params.show"></i><span>{{item.data[0].content}}</span>

												</div>

												<!-- 文章组件 -->

												<div class="article" v-if="item.type == 'article'" :style="item.style">

													<div class="item" v-for="article in item.data">

														<div class="image">

															<img :src="cdnurl(article.image)" >

														</div>

														<div class="article-content">

															<div class="title">

																{{article.articleTitle ? article.articleTitle : '右側のアクションバーをクリックして記事を選択してください'}}

															</div>

															<div class="operate">

																<span v-if="item.params.showTime == 'true'">2020年5月30日20:53</span>

																<span v-if="item.params.showView == 'true'">ブラウズ：100</span>

															</div>

														</div>

													</div>

												</div>

												<!-- 头条组件 -->

												<div class="headlines" v-if="item.type == 'headlines'" :style="item.style">

													<div class="margin-lr-bj">

														<i class="wlIcon wlIcon-toutiao"></i>

													</div>

													<div class="swiper">

														<div class="list padding-tb-xs">

															<div class="text-sm">

																<div class="cu-tag sm radius bg-gradual-red margin-right-xs">人気</div>

																..ユーザー端末は、バックグラウンドのヘッドラインデータを自動的に取得します..

															</div>

															<div class="text-sm">

																<div class="cu-tag sm radius bg-gradual-red margin-right-xs">人気</div>

																..ユーザー端末は、バックグラウンドのヘッドラインデータを自動的に取得します.. 

															</div>

														</div>

														<div class="pic">

															<img :src="cdnurl(item.data[0].image)" >

														</div>

													</div>

												</div>

												<!-- 搜索栏 -->

												<div class="search" v-if="item.type == 'search'" :style="item.style">

													<div :style="{'border-radius':item.params.searchRadius,'background':item.params.searchBackground,'padding':item.params.searchPadding}">

														<i class="wlIcon wlIcon-sousuo margin-right-xs"></i><span>{{item.data[0].content}}</span>

													</div>

												</div>

												<!-- 活动橱窗 -->

												<div class="category" v-if="item.type == 'activity'" :style="item.style">

													<div class="cu-list grid col-2-2_1">

														<div class="cu-item" v-for="(act, index) in item.data" :key="index">

															<div class="name">

																<span class="text-lg" :class="act.textColor">{{getParameter(act.activity)}}</span>

																<div v-if="act.tags" class="cu-tag round sm wanl-bg-orange"> 

																	<span class="wlIcon wlIcon-dot"></span>{{act.tags}}

																</div>

															</div>

															<div v-if="act.describe" class="wanl-gray">{{act.describe}}</div>

															<div class="goods margin-top-bj">

																<div v-for="image in getListNum('col-2-2_1', index)">

																	<img src="/assets/addons/wanlshop/img/common/img_default3x.png">

																</div>

															</div>

														</div>

													</div>

												</div>

												<!-- 分类橱窗 -->

												<div class="category" v-if="item.type == 'classify'" :style="item.style">

													<div class="cu-list grid" :class="item.params.colStyle">

														<div class="cu-item" v-for="(cat, index) in item.data" :key="index">

															<div class="name">

																<span class="text-lg" :class="cat.textColor">{{categoryName(cat.categoryId)}}</span>

																<div v-if="cat.tags" class="cu-tag round sm wanl-bg-orange">

																	<span class="wlIcon wlIcon-dot"></span>{{cat.tags}}

																</div>

															</div>

															<div v-if="cat.describe" class="wanl-gray">{{cat.describe}}</div>

															<div class="goods margin-top-bj">

																<div v-for="image in getListNum(item.params.colStyle, index)">

																	<img src="/assets/addons/wanlshop/img/common/img_default3x.png">

																</div>

															</div>

														</div>

													</div>

												</div>

												<!-- 类目标题 -->

												<div class="categoryTitle" v-if="item.type == 'categoryTitle'" :style="item.style">

													<div class="text-lg"> <span class="wlIcon margin-right-xs" :class="item.data[0].icon"></span>

														{{item.data[0].categoryName}} ···</div>

													<div class="text-sm wanl-gray">更多 <span class="wlIcon wlIcon-fanhui2 margin-left-xs"></span> </div>

												</div>

												<!-- 猜你喜欢 -->

												<div class="product" v-if="item.type == 'likes'" :style="item.style" :class="'col-'+ item.params.colthree +'-'+item.params.colmargin" >

													<div class="item">

														<div class="item_pic">

															<img src="/assets/addons/wanlshop/img/common/img_default3x.png">

														</div>

														<div class="item_list padding-bj">

															<div class="margin-bottom-xs">

																<div class="text-df text-cut-2">自動取得…自動取得…自動取得…</div>

																<div class="wanl-orange text-price text-lg">199</div>

															</div>

															<div>

																<div class="text-xs wanl-gray">

																	<span class="margin-right-sm">100+コメント</span> <span>100%有利なレート</span>

																</div>

															</div>

														</div>

													</div>



													<div class="item">

														<div class="item_pic">

															<img src="/assets/addons/wanlshop/img/common/img_default3x.png">

														</div>

														<div class="item_list padding-bj">

															<div class="margin-bottom-xs">

																<div class="text-df text-cut-2">自動取得…自動取得…自動取得…</div>

																<div class="wanl-orange text-price text-lg">199</div>

															</div>

															<div>

																<div class="text-xs wanl-gray">

																	<span class="margin-right-sm">100+コメント</span> <span>100%有利なレート</span>

																</div>

															</div>

														</div>

													</div>

												</div>

												<!-- 商品组件 -->

												<div class="product" v-if="item.type == 'goods'" :style="item.style" :class="'col-'+ item.params.colthree +'-'+item.params.colmargin" >

													<div class="item" v-for="goods in item.data">

														<div class="item_pic">

															<img src="/assets/addons/wanlshop/img/common/img_default3x.png">

														</div>

														<div class="item_list padding-bj">

															<div class="margin-bottom-xs">

																<div class="text-df text-cut-2">タイトルタイトルタイトルタイトルタイトルタイトルタイトルタイトルタイトルタイトルタイトルタイトルタイトルタイトルタイトル</div>

																<div class="wanl-orange text-price text-lg">199</div>

															</div>

															<div class="">

																<div class="margin-bottom-xs">

																	<div class="cu-tag sm round bg-gradual-red">新製品</div>

																	<div class="cu-tag sm round bg-white">クーポン66マイナス6を取得</div>

																</div>

																<div class="text-xs wanl-gray">

																	<span class="margin-right-sm">100+コメント</span> <span>100%有利なレート</span>

																</div>

															</div>

														</div>

													</div>

												</div>

												<!-- 砍价组件 -->

												<div class="bargain" v-if="item.type == 'bargain'" :style="item.style">

													<span>交渉コンポーネント-次のバージョンがリリースされますので、ご期待ください</span>

												</div>

												<!-- 秒杀组件 -->

												<div class="seckill" v-if="item.type == 'seckill'" :style="item.style">

													<span>スパイクコンポーネント-次のバージョンがリリースされますので、ご期待ください</span>

												</div>

												<!-- 搜索栏 -->

												<div class="empty" v-if="item.type == 'empty'" :style="item.style">

												</div>

												<!-- 分隔符 -->

												<div class="division" v-if="item.type == 'division'" :style="item.style">

													<div class="line" :style="{'width':item.params.lineWidth,'height':item.params.lineHeight,'background':item.params.lineBackground}"></div>

													<div class="linetext" :style="{'color':item.params.lineTextColor,'font-size':item.params.lineTextSize,'line-height':item.params.lineTextSize,'background':item.params.lineTextBackground,'padding':item.params.lineTextPadding}">

														{{item.params.lineText}}

													</div>

												</div>

												<div class="sub-del" @click="delModule(index)"><i class="wlIcon wlIcon-31guanbi"></i></div>

											</div>

										</wanldraggable>

									</div>

								</div>

								<div class="template">

									<div class="template-title">

										<span><i></i>カスタムコンポーネント</span>

										<!-- <span>更多 <span class="wlIcon wlIcon-fanhuigengduo"></span></span> -->

									</div>

									<div class="control">

										<!-- 模板分组 -->

										<div class="element" v-for="(item,index) in module" :key="index">

											<div class="element-name"> {{getParameter(index)}}</div>

											<div class="element-row">

												<div v-for="element in item" @click="addTemplate(element)">

													<i class="wlIcon" :class="'wlIcon-'+element.type"></i>

													<span>{{element.name}}</span>

												</div>

											</div>

										</div>

									</div>

								</div>

							</div>

						</div>

						<!-- 编辑器 -->

						<div class="editor">

							<div class="bs-example bs-example-tabs" v-if="type == 'page'">

								<ul class="nav nav-tabs" role="tablist">

									<li class="active"><a href="#home" data-toggle="tab" aria-expanded="true">ページ構成</a></li>

								</ul>

								<div class="tab-content">

									<div class="tab-pane fade active in" id="home">

										<p class="bg-info text-info"><strong>スキル：</strong>モジュールをクリックした後、このページが見つかりません。左側のナビゲーションバーをクリックして戻ります。！</p>

										<div class="form-group">

											<label>ページ名:</label>

											<input type="text" class="form-control" v-model="pageData.name">

										</div>

										<div class="form-group">

											<label>ナビゲーション列ヘッダー:</label>

											<input type="text" class="form-control" v-model="pageData.page.params.navigationBarTitleText">

										</div>

										

										<h5 class="page-header"></h5>

										<div class="form-group">

											<label>ナビゲーションバーの背景画像:</label>

											<div class="wanl-upload">

												<input class="form-control" type="text" v-model="pageData.page.style.navigationBackgroundImage">

												<input type="file" id="navigationBackground" accept="image/*" @change="changeImage($event,'navigationBackgroundImage')" style="display:none" >

												<label for="navigationBackground" class="btn btn-info">

													<i class="fa fa-upload"></i> アップロード

												</label>

											</div>

										</div>

										<div class="form-group">

											<label>ナビゲーションバーの背景:</label>

											<div class="form-inline">

												<input type="text" class="form-control" v-model="pageData.page.style.navigationBarBackgroundColor"> <input

												 id="color" class="form-control" type="color" v-model="pageData.page.style.navigationBarBackgroundColor">

											</div>

										</div>

										<div class="form-group">

											<label>ナビゲーションの前景色:</label>

											<select class="form-control" v-model="pageData.page.style.navigationBarTextStyle">

												<option value="#ffffff">淡い色（白）</option>

												<option value="#000000">ダーク（黒）</option>

											</select>

										</div>

										<h5 class="page-header"></h5>

										<div class="form-group">

											<label>ページの背景画像:</label>

											<div class="wanl-upload">

												<input class="form-control" type="text" v-model="pageData.page.style.pageBackgroundImage">

												<input type="file" id="pageBackground" accept="image/*" @change="changeImage($event,'pageBackgroundImage')" style="display:none" >

												<label for="pageBackground" class="btn btn-info">

													<i class="fa fa-upload"></i> アップロード

												</label>

											</div>

										</div>

										<div class="form-group">

											<label>ページの背景:</label>

											<div class="form-inline">

												<input type="text" class="form-control" v-model="pageData.page.style.pageBackgroundColor"> 

												<input id="color" class="form-control" type="color" v-model="pageData.page.style.pageBackgroundColor">

											</div>

										</div>

										<div class="form-group">

											<label>繰り返される背景:</label>

											<select class="form-control" v-model="pageData.page.style.pageBackgroundRepeat">

												<option value="#ffffff">繰り返す</option>

												<option value="#000000">繰り返さない</option>

											</select>

										</div>

									</div>

								</div>

							</div>

							

							<!-- 组件 -->

							<div class="bs-example bs-example-tabs module-example" v-for="(item,index) in pageData.item" :key="index" v-if="type == index">

								<ul class="nav nav-tabs" role="tablist">

									<li class="active"><a href="#home" data-toggle="tab" aria-expanded="true">{{item.name}}データ</a></li>

									<li v-if="item.params !== undefined"><a href="#params" data-toggle="tab" aria-expanded="false">構成パラメーター</a></li>

									<li><a href="#style" data-toggle="tab" aria-expanded="false">CSSスタイル</a></li>

								</ul>

								<div class="tab-content">

									<!-- 组件首页 -->

									<div class="tab-pane fade active in" id="home">

										<div class="add-data" @click="addData(index,item.data[0])">

											<a class="btn btn-sm btn-info btn-append"><i class="fa fa-plus"></i> データを追加する</a>

										</div>

										<p class="bg-info text-info"><strong>注意：</strong>データを追加するかどうかはご自身で判断してください。単一の画像などの単一のデータは無効です。！</p>

										<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">

											<div class="panel panel-default" v-for="(lists,num) in item.data" :key="num">

												<div class="panel-heading" role="tab" :id="'heading-'+num">

													<h4 class="panel-title" role="button" data-toggle="collapse" data-parent="#accordion" :href="'#collapse-'+num" :aria-expanded="num==0?true:false" :aria-controls="'collapse-'+num">

														{{item.name}} <strong>#{{num+1}}</strong>

													</h4>

													<span @click="delData(index,num)"><i class="wlIcon wlIcon-31guanbi"></i></span> 

												</div>

												<div :id="'collapse-'+num" class="panel-collapse collapse" :class="num==0?'in':''" role="tabpanel" :aria-labelledby="'heading-'+num">

													<div class="panel-body">

														<div v-for="(datas,type) in lists" :key="type">

															<!-- 图片上传组件 -->

															<div class="form-group" v-if="type == 'image'">

																<label>画像:</label>

																<div class="wanl-upload">

																	<input class="form-control" type="text" v-model="lists[type]"  placeholder="写真をアップロードするには、右側の[アップロード]をクリックします">

																	<input type="file" :id="type+index+num" accept="image/*" @change="dataUpload($event,index,num,type)" :ref="type+index+num" style="display: none;">

																	<label :for="type+index+num" class="btn btn-info">

																		<i class="fa fa-upload"></i> アップロード

																	</label>

																</div>

																<ul class="row list-inline plupload-preview">

																	<li class="col-xs-3">

																		<a class="thumbnail"><img :src="cdnurl(lists[type])" class="img-responsive"></a>

																	</li>

																</ul>

															</div>

															<!-- 提示 -->

															<div class="tips" v-else-if="type == 'tips'">

																{{datas}}

															</div>

															<!-- 提示2 -->

															<div class="title form-group" v-else-if="type == 'title'">

																<span class="text-green">{{datas}}</span>

															</div>

															<!-- icon颜色 -->

															<div class="form-group" v-else-if="type == 'iconClass'">

																<label>アイコンの色:</label>

																<select class="form-control" v-model="lists[type]">

																	<option value="text-white">白い</option>

																	<option value="wanl-black">ピュアブラック</option>

																	<option value="wanl-pip">スタンダードブラック</option>

																	<option value="wanl-gray-dark">暗灰色</option>

																	<option value="wanl-gray-light">ライトグレー</option>

																	<option value="wanl-text-white">白（グラデーション）</option>

																	<option value="wanl-orange">オレンジ</option>

																	<option value="wanl-red">赤</option>

																	<option value="text-yellow">黄</option>

																	<option value="text-green">緑</option>

																	<option value="text-blue">ブルー</option>

																	<option value="text-olive">アーミーグリーン</option>

																	<option value="text-cyan">青</option>

																	<option value="text-purple">紫の</option>

																	<option value="text-mauve">ヤン・ズー</option>

																	<option value="text-pink">ピンク</option>

																	<option value="text-brown">褐色</option>

																	<option value="wanl-text-red">赤（グラデーション）</option>

																	<option value="wanl-text-yellow">黄（グラデーション）</option>

																	<option value="wanl-text-orange">オレンジ（グラデーション）</option>

																	<option value="wanl-text-violet">バイオレット（グラデーション）</option>

																	<option value="wanl-text-blue">ブルー（グラデーション）</option>

																	<option value="wanl-text-light-blue">浅ブルー（グラデーション）</option>

																	<option value="wanl-text-pink">ピンク（グラデーション）</option>

																	<option value="wanl-text-green">緑（グラデーション）</option>

																	<option value="wanl-text-purple">紫の（グラデーション）</option>

																</select>

															</div>

															<!-- 背景样式下拉 -->

															<div class="form-group" v-else-if="type == 'bgClass'">

																<label>バックグラウンド:</label>

																<select class="form-control" v-model="lists[type]">

																	<option value="wanl-bg-transparent">透明（无）</option>

																	<option value="bg-white">白色</option>

																	<option value="wanl-bg-redorange">橘赤（グラデーション）</option>

																	<option value="wanl-bg-orange">オレンジ（グラデーション）</option>

																	<option value="wanl-bg-pink">ピンク（グラデーション）</option>

																	<option value="wanl-bg-blue">ブルー（グラデーション）</option>

																	<option value="bg-gradual-yellow">黄（グラデーション）</option>

																	<option value="bg-gradual-red">洋红（グラデーション）</option>

																	<option value="bg-gradual-orange">黄橙（グラデーション）</option>

																	<option value="bg-gradual-green">草绿（グラデーション）</option>

																	<option value="bg-gradual-purple">紫の（グラデーション）</option>

																	<option value="bg-gradual-pink">ヤン・ズー（グラデーション）</option>

																	<option value="bg-gradual-blue">蓝绿（グラデーション）</option>

																	<option value="bg-red">赤</option>

																	<option value="bg-orange">オレンジ</option>

																	<option value="bg-yellow">黄</option>

																	<option value="bg-olive">アーミーグリーン</option>

																	<option value="bg-green">緑</option>

																	<option value="bg-cyan">青</option>

																	<option value="bg-blue">ブルー</option>

																	<option value="bg-purple">インクパープル</option>

																	<option value="bg-mauve">ヤン・ズー</option>

																	<option value="bg-pink">ピンク</option>

																	<option value="bg-brown">褐色</option>

																</select>

															</div>

															<!-- 链接地址 -->

															<div class="form-group" v-else-if="type == 'link'">

																<h5 class="page-header"></h5>

																<label>リンクアドレス:</label>

																<div class="wanl-upload">

																	<input type="text" class="form-control" v-model="lists[type]" placeholder="右側の選択ボタンをクリックしてリンクを選択します">

																	<button @click="obtainLink(index,num,type,'false')" class="btn btn-primary wanl-link"><i class="fa fa-link"></i> 選択する </button>

																</div>

															</div>

															<!-- 类目链接 -->

															<div class="form-group" v-else-if="type == 'categoryLink'">

																<h5 class="page-header"></h5>

																<label>カテゴリリンク:</label>

																<div class="wanl-upload">

																	<input type="text" class="form-control" v-model="lists[type]" placeholder="右側の選択ボタンをクリックして、カテゴリIDを選択します">

																	<button @click="categoryLink(index, num, 'false')" class="btn btn-primary wanl-link"><i class="fa fa-link"></i> 選択する </button>

																</div>

															</div>

															<!-- 视频地址 -->

															<div class="form-group" v-else-if="type == 'video'">

																<h5 class="page-header"></h5>

																<label>ビデオを選択:</label>

																<div class="wanl-upload">

																	<input type="text" class="form-control" v-model="lists[type]" placeholder="右側の選択ボタンをクリックしてリンクを選択します">

																	<button @click="attachmentLink(index,num,type,'false')" class="btn btn-primary wanl-link"><i class="fa fa-list"></i> 選択する </button>

																</div>

															</div>

															<!-- icon类名 -->

															<div class="form-group" v-else-if="type == 'icon'">

																<label>アイコンクラス名:</label>

																<div class="wanl-upload">

																	<input type="text" class="form-control" v-model="lists[type]" placeholder="右側の選択ボタンをクリックしてアイコンを選択します">

																	<button @click="iconLink(index, num, type, 'false')" class="btn btn-info wanl-link"><i class="fa fa-bars"></i> 選択する </button>

																</div>

															</div>

															<!-- 商品链接 -->

															<div class="form-group" v-else-if="type == 'goodsLink'">

																<label>商品:</label>

																<div class="wanl-upload">

																	<input type="text" class="form-control" v-model="lists[type]" placeholder="右側の選択ボタンをクリックして、製品IDを選択します">

																	<button @click="goodsLink(index,num,type,'false')" class="btn btn-info wanl-link"><i class="fa fa-bars"></i> 選択する </button>

																</div>

															</div>

															

															<!-- 类目名 -->

															<div class="form-group" v-else-if="type == 'categoryName'">

																<label>種別名:</label>

																<input type="text" class="form-control" v-model="lists[type]" disabled />

															</div>

															<!-- 内容 -->

															<div class="form-group" v-else-if="type == 'content'">

																<label>コンテンツ:</label>

																<input type="text" class="form-control" v-model="lists[type]" placeholder="コンテンツを入力してください">

															</div>

															

															<!-- 活动类型 -->

															<div class="form-group" v-else-if="type == 'activity'">

																<label>活動の種類:</label>

																<select class="form-control" v-model="lists[type]">

																	<option value="distribution">分布</option>

																	<option value="group">共同購入して参加する</option>

																	<option value="bargain">バーゲン</option>

																	<option value="rush">期間限定購入</option>

																	<option value="coupon">クーポンセンター</option>

																</select>

															</div>

															<!-- 字体颜色 -->

															<div class="form-group" v-else-if="type == 'textColor'">

																<label>フォントの色:</label>

																<select class="form-control" v-model="lists[type]">

																	<option value="wanl-black">黒</option>

																	<option value="wanl-pip">スタンダードブラック</option>

																	<option value="wanl-orange">オレンジ</option>

																	<option value="wanl-red">ワンリアンレッド</option>

																	<option value="text-red">赤</option>

																	<option value="text-yellow">黄</option>

																	<option value="text-green">緑</option>

																	<option value="text-blue">ブルー</option>

																	<option value="text-olive">アーミーグリーン</option>

																	<option value="text-cyan">青</option>

																	<option value="text-purple">紫の</option>

																	<option value="text-mauve">ヤン・ズー</option>

																	<option value="text-pink">ピンク</option>

																	<option value="text-brown">褐色</option>

																	<option value="wanl-gray-dark">暗灰色</option>

																	<option value="wanl-gray-light">ライトグレー</option>

																</select>

															</div>

															<!-- 类目 -->

															<div class="form-group" v-else-if="type == 'categoryId'">

																<label>カテゴリを選択:</label>

																<select class="form-control" v-model="lists[type]">

																	<option v-for="cate in pageCategory" :value ="cate.id">{{mergeSpace(cate.spacer)}} {{cate.name}}</option>

																</select>

															</div>

															<!-- 普通表单 -->

															<div class="form-group" v-else>

																<label>{{getParameter(type)}}:</label>

																<input type="text" class="form-control" v-model="lists[type]" :placeholder="'入ってください' + getParameter(type)">

															</div>

														</div>

													</div>

												</div>

											</div>

										</div>

									</div>

									<!-- 组件参数 -->

									<div class="tab-pane fade" id="params">

										<p class="bg-warning text-warning"><strong>促す：</strong>パラメータに「pxunit」がある場合は、削除せず、pxのみにすることができます（クライアントは自動的にアダプティブrpxに変換されます）</p>

										<div class="form-group" v-for="(params,type) in item.params" :key="type">

											<!-- 指示器样式 -->

											<div v-if="type == 'banstyle'">

												<label>インジケータースタイル:</label>

												<select class="form-control" v-model="item.params[type]">

													<option value="1">丸い形</option>

													<option value="2">矩形</option>

												</select>

											</div>

											<!-- 布局方式 -->

											<div v-else-if="type == 'colStyle'">

												<label>レイアウト:</label>

												<select class="form-control" v-model="item.params[type]">

													<option value="col-1-2-2">1-2-2レイアウト</option>

													<option value="col-1-1_2">1-1_2レイアウト</option>

													<option value="col-2-1_2">2-1_2レイアウト</option>

													<option value="col-2-2_1">2-2_1レイアウト</option>

													<option value="col-2-2-1_2">2-2-1_2レイアウト</option>

													<option value="col-2-4">2-4レイアウト</option>

													<option value="col-2-2-4">2-2-4レイアウト</option>

												</select>

											</div>

											<!-- 每行数量 -->

											<div v-else-if="type == 'colthree'">

												<label>1行あたりの数:</label>

												<select class="form-control" v-model="item.params[type]">

													<option value="1">各行 1 カラム</option>

													<option value="2">各行 2 カラム</option>

													<option value="3">各行 3 カラム</option>

												</select>

											</div>

											<!-- 每行数量 -->

											<div v-else-if="type == 'colfive'">

												<label>1行あたりの数:</label>

												<select class="form-control" v-model="item.params[type]">

													<option value="1">各行 1 カラム</option>

													<option value="2">各行 2 カラム</option>

													<option value="3">各行 3 カラム</option>

													<option value="4">各行 4 カラム</option>

													<option value="5">各行 5 カラム</option>

												</select>

											</div>

											<!-- 列边距 -->

											<div v-else-if="type == 'colmargin'">

												<label>マージン:</label>

												<select class="form-control" v-model="item.params[type]">

													<option value="10">5ピクセル（10rpx）</option>

													<option value="15">7.5ピクセル（15rpx）</option>

													<option value="20">10ピクセル（20rpx）</option>

													<option value="25">12.5ピクセル（25rpx）</option>

													<option value="30">15ピクセル（30rpx）</option>

												</select>

											</div>

											<!-- 判断开关 -->

											<div v-else-if="type == 'show'">

												<label>通知バーアイコン:</label>

												<select class="form-control" v-model="item.params[type]">

													<option value="true">表示</option>

													<option value="">見せないで</option>

												</select>

											</div>

											<div v-else-if="type == 'showTime'">

												<label>記事の日付:</label>

												<select class="form-control" v-model="item.params[type]">

													<option value="true">表示</option>

													<option value="false">見せないで</option>

												</select>

											</div>

											<div v-else-if="type == 'showView'">

												<label>ビュー:</label>

												<select class="form-control" v-model="item.params[type]">

													<option value="true">表示</option>

													<option value="false">見せないで</option>

												</select>

											</div>

											<!-- 搜索颜色选项 -->

											<div class="form-inline" v-else-if="type == 'searchBackground'">

												<label>検索バーの背景:</label>

												<input type="text" class="form-control" v-model="item.params[type]"> <input id="color" class="form-control"

												 type="color" v-model="item.params[type]">

											</div>

											<!-- 线段颜色 -->

											<div class="form-inline" v-else-if="type == 'lineBackground'">

												<label>線の色:</label>

												<input type="text" class="form-control" v-model="item.params[type]"> <input id="color" class="form-control"

												 type="color" v-model="item.params[type]">

											</div>

											<!-- 分隔字体颜色 -->

											<div class="form-inline" v-else-if="type == 'lineTextColor'">

												<label>フォントの色:</label>

												<input type="text" class="form-control" v-model="item.params[type]"> <input id="color" class="form-control"

												 type="color" v-model="item.params[type]">

											</div>

											<!-- 分隔字体背景颜色选项 -->

											<div class="form-inline" v-else-if="type == 'lineTextBackground'">

												<label>フォントの背景色:</label>

												<input type="text" class="form-control" v-model="item.params[type]"> <input id="color" class="form-control"

												 type="color" v-model="item.params[type]">

											</div>

											<!-- 默认表单 -->

											<div v-else>

												<label>{{getParameter(type)}}:</label>

												<input type="text" class="form-control" v-model="item.params[type]">

											</div>

										</div>

									</div>

									<!-- 组件样式 -->

									<div class="tab-pane fade" id="style">

										<p class="bg-danger text-danger"><strong>促す：</strong>このアイテムを操作するには、フロントエンドCSSの基本を習得する必要があります。フロントエンドを知らない学生の場合は、デフォルトのスタイルを維持してください。スタイルを追加/変更することはお勧めしません。</p>

										<div class="form-group" v-for="(styles,type) in item.style" :key="type">

											<label>

												<div>{{type}} {{moduleStyle[type].name}}:</div>

												<div class="del" @click="delStyle(index,type)"><i class="wlIcon wlIcon-31guanbi"></i></div>

											</label>

											<div class="form-inline" v-if="type == 'color' || type == 'background-color'">

												<input type="text" class="form-control" v-model="item.style[type]"> <input id="color" class="form-control"

												 type="color" v-model="item.style[type]">

											</div>

											<div v-else>

												<input type="text" class="form-control" v-model="item.style[type]">

											</div>

										</div>

										<div class="dropdown">

											<a class="btn btn-sm btn-success btn-append" data-target="#" data-toggle="dropdown" role="button"

											 aria-haspopup="true" aria-expanded="false"><i class="fa fa-plus"></i> 新しいスタイルを追加する</a>

											<ul class="dropdown-menu">

												<li v-for="(item,type) in moduleStyle" :key="type">

													<a @click="addStyle(index,type,item.default)">{{item.name}}</a>

												</li>

											</ul>

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


										</div>

									</div>

								</div>

							</div>

						</div>

					</div>

				</div>

			</div>

		</div>



		<script src="/assets/js/require.min.js" data-main="/assets/js/require-wanlshop.min.js?v=<?php echo htmlentities($site['version']); ?>"></script>

	</body>

	<?php else: ?>

	<body class="inside-header inside-aside is-dialog" id="iosiframe">

		<div id="main" role="main">

			<div class="tab-content tab-addtabs">

				<div id="content">

					<div class="row">

						<div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">

							<div class="content">

								<link href="/assets/addons/wanlshop/css/appUI.css?v=<?php echo $site['version']; ?>" rel="stylesheet">

<link href="/assets/addons/wanlshop/css/page.css?v=<?php echo $site['version']; ?>" rel="stylesheet">

<link href="/assets/addons/wanlshop/css/iconfont.css?v=<?php echo $site['version']; ?>" rel="stylesheet">

<div class="panel panel-default panel-intro" id="app" v-cloak>

	<div class="panel-body" style="padding: 0;">

		<div id="myTabContent" class="tab-content">

			<div class="tab-pane fade active in" id="one">

				<div class="widget-body no-padding">

					<div class="wanl-page" :class="device">

						<!-- 左侧 -->

						<div class="left">

							<div class="wanl-tool">

								<div class="menu">

									<div class="dropdown">

										<div class="bnt" id="dLabel" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

											<span>{{device}}</span><span class="caret"></span>

										</div>

										<ul class="dropdown-menu" aria-labelledby="dLabel">

											<li><a @click="onDevice('huaweiMate30')">Huawei Mate30</a></li>

											<li role="separator" class="divider"></li>

											<li><a @click="onDevice('iPhoneX')">iPhoneX</a></li>

											<li><a @click="onDevice('iPhoneXmax')">iPhoneXmax</a></li>

											<li><a @click="onDevice('iPhone7')">iPhone7</a></li>

											<li><a @click="onDevice('iPhone7plus')">iPhone7plus</a></li>

											<li role="separator" class="divider"></li>

											<li><a @click="onDevice('OPPORenoAce')">OPPORenoAce</a></li>

											<li><a @click="onDevice('vivoNEX3')">vivoNEX3</a></li>

											<li><a @click="onDevice('xiaomi9Pro')">xiaomi9Pro</a></li>

										</ul>

									</div>

									<div class="dropdown">

										<div class="bnt" id="dLabel2" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

											<span>{{signal}}</span><span class="caret"></span>

										</div>

										<ul class="dropdown-menu" aria-labelledby="dLabel2">

											<li><a @click="onSignal('WIFI')">WIFI</a></li>

											<li role="separator" class="divider"></li>

											<li><a @click="onSignal('3G')">3G</a></li>

											<li><a @click="onSignal('4G')">4G</a></li>

											<li><a @click="onSignal('5G')">5G</a></li>

										</ul>

									</div>



									<!-- <div class="dropdown">

										<div class="bnt" id="dLabel3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

											<span>关于系统</span><span class="caret"></span>

										</div>

										<ul class="dropdown-menu" aria-labelledby="dLabel3">

											<li><a>使用教程</a></li>

											<li role="separator" class="divider"></li>

											<li><a>万联科技</a></li>

											<li><a>WANLSHOP v1.0.1</a></li>

										</ul>

									</div> -->

								</div>

								<div class="Button">

									<div class="dropdown">

										<div class="bnt" id="dLabel3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">

											<span>リリース</span><span class="caret"></span>

										</div>

										<ul class="dropdown-menu" aria-labelledby="dLabel3">

											<li @click="publish"><a href="javascript:void(0);">ページを公開</a></li>

											<li role="separator" class="divider"></li>

											<li v-if="pageRecover.length == 0"><a href="javascript:void(0);"><i class="wlIcon wlIcon-31tishi"></i> 履歴が見つかりません</a></li>

											<li v-for="list in pageRecover" @click="recover(list.id)"><a href="javascript:void(0);">再開 {{list.createtime|formatDate}} バージョン</a></li>

										</ul>

									</div>

								</div>

							</div>

							<!-- 手机 -->

							<div class="frame">

								<div class="preview">

									<div ref="parant" class="page" :style="{'background-color': pageData.page.style.pageBackgroundColor,'background-image': 'url('+pageData.page.style.pageBackgroundImage+')'}">

										<!-- 导航 -->

										<div class="navigation" :class="{action: type == 'page'}" :style="{'background-color': pageData.page.style.navigationBarBackgroundColor,color:pageData.page.style.navigationBarTextStyle}" @click="onType('page')">

											<div class="Statusbar">

												<div class="time"> {{nowTime}} </div>

												<div class="bangs">

													<div class="sub"></div>

												</div>

												<div class="device">

													<i class="wlIcon wlIcon-xinhao"></i>

													<i v-if="signal == '3G'">3G</i>

													<i v-if="signal == '4G'">4G</i>

													<i v-if="signal == '5G'">5G</i>

													<i v-if="signal == 'WIFI'" class="wlIcon wlIcon-WIFI"></i>

													<i class="wlIcon wlIcon-dianchifull"></i>

												</div>

											</div>

											<div class="page-head">

												<span class="wanlicon">

													<i class="wlIcon wlIcon-fanhui1"></i>

												</span>

												<span class="title">

													{{pageData.page.params.navigationBarTitleText}}

												</span>

												<span class="wanlicon">

													<i class="wlIcon wlIcon-fenxiang"></i>

												</span>

											</div>

										</div>

										<!-- 模块&拖动 -->

										<wanldraggable class="draggable" v-model="pageData.item" v-bind="{animation:500}">

											<div class="wanlshop" v-for="(item,index) in pageData.item" :key="index" @click="onType(index)" :class="{action: type == index}">

												<!-- 轮播组件 -->

												<div class="banner" v-if="item.type == 'banner'" :style="item.style">

													<img :src="cdnurl(item.data[0].image)">

													<div class="indicator">

														<div class="item">

															<span v-for="indic in item.data"></span>

														</div>

													</div>

												</div>

												<!-- 单图 -->

												<div class="image" v-if="item.type == 'image'" :style="item.style">

													<img :src="cdnurl(item.data[0].image)">

												</div>

												<!-- 广告轮播组件 -->

												<div class="advertBanner" v-if="item.type == 'advertBanner'" :style="item.style">

													<img src="/assets/addons/wanlshop/img/page/advert-banner.png">

													<div class="indicator">

														<div class="item">

															<span v-for="indic in item.data"></span>

														</div>

													</div>

												</div>

												<!-- 广告单图 -->

												<div class="advertImage" v-if="item.type == 'advertImage'" :style="item.style">

													<img src="/assets/addons/wanlshop/img/page/advert-image.png">

												</div>

												<!-- 视频 -->

												<div class="video" v-if="item.type == 'video'" :style="item.style">

													<img :src="cdnurl(item.data[0].image)">

													<div class="play"><i class="wlIcon wlIcon-bofang"></i></div>

												</div>

												<!-- 菜单组件 -->

												<div class="menu" v-if="item.type == 'menu'" :style="item.style">

													<div class="grid text-center" :class="'col-' + item.params.colfive">

														<div class="item" v-for="meun in item.data" :style="{'margin-top':item.params.menuMarginTop}">

															<div class="picicon" :class="meun.bgClass" :style="{'height':item.params.menuHeightWidth,'width':item.params.menuHeightWidth,'margin-bottom':item.params.menuMarginBottom}">

																<span :class="meun.iconClass"><i class="wlIcon" :class="meun.icon" :style="{'font-size':item.params.menuIconSize}"></i></span>

															</div>

															<div :style="{'font-size':item.params.menuTextSize}">{{meun.text}}</div>

														</div>

													</div>

												</div>

												<!-- 公告栏 -->

												<div class="notice" v-if="item.type == 'notice'" :style="item.style">

													<i class="wlIcon wlIcon-notice margin-right-xs" v-if="item.params.show"></i><span>{{item.data[0].content}}</span>

												</div>

												<!-- 文章组件 -->

												<div class="article" v-if="item.type == 'article'" :style="item.style">

													<div class="item" v-for="article in item.data">

														<div class="image">

															<img :src="cdnurl(article.image)" >

														</div>

														<div class="article-content">

															<div class="title">

																{{article.articleTitle ? article.articleTitle : '右側のアクションバーをクリックして記事を選択してください'}}

															</div>

															<div class="operate">

																<span v-if="item.params.showTime == 'true'">2020年5月30日20:53</span>

																<span v-if="item.params.showView == 'true'">ブラウズ：100</span>

															</div>

														</div>

													</div>

												</div>

												<!-- 头条组件 -->

												<div class="headlines" v-if="item.type == 'headlines'" :style="item.style">

													<div class="margin-lr-bj">

														<i class="wlIcon wlIcon-toutiao"></i>

													</div>

													<div class="swiper">

														<div class="list padding-tb-xs">

															<div class="text-sm">

																<div class="cu-tag sm radius bg-gradual-red margin-right-xs">人気</div>

																..ユーザー端末は、バックグラウンドのヘッドラインデータを自動的に取得します..

															</div>

															<div class="text-sm">

																<div class="cu-tag sm radius bg-gradual-red margin-right-xs">人気</div>

																..ユーザー端末は、バックグラウンドのヘッドラインデータを自動的に取得します.. 

															</div>

														</div>

														<div class="pic">

															<img :src="cdnurl(item.data[0].image)" >

														</div>

													</div>

												</div>

												<!-- 搜索栏 -->

												<div class="search" v-if="item.type == 'search'" :style="item.style">

													<div :style="{'border-radius':item.params.searchRadius,'background':item.params.searchBackground,'padding':item.params.searchPadding}">

														<i class="wlIcon wlIcon-sousuo margin-right-xs"></i><span>{{item.data[0].content}}</span>

													</div>

												</div>

												<!-- 活动橱窗 -->

												<div class="category" v-if="item.type == 'activity'" :style="item.style">

													<div class="cu-list grid col-2-2_1">

														<div class="cu-item" v-for="(act, index) in item.data" :key="index">

															<div class="name">

																<span class="text-lg" :class="act.textColor">{{getParameter(act.activity)}}</span>

																<div v-if="act.tags" class="cu-tag round sm wanl-bg-orange"> 

																	<span class="wlIcon wlIcon-dot"></span>{{act.tags}}

																</div>

															</div>

															<div v-if="act.describe" class="wanl-gray">{{act.describe}}</div>

															<div class="goods margin-top-bj">

																<div v-for="image in getListNum('col-2-2_1', index)">

																	<img src="/assets/addons/wanlshop/img/common/img_default3x.png">

																</div>

															</div>

														</div>

													</div>

												</div>

												<!-- 分类橱窗 -->

												<div class="category" v-if="item.type == 'classify'" :style="item.style">

													<div class="cu-list grid" :class="item.params.colStyle">

														<div class="cu-item" v-for="(cat, index) in item.data" :key="index">

															<div class="name">

																<span class="text-lg" :class="cat.textColor">{{categoryName(cat.categoryId)}}</span>

																<div v-if="cat.tags" class="cu-tag round sm wanl-bg-orange">

																	<span class="wlIcon wlIcon-dot"></span>{{cat.tags}}

																</div>

															</div>

															<div v-if="cat.describe" class="wanl-gray">{{cat.describe}}</div>

															<div class="goods margin-top-bj">

																<div v-for="image in getListNum(item.params.colStyle, index)">

																	<img src="/assets/addons/wanlshop/img/common/img_default3x.png">

																</div>

															</div>

														</div>

													</div>

												</div>

												<!-- 类目标题 -->

												<div class="categoryTitle" v-if="item.type == 'categoryTitle'" :style="item.style">

													<div class="text-lg"> <span class="wlIcon margin-right-xs" :class="item.data[0].icon"></span>

														{{item.data[0].categoryName}} ···</div>

													<div class="text-sm wanl-gray">更多 <span class="wlIcon wlIcon-fanhui2 margin-left-xs"></span> </div>

												</div>

												<!-- 猜你喜欢 -->

												<div class="product" v-if="item.type == 'likes'" :style="item.style" :class="'col-'+ item.params.colthree +'-'+item.params.colmargin" >

													<div class="item">

														<div class="item_pic">

															<img src="/assets/addons/wanlshop/img/common/img_default3x.png">

														</div>

														<div class="item_list padding-bj">

															<div class="margin-bottom-xs">

																<div class="text-df text-cut-2">自動取得…自動取得…自動取得…</div>

																<div class="wanl-orange text-price text-lg">199</div>

															</div>

															<div>

																<div class="text-xs wanl-gray">

																	<span class="margin-right-sm">100+コメント</span> <span>100%有利なレート</span>

																</div>

															</div>

														</div>

													</div>



													<div class="item">

														<div class="item_pic">

															<img src="/assets/addons/wanlshop/img/common/img_default3x.png">

														</div>

														<div class="item_list padding-bj">

															<div class="margin-bottom-xs">

																<div class="text-df text-cut-2">自動取得…自動取得…自動取得…</div>

																<div class="wanl-orange text-price text-lg">199</div>

															</div>

															<div>

																<div class="text-xs wanl-gray">

																	<span class="margin-right-sm">100+コメント</span> <span>100%有利なレート</span>

																</div>

															</div>

														</div>

													</div>

												</div>

												<!-- 商品组件 -->

												<div class="product" v-if="item.type == 'goods'" :style="item.style" :class="'col-'+ item.params.colthree +'-'+item.params.colmargin" >

													<div class="item" v-for="goods in item.data">

														<div class="item_pic">

															<img src="/assets/addons/wanlshop/img/common/img_default3x.png">

														</div>

														<div class="item_list padding-bj">

															<div class="margin-bottom-xs">

																<div class="text-df text-cut-2">タイトルタイトルタイトルタイトルタイトルタイトルタイトルタイトルタイトルタイトルタイトルタイトルタイトルタイトルタイトル</div>

																<div class="wanl-orange text-price text-lg">199</div>

															</div>

															<div class="">

																<div class="margin-bottom-xs">

																	<div class="cu-tag sm round bg-gradual-red">新製品</div>

																	<div class="cu-tag sm round bg-white">クーポン66マイナス6を取得</div>

																</div>

																<div class="text-xs wanl-gray">

																	<span class="margin-right-sm">100+コメント</span> <span>100%有利なレート</span>

																</div>

															</div>

														</div>

													</div>

												</div>

												<!-- 砍价组件 -->

												<div class="bargain" v-if="item.type == 'bargain'" :style="item.style">

													<span>交渉コンポーネント-次のバージョンがリリースされますので、ご期待ください</span>

												</div>

												<!-- 秒杀组件 -->

												<div class="seckill" v-if="item.type == 'seckill'" :style="item.style">

													<span>スパイクコンポーネント-次のバージョンがリリースされますので、ご期待ください</span>

												</div>

												<!-- 搜索栏 -->

												<div class="empty" v-if="item.type == 'empty'" :style="item.style">

												</div>

												<!-- 分隔符 -->

												<div class="division" v-if="item.type == 'division'" :style="item.style">

													<div class="line" :style="{'width':item.params.lineWidth,'height':item.params.lineHeight,'background':item.params.lineBackground}"></div>

													<div class="linetext" :style="{'color':item.params.lineTextColor,'font-size':item.params.lineTextSize,'line-height':item.params.lineTextSize,'background':item.params.lineTextBackground,'padding':item.params.lineTextPadding}">

														{{item.params.lineText}}

													</div>

												</div>

												<div class="sub-del" @click="delModule(index)"><i class="wlIcon wlIcon-31guanbi"></i></div>

											</div>

										</wanldraggable>

									</div>

								</div>

								<div class="template">

									<div class="template-title">

										<span><i></i>カスタムコンポーネント</span>

										<!-- <span>更多 <span class="wlIcon wlIcon-fanhuigengduo"></span></span> -->

									</div>

									<div class="control">

										<!-- 模板分组 -->

										<div class="element" v-for="(item,index) in module" :key="index">

											<div class="element-name"> {{getParameter(index)}}</div>

											<div class="element-row">

												<div v-for="element in item" @click="addTemplate(element)">

													<i class="wlIcon" :class="'wlIcon-'+element.type"></i>

													<span>{{element.name}}</span>

												</div>

											</div>

										</div>

									</div>

								</div>

							</div>

						</div>

						<!-- 编辑器 -->

						<div class="editor">

							<div class="bs-example bs-example-tabs" v-if="type == 'page'">

								<ul class="nav nav-tabs" role="tablist">

									<li class="active"><a href="#home" data-toggle="tab" aria-expanded="true">ページ構成</a></li>

								</ul>

								<div class="tab-content">

									<div class="tab-pane fade active in" id="home">

										<p class="bg-info text-info"><strong>スキル：</strong>モジュールをクリックした後、このページが見つかりません。左側のナビゲーションバーをクリックして戻ります。！</p>

										<div class="form-group">

											<label>ページ名:</label>

											<input type="text" class="form-control" v-model="pageData.name">

										</div>

										<div class="form-group">

											<label>ナビゲーション列ヘッダー:</label>

											<input type="text" class="form-control" v-model="pageData.page.params.navigationBarTitleText">

										</div>

										

										<h5 class="page-header"></h5>

										<div class="form-group">

											<label>ナビゲーションバーの背景画像:</label>

											<div class="wanl-upload">

												<input class="form-control" type="text" v-model="pageData.page.style.navigationBackgroundImage">

												<input type="file" id="navigationBackground" accept="image/*" @change="changeImage($event,'navigationBackgroundImage')" style="display:none" >

												<label for="navigationBackground" class="btn btn-info">

													<i class="fa fa-upload"></i> アップロード

												</label>

											</div>

										</div>

										<div class="form-group">

											<label>ナビゲーションバーの背景:</label>

											<div class="form-inline">

												<input type="text" class="form-control" v-model="pageData.page.style.navigationBarBackgroundColor"> <input

												 id="color" class="form-control" type="color" v-model="pageData.page.style.navigationBarBackgroundColor">

											</div>

										</div>

										<div class="form-group">

											<label>ナビゲーションの前景色:</label>

											<select class="form-control" v-model="pageData.page.style.navigationBarTextStyle">

												<option value="#ffffff">淡い色（白）</option>

												<option value="#000000">ダーク（黒）</option>

											</select>

										</div>

										<h5 class="page-header"></h5>

										<div class="form-group">

											<label>ページの背景画像:</label>

											<div class="wanl-upload">

												<input class="form-control" type="text" v-model="pageData.page.style.pageBackgroundImage">

												<input type="file" id="pageBackground" accept="image/*" @change="changeImage($event,'pageBackgroundImage')" style="display:none" >

												<label for="pageBackground" class="btn btn-info">

													<i class="fa fa-upload"></i> アップロード

												</label>

											</div>

										</div>

										<div class="form-group">

											<label>ページの背景:</label>

											<div class="form-inline">

												<input type="text" class="form-control" v-model="pageData.page.style.pageBackgroundColor"> 

												<input id="color" class="form-control" type="color" v-model="pageData.page.style.pageBackgroundColor">

											</div>

										</div>

										<div class="form-group">

											<label>繰り返される背景:</label>

											<select class="form-control" v-model="pageData.page.style.pageBackgroundRepeat">

												<option value="#ffffff">繰り返す</option>

												<option value="#000000">繰り返さない</option>

											</select>

										</div>

									</div>

								</div>

							</div>

							

							<!-- 组件 -->

							<div class="bs-example bs-example-tabs module-example" v-for="(item,index) in pageData.item" :key="index" v-if="type == index">

								<ul class="nav nav-tabs" role="tablist">

									<li class="active"><a href="#home" data-toggle="tab" aria-expanded="true">{{item.name}}データ</a></li>

									<li v-if="item.params !== undefined"><a href="#params" data-toggle="tab" aria-expanded="false">構成パラメーター</a></li>

									<li><a href="#style" data-toggle="tab" aria-expanded="false">CSSスタイル</a></li>

								</ul>

								<div class="tab-content">

									<!-- 组件首页 -->

									<div class="tab-pane fade active in" id="home">

										<div class="add-data" @click="addData(index,item.data[0])">

											<a class="btn btn-sm btn-info btn-append"><i class="fa fa-plus"></i> データを追加する</a>

										</div>

										<p class="bg-info text-info"><strong>注意：</strong>データを追加するかどうかはご自身で判断してください。単一の画像などの単一のデータは無効です。！</p>

										<div class="panel-group" id="accordion" role="tablist" aria-multiselectable="true">

											<div class="panel panel-default" v-for="(lists,num) in item.data" :key="num">

												<div class="panel-heading" role="tab" :id="'heading-'+num">

													<h4 class="panel-title" role="button" data-toggle="collapse" data-parent="#accordion" :href="'#collapse-'+num" :aria-expanded="num==0?true:false" :aria-controls="'collapse-'+num">

														{{item.name}} <strong>#{{num+1}}</strong>

													</h4>

													<span @click="delData(index,num)"><i class="wlIcon wlIcon-31guanbi"></i></span> 

												</div>

												<div :id="'collapse-'+num" class="panel-collapse collapse" :class="num==0?'in':''" role="tabpanel" :aria-labelledby="'heading-'+num">

													<div class="panel-body">

														<div v-for="(datas,type) in lists" :key="type">

															<!-- 图片上传组件 -->

															<div class="form-group" v-if="type == 'image'">

																<label>画像:</label>

																<div class="wanl-upload">

																	<input class="form-control" type="text" v-model="lists[type]"  placeholder="写真をアップロードするには、右側の[アップロード]をクリックします">

																	<input type="file" :id="type+index+num" accept="image/*" @change="dataUpload($event,index,num,type)" :ref="type+index+num" style="display: none;">

																	<label :for="type+index+num" class="btn btn-info">

																		<i class="fa fa-upload"></i> アップロード

																	</label>

																</div>

																<ul class="row list-inline plupload-preview">

																	<li class="col-xs-3">

																		<a class="thumbnail"><img :src="cdnurl(lists[type])" class="img-responsive"></a>

																	</li>

																</ul>

															</div>

															<!-- 提示 -->

															<div class="tips" v-else-if="type == 'tips'">

																{{datas}}

															</div>

															<!-- 提示2 -->

															<div class="title form-group" v-else-if="type == 'title'">

																<span class="text-green">{{datas}}</span>

															</div>

															<!-- icon颜色 -->

															<div class="form-group" v-else-if="type == 'iconClass'">

																<label>アイコンの色:</label>

																<select class="form-control" v-model="lists[type]">

																	<option value="text-white">白い</option>

																	<option value="wanl-black">ピュアブラック</option>

																	<option value="wanl-pip">スタンダードブラック</option>

																	<option value="wanl-gray-dark">暗灰色</option>

																	<option value="wanl-gray-light">ライトグレー</option>

																	<option value="wanl-text-white">白（グラデーション）</option>

																	<option value="wanl-orange">オレンジ</option>

																	<option value="wanl-red">赤</option>

																	<option value="text-yellow">黄</option>

																	<option value="text-green">緑</option>

																	<option value="text-blue">ブルー</option>

																	<option value="text-olive">アーミーグリーン</option>

																	<option value="text-cyan">青</option>

																	<option value="text-purple">紫の</option>

																	<option value="text-mauve">ヤン・ズー</option>

																	<option value="text-pink">ピンク</option>

																	<option value="text-brown">褐色</option>

																	<option value="wanl-text-red">赤（グラデーション）</option>

																	<option value="wanl-text-yellow">黄（グラデーション）</option>

																	<option value="wanl-text-orange">オレンジ（グラデーション）</option>

																	<option value="wanl-text-violet">バイオレット（グラデーション）</option>

																	<option value="wanl-text-blue">ブルー（グラデーション）</option>

																	<option value="wanl-text-light-blue">浅ブルー（グラデーション）</option>

																	<option value="wanl-text-pink">ピンク（グラデーション）</option>

																	<option value="wanl-text-green">緑（グラデーション）</option>

																	<option value="wanl-text-purple">紫の（グラデーション）</option>

																</select>

															</div>

															<!-- 背景样式下拉 -->

															<div class="form-group" v-else-if="type == 'bgClass'">

																<label>バックグラウンド:</label>

																<select class="form-control" v-model="lists[type]">

																	<option value="wanl-bg-transparent">透明（无）</option>

																	<option value="bg-white">白色</option>

																	<option value="wanl-bg-redorange">橘赤（グラデーション）</option>

																	<option value="wanl-bg-orange">オレンジ（グラデーション）</option>

																	<option value="wanl-bg-pink">ピンク（グラデーション）</option>

																	<option value="wanl-bg-blue">ブルー（グラデーション）</option>

																	<option value="bg-gradual-yellow">黄（グラデーション）</option>

																	<option value="bg-gradual-red">洋红（グラデーション）</option>

																	<option value="bg-gradual-orange">黄橙（グラデーション）</option>

																	<option value="bg-gradual-green">草绿（グラデーション）</option>

																	<option value="bg-gradual-purple">紫の（グラデーション）</option>

																	<option value="bg-gradual-pink">ヤン・ズー（グラデーション）</option>

																	<option value="bg-gradual-blue">蓝绿（グラデーション）</option>

																	<option value="bg-red">赤</option>

																	<option value="bg-orange">オレンジ</option>

																	<option value="bg-yellow">黄</option>

																	<option value="bg-olive">アーミーグリーン</option>

																	<option value="bg-green">緑</option>

																	<option value="bg-cyan">青</option>

																	<option value="bg-blue">ブルー</option>

																	<option value="bg-purple">インクパープル</option>

																	<option value="bg-mauve">ヤン・ズー</option>

																	<option value="bg-pink">ピンク</option>

																	<option value="bg-brown">褐色</option>

																</select>

															</div>

															<!-- 链接地址 -->

															<div class="form-group" v-else-if="type == 'link'">

																<h5 class="page-header"></h5>

																<label>リンクアドレス:</label>

																<div class="wanl-upload">

																	<input type="text" class="form-control" v-model="lists[type]" placeholder="右側の選択ボタンをクリックしてリンクを選択します">

																	<button @click="obtainLink(index,num,type,'false')" class="btn btn-primary wanl-link"><i class="fa fa-link"></i> 選択する </button>

																</div>

															</div>

															<!-- 类目链接 -->

															<div class="form-group" v-else-if="type == 'categoryLink'">

																<h5 class="page-header"></h5>

																<label>カテゴリリンク:</label>

																<div class="wanl-upload">

																	<input type="text" class="form-control" v-model="lists[type]" placeholder="右側の選択ボタンをクリックして、カテゴリIDを選択します">

																	<button @click="categoryLink(index, num, 'false')" class="btn btn-primary wanl-link"><i class="fa fa-link"></i> 選択する </button>

																</div>

															</div>

															<!-- 视频地址 -->

															<div class="form-group" v-else-if="type == 'video'">

																<h5 class="page-header"></h5>

																<label>ビデオを選択:</label>

																<div class="wanl-upload">

																	<input type="text" class="form-control" v-model="lists[type]" placeholder="右側の選択ボタンをクリックしてリンクを選択します">

																	<button @click="attachmentLink(index,num,type,'false')" class="btn btn-primary wanl-link"><i class="fa fa-list"></i> 選択する </button>

																</div>

															</div>

															<!-- icon类名 -->

															<div class="form-group" v-else-if="type == 'icon'">

																<label>アイコンクラス名:</label>

																<div class="wanl-upload">

																	<input type="text" class="form-control" v-model="lists[type]" placeholder="右側の選択ボタンをクリックしてアイコンを選択します">

																	<button @click="iconLink(index, num, type, 'false')" class="btn btn-info wanl-link"><i class="fa fa-bars"></i> 選択する </button>

																</div>

															</div>

															<!-- 商品链接 -->

															<div class="form-group" v-else-if="type == 'goodsLink'">

																<label>商品:</label>

																<div class="wanl-upload">

																	<input type="text" class="form-control" v-model="lists[type]" placeholder="右側の選択ボタンをクリックして、製品IDを選択します">

																	<button @click="goodsLink(index,num,type,'false')" class="btn btn-info wanl-link"><i class="fa fa-bars"></i> 選択する </button>

																</div>

															</div>

															

															<!-- 类目名 -->

															<div class="form-group" v-else-if="type == 'categoryName'">

																<label>種別名:</label>

																<input type="text" class="form-control" v-model="lists[type]" disabled />

															</div>

															<!-- 内容 -->

															<div class="form-group" v-else-if="type == 'content'">

																<label>コンテンツ:</label>

																<input type="text" class="form-control" v-model="lists[type]" placeholder="コンテンツを入力してください">

															</div>

															

															<!-- 活动类型 -->

															<div class="form-group" v-else-if="type == 'activity'">

																<label>活動の種類:</label>

																<select class="form-control" v-model="lists[type]">

																	<option value="distribution">分布</option>

																	<option value="group">共同購入して参加する</option>

																	<option value="bargain">バーゲン</option>

																	<option value="rush">期間限定購入</option>

																	<option value="coupon">クーポンセンター</option>

																</select>

															</div>

															<!-- 字体颜色 -->

															<div class="form-group" v-else-if="type == 'textColor'">

																<label>フォントの色:</label>

																<select class="form-control" v-model="lists[type]">

																	<option value="wanl-black">黒</option>

																	<option value="wanl-pip">スタンダードブラック</option>

																	<option value="wanl-orange">オレンジ</option>

																	<option value="wanl-red">ワンリアンレッド</option>

																	<option value="text-red">赤</option>

																	<option value="text-yellow">黄</option>

																	<option value="text-green">緑</option>

																	<option value="text-blue">ブルー</option>

																	<option value="text-olive">アーミーグリーン</option>

																	<option value="text-cyan">青</option>

																	<option value="text-purple">紫の</option>

																	<option value="text-mauve">ヤン・ズー</option>

																	<option value="text-pink">ピンク</option>

																	<option value="text-brown">褐色</option>

																	<option value="wanl-gray-dark">暗灰色</option>

																	<option value="wanl-gray-light">ライトグレー</option>

																</select>

															</div>

															<!-- 类目 -->

															<div class="form-group" v-else-if="type == 'categoryId'">

																<label>カテゴリを選択:</label>

																<select class="form-control" v-model="lists[type]">

																	<option v-for="cate in pageCategory" :value ="cate.id">{{mergeSpace(cate.spacer)}} {{cate.name}}</option>

																</select>

															</div>

															<!-- 普通表单 -->

															<div class="form-group" v-else>

																<label>{{getParameter(type)}}:</label>

																<input type="text" class="form-control" v-model="lists[type]" :placeholder="'入ってください' + getParameter(type)">

															</div>

														</div>

													</div>

												</div>

											</div>

										</div>

									</div>

									<!-- 组件参数 -->

									<div class="tab-pane fade" id="params">

										<p class="bg-warning text-warning"><strong>促す：</strong>パラメータに「pxunit」がある場合は、削除せず、pxのみにすることができます（クライアントは自動的にアダプティブrpxに変換されます）</p>

										<div class="form-group" v-for="(params,type) in item.params" :key="type">

											<!-- 指示器样式 -->

											<div v-if="type == 'banstyle'">

												<label>インジケータースタイル:</label>

												<select class="form-control" v-model="item.params[type]">

													<option value="1">丸い形</option>

													<option value="2">矩形</option>

												</select>

											</div>

											<!-- 布局方式 -->

											<div v-else-if="type == 'colStyle'">

												<label>レイアウト:</label>

												<select class="form-control" v-model="item.params[type]">

													<option value="col-1-2-2">1-2-2レイアウト</option>

													<option value="col-1-1_2">1-1_2レイアウト</option>

													<option value="col-2-1_2">2-1_2レイアウト</option>

													<option value="col-2-2_1">2-2_1レイアウト</option>

													<option value="col-2-2-1_2">2-2-1_2レイアウト</option>

													<option value="col-2-4">2-4レイアウト</option>

													<option value="col-2-2-4">2-2-4レイアウト</option>

												</select>

											</div>

											<!-- 每行数量 -->

											<div v-else-if="type == 'colthree'">

												<label>1行あたりの数:</label>

												<select class="form-control" v-model="item.params[type]">

													<option value="1">各行 1 カラム</option>

													<option value="2">各行 2 カラム</option>

													<option value="3">各行 3 カラム</option>

												</select>

											</div>

											<!-- 每行数量 -->

											<div v-else-if="type == 'colfive'">

												<label>1行あたりの数:</label>

												<select class="form-control" v-model="item.params[type]">

													<option value="1">各行 1 カラム</option>

													<option value="2">各行 2 カラム</option>

													<option value="3">各行 3 カラム</option>

													<option value="4">各行 4 カラム</option>

													<option value="5">各行 5 カラム</option>

												</select>

											</div>

											<!-- 列边距 -->

											<div v-else-if="type == 'colmargin'">

												<label>マージン:</label>

												<select class="form-control" v-model="item.params[type]">

													<option value="10">5ピクセル（10rpx）</option>

													<option value="15">7.5ピクセル（15rpx）</option>

													<option value="20">10ピクセル（20rpx）</option>

													<option value="25">12.5ピクセル（25rpx）</option>

													<option value="30">15ピクセル（30rpx）</option>

												</select>

											</div>

											<!-- 判断开关 -->

											<div v-else-if="type == 'show'">

												<label>通知バーアイコン:</label>

												<select class="form-control" v-model="item.params[type]">

													<option value="true">表示</option>

													<option value="">見せないで</option>

												</select>

											</div>

											<div v-else-if="type == 'showTime'">

												<label>記事の日付:</label>

												<select class="form-control" v-model="item.params[type]">

													<option value="true">表示</option>

													<option value="false">見せないで</option>

												</select>

											</div>

											<div v-else-if="type == 'showView'">

												<label>ビュー:</label>

												<select class="form-control" v-model="item.params[type]">

													<option value="true">表示</option>

													<option value="false">見せないで</option>

												</select>

											</div>

											<!-- 搜索颜色选项 -->

											<div class="form-inline" v-else-if="type == 'searchBackground'">

												<label>検索バーの背景:</label>

												<input type="text" class="form-control" v-model="item.params[type]"> <input id="color" class="form-control"

												 type="color" v-model="item.params[type]">

											</div>

											<!-- 线段颜色 -->

											<div class="form-inline" v-else-if="type == 'lineBackground'">

												<label>線の色:</label>

												<input type="text" class="form-control" v-model="item.params[type]"> <input id="color" class="form-control"

												 type="color" v-model="item.params[type]">

											</div>

											<!-- 分隔字体颜色 -->

											<div class="form-inline" v-else-if="type == 'lineTextColor'">

												<label>フォントの色:</label>

												<input type="text" class="form-control" v-model="item.params[type]"> <input id="color" class="form-control"

												 type="color" v-model="item.params[type]">

											</div>

											<!-- 分隔字体背景颜色选项 -->

											<div class="form-inline" v-else-if="type == 'lineTextBackground'">

												<label>フォントの背景色:</label>

												<input type="text" class="form-control" v-model="item.params[type]"> <input id="color" class="form-control"

												 type="color" v-model="item.params[type]">

											</div>

											<!-- 默认表单 -->

											<div v-else>

												<label>{{getParameter(type)}}:</label>

												<input type="text" class="form-control" v-model="item.params[type]">

											</div>

										</div>

									</div>

									<!-- 组件样式 -->

									<div class="tab-pane fade" id="style">

										<p class="bg-danger text-danger"><strong>促す：</strong>このアイテムを操作するには、フロントエンドCSSの基本を習得する必要があります。フロントエンドを知らない学生の場合は、デフォルトのスタイルを維持してください。スタイルを追加/変更することはお勧めしません。</p>

										<div class="form-group" v-for="(styles,type) in item.style" :key="type">

											<label>

												<div>{{type}} {{moduleStyle[type].name}}:</div>

												<div class="del" @click="delStyle(index,type)"><i class="wlIcon wlIcon-31guanbi"></i></div>

											</label>

											<div class="form-inline" v-if="type == 'color' || type == 'background-color'">

												<input type="text" class="form-control" v-model="item.style[type]"> <input id="color" class="form-control"

												 type="color" v-model="item.style[type]">

											</div>

											<div v-else>

												<input type="text" class="form-control" v-model="item.style[type]">

											</div>

										</div>

										<div class="dropdown">

											<a class="btn btn-sm btn-success btn-append" data-target="#" data-toggle="dropdown" role="button"

											 aria-haspopup="true" aria-expanded="false"><i class="fa fa-plus"></i> 新しいスタイルを追加する</a>

											<ul class="dropdown-menu">

												<li v-for="(item,type) in moduleStyle" :key="type">

													<a @click="addStyle(index,type,item.default)">{{item.name}}</a>

												</li>

											</ul>

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


							</div>

						</div>

					</div>

				</div>

			</div>

		</div>

		<script src="/assets/js/require.min.js" data-main="/assets/js/require-wanlshop.min.js?v=<?php echo htmlentities($site['version']); ?>"></script>

	</body>

	<?php endif; ?>



</html>
