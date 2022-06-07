SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";

SET AUTOCOMMIT = 0;

START TRANSACTION;

SET time_zone = "+00:00";



-- 

-- 表的结构 `__PREFIX__wanlshop_address`

-- 



CREATE TABLE IF NOT EXISTS `__PREFIX__wanlshop_address` (

  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',

  `user_id` int(10) NOT NULL DEFAULT '0' COMMENT '用户ID',

  `name` varchar(15) NOT NULL DEFAULT '' COMMENT '收货人',

  `mobile` varchar(11) NOT NULL DEFAULT '' COMMENT '手机号',

  `default` enum('0','1') NOT NULL DEFAULT '0' COMMENT '默认:1=是,0=否',

  `country` varchar(32) NOT NULL COMMENT '国家',

  `province` varchar(32) NOT NULL COMMENT '省份',

  `city` varchar(64) NOT NULL COMMENT '城市',

  `citycode` int(6) NOT NULL COMMENT '市级代码',

  `district` varchar(64) NOT NULL COMMENT '区/县',

  `adcode` int(6) NOT NULL COMMENT '县级代码',

  `formatted_address` varchar(255) NOT NULL COMMENT '详细地区',

  `address` varchar(255) NOT NULL COMMENT '详细地址',

  `address_name` varchar(255) NOT NULL COMMENT '地址名称',

  `location` varchar(32) DEFAULT '' COMMENT '经纬度',

  `createtime` int(10) DEFAULT NULL COMMENT '创建时间',

  `updatetime` int(10) DEFAULT NULL COMMENT '更新时间',

  `deletetime` int(10) DEFAULT NULL COMMENT '删除时间',

  `status` enum('normal','hidden') DEFAULT 'normal' COMMENT '状态',

  PRIMARY KEY (`id`) USING BTREE

) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='地址表';



-- 

-- 表的结构 `__PREFIX__wanlshop_advert`

-- 

CREATE TABLE IF NOT EXISTS `__PREFIX__wanlshop_advert` (

  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',

  `admin_id` int(10) NOT NULL DEFAULT '0' COMMENT '管理员ID',

  `module` enum('open','page','category','first','other') NOT NULL COMMENT '投放模块:open=开屏广告,page=自定义页面广告,category=类目广告,first=首次欢迎广告,other=其他广告',

  `category_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '投放类目',

  `type` enum('banner','image','video') NOT NULL COMMENT '媒体类型:banner=幻灯片,image=图片,video=视频',

  `media` varchar(100) NOT NULL DEFAULT '' COMMENT '媒体文件',

  `url` varchar(100) NOT NULL DEFAULT '' COMMENT '广告链接',

  `title` varchar(100) NOT NULL DEFAULT '' COMMENT '广告标题',

  `content` text NOT NULL COMMENT '广告内容',

  `city` varchar(100) NOT NULL DEFAULT '' COMMENT '投放城市',

  `startdate` date DEFAULT NULL COMMENT '开始日期',

  `enddate` date DEFAULT NULL COMMENT '结束日期',

  `views` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '点击次数',

  `show` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '展示次数',

  `createtime` int(10) DEFAULT NULL COMMENT '创建时间',

  `updatetime` int(10) DEFAULT NULL COMMENT '更新时间',

  `deletetime` int(10) DEFAULT NULL COMMENT '删除时间',

  `weigh` int(10) NOT NULL DEFAULT '0' COMMENT '权重',

  `status` enum('normal','hidden') DEFAULT 'normal' COMMENT '状态',

  PRIMARY KEY (`id`) USING BTREE

) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='广告表';





-- 

-- 表的结构 `__PREFIX__wanlshop_article`

-- 

CREATE TABLE IF NOT EXISTS `__PREFIX__wanlshop_article` (

  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',

  `admin_id` int(10) NOT NULL DEFAULT '0' COMMENT '管理员ID',

  `category_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '分类ID(单选)',

  `flag` set('hot','index','recommend') NOT NULL DEFAULT '' COMMENT '标志(多选):hot=热门,index=首页,recommend=推荐',

  `title` varchar(50) NOT NULL DEFAULT '' COMMENT '标题',

  `content` text NOT NULL COMMENT '内容',

  `image` varchar(100) NOT NULL DEFAULT '' COMMENT '图片',

  `images` varchar(1500) NOT NULL DEFAULT '' COMMENT '图片组',

  `attachfile` varchar(100) NOT NULL DEFAULT '' COMMENT '附件',

  `keywords` varchar(100) NOT NULL DEFAULT '' COMMENT '关键字',

  `description` varchar(255) NOT NULL DEFAULT '' COMMENT '描述',

  `views` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '点击',

  `createtime` int(10) DEFAULT NULL COMMENT '创建时间',

  `updatetime` int(10) DEFAULT NULL COMMENT '更新时间',

  `deletetime` int(10) DEFAULT NULL COMMENT '删除时间',

  `weigh` int(10) NOT NULL DEFAULT '0' COMMENT '权重',

  `status` enum('normal','hidden') DEFAULT 'normal' COMMENT '状态',

  PRIMARY KEY (`id`) USING BTREE

) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='文章';



-- 

-- 表的结构 `__PREFIX__wanlshop_auth`

-- 

CREATE TABLE IF NOT EXISTS `__PREFIX__wanlshop_auth` (

  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',

  `user_id` int(10) unsigned DEFAULT '0' COMMENT '会员ID',

  `state` enum('0','1','2') NOT NULL DEFAULT '0' COMMENT '店铺类型:0=个人,1=企业,2=旗舰',

  `shopname` varchar(32) NOT NULL DEFAULT '' COMMENT '店铺名称',

  `name` varchar(32) NOT NULL DEFAULT '' COMMENT '企业名/姓名',

  `number` varchar(32) NOT NULL DEFAULT '' COMMENT '统一信用/身份证号',

  `mobile` varchar(32) NOT NULL DEFAULT '' COMMENT '手机号',

  `image` varchar(255) NOT NULL DEFAULT '' COMMENT '证件图片',

  `trademark` varchar(255) DEFAULT '' COMMENT '商标证书',

  `wechat` varchar(32) NOT NULL DEFAULT '' COMMENT '微信号',

  `avatar` varchar(255) DEFAULT '' COMMENT '店铺头像',

  `bio` varchar(100) DEFAULT '' COMMENT '店铺简介',

  `refuse` varchar(100) DEFAULT '' COMMENT '拒绝理由',

  `content` text COMMENT '店铺介绍',

  `city` varchar(100) DEFAULT '' COMMENT '省市',

  `verify` enum('0','1','2','3','4') NOT NULL DEFAULT '0' COMMENT '审核:0=提交资质,1=提交店铺,2=提交审核,3=通过,4=未通过',

  `createtime` int(10) DEFAULT NULL COMMENT '创店时间',

  `updatetime` int(10) DEFAULT NULL COMMENT '更新时间',

  `deletetime` int(10) DEFAULT NULL COMMENT '删除时间',

  `status` enum('normal','hidden') DEFAULT 'normal' COMMENT '状态',

  PRIMARY KEY (`id`) USING BTREE,

  KEY `shopname` (`shopname`) USING BTREE

) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='认证表';



-- 

-- 表的结构 `__PREFIX__wanlshop_brand`

-- 

CREATE TABLE IF NOT EXISTS `__PREFIX__wanlshop_brand` (

  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',

  `admin_id` int(10) NOT NULL DEFAULT '0' COMMENT '管理员ID',

  `shop_id` int(10) NOT NULL DEFAULT '0' COMMENT '商家ID',

  `category_id` varchar(100) NOT NULL DEFAULT '' COMMENT '分类ID',

  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '品牌名',

  `image` varchar(100) NOT NULL DEFAULT '' COMMENT '图片',

  `content` text NOT NULL COMMENT '内容介绍',

  `weigh` int(10) NOT NULL DEFAULT '0' COMMENT '权重',

  `switch` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否启用',

  `createtime` int(10) DEFAULT NULL COMMENT '创建时间',

  `updatetime` int(10) DEFAULT NULL COMMENT '更新时间',

  `deletetime` int(10) DEFAULT NULL COMMENT '删除时间',

  `status` enum('normal','hidden') NOT NULL DEFAULT 'normal' COMMENT '状态',

  `state` enum('0','1') NOT NULL DEFAULT '0' COMMENT '状态值:0=审核中,1=已审核',

  PRIMARY KEY (`id`) USING BTREE

) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='品牌表';



-- 

-- 表的结构 `__PREFIX__wanlshop_cart`

-- 

CREATE TABLE IF NOT EXISTS `__PREFIX__wanlshop_cart` (

  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',

  `user_id` int(10) NOT NULL DEFAULT '0' COMMENT '用户ID',

  `shop_id` int(10) NOT NULL DEFAULT '0' COMMENT '店铺ID',

  `goods_id` int(10) NOT NULL DEFAULT '0' COMMENT '商品ID',

  `number` int(10) unsigned NOT NULL DEFAULT '1' COMMENT '购物车数量',

  `sku_id` int(10) NOT NULL DEFAULT '0' COMMENT 'SKU ID',

  `createtime` int(10) DEFAULT NULL COMMENT '创建时间',

  `updatetime` int(10) DEFAULT NULL COMMENT '更新时间',

  PRIMARY KEY (`id`)

) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='购物车表';



-- 

-- 表的结构 `__PREFIX__wanlshop_category`

-- 

CREATE TABLE IF NOT EXISTS `__PREFIX__wanlshop_category` (

  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,

  `pid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '父ID',

  `type` enum('article','goods') NOT NULL COMMENT '类型',

  `name` varchar(30) NOT NULL DEFAULT '' COMMENT '名称',

  `name_spacer` varchar(0) DEFAULT '' COMMENT '存放目录结构',

  `image` varchar(100) NOT NULL DEFAULT '' COMMENT '图片',

  `flag` set('hot','new','recommend') DEFAULT '' COMMENT '标志',

  `isnav` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否导航显示',

  `createtime` int(10) DEFAULT NULL COMMENT '创建时间',

  `updatetime` int(10) DEFAULT NULL COMMENT '更新时间',

  `weigh` int(10) NOT NULL DEFAULT '0' COMMENT '权重',

  `status` enum('normal','hidden') DEFAULT 'normal' COMMENT '状态',

  PRIMARY KEY (`id`),

  KEY `weigh` (`weigh`) USING BTREE,

  KEY `parent_id` (`pid`) USING BTREE

) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='商品、文章类目表';



-- 

-- 表的结构 `__PREFIX__wanlshop_category_attribute`

-- 

CREATE TABLE IF NOT EXISTS `__PREFIX__wanlshop_category_attribute` (

  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',

  `admin_id` int(10) NOT NULL DEFAULT '0' COMMENT '管理员ID',

  `category_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '分类ID',

  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '属性名',

  `value` longtext COMMENT '配置:key=名称,value=值2',

  `switch` tinyint(1) NOT NULL DEFAULT '0' COMMENT '开关',

  `weigh` int(10) NOT NULL DEFAULT '0' COMMENT '权重',

  `createtime` int(10) DEFAULT NULL COMMENT '创建时间',

  `updatetime` int(10) DEFAULT NULL COMMENT '更新时间',

  `deletetime` int(10) DEFAULT NULL COMMENT '删除时间',

  `status` enum('normal','hidden') NOT NULL DEFAULT 'normal' COMMENT '状态',

  PRIMARY KEY (`id`) USING BTREE

) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='类目属性表';



-- 

-- 表的结构 `__PREFIX__wanlshop_chat`

-- 

CREATE TABLE IF NOT EXISTS `__PREFIX__wanlshop_chat` (

  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',

  `form_uid` int(10) DEFAULT '0' COMMENT '发信息人ID',

  `to_id` int(10) DEFAULT '0' COMMENT '收信息人ID',

  `form` longtext COMMENT '发送人信息',

  `message` longtext COMMENT '消息数据',

  `type` varchar(50) DEFAULT NULL COMMENT '消息类型',

  `online` tinyint(1) DEFAULT '0' COMMENT '在线状态:0=离线消息,1=在线消息',

  `isread` tinyint(1) DEFAULT '0' COMMENT '是否已读:0=未读,1=已读',

  `createtime` int(10) DEFAULT NULL COMMENT '创建时间',

  `updatetime` int(10) DEFAULT NULL COMMENT '更新时间',

  `deletetime` int(10) DEFAULT NULL COMMENT '删除时间',

  PRIMARY KEY (`id`)

) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='聊天记录表';



-- 

-- 表的结构 `__PREFIX__wanlshop_complaint`

-- 

CREATE TABLE IF NOT EXISTS `__PREFIX__wanlshop_complaint` (

  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',

  `type` enum('0','1','2') NOT NULL COMMENT '举报类型:0=用户举报,1=商品举报,2=店铺举报',

  `user_id` int(10) NOT NULL DEFAULT '0' COMMENT '举报人',

  `complaint_user_id` int(10) unsigned DEFAULT '0' COMMENT '被举报会员ID',

  `complaint_shop_id` int(10) unsigned DEFAULT '0' COMMENT '被举报店铺ID',

  `complaint_goods_id` int(10) unsigned DEFAULT '0' COMMENT '被举报商品ID',

  `content` text NOT NULL COMMENT '内容',

  `images` varchar(1500) NOT NULL DEFAULT '' COMMENT '图片组',

  `reason` enum('0','1','2','3','4','5','6','7','8','9','10','11','12','13') NOT NULL COMMENT '举报理由:0=虚假交易,1=诈骗欺诈,2=收到空包裹,3=假冒盗版,4=泄露信息,5=违禁物品,6=未按成交价交易,7=未按约定时间发货,8=垃圾营销,9=涉黄信息,10=不实信息,11=人身攻击,12=违法信息,13=诈骗信息',

  `receipt` text COMMENT '处理回执',

  `createtime` int(10) DEFAULT NULL COMMENT '创建时间',

  `updatetime` int(10) DEFAULT NULL COMMENT '更新时间',

  `deletetime` int(10) DEFAULT NULL COMMENT '删除时间',

  `state` enum('normal','hidden') NOT NULL DEFAULT 'normal' COMMENT '状态:normal=未受理,hidden=已受理',

  PRIMARY KEY (`id`)

) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='举报表';



-- 

-- 表的结构 `__PREFIX__wanlshop_coupon`

-- 

