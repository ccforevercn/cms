<?php
/**
 * @author: cc_forever<1253705861@qq.com>
 * @day: 2020/7/23
 */

namespace App;

use App\CcForever\interfaces\ModelInterface;
use App\CcForever\model\BaseModel;
use Illuminate\Support\Facades\DB;

/**
 * 规则Model
 * Class Rules
 * @package App
 */
class Rules extends BaseModel implements ModelInterface
{

    protected $primaryKey = 'id'; // 表主键

    protected $table = 'rules'; // 表名称

    protected static $alias; // 表别名

    protected static $select = ['id', 'name', 'menu_id', 'admin_id', 'add_time', 'is_del']; // 表所有字段

    protected static $message = ['id', 'name', 'menu_id', 'admin_id', 'add_time', 'sort'];// 基本信息

    /**
     * 规则编号查询 唯一索引
     * @param $query
     * @param int $id
     * @return mixed
     */
    public static function scopeId($query, int $id)
    {
        return $query->where('id', $id);
    }

    /**
     * 管理员编号查询 普通索引
     * @param $query
     * @param int $adminId
     * @return mixed
     */
    public static function scopeAdminId($query, int $adminId)
    {
        return $query->where('admin_id', $adminId);
    }

    /**
     * 规则假删除查询 普通索引
     * @param $query
     * @param int $isDel
     * @return mixed
     */
    public static function scopeIsDel($query, int $isDel)
    {
        return $query->where(self::$alias.'is_del', $isDel);
    }

    /**
     * 查询条件
     * @param $query
     * @param array $where
     * @return mixed
     */
    public static function scopeListWhere($query, array $where)
    {
        $query = is_null($where['admin_id']) ? $query : self::adminId((int)$where['admin_id']);
        return $query;
    }

    /**
     * 设置表别名
     * @param string $alias
     */
    public static function setAlias(string $alias): void
    {
        // TODO: Implement setAlias() method.
        self::$alias = strlen($alias) ? $alias.'.' : '';
    }

    public static function lst(array $where, int $offset, int $limit): array
    {
        // TODO: Implement lst() method.
        $alias = 'r'; // 当前表别名
        $admins = 'a';// 管理员表别名
//        $jsonMenusSql = DB::raw('find_in_set('.$prefix.$menus.'.id,'.$prefix.$alias.'.menu_id)');
//        $select = [$alias.'.add_time', $alias.'.admin_id', $alias.'.id', $alias.'.menu_id', $alias.'.name', $admins.'.real_name as admin_name', DB::raw('group_concat('.$prefix.$menus.'.name order by '.$prefix.$menus.'.id SEPARATOR \'、\') as menu_name')];
        // 查询的字段
        $select = [$alias.'.add_time', $alias.'.admin_id', $alias.'.id', $alias.'.name', $admins.'.real_name as admin_name'];
        self::setAlias($alias); // 设置表别名
        $model = new self;
        $model = $model->from('rules as '.$alias);
//        $model = $model->leftJoin('menus as '.$menus, function ($join) use($jsonMenusSql){ $join->whereRaw($jsonMenusSql); });
        $model = $model->leftJoin('admins as '.$admins, $alias.'.admin_id', '=', $admins.'.id');
        $model = $model->listWhere($where);
        $model = $model->isDel(0);
        $model = $model->select($select);
        $model = $model->offset($offset);
        $model = $model->limit($limit);
        $list = $model->get();
        self::setAlias(''); // 清空表别名
        $list = is_null($list) ? [] : $list->toArray(); // 转为数组
        return $list;
    }

    public static function count(array $where): int
    {
        // TODO: Implement count() method.
        return self::listWhere($where)->isDel(0)->count();
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

    public static function message(int $id): array
    {
        // TODO: Implement message() method.
    }

    /**
     * 验证编号
     * @param int $id
     * @return bool
     */
    public static function checkId(int $id): bool
    {
        // TODO: Implement checkId() method.
        $count = self::id($id)->isDel(0)->count();
        return (bool)$count;
    }

    public static function select(int $id, string $select): string
    {
        // TODO: Implement select() method.
    }
}
