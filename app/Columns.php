<?php

namespace App;

use App\CcForever\interfaces\ModelInterface;
use App\CcForever\model\BaseModel;
use App\CcForever\traits\ModelTraits;

/**
 * Class Columns
 * @package App
 */
class Columns extends BaseModel implements ModelInterface
{
    use ModelTraits;

    protected $primaryKey = 'id'; // 主键

    protected $table = 'columns'; // 表名

    /**
     * 表名 ModelTraits 使用
     *
     * @var string
     */
    protected static $modelTable = 'columns';

    /**
     * 表所有字段
     *
     * @var array
     */
    private static $select = ['id', 'name', 'name_alias', 'parent_id', 'image', 'banner_image', 'description', 'weight', 'sort', 'navigation', 'render', 'page', 'add_time', 'is_del'];

    /**
     * 基本信息
     *
     * @var array
     */
    private static $message = ['id', 'name', 'name_alias', 'parent_id', 'image', 'banner_image', 'description', 'weight', 'sort', 'navigation', 'render', 'page', 'add_time'];

    /**
     * 编号查询 唯一索引
     *
     * @param $query
     * @param int $id
     * @return mixed
     */
    public static function scopeId($query, int $id)
    {
        return $query->where(self::GetAlias().'id', $id);
    }

    /**
     * 上级栏目查询 普通索引
     *
     * @param $query
     * @param int $parentId
     * @return mixed
     */
    public static function scopeParentId($query, int $parentId)
    {
        return $query->where(self::GetAlias().'parent_id', $parentId);
    }

    /**
     * 导航状态 普通索引
     *
     * @param $query
     * @param int $navigation
     * @return mixed
     */
    public static function scopeNavigation($query, int $navigation)
    {
        return $query->where(self::GetAlias().'navigation', $navigation);
    }

    /**
     * 菜单假删除查询 普通索引
     *
     * @param $query
     * @param int $isDel
     * @return mixed
     */
    public static function scopeIsDel($query, int $isDel)
    {
        return $query->where(self::GetAlias().'is_del', $isDel);
    }

    /**
     * 查询条件
     *
     * @param $query
     * @param array $where
     * @return mixed
     */
    public static function scopeListWhere($query, array $where)
    {
        $query = strlen($where['parent_id']) ? self::parentId($where['parent_id']) : $query;
        return $query;
    }

    /**
     * 列表
     *
     * @param array $where
     * @param int $offset
     * @param int $limit
     * @return array
     */
    public static function lst(array $where, int $offset, int $limit): array
    {
        // TODO: Implement lst() method.
        $model = new self;
        $model = $model->listWhere($where);
        $model = $model->isDel(0);
        $model = $model->select(self::GetMessage());
        $model = $model->offset($offset);
        $model = $model->limit($limit);
        $list = $model->get();
        $list = is_null($list) ? [] : $list->toArray();
        return $list;
    }

    /**
     * 列表总数
     * @param array $where
     * @return int
     */
    public static function count(array $where): int
    {
        // TODO: Implement count() method.
        return self::listWhere($where)->isDel(0)->count();
    }
}
