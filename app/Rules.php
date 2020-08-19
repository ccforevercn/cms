<?php
/**
 * @author: cc_forever<1253705861@qq.com>
 * @day: 2020/7/23
 */

namespace App;

use App\CcForever\interfaces\ModelInterface;
use App\CcForever\model\BaseModel;
use App\CcForever\traits\ModelTraits;
use Illuminate\Support\Facades\DB;

/**
 * 规则Model
 * Class Rules
 * @package App
 */
class Rules extends BaseModel implements ModelInterface
{
    use ModelTraits;

    protected $primaryKey = 'id'; // 表主键

    protected $table = 'rules'; // 表名称

    /**
     * 表名称 ModelTraits 使用
     *
     * @var string
     */
    protected static $modelTable = 'rules';

    /**
     * 表所有字段
     *
     * @var array
     */
    private static $select = ['id', 'name', 'unique', 'admin_id', 'add_time', 'is_del'];

    /**
     * 基本信息
     *
     * @var array
     */
    private static $message = ['id', 'name', 'unique', 'admin_id', 'add_time'];

    /**
     * 规则编号查询 唯一索引
     * @param $query
     * @param int $id
     * @return mixed
     */
    public static function scopeId($query, int $id)
    {
        return $query->where(self::GetAlias().'id', $id);
    }

    /**
     * 管理员编号查询 普通索引
     *
     * @param $query
     * @param array $adminId
     * @return mixed
     */
    public static function scopeAdminId($query, array $adminId)
    {
        return $query->whereIn(self::GetAlias().'admin_id', $adminId);
    }

    /**
     * 规则假删除查询 普通索引
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
     * @param $query
     * @param array $where
     * @return mixed
     */
    public static function scopeListWhere($query, array $where)
    {
        $query = count($where['admin_id']) ? self::adminId($where['admin_id']) : $query;
        return $query;
    }


    /**
     * 规则列表
     * @param array $where
     * @param int $offset
     * @param int $limit
     * @return array
     */
    public static function lst(array $where, int $offset, int $limit): array
    {
        // TODO: Implement lst() method.
        $select = [self::GetAlias().'add_time', self::GetAlias().'admin_id', self::GetAlias().'id', self::GetAlias().'name', Admins::GetAlias().'real_name as admin_name'];  // 查询的字段
        $model = new self;
        $model = $model->listWhere($where);
        $model = $model->leftJoin('admins', self::GetAlias().'admin_id', '=', Admins::GetAlias().'id');
        $model = $model->isDel(0);
        $model = $model->select($select);
        $model = $model->offset($offset);
        $model = $model->limit($limit);
        $list = $model->get();
        return is_null($list) ? [] : $list->toArray();  // 转为数组
    }

    /**
     * 规则总数
     * @param array $where
     * @return int
     */
    public static function count(array $where): int
    {
        // TODO: Implement count() method.
        return self::listWhere($where)->isDel(0)->count();
    }


    /**
     * 规则菜单
     * @param string $unique
     * @return array
     */
    public static function menus(string $unique): array
    {
        $menus = DB::table('rules_menus')->where('unique', $unique)->leftJoin('menus', 'rules_menus.menu_id', '=', 'menus.id')->select('menus.id as mid', 'menus.name as mname', 'menus.parent_id as parent_id')->orderBy('menus.id', 'DESC')->get();
        $menus = is_null($menus) ? [] : $menus->toArray();
        foreach ($menus as $key=>$menu){
            $menus[$key] = (array)$menu;
        }
        return $menus;
    }

    /**
     * 规则列表信息
     *
     * @param array $adminIds
     * @return array
     */
    public static function rules(array $adminIds): array
    {
        $model = new self;
        $model = $model->listWhere(['admin_id' => $adminIds]);
        $model = $model->isDel(0);
        $model = $model->select('name', 'id');
        $list = $model->get();
        return is_null($list) ? [] : $list->toArray();  // 转为数组
    }
}
