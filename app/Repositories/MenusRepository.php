<?php
/**
 * @author: cc_forever<1253705861@qq.com>
 * @day: 2020/7/21
 */

namespace App\Repositories;

use App\CcForever\extend\PRedisExtend;
use App\CcForever\interfaces\RepositoryInterface;
use App\CcForever\traits\RepositoryReturnMsgData;
use App\Menus;

/**
 * 菜单
 * Class MenusRepository
 * @package App\Repositories
 */
class MenusRepository implements RepositoryInterface
{
    use RepositoryReturnMsgData;

    public function __construct(Menus $model = null)
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
        self::$model = new Menus();
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
        $where['parent_id'] = array_key_exists('parent_id', $where) ? $where['parent_id'] : '';// 上级菜单是否存在
        if(array_key_exists('menu', $where)){// 菜单状态是否存在
            try{
                $where['menu'] = reduce_status($where['menu'], 1);
            }catch (\Exception $exception){
                $where['menu'] = '';
            }
        }else{
            $where['menu'] = '';
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
        $where['parent_id'] = array_key_exists('parent_id', $where) ? $where['parent_id'] : '';// 上级菜单是否存在
        if(array_key_exists('menu', $where)){// 菜单状态是否存在
            try{
                $where['menu'] = reduce_status($where['menu'], 1);
            }catch (\Exception $exception){
                $where['menu'] = '';
            }
        }else{
            $where['menu'] = '';
        }
        $count = self::$model::count($where);
        return self::setMsg('菜单总数', true, [$count]);
    }

    /**
     * 菜单添加
     * @param array $data
     * @return bool
     */
    public static function insert(array $data): bool
    {
        // TODO: Implement insert() method.
        $menu = [];
        $menu['name'] = array_key_exists('name', $data) ? $data['name'] : null;// 菜单名称
        $menu['parent_id'] = array_key_exists('parent_id', $data) ? $data['parent_id'] : null;// 菜单父级
        $menu['routes'] = array_key_exists('routes', $data) ? $data['routes'] : null;// 菜单路由
        $menu['page'] = array_key_exists('page', $data) ? $data['page'] : '';// 菜单页面
        $menu['icon'] = array_key_exists('icon', $data) ? $data['icon'] : '';// icon是否存在
        $menu['sort'] = array_key_exists('sort', $data) ? (int)$data['sort'] : 1;// 排序是否存在
        $menu['menu'] = array_key_exists('menu', $data) ? (int)$data['menu'] : 1;// 状态是否存在
        if(!check_null($menu['name'],$menu['parent_id'], $menu['routes'])){
            return self::setMsg('参数错误', false);
        }
        // 验证路由是否存在
        $equal = self::$model::base_array('equal', ['routes' => $menu['routes']], ['routes'], []);
        if(count($equal)){
            return self::setMsg('路由地址已存在', false);
        }
        $menu['is_del'] = 0;
        $menu['add_time'] = time();
        $status = self::$model::base_bool('insert', $menu, 0);
        return self::setMsg($status ? '添加成功' : '添加失败', $status);
    }

    /**
     * 菜单修改
     * @param array $data
     * @param int $id
     * @return bool
     */
    public static function update(array $data, int $id): bool
    {
        // TODO: Implement update() method.
        $check = self::$model::base_bool('check', [], $id); // 判断菜单是否存在
        if(!$check){ // 编号不存在
            return self::setMsg('菜单不存在', true);
        }
        $menu = [];
        $menu['name'] = array_key_exists('name', $data) ? $data['name'] : null;
        $menu['parent_id'] = array_key_exists('parent_id', $data) ? (int)$data['parent_id'] : null;
        $menu['routes'] = array_key_exists('routes', $data) ? $data['routes'] : null;
        $menu['page'] = array_key_exists('page', $data) ? $data['page'] : '';
        $menu['icon'] = array_key_exists('icon', $data) ? $data['icon'] : '';
        $menu['sort'] = array_key_exists('sort', $data) ? (int)$data['sort'] : 1;
        $menu['menu'] = array_key_exists('menu', $data) ? (int)$data['menu'] : 0;
        if(!check_null($menu['name'],$menu['parent_id'], $menu['routes'])){
            return self::setMsg('参数错误', false);
        }
        // 验证路由是否重复
        $equal = self::$model::base_array('equal', ['routes' => $menu['routes']], ['id', 'routes'], []);
        switch (count($equal)){
            case 0:
                break;
            case 1:
                if($equal[0]['id'] !== $id){
                    return self::setMsg('路由地址已存在', false);
                }
                break;
            default:
                return self::setMsg('路由地址已存在', false);
        }
        $message = self::$model::base_array('message', $id, array_keys($menu), []);
        if($message === $menu){ // 数据库的数据和修改的数据一致
            return self::setMsg('修改成功', true);
        }
        $status = self::$model::base_bool('update', $menu, $id); // 修改数据
        return self::setMsg($status ? '修改成功' : '修改失败', $status);
    }

