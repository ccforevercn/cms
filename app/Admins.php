<?php
/**
 * @author: cc_forever<1253705861@qq.com>
 * @day: 2020/7/20
 */

namespace App;

use App\CcForever\model\JWTModel;
use App\CcForever\traits\ModelTraits;

/**
 * 管理员Model
 * Class Admins
 * @package App
 */
class Admins extends  JWTModel
{
    use ModelTraits;

    /**
     * 表主键
     *
     * @var string
     */
    protected $primaryKey = 'id';

    /**
     * 表名称
     *
     * @var string
     */
    protected $table = 'admins';

    /**
     * 表名称 ModelTraits 使用
     *
     * @var string
     */
    public static $modelTable = 'admins';

    /**
     * 表名称 + .
     *
     * @var string
     */
    public static $modelTableJoin = 'admins.';

    /**
     * 不自动更新 created_at 和 updated_at
     *
     * @var bool
     */
    public $timestamps = false;

    /**
     * 登陆规则
     *
     * @var string
     */
    public $role = 'admin';

    /**
     * 表所有字段
     *
     * @var array
     */
    protected static $select = ['id', 'username', 'password', 'real_name', 'status', 'found', 'parent_id', 'rule_id', 'add_time', 'add_ip', 'last_ip', 'last_time', 'login_count', 'is_del'];

    /**
     * 基本信息
     *
     * @var array
     */
    public static $message = ['id', 'username', 'real_name', 'status', 'found', 'parent_id', 'rule_id', 'add_time', 'add_ip', 'last_ip', 'last_time', 'login_count'];

    /**
     * 当前管理员的上级+
     * @var array
     */
    public static $adminParentIds = [];

    /**
     * admin表中的数组在redis数据库 hash表中的name
     *
     * @var string
     */
    public static $redisHashName = 'admins_number_';

    /**
     * 当前管理员的上级+
     *
     * @var string
     */
    public static $redisHashKeyParentIdsSelect = 'parent_ids_select';

    /**
     * 当管理员可以访问的路由
     *
     * @var string
     */
    public static $redisHashKeyRuleMenusRoutes = 'rule_menus_routes';

    /**
     * 当前管理员可以打开的页面
     *
     * @var string
     */
    public static $redisHashKeyRuleMenusPages = 'rule_menus_pages';

    /**
     * 超级管理员编号 所有接口都可以访问
     *
     * @var array
     */
    private static $superAdministratorIds = [1];

    /**
     * 不需要验证的路由
     *
     * @var array
     */
    private static $noMenusRoute = ['/menus/button'];

    /**
     * 管理员编号 唯一索引
     * @param $query
     * @param int $id
     * @return mixed
     */
    public static function scopeId($query, int $id)
    {
        return $query->where(self::$modelTableJoin.'id', $id);
    }

    /**
     * 管理员账号 唯一索引
     * @param $query
     * @param string $username
     * @return mixed
     */
    public static function scopeUsername($query, string $username)
    {
        return $query->where(self::$modelTableJoin.'username', $username);
    }

    /**
     * 上级管理员查询 普通索引
     * @param $query
     * @param int $parentId
     * @return mixed
     */
    public static function scopeParentId($query, int $parentId)
    {
        return $query->where(self::$modelTableJoin.'parentId', $parentId);
    }

    /**
     * 管理员假删除查询 普通索引
     * @param $query
     * @param int $isDel
     * @return mixed
     */
    public static function scopeIsDel($query, int $isDel)
    {
        return $query->where(self::$modelTableJoin.'is_del', $isDel);
    }

    /**
     * 查询条件
     * @param $query
     * @param array $where
     * @return mixed
     */
    public static function scopeListWhere($query, array $where)
    {
        $query = strlen($where['parent_id']) ? self::parentId((int)$where['parent_id']) : $query;
        $query = strlen($where['username']) ? self::username($where['username']) : $query;
        return $query;
    }

    /**
     * 管理员列表
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
        $model = $model->select(self::$message);
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
     * 登陆
     * @param int $id
     * @param int $count
     * @return bool
     */
    public static function login(int $id, int $count): bool
    {
        $result = self::id($id)->update([
            'login_count' => $count,
            'last_time' => time(),
            'last_ip' => app('request')->ip()
        ]);
        return $result === 1;
    }

    /**
     * 获取所有管理员
     */
    public static function adminIdAndParentIdTotal(): void
    {
        self::$adminParentIds = self::isDel(0)->pluck('parent_id', 'id');
    }

    /**
     * 获取登陆规则
     *
     * @return string
     */
    public function loginRole(): string
    {
        return $this->role;
    }

    /**
     * 超级管理员编号
     *
     * @return array
     */
    public static function superAdministratorIds(): array
    {
        return self::$superAdministratorIds;
    }

    /**
     * 不需要验证的路由
     *
     * @return array
     */
    public static function noMenusRoute(): array
    {
        return self::$noMenusRoute;
    }
}