<?php
/**
 * @author: cc_forever<1253705861@qq.com>
 * @day: 2020/7/21
 */

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

/**
 * 管理员表默认数据
 * Class AdminsTableSeeder
 */
class AdminsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('admins')->insert([
            'username' => 'ccforever',
            'password' => Hash::make(create_admin_password('68888886')),
            'real_name' => '管理员昵称',
            'status' => 1,
            'found' => 1,
            'parent_id' => 0,
            'rule_id' => 1,
            'add_time' => time(),
            'add_ip' => app('request')->ip(),
            'last_time' => time(),
            'last_ip' => app('request')->ip(),
            'login_count' => 0,
            'is_del' => 0
        ]);
    }
}
