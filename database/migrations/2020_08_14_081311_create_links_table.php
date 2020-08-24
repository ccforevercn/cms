<?php
/**
 * @author: cc_forever<1253705861@qq.com>
 * @day: 2020/8/14
 */
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * 友情链接表
 *
 * Class CreateLinksTable
 */
class CreateLinksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('links', function (Blueprint $table) {
            $table->engine = 'InnoDB'; // 表存储引擎
            $table->charset = 'utf8';  //表默认字符集
            $table->collation = 'utf8_general_ci';  // 表默认的排序规则
            $table->bigIncrements('id')->comment('友情链接表');
            $table->string('name', 128)->comment('友情链接名称');
            $table->string('link', 128)->comment('友情链接');
            $table->string('image', 128)->comment('友情链接图片');
            $table->integer('weight')->comment('友情链接权重');
            $table->tinyInteger('follow')->comment('是否权重传递 1是 0否');
            $table->integer('add_time')->comment('添加时间');
            $table->tinyInteger('is_del')->comment('是否删除(1是 0否)');
            $table->unique('id'); // 编号唯一索引
            $table->index('weight'); // 友情链接权重普通索引
            $table->index('follow'); // 是否权重传递普通索引
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
        Schema::dropIfExists('links');
    }
}
