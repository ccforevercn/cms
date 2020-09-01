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
            ]
        ]);
    }
}
