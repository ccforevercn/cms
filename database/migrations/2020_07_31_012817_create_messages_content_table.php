<?php
/**
 * @author: cc_forever<1253705861@qq.com>
 * @day: 2020/7/31
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * 信息信息内容表
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
            $table->integer('id')->primary()->unique()->comment('信息内容表');
            $table->longText('content')->comment('信息内容')->nullable();
            $table->longText('markdown')->comment('信息内容')->nullable();
            $table->longText('images')->comment('信息图片')->nullable();
            $table->tinyInteger('is_del')->comment('是否删除 1是 0否')->default(1);
            $table->index('is_del'); // 是否删除添加唯一索引
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
