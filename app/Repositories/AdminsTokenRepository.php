<?php
/**
 * @author: cc_forever<1253705861@qq.com>
 * @day: 2020/7/21
 */

namespace App\Repositories;

use App\AdminTokens;
use App\CcForever\interfaces\RepositoryInterface;
use App\CcForever\traits\RepositoryReturnMsgData;

/**
 * 管理员登陆记录
 * Class AdminsTokenRepository
 * @package App\Repositories
 */
class AdminsTokenRepository implements RepositoryInterface
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

    /**
     * 验证Token并返回管理员编号
     * @param string $token
     * @return int
     */
    public static function checkToken(string $token):int
    {
        return self::$model::tokenSelectAdminId($token);
    }

    /**
     * 获取编号
     *
     * @param string $token
     * @return int
     */
    public static function tokenToId(string $token): int
    {
        return self::$model::tokenSelectId($token);
    }

    public static function lst(array $where, int $page, int $limit): bool
    {
        // TODO: Implement lst() method.
    }

    public static function count(array $where): bool
    {
        // TODO: Implement count() method.
    }

    public static function insert(array $data): bool
    {
        // TODO: Implement insert() method.
    }

    /**
     * 修改token过期时间
     *
     * @param array $data
     * @param int $id
     * @return bool
     */
    public static function update(array $data, int $id): bool
    {
        // TODO: Implement update() method.
        $time = array_key_exists('time', $data) ? $data['time'] : time();
        $status = self::$model::time($id, $time);
        return self::setMsg($status ? '修改成功' : '修改失败', $status, []);
    }

    public static function delete(int $id): bool
    {
        // TODO: Implement delete() method.
    }

    public static function message(int $id): bool
    {
        // TODO: Implement message() method.
    }
}