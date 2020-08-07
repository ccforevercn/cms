<?php
/**
 * @author: cc_forever<1253705861@qq.com>
 * @day: 2020/8/7
 */

namespace App;

use App\CcForever\interfaces\ModelInterface;
use App\CcForever\model\BaseModel;
use App\CcForever\traits\ModelTraits;

/**
 * 留言Model
 *
 * Class Chats
 * @package App
 */
class Chats extends BaseModel implements ModelInterface
{
    use ModelTraits;

    protected $primaryKey = 'id'; // 主键

    protected $table = 'chats'; // 表名

    /**
     * 表名 ModelTraits 使用
     *
     * @var string
     */
    protected static $modelTable = 'chats';

    /**
     * 表所有字段
     *
     * @var array
     */
    private static $select = ['id', 'customer', 'user', 'content', 'see', 'add_time', 'is_del'];

    /**
     * 基本信息
     *
     * @var array
     */
    private static $message = ['id', 'customer', 'user', 'content', 'see', 'add_time'];

    /**
     * 是否查看
     *
     * @var array
     */
    private static $see = [0, 1];  // 0  未查看 1 已查看


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
     * 客服名称 普通索引
     *
     * @param $query
     * @param string $customer
     * @return mixed
     */
    public static function scopeCustomer($query, string $customer)
    {
        return $query->where(self::GetAlias().'customer', $customer);
    }

    /**
     * 用户名称 普通索引
     *
     * @param $query
     * @param string $user
     * @return mixed
     */
    public static function scopeUser($query, string $user)
    {
        return $query->where(self::GetAlias().'user', $user);
    }

    /**
     * 是否查看 普通索引
     *
     * @param $query
     * @param int $see
     * @return mixed
     */
    public static function scopeSee($query, int $see)
    {
        return $query->where(self::GetAlias().'see', $see);
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
        $query = strlen($where['see']) ? self::see($where['see']) : $query; // 留言是否查看
        return $query;
    }

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

    public static function count(array $where): int
    {
        // TODO: Implement count() method.
        return self::listWhere($where)->isDel(0)->count();
    }

    /**
     * 获取是否查看
     *
     * @return array
     */
    public static function GetSee(): array
    {
        return self::$see;
    }
}
