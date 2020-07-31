<?php
/**
 * @author: cc_forever<1253705861@qq.com>
 * @day: 2020/7/31
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * 栏目内容表
 *
 * Class CreateColumnsContentTable
 */
class CreateColumnsContentTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('columns_content', function (Blueprint $table) {
            $table->integer('id')->primary()->unique()->comment('栏目内容表');
            $table->longText('content')->comment('栏目内容')->nullable();
            $table->longText('markdown')->comment('栏目内容')->nullable();
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
        Schema::dropIfExists('columns_content');
    }
}
