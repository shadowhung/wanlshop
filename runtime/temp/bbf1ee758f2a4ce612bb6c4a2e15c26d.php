<?php if (!defined('THINK_PATH')) exit(); /*a:2:{s:85:"/www/wwwroot/www.fdadeal.com/public/../application/index/view/wanlshop/goods/add.html";i:1632437132;s:72:"/www/wwwroot/www.fdadeal.com/application/index/view/layout/wanlshop.html";i:1636510733;}*/ ?>
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

		/*display: none;*/

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

<div class="alert alert-danger-light">

	<!--<strong>暫不可發佈商品：</strong>-->

	<?php if(in_array(($row['brand']), explode(',',"0"))): ?><p> システムにブランドがありません。【メイン舞台裏】>マルチユーザーモール>商品管理>ブランド管理追加に移動してください。。</p><?php endif; if(in_array(($row['shopsort']), explode(',',"0"))): ?><p> 「ショップカテゴリ」は作成されていません，お願いします <a class="btn-shopsort" href="#">[作成]をクリックします</a>。</p><?php endif; if(in_array(($row['freight']), explode(',',"0"))): ?><p> 尚未創建“運費範本”，お願いします<a class="btn-freight" href="#">[作成]をクリックします<</a>。</p><?php endif; if(empty($row['config']['sendPhoneNum']) || (($row['config']['sendPhoneNum'] instanceof \think\Collection || $row['config']['sendPhoneNum'] instanceof \think\Paginator ) && $row['config']['sendPhoneNum']->isEmpty())): ?><p> まだ完了していません“送信者情報”，お願いします <a class="btn-send" href="#">クリックして記入</a> 送信者情報。</p><?php endif; if(empty($row['config']['returnPhoneNum']) || (($row['config']['returnPhoneNum'] instanceof \think\Collection || $row['config']['returnPhoneNum'] instanceof \think\Paginator ) && $row['config']['returnPhoneNum']->isEmpty())): ?><p> まだ完了していません“返品情報”，お願いします <a class="btn-return" href="#">クリックして記入</a> 返品情報。</p><?php endif; ?>

</div>

<?php endif; ?>

<div class="panel panel-default panel-intro">

	<div class="panel-heading">

		<ul class="nav nav-tabs">

			<li class="active"><a href="#basics">基本情報</a></li>

			<li><a href="#sale">商品属性</a></li>

			<li><a href="#wanlinfo">グラフィックの説明</a></li>

			<li><a href="#payment">支払情報</a></li>

			<li><a href="#logistics">ロジスティクス情報</a></li>

			<li><a href="#service">アフター情報</a></li>

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

										<div class="panel-heading">基本情報</div>

										<div class="panel-body">

											<div class="form-group">

												<label class="control-label col-xs-12 col-sm-2"><?php echo __('Title'); ?>:</label>

												<div class="col-xs-12 col-sm-8">

													<input id="c-title" data-rule="required" class="form-control" name="row[title]" type="text"  placeholder="製品タイトルを入力してください">

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

												<label class="control-label col-xs-12 col-sm-2"><?php echo __('製品ブランド'); ?>:</label>

												<div class="col-xs-12 col-sm-8">

													<input id="c-brand" data-rule="required" value="其他" class="form-control" name="row[brand]" type="text"  placeholder="製品ブランドを入力してください">

												</div>

											</div>

											

											<!--<div class="form-group">

											    <label class="control-label col-xs-12 col-sm-2"><?php echo __('商品品牌'); ?>:</label>

											    <div class="col-xs-12 col-sm-8">

													<div class="input-group">

														<input id="c-brand_id" data-rule="required" 

														data-source="wanlshop/brand/selectpage" 

														class="form-control selectpage" 

														name="row[brand_id]" 

														type="text" placeholder="點擊獲取品牌列表">

														<div class="input-group-addon no-border no-padding">

															<span><button type="button" class="btn btn-danger btn-brand" ><?php echo __('申請品牌'); ?></button></span>

														</div>

													</div>

											    </div>

											</div>-->

											

											

											

											<div class="form-group" v-if="attributeData.length != 0">

												<label class="control-label col-xs-12 col-sm-2"><?php echo __('カテゴリの内容'); ?>:</label>

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

										<div class="panel-heading">商品属性</div>

										<div class="panel-body">

											<div class="form-group wanl-specs">

												<label class="control-label col-xs-12 col-sm-2"><?php echo __('商品属性'); ?>:</label>

												<div class="col-xs-12 col-sm-8">

													<div class="input-group add-option">

														<input type="text" class="form-control" ref="specs-name" placeholder="複数の製品属性はスペースで区切られます">

														<span class="input-group-addon pointer" @click="spuAdd">新しい属性</span>
														
														

													</div>
							
