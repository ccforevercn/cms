<?php
/**
 * @author: cc_forever<1253705861@qq.com>
 * @day: 2020/8/7
 */

namespace App;

use App\CcForever\interfaces\ModelInterface;
use App\CcForever\model\BaseModel;
use App\CcForever\traits\ModelTraits;
use Illuminate\Support\Facades\DB;

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
    private static $select = ['id', 'customer', 'user', 'content', 'speak', 'see', 'add_time', 'is_del'];

    /**
     * 基本信息
     *
     * @var array
     */
    private static $message = ['id', 'customer', 'user', 'content', 'speak', 'see', 'add_time'];

    /**
     * 是否查看
     *
     * @var array
     */
    private static $see = [0, 1];  // 0  未查看 1 已查看

    /**
     * 修改是否查看的接口
     *
     * @var string
     */
    private static $seeApi = '/chats/see';


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
     * 客服名称 分组
     *
     * @param $query
     * @return mixed
     */
    public static function scopeCustomerGroupBy($query)
    {
        return $query->groupBy(self::GetAlias().'customer');
    }

    /**
     * 客服名称 去重
     *
     * @param $query
     * @return mixed
     */
    public static function scopeCustomerDistinct($query)
    {
        return $query->distinct(self::GetAlias().'customer');
    }

    /**
     * 用户名称 分组
     *
     * @param $query
     * @return mixed
     */
    public static function scopeUserGroupBy($query)
    {
        return $query->groupBy(self::GetAlias().'user');
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
     * 用户名称 去重
     *
     * @param $query
     * @return mixed
     */
    public static function scopeUserDistinct($query)
    {
        return $query->distinct(self::GetAlias().'user');
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
        return $query;
    }

    /**
     * 留言客服列表
     *
     * @param array $where
     * @param int $offset
     * @param int $limit
     * @return array
     */
    public static function lst(array $where, int $offset, int $limit): array
    {
        // TODO: Implement lst() method.
        $select = [DB::raw('count(distinct('.self::GetAlias(true, true).'.user)) as user_count'), DB::raw('(select real_name from '.Admins::GetAlias(true, true).' where username = '.self::GetAlias(true, true).'.customer) as admin_name'), DB::raw('(select id from '.Admins::GetAlias(true, true).' where username = '.self::GetAlias(true, true).'.customer) as admin_id'), 'customer'];
        $model = new self;
        $model = $model->listWhere($where);
        $model = $model->isDel(0);
        $model = $model->select($select);
        $model = $model->customerGroupBy();
        $model = $model->offset($offset);
        $model = $model->limit($limit);
        $list = $model->get();
        $list = is_null($list) ? [] : $list->toArray();
        return $list;
    }

    /**
     * 留言客服总数
     *
     * @param array $where
     * @return int
     */
    public static function count(array $where): int
    {
        // TODO: Implement count() method.
        return self::listWhere($where)->customerDistinct()->isDel(0)->count();
    }

    /**
     * 留言用户列表
     *
     * @param string $customer
     * @param int $offset
     * @param int $limit
     * @return array
     */
    public static function users(string $customer, int $offset, int $limit): array
    {
        $select = [DB::raw('count('.self::GetAlias(true, true).'.content) as content_count'), DB::raw('min('.self::GetAlias(true, true).'.add_time) as time'), 'user'];
        $model = new self;
        $model = $model->select($select);
        $model = $model->isDel(0);
        $model = $model->customer($customer);
        $model = $model->userGroupBy();
        $model = $model->orderBy(self::GetAlias().'add_time', 'DESC');
        $model = $model->offset($offset);
        $model = $model->limit($limit);
        $list = $model->get();
        $list = is_null($list) ? [] : $list->toArray();
        return $list;
    }

    /**
     * 留言用户总数
     *
     * @param string $customer
     * @return int
     */
    public static function usersCount(string $customer): int
    {
        return self::customer($customer)->userDistinct()->isDel(0)->count();
    }

    /**
     * 留言客服和用户对话列表
     *
     * @param string $customer
     * @param string $user
     * @param int $offset
     * @param int $limit
     * @return array
     */
    public static function chats(string $customer, string $user, int $offset, int $limit): array
    {
        $model = new self;
        $model = $model->select(self::GetMessage());
        $model = $model->isDel(0);
        $model = $model->customer($customer);
        $model = $model->orderBy(self::GetAlias().'add_time', 'DESC');
        $model = $model->user($user);
        $model = $model->offset($offset);
        $model = $model->limit($limit);
        $list = $model->get();
        $list = is_null($list) ? [] : $list->toArray();
        return $list;
    }

    /**
     * 留言客服和用户对话总数
     *
     * @param string $customer
     * @param string $user
     * @return int
     */
    public static function chatsCount(string $customer, string $user): int
    {
        return self::customer($customer)->user($user)->isDel(0)->count();
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

    /**
     * 获取是否查看的接口
     *
     * @return string
     */
    public static function GetSeeApi() :string
    {
        return self::$seeApi;
    }
}
