<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            AdminsTableSeeder::class, // 管理员默认数据
            MenusTableSeeder::class, // 菜单默认数据
            RulesTableSeeder::class,  // 规则默认数据
            ConfigMessageSeeder::class,  // 配置分类表默认数据
            ConfigCategorySeeder::class,  // 配置信息表默认数据
        ]);
    }
}
