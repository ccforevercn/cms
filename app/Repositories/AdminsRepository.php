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
use Illuminate\Support\Facades\Hash;

/**
 * 管理员
 * Class AdminsRepository
 * @package App\Repositories
 */
class AdminsRepository implements RepositoryInterface
{
    use RepositoryReturnMsgData;

    public function __construct(Admins $model = null)
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
        $userInfo = self::$model::base_array('message', $id, self::$model::GetMessage(), []); // 管理员登陆信息
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
        self::subordinateIds($where['login_id']); // 获取当前管理员编号和下级管理员编号+
        $subordinateIds = self::returnData([]);
        $where['parent_id'] = array_key_exists('parent_id', $where) ? (int)$where['parent_id'] : 0;// 上级管理员是否存在
        $where['username'] = array_key_exists('username', $where) ? $where['username'] : '';// 管理员账号是否存在
        if($where['parent_id']){
            if(!in_array($where['parent_id'], $subordinateIds)){
                return self::setMsg('菜单列表', true, []);
            }
            $where['parent_id'] = [$where['parent_id']];
        }else{// 所有的下级管理员
            $where['parent_id'] = $subordinateIds;
        }
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
        self::subordinateIds($where['login_id']); // 获取当前管理员编号和下级管理员编号+
        $subordinateIds = self::returnData([]);
        $where['parent_id'] = array_key_exists('parent_id', $where) ? $where['parent_id'] : 0;// 上级管理员是否存在
        $where['username'] = array_key_exists('username', $where) ? $where['username'] : '';// 管理员账号是否存在
        if($where['parent_id']){
            if(!in_array($where['parent_id'], $subordinateIds)){
                return self::setMsg('菜单总数', true, [0]);
            }
            $where['parent_id'] = [$where['parent_id']];
        }else{// 所有的下级管理员
            $where['parent_id'] = $subordinateIds;
        }
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
        if(!check_null($admin['username'], $admin['password'], $admin['real_name'], $admin['parent_id'], $admin['status'], $admin['found'], $admin['rule_id'], $admin['email'])){
            return self::setMsg('参数错误', false);
        }
        $admin['password'] = Hash::make(create_admin_password($admin['password'])); // 加密管理员密码
        // 验证账号是否存在
        $equal = self::$model::base_array('equal', ['username' => $admin['username']], ['username'], []);
        if(count($equal)){
            return self::setMsg('账号已存在', false);
        }
        // 验证邮箱是否存在
        $equal = self::$model::base_array('equal', ['email' => $admin['email']], ['email'], []);
        if(count($equal)){
            return self::setMsg('邮箱已存在', false);
        }
        // 判断规则是否存在
        $rulesRepository = new RulesRepository();
        $rulesRepositoryModel = $rulesRepository::GetModel();
        $rulesCount = $rulesRepositoryModel::base_bool('check', [] , $admin['rule_id']);
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
        $admin['password'] = array_key_exists('password', $data) ? $data['password'] : null;
        $admin['real_name'] = array_key_exists('real_name', $data) ? $data['real_name'] : null;
        $admin['status'] = array_key_exists('status', $data) ? (int)$data['status'] : null;
        $admin['found'] = array_key_exists('found', $data) ? (int)$data['found'] : null;
        $admin['rule_id'] = array_key_exists('rule_id', $data) ? (int)$data['rule_id'] : null;
        $admin['email'] = array_key_exists('email', $data) ? $data['email'] : null;
        if(!check_null($admin['real_name'],$admin['status'], $admin['found'], $admin['rule_id'], $admin['email'])){
            return self::setMsg('参数错误', false);
        }
        if(check_null($admin['password'])){ // 管理员密码不为空时
            $passwordLen = strlen($admin['password']);
            if($passwordLen < 8 || $passwordLen > 18){
                return self::setMsg('密码至少是8个字符，最多18个字符', false);
            }
            $admin['password'] = Hash::make(create_admin_password($admin['password'])); // 管理员密码加密
        }else{ // 密码不存在时
            unset($admin['password']);
            // 当前数据库的信息和用户提交的信息是否一致
            $message = self::$model::base_array('message', $id, array_keys($admin), []);
            if($message === $admin){ // 数据库的数据和修改的数据一致
                return self::setMsg('修改成功', true);
            }
        }
        // 验证邮箱是否重复
        $equal = self::$model::base_array('equal', ['email' => $admin['email']], ['id', 'email'], []);
        switch (count($equal)){
            case 0:
                break;
            case 1:
                if($equal[0]['id'] !== $id){
                    return self::setMsg('邮箱已存在', false);
                }
                break;
            default:
                return self::setMsg('邮箱已存在', false);
        }
        // 判断当前管理员是否有修改管理员的权限
        $checkAdminHandleStatus = self::checkAdminHandle($id, $data['parent_id']);
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
     * 判断管理员是否有操作的权限
     * @param int $id         被修改的管理员编号
     * @param int $adminId   当前登陆的管理员编号
     * @return bool
     */
    public static function checkAdminHandle(int $id, int $adminId): bool
    {
        $adminParentIds = self::parentIds($id); // 获取当前管理员的编号和上级编号+
        if(!in_array($adminId, $adminParentIds)){ return false; }// 判断是否有权限
        return true;
    }

