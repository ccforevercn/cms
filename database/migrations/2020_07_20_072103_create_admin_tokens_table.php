<?php
/**
 * @author: cc_forever<1253705861@qq.com>
 * @day: 2020/7/20
 */
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * 管理员登陆表
 * Class CreateAdminTokensTable
 */
class CreateAdminTokensTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admin_tokens', function (Blueprint $table) {
            $table->engine = "InnoDB"; // 指定表存储引擎 (MySQL)
            $table->charset = 'utf8'; // 指定表的默认字符编码 (MySQL)
            $table->collation = 'utf8_unicode_ci'; // 指定表的默认排序格式 (MySQL)
            $table->bigIncrements('id')->comment('管理员登陆表');
            $table->char('username', 16)->comment('管理员账号');
            $table->integer('admin_id')->comment('管理员编号');
            $table->string('token', 512)->comment('管理员登陆token');
            $table->integer('start_time')->comment('管理员登陆token添加时间');
            $table->integer('stop_time')->comment('管理员登陆token过期时间');
            $table->unique('id'); // 编号 添加唯一索引
            $table->index('admin_id'); //  管理员编号 添加普通索引
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admin_tokens');
    }
}
