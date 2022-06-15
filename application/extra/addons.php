<?php

return [
    'autoload' => false,
    'hooks' => [
        'app_init' => [
            'alioss',
            'wanlshop',
        ],
        'upload_config_init' => [
            'alioss',
        ],
        'upload_delete' => [
            'alioss',
        ],
        'user_sidenav_after' => [
            'recharge',
            'wanlshop',
        ],
        'sms_send' => [
            'smsbao',
        ],
        'sms_notice' => [
            'smsbao',
        ],
        'sms_check' => [
            'smsbao',
        ],
        'upgrade' => [
            'wanlshop',
        ],
    ],
    'route' => [],
    'priority' => [],
];
