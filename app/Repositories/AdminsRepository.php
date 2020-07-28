<?php
/**
 * @author: cc_forever<1253705861@qq.com>
 * @day: 2020/7/20
 */

namespace App\Repositories;

use App\Admins;
use App\CcForever\extend\PRedisExtend;
use App\CcForever\interfaces\RepositoryInterface;
use App\CcForever\traits\RepositoryReturnMsgData;
use App\Rules;
use function GuzzleHttp\Psr7\str;
use Illuminate\Support\Facades\Hash;

/**
 * 管理员
 * Class AdminsRepository
 * @package App\Repositories
 */
class AdminsRepository implements RepositoryInterface
{
    use RepositoryReturnMsgData;

    public function __construct(Admins $model = null) {
        if(is_null($model)){
            self::loading();
        }else{
            self::$model = $model;
        }
    }

    /**
     * 手动加载Model
     */
    public static function loading(): void
    {
        self::$model = new Admins();
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
        $check = self::$model::base_bool('check', [], $id); // 判断管理员是否存在
        if(!$check){ // 管理员已删除
            return self::setMsg('用户不存在', false);
        }
        $userInfo = self::$model::base_array('message', [], $id, self::$model::$message); // 管理员登陆信息
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
        return self::setMsg('菜单总数', true, [$count]);
    }

    /**
     * 管理员添加
     * @param array $data
     * @return bool
     */
    public static function insert(array $data): bool
    {
        // TODO: Implement add() method.
        $admin = [];
        $admin['username'] = array_key_exists('username', $data) ? $data['username'] : null;
        $admin['password'] = array_key_exists('password', $data) ? $data['password'] : null;
        $admin['real_name'] = array_key_exists('real_name', $data) ? $data['real_name'] : null;
        $admin['parent_id'] = array_key_exists('parent_id', $data) ? (int)$data['parent_id'] : null;
        $admin['status'] = array_key_exists('status', $data) ? (int)$data['status'] : null;
        $admin['found'] = array_key_exists('found', $data) ? (int)$data['found'] : null;
        $admin['rule_id'] = array_key_exists('rule_id', $data) ? (int)$data['rule_id'] : null;
        $admin['email'] = array_key_exists('email', $data) ? $data['email'] : null;
        if(is_null($admin['username']) || is_null($admin['password']) || is_null($admin['real_name']) || is_null($admin['parent_id']) || is_null($admin['status']) || is_null($admin['found']) || is_null($admin['rule_id']) || is_null($admin['email'])){
            return self::setMsg('参数错误', false);
        }
        $admin['password'] = Hash::make(create_admin_password($admin['password'])); // 加密管理员密码
        // 判断规则是否存在
        $rulesCount = Rules::base_bool('check', [] , $admin['rule_id']);
        if(!$rulesCount){
            return self::setMsg('规则不存在', false);
        }
        $admin['add_time'] = time();
        $admin['add_ip'] = app('request')->ip();
        $admin['last_time'] = time();
        $admin['last_ip'] = app('request')->ip();
        $admin['login_count'] = 0;
        $admin['is_del'] = 0;
        $status = self::$model::base_bool('insert', $admin, 0); // 添加管理员
        return self::setMsg($status ? '添加成功' : '添加失败', $status);
    }

    /**
     * 管理员修改
     * @param array $data
     * @param int $id
     * @return bool
     */
    public static function update(array $data, int $id): bool
    {
        // TODO: Implement update() method.
        $check = self::$model::base_bool('check', [], $id); // 验证编号
        if(!$check){
            return self::setMsg('参数错误', false);
        }
        $admin = [];
        $admin['password'] = array_key_exists('password', $data) ? $data['password'] : '';
        $admin['real_name'] = array_key_exists('real_name', $data) ? $data['real_name'] : null;
        $admin['status'] = array_key_exists('status', $data) ? (int)$data['status'] : null;
        $admin['found'] = array_key_exists('found', $data) ? (int)$data['found'] : null;
        $admin['rule_id'] = array_key_exists('rule_id', $data) ? (int)$data['rule_id'] : null;
        $admin['email'] = array_key_exists('email', $data) ? $data['email'] : null;
        if(is_null($admin['real_name']) || is_null($admin['status']) || is_null($admin['found']) || is_null($admin['rule_id']) || is_null($admin['email'])){
            return self::setMsg('参数错误', false);
        }
        $admin['password'] = strlen($admin['password']) ? Hash::make(create_admin_password($admin['password'])) : ''; // 加密管理员密码
        if(!strlen($admin['password'])){ // 密码不存在时
            unset($admin['password']);
            // 当前数据库的信息和用户提交的信息是否一致
            $select = array_keys($admin); // 修改的字段
            $message = self::$model::base_array('message', [], $id, $select);
            if($message === $admin){ // 数据库的数据和修改的数据一致
                return self::setMsg('修改成功', true);
            }
        }
        // 判断当前管理员是否有修改管理员的权限
        $checkAdminHandleStatus = self::checkAdminHandle($id, auth('login')->id());
        if(!$checkAdminHandleStatus){
            return self::setMsg('没有权限修改', false);
        }
        $status = self::$model::base_bool('update', $admin, $id); // 修改数据
        return self::setMsg($status ? '修改成功' : '修改失败', $status);
    }