    /**
     * 获取当前管理员和上级管理员+
     *
     * @param int $id
     * @return array
     */
    private static function parentIds(int $id): array
    {
        try{
            $pRedis = new PRedisExtend('read');  // 连接redis
            $adminParentIds = $pRedis::redis()->hget(self::$model::redisHashName().$id, self::$model::redisHashKeyParentIdsSelect()); // 获取缓存
            if(is_null($adminParentIds)){ return self::setMsg("没有权限", false); } // 缓存不存在时
            $adminParentIds = json_decode($adminParentIds, true); // 格式化缓存
        }catch (\Exception $exception){// 未开启redis时
            $adminParentIds = self::adminParentIds($id, []);  // 可以操作的管理员编号
        }
        return $adminParentIds;
    }

    /**
     * 缓存当前管理员和上级管理员+
     * @param array $messageArr
     * @return bool
     */
    public static function adminParentIdsCache(array $messageArr): bool
    {
        $adminIds = array_key_exists('admintotalids', $messageArr) ? $messageArr['admintotalids'] : '';
        if(strlen($adminIds)){ $adminIds = explode(',', $adminIds); }
        else{ return self::setMsg("管理员上级编号缓存失败", false); }
        try{
            $cacheAdminIds = [];
            $pRedis = new PRedisExtend('read');
            foreach ($adminIds as &$value){
                $redisValue = $pRedis::redis()->hget(self::$model::redisHashName().$value, self::$model::redisHashKeyParentIdsSelect());
                if(is_null($redisValue)){
                    $cacheAdminIds[] = $value;
                }
            }
            $result = true;
            if(count($cacheAdminIds)){
                $pRedis = new PRedisExtend('write');
                foreach ($cacheAdminIds as &$adminId){
                    $parentIds = [];
                    $parentIds = self::adminParentIds($adminId, $parentIds);
                    if(count($parentIds)){
                        $result = $pRedis::redis()->hset(self::$model::redisHashName().$adminId, self::$model::redisHashKeyParentIdsSelect(), json_encode($parentIds)) && $result;
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
     * 当前管理员和上级管理员+
     * @param int $adminId
     * @param array $parentIds
     * @return array
     */
    private static function adminParentIds(int  $adminId, array $parentIds): array
    {
        $newAdminId = $adminId;
        $adminTotalIds = self::$model::adminTotalIds();
        if(!count($adminTotalIds)){ // 所有管理员为空时
            $order = []; // 排序方式
            $order['select'] = 'id';
            $order['value'] = 'ASC';
            self::$model::SetAdminTotalIds(self::$model::base_array('all', [], ['id', 'parent_id'], $order)); // 获取所有管理员
            $adminTotalIds = self::$model::adminTotalIds();
        }
        foreach ($adminTotalIds as $id=>$parentId){
            if($adminId == $id){
                $parentIds[] = $adminId;
                $newAdminId = $parentId;
            }
        }
        if($newAdminId != $adminId && $newAdminId){
            return self::adminParentIds($newAdminId, $parentIds);
        }
        return $parentIds;
    }

    /**
     * 获取当前管理员和下级管理员+
     *
     * @param int $id
     * @return array
     */
    public static function subordinateIds(int $id): bool
    {
        $subordinateIds = []; // 当前管理员和下级管理员+
        try{
            $pRedis = new PRedisExtend('read');  // 连接redis
            $adminSubordinateIds = $pRedis::redis()->hget(self::$model::redisHashName().$id, self::$model::redisHashKeySubordinateIdsSelect()); // 获取缓存
            if(is_null($adminSubordinateIds)){ return self::setMsg('权限不足', false, $subordinateIds); } // 缓存不存在时
            $subordinateIds = json_decode($adminSubordinateIds, true); // 格式化缓存
        }catch (\Exception $exception){  // 未开启redis时
            $subordinateIds = self::adminSubordinateIds([$id]);  // 当前管理员和下级管理员
        }
        return self::setMsg('当前管理员和下级管理员+', true, $subordinateIds);
    }

    /**
     * 缓存当前管理员和下级管理员+
     *
     * @param int $id
     * @return bool
     */
    public static function adminSubordinateIdsCache(int $id): bool
    {
        try{
            $pRedis = new PRedisExtend('read');
            $adminSubordinateIds = $pRedis::redis()->hget(self::$model::redisHashName().$id, self::$model::redisHashKeySubordinateIdsSelect());
            if(!is_null($adminSubordinateIds)){ return self::setMsg("管理员下级编号缓存成功", true); }
            $pRedis = new PRedisExtend('write');
            $subordinateIds = self::adminSubordinateIds([$id]);
            $result = $pRedis::redis()->hset(self::$model::redisHashName().$id, self::$model::redisHashKeySubordinateIdsSelect(), json_encode($subordinateIds));
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
     * 当前管理员和下级管理员+
     *
     * @param array $subordinateIdsNew
     * @return array
     */
    private static function adminSubordinateIds(array $subordinateIdsNew): array
    {
        $subordinateIds = $subordinateIdsNew;
        $adminTotalIds = self::$model::adminTotalIds();
        if(!count($adminTotalIds)){ // 所有管理员为空时
            $order = []; // 排序方式
            $order['select'] = 'id';
            $order['value'] = 'ASC';
            self::$model::SetAdminTotalIds(self::$model::base_array('all', [], ['id', 'parent_id'], $order)); // 获取所有管理员
            $adminTotalIds = self::$model::adminTotalIds();
        }
        foreach ($adminTotalIds as $id=>$parentId){
            if(in_array($parentId, $subordinateIdsNew)){
                $subordinateIdsNew[] = $id;
            }
        }
        $subordinateIdsNew = array_flip(array_flip($subordinateIdsNew));
        if(count($subordinateIdsNew) !== count($subordinateIds)){
            return self::adminSubordinateIds($subordinateIdsNew);
        }
        return array_merge($subordinateIdsNew, []);
    }

    /**
     * 获取登陆规则
     *
     * @return string
     */
    public static function loginRole(): string
    {
        return self::$model->loginRole();
    }

    /**
     * 超级管理员编号
     *
     * @return array
     */
    public static function superAdministratorIds(): array
    {
        return self::$model::superAdministratorIds();
    }

    /**
     * 不需要验证的路由
     *
     * @return array
     */
    public static function noMenusRoute(): array
    {
        return self::$model::noMenusRoute();
    }

    /**
     * 缓存管理员菜单路由
     *
     * @param int $id
     * @return bool
     */
    public static function adminRuleMenusRoutesCache(int $id): bool
    {
        try{
            $result = true;
            $pRedis = new PRedisExtend('read');
            $redisValue = $pRedis::redis()->hget(self::$model::redisHashName().$id, self::$model::redisHashKeyRuleMenusRoutes());
            if(!is_null($redisValue)){ return self::setMsg("管理员菜单路由缓存成功", true); }
            $pRedis = new PRedisExtend('write');
            $adminRuleMenusRoutes = self::adminRuleMenusRoutes($id);
            if(count($adminRuleMenusRoutes)){
                $result = $pRedis::redis()->hset(self::$model::redisHashName().$id, self::$model::redisHashKeyRuleMenusRoutes(), json_encode($adminRuleMenusRoutes));
            }
            if($result){
                return self::setMsg("管理员菜单路由缓存成功", true);
            }
            return self::setMsg("管理员菜单路由缓存失败", false);
        }catch (\Exception $exception){
            // 缓存失败
            return self::setMsg($exception->getMessage(), false);
        }
    }

    /**
     * 管理员菜单权限
     *
     * @param int $id
     * @return array
     */
    public static function adminRuleMenusRoutes(int $id): array
    {
        $ruleId = self::$model::base_string('select', $id, 'rule_id'); // 获取管理员规则编号
        if(strlen($ruleId)){ // 管理员信息存在
            $rulesRepository = new RulesRepository();// 实例化RulesRepository类
            $ruleId = (int)$ruleId;
            $rulesMenusStatus = $rulesRepository::menus($ruleId); // 获取规则菜单
            if($rulesMenusStatus){// 规则菜单存在
                $menus = $rulesRepository::returnData([]); // 规则菜单
                $menusIds = []; // 菜单编号
                foreach ($menus as $key=>$value){
                    $menusIds[] = $value['mid']; // 获取菜单编号
                }
                // 查询规则菜单对应的路由 routes
                $menusRepository = new MenusRepository(); // 实例化MenusRepository类
                $routesList = $menusRepository::menusIdsRoutes($menusIds);// 路由地址列表
                return $routesList;
            }
        }
        return [];
    }

    /**
     * 验证管理员权限
     *
     * @param int $id
     * @param string $routes
     * @return bool
     */
    public static function returnAdminRuleMenusRoutes(int $id, string $routes): bool
    {
        try{
            $pRedis = new PRedisExtend('read');// 获取redis实例
            // 获取管理员菜单路由缓存
            $adminRuleMenusRoutes = $pRedis::redis()->hget(self::$model::redisHashName().$id, self::$model::redisHashKeyRuleMenusRoutes());
            // 缓存不存在时
            if(is_null($adminRuleMenusRoutes)){ return self::setMsg("权限不存在，请联系管理员", false); }
            // 格式化缓存
            $adminRuleMenusRoutes = json_decode($adminRuleMenusRoutes, true);
            // 权限判断
            if(in_array($routes, $adminRuleMenusRoutes)){ return self::setMsg("可以访问", true); }
            else { return self::setMsg("权限不足", false); }
        }catch (\Exception $exception){// redis 没有开
            $adminRuleMenusRoutes = self::adminRuleMenusRoutes($id); // 获取管理员可以访问的菜单
            if(count($adminRuleMenusRoutes)){ // 菜单路由判断
                if(in_array($routes, $adminRuleMenusRoutes)){ return self::setMsg("可以访问", true); }
                else { return self::setMsg("权限不足", false); }
            }else{
                return self::setMsg('权限不足', false);
            }
        }
    }

    /**
     * 缓存管理员菜单按钮
     * @param int $id
     * @return bool
     */
    public static function adminMenusBottomCache(int $id): bool
    {
        try{
            $result = true;
            $pRedis = new PRedisExtend('read');
            $menusBottom = $pRedis::redis()->hget(self::$model::redisHashName().$id, self::$model::redisHashKeyRuleMenusPages());
            if(!is_null($menusBottom)){ return self::setMsg("管理员菜单按钮列表缓存成功", true); }
            $pRedis = new PRedisExtend('write');
            $menusRepository = new MenusRepository();
            $status = $menusRepository::menusButton($id);
            if($status){
                $menusBottom = $menusRepository::returnData([]);
                $result = $pRedis::redis()->hset(self::$model::redisHashName().$id, self::$model::redisHashKeyRuleMenusPages(), json_encode($menusBottom, JSON_UNESCAPED_UNICODE));
            }
            if($result){
                return self::setMsg("管理员菜单按钮列表缓存成功", true);
            }
            return self::setMsg("管理员菜单按钮列表缓存失败", false);
        }catch (\Exception $exception){
            // 缓存失败
            return self::setMsg($exception->getMessage(), false);
        }
    }
}