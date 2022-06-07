<?php
namespace app\api1\model\wanlshop;

use think\Model;

class Shop extends Model
{

    // 表名
    protected $name = 'wanlshop_shop';
    
    // 自动写入时间戳字段
    protected $autoWriteTimestamp = 'int';

    // 定义时间戳字段名
    protected $createTime = 'createtime';
    protected $updateTime = 'updatetime';
	

	// 追加属性

	protected $append = [

		'isself' //追加是否为自营店

	];

	

	public function getIsselfAttr($value, $data)

	{

	    return $data['isself'];

	}

	

	public function getServiceIdsAttr($value, $data)

	{

	    $value = $value ? $value : (isset($data['service_ids']) ? $data['service_ids'] : '');

	    $valueArr = explode(',', $value);

		$service = [];

		foreach(ShopService::all($valueArr) as $vo){

		   $service[] =  [

			   'id' => $vo['id'],

			   'name' => $vo['name'],

			   'description' => $vo['description']

		   ];

		}

		return $service;

	}

}
