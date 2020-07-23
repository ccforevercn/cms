<?php
/**
 * @author: cc_forever<1253705861@qq.com>
 * @day: 2020/7/23
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * 规则菜单表
 * Class CreateRulesMenusTable
 */
class CreateRulesMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rules_menus', function (Blueprint $table) {
            $table->engine = 'InnoDB'; // 表存储引擎
            $table->charset = 'utf8';  //表默认字符集
            $table->collation = 'utf8_general_ci';  // 表默认的排序规则
            $table->bigIncrements('id')->comment('规则菜单表');
            $table->char('unique', 32)->comment('规则唯一值');
            $table->integer('menu_id')->comment('菜单编号');
            $table->integer('add_time')->comment('菜单编号添加时间');
            $table->integer('clear_time')->comment('菜单编号清除时间');
            $table->tinyInteger('is_del')->comment('菜单是否删除 是 1 否 0')->default(0);
            $table->unique('id'); // 编号添加唯一索引
            $table->index('unique'); // 规则唯一值添加唯一索引
            $table->index('menu_id'); // 菜单编号普通索引
            $table->index('is_del'); // 菜单是否删除普通索引
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rules_menus');
    }
}
