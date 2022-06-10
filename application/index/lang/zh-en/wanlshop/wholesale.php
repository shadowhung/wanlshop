<?php


return [
    'Id' => 'ID',
    'Shop_category_id' => 'Category',
    'Shopsort.name' => '店鋪內類目',
    'Category_id' => '商品類目',
    'Category.name' => '商品類目',
    'Title' => 'Title',
    'Image' => 'Image',
    'Images' => 'Images',
    'Description' => 'Description',
    'On sale' => 'On sale',
    'Warehouse' => 'Warehouse',
    'Flag' => '標誌（多選）',
    'Flag hot' => 'Hot',
    'Flag index' => 'Home page',
    'Flag recommend' => 'Recommend',
    'Stock' => 'Stock',
    'Stock porder' => 'Inventory tracking by order',
    'Stock payment' => 'Inventory tracking by pay',
    'Content' => 'Description',
    'Price' => 'Price',
    'Freight_id' => '運費範本',
    'Grounding' => 'Status',
    'Specs' => 'Variants',
    'Specs single' => 'Single variant',
    'Specs multi' => 'Multiple variants',
    'Distribution' => '是否獨立分銷',
    'Distribution true' => 'ON',
    'Distribution false' => 'OFF',
    'Activity' => 'Active',
    'Activity true' => 'Yes',
    'Activity false' => 'No',
    'Views' => 'Views',
    'Sales' => 'Sales',
    'Comment' => 'Comments',
    'Praise' => '好評',
    'Like' => 'Like',
    'Weigh' => 'Weigh',
    'Createtime' => 'Create time',
    'Updatetime' => 'Update time',
    'Deletetime' => 'Delete time',
    'Status' => 'Status',
    //追加數據
    'All' => 'All',
    'On the shelf' => 'Active',
    'Not on sale' => 'Disabled',
    'Del' => 'Delete',
    'Normal' => 'Active',
    'Hidden' => 'Disable',
    'Set to normal' => 'Active',
    'Set to hidden' => 'Disabled',
    'Import' => 'Import',
    'Export' => 'Export',
    'Recycle bin' => 'Recycle bin',
    'Restore' => 'Restore',
    'Restore all' => 'Restore all',
    'Destroy' => 'Destroy',
    'Destroy all' => 'Destroy all',
    'Nothing need restore' => 'Nothing need restore',
    'Drag to sort' => 'Drag to sort',
    'Redirect now' => 'Redirect now',
    'Key' => 'Key',
    'Value' => 'Value',
    'Common search' => 'Common search',
    'Search %s' => 'Search %s',
    'View %s' => 'View %s',
    'Click to search %s' => 'Click to search %s',
    'Operation completed' => 'Success!',
    'Operation failed' => 'Failed',
    'Unknown data format' => 'Unknown format!',
    'Network error' => 'Network error!',
    'Invalid parameters' => 'Invalid parameters',
    'No results were found' => 'Not found',
    'No rows were inserted' => 'No rows were inserted',
    'No rows were deleted' => 'No rows were deleted',
    'No rows were updated' => 'No rows were updated',
    'Parameter %s can not be empty' => 'Parameter %s can not be empty',
    'Are you sure you want to delete the %s selected item?' => 'Are you sure you want to delete the %s selected item?',
    'Are you sure you want to delete this item?' => 'Are you sure you want to delete this item?',
    'Are you sure you want to delete or turncate?' => 'Are you sure you want to delete or turncate?',
    'Are you sure you want to truncate?' => 'Are you sure you want to truncate?'
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