    /**
     * 批量获取菜单路由
     * @param array $ids
     * @return array
     */
    public static function menusIdsRoutes(array $ids):array
    {
        // 获取菜单路由
        $order = []; // 排序方式
        $order['select'] = 'sort';
        $order['value'] = 'DESC';
        $menusIdsRoutes = self::$model::base_array('pluck', $ids, ['routes'], $order);
        return $menusIdsRoutes;
    }

    /**
     * 获取菜单按钮
     * @param int $adminId
     * @return bool
     */
    public static function button(int $adminId): bool
    {
        try{
            $pRedis = new PRedisExtend('read');// 获取redis实例
            // 实例化AdminsRepository类
            $adminsRepository = new AdminsRepository();
            // 获取管理员菜单按钮缓存
            $menusBottom = $pRedis::redis()->hget($adminsRepository::GetModel()::redisHashName().$adminId, $adminsRepository::GetModel()::redisHashKeyRuleMenusPages());
            if(is_null($menusBottom)){ return self::setMsg("权限不存在，请联系管理员", false); } // 缓存不存在时
            $menusBottom = json_decode($menusBottom, true); // 格式化缓存
            return self::setMsg("按钮列表", true, $menusBottom);
        }catch (\Exception $exception){// redis 没有开
            return self::menusButton($adminId);
        }
    }

    /**
     * 菜单按钮(后台左侧菜单)
     *
     * @param int $adminId
     * @return bool
     */
    public static function menusButton(int $adminId): bool
    {
        // 实例化AdminsRepository类
        $adminsRepository = new AdminsRepository();
        // 判断是否是超级管理员
        if(in_array($adminId, $adminsRepository::superAdministratorIds())){ // 是
            $order = []; // 排序方式
            $order['select'] = 'sort';
            $order['value'] = 'DESC';
            // 获取菜单列表信息
            $menusIds = self::$model::base_array('all', [], ['id'], $order);
            // 二维数组转为一维数组
            $menusIds = array_column($menusIds, 'id');
        }else{ // 否
            // 获取管理员规则编号
            $ruleId = $adminsRepository::GetModel()::base_string('select', $adminId, 'rule_id');
            // 规则编号不存在
            if(!strlen($ruleId)){ return self::setMsg('菜单不存在', false); }
            // 格式化规则变化
            $ruleId = (int)$ruleId;
            // 实例化RulesRepository类
            $rulesRepository = new RulesRepository();
            // 获取规则唯一值
            $unique = $rulesRepository::GetModel()::base_string('select', $ruleId, 'unique');
            // 规则唯一值不存在
            if(!strlen($unique)){ return self::setMsg('菜单不存在', false); }
            // 设置table为rules_menus表
            $rulesRepository::GetModel()::SetModelTable('rules_menus');
            // 获取规则菜单编号
            $menusIds = $rulesRepository::GetModel()::base_array('equal', ['unique' => $unique], ['menu_id'], []);
            // 二维数组转为一维数组
            $menusIds = array_column($menusIds, 'menu_id');
        }
        $order = []; // 排序方式
        $order['select'] = 'sort';
        $order['value'] = 'DESC';
        // 获取菜单列表信息
        $menusMessageList = self::$model::base_array('pluck', $menusIds, self::$model::GetMessage(), $order);
        $menusMessageBottomList = [];  // 菜单按钮列表
        foreach ($menusMessageList as $key=>$value){
            if($value['menu']){
                $menusMessageBottomList[] = $value; // 获取菜单按钮列表
            }
        }
        // 格式化菜单按钮
        $bottomList = self::formatMenus($menusMessageBottomList, 0);
        // 格式化菜单按钮总数
        $status = true;
        return self::setMsg($status ? '按钮列表' : '获取失败', $status, $bottomList);
    }

