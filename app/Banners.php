<?php
/**
 * @author: cc_forever<1253705861@qq.com>
 * @day: 2020/8/5
 */
namespace App;

use App\CcForever\interfaces\ModelInterface;
use App\CcForever\model\BaseModel;
use App\CcForever\traits\ModelTraits;

/**
 * 轮播图Model
 *
 * Class Banners
 * @package App
 */
class Banners extends BaseModel implements ModelInterface
{
    use ModelTraits;

    protected $primaryKey = 'id'; // 主键

    protected $table = 'banners'; // 表名

    /**
     * 表名 ModelTraits 使用
     *
     * @var string
     */
    protected static $modelTable = 'banners';

    /**
     * 表所有字段
     *
     * @var array
     */
    private static $select = ['id', 'name', 'link', 'image', 'weight', 'add_time', 'type', 'is_del'];

    /**
     * 基本信息
     *
     * @var array
     */
    private static $message = ['id', 'name', 'link', 'image', 'weight', 'add_time', 'type'];

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
     * 轮播图类型 普通索引
     *
     * @param $query
     * @param int $type
     * @return mixed
     */
    public static function scopeType($query, int $type)
    {
        return $query->where(self::GetAlias().'type', $type);
    }

    /**
     * 是否删除 普通索引
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
        $query = strlen($where['type']) ? self::type($where['type']) : $query; // 轮播图类型
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
     * 总数
     *
     * @param array $where
     * @return int
     */
    public static function count(array $where): int
    {
        // TODO: Implement count() method.
        return self::listWhere($where)->isDel(0)->count();
    }
}
