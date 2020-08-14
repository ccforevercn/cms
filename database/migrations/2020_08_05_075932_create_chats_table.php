<?php
/**
 * @author: cc_forever<1253705861@qq.com>
 * @day: 2020/8/5
 */
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * 留言表
 *
 * Class CreateChatsTable
 */
class CreateChatsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('chats', function (Blueprint $table) {
            $table->engine = 'InnoDB'; // 表存储引擎
            $table->charset = 'utf8';  //表默认字符集
            $table->collation = 'utf8_general_ci';  // 表默认的排序规则
            $table->bigIncrements('id')->comment('留言表');
            $table->char('customer', 16)->comment('客服名称');
            $table->char('user', 32)->comment('用户名称'); // md5(微秒+ip+5位随机数)
            $table->string('content', 512)->comment('内容');
            $table->string('speak', 32)->comment('发言者');
            $table->integer('add_time')->comment('添加时间');
            $table->tinyInteger('see')->comment('是否查看(1是 0否)');
            $table->tinyInteger('is_del')->comment('是否删除(1是 0否)');
            $table->unique('id'); // 编号唯一索引
            $table->index('customer'); // 客服名称普通索引
            $table->index('user'); // 用户名称普通索引
            $table->index('see'); // 是否查看普通索引
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
        Schema::dropIfExists('chats');
    }
}
