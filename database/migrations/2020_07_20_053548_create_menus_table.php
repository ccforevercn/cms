<?php
/**
 * @author: cc_forever<1253705861@qq.com>
 * @day: 2020/7/20
 */
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * 菜单表
 * Class CreateMenusTable
 */
class CreateMenusTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('menus', function (Blueprint $table) {
            $table->engine = 'InnoDB'; // 表存储引擎
            $table->charset = 'utf8';  //表默认字符集
            $table->collation = 'utf8_general_ci';  // 表默认的排序规则
            $table->increments('id')->comment('菜单表');
            $table->string('name', 64)->comment('按钮名称');
            $table->integer('parent_id')->default(0)->comment('父级按钮编号');
            $table->string('routes', 64)->comment('路由地址');
            $table->string('page', 64)->default('')->comment('页面链接');
            $table->string('icon', 16)->nullable()->default('')->comment('按钮样式');
            $table->tinyInteger('menu')->default(1)->comment('菜单状态 1 展示 0 隐藏');
            $table->tinyInteger('is_del')->default(0)->comment('删除状态 1 已删除 0 未删除');
            $table->integer('add_time')->comment('按钮添加时间');
            $table->integer('sort')->default(1)->comment('按钮排序');
            $table->unique('id'); // 编号添加唯一索引
            $table->unique('routes'); // 路由地址添加唯一索引
            $table->unique('name'); // 按钮名称添加唯一索引
            $table->index('parent_id'); // 父级按钮编号添加普通索引
            $table->index('menu'); // 菜单状态添加普通索引
            $table->index('is_del'); // 删除状态添加普通索引
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('menus');
    }
}
