<?php
/**
 * @author: cc_forever<1253705861@qq.com>
 * @day: 2020/9/1
 */

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
/**
 * 配置信息表默认数据
 *
 * Class ConfigMessageSeeder
 */
class ConfigMessageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('config_message')->insert([
            [
                'id' => 1,
                'name' => '网站名称',
                'description' => '网站名称',
                'select' => 'name',
                'type' => 1,
                'type_value' => '',
                'value' => '网站名称',
                'category_id' => 1,
                'add_time' => time(),
                'is_del' => 0
            ],
            [
                'id' => 2,
                'name' => '网站域名',
                'description' => '网站域名',
                'select' => 'website',
                'type' => 1,
                'type_value' => '',
                'value' => 'http://www.ccforever.cn',
                'category_id' => 1,
                'add_time' => time(),
                'is_del' => 0
            ],
            [
                'id' => 3,
                'name' => '网站LOGO',
                'description' => 'PC端顶部',
                'select' => 'pc_logo_top',
                'type' => 4,
                'type_value' => '',
                'value' => '',
                'category_id' => 1,
                'add_time' => time(),
                'is_del' => 0
            ],
            [
                'id' => 4,
                'name' => '网站版权',
                'description' => '网站版权(支持html标签)',
                'select' => 'copyright',
                'type' => 5,
                'type_value' => '',
                'value' => '',
                'category_id' => 1,
                'add_time' => time(),
                'is_del' => 0
            ],
            [
                'id' => 5,
                'name' => '网站备案号',
                'description' => '网站备案号(支持html标签)',
                'select' => 'record_number',
                'type' => 5,
                'type_value' => '',
                'value' => '',
                'category_id' => 1,
                'add_time' => time(),
                'is_del' => 0
            ],
            [
                'id' => 6,
                'name' => '电话',
                'description' => '客服电话',
                'select' => 'service_phone',
                'type' => 1,
                'type_value' => '',
                'value' => '',
                'category_id' => 3,
                'add_time' => time(),
                'is_del' => 0
            ],
            [
                'id' => 7,
                'name' => '手机',
                'description' => '客服手机',
                'select' => 'service_tel',
                'type' => 1,
                'type_value' => '',
                'value' => '',
                'category_id' => 3,
                'add_time' => time(),
                'is_del' => 0
            ],
            [
                'id' => 8,
                'name' => 'QQ',
                'description' => '客服QQ',
                'select' => 'service_qq',
                'type' => 1,
                'type_value' => '',
                'value' => '',
                'category_id' => 3,
                'add_time' => time(),
                'is_del' => 0
            ],
            [
                'id' => 9,
                'name' => '邮箱',
                'description' => '客服邮箱',
                'select' => 'service_email',
                'type' => 1,
                'type_value' => '',
                'value' => '',
                'category_id' => 3,
                'add_time' => time(),
                'is_del' => 0
            ],
            [
                'id' => 10,
                'name' => 'PC端顶部第三方代码',
                'description' => 'PC端顶部第三方代码(支持html标签和script标签)',
                'select' => 'pc_top_code',
                'type' => 5,
                'type_value' => '',
                'value' => '',
                'category_id' => 1,
                'add_time' => time(),
                'is_del' => 0
            ],
            [
                'id' => 11,
                'name' => 'PC端底部第三方代码',
                'description' => 'PC端底部第三方代码(支持html标签和script标签)',
                'select' => 'pc_bottom_code',
                'type' => 5,
                'type_value' => '',
                'value' => '',
                'category_id' => 1,
                'add_time' => time(),
                'is_del' => 0
            ],
            [
                'id' => 12,
                'name' => '网站标题',
                'description' => '网站标题(head标签，首页标题、栏目页面和信息页面标题后缀，一般不超过80个字符)',
                'select' => 'title',
                'type' => 1,
                'type_value' => '',
                'value' => '',
                'category_id' => 2,
                'add_time' => time(),
                'is_del' => 0
            ],
            [
                'id' => 13,
                'name' => '网站关键字',
                'description' => '网站关键字(head标签，首页关键字、栏目页面关键字后缀，一般不超过100个字符)',
                'select' => 'keyword',
                'type' => 1,
                'type_value' => '',
                'value' => '',
                'category_id' => 2,
                'add_time' => time(),
                'is_del' => 0
            ],
            [
                'id' => 14,
                'name' => '网站描述',
                'description' => '网站描述(head标签，首页描述、栏目页面描述后缀，一般不超过200个字符)',
                'select' => 'description',
                'type' => 5,
                'type_value' => '',
                'value' => '',
                'category_id' => 2,
                'add_time' => time(),
                'is_del' => 0
            ],
            [
                'id' => 15,
                'name' => '姓名',
                'description' => '客服姓名',
                'select' => 'service_name',
                'type' => 1,
                'type_value' => '',
                'value' => '',
                'category_id' => 3,
                'add_time' => time(),
                'is_del' => 0
            ],
            [
                'id' => 16,
                'name' => '二维码',
                'description' => '客服二维码',
                'select' => 'service_code',
                'type' => 4,
                'type_value' => '',
                'value' => '',
                'category_id' => 3,
                'add_time' => time(),
                'is_del' => 0
            ],
            [
                'id' => 17,
                'name' => '微信号',
                'description' => '客服微信号',
                'select' => 'service_wechat',
                'type' => 1,
                'type_value' => '',
                'value' => '',
                'category_id' => 3,
                'add_time' => time(),
                'is_del' => 0
            ],
            [
                'id' => 18,
                'name' => '热搜词',
                'description' => '网站热搜词(多个请用|隔开，支持html标签)',
                'select' => 'heat_word',
                'type' => 5,
                'type_value' => '',
                'value' => '',
                'category_id' => 2,
                'add_time' => time(),
                'is_del' => 0
            ],
            [
                'id' => 19,
                'name' => '网站LOGO',
                'description' => 'PC端底部',
                'select' => 'pc_bottom_logo',
                'type' => 4,
                'type_value' => '',
                'value' => '',
                'category_id' => 1,
                'add_time' => time(),
                'is_del' => 0
            ],
            [
                'id' => 20,
                'name' => '地址',
                'description' => '客服地址',
                'select' => 'service_address',
                'type' => 1,
                'type_value' => '',
                'value' => '',
                'category_id' => 3,
                'add_time' => time(),
                'is_del' => 0
            ],
            [
                'id' => 21,
                'name' => '网站LOGO',
                'description' => 'WAP端顶部',
                'select' => 'wap_top_logo',
                'type' => 4,
                'type_value' => '',
                'value' => '',
                'category_id' => 1,
                'add_time' => time(),
                'is_del' => 0
            ],
            [
                'id' => 22,
                'name' => '网站内链和外链的优先级',
                'description' => '网站地图XML内链和外链的优先级',
                'select' => 'priority',
                'type' => 2,
                'type_value' => '0.8:高|0.6:中|0.4:低',
                'value' => '0.6',
                'category_id' => 2,
                'add_time' => time(),
                'is_del' => 0
            ],
            [
                'id' => 23,
                'name' => '页面内容更改频率',
                'description' => '网站地图XML页面内容更改频率',
                'select' => 'changefreq',
                'type' => 2,
                'type_value' => 'always:随时|hourly:每小时|daily:每天|weekly:每周|monthly:每月|yearly:每年|never:永久',
                'value' => 'monthly',
                'category_id' => 2,
                'add_time' => time(),
                'is_del' => 0
            ],
            [
                'id' => 24,
                'name' => '信息前缀',
                'description' => '信息标题前缀(head标签内添加)',
                'select' => 'message_prefix',
                'type' => 1,
                'type_value' => '',
                'value' => '',
                'category_id' => 2,
                'add_time' => time(),
                'is_del' => 0
            ],
            [
                'id' => 25,
                'name' => '信息后缀',
                'description' => '信息标题后缀(head标签内添加)',
                'select' => 'message_suffix',
                'type' => 1,
                'type_value' => '',
                'value' => '',
                'category_id' => 2,
                'add_time' => time(),
                'is_del' => 0
            ],
            [
                'id' => 26,
                'name' => '信息编号(前缀)',
                'description' => '追加的标题前缀的信息',
                'select' => 'message_ids_prefix',
                'type' => 1,
                'type_value' => '',
                'value' => '',
                'category_id' => 2,
                'add_time' => time(),
                'is_del' => 0
            ],
            [
                'id' => 27,
                'name' => '信息编号(后缀)',
                'description' => '追加的标题后缀的信息',
                'select' => 'message_ids_suffix',
                'type' => 1,
                'type_value' => '',
                'value' => '',
                'category_id' => 2,
                'add_time' => time(),
                'is_del' => 0
            ],
            [
                'id' => 28,
                'name' => 'WAP端顶部第三方代码',
                'description' => 'WAP端顶部第三方代码(支持html标签和script标签)',
                'select' => 'wap_top_code',
                'type' => 5,
                'type_value' => '',
                'value' => '',
                'category_id' => 1,
                'add_time' => time(),
                'is_del' => 0
            ],
            [
                'id' => 29,
                'name' => 'WAP端底部第三方代码',
                'description' => 'WAP端底部第三方代码(支持html标签和script标签)',
                'select' => 'wap_bottom_code',
                'type' => 5,
                'type_value' => '',
                'value' => '',
                'category_id' => 1,
                'add_time' => time(),
                'is_del' => 0
            ],
            [
                'id' => 30,
                'name' => '留言连接',
                'description' => '客服留言连接',
                'select' => 'service_ws_url',
                'type' => 1,
                'type_value' => '',
                'value' => '',
                'category_id' => 1,
                'add_time' => time(),
                'is_del' => 0
            ],
            [
                'id' => 31,
                'name' => '作者',
                'description' => '网站作者',
                'select' => 'author',
                'type' => 1,
                'type_value' => '',
                'value' => '',
                'category_id' => 1,
                'add_time' => time(),
                'is_del' => 0
            ],
            [
                'id' => 32,
                'name' => 'accessKeyId',
                'description' => 'accessKeyId',
                'select' => 'smsaccesskeyid',
                'type' => 1,
                'type_value' => '',
                'value' => '',
                'category_id' => 4,
                'add_time' => time(),
                'is_del' => 0
            ],
            [
                'id' => 33,
                'name' => 'accessSecret',
                'description' => 'accessSecret',
                'select' => 'smsaccesssecret',
                'type' => 1,
                'type_value' => '',
                'value' => '',
                'category_id' => 4,
                'add_time' => time(),
                'is_del' => 0
            ],
            [
                'id' => 34,
                'name' => '服务器区域',
                'description' => '服务器区域',
                'select' => 'smsregionid',
                'type' => 1,
                'type_value' => '',
                'value' => '',
                'category_id' => 4,
                'add_time' => time(),
                'is_del' => 0
            ],
            [
                'id' => 35,
                'name' => '模版签名',
                'description' => '模版签名(发送短信时提示给用户)',
                'select' => 'smssignname',
                'type' => 1,
                'type_value' => '',
                'value' => '',
                'category_id' => 4,
                'add_time' => time(),
                'is_del' => 0
            ],
            [
                'id' => 36,
                'name' => '模版编号',
                'description' => '模版编号(发送短信内容对于的模板编号)',
                'select' => 'smstemplate',
                'type' => 1,
                'type_value' => '',
                'value' => '',
                'category_id' => 4,
                'add_time' => time(),
                'is_del' => 0
            ],
            [
                'id' => 37,
                'name' => '短信状态',
                'description' => '短信状态',
                'select' => 'smsstatus',
                'type' => 2,
                'type_value' => '1:开启|0:关闭',
                'value' => '0',
                'category_id' => 4,
                'add_time' => time(),
                'is_del' => 0
            ],
            [
                'id' => 38,
                'name' => '短信收件人',
                'description' => '短信收件人',
                'select' => 'smsphone',
                'type' => 1,
                'type_value' => '',
                'value' => '',
                'category_id' => 4,
                'add_time' => time(),
                'is_del' => 0
            ],
            [
                'id' => 39,
                'name' => '邮件地址',
                'description' => '接受程序邮件提示的邮件地址',
                'select' => 'emailaddress',
                'type' => 1,
                'type_value' => '',
                'value' => '',
                'category_id' => 5,
                'add_time' => time(),
                'is_del' => 0
            ],
        ]);
    }
}