CREATE TABLE IF NOT EXISTS `__PREFIX__wanlshop_coupon` (

  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',

  `shop_id` int(10) NOT NULL DEFAULT '0' COMMENT '管理员ID',

  `type` enum('reduction','discount','shipping','vip') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'reduction' COMMENT '优惠券类型:reduction=满减券,discount=折扣券,shipping=包邮券,vip=会员赠券',

  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '名称',

  `userlevel` int(10) unsigned DEFAULT '0' COMMENT '会员等级',

  `usertype` enum('reduction','discount') COLLATE utf8mb4_unicode_ci DEFAULT 'reduction' COMMENT '赠券类型:reduction=满减券,discount=折扣券',

  `price` decimal(10,2) unsigned DEFAULT '0.00' COMMENT '面值',

  `discount` decimal(2,1) unsigned DEFAULT '0.0' COMMENT '折扣率',

  `limit` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '消费限制',

  `rangetype` enum('all','goods','category') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'all' COMMENT '可用范围:all=全部商品,goods=指定商品,category=指定分类',

  `range` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '范围',

  `pretype` enum('appoint','fixed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'appoint' COMMENT '时效类型:appoint=领后天数,fixed=固定时间',

  `validity` int(10) unsigned DEFAULT '0' COMMENT '有效天数',

  `startdate` date DEFAULT NULL COMMENT '开始日期',

  `enddate` date DEFAULT NULL COMMENT '结束时间',

  `drawlimit` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '领取限制',

  `grant` varchar(10) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '-1' COMMENT '发放总数量',

  `alreadygrant` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '已领取数量',

  `surplus` int(10) unsigned DEFAULT '0' COMMENT '剩余数量',

  `content` text COLLATE utf8mb4_unicode_ci COMMENT '使用说明',

  `usenum` int(10) unsigned DEFAULT '0' COMMENT '已使用数量',

  `invalid` int(10) unsigned DEFAULT '0' COMMENT '是否失效',

  `createtime` int(10) DEFAULT NULL COMMENT '创建时间',

  `updatetime` int(10) DEFAULT NULL COMMENT '更新时间',

  `deletetime` int(10) DEFAULT NULL COMMENT '删除时间',

  PRIMARY KEY (`id`)

) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='卡券表';



-- 

-- 表的结构 `__PREFIX__wanlshop_coupon_receive`

-- 

CREATE TABLE IF NOT EXISTS `__PREFIX__wanlshop_coupon_receive` (

  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',

  `coupon_id` int(10) NOT NULL DEFAULT '0' COMMENT '原始优惠券ID',

  `coupon_no` varchar(16) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '优惠券编码',

  `user_id` int(10) NOT NULL DEFAULT '0' COMMENT '用户ID',

  `shop_id` int(10) NOT NULL DEFAULT '0' COMMENT '店铺ID',

  `order_id` int(10) DEFAULT '0' COMMENT '使用订单ID',

  `type` enum('reduction','discount','shipping','vip') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'reduction' COMMENT '优惠券类型:reduction=满减券,discount=折扣券,shipping=包邮券,vip=会员赠券',

  `name` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '名称',

  `userlevel` int(10) unsigned DEFAULT '0' COMMENT '会员等级',

  `usertype` enum('reduction','discount') COLLATE utf8mb4_unicode_ci DEFAULT 'reduction' COMMENT '赠券类型:reduction=满减券,discount=折扣券',

  `price` decimal(10,2) unsigned DEFAULT '0.00' COMMENT '面值',

  `discount` decimal(2,1) unsigned DEFAULT '0.0' COMMENT '折扣率',

  `limit` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '消费限制',

  `rangetype` enum('all','goods','category') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'all' COMMENT '可用范围:all=全部商品,goods=指定商品,category=指定分类',

  `range` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '范围',

  `pretype` enum('appoint','fixed') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'appoint' COMMENT '时效类型:appoint=领后天数,fixed=固定时间',

  `validity` int(10) unsigned DEFAULT '0' COMMENT '有效天数',

  `startdate` date DEFAULT NULL COMMENT '开始日期',

  `enddate` date DEFAULT NULL COMMENT '活动时间(datetime)',

  `state` enum('1','2','3') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '1' COMMENT '使用状态:1=未使用,2=已使用,3=已过期',

  `createtime` int(10) DEFAULT NULL COMMENT '创建时间',

  `updatetime` int(10) DEFAULT NULL COMMENT '更新时间',

  `deletetime` int(10) DEFAULT NULL COMMENT '删除时间',

  PRIMARY KEY (`id`)

) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='领取卡券历史表';



-- 

-- 表的结构 `__PREFIX__wanlshop_feedback`

-- 

CREATE TABLE IF NOT EXISTS `__PREFIX__wanlshop_feedback` (

  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',

  `user_id` int(10) NOT NULL DEFAULT '0' COMMENT '用户ID',

  `content` text NOT NULL COMMENT '内容',

  `images` varchar(1500) NOT NULL DEFAULT '' COMMENT '图片组',

  `contact` varchar(20) NOT NULL DEFAULT '' COMMENT '联系方式',

  `device` varchar(500) NOT NULL DEFAULT '' COMMENT '设备详情',

  `score` int(1) NOT NULL DEFAULT '0' COMMENT '评分',

  `receipt` text COMMENT '处理回执',

  `createtime` int(10) DEFAULT NULL COMMENT '创建时间',

  `updatetime` int(10) DEFAULT NULL COMMENT '更新时间',

  `deletetime` int(10) DEFAULT NULL COMMENT '删除时间',

  `status` enum('normal','hidden') NOT NULL DEFAULT 'normal' COMMENT '状态:normal=未受理,hidden=已受理',

  PRIMARY KEY (`id`)

) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='意见反馈表';



-- 

-- 表的结构 `__PREFIX__wanlshop_find`

-- 

CREATE TABLE IF NOT EXISTS `__PREFIX__wanlshop_find` (

  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',

  `shop_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '商家ID',

  `type` enum('new','live','want','activity','show') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'new' COMMENT '类型:new=上新,live=直播,want=种草,activity=活动,show=买家秀',

  `goods_ids` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '类型ID',

  `comments_id` int(10) DEFAULT NULL COMMENT '评论ID',

  `activity_id` int(10) DEFAULT NULL COMMENT '活动ID',

  `live_id` int(10) DEFAULT NULL COMMENT '直播ID',

  `content` text COLLATE utf8mb4_unicode_ci COMMENT '内容',

  `images` varchar(1500) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '图片组',

  `views` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '点击',

  `like` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '点赞',

  `comments` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '评论',

  `createtime` int(10) DEFAULT NULL COMMENT '创建时间',

  `updatetime` int(10) DEFAULT NULL COMMENT '更新时间',

  `deletetime` int(10) DEFAULT NULL COMMENT '删除时间',

  PRIMARY KEY (`id`)

) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='发现动态表';



-- 

-- 表的结构 `__PREFIX__wanlshop_find_comments`

-- 

CREATE TABLE IF NOT EXISTS `__PREFIX__wanlshop_find_comments` (

  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',

  `pid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '父ID',

  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',

  `find_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '店铺ID',

  `content` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '内容',

  `like` int(10) DEFAULT '0' COMMENT '喜欢',

  `createtime` int(10) DEFAULT NULL COMMENT '创建时间',

  `updatetime` int(10) DEFAULT NULL COMMENT '更新时间',

  `deletetime` int(10) DEFAULT NULL COMMENT '删除时间',

  `status` enum('normal','hidden') COLLATE utf8mb4_unicode_ci DEFAULT 'normal' COMMENT '状态',

  PRIMARY KEY (`id`) USING BTREE

) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='关注评论表';



-- 

-- 表的结构 `__PREFIX__wanlshop_find_follow`

-- 

CREATE TABLE IF NOT EXISTS `__PREFIX__wanlshop_find_follow` (

  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',

  `user_id` int(10) unsigned DEFAULT '0' COMMENT '用户ID',

  `find_id` int(10) unsigned DEFAULT '0' COMMENT '店铺ID',

  `createtime` int(10) DEFAULT NULL COMMENT '创建时间',

  `updatetime` int(10) DEFAULT NULL COMMENT '更新时间',

  `deletetime` int(10) DEFAULT NULL COMMENT '删除时间',

  `status` enum('normal','hidden') DEFAULT 'normal' COMMENT '状态',

  PRIMARY KEY (`id`) USING BTREE

) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='关注动态表';



-- 

-- 表的结构 `__PREFIX__wanlshop_goods`

-- 

CREATE TABLE IF NOT EXISTS `__PREFIX__wanlshop_goods` (

  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',

  `shop_id` int(10) unsigned DEFAULT '0' COMMENT '店铺ID',

  `shop_category_id` varchar(100) DEFAULT NULL COMMENT '店铺内类目',

  `category_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '商品类目',

  `brand_id` int(10) unsigned DEFAULT '0' COMMENT '品牌ID',

  `category_attribute` longtext COMMENT '类目属性',

  `title` varchar(100) NOT NULL DEFAULT '' COMMENT '商品标题',

  `image` varchar(100) NOT NULL DEFAULT '' COMMENT '商品主图',

  `images` varchar(1500) NOT NULL DEFAULT '' COMMENT '产品相册',

  `description` varchar(255) NOT NULL DEFAULT '' COMMENT '商品描述',

  `flag` set('hot','index','recommend') NOT NULL DEFAULT '' COMMENT '标志(多选):hot=热门,index=首页,recommend=推荐',

  `stock` enum('porder','payment') NOT NULL DEFAULT 'porder' COMMENT '库存计算方式:porder=下单减库存,payment=付款减库存',

  `content` longtext NOT NULL COMMENT '商品详情',

  `freight_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '运费模板',

  `grounding` tinyint(1) NOT NULL DEFAULT '0' COMMENT '上架状态',

  `specs` enum('single','multi') NOT NULL DEFAULT 'single' COMMENT '商品规格:single=单规格,multi=多规格',

  `distribution` enum('true','false') NOT NULL DEFAULT 'false' COMMENT '是否独立分销:true=开启,false=关闭',

  `activity` enum('true','false') NOT NULL DEFAULT 'false' COMMENT '是否活动中:true=是,false=否',

  `views` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '点击',

  `price` decimal(10,2) DEFAULT '0.00' COMMENT '产品价格',

  `sales` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '销量',

  `payment` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '付款人数',

  `comment` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '评论',

  `praise` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '好评',

  `moderate` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '中评',

  `negative` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '差评',

  `like` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '收藏',

  `weigh` int(10) NOT NULL DEFAULT '0' COMMENT '权重',

  `createtime` int(10) DEFAULT NULL COMMENT '创建时间',

  `updatetime` int(10) DEFAULT NULL COMMENT '更新时间',

  `deletetime` int(10) DEFAULT NULL COMMENT '删除时间',

  `status` enum('normal','hidden') DEFAULT 'normal' COMMENT '状态',

  PRIMARY KEY (`id`) USING BTREE

) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='商品表';



-- 

-- 表的结构 `__PREFIX__wanlshop_goods_comment`

-- 

CREATE TABLE IF NOT EXISTS `__PREFIX__wanlshop_goods_comment` (

  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',

  `user_id` int(10) NOT NULL DEFAULT '0' COMMENT '用员ID',

  `shop_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '店铺ID',

  `order_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '订单ID',

  `goods_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '商品ID',

  `order_goods_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '订单商品ID',

  `state` enum('0','1','2') NOT NULL DEFAULT '1' COMMENT '评价:0=好评,1=中评,2=差评',

  `content` text COMMENT '内容',

  `tag` varchar(500) DEFAULT NULL COMMENT '评论标签',

  `suk` text NOT NULL COMMENT '所购买商品SUK',

  `images` varchar(1500) NOT NULL COMMENT '图片组',

  `score` float(3,1) unsigned DEFAULT '0.0' COMMENT '综合评分',

  `score_describe` float(3,1) unsigned DEFAULT '0.0' COMMENT '描述相符',

  `score_service` float(3,1) unsigned DEFAULT '0.0' COMMENT '服务相符',

  `score_deliver` float(3,1) unsigned DEFAULT '0.0' COMMENT '发货相符',

  `score_logistics` float(3,1) unsigned DEFAULT '0.0' COMMENT '物流相符',

  `switch` tinyint(1) DEFAULT '0' COMMENT '匿名评论',

  `createtime` int(10) DEFAULT NULL COMMENT '创建时间',

  `updatetime` int(10) DEFAULT NULL COMMENT '更新时间',

  `deletetime` int(10) DEFAULT NULL COMMENT '删除时间',

  `status` enum('normal','hidden') DEFAULT 'normal' COMMENT '状态',

  PRIMARY KEY (`id`) USING BTREE

) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='商品评论';



-- 

-- 表的结构 `__PREFIX__wanlshop_goods_follow`

-- 

CREATE TABLE IF NOT EXISTS `__PREFIX__wanlshop_goods_follow` (

  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',

  `user_id` int(10) unsigned DEFAULT '0' COMMENT '用户ID',

  `goods_id` int(10) unsigned DEFAULT '0' COMMENT '商品ID',

  `createtime` int(10) DEFAULT NULL COMMENT '创建时间',

  `updatetime` int(10) DEFAULT NULL COMMENT '更新时间',

  `deletetime` int(10) DEFAULT NULL COMMENT '删除时间',

  `status` enum('normal','hidden') DEFAULT 'normal' COMMENT '状态',

  PRIMARY KEY (`id`) USING BTREE

) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='关注商品表';



-- 

-- 表的结构 `__PREFIX__wanlshop_goods_sku`

-- 

CREATE TABLE IF NOT EXISTS `__PREFIX__wanlshop_goods_sku` (

  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',

  `goods_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '商品ID',

  `difference` text COMMENT '规格',

  `price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '商品价格',

  `market_price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '市场价格',

  `stock` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '商品库存',

  `weigh` int(10) NOT NULL DEFAULT '0' COMMENT '商品重量',

  `sn` char(64) NOT NULL DEFAULT '0' COMMENT '商品编码',

  `sales` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '销量',

  `state` enum('0','1') NOT NULL DEFAULT '0' COMMENT '状态:0=新版数据,1=旧版数据',

  `createtime` int(10) DEFAULT NULL COMMENT '创建时间',

  `updatetime` int(10) DEFAULT NULL COMMENT '更新时间',

  `deletetime` int(10) DEFAULT NULL COMMENT '删除时间',

  `status` enum('normal','hidden') DEFAULT 'normal' COMMENT '状态',

  PRIMARY KEY (`id`) USING BTREE

) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='商品SUK表';



-- 

-- 表的结构 `__PREFIX__wanlshop_goods_spu`

-- 

CREATE TABLE IF NOT EXISTS `__PREFIX__wanlshop_goods_spu` (

  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',

  `goods_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '商品ID',

  `name` char(64) NOT NULL DEFAULT '0' COMMENT '规格名称',

  `item` text COMMENT '规格',

  `createtime` int(10) DEFAULT NULL COMMENT '创建时间',

  `updatetime` int(10) DEFAULT NULL COMMENT '更新时间',

  `deletetime` int(10) DEFAULT NULL COMMENT '删除时间',

  `status` enum('normal','hidden') DEFAULT 'normal' COMMENT '状态',

  PRIMARY KEY (`id`) USING BTREE

) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='商品SPU表';



-- 

-- 表的结构 `__PREFIX__wanlshop_icon`

-- 

CREATE TABLE IF NOT EXISTS `__PREFIX__wanlshop_icon` (

  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',

  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '名称',

  `class` varchar(100) NOT NULL DEFAULT '' COMMENT '路径',

  `createtime` int(10) DEFAULT NULL COMMENT '创建时间',

  `updatetime` int(10) DEFAULT NULL COMMENT '更新时间',

  `deletetime` int(10) DEFAULT NULL COMMENT '删除时间',

  `weigh` int(10) NOT NULL DEFAULT '0' COMMENT '权重',

  `status` enum('normal','hidden') NOT NULL DEFAULT 'normal' COMMENT '状态',

  PRIMARY KEY (`id`)

) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='图标表';



-- 

-- 表的结构 `__PREFIX__wanlshop_kuaidi`

-- 

CREATE TABLE IF NOT EXISTS `__PREFIX__wanlshop_kuaidi` (

  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',

  `name` varchar(32) DEFAULT NULL COMMENT '快递名',

  `code` varchar(100) DEFAULT NULL COMMENT '快递编码',

  `logo` varchar(500) DEFAULT NULL COMMENT '快递Logo',

  `tel` varchar(15) DEFAULT NULL COMMENT '快递电话',

  `createtime` int(10) DEFAULT NULL COMMENT '创建时间',

  `updatetime` int(10) DEFAULT NULL COMMENT '更新时间',

  `deletetime` int(10) DEFAULT NULL COMMENT '删除时间',

  `status` enum('normal','hidden') DEFAULT 'normal' COMMENT '状态',

  PRIMARY KEY (`id`)

) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='快递表';



-- 

-- 表的结构 `__PREFIX__wanlshop_kuaidi_sub`

-- 

CREATE TABLE IF NOT EXISTS `__PREFIX__wanlshop_kuaidi_sub` (

  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',

  `sign` varchar(32) NOT NULL COMMENT '运单秘钥',

  `express_no` varchar(100) NOT NULL COMMENT '运单编号',

  `returncode` int(10) DEFAULT NULL COMMENT '返回码',

  `message` varchar(100) DEFAULT NULL COMMENT '提示消息',

  `status` varchar(100) DEFAULT NULL COMMENT '监控状态',

  `state` int(1) DEFAULT '0' COMMENT '监控状态',

  `ischeck` int(1) DEFAULT '0' COMMENT '监控状态',

  `com` varchar(100) DEFAULT NULL COMMENT '提示消息',

  `data` longtext COMMENT '提示消息',

  `createtime` int(10) DEFAULT NULL COMMENT '创建时间',

  `updatetime` int(10) DEFAULT NULL COMMENT '更新时间',

  PRIMARY KEY (`id`)

) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='快递运单表';



-- 

-- 表的结构 `__PREFIX__wanlshop_link`

-- 

CREATE TABLE IF NOT EXISTS `__PREFIX__wanlshop_link` (

  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',

  `type` enum('system','activity','user','product','page') NOT NULL DEFAULT 'system' COMMENT '页面类型:system=系统,activity=活动,user=用户中心,product=商品,page=自定义页面',

  `title` varchar(50) NOT NULL DEFAULT '' COMMENT '页面标题',

  `route` varchar(100) NOT NULL DEFAULT '' COMMENT '路径',

  `createtime` int(10) DEFAULT NULL COMMENT '创建时间',

  `updatetime` int(10) DEFAULT NULL COMMENT '更新时间',

  `deletetime` int(10) DEFAULT NULL COMMENT '删除时间',

  `weigh` int(10) NOT NULL DEFAULT '0' COMMENT '权重',

  `status` enum('normal','hidden') NOT NULL DEFAULT 'normal' COMMENT '状态',

  PRIMARY KEY (`id`)

) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='链接表';



-- 

-- 表的结构 `__PREFIX__wanlshop_live`

-- 

CREATE TABLE IF NOT EXISTS `__PREFIX__wanlshop_live` (

  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',

  `shop_id` int(10) unsigned DEFAULT '0' COMMENT '商家ID',

  `goods_ids` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT NULL COMMENT '类型ID',

  `image` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '直播封面',

  `content` text COLLATE utf8mb4_unicode_ci COMMENT '内容',

  `liveid` varchar(100) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '推流流名',

  `liveurl` varchar(1000) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '推流地址',

  `pushurl` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '播流地址',

  `recordurl` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '录制地址',

  `gestion` varchar(500) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '审核状态',

  `views` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '观看',

  `like` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '点赞',

  `state` enum('0','1','2','3') CHARACTER SET utf8mb4 NOT NULL DEFAULT '0' COMMENT '直播状态:0=未开播,1=正在直播,2=直播结束,3=直播封禁',

  `createtime` int(10) DEFAULT NULL COMMENT '创建时间',

  `updatetime` int(10) DEFAULT NULL COMMENT '更新时间',

  `deletetime` int(10) DEFAULT NULL COMMENT '删除时间',

  PRIMARY KEY (`id`)

) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='直播表';



-- 

-- 表的结构 `__PREFIX__wanlshop_notice`

-- 

CREATE TABLE IF NOT EXISTS `__PREFIX__wanlshop_notice` (

  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',

  `user_id` int(10) DEFAULT '0' COMMENT '用户ID',

  `shop_id` int(10) unsigned DEFAULT '0' COMMENT '店铺ID',

  `image` varchar(200) NOT NULL DEFAULT '' COMMENT '图片',

  `title` varchar(50) NOT NULL DEFAULT '' COMMENT '消息标题',

  `come` varchar(50) NOT NULL DEFAULT '' COMMENT '来自哪里',

  `content` text COMMENT '消息内容',

  `type` enum('order','notice') NOT NULL COMMENT '分类',

  `modules` varchar(10) NOT NULL DEFAULT '' COMMENT '类型:order=订单,refund=退款,live=直播,goods=商品',

  `modules_id` int(10) unsigned DEFAULT '0' COMMENT '所属ID',

  `createtime` int(10) DEFAULT NULL COMMENT '创建时间',

  `updatetime` int(10) DEFAULT NULL COMMENT '更新时间',

  `deletetime` int(10) DEFAULT NULL COMMENT '删除时间',

  `status` enum('normal','hidden') NOT NULL DEFAULT 'normal' COMMENT '状态',

  PRIMARY KEY (`id`)

) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='消息表';



-- 

-- 表的结构 `__PREFIX__wanlshop_order`

-- 

CREATE TABLE IF NOT EXISTS `__PREFIX__wanlshop_order` (

  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',

  `user_id` int(10) NOT NULL DEFAULT '0' COMMENT '用户ID',

  `shop_id` int(10) NOT NULL DEFAULT '0' COMMENT '所属商家',

  `order_no` varchar(18) NOT NULL COMMENT '订单号',

  `address_id` int(10) NOT NULL DEFAULT '0' COMMENT '地址ID',

  `coupon_id` int(10) NOT NULL DEFAULT '0' COMMENT '优惠券ID',

  `isaddress` int(10) NOT NULL DEFAULT '0' COMMENT '是否修改过地址，修改过为1',

  `freight_type` int(10) NOT NULL DEFAULT '0' COMMENT '运费组合策略',

  `express_name` varchar(100) DEFAULT NULL COMMENT '快递公司',

  `express_no` varchar(100) DEFAULT NULL COMMENT '快递号',

  `state` enum('1','2','3','4','5','6','7') NOT NULL DEFAULT '1' COMMENT '订单状态:1=待支付,2=待发货,3=待收货,4=待评论,5=售后订单(已弃用),6=已完成,7=已取消',

  `remarks` varchar(500) DEFAULT NULL COMMENT '订单备注',

  `createtime` int(10) DEFAULT NULL COMMENT '创建时间',

  `paymenttime` int(10) DEFAULT NULL COMMENT '付款时间',

  `delivertime` int(10) DEFAULT NULL COMMENT '发货时间',

  `taketime` int(10) DEFAULT NULL COMMENT '收货时间',

  `dealtime` int(10) DEFAULT NULL COMMENT '成交时间(评论时间)',

  `updatetime` int(10) DEFAULT NULL COMMENT '更新时间',

  `deletetime` int(10) DEFAULT NULL COMMENT '删除时间',

  `status` enum('normal','hidden') DEFAULT 'normal' COMMENT '状态',

  PRIMARY KEY (`id`)

) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='订单表';



-- 

-- 表的结构 `__PREFIX__wanlshop_order_address`

-- 

CREATE TABLE IF NOT EXISTS `__PREFIX__wanlshop_order_address` (

  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',

  `user_id` int(10) NOT NULL DEFAULT '0' COMMENT '用户ID',

  `shop_id` int(10) NOT NULL DEFAULT '0' COMMENT '商家ID',

  `order_id` int(10) NOT NULL DEFAULT '0' COMMENT '订单ID',

  `isaddress` int(10) NOT NULL DEFAULT '0' COMMENT '是否修改过地址',

  `name` varchar(15) NOT NULL DEFAULT '' COMMENT '收货人',

  `mobile` varchar(11) NOT NULL DEFAULT '' COMMENT '手机号',

  `address` varchar(255) NOT NULL COMMENT '详细地址',

  `address_name` varchar(255) NOT NULL COMMENT '地址名称',

  `location` varchar(32) NOT NULL COMMENT '经纬度',

  `createtime` int(10) DEFAULT NULL COMMENT '创建时间',

  `updatetime` int(10) DEFAULT NULL COMMENT '更新时间',

  `deletetime` int(10) DEFAULT NULL COMMENT '删除时间',

  `status` enum('normal','hidden') DEFAULT 'normal' COMMENT '状态',

  PRIMARY KEY (`id`) USING BTREE

) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='订单地址表';



-- 

-- 表的结构 `__PREFIX__wanlshop_order_goods`

-- 

CREATE TABLE IF NOT EXISTS `__PREFIX__wanlshop_order_goods` (

  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',

  `order_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '订单ID',

  `goods_id` int(10) NOT NULL DEFAULT '0' COMMENT '商品ID',

  `shop_id` int(10) NOT NULL DEFAULT '0' COMMENT '店铺ID',

  `shop_name` varchar(32) NOT NULL DEFAULT '' COMMENT '店铺名称',

  `title` varchar(32) NOT NULL DEFAULT '' COMMENT '产品标题',

  `image` varchar(100) NOT NULL DEFAULT '' COMMENT '商品主图',

  `goods_sku_sn` varchar(100) NOT NULL DEFAULT '' COMMENT '商品编码',

  `goods_sku_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '订单ID',

  `difference` varchar(100) NOT NULL DEFAULT '' COMMENT '选择的sku',

  `price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '价格',

  `refund_id` int(10) DEFAULT '0' COMMENT '退款ID',

  `refund_status` enum('0','1','2','3','4','5') DEFAULT '0' COMMENT '退款状态:0=未退款,1=退款中,2=待退货,3=退款完成,4=退款关闭,5=退款被拒',

  `market_price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '市场价',

  `freight_price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '快递价格',

  `discount_price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '优惠价格',

  `number` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '数量',

  `createtime` int(10) DEFAULT NULL COMMENT '创建时间',

  `updatetime` int(10) DEFAULT NULL COMMENT '更新时间',

  `deletetime` int(10) DEFAULT NULL COMMENT '删除时间',

  `status` enum('normal','hidden') DEFAULT 'normal' COMMENT '状态',

  PRIMARY KEY (`id`)

) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='订单商品表';



-- 

-- 表的结构 `__PREFIX__wanlshop_page`

-- 

CREATE TABLE IF NOT EXISTS `__PREFIX__wanlshop_page` (

  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID(id=1首页)',

  `shop_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '店铺ID',

  `name` varchar(100) DEFAULT '自定义页面' COMMENT '页面名称',

  `page_token` varchar(16) DEFAULT NULL COMMENT '页面Token',

  `type` enum('page','shop','index') DEFAULT 'page' COMMENT '页面类型',

  `page` longtext COMMENT '页面配置',

  `item` longtext COMMENT '项目',

  `createtime` int(10) DEFAULT NULL COMMENT '创建时间',

  `updatetime` int(10) DEFAULT NULL COMMENT '更新时间',

  `deletetime` int(10) DEFAULT NULL COMMENT '删除时间',

  `status` enum('normal','hidden') DEFAULT 'normal' COMMENT '状态',

  PRIMARY KEY (`id`) USING BTREE

) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='自定义页面';



-- 

-- 表的结构 `__PREFIX__wanlshop_pay`

-- 

CREATE TABLE IF NOT EXISTS `__PREFIX__wanlshop_pay` (

  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',

  `pay_no` varchar(32) NOT NULL COMMENT '交易号',

  `trade_no` varchar(32) DEFAULT '' COMMENT '交易订单号',

  `user_id` int(10) NOT NULL DEFAULT '0' COMMENT '用户ID',

  `shop_id` int(10) NOT NULL DEFAULT '0' COMMENT '用户ID',

  `order_id` int(10) NOT NULL DEFAULT '0' COMMENT '订单ID',

  `order_no` varchar(18) NOT NULL COMMENT '订单号',

  `pay_type` enum('0','1','2') NOT NULL DEFAULT '0' COMMENT '支付类型:0=余额支付,1=微信支付,2=支付宝支付',

  `pay_state` enum('0','1','2') NOT NULL DEFAULT '0' COMMENT '支付状态 (支付回调):0=未支付,1=已支付,2=已退款',

  `number` int(10) NOT NULL DEFAULT '0' COMMENT '总数',

  `price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '支付金额',

  `order_price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '订单金额',

  `freight_price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '快递金额',

  `coupon_price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '优惠券金额',

  `discount_price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '优惠金额',

  `refund_price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '退款金额',

  `actual_payment` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '实际支付',

  `total_amount` decimal(10,2) unsigned DEFAULT '0.00' COMMENT '总金额',

  `notice` text COMMENT '通知内容',

  `createtime` int(10) DEFAULT NULL COMMENT '创建时间',

  `updatetime` int(10) DEFAULT NULL COMMENT '更新时间',

  `deletetime` int(10) DEFAULT NULL COMMENT '删除时间',

  `status` enum('normal','hidden') DEFAULT 'normal' COMMENT '状态',

  PRIMARY KEY (`id`)

) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='订单支付表 日志类';



-- 

-- 表的结构 `__PREFIX__wanlshop_pay_account`

-- 

CREATE TABLE IF NOT EXISTS `__PREFIX__wanlshop_pay_account` (

  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',

  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',

  `username` varchar(4) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '持卡人姓名',

  `mobile` varchar(11) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '手机号',

  `bankCode` varchar(20) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '类型',

  `bankName` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '名称',

  `cardType` int(1) DEFAULT '0' COMMENT '卡片类型',

  `cardCode` varchar(50) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '账户',

  `createtime` int(10) DEFAULT NULL COMMENT '创建时间',

  `updatetime` int(10) DEFAULT NULL COMMENT '更新时间',

  `deletetime` int(10) DEFAULT NULL COMMENT '删除时间',

  PRIMARY KEY (`id`)

) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='账号表';



-- 

-- 表的结构 `__PREFIX__wanlshop_qrcode`

-- 

CREATE TABLE IF NOT EXISTS `__PREFIX__wanlshop_qrcode` (

  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',

  `admin_id` int(10) NOT NULL DEFAULT '0' COMMENT '管理员ID',

  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '图片名称',

  `template` enum('wanlshopqrlist001','wanlshopqr') NOT NULL DEFAULT 'wanlshopqrlist001' COMMENT '二维码模板:wanlshopqrlist001=海报类型一,wanlshopqr=二维码类型',

  `canvas_width` int(10) unsigned NOT NULL DEFAULT '500' COMMENT '画布宽度',

  `canvas_height` int(10) unsigned NOT NULL DEFAULT '500' COMMENT '画布高度',

  `thumbnail_width` int(10) NOT NULL DEFAULT '54' COMMENT '二维码大小',

  `thumbnail_url` varchar(100) DEFAULT '' COMMENT '封面浓缩图',

  `background_url` varchar(100) DEFAULT '' COMMENT '封面背景图片',

  `logo_src` varchar(100) DEFAULT '' COMMENT 'LOGO图标地址',

  `checked` tinyint(1) DEFAULT '0' COMMENT '选中状态',

  `createtime` int(10) DEFAULT NULL COMMENT '创建时间',

  `updatetime` int(10) DEFAULT NULL COMMENT '更新时间',

  `deletetime` int(10) DEFAULT NULL COMMENT '删除时间',

  `weigh` int(10) NOT NULL DEFAULT '0' COMMENT '权重',

  `status` enum('normal','hidden') DEFAULT 'normal' COMMENT '状态',

  PRIMARY KEY (`id`) USING BTREE

) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='二维码配置表';



-- 

-- 表的结构 `__PREFIX__wanlshop_record`

-- 

CREATE TABLE IF NOT EXISTS `__PREFIX__wanlshop_record` (

  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',

  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '用户ID',

  `shop_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '店铺ID',

  `goods_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '商品ID',

  `category_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '类目ID',

  `category_pid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '类目父ID',

  `uuid` varchar(36) NOT NULL COMMENT 'app唯一编码',

  `ip` varchar(50) DEFAULT NULL COMMENT '设备ip',

  `views` int(64) NOT NULL DEFAULT '1' COMMENT '点击',

  `createtime` int(10) DEFAULT NULL COMMENT '创建时间',

  `updatetime` int(10) DEFAULT NULL COMMENT '更新时间',

  `deletetime` int(10) DEFAULT NULL COMMENT '删除时间',

  `status` enum('normal','hidden') DEFAULT 'normal' COMMENT '状态',

  PRIMARY KEY (`id`) USING BTREE

) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='足迹、我看过谁，谁看过我、数据统计、友好度分析、类目分析表';



-- 

-- 表的结构 `__PREFIX__wanlshop_refund`

-- 

CREATE TABLE IF NOT EXISTS `__PREFIX__wanlshop_refund` (

  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',

  `user_id` int(10) NOT NULL DEFAULT '0' COMMENT '用户ID',

  `shop_id` int(10) NOT NULL DEFAULT '0' COMMENT '店铺ID',

  `order_id` int(10) NOT NULL DEFAULT '0' COMMENT '订单ID',

  `order_pay_id` int(10) NOT NULL DEFAULT '0' COMMENT '支付ID',

  `goods_ids` varchar(100) DEFAULT NULL COMMENT '退款产品',

  `expressType` enum('0','1') NOT NULL DEFAULT '0' COMMENT '物流状态:0=未收到货,1=已收到货',

  `price` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '退款金额',

  `type` enum('0','1') NOT NULL DEFAULT '0' COMMENT '退款类型:0=我要退款(无需退货),1=退货退款',

  `reason` enum('0','1','2','3','4','5','6') NOT NULL DEFAULT '0' COMMENT '退货理由:0=不喜欢,1=空包裹,2=一直未送达,3=颜色/尺码不符,4=质量问题,5=少件漏发,6=假冒品牌',

  `images` text COMMENT '图片',

  `refund_content` text COMMENT '退款理由',

  `refuse_content` text COMMENT '拒绝理由',

  `express_name` varchar(50) DEFAULT NULL COMMENT '快递公司',

  `express_no` varchar(100) DEFAULT NULL COMMENT '快递号',

  `state` enum('0','1','2','3','4','5','6') NOT NULL DEFAULT '0' COMMENT '退款状态:0=申请退款,1=卖家同意,2=卖家拒绝,3=申请平台介入,4=成功退款,5=退款已关闭,6=已提交物流',

  `createtime` int(10) DEFAULT NULL COMMENT '创建时间',

  `agreetime` int(10) DEFAULT NULL COMMENT '同意时间',

  `returntime` int(10) DEFAULT NULL COMMENT '退货时间',

  `rejecttime` int(10) DEFAULT NULL COMMENT '卖家拒绝时间',

  `closingtime` int(10) DEFAULT NULL COMMENT '退款关闭时间',

  `completetime` int(10) DEFAULT NULL COMMENT '完成时间',

  `updatetime` int(10) DEFAULT NULL COMMENT '更新时间',

  `deletetime` int(10) DEFAULT NULL COMMENT '删除时间',

  `status` enum('normal','hidden') DEFAULT 'normal' COMMENT '状态',

  PRIMARY KEY (`id`)

) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='订单退款表';



-- 

-- 表的结构 `__PREFIX__wanlshop_refund_log`

-- 

CREATE TABLE IF NOT EXISTS `__PREFIX__wanlshop_refund_log` (

  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',

  `user_id` int(10) DEFAULT '0' COMMENT '用户ID',

  `refund_id` int(10) NOT NULL DEFAULT '0' COMMENT '退款ID',

  `type` enum('0','1','2','3') NOT NULL DEFAULT '0' COMMENT '退款状态:0=买家,1=卖家,2=官方,3=系统',

  `shop_id` int(10) NOT NULL DEFAULT '0' COMMENT '店铺ID',

  `content` text COMMENT '退款理由',

  `createtime` int(10) DEFAULT NULL COMMENT '创建时间',

  `update_time` int(10) DEFAULT NULL COMMENT '更新时间',

  PRIMARY KEY (`id`)

) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='订单退款日志表';



-- 

-- 表的结构 `__PREFIX__wanlshop_search`

-- 

CREATE TABLE IF NOT EXISTS `__PREFIX__wanlshop_search` (

  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',

  `keywords` varchar(50) NOT NULL DEFAULT '' COMMENT '关键字',

  `flag` set('hot','index','recommend') NOT NULL DEFAULT '' COMMENT '推荐位 :hot=系统热门,index=搜索条,recommend=推荐',

  `views` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '搜索次数',

  `createtime` int(10) DEFAULT NULL COMMENT '创建时间',

  `updatetime` int(10) DEFAULT NULL COMMENT '更新时间',

  `deletetime` int(10) DEFAULT NULL COMMENT '删除时间',

  `weigh` int(10) NOT NULL DEFAULT '0' COMMENT '权重',

  `switch` tinyint(1) NOT NULL DEFAULT '0' COMMENT '开关',

  `status` enum('normal','hidden') DEFAULT 'normal' COMMENT '状态',

  PRIMARY KEY (`id`) USING BTREE

) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='搜索表';



-- 

-- 表的结构 `__PREFIX__wanlshop_shop`

-- 

CREATE TABLE IF NOT EXISTS `__PREFIX__wanlshop_shop` (

  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',

  `user_id` int(10) unsigned DEFAULT '0' COMMENT '会员ID',

  `shopname` varchar(32) NOT NULL DEFAULT '' COMMENT '店铺名称',

  `keywords` varchar(100) NOT NULL DEFAULT '' COMMENT '关键字',

  `description` varchar(255) NOT NULL DEFAULT '' COMMENT '描述',

  `service_ids` varchar(100) DEFAULT '' COMMENT '服务(多选)',

  `avatar` varchar(255) NOT NULL DEFAULT '' COMMENT '店铺头像',

  `state` enum('0','1','2') NOT NULL DEFAULT '1' COMMENT '店铺类型:0=个人,1=企业,2=旗舰',

  `level` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '店铺等级',

  `islive` tinyint(1) NOT NULL DEFAULT '0' COMMENT '直播权限',

  `isself` tinyint(1) NOT NULL DEFAULT '0' COMMENT '是否自营',

  `bio` text NOT NULL COMMENT '店铺简介',

  `city` varchar(100) NOT NULL DEFAULT '' COMMENT '省市',

  `return` varchar(100) NOT NULL DEFAULT '' COMMENT '退货地址',

  `like` int(10) NOT NULL DEFAULT '0' COMMENT '收藏/喜欢',

  `score_describe` float(3,1) NOT NULL DEFAULT '0.0' COMMENT '商品描述',

  `score_service` float(3,1) NOT NULL DEFAULT '0.0' COMMENT '卖家服务',

  `score_deliver` float(3,1) NOT NULL DEFAULT '0.0' COMMENT '发货相符',

  `score_logistics` float(3,1) NOT NULL DEFAULT '0.0' COMMENT '物流服务',

  `weigh` int(10) NOT NULL DEFAULT '0' COMMENT '权重',

  `verify` enum('0','1','2','3','4') NOT NULL DEFAULT '0' COMMENT '审核:0=提交资质,1=提交店铺,2=提交审核,3=通过,4=未通过',

  `createtime` int(10) DEFAULT NULL COMMENT '创店时间',

  `updatetime` int(10) DEFAULT NULL COMMENT '更新时间',

  `deletetime` int(10) DEFAULT NULL COMMENT '删除时间',

  `status` enum('normal','hidden') DEFAULT 'normal' COMMENT '状态',

  PRIMARY KEY (`id`) USING BTREE,

  KEY `shopname` (`shopname`) USING BTREE

) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='店铺表';



-- 

-- 表的结构 `__PREFIX__wanlshop_shop_config`

-- 

CREATE TABLE IF NOT EXISTS `__PREFIX__wanlshop_shop_config` (

  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',

  `shop_id` int(10) NOT NULL DEFAULT '0' COMMENT '店铺ID',

  `freight` enum('0','1','2') NOT NULL DEFAULT '1' COMMENT '运费组合策略:0=运费叠加,1=以最低结算,2=以最高结算',

  `iscloud` enum('0','1') NOT NULL DEFAULT '0' COMMENT '是否开启云打印:0=关闭,1=开启',

  `isauto` enum('0','1') NOT NULL DEFAULT '0' COMMENT '是否云打印自动发货:0=关闭,1=开启',

  `secret` varchar(255) DEFAULT NULL COMMENT 'Secret',

  `key` varchar(255) DEFAULT NULL COMMENT '授权KEY',

  `partnerId` varchar(255) DEFAULT NULL COMMENT '面单账号',

  `partnerKey` varchar(255) DEFAULT NULL COMMENT '面单密码',

  `siid` varchar(255) DEFAULT NULL COMMENT '打印设备码',

  `tempid` varchar(255) DEFAULT NULL COMMENT '模板ID',

  `welcome` text COMMENT '欢迎消息',

  `sendName` varchar(255) DEFAULT NULL COMMENT '姓名(店铺名)',

  `sendPhoneNum` varchar(255) DEFAULT NULL COMMENT '固话/手机',

  `sendAddr` text COMMENT '寄件地址',

  `returnName` varchar(255) DEFAULT NULL COMMENT '姓名(店铺名)',

  `returnPhoneNum` varchar(255) DEFAULT NULL COMMENT '固话/手机',

  `returnAddr` text COMMENT '退货地址',

  `createtime` int(10) DEFAULT NULL COMMENT '创建时间',

  `updatetime` int(10) DEFAULT NULL COMMENT '更新时间',

  PRIMARY KEY (`id`)

) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='店铺配置表';



-- 

-- 表的结构 `__PREFIX__wanlshop_shop_follow`

-- 

CREATE TABLE IF NOT EXISTS `__PREFIX__wanlshop_shop_follow` (

  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',

  `user_id` int(10) unsigned DEFAULT '0' COMMENT '用户ID',

  `shop_id` int(10) unsigned DEFAULT '0' COMMENT '店铺ID',

  `createtime` int(10) DEFAULT NULL COMMENT '创建时间',

  `updatetime` int(10) DEFAULT NULL COMMENT '更新时间',

  `deletetime` int(10) DEFAULT NULL COMMENT '删除时间',

  `status` enum('normal','hidden') DEFAULT 'normal' COMMENT '状态',

  PRIMARY KEY (`id`) USING BTREE

) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='关注店铺表';



-- 

-- 表的结构 `__PREFIX__wanlshop_shop_freight`

-- 

CREATE TABLE IF NOT EXISTS `__PREFIX__wanlshop_shop_freight` (

  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',

  `shop_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '店铺ID',

  `name` varchar(50) NOT NULL DEFAULT '' COMMENT '模板名称',

  `delivery` enum('0','1','2','3','4','5','6','7','8','9','10','11','12','13','14','15','16','17','18') NOT NULL DEFAULT '5' COMMENT '发货时间:0=4小时内,1=8小时内,2=12小时内,3=16小时内,4=20小时内,5=1天内,6=2天内,7=3天内,8=4天内,9=5天内,10=7天内,11=8天内,12=10天内,13=12天内,14=15天内,15=17天内,16=20天内,17=25天内,18=30天内',

  `isdelivery` enum('0','1') NOT NULL DEFAULT '1' COMMENT '是否包邮:0=自定义运费,1=卖家包邮',

  `valuation` enum('0','1','2') NOT NULL DEFAULT '0' COMMENT '计价方式:0=按件数,1=按重量,2=按体积',

  `createtime` int(10) DEFAULT NULL COMMENT '创建时间',

  `updatetime` int(10) DEFAULT NULL COMMENT '更新时间',

  `deletetime` int(10) DEFAULT NULL COMMENT '删除时间',

  `status` enum('normal','hidden') DEFAULT 'normal' COMMENT '状态',

  PRIMARY KEY (`id`) USING BTREE

) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='店铺运费模板';



-- 

-- 表的结构 `__PREFIX__wanlshop_shop_freight_data`

-- 

CREATE TABLE IF NOT EXISTS `__PREFIX__wanlshop_shop_freight_data` (

  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',

  `shop_id` int(10) NOT NULL DEFAULT '0' COMMENT '管理员ID',

  `freight_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '运费模板ID',

  `province` text NOT NULL COMMENT '省份',

  `citys` text NOT NULL COMMENT '城市',

  `first` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '首件',

  `first_fee` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '运费',

  `additional` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '续件',

  `additional_fee` decimal(10,2) unsigned NOT NULL DEFAULT '0.00' COMMENT '续件运费',

  `createtime` int(10) DEFAULT NULL COMMENT '创建时间',

  `updatetime` int(10) DEFAULT NULL COMMENT '更新时间',

  `deletetime` int(10) DEFAULT NULL COMMENT '删除时间',

  `status` enum('normal','hidden') NOT NULL DEFAULT 'normal' COMMENT '状态',

  PRIMARY KEY (`id`)

) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='运费模板数据表';



-- 

-- 表的结构 `__PREFIX__wanlshop_shop_service`

-- 

CREATE TABLE IF NOT EXISTS `__PREFIX__wanlshop_shop_service` (

  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',

  `name` varchar(32) NOT NULL DEFAULT '' COMMENT '服务名称',

  `description` varchar(255) NOT NULL DEFAULT '' COMMENT '服务描述',

  `createtime` int(10) DEFAULT NULL COMMENT '创店时间',

  `updatetime` int(10) DEFAULT NULL COMMENT '更新时间',

  `deletetime` int(10) DEFAULT NULL COMMENT '删除时间',

  `status` enum('normal','hidden') DEFAULT 'normal' COMMENT '状态',

  PRIMARY KEY (`id`) USING BTREE,

  KEY `shopname` (`name`) USING BTREE

) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='店铺服务';



-- 

-- 表的结构 `__PREFIX__wanlshop_shop_sort`

-- 

CREATE TABLE IF NOT EXISTS `__PREFIX__wanlshop_shop_sort` (

  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,

  `shop_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '店铺',

  `pid` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '父ID',

  `name` varchar(30) NOT NULL DEFAULT '' COMMENT '名称',

  `image` varchar(100) NOT NULL DEFAULT '' COMMENT '图片',

  `flag` set('hot','new','recommend') DEFAULT '' COMMENT '标志',

  `isnav` tinyint(1) NOT NULL DEFAULT '1' COMMENT '是否导航显示',

  `createtime` int(10) DEFAULT NULL COMMENT '创建时间',

  `updatetime` int(10) DEFAULT NULL COMMENT '更新时间',

  `weigh` int(10) NOT NULL DEFAULT '0' COMMENT '权重',

  `status` enum('normal','hidden') DEFAULT 'normal' COMMENT '状态',

  PRIMARY KEY (`id`),

  KEY `weigh` (`weigh`,`id`),

  KEY `parent_id` (`pid`)

) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='商家自定义分类';



-- 

-- 表的结构 `__PREFIX__wanlshop_third`

-- 

CREATE TABLE IF NOT EXISTS `__PREFIX__wanlshop_third` (

  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT 'ID',

  `user_id` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '会员ID',

  `platform` varchar(30) NOT NULL DEFAULT '' COMMENT '第三方应用',

  `openid` varchar(100) NOT NULL DEFAULT '' COMMENT '第三方唯一ID',

  `openname` varchar(100) NOT NULL DEFAULT '' COMMENT '第三方会员昵称',

  `access_token` varchar(255) NOT NULL DEFAULT '' COMMENT 'AccessToken',

  `refresh_token` varchar(255) NOT NULL DEFAULT '' COMMENT 'RefreshToken',

  `unionid` varchar(50) NOT NULL DEFAULT '' COMMENT 'UnionId',

  `expires_in` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '有效期',

  `createtime` int(10) unsigned DEFAULT NULL COMMENT '创建时间',

  `updatetime` int(10) unsigned DEFAULT NULL COMMENT '更新时间',

  `logintime` int(10) unsigned DEFAULT NULL COMMENT '登录时间',

  `expiretime` int(10) unsigned DEFAULT NULL COMMENT '过期时间',

  PRIMARY KEY (`id`),

  KEY `user_id` (`user_id`,`platform`)

) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='第三方登录表';



-- 

-- 表的结构 `__PREFIX__withdraw`

--

CREATE TABLE IF NOT EXISTS `__PREFIX__withdraw` (

  `id` int(10) unsigned NOT NULL AUTO_INCREMENT,

  `user_id` int(10) unsigned DEFAULT '0' COMMENT '会员ID',

  `money` decimal(10,2) unsigned DEFAULT '0.00' COMMENT '金额',

  `handingfee` decimal(10,2) unsigned DEFAULT '0.00' COMMENT '手续费',

  `taxes` decimal(10,2) unsigned DEFAULT '0.00' COMMENT '税费',

  `type` varchar(50) DEFAULT '' COMMENT '类型',

  `account` varchar(100) DEFAULT '' COMMENT '提现账户',

  `memo` varchar(255) DEFAULT NULL COMMENT '备注',

  `orderid` varchar(50) DEFAULT '' COMMENT '订单号',

  `transactionid` varchar(50) DEFAULT '' COMMENT '流水号',

  `status` enum('created','successed','rejected') DEFAULT 'created' COMMENT '状态:created=申请中,successed=成功,rejected=已拒绝',

  `transfertime` int(10) DEFAULT NULL COMMENT '转账时间',

  `createtime` int(10) DEFAULT NULL COMMENT '添加时间',

  `updatetime` int(10) DEFAULT NULL COMMENT '更新时间',

  PRIMARY KEY (`id`)

) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='提现表';



-- 

-- 表的结构 `__PREFIX__recharge_order`

--

CREATE TABLE IF NOT EXISTS `__PREFIX__recharge_order` (

  `id` int(10) unsigned NOT NULL AUTO_INCREMENT COMMENT '主键ID',

  `orderid` varchar(100) DEFAULT NULL COMMENT '订单ID',

  `user_id` int(10) unsigned DEFAULT '0' COMMENT '会员ID',

  `amount` double(10,2) unsigned DEFAULT '0.00' COMMENT '订单金额',

  `payamount` double(10,2) unsigned DEFAULT '0.00' COMMENT '支付金额',

  `paytype` varchar(50) DEFAULT NULL COMMENT '支付类型',

  `paytime` int(10) DEFAULT NULL COMMENT '支付时间',

  `ip` varchar(50) DEFAULT NULL COMMENT 'IP地址',

  `useragent` varchar(255) DEFAULT NULL COMMENT 'UserAgent',

  `memo` varchar(255) DEFAULT NULL COMMENT '备注',

  `createtime` int(10) DEFAULT NULL COMMENT '添加时间',

  `updatetime` int(10) DEFAULT NULL COMMENT '更新时间',

  `status` enum('created','paid','expired') DEFAULT 'created' COMMENT '状态',

  PRIMARY KEY (`id`)

) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='充值表';



-- 

-- 表的结构 `__PREFIX__wanlshop_version`

-- 

CREATE TABLE IF NOT EXISTS `__PREFIX__wanlshop_version` (

  `id` int(32) NOT NULL AUTO_INCREMENT COMMENT '客户端版本号',

  `title` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '版本标题',

  `versionName` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '版本名称',

  `versionCode` int(10) NOT NULL DEFAULT '100' COMMENT '版本号',

  `content` text COLLATE utf8mb4_unicode_ci NOT NULL COMMENT '升级内容',

  `androidLink` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '安卓升级文件',

  `iosLink` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT 'IOS升级文件',

  `type` enum('base','alpha','beta','rc','release') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'beta' COMMENT '版本类型:base=结构版,alpha=内测版,beta=公测版,rc=终测版,release=正式版',

  `enforce` tinyint(1) unsigned NOT NULL DEFAULT '0' COMMENT '强制更新',

  `createtime` int(10) NOT NULL DEFAULT '0' COMMENT '创建时间',

  `updatetime` int(10) unsigned NOT NULL DEFAULT '0' COMMENT '更新时间',

  PRIMARY KEY (`id`)

) ENGINE=InnoDB AUTO_INCREMENT=1 DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_unicode_ci COMMENT='版本表';



--

-- 1.0.3升级
-- 旧版本修改表列名
--

ALTER TABLE `__PREFIX__wanlshop_version` CHANGE `app_version` `id` int(32) NOT NULL AUTO_INCREMENT COMMENT '客户端版本号';



--

-- 1.0.3升级
-- 旧版本删除表结构
--

ALTER TABLE `__PREFIX__wanlshop_version` DROP COLUMN `weigh`;

ALTER TABLE `__PREFIX__wanlshop_version` DROP COLUMN `status`;

ALTER TABLE `__PREFIX__wanlshop_version` DROP COLUMN `packagesize`;

ALTER TABLE `__PREFIX__wanlshop_version` DROP COLUMN `downloadurl`;

ALTER TABLE `__PREFIX__wanlshop_version` DROP COLUMN `ad_version`;

ALTER TABLE `__PREFIX__wanlshop_version` DROP COLUMN `service_version`;

ALTER TABLE `__PREFIX__wanlshop_version` DROP COLUMN `blacklist`;



--

-- 1.0.3升级
-- 旧版本增加表结构
--

ALTER TABLE `__PREFIX__wanlshop_version` ADD COLUMN `title` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '版本标题';

ALTER TABLE `__PREFIX__wanlshop_version` ADD COLUMN `versionName` varchar(32) COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT '' COMMENT '版本名称';

ALTER TABLE `__PREFIX__wanlshop_version` ADD COLUMN `versionCode` int(10) NOT NULL DEFAULT '100' COMMENT '版本号';

ALTER TABLE `__PREFIX__wanlshop_version` ADD COLUMN `androidLink` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT '安卓升级文件';

ALTER TABLE `__PREFIX__wanlshop_version` ADD COLUMN `iosLink` varchar(500) COLLATE utf8mb4_unicode_ci DEFAULT '' COMMENT 'IOS升级文件';

ALTER TABLE `__PREFIX__wanlshop_version` ADD COLUMN `type` enum('base','alpha','beta','rc','release') COLLATE utf8mb4_unicode_ci NOT NULL DEFAULT 'beta' COMMENT '版本类型:base=结构版,alpha=内测版,beta=公测版,rc=终测版,release=正式版';



--

-- 1.0.2升级
-- 旧版本新增表结构
--
ALTER TABLE `__PREFIX__user_money_log` ADD COLUMN `type` enum('pay','recharge','withdraw','refund','sys') NULL DEFAULT 'sys' COMMENT '业务类型:pay=商品交易,recharge=充值,withdraw=提现,refund=退款,sys=系统业务' AFTER `memo`;



--
-- 旧版本修复表结构
--
ALTER TABLE `__PREFIX__user_money_log` ADD COLUMN `service_ids` varchar(100) NULL DEFAULT '' COMMENT '业务ID' AFTER `type`;



--

-- 1.0.2升级
-- 旧版本修复表结构 
--
ALTER TABLE `__PREFIX__user_money_log` MODIFY COLUMN `type` enum('pay','recharge','withdraw','refund','sys') NULL DEFAULT 'sys' COMMENT '业务类型:pay=商品交易,recharge=充值,withdraw=提现,refund=退款,sys=系统业务' AFTER `memo`;



--

-- 1.0.2升级
-- 旧版本新增表结构 welcome
--
ALTER TABLE `__PREFIX__wanlshop_shop_config` ADD COLUMN `welcome` text NULL COMMENT '欢迎消息' AFTER `tempid`;



--
-- 转存表中的数据 `__PREFIX__wanlshop_advert`
--

INSERT INTO `__PREFIX__wanlshop_advert` (`id`, `admin_id`, `module`, `category_id`, `type`, `media`, `url`, `title`, `content`, `city`, `startdate`, `enddate`, `views`, `show`, `createtime`, `updatetime`, `deletetime`, `weigh`, `status`) VALUES

(1, 0, 'open', 0, 'image', '/assets/addons/wanlshop/img/show/open_img.jpg', '', '', '', '', '2020-03-23', '2020-03-23', 0, 0, 1584944842, 1595924315, null, 1, 'hidden'),

(2, 0, 'page', 0, 'image', '/assets/addons/wanlshop/img/show/page_img.png', '/pages/page/index?id=31BdtOZ5XrRm4yCE', '', '', '', '2020-04-29', '2020-04-29', 0, 0, 1588094504, 1601211172, null, 2, 'normal'),

(3, 0, 'page', 0, 'banner', '/assets/addons/wanlshop/img/show/page_swiper.png', '/pages/page/index?id=31BdtOZ5XrRm4yCE', '', '', '', '2020-06-03', '2020-06-03', 0, 0, 1591150702, 1591182586, null, 3, 'normal'),

(4, 0, 'first', 0, 'image', '/assets/addons/wanlshop/img/show/start-up-2.png', '钱包 支付/实时充值 消费明细 一目了然/#fd6600', '', '', '', '2020-06-14', '2020-06-14', 0, 0, 1592085907, 1601666871, null, 4, 'normal'),

(5, 0, 'first', 0, 'image', '/assets/addons/wanlshop/img/show/start-up-3.png', 'VUEX 购物车/购物车云同步 登录合并离线购物车/#0fbfa7', '', '', '', '2020-10-03', '2020-10-03', 0, 0, 1601666545, 1601666733, null, 5, 'normal'),

(6, 0, 'first', 0, 'image', '/assets/addons/wanlshop/img/show/start-up-1.png', 'IM 即时通讯/全新升级 断线重连 无延迟更可靠/#299af8', '', '', '', '2020-10-04', '2020-10-04', 0, 0, 1601770360, 1601771476, null, 6, 'normal'),

(7, 0, 'category', 10, 'image', '/assets/addons/wanlshop/img/show/category_img.jpg', '/pages/page/index?id=31BdtOZ5XrRm4yCE', '类目广告', '', '', '2020-09-24', '2020-09-24', 0, 0, 1600955320, 1601036346, null, 7, 'normal'),

(8, 0, 'first', 0, 'image', '/assets/addons/wanlshop/img/show/start-up-3.png', 'VUEX 购物车/购物车云同步 登录合并离线购物车/#0fbfa7', '', '', '', '2020-10-03', '2020-10-03', 0, 0, 1601666545, 1601666733, null, 8, 'normal');



--
-- 转存表中的数据 `__PREFIX__wanlshop_shop_service`
--
INSERT INTO `__PREFIX__wanlshop_shop_service` (`id`, `name`, `description`, `createtime`, `updatetime`, `deletetime`, `status`) VALUES
(1, '7天无理由退款', '满足退款条件，用户可申请七天无理由退款', 1567297121, 1567297121, null, 'normal'),

(2, '24小时内发货', '商家保障，24小时内发出货品', 1567297121, 1567297121, null, 'normal'),

(3, '48小时内发货', '商家保障，48小时内发出货品', 1567297121, 1567297121, null, 'normal'),

(4, '急速退款', '信誉用户在退货后，急速退款至账户', 1567297121, 1567297121, null, 'normal'),

(5, '假一赔十', '正品保障，假一赔十', 1567297121, 1567297121, null, 'normal');



--
-- 转存表中的数据 `__PREFIX__wanlshop_kuaidi`
--

INSERT INTO `__PREFIX__wanlshop_kuaidi` (`id`, `name`, `code`, `logo`, `tel`, `createtime`, `updatetime`, `deletetime`, `status`) VALUES
(1, '顺丰速运', 'shunfeng', '/assets/addons/wanlshop/img/kuaidi/shunfeng.png', '95338', null, null, null, 'normal'),

(2, '邮政快递包裹', 'youzhengguonei', '/assets/addons/wanlshop/img/kuaidi/youzheng.png', '11185', null, null, null, 'normal'),

(3, '京东物流', 'jd', '/assets/addons/wanlshop/img/kuaidi/JD.png', '950616', null, null, null, 'normal'),

(4, '韵达快递', 'yunda', '/assets/addons/wanlshop/img/kuaidi/yunda.png', '95546', null, null, null, 'normal'),

(5, 'EMS', 'ems', '/assets/addons/wanlshop/img/kuaidi/EMS.png', '11183', null, null, null, 'normal'),

(6, '圆通速递', 'yuantong', '/assets/addons/wanlshop/img/kuaidi/yuantong.png', '95554', null, null, null, 'normal'),

(7, '中通快递', 'zhongtong', '/assets/addons/wanlshop/img/kuaidi/zhongtong.png', '95311', null, null, null, 'normal'),

(8, '百世快递', 'huitongkuaidi', '/assets/addons/wanlshop/img/kuaidi/huitongkuaidi.png', '95320', null, null, null, 'normal'),

(9, '申通快递', 'shentong', '/assets/addons/wanlshop/img/kuaidi/shentong.png', '95543', null, null, null, 'normal'),

(10, '邮政标准快递', 'youzhengbk', '/assets/addons/wanlshop/img/kuaidi/youzheng.png', '11183', null, null, null, 'normal'),

(11, '宅急送', 'zhaijisong', '/assets/addons/wanlshop/img/kuaidi/zhaijisong.png', '400-678-9000', null, null, null, 'normal'),

(12, '天天快递', 'tiantian', '/assets/addons/wanlshop/img/kuaidi/tiantian.png', '400-188-8888', null, null, null, 'normal'),

(13, 'TransRush', 'transrush', '', '114', null, null, null, 'normal'),

(14, '德邦物流', 'debangwuliu', '/assets/addons/wanlshop/img/kuaidi/debang.png', '95353', null, null, null, 'normal'),

(15, '百世快运', 'baishiwuliu', '/assets/addons/wanlshop/img/kuaidi/huitongkuaidi.png', '400-885-6561', null, null, null, 'normal'),

(16, '国际包裹', 'youzhengguoji', '/assets/addons/wanlshop/img/kuaidi/youzheng.png', '114', null, null, null, 'normal'),

(17, 'EMS-国际件', 'emsguoji', '/assets/addons/wanlshop/img/kuaidi/EMS.png', '11183', null, null, null, 'normal'),

(18, '丹鸟', 'danniao', null, '400-855-5566', null, null, null, 'normal'),

(19, '全峰快递', 'quanfengkuaidi', '/assets/addons/wanlshop/img/kuaidi/quanfengkuaidi.png', '400-698-0398', null, null, null, 'normal'),

(20, '苏宁物流', 'suning', '/assets/addons/wanlshop/img/kuaidi/suning.png', '95315', null, null, null, 'normal'),

(21, 'EWE全球快递', 'ewe', '/assets/addons/wanlshop/img/kuaidi/ewe.png', '400-600-8183', null, null, null, 'normal'),

(22, 'USPS', 'usps', null, '800-275-8777', null, null, null, 'normal'),

(23, '优速快递', 'youshuwuliu', '/assets/addons/wanlshop/img/kuaidi/youshu.png', '95349', null, null, null, 'normal'),

(24, '德邦快递', 'debangkuaidi', '/assets/addons/wanlshop/img/kuaidi/debang.png', '95353', null, null, null, 'normal'),

(25, '自提', 'ziti', null, '114', null, null, null, 'normal');



--
-- 转存表中的数据 `__PREFIX__wanlshop_icon`
--
INSERT INTO `__PREFIX__wanlshop_icon` (`id`, `name`, `class`, `createtime`, `updatetime`, `deletetime`, `weigh`, `status`) VALUES

(1, '失败', 'wlIcon-shibai', 1588155199, 1588155199, null, 1, 'normal'),

(2, '拼团-团购成功', 'wlIcon-pintuantuangouchenggong', 1588155199, 1588155199, null, 2, 'normal'),

(3, '设置', 'wlIcon-shezhi1', 1588155199, 1588155199, null, 3, 'normal'),

(4, '一起拼', 'wlIcon-yiqipin', 1588155199, 1588155199, null, 4, 'normal'),

(5, '企业', 'wlIcon-qiye', 1588155199, 1588155199, null, 5, 'normal'),

(6, '旗舰店2', 'wlIcon-qijiandian', 1588155199, 1588155199, null, 6, 'normal'),

(7, '个人店', 'wlIcon-gerendian', 1588155199, 1588155199, null, 7, 'normal'),

(8, '差评', 'wlIcon-chaping', 1588155199, 1588155199, null, 8, 'normal'),

(9, '好评', 'wlIcon-haoping', 1588155199, 1588155199, null, 9, 'normal'),

(10, '首页-中差评', 'wlIcon-zhongchaping', 1588155199, 1588155199, null, 10, 'normal'),

(11, '公共-好评', 'wlIcon-haoping1', 1588155199, 1588155199, null, 11, 'normal'),

(12, '图片', 'wlIcon-tupian1', 1588155199, 1588155199, null, 12, 'normal'),

(13, '发送', 'wlIcon-zhifeiji', 1588155199, 1588155199, null, 13, 'normal'),

(14, '发送', 'wlIcon-fasong', 1588155199, 1588155199, null, 14, 'normal'),

(15, '服务星1', 'wlIcon-fuwuxing', 1588155199, 1588155199, null, 15, 'normal'),

(16, '举报', 'wlIcon-jubao', 1588155199, 1588155199, null, 16, 'normal'),

(17, '菜单管理', 'wlIcon-caidanguanli_', 1588155199, 1588155199, null, 17, 'normal'),

(18, '关闭', 'wlIcon-guanbi1', 1588155199, 1588155199, null, 18, 'normal'),

(19, '话筒-01', 'wlIcon-huatong01', 1588155199, 1588155199, null, 19, 'normal'),

(20, '语音 话筒', 'wlIcon-icon-test', 1588155199, 1588155199, null, 20, 'normal'),

(21, '表情', 'wlIcon-biaoqing2', 1588155199, 1588155199, null, 21, 'normal'),

(22, '表情', 'wlIcon-emoji_icon', 1588155199, 1588155199, null, 22, 'normal'),

(23, '语音-右', 'wlIcon-yuyinyou', 1588155199, 1588155199, null, 23, 'normal'),

(24, '语音-左', 'wlIcon-yuyinzuo', 1588155199, 1588155199, null, 24, 'normal'),

(25, '评价-拍照', 'wlIcon-pingjiapaizhao', 1588155199, 1588155199, null, 25, 'normal'),

(26, '加号（圆圈）', 'wlIcon-yuanquanjiahao', 1588155199, 1588155199, null, 26, 'normal'),

(27, '加', 'wlIcon-wuuiconxiangjifangda', 1588155199, 1588155199, null, 27, 'normal'),

(28, '智能语音交互', 'wlIcon-zhinengyuyinjiaohu', 1588155199, 1588155199, null, 28, 'normal'),

(29, '键盘切换', 'wlIcon-jianpanqiehuan', 1588155199, 1588155199, null, 29, 'normal'),

(30, '语音', 'wlIcon-yuyin', 1588155199, 1588155199, null, 30, 'normal'),

(31, '引号', 'wlIcon-miao', 1588155199, 1588155199, null, 31, 'normal'),

(32, '快照备份与恢复', 'wlIcon-kuaizhaobeifenyuhuifu', 1588155199, 1588155199, null, 32, 'normal'),

(33, '发布', 'wlIcon-fabu', 1588155199, 1588155199, null, 33, 'normal'),

(34, '服务器', 'wlIcon-fuwuqi', 1588155199, 1588155199, null, 34, 'normal'),

(35, '服务器', 'wlIcon-fuwuqi1', 1588155199, 1588155199, null, 35, 'normal'),

(36, '标题', 'wlIcon-categoryTitle', 1588155199, 1588155199, null, 36, 'normal'),

(37, '播放', 'wlIcon-bofang', 1588155199, 1588155199, null, 37, 'normal'),

(38, '轮播效果', 'wlIcon-banner', 1588155199, 1588155199, null, 38, 'normal'),

(39, '图片', 'wlIcon-image', 1588155199, 1588155199, null, 39, 'normal'),

(40, '公告', 'wlIcon-notice', 1588155199, 1588155199, null, 40, 'normal'),

(41, '秒杀', 'wlIcon-seckill', 1588155199, 1588155199, null, 41, 'normal'),

(42, '分类', 'wlIcon-menu', 1588155199, 1588155199, null, 42, 'normal'),

(43, '文章管理02', 'wlIcon-article', 1588155199, 1588155199, null, 43, 'normal'),

(44, '视频', 'wlIcon-video', 1588155199, 1588155199, null, 44, 'normal'),

(45, '活动', 'wlIcon-activity', 1588155199, 1588155199, null, 45, 'normal'),

(46, '活动', 'wlIcon-navicon-hd', 1588155199, 1588155199, null, 46, 'normal'),

(47, '商品', 'wlIcon-goods', 1588155199, 1588155199, null, 47, 'normal'),

(48, '商品', 'wlIcon-shangpin1', 1588155199, 1588155199, null, 48, 'normal'),

(49, '喜欢', 'wlIcon-likes', 1588155199, 1588155199, null, 49, 'normal'),

(50, '砍价活动', 'wlIcon-bargain', 1588155199, 1588155199, null, 50, 'normal'),

(51, '空的_empty38', 'wlIcon-empty', 1588155199, 1588155199, null, 51, 'normal'),

(52, '搜索', 'wlIcon-search', 1588155199, 1588155199, null, 52, 'normal'),

(53, '分割线', 'wlIcon-division', 1588155199, 1588155199, null, 53, 'normal'),

(54, '商品管理', 'wlIcon-classify', 1588155199, 1588155199, null, 54, 'normal'),

(55, '电池 (3)', 'wlIcon-dianchifull', 1588155199, 1588155199, null, 55, 'normal'),

(56, 'WIFI', 'wlIcon-WIFI', 1588155199, 1588155199, null, 56, 'normal'),

(57, '信号', 'wlIcon-xinhao', 1588155199, 1588155199, null, 57, 'normal'),

(58, '电话', 'wlIcon-dianhua', 1588155199, 1588155199, null, 58, 'normal'),

(59, '积分2', 'wlIcon-tubiao309', 1588155199, 1588155199, null, 59, 'normal'),

(60, '会员中心', 'wlIcon-huiyuanzhongxin', 1588155199, 1588155199, null, 60, 'normal'),

(61, '签到', 'wlIcon-qiandao', 1588155199, 1588155199, null, 61, 'normal'),

(62, '帮助', 'wlIcon-bangzhu1', 1588155199, 1588155199, null, 62, 'normal'),

(63, '秒杀', 'wlIcon-miaosha', 1588155199, 1588155199, null, 63, 'normal'),

(64, '帮助', 'wlIcon-bangzhu2', 1588155199, 1588155199, null, 64, 'normal'),

(65, '扫一扫', 'wlIcon-saoyisao-copy', 1588155199, 1588155199, null, 65, 'normal'),

(66, '帮助 (1)', 'wlIcon-leimu', 1588155199, 1588155199, null, 66, 'normal'),

(67, '加载', 'wlIcon-jiazai', 1588155199, 1588155199, null, 67, 'normal'),

(68, '男', 'wlIcon-nan', 1588155200, 1588155200, null, 68, 'normal'),

(69, '女', 'wlIcon-nv', 1588155200, 1588155200, null, 69, 'normal'),

(70, '小米', 'wlIcon-Xiaomi', 1588155200, 1588155200, null, 70, 'normal'),

(71, '更多', 'wlIcon-gengduo1', 1588155200, 1588155200, null, 71, 'normal'),

(72, '微信', 'wlIcon-WeChat', 1588155200, 1588155200, null, 72, 'normal'),

(73, '微博', 'wlIcon-WeiBo', 1588155200, 1588155200, null, 73, 'normal'),

(74, 'QQ', 'wlIcon-QQ', 1588155200, 1588155200, null, 74, 'normal'),

(75, '余额', 'wlIcon-yue', 1588155200, 1588155200, null, 75, 'normal'),

(76, '支付宝支付', 'wlIcon-zhifubaozhifu', 1588155200, 1588155200, null, 76, 'normal'),

(77, '微信 支付', 'wlIcon-weixinzhifu', 1588155200, 1588155200, null, 77, 'normal'),

(78, '位置', 'wlIcon-weizhi1', 1588155200, 1588155200, null, 78, 'normal'),

(79, '商品', 'wlIcon-baobei', 1588155200, 1588155200, null, 79, 'normal'),

(80, '关注', 'wlIcon-guanzhu', 1588155200, 1588155200, null, 80, 'normal'),

(81, '足迹', 'wlIcon-zuji1', 1588155200, 1588155200, null, 81, 'normal'),

(82, '关注', 'wlIcon-guanzhu3', 1588155200, 1588155200, null, 82, 'normal'),

(83, '列表', 'wlIcon-listing-jf', 1588155200, 1588155200, null, 83, 'normal'),

(84, '列表', 'wlIcon-liebiao', 1588155200, 1588155200, null, 84, 'normal'),

(85, '筛选', 'wlIcon-shaixuan', 1588155200, 1588155200, null, 85, 'normal'),

(86, '垃圾桶', 'wlIcon-lajitong', 1588155200, 1588155200, null, 86, 'normal'),

(87, '火苗', 'wlIcon-huomiao2', 1588155200, 1588155200, null, 87, 'normal'),

(88, '点', 'wlIcon-dot', 1588155200, 1588155200, null, 88, 'normal'),

(89, '类目 品类 分类 类别.2', 'wlIcon-lei', 1588155200, 1588155200, null, 89, 'normal'),

(90, '头条', 'wlIcon-toutiao', 1588155200, 1588155200, null, 90, 'normal'),

(91, '头条', 'wlIcon-headlines', 1588155200, 1588155200, null, 91, 'normal'),

(92, '消息中心', 'wlIcon-xiaoxizhongxin', 1588155200, 1588155200, null, 92, 'normal'),

(93, '使用帮助1', 'wlIcon-shiyongbangzhu1', 1588155200, 1588155200, null, 93, 'normal'),

(94, '清空', 'wlIcon-qingkong', 1588155200, 1588155200, null, 94, 'normal'),

(95, '设置', 'wlIcon-shezhi', 1588155200, 1588155200, null, 95, 'normal'),

(96, '认证-01', 'wlIcon-guanfang', 1588155200, 1588155200, null, 96, 'normal'),

(97, '个人关注', 'wlIcon-gerenguanzhu', 1588155200, 1588155200, null, 97, 'normal'),

(98, '已关注', 'wlIcon-yiguanzhu1', 1588155200, 1588155200, null, 98, 'normal'),

(99, '分享', 'wlIcon-fenxiangcopy', 1588155200, 1588155200, null, 99, 'normal'),

(100, '位置', 'wlIcon-weizhi', 1588155200, 1588155200, null, 100, 'normal'),

(101, '购物车', 'wlIcon-gouwuche', 1588155200, 1588155200, null, 101, 'normal'),

(102, '客服', 'wlIcon-kefu', 1588155200, 1588155200, null, 102, 'normal'),

(103, '提示', 'wlIcon-tishi1', 1588155200, 1588155200, null, 103, 'normal'),

(104, '物流 卡车2', 'wlIcon-wuliuqiache2', 1588155200, 1588155200, null, 104, 'normal'),

(105, '留言2', 'wlIcon-liuyan-fill', 1588155200, 1588155200, null, 105, 'normal'),

(106, '通知', 'wlIcon-tongzhi', 1588155200, 1588155200, null, 106, 'normal'),

(107, '店铺', 'wlIcon-dianpu1', 1588155200, 1588155200, null, 107, 'normal'),

(108, '店铺', 'wlIcon-dianpu2', 1588155200, 1588155200, null, 108, 'normal'),

(109, '减', 'wlIcon-jian', 1588155200, 1588155200, null, 109, 'normal'),

(110, '添加', 'wlIcon-tianjia', 1588155200, 1588155200, null, 110, 'normal'),

(111, '分期－完成', 'wlIcon-wancheng', 1588155200, 1588155200, null, 111, 'normal'),

(112, '好房拓 4.0.0 iconfont_完成-82', 'wlIcon-ok', 1588155200, 1588155200, null, 112, 'normal'),

(113, '派送', 'wlIcon-yunshuzhong', 1588155200, 1588155200, null, 113, 'normal'),

(114, '派送提醒-物流详情', 'wlIcon-paisongtixing', 1588155200, 1588155200, null, 114, 'normal'),

(115, '猜你喜欢', 'wlIcon-cainixihuan', 1588155200, 1588155200, null, 115, 'normal'),

(116, '分销', 'wlIcon-fenxiao', 1588155200, 1588155200, null, 116, 'normal'),

(117, '砍价', 'wlIcon-kanjia', 1588155200, 1588155200, null, 117, 'normal'),

(118, '客服', 'wlIcon-unie737', 1588155200, 1588155200, null, 118, 'normal'),

(119, '钱包', 'wlIcon-qianbao', 1588155200, 1588155200, null, 119, 'normal'),

(120, '地址', 'wlIcon-dizhi', 1588155200, 1588155200, null, 120, 'normal'),

(121, '拼团', 'wlIcon-pintuan', 1588155200, 1588155200, null, 121, 'normal'),

(122, '待付款', 'wlIcon-daifukuan', 1588155200, 1588155200, null, 122, 'normal'),

(123, '待收货', 'wlIcon-daishouhuo', 1588155200, 1588155200, null, 123, 'normal'),

(124, '待发货', 'wlIcon-daifahuo', 1588155200, 1588155200, null, 124, 'normal'),

(125, '个人二维码', 'wlIcon-gerenerweima', 1588155200, 1588155200, null, 125, 'normal'),

(126, '售后服务-差评防御', 'wlIcon-shouhou', 1588155200, 1588155200, null, 126, 'normal'),

(127, '售后服务-自动评价', 'wlIcon-daipinglun', 1588155200, 1588155200, null, 127, 'normal'),

(128, '新浪', 'wlIcon-xinlang', 1588155200, 1588155200, null, 128, 'normal'),

(129, '微信', 'wlIcon-weixin', 1588155200, 1588155200, null, 129, 'normal'),

(130, '二维码', 'wlIcon-erweima', 1588155200, 1588155200, null, 130, 'normal'),

(131, '钱包', 'wlIcon-qianbao-', 1588155200, 1588155200, null, 131, 'normal'),

(132, '退款', 'wlIcon-tuikuan', 1588155200, 1588155200, null, 132, 'normal'),

(133, '红包', 'wlIcon-tuikuan1', 1588155200, 1588155200, null, 133, 'normal'),

(134, '3.1语音-选中', 'wlIcon-31yuyinxuanzhong', 1588155200, 1588155200, null, 134, 'normal'),

(135, '3.1语音', 'wlIcon-31yuyin', 1588155200, 1588155200, null, 135, 'normal'),

(136, '3.1关闭', 'wlIcon-31guanbi', 1588155200, 1588155200, null, 136, 'normal'),

(137, '3.1选择', 'wlIcon-31xuanze', 1588155200, 1588155200, null, 137, 'normal'),

(138, '3.1选中', 'wlIcon-31xuanzhong', 1588155200, 1588155200, null, 138, 'normal'),

(139, '3.1已关注店铺', 'wlIcon-31yiguanzhudianpu', 1588155200, 1588155200, null, 139, 'normal'),

(140, '3.1店铺', 'wlIcon-31dianpu', 1588155200, 1588155200, null, 140, 'normal'),

(141, '3.1分享', 'wlIcon-31fenxiang', 1588155200, 1588155200, null, 141, 'normal'),

(142, '3.1转发', 'wlIcon-31zhuanfa', 1588155200, 1588155200, null, 142, 'normal'),

(143, '3.1待发货', 'wlIcon-31daifahuo', 1588155200, 1588155200, null, 143, 'normal'),

(144, '3.1待付款', 'wlIcon-31daifukuan', 1588155200, 1588155200, null, 144, 'normal'),

(145, '3.1待收货', 'wlIcon-31daishouhuo', 1588155200, 1588155200, null, 145, 'normal'),

(146, '3.1待评价', 'wlIcon-31daipingjia', 1588155200, 1588155200, null, 146, 'normal'),

(147, '3.1退款退货', 'wlIcon-tuikuantuihuo', 1588155200, 1588155200, null, 147, 'normal'),

(148, '3.1会员卡', 'wlIcon-31huiyuanqia', 1588155200, 1588155200, null, 148, 'normal'),

(149, '3.1优惠券', 'wlIcon-31youhuiquan', 1588155200, 1588155200, null, 149, 'normal'),

(150, '3.1红包', 'wlIcon-31hongbao', 1588155200, 1588155200, null, 150, 'normal'),

(151, '3.1购物车-选中', 'wlIcon-31gouwuchexuanzhong', 1588155200, 1588155200, null, 151, 'normal'),

(152, '3.1购物车', 'wlIcon-31gouwuche', 1588155200, 1588155200, null, 152, 'normal'),

(153, '3.1关注-选中', 'wlIcon-31guanzhuxuanzhong', 1588155200, 1588155200, null, 153, 'normal'),

(154, '3.1关注', 'wlIcon-31guanzhu', 1588155200, 1588155200, null, 154, 'normal'),

(155, '3.1首页-选中', 'wlIcon-31shouyexuanzhong', 1588155200, 1588155200, null, 155, 'normal'),

(156, '3.1首页', 'wlIcon-31shouye', 1588155200, 1588155200, null, 156, 'normal'),

(157, '3.1我的-选中', 'wlIcon-31wodexuanzhong', 1588155200, 1588155200, null, 157, 'normal'),

(158, '3.1我的', 'wlIcon-31wode', 1588155200, 1588155200, null, 158, 'normal'),

(159, '3.1-降价', 'wlIcon-jiangjia', 1588155200, 1588155200, null, 159, 'normal'),

(160, '礼物 活动', 'wlIcon-liwuhuodong', 1588155200, 1588155200, null, 160, 'normal'),

(161, '3.1-剪裁', 'wlIcon-31jiancai', 1588155200, 1588155200, null, 161, 'normal'),

(162, '列表模式', 'wlIcon-liebiaomoshi', 1588155200, 1588155200, null, 162, 'normal'),

(163, '中图模式', 'wlIcon-zhongtumoshi', 1588155200, 1588155200, null, 163, 'normal'),

(164, '查看', 'wlIcon-chakan', 1588155200, 1588155200, null, 164, 'normal'),

(165, '关闭', 'wlIcon-guanbi', 1588155200, 1588155200, null, 165, 'normal'),

(166, '关注', 'wlIcon-guanzhu2', 1588155200, 1588155200, null, 166, 'normal'),

(167, '火热', 'wlIcon-huore', 1588155200, 1588155200, null, 167, 'normal'),

(168, '喇叭', 'wlIcon-laba', 1588155200, 1588155200, null, 168, 'normal'),

(169, '3.1铃铛', 'wlIcon-lingdang', 1588155200, 1588155200, null, 169, 'normal'),

(170, '3.1拍摄-选中', 'wlIcon-31paishexuanzhong', 1588155200, 1588155200, null, 170, 'normal'),

(171, '3.1拍摄', 'wlIcon-31paishe', 1588155200, 1588155200, null, 171, 'normal'),

(172, '3.1购买充值', 'wlIcon-31goumaichongzhi', 1588155200, 1588155200, null, 172, 'normal'),

(173, '3.1关注1-选中', 'wlIcon-31guanzhu1xuanzhong', 1588155200, 1588155200, null, 173, 'normal'),

(174, '返回2', 'wlIcon-fanhuigengduo', 1588155200, 1588155200, null, 174, 'normal'),

(175, '3.1关注1', 'wlIcon-31guanzhu1', 1588155200, 1588155200, null, 175, 'normal'),

(176, '3.1回到顶部', 'wlIcon-31huidaodingbu', 1588155200, 1588155200, null, 176, 'normal'),

(177, '3.1 会员', 'wlIcon-31huiyuan', 1588155200, 1588155200, null, 177, 'normal'),

(178, '3.1 下拉', 'wlIcon-31xiala', 1588155200, 1588155200, null, 178, 'normal'),

(179, '3.1提示', 'wlIcon-31tishi', 1588155200, 1588155200, null, 179, 'normal'),

(180, '3.1 好友', 'wlIcon-31haoyou', 1588155200, 1588155200, null, 180, 'normal'),

(181, '分类', 'wlIcon-fenlei', 1588155200, 1588155200, null, 181, 'normal'),

(182, '扫一扫，猫客', 'wlIcon-saoyisao', 1588155200, 1588155200, null, 182, 'normal'),

(183, '三角1', 'wlIcon-jiang', 1588155200, 1588155200, null, 183, 'normal'),

(184, '搜索，猫客', 'wlIcon-sousuo', 1588155200, 1588155200, null, 184, 'normal'),

(185, '三角2', 'wlIcon-sheng', 1588155200, 1588155200, null, 185, 'normal'),

(186, '产品参数', 'wlIcon-chanpincanshu', 1588155200, 1588155200, null, 186, 'normal'),

(187, '持平', 'wlIcon-chiping', 1588155200, 1588155200, null, 187, 'normal'),

(188, '低于', 'wlIcon-diyu', 1588155200, 1588155200, null, 188, 'normal'),

(189, '分享', 'wlIcon-fenxiang', 1588155200, 1588155200, null, 189, 'normal'),

(190, '高于', 'wlIcon-gaoyu', 1588155200, 1588155200, null, 190, 'normal'),

(191, '购买', 'wlIcon-goumai', 1588155200, 1588155200, null, 191, 'normal'),

(192, '分类', 'wlIcon-fenlei1', 1588155200, 1588155200, null, 192, 'normal'),

(193, '搜索', 'wlIcon-sousuo1', 1588155200, 1588155200, null, 193, 'normal'),

(194, '保存到桌面', 'wlIcon-baocundaozhuomian', 1588155200, 1588155200, null, 194, 'normal'),

(195, '关注店铺', 'wlIcon-guanzhudianpu', 1588155200, 1588155200, null, 195, 'normal'),

(196, '已关注', 'wlIcon-yiguanzhu', 1588155200, 1588155200, null, 196, 'normal'),

(197, '店铺', 'wlIcon-dianpu', 1588155200, 1588155200, null, 197, 'normal'),

(198, '关注-选中', 'wlIcon-guanzhuxuanzhong', 1588155200, 1588155200, null, 198, 'normal'),

(199, '关注', 'wlIcon-guanzhu1', 1588155200, 1588155200, null, 199, 'normal'),

(200, '会员卡', 'wlIcon-huiyuanqia', 1588155200, 1588155200, null, 200, 'normal'),

(201, '我', 'wlIcon-wo', 1588155200, 1588155200, null, 201, 'normal'),

(202, '优惠券', 'wlIcon-youhuiquan', 1588155200, 1588155200, null, 202, 'normal'),

(203, '表情', 'wlIcon-biaoqing', 1588155200, 1588155200, null, 203, 'normal'),

(204, '功能建议', 'wlIcon-gongnengjianyi', 1588155200, 1588155200, null, 204, 'normal'),

(205, '换一批', 'wlIcon-huanyipi', 1588155200, 1588155200, null, 205, 'normal'),

(206, '声波', 'wlIcon-shengbo', 1588155200, 1588155200, null, 206, 'normal'),

(207, '时间', 'wlIcon-shijian', 1588155200, 1588155200, null, 207, 'normal'),

(208, '问题反馈', 'wlIcon-wentifankui', 1588155200, 1588155200, null, 208, 'normal'),

(209, '信息', 'wlIcon-xinxi', 1588155200, 1588155200, null, 209, 'normal'),

(210, '修改or意见', 'wlIcon-xiugaioryijian', 1588155200, 1588155200, null, 210, 'normal'),

(211, '赞', 'wlIcon-zan', 1588155200, 1588155200, null, 211, 'normal'),

(212, '进入店铺', 'wlIcon-jinrudianpu', 1588155200, 1588155200, null, 212, 'normal'),

(213, '朋友圈', 'wlIcon-pengyouquan', 1588155200, 1588155200, null, 213, 'normal'),

(214, '链接', 'wlIcon-lianjie', 1588155200, 1588155200, null, 214, 'normal'),

(215, '点赞', 'wlIcon-dianzan', 1588155200, 1588155200, null, 215, 'normal'),

(216, '返回8', 'wlIcon-fanhui8', 1588155200, 1588155200, null, 216, 'normal'),

(217, '返回7', 'wlIcon-fanhui7', 1588155200, 1588155200, null, 217, 'normal'),

(218, '返回6', 'wlIcon-fanhui6', 1588155200, 1588155200, null, 218, 'normal'),

(219, '返回5', 'wlIcon-fanhui5', 1588155200, 1588155200, null, 219, 'normal'),

(220, '更多', 'wlIcon-gengduo', 1588155200, 1588155200, null, 220, 'normal'),

(221, '收藏-选中', 'wlIcon-shoucangxuanzhong', 1588155200, 1588155200, null, 221, 'normal'),

(222, '收藏', 'wlIcon-shoucang', 1588155200, 1588155200, null, 222, 'normal'),

(223, '返回1', 'wlIcon-fanhui1', 1588155200, 1588155200, null, 223, 'normal'),

(224, '返回2', 'wlIcon-fanhui2', 1588155200, 1588155200, null, 224, 'normal'),

(225, '返回3', 'wlIcon-fanhui3', 1588155200, 1588155200, null, 225, 'normal'),

(226, '返回4', 'wlIcon-fanhui4', 1588155200, 1588155200, null, 226, 'normal'),

(227, '旋转', 'wlIcon-xuanzhuan', 1588155200, 1588155200, null, 227, 'normal'),

(228, '方向2', 'wlIcon-fangxiang2', 1588155200, 1588155200, null, 228, 'normal'),

(229, '方向3', 'wlIcon-fangxiang3', 1588155200, 1588155200, null, 229, 'normal'),

(230, '方向4', 'wlIcon-fangxiang4', 1588155200, 1588155200, null, 230, 'normal'),

(231, '三角2', 'wlIcon-sanjiao2', 1588155200, 1588155200, null, 231, 'normal'),

(232, '三角1', 'wlIcon-sanjiao1', 1588155200, 1588155200, null, 232, 'normal'),

(233, '三角4', 'wlIcon-sanjiao4', 1588155200, 1588155200, null, 233, 'normal'),

(234, '三角3', 'wlIcon-sanjiao3', 1588155200, 1588155200, null, 234, 'normal'),

(235, '积分', 'wlIcon-jifen', 1588155200, 1588155200, null, 235, 'normal'),

(236, '删除2', 'wlIcon-shanchu2', 1588155200, 1588155200, null, 236, 'normal'),

(237, '回到顶部', 'wlIcon-huidaodingbu', 1588155200, 1588155200, null, 237, 'normal'),

(238, '删除', 'wlIcon-shanchu', 1588155200, 1588155200, null, 238, 'normal'),

(239, '我的-选中', 'wlIcon-wodexuanzhong', 1588155200, 1588155200, null, 239, 'normal'),

(240, '列表模式2', 'wlIcon-liebiaomoshi2', 1588155200, 1588155200, null, 240, 'normal'),

(241, '排行', 'wlIcon-paixing', 1588155200, 1588155200, null, 241, 'normal'),

(242, '关于我', 'wlIcon-guanyuwo', 1588155200, 1588155200, null, 242, 'normal'),

(243, '删除', 'wlIcon-shanchu1', 1588155200, 1588155200, null, 243, 'normal'),

(244, '赞-选中', 'wlIcon-zanxuanzhong', 1588155200, 1588155200, null, 244, 'normal'),

(245, '表情', 'wlIcon-biaoqing1', 1588155200, 1588155200, null, 245, 'normal'),

(246, '提示', 'wlIcon-tishi', 1588155200, 1588155200, null, 246, 'normal'),

(247, '帮助', 'wlIcon-bangzhu', 1588155200, 1588155200, null, 247, 'normal'),

(248, '错误', 'wlIcon-cuowu', 1588155200, 1588155200, null, 248, 'normal'),

(249, '积分', 'wlIcon-jifen1', 1588155200, 1588155200, null, 249, 'normal'),

(250, '足迹', 'wlIcon-zuji', 1588155200, 1588155200, null, 250, 'normal'),

(251, '金点子', 'wlIcon-jindianzi', 1588155200, 1588155200, null, 251, 'normal'),

(252, '红包', 'wlIcon-hongbao', 1588155200, 1588155200, null, 252, 'normal');



--
-- 转存表中的数据 `__PREFIX__wanlshop_link`
--
INSERT INTO `__PREFIX__wanlshop_link` (`id`, `type`, `title`, `route`, `createtime`, `updatetime`, `deletetime`, `weigh`, `status`) VALUES

(1, 'system', '首页', '/pages/wanlshop/wanlshop', 1588039197, 1588039197, null, 1, 'normal'),

(2, 'system', '类目', '/pages/product/category/category', 1588044953, 1588044953, null, 2, 'normal'),

(3, 'system', '发现页', '/pages/find/find', 1588039197, 1588039197, null, 3, 'normal'),

(4, 'system', '购物车', '/pages/cart/cart', 1588039197, 1588039197, null, 4, 'normal'),

(5, 'system', '用户中心', '/pages/user/user', 1588039197, 1588039197, null, 5, 'normal'),

(6, 'system', '通知消息', '/pages/notice/notify/notify', 1588039197, 1588039197, null, 6, 'normal'),

(7, 'system', '系统消息', '/pages/notice/system/system', 1588039197, 1588039197, null, 7, 'normal'),

(8, 'system', '交易物流', '/pages/notice/logistics/logistics', 1588039197, 1588039197, null, 8, 'normal'),

(9, 'system', '商品列表', '/pages/product/list', 1588039197, 1588039197, null, 9, 'normal'),

(10, 'system', '智能客服', '/pages/user/service', 1588039197, 1588039197, null, 10, 'normal'),

(11, 'system', '搜索商品', '/pages/product/search', 1588039197, 1588039197, null, 11, 'normal'),

(12, 'system', '文章列表', '/pages/article/list', 1588039197, 1588039197, null, 12, 'normal'),

(13, 'system', '帮助中心', '/pages/user/help', 1588039197, 1588039197, null, 13, 'normal'),

(14, 'system', '用户足迹', '/pages/user/footprint', 1588039197, 1588039197, null, 14, 'normal'),

(15, 'system', '用户关注', '/pages/user/follow', 1588039197, 1588039197, null, 15, 'normal'),

(16, 'system', '用户收藏', '/pages/user/collect', 1588039197, 1588039197, null, 16, 'normal'),

(17, 'system', '积分签到', '/pages/user/signin/signin', 1588039197, 1588039197, null, 17, 'normal'),

(18, 'system', '积分明细', '/pages/user/signin/log', 1588039197, 1588039197, null, 18, 'normal'),

(19, 'system', '收货地址', '/pages/user/address/address', 1588039197, 1588039197, null, 19, 'normal'),

(20, 'system', '签到排行榜', '/pages/user/signin/rank', 1588039197, 1588039197, null, 20, 'normal'),

(21, 'system', '意见反馈', '/pages/user/feedback/feedback', 1588039197, 1588039197, null, 21, 'normal'),

(22, 'system', '我的反馈', '/pages/user/feedback/lists', 1588039197, 1588039197, null, 22, 'normal'),

(23, 'system', '投诉举报', '/pages/user/complaint/complaint', 1588039197, 1588039197, null, 23, 'normal'),

(24, 'system', '我的举报', '/pages/user/complaint/lists', 1588039197, 1588039197, null, 24, 'normal'),

(25, 'system', '用户订单', '/pages/user/order/order', 1588039197, 1588039197, null, 25, 'normal'),

(26, 'system', '用户钱包', '/pages/user/money/money', 1588039197, 1588039197, null, 26, 'normal'),

(27, 'system', '余额明细', '/pages/user/money/list', 1588039197, 1588039197, null, 27, 'normal'),

(28, 'system', '提现日志', '/pages/user/money/witlist', 1588039197, 1588039197, null, 28, 'normal'),

(29, 'system', '领取优惠券', '/pages/user/coupon/list', 1588039197, 1588039197, null, 29, 'normal'),

(30, 'system', '我的优惠券', '/pages/user/coupon/mycard', 1588039197, 1588039197, null, 30, 'normal'),

(31, 'system', '商家入驻入口', '/pages/shop/apply/details', 1588039197, 1588039197, null, 31, 'normal');

--
-- 转存表中的数据 `__PREFIX__wanlshop_page`
--
INSERT INTO `__PREFIX__wanlshop_page` (`id`, `shop_id`, `name`, `page_token`, `type`, `page`, `item`, `createtime`, `updatetime`, `deletetime`, `status`) VALUES
(1, 0, 'App 首页', '8zigwfG5L0Votujx', 'index', '{\"params\":{\"navigationBarTitleText\":\"App \\u9996\\u9875\",\"share_title\":\"\\u5206\\u4eab\\u6807\\u9898\"},\"style\":{\"navigationBarTextStyle\":\"#ffffff\",\"navigationBarBackgroundColor\":\"#fe6600\",\"navigationBarBackgroundImage\":\"\",\"pageBackgroundColor\":\"#0d164a\",\"pageBackgroundImage\":\"\\/assets\\/addons\\/wanlshop\\/img\\/page\\/bg.jpg\",\"navigationBackgroundImage\":\"\\/assets\\/addons\\/wanlshop\\/img\\/user\\/top_bg.png\",\"pageBackgroundRepeat\":\"#ffffff\"}}', '[{\"name\":\"\\u8f6e\\u64ad\\u7ec4\\u4ef6\",\"type\":\"advertBanner\",\"style\":{\"color\":\"#000000\"},\"params\":{\"interval\":\"2800\",\"banstyle\":\"2\"},\"data\":[{\"title\":\"\\u7cfb\\u7edf\\u81ea\\u52a8\\u83b7\\u53d6-\\u5e7f\\u544a\\u7ba1\\u7406-\\u3010\\u81ea\\u5b9a\\u4e49\\u9875\\u9762\\u5e7f\\u544a\\u3011-\\u8f6e\\u64ad\\u56fe\"}]},{\"name\":\"\\u83dc\\u5355\\u7ec4\\u4ef6\",\"type\":\"menu\",\"params\":{\"colfive\":\"5\",\"menuMarginTop\":\"12.5px\",\"menuMarginBottom\":\"5px\",\"menuHeightWidth\":\"45px\",\"menuIconSize\":\"28px\",\"menuTextSize\":\"12px\"},\"style\":{\"color\":\"#ffffff\",\"margin\":\"0 12.5px\",\"padding\":\"6px 0\"},\"data\":[{\"text\":\"\\u7c7b\\u76ee\",\"icon\":\"wlIcon-leimu\",\"iconClass\":\"wanl-text-white\",\"bgClass\":\"wanl-bg-redorange\",\"link\":\"\\/pages\\/product\\/category\\/category\"},{\"text\":\"\\u81ea\\u5b9a\\u4e49\",\"icon\":\"wlIcon-pintuan\",\"iconClass\":\"wanl-text-white\",\"bgClass\":\"bg-gradual-blue\",\"link\":\"\\/pages\\/product\\/category\\/category\"},{\"text\":\"\\u81ea\\u5b9a\\u4e49\",\"icon\":\"wlIcon-tubiao309\",\"iconClass\":\"wanl-text-white\",\"bgClass\":\"bg-gradual-yellow\",\"link\":\"\\/pages\\/product\\/category\\/category\"},{\"text\":\"\\u81ea\\u5b9a\\u4e49\",\"icon\":\"wlIcon-kanjia\",\"iconClass\":\"wanl-text-white\",\"bgClass\":\"bg-gradual-green\",\"link\":\"\\/pages\\/product\\/category\\/category\"},{\"text\":\"\\u81ea\\u5b9a\\u4e49\",\"icon\":\"wlIcon-miaosha\",\"iconClass\":\"wanl-text-white\",\"bgClass\":\"bg-gradual-blue\",\"link\":\"\\/pages\\/product\\/category\\/category\"},{\"text\":\"\\u4f1a\\u5458\\u4e2d\\u5fc3\",\"icon\":\"wlIcon-huiyuanzhongxin\",\"iconClass\":\"wanl-text-white\",\"bgClass\":\"bg-gradual-red\",\"link\":\"\\/pages\\/user\\/user\"},{\"text\":\"\\u7b7e\\u5230\",\"icon\":\"wlIcon-qiandao\",\"iconClass\":\"wanl-text-white\",\"bgClass\":\"wanl-bg-orange\",\"link\":\"\\/pages\\/user\\/signin\\/signin\"},{\"text\":\"\\u4f59\\u989d\\u660e\\u7ec6\",\"icon\":\"wlIcon-saoyisao-copy\",\"iconClass\":\"wanl-text-white\",\"bgClass\":\"bg-gradual-purple\",\"link\":\"\\/pages\\/user\\/money\\/list\"},{\"text\":\"\\u667a\\u80fd\\u5c0f\\u871c\",\"icon\":\"wlIcon-unie737\",\"iconClass\":\"wanl-text-white\",\"bgClass\":\"bg-gradual-blue\",\"link\":\"\\/pages\\/user\\/service\"},{\"text\":\"\\u5e2e\\u52a9\",\"icon\":\"wlIcon-bangzhu1\",\"iconClass\":\"wanl-text-white\",\"bgClass\":\"bg-gradual-pink\",\"link\":\"\\/pages\\/user\\/help\"}]},{\"name\":\"\\u56fe\\u7247\\u7ec4\\u4ef6\",\"type\":\"advertImage\",\"style\":{\"height\":\"100px\",\"width\":\"100%\"},\"data\":[{\"advertLink\":\"2\"}]},{\"name\":\"\\u5934\\u6761\\u7ec4\\u4ef6\",\"type\":\"headlines\",\"style\":{\"background-color\":\"#ffffff\",\"border-radius\":\"10px\",\"margin\":\"0 12.5px\"},\"data\":[{\"title\":\"\\u7cfb\\u7edf\\u81ea\\u52a8\\u83b7\\u53d6-\\u5185\\u5bb9\\u7ba1\\u7406-\\u6587\\u7ae0\\u5217\\u8868-\\u9996\\u9875\\u6807\\u5fd7\"}]},{\"name\":\"\\u5206\\u7c7b\\u6a71\\u7a97\",\"type\":\"classify\",\"style\":{\"background-color\":\"#ffffff\",\"border-radius\":\"10px\",\"margin\":\"12.5px\"},\"params\":{\"colStyle\":\"col-2-2_1\"},\"data\":[{\"categoryId\":\"84\",\"textColor\":\"wanl-pip\",\"describe\":\"30\\u5929\\u5305\\u9000 365\\u5929\\u5305\\u6362\",\"tags\":\"\\u65b0\\u54c1\\u5c1d\\u9c9c\"},{\"categoryId\":\"81\",\"textColor\":\"text-red\",\"describe\":\"30\\u5929\\u5305\\u9000 365\\u5929\\u5305\\u6362\",\"tags\":\"\\u540e\\u53f0\\u8c03\\u7528\"},{\"categoryId\":\"93\",\"textColor\":\"text-pink\",\"describe\":\"\\u5546\\u54c1\\u63a8\\u8350\",\"tags\":\"\"},{\"categoryId\":\"88\",\"textColor\":\"wanl-pip\",\"describe\":\"\\u7279\\u60e0\",\"tags\":\"\"},{\"categoryId\":\"100\",\"textColor\":\"wanl-orange\",\"describe\":\"\\u540e\\u53f0\\u53ef\\u81ea\\u5b9a\\u4e49\\u6b64\\u9875\\u9762\",\"tags\":\"\"},{\"categoryId\":\"101\",\"textColor\":\"wanl-black\",\"describe\":\"\\u88c5\\u4fee\\u7ba1\\u7406\\u6b64\\u7ec4\\u4ef6\",\"tags\":\"\"},{\"categoryId\":\"91\",\"textColor\":\"wanl-pip\",\"describe\":\"\\u81ea\\u52a8\\u83b7\\u53d6\\u5546\\u54c1\",\"tags\":\"\"}]},{\"name\":\"\\u5206\\u9694\\u7b26\",\"type\":\"division\",\"style\":{\"width\":\"100%\",\"padding\":\"12.5px\"},\"params\":{\"lineWidth\":\"60%\",\"lineHeight\":\"1px\",\"lineBackground\":\"#bababa\",\"lineText\":\"\\u731c\\u4f60\\u559c\\u6b22\",\"lineTextColor\":\"#ffffff\",\"lineTextSize\":\"14px\",\"lineTextBackground\":\"#0d164a\",\"lineTextPadding\":\"0 9px\"}},{\"name\":\"\\u731c\\u4f60\\u559c\\u6b22\",\"type\":\"likes\",\"style\":{\"background-color\":\"#f5f5f5\"},\"params\":{\"colthree\":\"2\",\"colmargin\":\"25\"},\"data\":[{\"title\":\"\\u81ea\\u52a8\\u83b7\\u53d6\\u7cfb\\u7edf\\u731c\\u4f60\\u559c\\u6b22\\u6570\\u636e\"}]}]', 1603591923, 1603591923, NULL, 'normal'),

(2, 0, '自定义页面', '31BdtOZ5XrRm4yCE', 'page', '{\"params\":{\"navigationBarTitleText\":\"\\u81ea\\u5b9a\\u4e49\\u9875\\u9762\",\"share_title\":\"\\u5206\\u4eab\\u6807\\u9898\"},\"style\":{\"navigationBarTextStyle\":\"#ffffff\",\"navigationBarBackgroundColor\":\"#ff0000\",\"navigationBarBackgroundImage\":\"\",\"pageBackgroundColor\":\"#f5f5f5\",\"pageBackgroundImage\":\"\"}}', '[{\"name\":\"\\u516c\\u544a\\u680f\",\"type\":\"notice\",\"params\":{\"show\":\"true\"},\"style\":{\"background-color\":\"#fffbe8\",\"color\":\"#de8f1c\",\"padding\":\"2px 12.5px\"},\"data\":[{\"content\":\"\\u672c\\u9875\\u9762\\u7531\\u540e\\u53f0\\u5546\\u3010\\u57ce\\u88c5\\u3011\\u4fee\\u521b\\u5efa\\u7684\\u81ea\\u5b9a\\u4e49\\u9875\\u9762\\uff01\",\"link\":\"\"}]},{\"name\":\"\\u5546\\u54c1\\u7ec4\\u4ef6\",\"type\":\"goods\",\"params\":{\"colthree\":\"2\",\"colmargin\":\"25\"},\"data\":[{\"goodsLink\":\"1\"},{\"goodsLink\":\"2\"},{\"goodsLink\":\"3\"},{\"goodsLink\":\"4\"},{\"goodsLink\":\"5\"},{\"goodsLink\":\"6\"}]},{\"name\":\"\\u5206\\u9694\\u7b26\",\"type\":\"division\",\"style\":{\"width\":\"100%\",\"padding\":\"12.5px\"},\"params\":{\"lineWidth\":\"60%\",\"lineHeight\":\"1px\",\"lineBackground\":\"#bababa\",\"lineText\":\"\\u901a\\u8fc7\\u540e\\u53f0\\u81ea\\u5b9a\\u4e49\\u9875\\u9762\\u521b\\u5efa\",\"lineTextColor\":\"#333333\",\"lineTextSize\":\"14px\",\"lineTextBackground\":\"#f5f5f5\",\"lineTextPadding\":\"0 9px\"}}]', 1601211376, 1601211376, null, 'normal');





--
-- 转存表中的数据 `__PREFIX__wanlshop_category`
--
INSERT INTO `__PREFIX__wanlshop_category` (`id`, `pid`, `type`, `name`, `name_spacer`, `image`, `flag`, `isnav`, `createtime`, `updatetime`, `weigh`, `status`) VALUES

(1, 0, 'article', '帮助中心', null, '', null, 1, 1580846024, 1580846024, 1, 'normal'),

(2, 0, 'article', '头条新闻', null, '', null, 1, 1580846058, 1581001065, 2, 'normal'),

(3, 0, 'article', '使用协议', null, '', null, 1, 1580846097, 1580846097, 3, 'normal'),

(4, 0, 'article', '系统消息', null, '', null, 1, 1581505684, 1581505684, 4, 'normal'),

(10, 0, 'goods', '女装', '', '/assets/addons/wanlshop/img/category/category_nvzhuang3x.jpg', '', 1, 1592852500, 1592852500, 10, 'normal'),

(11, 0, 'goods', '手机数码', '', '/assets/addons/wanlshop/img/category/category_shoujishuma3x.jpg', '', 1, 1592852500, 1592852500, 11, 'normal'),

(12, 0, 'goods', '男装', '', '/assets/addons/wanlshop/img/category/category_nanzhuang3x.jpg', '', 1, 1592852500, 1592852500, 12, 'normal'),

(13, 0, 'goods', '鞋靴', '', '/assets/addons/wanlshop/img/category/category_xiexue3x.jpg', '', 1, 1592852500, 1592852500, 13, 'normal'),

(14, 0, 'goods', '百货', '', '/assets/addons/wanlshop/img/category/category_baihuo3x.jpg', '', 1, 1592852500, 1592852500, 14, 'normal'),

(15, 0, 'goods', '家电', '', '/assets/addons/wanlshop/img/category/category_jiadian3x.jpg', '', 1, 1592852500, 1592852500, 15, 'normal'),

(16, 0, 'goods', '美妆洗护', '', '/assets/addons/wanlshop/img/category/category_meizhuangxihu3x.jpg', '', 1, 1592852500, 1592852500, 16, 'normal'),

(17, 0, 'goods', '母婴', '', '/assets/addons/wanlshop/img/category/category_muying3x.jpg', '', 1, 1592852500, 1592852500, 17, 'normal'),

(18, 0, 'goods', '饰品', '', '/assets/addons/wanlshop/img/category/category_shipin3x.jpg', '', 1, 1592852500, 1592852500, 18, 'normal'),

(19, 0, 'goods', '箱包', '', '/assets/addons/wanlshop/img/category/category_xiangbao3x.jpg', '', 1, 1592852500, 1592852500, 19, 'normal'),

(20, 0, 'goods', '生鲜', '', '/assets/addons/wanlshop/img/category/category_shengxian3x.jpg', '', 1, 1592852500, 1592852500, 20, 'normal'),

(21, 0, 'goods', '食品', '', '/assets/addons/wanlshop/img/category/category_lingshi3x.jpg', '', 1, 1592852500, 1592852500, 21, 'normal'),

(22, 10, 'goods', '女裙', '', '/assets/addons/wanlshop/img/category/category_nvqun3x.jpg', '', 1, 1592852984, 1592852984, 22, 'normal'),

(23, 10, 'goods', '上装', '', '/assets/addons/wanlshop/img/category/category_shangzhuang3x.jpg', '', 1, 1592852984, 1592852984, 23, 'normal'),

(24, 10, 'goods', '女裤', '', '/assets/addons/wanlshop/img/category/category_nvku3x.jpg', '', 1, 1592852984, 1592852984, 24, 'normal'),

(25, 10, 'goods', '套装', '', '/assets/addons/wanlshop/img/category/category_taozhuang3x.jpg', '', 1, 1592852984, 1592852984, 25, 'normal'),

(26, 10, 'goods', '外套', '', '/assets/addons/wanlshop/img/category/category_waitao3x.jpg', '', 1, 1592852984, 1592852984, 26, 'normal'),

(27, 11, 'goods', '手机', '', '/assets/addons/wanlshop/img/category/category_shouji3x.jpg', '', 1, 1592853067, 1592853067, 27, 'normal'),

(28, 11, 'goods', '3C配件', '', '/assets/addons/wanlshop/img/category/category_3Cpeijian3x.jpg', '', 1, 1592853067, 1592853067, 28, 'normal'),

(29, 11, 'goods', '维修', '', '/assets/addons/wanlshop/img/category/category_weixiu3x.jpg', '', 1, 1592853067, 1592853067, 29, 'normal'),

(30, 12, 'goods', '裤子', '', '/assets/addons/wanlshop/img/category/category_kuzi3x.jpg', '', 1, 1592853100, 1592853100, 30, 'normal'),

(31, 12, 'goods', '上装', '', '/assets/addons/wanlshop/img/category/category_shangzhuang3x.jpg', '', 1, 1592853100, 1592853100, 31, 'normal'),

(32, 13, 'goods', '女鞋', '', '/assets/addons/wanlshop/img/category/category_nvxie3x.jpg', '', 1, 1592853127, 1592853127, 32, 'normal'),

(33, 13, 'goods', '男鞋', '', '/assets/addons/wanlshop/img/category/category_nanxie3x.jpg', '', 1, 1592853127, 1592853127, 33, 'normal'),

(34, 14, 'goods', '居家日用', '', '/assets/addons/wanlshop/img/category/category_jujiariyong3x.jpg', '', 1, 1592853243, 1592853243, 34, 'normal'),

(35, 14, 'goods', '餐饮用具', '', '/assets/addons/wanlshop/img/category/category_canyinyongju3x.jpg', '', 1, 1592853243, 1592853243, 35, 'normal'),

(36, 14, 'goods', '绿植宠物', '', '/assets/addons/wanlshop/img/category/category_lvzhichongwu3x.jpg', '', 1, 1592853243, 1592853243, 36, 'normal'),

(37, 14, 'goods', '窗帘布艺', '', '/assets/addons/wanlshop/img/category/category_chuanglianbuyi3x.jpg', '', 1, 1592853243, 1592853243, 37, 'normal'),

(38, 14, 'goods', '厨房用品', '', '/assets/addons/wanlshop/img/category/category_chufangyongpin3x.jpg', '', 1, 1592853243, 1592853243, 38, 'normal'),

(39, 14, 'goods', '床上用品', '', '/assets/addons/wanlshop/img/category/category_chuangshangyongpin3x.jpg', '', 1, 1592853243, 1592853243, 39, 'normal'),

(40, 14, 'goods', '家居装饰', '', '/assets/addons/wanlshop/img/category/category_jiajuzhuangshi3x.jpg', '', 1, 1592853243, 1592853243, 40, 'normal'),

(41, 14, 'goods', '收纳整理', '', '/assets/addons/wanlshop/img/category/category_shounazhengli3x.jpg', '', 1, 1592853243, 1592853243, 41, 'normal'),

(42, 14, 'goods', '清洁工具', '', '/assets/addons/wanlshop/img/category/category_qingjiegongju3x.jpg', '', 1, 1592853243, 1592853243, 42, 'normal'),

(43, 15, 'goods', '厨房电器', '', '/assets/addons/wanlshop/img/category/category_chufangdianqi3x.jpg', '', 1, 1592853294, 1592853294, 43, 'normal'),

(44, 15, 'goods', '生活电器', '', '/assets/addons/wanlshop/img/category/category_shenghuodianqi3x.jpg', '', 1, 1592853294, 1592853294, 44, 'normal'),

(45, 15, 'goods', '大家电', '', '/assets/addons/wanlshop/img/category/category_dajiadian3x.jpg', '', 1, 1592853294, 1592853294, 45, 'normal'),

(46, 15, 'goods', '个护电器', '', '/assets/addons/wanlshop/img/category/category_gehudianqi3x.jpg', '', 1, 1592853294, 1592853294, 46, 'normal'),

(47, 16, 'goods', '护肤', '', '/assets/addons/wanlshop/img/category/category_hufu3x.jpg', '', 1, 1592853313, 1592853313, 47, 'normal'),

(48, 16, 'goods', '彩妆', '', '/assets/addons/wanlshop/img/category/category_caizhuang3x.jpg', '', 1, 1592853313, 1592853313, 48, 'normal'),

(49, 16, 'goods', '美容美体', '', '/assets/addons/wanlshop/img/category/category_meirongmeiti3x.jpg', '', 1, 1592853313, 1592853313, 49, 'normal'),

(50, 17, 'goods', '儿童玩具', '', '/assets/addons/wanlshop/img/category/category_ertongwanju3x.jpg', '', 1, 1592853406, 1592853406, 50, 'normal'),

(51, 17, 'goods', '童装', '', '/assets/addons/wanlshop/img/category/category_tongzhuang3x.jpg', '', 1, 1592853406, 1592853406, 51, 'normal'),

(52, 17, 'goods', '童鞋', '', '/assets/addons/wanlshop/img/category/category_tongxie3x.jpg', '', 1, 1592853406, 1592853406, 52, 'normal'),

(53, 17, 'goods', '洗护用品', '', '/assets/addons/wanlshop/img/category/category_xihuyongpin3x.jpg', '', 1, 1592853406, 1592853406, 53, 'normal'),

(54, 17, 'goods', '孕产穿搭', '', '/assets/addons/wanlshop/img/category/category_yunchanchuanda3x.jpg', '', 1, 1592853406, 1592853406, 54, 'normal'),

(55, 17, 'goods', '哺乳喂养', '', '/assets/addons/wanlshop/img/category/category_buruweiyang3x.jpg', '', 1, 1592853406, 1592853406, 55, 'normal'),

(56, 17, 'goods', '儿童家具', '', '/assets/addons/wanlshop/img/category/category_ertongjiaju3x.jpg', '', 1, 1592853406, 1592853406, 56, 'normal'),

(57, 17, 'goods', '婴儿装', '', '/assets/addons/wanlshop/img/category/category_yingerzhuang3x.jpg', '', 1, 1592853406, 1592853406, 57, 'normal'),

(58, 17, 'goods', '玩具车', '', '/assets/addons/wanlshop/img/category/category_wanjuche3x.jpg', '', 1, 1592853406, 1592853406, 58, 'normal'),

(59, 17, 'goods', '宝宝出行', '', '/assets/addons/wanlshop/img/category/category_baobaochuxing3x.jpg', '', 1, 1592853406, 1592853406, 59, 'normal'),

(60, 17, 'goods', '孕产用品', '', '/assets/addons/wanlshop/img/category/category_yunchanyongpin3x.jpg', '', 1, 1592853406, 1592853406, 60, 'normal'),

(61, 17, 'goods', '奶粉营养', '', '/assets/addons/wanlshop/img/category/category_naifenyingyang3x.jpg', '', 1, 1592853406, 1592853406, 61, 'normal'),

(62, 19, 'goods', '女士背包', '', '/assets/addons/wanlshop/img/category/category_nvshibeibao3x.jpg', '', 1, 1592853445, 1592853445, 62, 'normal'),

(63, 19, 'goods', '男士背包', '', '/assets/addons/wanlshop/img/category/category_nanshibeibao3x.jpg', '', 1, 1592853445, 1592853445, 63, 'normal'),

(64, 19, 'goods', '箱包', '', '/assets/addons/wanlshop/img/category/category_xiangbao3x.jpg', '', 1, 1592853445, 1592853445, 64, 'normal'),

(65, 20, 'goods', '美味蔬菜', '', '/assets/addons/wanlshop/img/category/category_meiweishucai3x.jpg', '', 1, 1592853500, 1592853500, 65, 'normal'),

(66, 20, 'goods', '禽蛋', '', '/assets/addons/wanlshop/img/category/category_qindan3x.jpg', '', 1, 1592853500, 1592853500, 66, 'normal'),

(67, 20, 'goods', '时令生鲜', '', '/assets/addons/wanlshop/img/category/category_shilingshengxian3x.jpg', '', 1, 1592853500, 1592853500, 67, 'normal'),

(68, 20, 'goods', '新鲜肉类', '', '/assets/addons/wanlshop/img/category/category_xinxianroulei3x.jpg', '', 1, 1592853500, 1592853500, 68, 'normal'),

(69, 20, 'goods', '海产水产', '', '/assets/addons/wanlshop/img/category/category_haichanshuichan3x.jpg', '', 1, 1592853500, 1592853500, 69, 'normal'),

(70, 20, 'goods', '火锅料理', '', '/assets/addons/wanlshop/img/category/category_huoguoliaoli3x.jpg', '', 1, 1592853500, 1592853500, 70, 'normal'),

(71, 21, 'goods', '零食', '', '/assets/addons/wanlshop/img/category/category_lingshi3x.jpg', '', 1, 1592853551, 1592853551, 71, 'normal'),

(72, 21, 'goods', '方便速食', '', '/assets/addons/wanlshop/img/category/category_fangbiansushi3x.jpg', '', 1, 1592853551, 1592853551, 72, 'normal'),

(73, 21, 'goods', '乳饮', '', '/assets/addons/wanlshop/img/category/category_ruyin3x.jpg', '', 1, 1592853551, 1592853551, 73, 'normal'),

(74, 21, 'goods', '粮油调味', '', '/assets/addons/wanlshop/img/category/category_liangyoudiaowei3x.jpg', '', 1, 1592853551, 1592853551, 74, 'normal'),

(75, 21, 'goods', '冲饮', '', '/assets/addons/wanlshop/img/category/category_chongyin3x.jpg', '', 1, 1592853551, 1592853551, 75, 'normal'),

(76, 21, 'goods', '茶', '', '/assets/addons/wanlshop/img/category/category_cha3x.jpg', '', 1, 1592853551, 1592853551, 76, 'normal'),

(77, 21, 'goods', '南北干货', '', '/assets/addons/wanlshop/img/category/category_nanbeiganhuo3x.jpg', '', 1, 1592853551, 1592853551, 77, 'normal'),

(78, 18, 'goods', '手表', '', '/assets/addons/wanlshop/img/category/category_shoubiao3x.jpg', '', 1, 1592853646, 1592853646, 78, 'normal'),

(79, 18, 'goods', '眼镜', '', '/assets/addons/wanlshop/img/category/category_yanjing3x.jpg', '', 1, 1592853646, 1592853646, 79, 'normal'),

(80, 18, 'goods', '珠宝', '', '/assets/addons/wanlshop/img/category/category_zhubao3x.jpg', '', 1, 1592853646, 1592853646, 80, 'normal'),

(81, 22, 'goods', '连衣裙', '', '/assets/addons/wanlshop/img/category/category_lianyiqun3x.jpg', '', 1, 1592853678, 1592853678, 81, 'normal'),

(82, 22, 'goods', '半身裙', '', '/assets/addons/wanlshop/img/category/category_banshenqun3x.jpg', '', 1, 1592853678, 1592853678, 82, 'normal'),

(83, 22, 'goods', '旗袍', '', '/assets/addons/wanlshop/img/category/category_qipao3x.jpg', '', 1, 1592853678, 1592853678, 83, 'normal'),

(84, 23, 'goods', 'T恤', '', '/assets/addons/wanlshop/img/category/category_Txu3x.jpg', '', 1, 1592853721, 1592853721, 84, 'normal'),

(85, 23, 'goods', '衬衫', '', '/assets/addons/wanlshop/img/category/category_chenshan3x.jpg', '', 1, 1592853721, 1592853721, 85, 'normal'),

(86, 23, 'goods', '雪纺衫', '', '/assets/addons/wanlshop/img/category/category_xuefangshan3x.jpg', '', 1, 1592853721, 1592853721, 86, 'normal'),

(87, 23, 'goods', '卫衣', '', '/assets/addons/wanlshop/img/category/category_weiyi3x.jpg', '', 1, 1592853721, 1592853721, 87, 'normal'),

(88, 23, 'goods', '毛衣', '', '/assets/addons/wanlshop/img/category/category_maoyi3x.jpg', '', 1, 1592853721, 1592853721, 88, 'normal'),

(89, 23, 'goods', '马甲', '', '/assets/addons/wanlshop/img/category/category_majia3x.jpg', '', 1, 1592853721, 1592853721, 89, 'normal'),

(90, 24, 'goods', '休闲裤', '', '/assets/addons/wanlshop/img/category/category_xiuxianku3x.jpg', '', 1, 1592853747, 1592853747, 90, 'normal'),

(91, 24, 'goods', '牛仔裤', '', '/assets/addons/wanlshop/img/category/category_niuziku3x.jpg', '', 1, 1592853747, 1592853747, 91, 'normal'),

(92, 24, 'goods', '打底裤', '', '/assets/addons/wanlshop/img/category/category_dadiku3x.jpg', '', 1, 1592853747, 1592853747, 92, 'normal'),

(93, 24, 'goods', '西装裤', '', '/assets/addons/wanlshop/img/category/category_xizhuangku3x.jpg', '', 1, 1592853747, 1592853747, 93, 'normal'),

(94, 25, 'goods', '时尚套装', '', '/assets/addons/wanlshop/img/category/category_shishangtaozhuang3x.jpg', '', 1, 1592853768, 1592853768, 94, 'normal'),

(95, 25, 'goods', '运动套装', '', '/assets/addons/wanlshop/img/category/category_yundongtaozhuang3x.jpg', '', 1, 1592853768, 1592853768, 95, 'normal'),

(96, 26, 'goods', '短外套', '', '/assets/addons/wanlshop/img/category/category_duanwaitao3x.jpg', '', 1, 1592853812, 1592853812, 96, 'normal'),

(97, 26, 'goods', '西装', '', '/assets/addons/wanlshop/img/category/category_xizhuang3x.jpg', '', 1, 1592853812, 1592853812, 97, 'normal'),

(98, 26, 'goods', '风衣', '', '/assets/addons/wanlshop/img/category/category_fengyi3x.jpg', '', 1, 1592853812, 1592853812, 98, 'normal'),

(99, 26, 'goods', '羽绒服', '', '/assets/addons/wanlshop/img/category/category_yurongfu3x.jpg', '', 1, 1592853812, 1592853812, 99, 'normal'),

(100, 26, 'goods', '毛呢大衣', '', '/assets/addons/wanlshop/img/category/category_maonedayi3x.jpg', '', 1, 1592853812, 1592853812, 100, 'normal'),

(101, 26, 'goods', '棉衣棉服', '', '/assets/addons/wanlshop/img/category/category_mianyimianfu3x.jpg', '', 1, 1592853812, 1592853812, 101, 'normal'),

(102, 26, 'goods', '皮草', '', '/assets/addons/wanlshop/img/category/category_picao3x.jpg', '', 1, 1592853812, 1592853812, 102, 'normal'),

(103, 26, 'goods', '皮衣', '', '/assets/addons/wanlshop/img/category/category_piyi3x.jpg', '', 1, 1592853812, 1592853812, 103, 'normal');





--
-- 转存表中的数据 `__PREFIX__wanlshop_category_attribute`
--

INSERT INTO `__PREFIX__wanlshop_category_attribute` (`id`, `admin_id`, `category_id`, `name`, `value`, `switch`, `weigh`, `createtime`, `updatetime`, `deletetime`, `status`) VALUES

(1, 0, 81, '厚薄', '[{\"key\":\"0\",\"name\":\"常规\"},{\"key\":\"1\",\"name\":\"加厚\"},{\"key\":\"2\",\"name\":\"适中\"},{\"key\":\"3\",\"name\":\"厚\"},{\"key\":\"4\",\"name\":\"薄款\"},{\"key\":\"5\",\"name\":\"薄\"},{\"key\":\"6\",\"name\":\"加绒\"},{\"key\":\"7\",\"name\":\"超薄\"}]', 0, 0, null, 1582320243, null, 'normal'),

(2, 0, 81, '尺码', '[{\"key\":\"0\",\"name\":\"XXS\"},{\"key\":\"1\",\"name\":\"XS\"},{\"key\":\"2\",\"name\":\"S\"},{\"key\":\"3\",\"name\":\"M\"},{\"key\":\"4\",\"name\":\"均码\"},{\"key\":\"5\",\"name\":\"L\"},{\"key\":\"6\",\"name\":\"XL\"},{\"key\":\"7\",\"name\":\"2XL\"},{\"key\":\"8\",\"name\":\"XXXL\"},{\"key\":\"9\",\"name\":\"XXXXL\"},{\"key\":\"10\",\"name\":\"5XL\"}]', 0, 3, 1582319997, 1582320176, null, 'normal'),

(3, 0, 81, '服装款式', '[{\"key\":\"0\",\"name\":\"拼接\"},{\"key\":\"1\",\"name\":\"纽扣\"},{\"key\":\"2\",\"name\":\"口袋\"},{\"key\":\"3\",\"name\":\"拉链\"},{\"key\":\"4\",\"name\":\"系带\"},{\"key\":\"5\",\"name\":\"皱褶\"},{\"key\":\"6\",\"name\":\"荷叶边\"},{\"key\":\"7\",\"name\":\"印花\"},{\"key\":\"8\",\"name\":\"蕾丝\"},{\"key\":\"9\",\"name\":\"蝴蝶结\"},{\"key\":\"10\",\"name\":\"立体装饰\"},{\"key\":\"11\",\"name\":\"纱网\"},{\"key\":\"12\",\"name\":\"绷带\"},{\"key\":\"13\",\"name\":\"带毛领\"},{\"key\":\"14\",\"name\":\"螺纹\"},{\"key\":\"15\",\"name\":\"抽褶\"},{\"key\":\"16\",\"name\":\"绣花\"},{\"key\":\"17\",\"name\":\"树脂固色\"},{\"key\":\"18\",\"name\":\"不对称\"},{\"key\":\"19\",\"name\":\"流苏\"}]', 0, 0, null, 1582320478, null, 'normal'),

(4, 0, 81, '适用年龄', '[{\"key\":\"0\",\"name\":\"17周岁以下\"},{\"key\":\"1\",\"name\":\"18-24周岁\"},{\"key\":\"2\",\"name\":\"18-25周岁\"},{\"key\":\"3\",\"name\":\"25-29周岁\"},{\"key\":\"4\",\"name\":\"25-35周岁\"},{\"key\":\"5\",\"name\":\"30-34周岁\"},{\"key\":\"6\",\"name\":\"30-39周岁\"},{\"key\":\"7\",\"name\":\"35-39周岁\"},{\"key\":\"8\",\"name\":\"35周岁以上\"},{\"key\":\"9\",\"name\":\"40-49周岁\"},{\"key\":\"10\",\"name\":\"50-59周岁\"},{\"key\":\"11\",\"name\":\"60周岁以上\"}]', 0, 0, null, 1582320590, null, 'normal'),

(5, 0, 81, '风格', '[{\"key\":\"0\",\"name\":\"通勤\"},{\"key\":\"1\",\"name\":\"接头\"},{\"key\":\"2\",\"name\":\"甜美\"},{\"key\":\"3\",\"name\":\"时尚\"},{\"key\":\"4\",\"name\":\"百搭\"},{\"key\":\"5\",\"name\":\"休闲\"},{\"key\":\"6\",\"name\":\"原创设计\"},{\"key\":\"7\",\"name\":\"民族风\"},{\"key\":\"8\",\"name\":\"复古\"},{\"key\":\"9\",\"name\":\"优雅\"},{\"key\":\"10\",\"name\":\"运动\"},{\"key\":\"11\",\"name\":\"清新\"},{\"key\":\"12\",\"name\":\"性感\"}]', 0, 0, null, 1582320661, null, 'normal'),

(6, 0, 81, '材质', '[{\"key\":\"0\",\"name\":\"棉\"},{\"key\":\"1\",\"name\":\"涤纶\"},{\"key\":\"2\",\"name\":\"粘胶\"},{\"key\":\"3\",\"name\":\"羊毛\"},{\"key\":\"4\",\"name\":\"腈纶\"},{\"key\":\"5\",\"name\":\"请纶混纺\"},{\"key\":\"6\",\"name\":\"棉纶\"},{\"key\":\"7\",\"name\":\"羊绒\"},{\"key\":\"8\",\"name\":\"聚酯\"},{\"key\":\"9\",\"name\":\"蚕丝\"},{\"key\":\"10\",\"name\":\"雪纺\"},{\"key\":\"11\",\"name\":\"麻\"},{\"key\":\"12\",\"name\":\"棉布\"},{\"key\":\"13\",\"name\":\"莫代尔\"},{\"key\":\"14\",\"name\":\"棉麻\"},{\"key\":\"15\",\"name\":\"混纺\"},{\"key\":\"16\",\"name\":\"貂绒\"},{\"key\":\"17\",\"name\":\"针织\"}]', 0, 0, null, 1582320776, null, 'normal');



--
-- 转存表中的数据 `__PREFIX__wanlshop_qrcode`
--
INSERT INTO `__PREFIX__wanlshop_qrcode` (`id`, `admin_id`, `name`, `template`, `canvas_width`, `canvas_height`, `thumbnail_width`, `thumbnail_url`, `background_url`, `logo_src`, `checked`, `createtime`, `updatetime`, `deletetime`, `weigh`, `status`) VALUES
(1, '0', '海报', 'wanlshopqrlist001', '500', '820', '54', '/assets/addons/wanlshop/img/qrcode/cover.jpg', '/assets/addons/wanlshop/img/qrcode/poster.jpg', '/assets/addons/wanlshop/img/qrcode/logo.png', '0', 1583066729, 1583074893, null, 1, 'normal'),

(2, '0', '普通二维码', 'wanlshopqr', '500', '500', '88', '/assets/addons/wanlshop/img/qrcode/qrcode.png', '/assets/addons/wanlshop/img/qrcode/qrcode.png', '/assets/addons/wanlshop/img/qrcode/logo.png', '0', 1583066774, 1583077796, null, 2, 'normal');



--
-- 转存表中的数据 `__PREFIX__wanlshop_brand`
--

INSERT INTO `__PREFIX__wanlshop_brand` (`id`, `admin_id`, `shop_id`, `category_id`, `name`, `image`, `content`, `weigh`, `switch`, `createtime`, `updatetime`, `deletetime`, `status`, `state`) VALUES

(1, 0, 0, 0, '其他', '', '', '1', '0', 1592817418, 1593789237, null, 'normal', '1');

BEGIN;

COMMIT;