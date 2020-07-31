<?php
/**
 * @author: cc_forever<1253705861@qq.com>
 * @day: 2020/7/31
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * 文章信息内容表
 *
 * Class CreateMessagesContentTable
 */
class CreateMessagesContentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('messages_content', function (Blueprint $table) {
            $table->integer('mid')->comment('文章信息表');
            $table->text('content')->comment('文章内容')->default('文章内容');
            $table->text('images')->comment('文章图片')->default('');
            $table->primary('mid'); // 文章编号设置为主键
            $table->unique('mid'); // 文章编号唯一索引
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('messages_content');
    }
}
