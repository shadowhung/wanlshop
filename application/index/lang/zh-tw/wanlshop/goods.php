<?php
return [
    'Id' => 'ID',
    'Shop_category_id' =>'商店の内で類の目',
    'Shopsort.name' =>'商店の内で類の目',
    'Category_id' =>'商の種類の目',
    'Category.name' =>'商の種類の目',
    'Title' =>'商品の見出し',
    'Image' =>'商品の主な図',
    'Images' =>'商品の様子ですか？',
    'Description' =>'商品の説明',
    'Flag' =>'は（複数選択）を表して',
    'Flag hot' =>'大人気',
    'Flag index' =>'トップページ',
    'Flag recommend' =>'はを推薦して',
    'Stock' =>'在庫はルートを計算して',
    'Stock porder' =>'は注文票を出しますか？在庫',
    'Stock payment' =>'はお金を支払いますか？在庫',
    'Content' =>'商品の詳しい情況',
    'Price' =>'製品の価格',
    'Freight_id' =>'運賃の手本',
    'Grounding' =>'は状態を入荷して',
    'Specs' =>'商品の規格',
    'Specs single' =>'単に規格',
    'Specs multi' =>'多い規格',
    'Distribution' =>'は単独で分けてを売るかどうか',
    'Distribution true' =>'はを開いて',
    'Distribution false' =>'はを閉めて',
    'Activity' =>'イベントの中で',
    'Activity true' =>'はで',
    'Activity false' =>'はを否定して',
    'Views' =>'はをクリックして',
    'Sales' =>'販売量',
    'Comment' =>'はを評論して',
    'Praise' =>'好評',
    'Like' =>'はを収集して',
    'Weigh' =>'権力の重い',
    'Createtime' =>'記入時間',
    'Updatetime' =>'更新時間',
    'Deletetime' => '?時間を割って',
    'Status' =>'は状態を入荷して',
    'All' =>'すべての製品',
    'Del' => '削除する',
    'Normal' =>'正常',
    'Hidden' =>'の下でを支えて',
    'Set to normal' =>'は商品を入荷して',
    'Set to hidden' =>'の下で商品を支えて',
    'Import' =>'はを導入して',
    'Export' =>'はを集めて',
    'Recycle bin' =>'商品のごみ箱',
    'Restore' =>'は原状に復して',
    'Restore all' =>'原状に復するすべて',
    'Destroy' =>'はを廃棄して',
    'Destroy all' =>'は空いているごみ箱を点検して',
    'Nothing need restore' =>'は原状に復するデータが必要になっていませんて',
    'Drag to sort' =>'がドラッグしてソーティングすることを行って',
    'Redirect now' =>'は直ちにジャンプして',
    'Key' =>'鍵盤',
    'Value' =>'はに値して',
    'Common search' =>'普通の検索',
    'Search %s' =>'は%sを検索して',
    'View %s' =>'は%sを調べて',
    'Click to search %s' =>'は検索%sをクリックして',
    'Operation completed' =>'は操作することに成功します！',
    'Operation failed' =>'は失敗を操作します！',
    'Unknown data format' =>'の知らないデータ形式！',
    'Network error' =>'ネットワークが誤った！',
    'Invalid parameters' =>'未知パラメータ',
    'No results were found' =>'は記録してが見つかっていないで',
    'No rows were inserted' =>'はいかなるを挿入していないで',
    'No rows were deleted' =>'ですか？いかなるを割って',
    'No rows were updated' =>'はいかなるを更新していないで',
    'Parameter %s can not be empty' =>'パラメーター%sは暇のためことはできません',
    'Are you sure you want to delete the %s selected item?' =>'は確定しますか？選んだ%s項を割りますか？',
    'Are you sure you want to delete this item?' =>'は確定しますか？この項を割りますか？',
    'Are you sure you want to delete or turncate?' =>'は確定しますか？あるいは,を除いて暇を点検しますか？',
    'Are you sure you want to truncate?' =>'は暇を点検するのを確定しますか？'
];



/*return [
    'Id'                 => 'ID',
    'Shop_category_id'   => '店铺内类目',

	'Shopsort.name'      => '店铺内类目',
    'Category_id'        => '商品类目',

	'Category.name'      => '商品类目',

    'Title'              => '商品标题',
    'Image'              => '商品主图',
    'Images'             => '商品相册',
    'Description'        => '商品描述',
    'Flag'               => '标志(多选)',
    'Flag hot'           => '热门',
    'Flag index'         => '首页',
    'Flag recommend'     => '推荐',
    'Stock'              => '库存计算方式',
    'Stock porder'       => '下单减库存',
    'Stock payment'      => '付款减库存',
    'Content'            => '商品详情',
    'Price'              => '产品价格',
    'Freight_id'         => '运费模板',
    'Grounding'          => '上架状态',
    'Specs'              => '商品规格',
    'Specs single'       => '单规格',
    'Specs multi'        => '多规格',
    'Distribution'       => '是否独立分销',
    'Distribution true'  => '开启',
    'Distribution false' => '关闭',
    'Activity'           => '是否活动中',
    'Activity true'      => '是',
    'Activity false'     => '否',
    'Views'              => '点击',
    'Sales'              => '销量',
    'Comment'            => '评论',
    'Praise'             => '好评',
    'Like'               => '收藏',
    'Weigh'              => '权重',
    'Createtime'         => '创建时间',
    'Updatetime'         => '更新时间',
    'Deletetime'         => '删除时间',
    'Status'             => '上架状态',

	// 追加数据

	'All'                                                   => '全部商品',

	'Del'													=> '删除',

	'Normal'                                                => '正常',

	'Hidden'                                                => '下架',

	'Set to normal'      => '上架商品',

	'Set to hidden'      => '下架商品',

	'Import'                                                => '导入',

	'Export'                                                => '导出',

	'Recycle bin'                                           => '商品回收站',

	'Restore'                                               => '还原',

	'Restore all'                                           => '还原全部',

	'Destroy'                                               => '销毁',

	'Destroy all'                                           => '清空回收站',

	'Nothing need restore'                                  => '没有需要还原的数据',

	'Drag to sort'                                          => '拖动进行排序',

	'Redirect now'                                          => '立即跳转',

	'Key'                                                   => '键',

	'Value'                                                 => '值',

	'Common search'                                         => '普通搜索',

	'Search %s'                                             => '搜索 %s',

	'View %s'                                               => '查看 %s',

	'Click to search %s'                                    => '点击搜索 %s',

	'Operation completed'                                   => '操作成功!',

	'Operation failed'                                      => '操作失败!',

	'Unknown data format'                                   => '未知的数据格式!',

	'Network error'                                         => '网络错误!',

	'Invalid parameters'                                    => '未知参数',

	'No results were found'                                 => '记录未找到',

	'No rows were inserted'                                 => '未插入任何行',

	'No rows were deleted'                                  => '未删除任何行',

	'No rows were updated'                                  => '未更新任何行',

	'Parameter %s can not be empty'                         => '参数%s不能为空',

	'Are you sure you want to delete the %s selected item?' => '确定删除选中的 %s 项?',

	'Are you sure you want to delete this item?'            => '确定删除此项?',

	'Are you sure you want to delete or turncate?'          => '确定删除或清空?',

	'Are you sure you want to truncate?'                    => '确定清空?'

];*/
