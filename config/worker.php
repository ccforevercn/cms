<?php
/**
 * @author: cc_forever<1253705861@qq.com>
 * @day: 2020/7/24
 */

return [
    'name' => 'ccforever',  // worker名称
    'options' =>[
        'blog' => [ // 前台博客配置
            'protocol' => 'websocket://',  // 协议 http://  websocket://  tcp://
            'ip' => '0.0.0.0', // ip地址 0.0.0.0 所有IP都可以接入
            'port' => '1111',  // 端口 指定的端口在服务器的防火墙中
            'name' => 'blog', // 名称
            'count' => 1,  // 启动多少个进程
            'transport' => 'tcp',  // 传输层协议
            'reusePort' => true,  // 是否开启监听端口复用
            'user' => 'www', //  Worker实例以哪个用户运行
            'class' => 'App\CcForever\extend\BlogExtend' // 类的命名空间和类名(类的静态方法作为回调)
        ],
        'manages' => [ // 后台管理员配置
            'protocol' => 'websocket://',  // 协议 http://  websocket://  tcp://
            'ip' => '0.0.0.0', // ip地址 0.0.0.0 所有IP都可以接入
            'port' => '2222',  // 端口 指定的端口在服务器的防火墙中
            'name' => 'manages', // 名称
            'count' => 1,  // 启动多少个进程
            'transport' => 'tcp',  // 传输层协议
            'reusePort' => true,  // 是否开启监听端口复用
            'user' => 'www', //  Worker实例以哪个用户运行
            'class' => 'App\CcForever\extend\ManagesExtend' // 类的命名空间和类名(类的静态方法作为回调)
        ],
        'channel' => [ // 内部通信配置
            'server' => '0.0.0.0', // Server ip地址
            'connect' => '127.0.0.1', // connect ip地址
            'port' => '3333',  // 端口 指定的端口在服务器的防火墙中
            'event' =>[
                'notice_name' => 'notice_broadcast', // 通知广播
                'email_name' => 'email_broadcast',  // 邮件广播
                'document_name' => 'document_broadcast',  // 文件广播
                'article_name' => 'article_broadcast',  // 文章广播
            ],
        ]
    ]
];