    /**
     * 格式化菜单按钮
     *
     * @param array $menusMessageList
     * @param int $parentId
     * @return array
     */
    private static function formatMenus(array $menusMessageList, int $parentId): array
    {
        /**
         *
         * $menusMessageList array  格式  二维数组
         * [
         *   [ "id" => 1, name" => "系统管理", parent_id" => 0, "page" => "/system", "icon" => "nested"]
         *   [ "id" => 2, name" => "管理员列表", parent_id" => 1, "page" => "/admins", "icon" => ""]
         * ]
         */
        $menusFormatList = [];
        foreach($menusMessageList as &$item){
            $data = [];
            if($item['parent_id'] == $parentId){
                $data['top'] = $item['parent_id'] === 0 ?? false;
                $data['page'] = $item['page'];
                $data['name'] = substr($item['page'], 1, strlen($item['page']));
                $data['meta']['title'] = $item['name'];
                $data['meta']['icon'] = $item['icon'];
                $data['children'] = self::formatMenus($menusMessageList,$item['id']);
                if(count($data['children']) || !$data['top']){
                    // 子菜单存储或者当前菜单不是顶级菜单
                    $menusFormatList[] = $data;
                }
            }
        }
        return $menusFormatList;
    }

    /**
     * 所有菜单(当前管理员)
     *
     * @param int $adminId
     * @param int $ruleId
     * @return bool
     */
    public static function menus(int $adminId, int $ruleId): bool
    {
        // 判断是否是超级管理员 是 返回所有菜单 否 获取当前管理员对应的权限编号 根据权限编号获取菜单编号， 获取对应的菜单数据
        $adminsRepository = new AdminsRepository(); // 实例化AdminsRepository类
        $superAdministratorIds = $adminsRepository::superAdministratorIds();// 获取超级管理员编号
        $menusIds = []; // 菜单编号
        $order = []; // 菜单排序方式
        $order['select'] = 'sort'; // 排序字段
        $order['value'] = 'DESC'; // 排序方式 DESC 降序 ASC 升序
        if(!in_array($adminId, $superAdministratorIds)) {// 不是超级管理员
            $rulesRepository = new RulesRepository(); // 实例化RulesRepository类
            $rulesRepositoryModel = $rulesRepository::GetModel(); // 获取RulesModel
            $check = $rulesRepositoryModel::base_bool('check', [], $ruleId); // 验证编号
            if(!$check){ // 规则编号不存在
                return self::setMsg('权限不足', false);
            }
            $unique = $rulesRepositoryModel::base_string('select', $ruleId, 'unique'); // 查询规则信息
            $menus = $rulesRepositoryModel::menus($unique); // 获取管理员对应的菜单
            $status = (bool)count($menus); // 转为bool值
            if(!$status){ // 没有菜单
                return self::setMsg('获取失败', $status, []);
            }
            // 获取菜单对应的编号
            foreach ($menus as $key=>&$menu){
                $menusIds[] = $menu['mid'];
            }
            // 获取当前管理员菜单列表信息
            $menusList = self::$model::base_array('pluck', $menusIds, ['id', 'parent_id', 'name'], $order);
            $status = (bool)count($menusList);
            return self::setMsg($status ? '菜单列表' : '获取失败', $status, $menusList);
        }
        // 获取超级管理员的菜单列表信息
        $menusList = self::$model::base_array('all', $menusIds, ['id', 'parent_id', 'name'], $order);
        $status = (bool)count($menusList);
        return self::setMsg($status ? '菜单列表' : '获取失败', $status, $menusList);
    }

    /**
     * 数据库所有菜单
     *
     * @return array
     */
    public static function menusTotalList(): array
    {
        $order = [];
        $order['select'] = 'id';
        $order['value'] = 'DESC';
        return self::$model::base_array('all', [], ['id as mid', 'name as mname', 'parent_id'], $order);
    }
}