<span style="color:red;">1、製品価格を設定するには、次の1つの属性を入力する必要があります<br/>
2、色、サイズ、仕様の要件がない場合は、右側の対応する属性を削除してください<br/>
3、3番目の仕様は、次のように記入できます：単一製品、XXギフトパッケージ<br/>
4、特別な製品属性要件がある場合は、上記の新しい属性の内容をカスタマイズし、色、サイズ、および仕様の属性を削除できます。</span><br/>
													<div class="panel panel-default" v-for="(item, i) in spu" :key="i">

														<header class="panel-heading">

															<b>{{item}}</b>

															<span class="remove" title="削除する" @click="spuRemove(i)">×</span>

														</header>

														<div class="row">

															<div class="col-md-5 col-sm-5 col-xs-8">

																<div class="input-group">

																	<input type="text" class="form-control" :ref="'specs-name-' + i" placeholder="バリアントはスペースで区切られます">

																	<span class="input-group-addon pointer" @click="skuAdd(i)"><i class="fa fa-plus"></i></span>

																</div>

															</div>

															<div class="col-md-7 col-sm-7 col-xs-7">

																<div class="wanl-specs-tag" v-for="(v, j) in spuItem[i]" :key="j">

																	{{v}}<span class="remove" title="削除する" @click="skuRemove(i, j)">×</span>

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

																		<th width="80">元値</th>

																		<th width="80">現在の価格</th>

																		<th width="80">在庫あり</th>

																		<th width="80">重量(kg)</th>

																		<th width="80">コーディング</th>

																	</tr>

																</thead>

																<tbody>

																	<tr v-for="item in sku">

																		<td v-for="v in item">{{v}}</td>

																		<td width="80"> <input type="number" data-rule="required" name="row[market_price][]" class="input-sm form-control wanl-market_price"> </td>

																		<td width="80"> <input type="number" data-rule="required" name="row[price][]" class="input-sm form-control wanl-price"> </td>

																		<td width="80"><input type="number" data-rule="required" name="row[stocks][]" class="input-sm form-control wanl-stock"></td>

																		<td width="80"><input type="number" name="row[weigh][]" class="input-sm form-control wanl-weigh"></td>

																		<td width="80"><input type="text" name="row[sn][]" class="input-sm form-control wanl-sn"></td>

																	</tr>

																</tbody>

															</table>

															<div @click="skuBatch()">

																<span v-if="batch == 0">

																	バッチで設定しますか？

																</span>

																<span v-else>

																	バッチ設定をキャンセル？

																</span>

															</div>

														</div>

													</div>

							

													<div class="batch" v-show="batch == 1">

														<div class="input-group">

															<div class="input-group-addon">元値 円</div>

															<input type="number" class="form-control" id="batch-market_price" placeholder="ワンクリックで元の価格を設定">

															<div class="input-group-addon" onclick="batchSet('market_price')">バッチ設定</div>

														</div>

														<div class="input-group">

															<div class="input-group-addon">現在の価格 円</div>

															<input type="number" class="form-control" id="batch-price" placeholder="ワンクリックで現在の価格を設定">

															<div class="input-group-addon" onclick="batchSet('price')">バッチ設定</div>

														</div>

														<div class="input-group">

															<div class="input-group-addon">在庫あり</div>

															<input type="number" class="form-control" id="batch-stock" placeholder="ワンクリック在庫設定">

															<div class="input-group-addon" onclick="batchSet('stock')">バッチ設定</div>

														</div>

														<div class="input-group">

															<div class="input-group-addon">重量</div>

															<input type="number" class="form-control" id="batch-weigh" placeholder="体重を設定するための1つの鍵">

															<div class="input-group-addon" onclick="batchSet('weigh')">バッチ設定</div>

														</div>

														<div class="input-group">

															<div class="input-group-addon">コーディング</div>

															<input type="text" class="form-control" id="batch-sn" placeholder="コードを設定するための1つのキー">

															<div class="input-group-addon" onclick="batchSet('sn')">バッチ設定</div>

														</div>

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

									<div class="panel-heading">グラフィックの説明</div>

									<div class="panel-body">

										<div class="form-group">

											<label class="control-label col-xs-12 col-sm-2"><?php echo __('Image'); ?>:</label>

											<div class="col-xs-12 col-sm-8">

												<div class="input-group">

													<input id="c-image" data-rule="required" class="form-control" size="50" name="row[image]" type="text" placeholder="商品のメイン画像をアップロードしてください">

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

													<input id="c-images" data-rule="required" class="form-control" size="50" name="row[images]" type="text" placeholder="製品アルバムをアップロードしてください">

													<div class="input-group-addon no-border no-padding">

														<span><button type="button" id="plupload-images" class="btn btn-danger plupload" data-input-id="c-images" data-mimetype="image/gif,image/jpeg,image/png,image/jpg,image/bmp" data-multiple="true" data-preview-id="p-images"><i class="fa fa-upload"></i> <?php echo __('Upload'); ?></button></span>

														<span><button type="button" id="fachoose-images" class="btn btn-primary fachoose" data-input-id="c-images" data-mimetype="image/*" data-multiple="true"><i class="fa fa-list"></i> <?php echo __('Choose'); ?></button></span>

													</div>

													<span class="msg-box n-right" for="c-images"></span>

												</div>

												<ul class="row list-inline plupload-preview" id="p-images"></ul>

											</div>

										</div>

										<div class="form-group">

										    <label class="control-label col-xs-12 col-sm-2"><?php echo __('Description'); ?>:</label>

										    <div class="col-xs-12 col-sm-8">

										        <input id="c-description" data-rule="required" class="form-control" name="row[description]" type="text" placeholder="製品の説明を入力してください">

										    </div>

										</div>

										<div class="form-group">

											<label class="control-label col-xs-12 col-sm-2"><?php echo __('Content'); ?>:</label>

											<div class="col-xs-12 col-sm-8">

												<textarea id="c-content" data-rule="required" class="form-control editor" rows="5" name="row[content]" cols="50"></textarea>

											</div>

										</div>

										<div class="form-group">

											<label class="control-label col-xs-12 col-sm-2"><?php echo __('ショップのカテゴリー'); ?>:</label>

											<div class="col-xs-12 col-sm-8">

												<div class="input-group">

													<input id="c-shop_category_id" data-rule="required"

													data-source="wanlshop/shopsort"

													data-params='{"isTree":1}'

													data-multiple="true"

													data-pagination="true"

													data-page-size="1"

													class="form-control selectpage"

													name="row[shop_category_id]"

													type="text"

													placeholder="クリックしてストアカテゴリを選択します">

													<div class="input-group-addon no-border no-padding">

														<span><button type="button" class="btn btn-danger btn-shopsort" ><?php echo __('新たなカテゴリー'); ?></button></span>

													</div>

												</div>

											</div>

										</div>

									</div>

								</div>

							</div>

						</div>

						<div class="row" id="payment">

							<div class="col-md-12">

								<div class="panel panel-default">

									<div class="panel-heading">支払情報</div>

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

						<div class="row" id="logistics">

							<div class="col-md-12">

								<div class="panel panel-default">

									<div class="panel-heading">ロジスティクス情報</div>

									<div class="panel-body">

										<div class="form-group">

										    <label class="control-label col-xs-12 col-sm-2"><?php echo __('Freight_id'); ?>:</label>

										    <div class="col-xs-12 col-sm-8">

												<div class="input-group">

													<input id="c-freight_id" data-rule="required" data-source="wanlshop/freight" class="form-control selectpage" name="row[freight_id]" type="text" placeholder="クリックして配送テンプレートを選択します">

													<div class="input-group-addon no-border no-padding">

														<span><button type="button" class="btn btn-danger btn-freight" ><?php echo __('新しいテンプレート'); ?></button></span>

													</div>

												</div>

										    </div>

										</div>

										



									</div>

								</div>

							</div>

						</div>

						<div class="row" id="service">

							<div class="col-md-12">

								<div class="panel panel-default">

									<div class="panel-heading">アフター情報</div>

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

		/*display: none;*/

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

