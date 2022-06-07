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
        'user_sidenav_after' => [
            'wanlshop',
        ],
    ],
    'route' => [],
    'priority' => [],
];
