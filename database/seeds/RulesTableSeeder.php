<?php
/**
 * @author: cc_forever<1253705861@qq.com>
 * @day: 2020/7/23
 */

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

/**
 * 规则表默认数据
 * Class RulesTableSeeder
 */
class RulesTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('rules')->insert([
            'id' => 1,
            'name' => '超级管理员',
            'admin_id' => 1,
            'add_time' => time(),
            'is_del' => 0
        ]);
    }
}
