<?php
/**
 * @author: cc_forever<1253705861@qq.com>
 * @day: 2020/7/27
 */

return [
    'prefix' => [
        'admin' => env('ADMIN_PREFIX', 'ccforever'),
        'label' => env('LABEL_PREFIX', 'cc_cms')
    ],
    'suffix' => [
        'page' => env('PAGE_SUFFIX', '.html'),
    ],
    'config' => [
        'unique_list' => env('CONFIG_UNIQUE_LIST', 'website'),
        'wap_type' => env('CONFIG_WAP_TYPE', '1')
    ]
];
