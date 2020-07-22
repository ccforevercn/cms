<?php
/**
 * @author: cc_forever<1253705861@qq.com>
 * @day: 2020/7/21
 */

namespace App;

use App\CcForever\interfaces\ModelInterface;
use App\CcForever\model\BaseModel;

/**
 * 菜单Model
 * Class Menus
 * @package App
 */
class Menus extends BaseModel implements ModelInterface
{
    protected $primaryKey = 'id'; // 表主键

    protected $table = 'menus'; // 表名称

    protected static $alias; // 表别名

    protected static $select = ['id', 'name', 'parent_id', 'routes', 'page', 'icon', 'menu', 'add_time', 'sort', 'is_del']; // 表所有字段

    protected static $message = ['id', 'name', 'parent_id', 'routes', 'page', 'icon', 'menu', 'add_time', 'sort'];// 基本信息

    /**
     * 设置表别名
     * @param string $alias
     */
    public static function setAlias(string $alias): void
    {
        self::$alias = strlen($alias) ? $alias.'.' : '';
    }

    /**
     *  编号查询 唯一索引
     * @param $query
     * @param int $id
     * @return mixed
     */
    public static function scopeId($query, int $id)
    {
        return $query->where(self::$alias.'id', $id);
    }

    /**
     * 路由地址查询 唯一索引
     * @param $query
     * @param string $routes
     * @return mixed
     */
    public static function scopeRoutes($query, string $routes)
    {
        return $query->where(self::$alias.'routes', $routes);
    }

    /**
     * 上级菜单查询 普通索引
     * @param $query
     * @param int $parentId
     * @return mixed
     */
    public static function scopeParentId($query, int $parentId)
    {
        return $query->where(self::$alias.'parent_id', $parentId);
    }

    /**
     * 菜单状态查询 普通索引
     * @param $query
     * @param int $menu
     * @return mixed
     */
    public static function scopeMenu($query, int $menu)
    {
        return $query->where(self::$alias.'menu', $menu);
    }

    /**
     * 菜单假删除查询 普通索引
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
        $query = strlen($where['parent_id']) ? self::parentId((int)$where['parent_id']) : $query;
        $query = strlen($where['menu']) ? self::menu((int)$where['menu']) : $query;
        return $query;
    }

    /**
     * 列表
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
        $model = $model->offset($offset);
        $model = $model->limit($limit);
        $list = $model->get();
        $list = is_null($list) ? [] : $list->toArray();
        return $list;
    }

    /**
     * 列表查询总数
     * @param array $where
     * @return int
     */
    public static function count(array $where): int
    {
        // TODO: Implement count() method.
        return self::listWhere($where)->isDel(0)->count();
    }

    /**
     * 添加
     * @param array $data
     * @return bool
     */
    public static function add(array $data): bool
    {
        // TODO: Implement add() method.
        try{
            return self::insert($data);
        }catch (\Exception $exception){
            return false;
        }
    }

    /**
     * 修改
     * @param array $data
     * @param int $id
     * @return bool
     */
    public static function modify(array $data, int $id): bool
    {
        // TODO: Implement modify() method.
        try{
            $count = self::id($id)->where($data)->count();
            if($count){ return true; }
            $update = self::id($id)->update($data);
            return (bool)$update;
        }catch (\Exception $exception){
            return false;
        }
    }

    /**
     * 假删除
     * @param int $id
     * @return bool
     */
    public static function recycle(int $id): bool
    {
        // TODO: Implement recycle() method.
        $update = self::id($id)->update(['is_del' => 1]);
        return (bool)$update;
    }

    /**
     * 查询
     * @param int $id
     * @return array
     */
    public static function message(int $id): array
    {
        // TODO: Implement message() method.
        return self::id($id)->isDel(0)->select(self::$message)->first()->toArray();
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

    /**
     * 查询字段值
     * @param int $id
     * @param string $select
     * @return string
     */
    public static function select(int $id, string $select): string
    {
        // TODO: Implement select() method.
        if(!in_array($select, self::$select)){
            // 字段不存在
            return false;
        };
        return self::id($id)->isDel(0)->value($select);
    }

    /**
     * 验证路由地址
     * @param string $routes
     * @return array
     */
    public static function checkRoutes(string $routes): array
    {
        $routesListIds = self::routes($routes)->isDel(0)->select('id')->get();
        return is_null($routesListIds) ? [] : $routesListIds->toArray();
    }

}