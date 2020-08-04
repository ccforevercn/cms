<?php
/**
 * @author: cc_forever<1253705861@qq.com>
 * @day: 2020/7/31
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * 信息信息表
 *
 * Class CreateMessagesTable
 */
class CreateMessagesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages', function (Blueprint $table) {
            $table->engine = 'InnoDB'; // 表存储引擎
            $table->charset = 'utf8';  //表默认字符集
            $table->collation = 'utf8_general_ci';  // 表默认的排序规则
            $table->bigIncrements('id')->comment('信息信息表');
            $table->string('name', '128')->comment('信息名称')->default('信息名称');
            $table->integer('columns_id')->comment('栏目编号')->default(0)->nullable();
            $table->string('image', '128')->comment('信息图片')->default('')->nullable();
            $table->string('writer', '32')->comment('信息作者')->default('ccforever<1253705861@qq.com>');
            $table->integer('click')->comment('信息点击量')->default(1);
            $table->integer('weight')->comment('信息权重')->default(1);
            $table->string('keywords', '256')->comment('信息关键字')->default('信息关键字');
            $table->string('description', '512')->comment('信息描述')->default('信息描述');
            $table->tinyInteger('index')->comment('首页推荐(1是 0否)')->default(1);
            $table->tinyInteger('hot')->comment('热门推荐(1是 0否)')->default(1);
            $table->tinyInteger('release')->comment('发布状态(1是 0否)')->default(1);
            $table->integer('add_time')->comment('信息添加时间');
            $table->integer('update_time')->comment('信息修改时间');
            $table->integer('release_time')->comment('信息发布时间');
            $table->char('page', '32')->comment('信息页面');
            $table->char('unique', '32')->comment('信息标签唯一值');
            $table->tinyInteger('is_del')->comment('信息是否删除(1是 0否)')->default(0);
            $table->unique('id'); // 编号唯一索引
            $table->unique('unique'); // 标签名称唯一索引
            $table->index('columns_id'); // 栏目编号普通索引
            $table->index('index'); // 首页推荐普通索引
            $table->index('hot');   // 热门推荐普通索引
            $table->index('release');  // 发布状态普通索引
            $table->index(['click', 'columns_id', 'is_del']); // 点击量普通索引
            $table->index(['weight', 'columns_id', 'is_del']); // 权重普通索引
            $table->index(['update_time', 'columns_id', 'is_del']);   // 信息修改时间普通索引
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
        Schema::dropIfExists('messages');
    }
}
