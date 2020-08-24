<?php
/**
 * @author: cc_forever<1253705861@qq.com>
 * @day: 2020/8/4
 */
namespace App;

use App\CcForever\interfaces\ModelInterface;
use App\CcForever\model\BaseModel;
use App\CcForever\traits\ModelTraits;

/**
 * 配置信息Model
 *
 * Class ConfigMessage
 * @package App
 */
class ConfigMessage extends BaseModel implements ModelInterface
{
    use ModelTraits;

    protected $primaryKey = 'id'; // 主键

    protected $table = 'config_message'; // 表名

    /**
     * 表名 ModelTraits 使用
     *
     * @var string
     */
    protected static $modelTable = 'config_message';

    /**
     * 表所有字段
     *
     * @var array
     */
    private static $select = ['id', 'name', 'description', 'select', 'type', 'type_value', 'value', 'category_id', 'add_time', 'is_del'];

    /**
     * 基本信息
     *
     * @var array
     */
    private static $message = ['id', 'name', 'description', 'select', 'type', 'type_value', 'value', 'category_id', 'add_time'];

    /**
     * 不可见配置信息
     *
     * @var array
     */
    private static $notViewableSelect = ['token'];

    /**
     * 静态配置名称
     *
     * @var array
     */
    private static $staticConfigName = ['label_prefix'];

    /**
     * 静态配置值
     *
     * @var array
     */
    private static $staticConfigValue = ['label_prefix' => 'ccforever.prefix.label'];

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
     * 栏目编号查询 普通索引
     *
     * @param $query
     * @param int $categoryId
     * @return mixed
     */
    public static function scopeCategoryId($query, int $categoryId)
    {
        return $query->where(self::GetAlias().'category_id', $categoryId);
    }

    /**
     * 唯一值查询 唯一索引
     *
     * @param $query
     * @param string $select
     * @return mixed
     */
    public static function scopeSelectC($query, string $select)
    {
        return $query->where(self::GetAlias().'select', $select);
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
        $query = strlen($where['category_id']) ? self::categoryId($where['category_id']) : $query; // 配置分类
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
     * 不可见配置信息
     *
     * @return array
     */
    public static function GetNotViewableSelect(): array
    {
        return self::$notViewableSelect;
    }

    /**
     * 静态配置名称
     *
     * @return array
     */
    public static function GetStaticConfigName(): array
    {
        return self::$staticConfigName;
    }

    /**
     * 静态配置值
     *
     * @param string $key
     * @return string
     */
    public static function GetStaticConfigValue(string $key): string
    {
        return self::$staticConfigValue[$key];
    }
}
