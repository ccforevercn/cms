<?php
/**
 * @author: cc_forever<1253705861@qq.com>
 * @day: 2020/7/23
 */

namespace App\Repositories;

use App\CcForever\interfaces\RepositoryInterface;
use App\CcForever\traits\RepositoryReturnMsgData;
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
        $count = self::$model::count($where); // 规则列表
        return self::setMsg('规则总数', true, [$count]);
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