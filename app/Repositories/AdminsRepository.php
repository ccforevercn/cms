<?php
/**
 * @author: cc_forever<1253705861@qq.com>
 * @day: 2020/7/20
 */

namespace App\Repositories;

use App\Admins;
use App\CcForever\interfaces\RepositoryInterface;
use App\CcForever\traits\RepositoryReturnMsgData;

/**
 * 管理员
 * Class AdminsRepository
 * @package App\Repositories
 */
class AdminsRepository implements RepositoryInterface
{
    use RepositoryReturnMsgData;

    public function __construct(Admins $model) {
        self::$model = $model;
    }

    /**
     * 管理员登陆信息
     * @param string $username
     * @param string $password
     * @return bool
     */
    public static function login(string $username, string $password): bool
    {
        try{
            // 验证账号密码，获取登录秘钥
            $token = auth('login')->attempt(['username' => $username, 'password' => create_admin_password($password)]);
            $start_time = (int)time();
            $expires_in = auth('login')->factory()->getTTL() * 60;
            $stop_time = (int)bcadd($expires_in, $start_time, 0);
        }catch (\Exception $exception){ // 获取登录秘钥失败
            return self::setMsg('登陆失败，请联系网站网站管理员', false);
        }
        if(!$token){// 获取登录秘钥失败
            return self::setMsg('登陆失败，请重新登陆', false);
        }
        $id = self::$model::username($username)->value('id'); // 获取管理员编号
        if(is_null($id)){ // 管理员不存在
            return self::setMsg('用户不存在', false);
        }
        $check = self::$model::checkId($id);
        if(!$check){ // 管理员已删除
            return self::setMsg('用户不存在', false);
        }
        $userInfo = self::$model::message($id); // 管理员登陆信息
        if(!$userInfo['status']){// 管理员账号已锁定
            return self::setMsg('账号已锁定', false);
        }
        $login = self::$model::login($id, (int)bcadd($userInfo['login_count'], 1, 0)); // 添加登陆记录
        if(!$login){// 添加登陆记录失败
            return self::setMsg('登陆失败', false);
        }
        return self::setMsg('登陆成功', true, compact('id', 'username', 'token', 'start_time', 'stop_time', 'expires_in'));
    }

    /**
     * 菜单列表
     * @param array $where
     * @param int $page
     * @param int $limit
     * @return bool
     */
    public static function lst(array $where, int $page, int $limit): bool
    {
        // TODO: Implement lst() method.
        $where['parent_id'] = array_key_exists('parent_id', $where) ? $where['parent_id'] : '';// 上级管理员是否存在
        $where['username'] = array_key_exists('username', $where) ? $where['username'] : '';// 管理员账号是否存在
        $offset = page_to_offset($page, $limit); // 获取起始值
        $list = self::$model::lst($where, $offset, $limit);// 菜单列表
        return self::setMsg('菜单列表', true, $list);
    }

    /**
     * 菜单总数
     * @param array $where
     * @return bool
     */
    public static function count(array $where): bool
    {
        // TODO: Implement count() method.
        $where['parent_id'] = array_key_exists('parent_id', $where) ? $where['parent_id'] : '';// 上级管理员是否存在
        $where['username'] = array_key_exists('username', $where) ? $where['username'] : '';// 管理员账号是否存在
        $count = self::$model::count($where);// 菜单列表
        return self::setMsg('菜单总数', true, $count);
    }

    public static function add(array $data): bool
    {
        // TODO: Implement add() method.
    }

    public static function modify(array $data, int $id): bool
    {
        // TODO: Implement modify() method.
    }

    public static function recycle(int $id): bool
    {
        // TODO: Implement recycle() method.
    }

    public static function message(int $id): bool
    {
        // TODO: Implement message() method.
    }


}