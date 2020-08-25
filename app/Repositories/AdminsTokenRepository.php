<?php
/**
 * @author: cc_forever<1253705861@qq.com>
 * @day: 2020/7/21
 */

namespace App\Repositories;

use App\AdminTokens;
use App\CcForever\traits\RepositoryReturnMsgData;

/**
 * 管理员登陆记录
 * Class AdminsTokenRepository
 * @package App\Repositories
 */
class AdminsTokenRepository
{
    use RepositoryReturnMsgData;

    public function __construct(AdminTokens $model = null)
    {
        if(is_null($model)){
            self::loading();
        }else{
            self::$model = $model;
        }
    }

    /**
     * 手动加载Model
     */
    private static function loading(): void
    {
        self::$model = new AdminTokens();
    }

    /**
     * 管理员登陆
     * @param array $data
     * @return bool
     */
    public static function login(array $data): bool
    {
        $admin_id  = array_key_exists('id', $data) ? (int)$data['id'] : null;
        $username  = array_key_exists('username', $data) ? (string)$data['username'] : null;
        $token  = array_key_exists('token', $data) ? (string)$data['token'] : null;
        $start_time  = array_key_exists('start_time', $data) ? (int)$data['start_time'] : null;
        $stop_time  = array_key_exists('stop_time', $data) ? (int)$data['stop_time'] : null;
        if(!check_null($admin_id, $username, $token, $start_time, $stop_time)){
            return self::setMsg('参数错误', false);
        }
        $status = self::$model::login($username, $token, $admin_id, $start_time, $stop_time);
        return self::setMsg("登陆成功", $status);
    }
}