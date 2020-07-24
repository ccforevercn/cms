<?php
/**
 * @author: cc_forever<1253705861@qq.com>
 * @day: 2020/7/23
 */

namespace App\Repositories;

use App\Admins;
use App\CcForever\interfaces\RepositoryInterface;
use App\CcForever\traits\RepositoryReturnMsgData;
use App\Menus;
use App\Rules;

/**
 * 规则
 * Class RulesRepository
 * @package App\Repositories
 */
class RulesRepository implements RepositoryInterface
{
    use RepositoryReturnMsgData;

    public function __construct(Rules $model)
    {
        self::$model = $model;
    }

    /**
     * 规则列表
     * @param array $where
     * @param int $page
     * @param int $limit
     * @return bool
     */
    public static function lst(array $where, int $page, int $limit): bool
    {
        // TODO: Implement lst() method.
        $where['admin_id'] = array_key_exists('admin_id', $where) ? $where['admin_id'] : null;// 创建管理员
        if(!$where['admin_id']) $where['admin_id'] = null;
        $offset = page_to_offset($page, $limit); // 获取起始值
        $list = self::$model::lst($where, $offset, $limit); // 规则列表
        return self::setMsg('规则列表', true, $list);
    }

    /**
     * 规则总数
     * @param array $where
     * @return bool
     */
    public static function count(array $where): bool
    {
        // TODO: Implement count() method.
        $where['admin_id'] = array_key_exists('admin_id', $where) ? $where['admin_id'] : null;// 创建管理员
        if(!$where['admin_id']) $where['admin_id'] = null;
        $count = self::$model::count($where); // 规则列表
        return self::setMsg('规则总数', true, [$count]);
    }

    /**
     * 规则添加
     * @param array $data
     * @return bool
     */
    public static function insert(array $data): bool
    {
        // TODO: Implement insert() method.
        // 验证菜单编号是否存在
        $menuIdsStr = array_key_exists('menus_id', $data) ? $data['menus_id'] : null;
        if(is_null($menuIdsStr)){
            return self::setMsg('菜单不存在', false);
        }
        $menuIds = explode(',', $menuIdsStr);
        $count = Menus::checkIds($menuIds);
        if($count !== count($menuIds)){
            return self::setMsg('菜单不存在', false);
        }
        $unique = create_admin_password(create_millisecond(), $data['username'].$data['admin_id']);
        $time = time();
        $rule = []; // 规则数据
        $rule['name'] = array_key_exists('name', $data) ? $data['name'] : null;
        $rule['unique'] = $unique;
        $rule['admin_id'] = array_key_exists('admin_id', $data) ? $data['admin_id'] : null;
        $rule['add_time'] = $time;
        $rule['is_del'] = 0;
        $ruleMenu = []; // 规则菜单数据
        $ruleMenuCount = 0;
        foreach ($menuIds as $menuId){
            $ruleMenu[$ruleMenuCount]['unique'] = $unique;
            $ruleMenu[$ruleMenuCount]['menu_id'] = (int)$menuId;
            $ruleMenu[$ruleMenuCount]['add_time'] = $time;
            $ruleMenu[$ruleMenuCount]['clear_time'] = $time;
            $ruleMenu[$ruleMenuCount]['is_del'] = 0;
            $ruleMenuCount++;
        }
        self::$model::beginTransaction(); // 开启事务
        $ruleStatus = self::$model::base_bool('insert', $rule, 0); // 添加规则
        self::$model::$modelTable = 'rules_menus';
        $ruleMenusStatus = self::$model::base_bool('insert', $ruleMenu, 0); // 添加规规则菜单
        self::$model::$modelTable = 'rules';
        $bool = $ruleStatus && $ruleMenusStatus;
        self::$model::checkTransaction($bool); // 事务提交
        return self::setMsg($bool ? '添加成功' : '添加失败', $bool);
    }

    public static function update(array $data, int $id): bool
    {
        // TODO: Implement update() method.
        // 验证编号是否存在
        $check = self::$model::base_bool('check', [], $id);
        if(!$check){
            return self::setMsg('参数错误', false);
        }
        // 验证菜单编号是否存在
        $menuIdsStr = array_key_exists('menus_id', $data) ? $data['menus_id'] : null;
        if(is_null($menuIdsStr)){
            return self::setMsg('菜单不存在', false);
        }
        $menuIds = explode(',', $menuIdsStr);
        $count = Menus::checkIds($menuIds);
        if($count !== count($menuIds)){
            return self::setMsg('菜单不存在', false);
        }
        $rule = []; // 规则修改信息
        $rule['name'] = array_key_exists('name', $data) ? $data['name'] : null;
        $rule['name'] = array_key_exists('name', $data) ? $data['name'] : null;
        $adminId = array_key_exists('admin_id', $data) ? $data['admin_id'] : null;
        // 规则修改信息不完整
        if(is_null($rule['name']) || is_null($adminId)){
            return self::setMsg('参数错误', false);
        }
        // 验证当前管理员是否有修改权限
//        if(!in_array($adminId, Admins::$adminParentId)){
//            return self::setMsg('没有权限修改'.$rule['name'].'规则', false);
//        }
        dd($rule, $id, $menuIds);
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