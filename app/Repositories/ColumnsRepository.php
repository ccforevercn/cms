<?php
/**
 * @author: cc_forever<1253705861@qq.com>
 * @day: 2020/7/31
 */

namespace App\Repositories;
use App\CcForever\interfaces\RepositoryInterface;
use App\CcForever\traits\RepositoryReturnMsgData;
use App\Columns;

/**
 * 栏目
 *
 * Class ColumnsRepository
 * @package App\Repositories
 */
class ColumnsRepository implements RepositoryInterface
{
    use RepositoryReturnMsgData;

    public function __construct(Columns $model = null) {
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
        self::$model = new Columns();
    }

    public static function GetModel(): object
    {
        // TODO: Implement GetModel() method.
        return self::$model;
    }

    /**
     * 栏目列表
     * @param array $where
     * @param int $page
     * @param int $limit
     * @return bool
     */
    public static function lst(array $where, int $page, int $limit): bool
    {
        // TODO: Implement lst() method.
        $where['parent_id'] = array_key_exists('parent_id', $where) ? $where['parent_id'] : '';// 上级栏目是否存在
        $offset = page_to_offset($page, $limit); // 获取起始值
        $list = self::$model::lst($where, $offset, $limit);// 菜单列表
        return self::setMsg('栏目列表', true, $list);

    }

    /**
     * 栏目总数
     *
     * @param array $where
     * @return bool
     */
    public static function count(array $where): bool
    {
        // TODO: Implement count() method.
        $where['parent_id'] = array_key_exists('parent_id', $where) ? $where['parent_id'] : '';// 上级栏目是否存在
        $count = self::$model::count($where);
        return self::setMsg('菜单总数', true, [$count]);
    }

    public static function insert(array $data): bool
    {
        // TODO: Implement insert() method.
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