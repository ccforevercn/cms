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

    public function __construct(Menus $model = null) {
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
        self::$model = new Menus();
    }

    /**
     * 外部调用Model
     *
     * @return object
     */
    public static function GetModel(): object
    {
        // TODO: Implement GetModel() method.
        return self::$model;
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
        $routesListIds = self::$model::checkRoutes($data['routes']); // 获取相同路由地址数组
        $routesListIdsCount = count($routesListIds);// 获取相同路由地址条数
        switch ($routesListIdsCount){
            case 0: // 没有
                break;
            case 1:// 一条
                if($routesListIds[0]['id'] != $id){ // 修改的记录编号和查出来的不一样返回 false
                    return self::setMsg('路由地址已存在', false);
                }
                break;
            default:
                return self::setMsg('路由地址已存在', false);
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
        $message = self::$model::base_array('message', [], $id, array_keys($menu));
        if($message === $menu){ // 数据库的数据和修改的数据一致
            return self::setMsg('修改成功', true);
        }
        $status = self::$model::base_bool('update', $menu, $id); // 修改数据
        return self::setMsg($status ? '修改成功' : '修改失败', $status);
    }

    /**
     * 菜单删除
     * @param int $id
     * @return bool
     */
    public static function delete(int $id): bool
    {
        // TODO: Implement delete() method.
        $check = self::$model::base_bool('check', [], $id);
        if(!$check){// 编号不存在
            return self::setMsg('删除成功', true);
        }
        $status = self::$model::base_bool('delete', [], $id);
        return self::setMsg($status ? '删除成功' : '删除失败', $status);
    }

    /**
     * 菜单信息
     * @param int $id
     * @return bool
     */
    public static function message(int $id): bool
    {
        // TODO: Implement message() method.
        $check = self::$model::base_bool('check', [], $id);
        if(!$check){// 编号不存在
            return self::setMsg('数据不存在', false);
        }
        $message = self::$model::base_array('message', [], $id, self::$model::GetMessage());
        return self::setMsg('菜单信息', true, $message);
    }

    /**
     * 批量获取菜单路由
     * @param array $ids
     * @return array
     */
    public static function menusIdsRoutes(array $ids):array
    {
        // 获取菜单路由
        $menusIdsRoutes = self::$model::base_array('pluck', [], $ids, ['routes']);
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
            // 获取菜单列表信息
            $menusIds = self::$model::base_array('all', [], [], ['id']);
            // 二维数组转为一维数组
            $menusIds = array_column($menusIds, 'id');
        }else{ // 否
            // 获取管理员规则编号
            $ruleId = $adminsRepository::GetModel()::base_string('select', [], $adminId, 'rule_id');
            // 规则编号不存在
            if(!strlen($ruleId)){ return self::setMsg('菜单不存在', false); }
            // 格式化规则变化
            $ruleId = (int)$ruleId;
            // 实例化RulesRepository类
            $rulesRepository = new RulesRepository();
            // 获取规则唯一值
            $unique = $rulesRepository::GetModel()::base_string('select', [], $ruleId, 'unique');
            // 规则唯一值不存在
            if(!strlen($unique)){ return self::setMsg('菜单不存在', false); }
            // 设置table为rules_menus表
            $rulesRepository::GetModel()::SetModelTable('rules_menus');
            // 获取规则菜单编号
            $menusIds = $rulesRepository::GetModel()::base_array('equal', [], ['unique' => $unique], ['menu_id']);
            // 二维数组转为一维数组
            $menusIds = array_column($menusIds, 'menu_id');
        }
        // 获取菜单列表信息
        $menusMessageList = self::$model::base_array('pluck', [], $menusIds, self::$model::GetMessage());
        $menusMessageBottomList = [];  // 菜单按钮列表
        foreach ($menusMessageList as $key=>$value){
            if($value['menu']){
                $menusMessageBottomList[] = $value; // 获取菜单按钮列表
            }
        }
        // 格式化菜单按钮
        $bottomList = self::formatMenus($menusMessageBottomList, 0);
        // 格式化菜单按钮总数
        $status = count($bottomList);
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
                if($data['children'] == null){
                    $data['children'] = [];
                }
                $menusFormatList[] = $data;
            }
        }
        return $menusFormatList;
    }
}