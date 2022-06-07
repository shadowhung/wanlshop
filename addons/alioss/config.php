<?php

return [
    [
        'name' => 'accessKeyId',
        'title' => 'accessKeyId',
        'type' => 'string',
        'content' => [],
        'value' => 'LTAI5tPBdzGgcUbYReHQgcuJ',
        'rule' => 'required',
        'msg' => '',
        'tip' => '',
        'ok' => '',
        'extend' => '',
    ],
    [
        'name' => 'accessKeySecret',
        'title' => 'accessKeySecret',
        'type' => 'string',
        'content' => [],
        'value' => 'yqU2IjFyli18fd0P967Lg7Tr0zo4AO',
        'rule' => 'required',
        'msg' => '',
        'tip' => '',
        'ok' => '',
        'extend' => '',
    ],
    [
        'name' => 'bucket',
        'title' => 'Bucket',
        'type' => 'string',
        'content' => [],
        'value' => 'imagesrb',
        'rule' => 'required',
        'msg' => '',
        'tip' => '阿里云OSS的空间名',
        'ok' => '',
        'extend' => '',
    ],
    [
        'name' => 'endpoint',
        'title' => 'EndPoint',
        'type' => 'string',
        'content' => [],
        'value' => 'oss-ap-northeast-1.aliyuncs.com',
        'rule' => 'required',
        'msg' => '',
        'tip' => '如果是服务器中转模式，可填写内网域名，前面不可加http://',
        'ok' => '',
        'extend' => '',
    ],
    [
        'name' => 'cdnurl',
        'title' => 'CDN地址',
        'type' => 'string',
        'content' => [],
        'value' => 'https://imagesrb.oss-ap-northeast-1.aliyuncs.com',
        'rule' => 'required',
        'msg' => '',
        'tip' => '请填写CDN地址，必须以http://开头',
        'ok' => '',
        'extend' => '',
    ],
    [
        'name' => 'uploadmode',
        'title' => '上传模式',
        'type' => 'select',
        'content' => [
            'client' => '客户端直传(速度快,无备份)',
            'server' => '服务器中转(占用服务器带宽,有备份)',
        ],
        'value' => 'server',
        'rule' => '',
        'msg' => '',
        'tip' => '',
        'ok' => '',
        'extend' => '',
    ],
    [
        'name' => 'savekey',
        'title' => '保存文件名',
        'type' => 'string',
        'content' => [],
        'value' => '/uploads/{year}{mon}{day}/{filemd5}{.suffix}',
        'rule' => 'required',
        'msg' => '',
        'tip' => '',
        'ok' => '',
        'extend' => '',
    ],
    [
        'name' => 'expire',
        'title' => '上传有效时长',
        'type' => 'string',
        'content' => [],
        'value' => '600',
        'rule' => 'required',
        'msg' => '',
        'tip' => '',
        'ok' => '',
        'extend' => '',
    ],
    [
        'name' => 'maxsize',
        'title' => '最大可上传',
        'type' => 'string',
        'content' => [],
        'value' => '10M',
        'rule' => 'required',
        'msg' => '',
        'tip' => '',
        'ok' => '',
        'extend' => '',
    ],
    [
        'name' => 'mimetype',
        'title' => '可上传后缀格式',
        'type' => 'string',
        'content' => [],
        'value' => 'jpg,png,bmp,jpeg,gif,zip,rar,xls,xlsx',
        'rule' => 'required',
        'msg' => '',
        'tip' => '',
        'ok' => '',
        'extend' => '',
    ],
    [
        'name' => 'multiple',
        'title' => '多文件上传',
        'type' => 'bool',
        'content' => [],
        'value' => '1',
        'rule' => 'required',
        'msg' => '',
        'tip' => '',
        'ok' => '',
        'extend' => '',
    ],
    [
        'name' => 'thumbstyle',
        'title' => '缩略图样式',
        'type' => 'string',
        'content' => [],
        'value' => '',
        'rule' => '',
        'msg' => '',
        'tip' => '用于附件管理缩略图样式，可使用：?x-oss-process=image/resize,m_lfit,w_120,h_90',
        'ok' => '',
        'extend' => '',
    ],
    [
        'name' => 'chunking',
        'title' => '分片上传',
        'type' => 'radio',
        'content' => [
            1 => '开启',
            0 => '关闭',
        ],
        'value' => '1',
        'rule' => 'required',
        'msg' => '',
        'tip' => '',
        'ok' => '',
        'extend' => '',
    ],
    [
        'name' => 'chunksize',
        'title' => '分片大小',
        'type' => 'number',
        'content' => [],
        'value' => '4194304',
        'rule' => 'required',
        'msg' => '',
        'tip' => '',
        'ok' => '',
        'extend' => '',
    ],
    [
        'name' => 'syncdelete',
        'title' => '附件删除时是否同步删除文件',
        'type' => 'bool',
        'content' => [],
        'value' => '1',
        'rule' => 'required',
        'msg' => '',
        'tip' => '',
        'ok' => '',
        'extend' => '',
    ],
    [
        'name' => '__tips__',
        'title' => '温馨提示',
        'type' => '',
        'content' => [],
        'value' => '1、在使用之前请注册阿里云账号并进行认证和创建空间，注册链接:<a href="https://oss.console.aliyun.com/index" target="_blank">https://oss.console.aliyun.com/index</a><br>'."\n"
            .'2、如需开启分片上传，必须给对应的按钮添加上<code>data-chunking="true"</code>',
        'rule' => '',
        'msg' => '',
        'tip' => '',
        'ok' => '',
        'extend' => '',
    ],
];
