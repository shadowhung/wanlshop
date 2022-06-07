<?php if (!defined('THINK_PATH')) exit(); /*a:1:{s:78:"/www/wwwroot/www.fdadeal.com/addons/wanlshop/view/hook/user_sidenav_after.html";i:1608268546;}*/ ?>
<ul class="list-group">
    <li class="list-group-heading"><?php echo __('卖家管理'); ?></li>
	<li class="list-group-item <?php echo $actionname=='my'?'active':''; ?>"><a target="_blank" href="<?php echo url('index/wanlshop.console/index'); ?>"><i class="fa fa-list fa-fw"></i> <?php echo __('卖家控制台'); ?></a></li>
</ul>
