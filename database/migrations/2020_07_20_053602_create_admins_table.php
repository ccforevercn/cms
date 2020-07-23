<?php
/**
 * @author: cc_forever<1253705861@qq.com>
 * @day: 2020/7/20
 */

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * 管理员表
 * Class CreateAdminTable
 */
class CreateAdminsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->engine = 'InnoDB'; // 表存储引擎
            $table->charset = 'utf8';  //表默认字符集
            $table->collation = 'utf8_general_ci';  // 表默认的排序规则
            $table->increments('id')->comment('管理员表');
            $table->char('username', 16)->comment('管理员账号');
            $table->char('password', 64)->comment('管理员密码');
            $table->string('real_name', 16)->comment('管理员昵称');
            $table->tinyInteger('status')->comment('管理员状态 1 正常 0 锁定')->default(1);
            $table->tinyInteger('found')->comment('创建管理员权限 1 是 0 否')->default(1);
            $table->integer('parent_id')->comment('父级管理员编号')->default(0);
            $table->tinyInteger('rule_id')->comment('规则编号')->default(0);
            $table->string('email')->comment('管理员邮箱');
            $table->integer('add_time')->comment('管理员添加时间');
            $table->char('add_ip', 15)->comment('管理员添加ip');
            $table->integer('last_time')->comment('管理员最后一次登录时间');
            $table->char('last_ip', 15)->comment('管理员最后一次登录ip');
            $table->integer('login_count')->comment('登录次数')->default(0);
            $table->tinyInteger('is_del')->comment('是否删除')->default(0);
            $table->unique('id'); // 编号添加唯一索引
            $table->unique('username'); // 管理员账号添加唯一索引
            $table->index('parent_id');// 父级管理员编号添加普通索引
            $table->index('is_del');// 是否删除添加普通索引
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('admins');
    }
}
