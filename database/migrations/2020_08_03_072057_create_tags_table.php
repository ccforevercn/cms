<?php
/**
 * @author: cc_forever<1253705861@qq.com>
 * @day: 2020/8/3
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTagsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tags', function (Blueprint $table) {
            $table->engine = 'InnoDB'; // 表存储引擎
            $table->charset = 'utf8';  //表默认字符集
            $table->collation = 'utf8_general_ci';  // 表默认的排序规则
            $table->bigIncrements('id')->comment('标签表');
            $table->char('name', 32)->comment('标签名称');
            $table->integer('add_time')->comment('添加时间');
            $table->tinyInteger('status')->comment('标签状态 1 展示 0 隐藏');
            $table->tinyInteger('is_del')->comment('是否删除 1 是 0 否');
            $table->unique('id'); // 编号唯一索引
            $table->unique('name'); // 标签名称唯一索引
            $table->index('status'); // 标签状态普通索引
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
        Schema::dropIfExists('tags');
    }
}
