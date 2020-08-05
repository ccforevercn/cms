<?php
/**
 * @author: cc_forever<1253705861@qq.com>
 * @day: 2020/8/5
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * 轮播图表
 *
 * Class CreateBannersTable
 */
class CreateBannersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('banners', function (Blueprint $table) {
            $table->engine = 'InnoDB'; // 表存储引擎
            $table->charset = 'utf8';  //表默认字符集
            $table->collation = 'utf8_general_ci';  // 表默认的排序规则
            $table->bigIncrements('id')->comment('轮播图表');
            $table->string('name', '128')->comment('轮播图名称');
            $table->string('link', '128')->comment('轮播图链接');
            $table->string('image', '128')->comment('轮播图地址');
            $table->integer('weight')->comment('轮播图权重');
            $table->tinyInteger('type')->comment('轮播图类型 1 PC 2 WAP');
            $table->integer('add_time')->comment('配置信息添加时间');
            $table->tinyInteger('is_del')->comment('是否删除(1是 0否)');
            $table->unique('id'); // 编号唯一索引
            $table->index('type'); // 轮播图类型普通索引
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
        Schema::dropIfExists('banners');
    }
}
