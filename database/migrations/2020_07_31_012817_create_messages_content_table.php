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
            $table->integer('mid')->primary()->unique()->comment('文章信息表');
            $table->longText('content')->comment('文章内容')->nullable();
            $table->longText('images')->comment('文章图片')->nullable();
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
