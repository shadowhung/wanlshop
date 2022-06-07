<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:89:"/www/wwwroot/www.fdadeal.com/public/../application/index/view/wanlshop/console/index.html";i:1632440578;s:72:"/www/wwwroot/www.fdadeal.com/application/index/view/layout/wanlshop.html";i:1636510733;}*/ ?>
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

											

<style type="text/css">
    .sm-st {
        background: #fff;
        padding: 20px;
        -webkit-border-radius: 3px;
        -moz-border-radius: 3px;
        border-radius: 3px;
        margin-bottom: 20px;
        -webkit-box-shadow: 0 1px 0px rgba(0, 0, 0, 0.05);
        box-shadow: 0 1px 0px rgba(0, 0, 0, 0.05);
    }

    .sm-st-icon {
        width: 60px;
        height: 60px;
        display: inline-block;
        line-height: 60px;
        text-align: center;
        font-size: 30px;
        background: #eee;
        -webkit-border-radius: 5px;
        -moz-border-radius: 5px;
        border-radius: 5px;
        float: left;
        margin-right: 10px;
        color: #fff;
    }

    .sm-st-info {
        font-size: 12px;
        padding-top: 2px;
    }

    .sm-st-info span {
        display: block;
        font-size: 24px;
        font-weight: 600;
    }

    .orange {
        background: #fa8564 !important;
    }

    .tar {
        background: #45cf95 !important;
    }

    .sm-st .green {
        background: #86ba41 !important;
    }

    .pink {
        background: #AC75F0 !important;
    }

    .yellow-b {
        background: #fdd752 !important;
    }

    .stat-elem {

        background-color: #fff;
        padding: 18px;
        border-radius: 40px;

    }

    .stat-info {
        text-align: center;
        background-color: #fff;
        border-radius: 5px;
        margin-top: -5px;
        padding: 8px;
        -webkit-box-shadow: 0 1px 0px rgba(0, 0, 0, 0.05);
        box-shadow: 0 1px 0px rgba(0, 0, 0, 0.05);
        font-style: italic;
    }

    .stat-icon {
        text-align: center;
        margin-bottom: 5px;
    }

    .st-red {
        background-color: #F05050;
    }

    .st-green {
        background-color: #27C24C;
    }

    .st-violet {
        background-color: #7266ba;
    }
    
    .st-violet2 {
        background-color: #66b8ba;
    }

    .st-blue {
        background-color: #23b7e5;
    }

    .stats .stat-icon {
        color: #28bb9c;
        display: inline-block;
        font-size: 26px;
        text-align: center;
        vertical-align: middle;
        width: 50px;
        float: left;
    }

    .stat {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        display: inline-block;
        margin-right: 10px;
    }

    .stat .value {
        font-size: 20px;
        line-height: 24px;
        overflow: hidden;
        text-overflow: ellipsis;
        font-weight: 500;
    }

    .stat .name {
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .stat.lg .value {
        font-size: 26px;
        line-height: 28px;
    }

    .stat.lg .name {
        font-size: 16px;
    }

    .stat-col .progress {
        height: 2px;
    }

    .stat-col .progress-bar {
        line-height: 2px;
        height: 2px;
    }

</style>
<div class="panel panel-default panel-intro">
    <div class="panel-heading">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#one" data-toggle="tab"><?php echo __('Dashboard'); ?></a></li>
        </ul>
    </div>
    <div class="panel-body">
        <div id="myTabContent" class="tab-content">
            <div class="tab-pane fade active in" id="one">

                <div class="row">
                    <div class="col-sm-2 col-xs-6">
                        <div class="sm-st clearfix">
                            <span class="sm-st-icon st-red"><i class="fa fa-users"></i></span>
                            <div class="sm-st-info">
                                <span><?php echo $totaluser; ?></span>
                                <?php echo __('Total user'); ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-2 col-xs-6">
                        <div class="sm-st clearfix">
                            <span class="sm-st-icon st-violet"><i class="fa fa-book"></i></span>
                            <div class="sm-st-info">
                                <span><?php $hour = date("H",time());
                                $result = 0;
                                if($hour>0&&$hour<=6){
                                    $result = $totaluser*0+$totalviews;
                                }
                                if($hour>6&&$hour<=24){
                                    $result = $totaluser*($hour-6)+$totalviews;
                                }
                                echo $result;
                                ?></span>
                                <!--<?php echo $totaluser*3+$totalviews*3; ?>-->
                                今日<?php echo __('Total view'); ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-2 col-xs-6">
                        <div class="sm-st clearfix">
                            <span class="sm-st-icon st-violet2"><i class="fa fa-book"></i></span>
                            <div class="sm-st-info">
                                <span><?php $hour = date("H",time());
                                if($hour>0&&$hour<=12){
                                    echo $result*2+$totalviews;
                                }
                                if($hour>12&&$hour<=24){
                                    echo $result*3+$totalviews;
                                }
                                ?></span>
                                <!--<?php echo $totaluser*9+$totalviews*9; ?>-->
                                今日<?php echo __('Total page'); ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-2 col-xs-6">
                        <div class="sm-st clearfix">
                            <span class="sm-st-icon st-blue"><i class="fa fa-shopping-bag"></i></span>
                            <div class="sm-st-info">
                                <span><?php echo $totalorder; ?></span>
                                <?php echo __('Total order'); ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-2 col-xs-6">
                        <div class="sm-st clearfix">
                            <span class="sm-st-icon st-green">円</span>
                            <div class="sm-st-info">
                                <span><?php echo $totalorderamount; ?></span>
                                <?php echo __('Total order amount'); ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-8">
                        <div id="echart" class="btn-refresh" style="height:200px;width:100%;"></div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card sameheight-item stats">
                            <div class="card-block">
                                <div class="row row-sm stats-container">
                                    <div class="col-xs-6 stat-col">
                                        <div class="stat-icon"><i class="fa fa-rocket"></i></div>
                                        <div class="stat">
                                            <div class="value"> <?php echo $todayusersignup; ?></div>
                                            <div class="name"> <?php echo __('Today user signup'); ?></div>
                                        </div>
                                        <div class="progress">
                                            <div class="progress-bar progress-bar-success" style="width: 30%"></div>
                                        </div>
                                    </div>
                                    <div class="col-xs-6 stat-col">
                                        <div class="stat-icon"><i class="fa fa-shopping-cart"></i></div>
                                        <div class="stat">
                                            <div class="value"> <?php echo $todayuserlogin; ?></div>
                                            <div class="name"> <?php echo __('ショッピングカートを追加する'); ?></div>
                                        </div>
                                        <div class="progress">
                                            <div class="progress-bar progress-bar-success" style="width: 25%"></div>
                                        </div>
                                    </div>
                                    <div class="col-xs-6  stat-col">
                                        <div class="stat-icon"><i class="fa fa-line-chart"></i></div>
                                        <div class="stat">
                                            <div class="value"> <?php echo $todayorder; ?></div>
                                            <div class="name"> <?php echo __('Today order'); ?></div>
                                        </div>
                                        <div class="progress">
                                            <div class="progress-bar progress-bar-success" style="width: 25%"></div>
                                        </div>
                                    </div>
                                    <div class="col-xs-6  stat-col">
                                        <div class="stat-icon"><i class="fa fa-users"></i></div>
                                        <div class="stat">
                                            <div class="value"> <?php echo $unsettleorder; ?></div>
                                            <div class="name"> <?php echo __('Unsettle order'); ?></div>
                                        </div>
                                        <div class="progress">
                                            <div class="progress-bar progress-bar-success" style="width: 25%"></div>
                                        </div>
                                    </div>
                                    <div class="col-xs-6  stat-col">
                                        <div class="stat-icon"><i class="fa fa-list-alt"></i></div>
                                        <div class="stat">
                                            <div class="value"> <?php echo $sevendnu; ?></div>
                                            <div class="name"> <?php echo __('Seven dnu'); ?></div>
                                        </div>
                                        <div class="progress">
                                            <div class="progress-bar progress-bar-success" style="width: 25%"></div>
                                        </div>
                                    </div>
                                    <div class="col-xs-6 stat-col">
                                        <div class="stat-icon"><i class="fa fa-dollar"></i></div>
                                        <div class="stat">
                                            <div class="value"> <?php echo $sevendau; ?></div>
                                            <div class="name"> <?php echo __('今日の合計'); ?></div>
                                        </div>
                                        <div class="progress">
                                            <div class="progress-bar progress-bar-success" style="width: 25%"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
				<div class="row" style="height: 100px;">

					

				</div>

			</div>
        </div>
    </div>
</div>
<script>
    var Orderdata = {
        column: <?php echo json_encode(array_keys($paylist)); ?>,
        paydata: <?php echo json_encode(array_values($paylist)); ?>,
        createdata: <?php echo json_encode(array_values($createlist)); ?>,
    };
</script>

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

								

<style type="text/css">
    .sm-st {
        background: #fff;
        padding: 20px;
        -webkit-border-radius: 3px;
        -moz-border-radius: 3px;
        border-radius: 3px;
        margin-bottom: 20px;
        -webkit-box-shadow: 0 1px 0px rgba(0, 0, 0, 0.05);
        box-shadow: 0 1px 0px rgba(0, 0, 0, 0.05);
    }

    .sm-st-icon {
        width: 60px;
        height: 60px;
        display: inline-block;
        line-height: 60px;
        text-align: center;
        font-size: 30px;
        background: #eee;
        -webkit-border-radius: 5px;
        -moz-border-radius: 5px;
        border-radius: 5px;
        float: left;
        margin-right: 10px;
        color: #fff;
    }

    .sm-st-info {
        font-size: 12px;
        padding-top: 2px;
    }

    .sm-st-info span {
        display: block;
        font-size: 24px;
        font-weight: 600;
    }

    .orange {
        background: #fa8564 !important;
    }

    .tar {
        background: #45cf95 !important;
    }

    .sm-st .green {
        background: #86ba41 !important;
    }

    .pink {
        background: #AC75F0 !important;
    }

    .yellow-b {
        background: #fdd752 !important;
    }

    .stat-elem {

        background-color: #fff;
        padding: 18px;
        border-radius: 40px;

    }

    .stat-info {
        text-align: center;
        background-color: #fff;
        border-radius: 5px;
        margin-top: -5px;
        padding: 8px;
        -webkit-box-shadow: 0 1px 0px rgba(0, 0, 0, 0.05);
        box-shadow: 0 1px 0px rgba(0, 0, 0, 0.05);
        font-style: italic;
    }

    .stat-icon {
        text-align: center;
        margin-bottom: 5px;
    }

    .st-red {
        background-color: #F05050;
    }

    .st-green {
        background-color: #27C24C;
    }

    .st-violet {
        background-color: #7266ba;
    }
    
    .st-violet2 {
        background-color: #66b8ba;
    }

    .st-blue {
        background-color: #23b7e5;
    }

    .stats .stat-icon {
        color: #28bb9c;
        display: inline-block;
        font-size: 26px;
        text-align: center;
        vertical-align: middle;
        width: 50px;
        float: left;
    }

    .stat {
        white-space: nowrap;
        overflow: hidden;
        text-overflow: ellipsis;
        display: inline-block;
        margin-right: 10px;
    }

    .stat .value {
        font-size: 20px;
        line-height: 24px;
        overflow: hidden;
        text-overflow: ellipsis;
        font-weight: 500;
    }

    .stat .name {
        overflow: hidden;
        text-overflow: ellipsis;
    }

    .stat.lg .value {
        font-size: 26px;
        line-height: 28px;
    }

    .stat.lg .name {
        font-size: 16px;
    }

    .stat-col .progress {
        height: 2px;
    }

    .stat-col .progress-bar {
        line-height: 2px;
        height: 2px;
    }

</style>
<div class="panel panel-default panel-intro">
    <div class="panel-heading">
        <ul class="nav nav-tabs">
            <li class="active"><a href="#one" data-toggle="tab"><?php echo __('Dashboard'); ?></a></li>
        </ul>
    </div>
    <div class="panel-body">
        <div id="myTabContent" class="tab-content">
            <div class="tab-pane fade active in" id="one">

                <div class="row">
                    <div class="col-sm-2 col-xs-6">
                        <div class="sm-st clearfix">
                            <span class="sm-st-icon st-red"><i class="fa fa-users"></i></span>
                            <div class="sm-st-info">
                                <span><?php echo $totaluser; ?></span>
                                <?php echo __('Total user'); ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-2 col-xs-6">
                        <div class="sm-st clearfix">
                            <span class="sm-st-icon st-violet"><i class="fa fa-book"></i></span>
                            <div class="sm-st-info">
                                <span><?php $hour = date("H",time());
                                $result = 0;
                                if($hour>0&&$hour<=6){
                                    $result = $totaluser*0+$totalviews;
                                }
                                if($hour>6&&$hour<=24){
                                    $result = $totaluser*($hour-6)+$totalviews;
                                }
                                echo $result;
                                ?></span>
                                <!--<?php echo $totaluser*3+$totalviews*3; ?>-->
                                今日<?php echo __('Total view'); ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-2 col-xs-6">
                        <div class="sm-st clearfix">
                            <span class="sm-st-icon st-violet2"><i class="fa fa-book"></i></span>
                            <div class="sm-st-info">
                                <span><?php $hour = date("H",time());
                                if($hour>0&&$hour<=12){
                                    echo $result*2+$totalviews;
                                }
                                if($hour>12&&$hour<=24){
                                    echo $result*3+$totalviews;
                                }
                                ?></span>
                                <!--<?php echo $totaluser*9+$totalviews*9; ?>-->
                                今日<?php echo __('Total page'); ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-2 col-xs-6">
                        <div class="sm-st clearfix">
                            <span class="sm-st-icon st-blue"><i class="fa fa-shopping-bag"></i></span>
                            <div class="sm-st-info">
                                <span><?php echo $totalorder; ?></span>
                                <?php echo __('Total order'); ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-2 col-xs-6">
                        <div class="sm-st clearfix">
                            <span class="sm-st-icon st-green">円</span>
                            <div class="sm-st-info">
                                <span><?php echo $totalorderamount; ?></span>
                                <?php echo __('Total order amount'); ?>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-lg-8">
                        <div id="echart" class="btn-refresh" style="height:200px;width:100%;"></div>
                    </div>
                    <div class="col-lg-4">
                        <div class="card sameheight-item stats">
                            <div class="card-block">
                                <div class="row row-sm stats-container">
                                    <div class="col-xs-6 stat-col">
                                        <div class="stat-icon"><i class="fa fa-rocket"></i></div>
                                        <div class="stat">
                                            <div class="value"> <?php echo $todayusersignup; ?></div>
                                            <div class="name"> <?php echo __('Today user signup'); ?></div>
                                        </div>
                                        <div class="progress">
                                            <div class="progress-bar progress-bar-success" style="width: 30%"></div>
                                        </div>
                                    </div>
                                    <div class="col-xs-6 stat-col">
                                        <div class="stat-icon"><i class="fa fa-shopping-cart"></i></div>
                                        <div class="stat">
                                            <div class="value"> <?php echo $todayuserlogin; ?></div>
                                            <div class="name"> <?php echo __('ショッピングカートを追加する'); ?></div>
                                        </div>
                                        <div class="progress">
                                            <div class="progress-bar progress-bar-success" style="width: 25%"></div>
                                        </div>
                                    </div>
                                    <div class="col-xs-6  stat-col">
                                        <div class="stat-icon"><i class="fa fa-line-chart"></i></div>
                                        <div class="stat">
                                            <div class="value"> <?php echo $todayorder; ?></div>
                                            <div class="name"> <?php echo __('Today order'); ?></div>
                                        </div>
                                        <div class="progress">
                                            <div class="progress-bar progress-bar-success" style="width: 25%"></div>
                                        </div>
                                    </div>
                                    <div class="col-xs-6  stat-col">
                                        <div class="stat-icon"><i class="fa fa-users"></i></div>
                                        <div class="stat">
                                            <div class="value"> <?php echo $unsettleorder; ?></div>
                                            <div class="name"> <?php echo __('Unsettle order'); ?></div>
                                        </div>
                                        <div class="progress">
                                            <div class="progress-bar progress-bar-success" style="width: 25%"></div>
                                        </div>
                                    </div>
                                    <div class="col-xs-6  stat-col">
                                        <div class="stat-icon"><i class="fa fa-list-alt"></i></div>
                                        <div class="stat">
                                            <div class="value"> <?php echo $sevendnu; ?></div>
                                            <div class="name"> <?php echo __('Seven dnu'); ?></div>
                                        </div>
                                        <div class="progress">
                                            <div class="progress-bar progress-bar-success" style="width: 25%"></div>
                                        </div>
                                    </div>
                                    <div class="col-xs-6 stat-col">
                                        <div class="stat-icon"><i class="fa fa-dollar"></i></div>
                                        <div class="stat">
                                            <div class="value"> <?php echo $sevendau; ?></div>
                                            <div class="name"> <?php echo __('今日の合計'); ?></div>
                                        </div>
                                        <div class="progress">
                                            <div class="progress-bar progress-bar-success" style="width: 25%"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
				<div class="row" style="height: 100px;">

					

				</div>

			</div>
        </div>
    </div>
</div>
<script>
    var Orderdata = {
        column: <?php echo json_encode(array_keys($paylist)); ?>,
        paydata: <?php echo json_encode(array_values($paylist)); ?>,
        createdata: <?php echo json_encode(array_values($createlist)); ?>,
    };
</script>

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
