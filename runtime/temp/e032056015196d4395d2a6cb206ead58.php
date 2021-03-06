<?php if (!defined('THINK_PATH')) exit(); /*a:4:{s:85:"/www/wwwroot/www.fdadeal.com/public/../application/admin/view/wanlshop/page/edit.html";i:1608326198;s:71:"/www/wwwroot/www.fdadeal.com/application/admin/view/layout/default.html";i:1608326192;s:68:"/www/wwwroot/www.fdadeal.com/application/admin/view/common/meta.html";i:1608326192;s:70:"/www/wwwroot/www.fdadeal.com/application/admin/view/common/script.html";i:1608326190;}*/ ?>
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
                                <link href="/assets/addons/wanlshop/css/appUI.css?v=<?php echo $site['version']; ?>" rel="stylesheet">
<link href="/assets/addons/wanlshop/css/page.css?v=<?php echo $site['version']; ?>" rel="stylesheet">
<link href="/assets/addons/wanlshop/css/iconfont.css?v=<?php echo $site['version']; ?>" rel="stylesheet">
<div class="panel panel-default panel-intro" id="app" v-cloak>
	<div class="panel-body" style="padding: 0;">
		<div id="myTabContent" class="tab-content">
			<div class="tab-pane fade active in" id="one">
				<div class="widget-body no-padding">
					<div class="wanl-page" :class="device">
						<!-- ?????? -->
						<div class="left">
							<div class="wanl-tool">
								<div class="menu">
									<div class="dropdown">
										<div class="bnt" id="dLabel" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
											<span>{{device}}</span><span class="caret"></span>
										</div>
										<ul class="dropdown-menu" aria-labelledby="dLabel">
											<li><a @click="onDevice('huaweiMate30')">??????Mate30</a></li>
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
											<span>????????????</span><span class="caret"></span>
										</div>
										<ul class="dropdown-menu" aria-labelledby="dLabel3">
											<li><a>????????????</a></li>
											<li role="separator" class="divider"></li>
											<li><a>????????????</a></li>
											<li><a>WANLSHOP v1.0.1</a></li>
										</ul>
									</div> -->
								</div>
								<div class="Button">
									<div class="dropdown">
										<div class="bnt" id="dLabel3" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
											<span>??????</span><span class="caret"></span>
										</div>
										<ul class="dropdown-menu" aria-labelledby="dLabel3">
											<li @click="publish"><a href="javascript:void(0);">????????????</a></li>
											<li role="separator" class="divider"></li>
											<li v-if="pageRecover.length == 0"><a href="javascript:void(0);"><i class="wlIcon wlIcon-31tishi"></i> ??????????????????????????????</a></li>
											<li v-for="list in pageRecover" @click="recover(list.id)"><a href="javascript:void(0);">????????? {{list.createtime|formatDate}} ??????</a></li>
										</ul>
									</div>
								</div>
							</div>
							<!-- ?????? -->
							<div class="frame">
								<div class="preview">
									<div ref="parant" class="page" :style="{'background-color': pageData.page.style.pageBackgroundColor,'background-image': 'url('+pageData.page.style.pageBackgroundImage+')'}">
										<!-- ?????? -->
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
										<!-- ??????&?????? -->
										<wanldraggable class="draggable" v-model="pageData.item" v-bind="{animation:500}">
											<div class="wanlshop" v-for="(item,index) in pageData.item" :key="index" @click="onType(index)" :class="{action: type == index}">
												<!-- ???????????? -->
												<div class="banner" v-if="item.type == 'banner'" :style="item.style">
													<img :src="cdnurl(item.data[0].image)">
													<div class="indicator">
														<div class="item">
															<span v-for="indic in item.data"></span>
														</div>
													</div>
												</div>
												<!-- ?????? -->
												<div class="image" v-if="item.type == 'image'" :style="item.style">
													<img :src="cdnurl(item.data[0].image)">
												</div>
												<!-- ?????????????????? -->
												<div class="advertBanner" v-if="item.type == 'advertBanner'" :style="item.style">
													<img src="/assets/addons/wanlshop/img/page/advert-banner.png">
													<div class="indicator">
														<div class="item">
															<span v-for="indic in item.data"></span>
														</div>
													</div>
												</div>
												<!-- ???????????? -->
												<div class="advertImage" v-if="item.type == 'advertImage'" :style="item.style">
													<img src="/assets/addons/wanlshop/img/page/advert-image.png">
												</div>
												<!-- ?????? -->
												<div class="video" v-if="item.type == 'video'" :style="item.style">
													<img :src="cdnurl(item.data[0].image)">
													<div class="play"><i class="wlIcon wlIcon-bofang"></i></div>
												</div>
												<!-- ???????????? -->
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
												<!-- ????????? -->
												<div class="notice" v-if="item.type == 'notice'" :style="item.style">
													<i class="wlIcon wlIcon-notice margin-right-xs" v-if="item.params.show"></i><span>{{item.data[0].content}}</span>
												</div>
												<!-- ???????????? -->
												<div class="article" v-if="item.type == 'article'" :style="item.style">
													<div class="item" v-for="article in item.data">
														<div class="image">
															<img :src="cdnurl(article.image)" >
														</div>
														<div class="article-content">
															<div class="title">
																{{article.articleTitle ? article.articleTitle : '????????????????????????????????????'}}
															</div>
															<div class="operate">
																<span v-if="item.params.showTime == 'true'">2020???5???30???20:53</span>
																<span v-if="item.params.showView == 'true'">?????????100</span>
															</div>
														</div>
													</div>
												</div>
												<!-- ???????????? -->
												<div class="headlines" v-if="item.type == 'headlines'" :style="item.style">
													<div class="margin-lr-bj">
														<i class="wlIcon wlIcon-toutiao"></i>
													</div>
													<div class="swiper">
														<div class="list padding-tb-xs">
															<div class="text-sm">
																<div class="cu-tag sm radius bg-gradual-red margin-right-xs">??????</div>
																..???????????????????????????????????????..
															</div>
															<div class="text-sm">
																<div class="cu-tag sm radius bg-gradual-red margin-right-xs">??????</div>
																..???????????????????????????????????????.. 
															</div>
														</div>
														<div class="pic">
															<img :src="cdnurl(item.data[0].image)" >
														</div>
													</div>
												</div>
												<!-- ????????? -->
												<div class="search" v-if="item.type == 'search'" :style="item.style">
													<div :style="{'border-radius':item.params.searchRadius,'background':item.params.searchBackground,'padding':item.params.searchPadding}">
														<i class="wlIcon wlIcon-sousuo margin-right-xs"></i><span>{{item.data[0].content}}</span>
													</div>
												</div>
												<!-- ???????????? -->
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
												<!-- ???????????? -->
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
												<!-- ???????????? -->
												<div class="categoryTitle" v-if="item.type == 'categoryTitle'" :style="item.style">
													<div class="text-lg"> <span class="wlIcon margin-right-xs" :class="item.data[0].icon"></span>
														{{item.data[0].categoryName}} ??????</div>
													<div class="text-sm wanl-gray">?????? <span class="wlIcon wlIcon-fanhui2 margin-left-xs"></span> </div>
												</div>
												<!-- ???????????? -->
												<div class="product" v-if="item.type == 'likes'" :style="item.style" :class="'col-'+ item.params.colthree +'-'+item.params.colmargin" >
													<div class="item">
														<div class="item_pic">
															<img src="/assets/addons/wanlshop/img/common/img_default3x.png">
														</div>
														<div class="item_list padding-bj">
															<div class="margin-bottom-xs">
																<div class="text-df text-cut-2">????????????...????????????...????????????...</div>
																<div class="wanl-orange text-price text-lg">199</div>
															</div>
															<div>
																<div class="text-xs wanl-gray">
																	<span class="margin-right-sm">100+?????????</span> <span>100%?????????</span>
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
																<div class="text-df text-cut-2">????????????...????????????...????????????...</div>
																<div class="wanl-orange text-price text-lg">199</div>
															</div>
															<div>
																<div class="text-xs wanl-gray">
																	<span class="margin-right-sm">100+?????????</span> <span>100%?????????</span>
																</div>
															</div>
														</div>
													</div>
												</div>
												<!-- ???????????? -->
												<div class="product" v-if="item.type == 'goods'" :style="item.style" :class="'col-'+ item.params.colthree +'-'+item.params.colmargin" >
													<div class="item" v-for="goods in item.data">
														<div class="item_pic">
															<img src="/assets/addons/wanlshop/img/common/img_default3x.png">
														</div>
														<div class="item_list padding-bj">
															<div class="margin-bottom-xs">
																<div class="text-df text-cut-2">????????????????????????????????????????????????????????????????????????????????????????????????</div>
																<div class="wanl-orange text-price text-lg">199</div>
															</div>
															<div class="">
																<div class="margin-bottom-xs">
																	<div class="cu-tag sm round bg-gradual-red">??????</div>
																	<div class="cu-tag sm round bg-white">??????66???6</div>
																</div>
																<div class="text-xs wanl-gray">
																	<span class="margin-right-sm">100+?????????</span> <span>100%?????????</span>
																</div>
															</div>
														</div>
													</div>
												</div>
												<!-- ???????????? -->
												<div class="bargain" v-if="item.type == 'bargain'" :style="item.style">
													<span>????????????-?????????????????????????????????</span>
												</div>
												<!-- ???????????? -->
												<div class="seckill" v-if="item.type == 'seckill'" :style="item.style">
													<span>????????????-?????????????????????????????????</span>
												</div>
												<!-- ????????? -->
												<div class="empty" v-if="item.type == 'empty'" :style="item.style">
												</div>
												<!-- ????????? -->
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
										<span><i></i>???????????????</span>
										<!-- <span>?????? <span class="wlIcon wlIcon-fanhuigengduo"></span></span> -->
									</div>
									<div class="control">
										<!-- ???????????? -->
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
						<!-- ????????? -->
						<div class="editor">
							<div class="bs-example bs-example-tabs" v-if="type == 'page'">
								<ul class="nav nav-tabs" role="tablist">
									<li class="active"><a href="#home" data-toggle="tab" aria-expanded="true">????????????</a></li>
								</ul>
								<div class="tab-content">
									<div class="tab-pane fade active in" id="home">
										<p class="bg-info text-info"><strong>?????????</strong>??????????????????????????????????????????????????????????????????????????????</p>
										<div class="form-group">
											<label>????????????:</label>
											<input type="text" class="form-control" v-model="pageData.name">
										</div>
										<div class="form-group">
											<label>???????????????:</label>
											<input type="text" class="form-control" v-model="pageData.page.params.navigationBarTitleText">
										</div>
										
										<h5 class="page-header"></h5>
										<div class="form-group">
											<label>??????????????????:</label>
											<div class="wanl-upload">
												<input class="form-control" type="text" v-model="pageData.page.style.navigationBackgroundImage">
												<input type="file" id="navigationBackground" accept="image/*" @change="changeImage($event,'navigationBackgroundImage')" style="display:none" >
												<label for="navigationBackground" class="btn btn-info">
													<i class="fa fa-upload"></i> ??????
												</label>
											</div>
										</div>
										
										<div class="form-group">
											<label>???????????????:</label>
											<div class="form-inline">
												<input type="text" class="form-control" v-model="pageData.page.style.navigationBarBackgroundColor"> <input
												 id="color" class="form-control" type="color" v-model="pageData.page.style.navigationBarBackgroundColor">
											</div>
										</div>
										<div class="form-group">
											<label>???????????????:</label>
											<select class="form-control" v-model="pageData.page.style.navigationBarTextStyle">
												<option value="#ffffff">??????????????????</option>
												<option value="#000000">??????????????????</option>
											</select>
										</div>
										<h5 class="page-header"></h5>
										<div class="form-group">
											<label>???????????????:</label>
											<div class="wanl-upload">
												<input class="form-control" type="text" v-model="pageData.page.style.pageBackgroundImage">
												<input type="file" id="pageBackground" accept="image/*" @change="changeImage($event,'pageBackgroundImage')" style="display:none" >
												<label for="pageBackground" class="btn btn-info">
													<i class="fa fa-upload"></i> ??????
												</label>
											</div>
										</div>
										<div class="form-group">
											<label>????????????:</label>
											<div class="form-inline">
												<input type="text" class="form-control" v-model="pageData.page.style.pageBackgroundColor"> 
												<input id="color" class="form-control" type="color" v-model="pageData.page.style.pageBackgroundColor">
											</div>
										</div>
										<div class="form-group">
											<label>????????????:</label>
											<select class="form-control" v-model="pageData.page.style.pageBackgroundRepeat">
												<option value="#ffffff">??????</option>
												<option value="#000000">?????????</option>
											</select>
										</div>
									</div>
								</div>
							</div>
							
							<!-- ?????? -->
							<div class="bs-example bs-example-tabs module-example" v-for="(item,index) in pageData.item" :key="index" v-if="type == index">
								<ul class="nav nav-tabs" role="tablist">
									<li class="active"><a href="#home" data-toggle="tab" aria-expanded="true">{{item.name}}??????</a></li>
									<li v-if="item.params !== undefined"><a href="#params" data-toggle="tab" aria-expanded="false">????????????</a></li>
									<li><a href="#style" data-toggle="tab" aria-expanded="false">CSS??????</a></li>
								</ul>
								<div class="tab-content">
									<!-- ???????????? -->
									<div class="tab-pane fade active in" id="home">
										<div class="add-data" @click="addData(index,item.data[0])">
											<a class="btn btn-sm btn-info btn-append"><i class="fa fa-plus"></i> ????????????</a>
										</div>
										<p class="bg-info text-info"><strong>?????????</strong>????????????????????????????????????????????????????????????????????????</p>
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
															<!-- ?????????????????? -->
															<div class="form-group" v-if="type == 'image'">
																<label>??????:</label>
																<div class="wanl-upload">
																	<input class="form-control" type="text" v-model="lists[type]" placeholder="????????????????????????????????????">
																	<input type="file" :id="type+index+num" accept="image/*" @change="dataUpload($event,index,num,type)" :ref="type+index+num" style="display: none;">
																	<label :for="type+index+num" class="btn btn-info">
																		<i class="fa fa-upload"></i> ??????
																	</label>
																</div>
																<ul class="row list-inline plupload-preview">
																	<li class="col-xs-3">
																		<a class="thumbnail"><img :src="cdnurl(lists[type])" class="img-responsive"></a>
																	</li>
																</ul>
															</div>
															<!-- ?????? -->
															<div class="tips" v-else-if="type == 'tips'">
																{{datas}}
															</div>
															<!-- ??????2 -->
															<div class="title form-group" v-else-if="type == 'title'">
																<span class="text-green">{{datas}}</span>
															</div>
															<!-- icon?????? -->
															<div class="form-group" v-else-if="type == 'iconClass'">
																<label>icon??????:</label>
																<select class="form-control" v-model="lists[type]">
																	<option value="text-white">??????</option>
																	<option value="wanl-black">??????</option>
																	<option value="wanl-pip">?????????</option>
																	<option value="wanl-gray-dark">??????</option>
																	<option value="wanl-gray-light">??????</option>
																	<option value="wanl-text-white">??????????????????</option>
																	<option value="wanl-orange">??????</option>
																	<option value="wanl-red">??????</option>
																	<option value="text-yellow">??????</option>
																	<option value="text-green">??????</option>
																	<option value="text-blue">??????</option>
																	<option value="text-olive">?????????</option>
																	<option value="text-cyan">??????</option>
																	<option value="text-purple">??????</option>
																	<option value="text-mauve">??????</option>
																	<option value="text-pink">??????</option>
																	<option value="text-brown">??????</option>
																	<option value="wanl-text-red">??????????????????</option>
																	<option value="wanl-text-yellow">??????????????????</option>
																	<option value="wanl-text-orange">??????????????????</option>
																	<option value="wanl-text-violet">?????????????????????</option>
																	<option value="wanl-text-blue">??????????????????</option>
																	<option value="wanl-text-light-blue">?????????????????????</option>
																	<option value="wanl-text-pink">??????????????????</option>
																	<option value="wanl-text-green">??????????????????</option>
																	<option value="wanl-text-purple">??????????????????</option>
																</select>
															</div>
															<!-- ?????????????????? -->
															<div class="form-group" v-else-if="type == 'bgClass'">
																<label>??????:</label>
																<select class="form-control" v-model="lists[type]">
																	<option value="wanl-bg-transparent">???????????????</option>
																	<option value="bg-white">??????</option>
																	<option value="wanl-bg-redorange">?????????????????????</option>
																	<option value="wanl-bg-orange">??????????????????</option>
																	<option value="wanl-bg-pink">??????????????????</option>
																	<option value="wanl-bg-blue">??????????????????</option>
																	<option value="bg-gradual-yellow">??????????????????</option>
																	<option value="bg-gradual-red">??????????????????</option>
																	<option value="bg-gradual-orange">??????????????????</option>
																	<option value="bg-gradual-green">??????????????????</option>
																	<option value="bg-gradual-purple">??????????????????</option>
																	<option value="bg-gradual-pink">??????????????????</option>
																	<option value="bg-gradual-blue">??????????????????</option>
																	<option value="bg-red">??????</option>
																	<option value="bg-orange">??????</option>
																	<option value="bg-yellow">??????</option>
																	<option value="bg-olive">??????</option>
																	<option value="bg-green">??????</option>
																	<option value="bg-cyan">??????</option>
																	<option value="bg-blue">??????</option>
																	<option value="bg-purple">??????</option>
																	<option value="bg-mauve">??????</option>
																	<option value="bg-pink">??????</option>
																	<option value="bg-brown">??????</option>
																</select>
															</div>
															<!-- ???????????? -->
															<div class="form-group" v-else-if="type == 'link'">
																<h5 class="page-header"></h5>
																<label>????????????:</label>
																<div class="wanl-upload">
																	<input type="text" class="form-control" v-model="lists[type]" placeholder="????????????????????????????????????">
																	<button @click="obtainLink(index,num,type,'false')" class="btn btn-primary wanl-link"><i class="fa fa-link"></i> ?????? </button>
																</div>
															</div>
															<!-- ???????????? -->
															<div class="form-group" v-else-if="type == 'video'">
																<h5 class="page-header"></h5>
																<label>????????????:</label>
																<div class="wanl-upload">
																	<input type="text" class="form-control" v-model="lists[type]" placeholder="????????????????????????????????????">
																	<button @click="attachmentLink(index,num,type,'false')" class="btn btn-primary wanl-link"><i class="fa fa-list"></i> ?????? </button>
																</div>
															</div>
															<!-- icon?????? -->
															<div class="form-group" v-else-if="type == 'icon'">
																<label>????????????:</label>
																<div class="wanl-upload">
																	<input type="text" class="form-control" v-model="lists[type]" placeholder="????????????????????????????????????">
																	<button @click="iconLink(index, num, type, 'false')" class="btn btn-info wanl-link"><i class="fa fa-bars"></i> ?????? </button>
																</div>
															</div>
															<!-- ???????????? -->
															<div class="form-group" v-else-if="type == 'categoryLink'">
																<h5 class="page-header"></h5>
																<label>????????????:</label>
																<div class="wanl-upload">
																	<input type="text" class="form-control" v-model="lists[type]" placeholder="????????????????????????????????????ID">
																	<button @click="categoryLink(index, num, 'false')" class="btn btn-info wanl-link"><i class="fa fa-bars"></i> ?????? </button>
																</div>
															</div>
															<!-- ????????? -->
															<div class="form-group" v-else-if="type == 'categoryName'">
																<label>?????????:</label>
																<input type="text" class="form-control" v-model="lists[type]" disabled />
															</div>
															<!-- ???????????? -->
															<div class="form-group" v-else-if="type == 'goodsLink'">
																<label>??????:</label>
																<div class="wanl-upload">
																	<input type="text" class="form-control" v-model="lists[type]" placeholder="????????????????????????????????????ID">
																	<button @click="goodsLink(index,num,type,'false')" class="btn btn-info wanl-link"><i class="fa fa-bars"></i> ?????? </button>
																</div>
															</div>
															<!-- ?????? -->
															<div class="form-group" v-else-if="type == 'advertLink'">
																<label>????????????:</label>
																<div class="wanl-upload">
																	<input type="text" class="form-control" v-model="lists[type]" placeholder="????????????????????????????????????ID">
																	<button @click="advertLink(index,num,type,'false')" class="btn btn-info wanl-link"><i class="fa fa-bars"></i> ?????? </button>
																</div>
															</div>
															<!-- ?????? -->
															<div class="form-group" v-else-if="type == 'articleLink'">
																<h5 class="page-header"></h5>
																<label>????????????:</label>
																<div class="wanl-upload">
																	<input type="text" class="form-control" v-model="lists[type]" placeholder="????????????????????????????????????">
																	<button @click="articleLink(index,num,type,'false')" class="btn btn-info wanl-link"><i class="fa fa-bars"></i> ?????? </button>
																</div>
															</div>
															
															<!-- ???????????? -->
															<div class="form-group hidden" v-else-if="type == 'articleTitle'">
																<label>????????????:</label>
																<input type="text" class="form-control" v-model="lists[type]" disabled="disabled">
															</div>
															
															<!-- ?????? -->
															<div class="form-group" v-else-if="type == 'content'">
																<label>??????:</label>
																<input type="text" class="form-control" v-model="lists[type]" placeholder="???????????????">
															</div>
															
															<!-- ???????????? -->
															<div class="form-group" v-else-if="type == 'activity'">
																<label>????????????:</label>
																<select class="form-control" v-model="lists[type]">
																	<option value="distribution">??????</option>
																	<option value="group">????????????</option>
																	<option value="bargain">??????</option>
																	<option value="rush">????????????</option>
																	<option value="coupon">????????????</option>
																</select>
															</div>
															<!-- ???????????? -->
															<div class="form-group" v-else-if="type == 'textColor'">
																<label>????????????:</label>
																<select class="form-control" v-model="lists[type]">
																	<option value="wanl-black">??????</option>
																	<option value="wanl-pip">?????????</option>
																	<option value="wanl-orange">??????</option>
																	<option value="wanl-red">?????????</option>
																	<option value="text-red">??????</option>
																	<option value="text-yellow">??????</option>
																	<option value="text-green">??????</option>
																	<option value="text-blue">??????</option>
																	<option value="text-olive">?????????</option>
																	<option value="text-cyan">??????</option>
																	<option value="text-purple">??????</option>
																	<option value="text-mauve">??????</option>
																	<option value="text-pink">??????</option>
																	<option value="text-brown">??????</option>
																	<option value="wanl-gray-dark">??????</option>
																	<option value="wanl-gray-light">??????</option>
																</select>
															</div>
															<!-- ?????? -->
															<div class="form-group" v-else-if="type == 'categoryId'">
																<label>????????????:</label>
																<select class="form-control" v-model="lists[type]">
																	<option v-for="cate in pageCategory" :value ="cate.id">{{mergeSpace(cate.spacer)}} {{cate.name}}</option>
																</select>
															</div>
															<!-- ???????????? -->
															<div class="form-group" v-else>
																<label>{{getParameter(type)}}:</label>
																<input type="text" class="form-control" v-model="lists[type]" :placeholder="'?????????' + getParameter(type)">
															</div>
														</div>
													</div>
												</div>
											</div>
										</div>
									</div>
									<!-- ???????????? -->
									<div class="tab-pane fade" id="params">
										<p class="bg-warning text-warning"><strong>?????????</strong>???????????????px????????????????????????????????????px???????????????????????????????????????rpx???</p>
										<div class="form-group" v-for="(params,type) in item.params" :key="type">
											<!-- ??????????????? -->
											<div v-if="type == 'banstyle'">
												<label>???????????????:</label>
												<select class="form-control" v-model="item.params[type]">
													<option value="1">??????</option>
													<option value="2">??????</option>
												</select>
											</div>
											<!-- ???????????? -->
											<div v-else-if="type == 'colStyle'">
												<label>????????????:</label>
												<select class="form-control" v-model="item.params[type]">
													<option value="col-1-2-2">1-2-2??????</option>
													<option value="col-1-1_2">1-1_2??????</option>
													<option value="col-2-1_2">2-1_2??????</option>
													<option value="col-2-2_1">2-2_1??????</option>
													<option value="col-2-2-1_2">2-2-1_2??????</option>
													<option value="col-2-4">2-4??????</option>
													<option value="col-2-2-4">2-2-4??????</option>
												</select>
											</div>
											<!-- ???????????? -->
											<div v-else-if="type == 'colthree'">
												<label>????????????:</label>
												<select class="form-control" v-model="item.params[type]">
													<option value="1">?????? 1 ???</option>
													<option value="2">?????? 2 ???</option>
													<option value="3">?????? 3 ???</option>
												</select>
											</div>
											<!-- ???????????? -->
											<div v-else-if="type == 'colfive'">
												<label>????????????:</label>
												<select class="form-control" v-model="item.params[type]">
													<option value="1">?????? 1 ???</option>
													<option value="2">?????? 2 ???</option>
													<option value="3">?????? 3 ???</option>
													<option value="4">?????? 4 ???</option>
													<option value="5">?????? 5 ???</option>
												</select>
											</div>
											<!-- ????????? -->
											<div v-else-if="type == 'colmargin'">
												<label>??????:</label>
												<select class="form-control" v-model="item.params[type]">
													<option value="10">5?????????10rpx???</option>
													<option value="15">7.5?????????15rpx???</option>
													<option value="20">10?????????20rpx???</option>
													<option value="25">12.5?????????25rpx???</option>
													<option value="30">15?????????30rpx???</option>
												</select>
											</div>
											<!-- ???????????? -->
											<div v-else-if="type == 'show'">
												<label>???????????????:</label>
												<select class="form-control" v-model="item.params[type]">
													<option value="true">??????</option>
													<option value="">?????????</option>
												</select>
											</div>
											<div v-else-if="type == 'showTime'">
												<label>????????????:</label>
												<select class="form-control" v-model="item.params[type]">
													<option value="true">??????</option>
													<option value="false">?????????</option>
												</select>
											</div>
											<div v-else-if="type == 'showView'">
												<label>????????????:</label>
												<select class="form-control" v-model="item.params[type]">
													<option value="true">??????</option>
													<option value="false">?????????</option>
												</select>
											</div>
											<!-- ?????????????????? -->
											<div class="form-inline" v-else-if="type == 'searchBackground'">
												<label>???????????????:</label>
												<input type="text" class="form-control" v-model="item.params[type]"> <input id="color" class="form-control"
												 type="color" v-model="item.params[type]">
											</div>
											<!-- ???????????? -->
											<div class="form-inline" v-else-if="type == 'lineBackground'">
												<label>????????????:</label>
												<input type="text" class="form-control" v-model="item.params[type]"> <input id="color" class="form-control"
												 type="color" v-model="item.params[type]">
											</div>
											<!-- ?????????????????? -->
											<div class="form-inline" v-else-if="type == 'lineTextColor'">
												<label>????????????:</label>
												<input type="text" class="form-control" v-model="item.params[type]"> <input id="color" class="form-control"
												 type="color" v-model="item.params[type]">
											</div>
											<!-- ?????????????????????????????? -->
											<div class="form-inline" v-else-if="type == 'lineTextBackground'">
												<label>??????????????????:</label>
												<input type="text" class="form-control" v-model="item.params[type]"> <input id="color" class="form-control"
												 type="color" v-model="item.params[type]">
											</div>
											<!-- ???????????? -->
											<div v-else>
												<label>{{getParameter(type)}}:</label>
												<input type="text" class="form-control" v-model="item.params[type]">
											</div>
										</div>
									</div>
									<!-- ???????????? -->
									<div class="tab-pane fade" id="style">
										<p class="bg-danger text-danger"><strong>?????????</strong>???????????????????????????CSS?????????????????????????????????????????????????????????????????????????????? / ???????????????</p>
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
											 aria-haspopup="true" aria-expanded="false"><i class="fa fa-plus"></i> ???????????????</a>
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
        <script src="/assets/js/require<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.js" data-main="/assets/js/require-backend<?php echo \think\Config::get('app_debug')?'':'.min'; ?>.js?v=<?php echo htmlentities($site['version']); ?>"></script>
    </body>
</html>
