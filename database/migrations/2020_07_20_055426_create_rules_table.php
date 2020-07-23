<?php
/**
 * @author: cc_forever<1253705861@qq.com>
 * @day: 2020/7/20
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * 管理员规则表
 * Class CreateRulesTable
 */
class CreateRulesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('rules', function (Blueprint $table) {
            $table->engine = 'InnoDB'; // 表存储引擎
            $table->charset = 'utf8';  //表默认字符集
            $table->collation = 'utf8_general_ci';  // 表默认的排序规则
            $table->bigIncrements('id')->comment('管理员规则表');
            $table->string('name', '64')->comment('规则名称');
            $table->integer('admin_id')->comment('管理员编号(哪一个管理员创建的规则)');
            $table->integer('add_time')->comment('规则添加时间');
            $table->tinyInteger('is_del')->comment('是否删除 1 是 0 否');
            $table->unique('id'); // 编号添加唯一索引
            $table->index('admin_id'); // 管理员编号普通索引
            $table->index('is_del'); // 是否删除添加普通索引
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('rules');
    }
}
