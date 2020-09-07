<?php
/**
 * @author: cc_forever<1253705861@qq.com>
 * @day: 2020/9/7
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * 分站表
 *
 * Class CreateSubstationsTable
 */
class CreateSubstationsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('substations', function (Blueprint $table) {
            $table->engine = 'InnoDB'; // 表存储引擎
            $table->charset = 'utf8';  //表默认字符集
            $table->collation = 'utf8_general_ci';  // 表默认的排序规则
            $table->increments('id')->comment('分站表');
            $table->string('title', 255)->comment('名称');
            $table->string('unique', 128)->unique()->comment('唯一值');
            $table->integer('add_time')->comment('添加时间');
            $table->tinyInteger('is_del')->comment('是否删除(1是 0否)');
            $table->unique('id'); // 编号添加唯一索引
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
        Schema::dropIfExists('substations');
    }
}
