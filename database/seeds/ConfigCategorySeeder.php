<?php
/**
 * @author: cc_forever<1253705861@qq.com>
 * @day: 2020/9/1
 */

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * 配置分类表默认数据
 *
 * Class ConfigCategorySeeder
 */
class ConfigCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('config_category')->insert([
            [
                'id' => 1,
                'name' => '基础配置',
                'description' => '网站基础配置',
                'add_time' => time(),
                'is_del' => 0
            ],
            [
                'id' => 2,
                'name' => 'seo配置',
                'description' => '网站seo配置',
                'add_time' => time(),
                'is_del' => 0
            ],
            [
                'id' => 3,
                'name' => '客服配置',
                'description' => '网站客服配置',
                'add_time' => time(),
                'is_del' => 0
            ],
            [
                'id' => 4,
                'name' => '短信配置',
                'description' => '网站短信配置(用户留言后没有查看的信息发送短信)',
                'add_time' => time(),
                'is_del' => 0
            ],
            [
                'id' => 5,
                'name' => '邮件配置',
                'description' => '网站邮件配置(用户留言后没有查看的信息发送邮件)',
                'add_time' => time(),
                'is_del' => 0
            ],
        ]);
    }
}
