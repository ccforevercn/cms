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
                'select' => 'webname',
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
                'description' => 'PC端',
                'select' => 'weblogopc',
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
                'description' => '网站版权',
                'select' => 'copyright',
                'type' => 1,
                'type_value' => '',
                'value' => '',
                'category_id' => 1,
                'add_time' => time(),
                'is_del' => 0
            ],
            [
                'id' => 5,
                'name' => '网站备案号',
                'description' => '网站备案号',
                'select' => 'record_number',
                'type' => 1,
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
                'select' => 'phone',
                'type' => 1,
                'type_value' => '',
                'value' => '',
                'category_id' => 1,
                'add_time' => time(),
                'is_del' => 0
            ],
            [
                'id' => 7,
                'name' => '手机',
                'description' => '客服手机',
                'select' => 'tel',
                'type' => 1,
                'type_value' => '',
                'value' => '',
                'category_id' => 1,
                'add_time' => time(),
                'is_del' => 0
            ],
            [
                'id' => 8,
                'name' => 'QQ',
                'description' => '客服QQ',
                'select' => 'qq',
                'type' => 1,
                'type_value' => '',
                'value' => '',
                'category_id' => 1,
                'add_time' => time(),
                'is_del' => 0
            ],
            [
                'id' => 9,
                'name' => '邮箱',
                'description' => '客服邮箱',
                'select' => 'email',
                'type' => 1,
                'type_value' => '',
                'value' => '',
                'category_id' => 1,
                'add_time' => time(),
                'is_del' => 0
            ],
            [
                'id' => 10,
                'name' => 'PC端顶部第三方代码',
                'description' => 'PC端顶部第三方代码',
                'select' => 'pc_top',
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
                'description' => 'PC端底部第三方代码',
                'select' => 'pc_bottom',
                'type' => 5,
                'type_value' => '',
                'value' => '',
                'category_id' => 1,
                'add_time' => time(),
                'is_del' => 0
            ]
        ]);
    }
}
