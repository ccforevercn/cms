<?php
/**
 * @author: cc_forever<1253705861@qq.com>
 * @day: 2020/8/4
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * 视图表
 *
 * Class CreateViewsTable
 */
class CreateViewsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('views', function (Blueprint $table) {
            $table->engine = 'InnoDB'; // 表存储引擎
            $table->charset = 'utf8';  //表默认字符集
            $table->collation = 'utf8_general_ci';  // 表默认的排序规则
            $table->bigIncrements('id')->comment('视图表(栏目和文章视图)');
            $table->string('name', 32)->comment('视图名称');
            $table->char('path', 16)->comment('视图地址');
            $table->integer('add_time')->comment('视图名称添加时间');
            $table->tinyInteger('type')->comment('视图类型 1 栏目 2 文章');
            $table->tinyInteger('is_del')->comment('是否删除 1 是 0 否');
            $table->unique('id'); // 编号唯一索引
            $table->index('type'); // 视图类型普通索引
            $table->index('is_del'); // 是否删除普通索引
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('views');
    }
}