<div class="alert alert-danger-light">

	<!--<strong>暫不可發佈商品：</strong>-->

	<?php if(in_array(($row['brand']), explode(',',"0"))): ?><p> システムにブランドがありません。【メイン舞台裏】>マルチユーザーモール>商品管理>ブランド管理追加に移動してください。。</p><?php endif; if(in_array(($row['shopsort']), explode(',',"0"))): ?><p> 「ショップカテゴリ」は作成されていません，お願いします <a class="btn-shopsort" href="#">[作成]をクリックします</a>。</p><?php endif; if(in_array(($row['freight']), explode(',',"0"))): ?><p> 尚未創建“運費範本”，お願いします<a class="btn-freight" href="#">[作成]をクリックします<</a>。</p><?php endif; if(empty($row['config']['sendPhoneNum']) || (($row['config']['sendPhoneNum'] instanceof \think\Collection || $row['config']['sendPhoneNum'] instanceof \think\Paginator ) && $row['config']['sendPhoneNum']->isEmpty())): ?><p> まだ完了していません“送信者情報”，お願いします <a class="btn-send" href="#">クリックして記入</a> 送信者情報。</p><?php endif; if(empty($row['config']['returnPhoneNum']) || (($row['config']['returnPhoneNum'] instanceof \think\Collection || $row['config']['returnPhoneNum'] instanceof \think\Paginator ) && $row['config']['returnPhoneNum']->isEmpty())): ?><p> まだ完了していません“返品情報”，お願いします <a class="btn-return" href="#">クリックして記入</a> 返品情報。</p><?php endif; ?>

