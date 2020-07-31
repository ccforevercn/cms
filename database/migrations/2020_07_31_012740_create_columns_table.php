<?php
/**
 * @author: cc_forever<1253705861@qq.com>
 * @day: 2020/7/31
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * 栏目表
 *
 * Class CreateColumnsTable
 */
class CreateColumnsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('columns', function (Blueprint $table) {
            $table->engine = 'InnoDB'; // 表存储引擎
            $table->charset = 'utf8';  //表默认字符集
            $table->collation = 'utf8_general_ci';  // 表默认的排序规则
            $table->bigIncrements('id')->comment('栏目表');
            $table->string('name', '128')->comment('栏目名称')->default('栏目名称');
            $table->string('name_alias', '128')->comment('栏目别名')->default('栏目别名');
            $table->integer('parent_id')->comment('父级栏目编号')->default(0)->nullable();
            $table->string('image', '128')->comment('栏目图片')->default('')->nullable();
            $table->string('banner_image', '128')->comment('栏目轮播图片')->default('')->nullable();
            $table->string('description', '512')->comment('栏目描述')->default('栏目描述');
            $table->integer('weight')->comment('栏目权重')->default(1);
            $table->integer('sort')->comment('栏目排序(栏目下的文章排序) 0 默认编号倒叙 1 修改时间升序 2 修改时间倒叙 3 权重升序 4 权重倒叙 5 点击量升序 6 点击量降序')->default(0);
            $table->tinyInteger('navigation')->comment('导航状态(1是 0否)')->default(0);
            $table->tinyInteger('render')->comment('渲染类型(1超链 0页面)')->default(0);
            $table->char('page', '32')->comment('栏目页面');
            $table->integer('add_time')->comment('栏目添加时间');
            $table->tinyInteger('is_del')->comment('栏目是否删除(1是 0否)')->default(0);
            $table->unique('id'); // 编号添加唯一索引
            $table->index('parent_id'); // 父级栏目编号添加唯一索引
            $table->index('navigation'); // 导航状态普通索引
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
        Schema::dropIfExists('columns');
    }
}
