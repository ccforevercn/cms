<?php
/**
 * @author: cc_forever<1253705861@qq.com>
 * @day: 2020/7/23
 */

namespace App\Repositories;

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
        $menuIds = explode(',', $data['menus_id']);
        $count = Menus::checkIds($menuIds);
        if($count !== count($menuIds)){
            return self::setMsg('菜单不存在', false);
        }
        $unique = create_admin_password(create_millisecond(), $data['username'].$data['admin_id']);
        $time = time();
        $ruleData = []; // 规则数据
        $ruleData['name'] = $data['name'];
        $ruleData['unique'] = $unique;
        $ruleData['admin_id'] = $data['admin_id'];
        $ruleData['add_time'] = $time;
        $ruleData['is_del'] = 0;
        $ruleMenuData = []; // 规则菜单数据
        $ruleMenuDataCount = 0;
        foreach ($menuIds as $menuId){
            $ruleMenuData[$ruleMenuDataCount]['unique'] = $unique;
            $ruleMenuData[$ruleMenuDataCount]['menu_id'] = (int)$menuId;
            $ruleMenuData[$ruleMenuDataCount]['add_time'] = $time;
            $ruleMenuData[$ruleMenuDataCount]['clear_time'] = $time;
            $ruleMenuData[$ruleMenuDataCount]['is_del'] = 0;
            $ruleMenuDataCount++;
        }
        self::$model::beginTransaction(); // 开启事务
        $ruleStatus = self::$model::base_bool('insert', $ruleData, 0); // 添加规则
        self::$model::$modelTable = 'rules_menus';
        $ruleMenusStatus = self::$model::base_bool('insert', $ruleMenuData, 0); // 添加规规则菜单
        self::$model::$modelTable = 'rules';
        $bool = $ruleStatus && $ruleMenusStatus;
        self::$model::checkTransaction($bool); // 事务提交
        return self::setMsg($bool ? '添加成功' : '添加失败', $bool);
    }

    public static function update(array $data, int $id): bool
    {
        // TODO: Implement update() method.
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