</div>

<?php endif; ?>

<div class="panel panel-default panel-intro">

	<div class="panel-heading">

		<ul class="nav nav-tabs">

			<li class="active"><a href="#basics">基本情報</a></li>

			<li><a href="#sale">商品属性</a></li>

			<li><a href="#wanlinfo">グラフィックの説明</a></li>

			<li><a href="#payment">支払情報</a></li>

			<li><a href="#logistics">ロジスティクス情報</a></li>

			<li><a href="#service">アフター情報</a></li>

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

										<div class="panel-heading">基本情報</div>

										<div class="panel-body">

											<div class="form-group">

												<label class="control-label col-xs-12 col-sm-2"><?php echo __('Title'); ?>:</label>

												<div class="col-xs-12 col-sm-8">

													<input id="c-title" data-rule="required" class="form-control" name="row[title]" type="text"  placeholder="製品タイトルを入力してください">

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

												<label class="control-label col-xs-12 col-sm-2"><?php echo __('製品ブランド'); ?>:</label>

												<div class="col-xs-12 col-sm-8">

													<input id="c-brand" data-rule="required" value="其他" class="form-control" name="row[brand]" type="text"  placeholder="製品ブランドを入力してください">

												</div>

											</div>

											

											<!--<div class="form-group">

											    <label class="control-label col-xs-12 col-sm-2"><?php echo __('商品品牌'); ?>:</label>

											    <div class="col-xs-12 col-sm-8">

													<div class="input-group">

														<input id="c-brand_id" data-rule="required" 

														data-source="wanlshop/brand/selectpage" 

														class="form-control selectpage" 

														name="row[brand_id]" 

														type="text" placeholder="點擊獲取品牌列表">

														<div class="input-group-addon no-border no-padding">

															<span><button type="button" class="btn btn-danger btn-brand" ><?php echo __('申請品牌'); ?></button></span>

														</div>

													</div>

											    </div>

											</div>-->

											

											

											

											<div class="form-group" v-if="attributeData.length != 0">

												<label class="control-label col-xs-12 col-sm-2"><?php echo __('カテゴリの内容'); ?>:</label>

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

										<div class="panel-heading">商品属性</div>

										<div class="panel-body">

											<div class="form-group wanl-specs">

												<label class="control-label col-xs-12 col-sm-2"><?php echo __('商品属性'); ?>:</label>

												<div class="col-xs-12 col-sm-8">

													<div class="input-group add-option">

														<input type="text" class="form-control" ref="specs-name" placeholder="複数の製品属性はスペースで区切られます">

														<span class="input-group-addon pointer" @click="spuAdd">新しい属性</span>
														
														

													</div>
							
