<?php
/**
 * @author: cc_forever<1253705861@qq.com>
 * @day: 2020/8/17
 */
namespace App;

use App\CcForever\interfaces\ModelInterface;
use App\CcForever\model\BaseModel;
use App\CcForever\traits\ModelTraits;

/**
 * 合作伙伴Model
 *
 * Class Partners
 * @package App
 */
class Partners extends BaseModel implements ModelInterface
{
    use ModelTraits;


    protected $primaryKey = 'id'; // 主键

    protected $table = 'partners'; // 表名

    /**
     * 表名 ModelTraits 使用
     *
     * @var string
     */
    protected static $modelTable = 'partners';

    /**
     * 表所有字段
     *
     * @var array
     */
    private static $select = ['id', 'name', 'link', 'image', 'weight', 'follow', 'add_time', 'is_del'];

    /**
     * 基本信息
     *
     * @var array
     */
    private static $message = ['id', 'name', 'link', 'image', 'weight', 'follow', 'add_time'];

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
     * 是否权重传递 普通索引
     *
     * @param $query
     * @param int $follow
     * @return mixed
     */
    public static function scopeFollow($query, int $follow)
    {
        return $query->where(self::GetAlias().'follow', $follow);
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
        $query = strlen($where['follow']) ? self::follow($where['follow']) : $query; // 是否权重传递
        return $query;
    }

    /**
     * 友情链接列表
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
     * 友情链接总数
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
