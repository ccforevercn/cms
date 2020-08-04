<?php
/**
 * @author: cc_forever<1253705861@qq.com>
 * @day: 2020/8/4
 */
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * 配置分类表
 *
 * Class CreateConfigCategoryTable
 */
class CreateConfigCategoryTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('config_category', function (Blueprint $table) {
            $table->engine = 'InnoDB'; // 表存储引擎
            $table->charset = 'utf8';  //表默认字符集
            $table->collation = 'utf8_general_ci';  // 表默认的排序规则
            $table->bigIncrements('id')->comment('配置分类表');
            $table->string('name', '128')->comment('配置分类名称');
            $table->string('description', '256')->comment('配置分类描述');
            $table->integer('add_time')->comment('配置分类添加时间');
            $table->tinyInteger('is_del')->comment('是否删除(1是 0否)');
            $table->unique('id'); // 编号唯一索引
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
        Schema::dropIfExists('config_category');
    }
}