<span style="color:red;">1、製品価格を設定するには、次の1つの属性を入力する必要があります<br/>
2、色、サイズ、仕様の要件がない場合は、右側の対応する属性を削除してください<br/>
3、3番目の仕様は、次のように記入できます：単一製品、XXギフトパッケージ<br/>
4、特別な製品属性要件がある場合は、上記の新しい属性の内容をカスタマイズし、色、サイズ、および仕様の属性を削除できます。</span><br/>
													<div class="panel panel-default" v-for="(item, i) in spu" :key="i">

														<header class="panel-heading">

															<b>{{item}}</b>

															<span class="remove" title="削除する" @click="spuRemove(i)">×</span>

														</header>

														<div class="row">

															<div class="col-md-5 col-sm-5 col-xs-8">

																<div class="input-group">

																	<input type="text" class="form-control" :ref="'specs-name-' + i" placeholder="バリアントはスペースで区切られます">

																	<span class="input-group-addon pointer" @click="skuAdd(i)"><i class="fa fa-plus"></i></span>

																</div>

															</div>

															<div class="col-md-7 col-sm-7 col-xs-7">

																<div class="wanl-specs-tag" v-for="(v, j) in spuItem[i]" :key="j">

																	{{v}}<span class="remove" title="削除する" @click="skuRemove(i, j)">×</span>

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

																		<th width="80">元値</th>

																		<th width="80">現在の価格</th>

																		<th width="80">在庫あり</th>

																		<th width="80">重量(kg)</th>

																		<th width="80">コーディング</th>

																	</tr>

																</thead>

																<tbody>

																	<tr v-for="item in sku">

																		<td v-for="v in item">{{v}}</td>

																		<td width="80"> <input type="number" data-rule="required" name="row[market_price][]" class="input-sm form-control wanl-market_price"> </td>

																		<td width="80"> <input type="number" data-rule="required" name="row[price][]" class="input-sm form-control wanl-price"> </td>

																		<td width="80"><input type="number" data-rule="required" name="row[stocks][]" class="input-sm form-control wanl-stock"></td>

																		<td width="80"><input type="number" name="row[weigh][]" class="input-sm form-control wanl-weigh"></td>

																		<td width="80"><input type="text" name="row[sn][]" class="input-sm form-control wanl-sn"></td>

																	</tr>

																</tbody>

															</table>

															<div @click="skuBatch()">

																<span v-if="batch == 0">

																	バッチで設定しますか？

																</span>

																<span v-else>

																	バッチ設定をキャンセル？

																</span>

															</div>

														</div>

													</div>

							

													<div class="batch" v-show="batch == 1">

														<div class="input-group">

															<div class="input-group-addon">元値 円</div>

															<input type="number" class="form-control" id="batch-market_price" placeholder="ワンクリックで元の価格を設定">

															<div class="input-group-addon" onclick="batchSet('market_price')">バッチ設定</div>

														</div>

														<div class="input-group">

															<div class="input-group-addon">現在の価格 円</div>

															<input type="number" class="form-control" id="batch-price" placeholder="ワンクリックで現在の価格を設定">

															<div class="input-group-addon" onclick="batchSet('price')">バッチ設定</div>

														</div>

														<div class="input-group">

															<div class="input-group-addon">在庫あり</div>

															<input type="number" class="form-control" id="batch-stock" placeholder="ワンクリック在庫設定">

															<div class="input-group-addon" onclick="batchSet('stock')">バッチ設定</div>

														</div>

														<div class="input-group">

															<div class="input-group-addon">重量</div>

															<input type="number" class="form-control" id="batch-weigh" placeholder="体重を設定するための1つの鍵">

															<div class="input-group-addon" onclick="batchSet('weigh')">バッチ設定</div>

														</div>

														<div class="input-group">

															<div class="input-group-addon">コーディング</div>

															<input type="text" class="form-control" id="batch-sn" placeholder="コードを設定するための1つのキー">

															<div class="input-group-addon" onclick="batchSet('sn')">バッチ設定</div>

														</div>

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

									<div class="panel-heading">グラフィックの説明</div>

									<div class="panel-body">

										<div class="form-group">

											<label class="control-label col-xs-12 col-sm-2"><?php echo __('Image'); ?>:</label>

											<div class="col-xs-12 col-sm-8">

												<div class="input-group">

													<input id="c-image" data-rule="required" class="form-control" size="50" name="row[image]" type="text" placeholder="商品のメイン画像をアップロードしてください">

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

													<input id="c-images" data-rule="required" class="form-control" size="50" name="row[images]" type="text" placeholder="製品アルバムをアップロードしてください">

													<div class="input-group-addon no-border no-padding">

														<span><button type="button" id="plupload-images" class="btn btn-danger plupload" data-input-id="c-images" data-mimetype="image/gif,image/jpeg,image/png,image/jpg,image/bmp" data-multiple="true" data-preview-id="p-images"><i class="fa fa-upload"></i> <?php echo __('Upload'); ?></button></span>

														<span><button type="button" id="fachoose-images" class="btn btn-primary fachoose" data-input-id="c-images" data-mimetype="image/*" data-multiple="true"><i class="fa fa-list"></i> <?php echo __('Choose'); ?></button></span>

													</div>

													<span class="msg-box n-right" for="c-images"></span>

												</div>

												<ul class="row list-inline plupload-preview" id="p-images"></ul>

											</div>

										</div>

										<div class="form-group">

										    <label class="control-label col-xs-12 col-sm-2"><?php echo __('Description'); ?>:</label>

										    <div class="col-xs-12 col-sm-8">

										        <input id="c-description" data-rule="required" class="form-control" name="row[description]" type="text" placeholder="製品の説明を入力してください">

										    </div>

										</div>

										<div class="form-group">

											<label class="control-label col-xs-12 col-sm-2"><?php echo __('Content'); ?>:</label>

											<div class="col-xs-12 col-sm-8">

												<textarea id="c-content" data-rule="required" class="form-control editor" rows="5" name="row[content]" cols="50"></textarea>

											</div>

										</div>

										<div class="form-group">

											<label class="control-label col-xs-12 col-sm-2"><?php echo __('ショップのカテゴリー'); ?>:</label>

											<div class="col-xs-12 col-sm-8">

												<div class="input-group">

													<input id="c-shop_category_id" data-rule="required"

													data-source="wanlshop/shopsort"

													data-params='{"isTree":1}'

													data-multiple="true"

													data-pagination="true"

													data-page-size="1"

													class="form-control selectpage"

													name="row[shop_category_id]"

													type="text"

													placeholder="クリックしてストアカテゴリを選択します">

													<div class="input-group-addon no-border no-padding">

														<span><button type="button" class="btn btn-danger btn-shopsort" ><?php echo __('新たなカテゴリー'); ?></button></span>

													</div>

												</div>

											</div>

										</div>

									</div>

								</div>

							</div>

						</div>

						<div class="row" id="payment">

							<div class="col-md-12">

								<div class="panel panel-default">

									<div class="panel-heading">支払情報</div>

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

						<div class="row" id="logistics">

							<div class="col-md-12">

								<div class="panel panel-default">

									<div class="panel-heading">ロジスティクス情報</div>

									<div class="panel-body">

										<div class="form-group">

										    <label class="control-label col-xs-12 col-sm-2"><?php echo __('Freight_id'); ?>:</label>

										    <div class="col-xs-12 col-sm-8">

												<div class="input-group">

													<input id="c-freight_id" data-rule="required" data-source="wanlshop/freight" class="form-control selectpage" name="row[freight_id]" type="text" placeholder="クリックして配送テンプレートを選択します">

													<div class="input-group-addon no-border no-padding">

														<span><button type="button" class="btn btn-danger btn-freight" ><?php echo __('新しいテンプレート'); ?></button></span>

													</div>

												</div>

										    </div>

										</div>

										



									</div>

								</div>

							</div>

						</div>

						<div class="row" id="service">

							<div class="col-md-12">

								<div class="panel panel-default">

									<div class="panel-heading">アフター情報</div>

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

		<script src="/assets/js/require.min.js" data-main="/assets/js/require-wanlshop.min.js?v=<?php echo htmlentities($site['version']); ?>"></script>

	</body>

	<?php endif; ?>



</html>