    /**
     * 管理员删除
     * @param int $id
     * @return bool
     */
    public static function delete(int $id): bool
    {
        // TODO: Implement delete() method.
        $check = self::$model::base_bool('check', [], $id); // 验证编号
        if(!$check){
            return self::setMsg('已删除', true);
        }
        // 判断当前管理员是否有删除管理员的权限
        $checkAdminHandleStatus = self::checkAdminHandle($id, auth('login')->id());
        if(!$checkAdminHandleStatus){
            return self::setMsg('没有权限删除', false);
        }
        $status = self::$model::base_bool('delete', [], $id); // 删除数据
        return self::setMsg($status ? '删除成功' : '删除失败', $status);
    }

    /**
     * 管理员信息
     * @param int $id
     * @return bool
     */
    public static function message(int $id): bool
    {
        // TODO: Implement message() method.
        $check = self::$model::base_bool('check', [], $id); // 验证编号
        if(!$check){
            return self::setMsg('管理员不存在', false);
        }
        $select = self::$model::$message;
        $message = self::$model::base_array('message', [], $id, $select); // 查询管理员信息
        $status = count($message);
        return self::setMsg($status ? '管理员信息' : '获取失败', $status, $message);
    }

    /**
     * 获取当前管理员和上级管理员+
     * @param array $messageArr
     * @return bool
     */
    public static function handleAdminTotalIds(array $messageArr): bool
    {
        $adminIds = array_key_exists('admintotalids', $messageArr) ? $messageArr['admintotalids'] : '';
        if(strlen($adminIds)){ $adminIds = explode(',', $adminIds); }
        else{ return self::setMsg("管理员上级编号缓存失败", false); }
        try{
            $cacheAdminIds = [];
            $pRedis = new PRedisExtend('write');
            foreach ($adminIds as &$value){
                $redisValue = $pRedis::redis()->hget(self::$model::$redisHashName.$value, self::$model::$redisHashKeyParentIdsSelect);
                if(is_null($redisValue)){
                    $cacheAdminIds[] = $value;
                }
            }
            $result = true;
            if(count($cacheAdminIds)){
                foreach ($cacheAdminIds as &$adminId){
                    $parentIds = [];
                    $parentIds = self::adminTotalIds($adminId, $parentIds);
                    if(count($parentIds)){
                        $pRedis = new PRedisExtend('write');
                        $result = $pRedis::redis()->hset(self::$model::$redisHashName.$adminId, self::$model::$redisHashKeyParentIdsSelect, json_encode($parentIds)) && $result;
                    }
                }
            }
            if($result){
                return self::setMsg("管理员上级编号缓存成功", true);
            }
            return self::setMsg("管理员上级编号缓存失败", false);
        }catch (\Exception $exception){
            // 缓存失败
            return self::setMsg($exception->getMessage(), false);
        }
    }

    /**
     * 重置当前管理员和上级管理员+
     * @param int $adminId
     * @param array $parentIds
     * @return array
     */
    public static function adminTotalIds(int  $adminId, array $parentIds): array
    {
        $newAdminId = $adminId;
        $adminTotalIds = self::$model::$adminParentIds;
        if(!count($adminTotalIds)){ // 所有管理员为空时
            self::$model::adminIdAndParentIdTotal(); // 获取所有管理员
            $adminTotalIds = self::$model::$adminParentIds;
        }
        foreach ($adminTotalIds as $id=>$parentId){
            if($adminId == $id){
                $parentIds[] = $adminId;
                $newAdminId = $parentId;
            }
        }
        if($newAdminId != $adminId && $newAdminId){
            return self::adminTotalIds($newAdminId, $parentIds);
        }
        return $parentIds;
    }

    /**
     * 判断管理员是否有操作的权限
     * @param int $id         被修改的管理员编号
     * @param int $adminId   当前登陆的管理员编号
     * @return bool
     */
    public static function checkAdminHandle(int $id, int $adminId): bool
    {
        try{
            $pRedis = new PRedisExtend('read');  // 连接redis
            $adminParentIds = $pRedis::redis()->hget(Admins::$redisHashName.$id, Admins::$redisHashKeyParentIdsSelect); // 获取缓存
            $adminParentIds = json_decode($adminParentIds, true); // 格式化缓存 可以操作的管理员编号
        }catch (\Exception $exception){
            $adminParentIds = []; // 可以操作的管理员编号
        }
        if(!in_array($adminId, $adminParentIds)){ return false; }
        return true;
    }
}