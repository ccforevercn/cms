<?php
/**
 * @author: cc_forever<1253705861@qq.com>
 * @day: 2020/8/4
 */

namespace App\Repositories;

use App\CcForever\interfaces\RepositoryInterface;
use App\CcForever\traits\RepositoryReturnMsgData;
use App\ConfigCategory;

/**
 * 配置栏目
 *
 * Class ConfigCategoryRepository
 * @package App\Repositories
 */
class ConfigCategoryRepository implements RepositoryInterface
{
    use RepositoryReturnMsgData;

    public function __construct(ConfigCategory $model = null)
    {
        if(is_null($model)){
            self::loading();
        }else{
            self::$model = $model;
        }
    }

    /**
     * 手动加载Model
     */
    private static function loading(): void
    {
        self::$model = new ConfigCategory();
    }

    /**
     * 配置栏目列表
     *
     * @param array $where
     * @param int $page
     * @param int $limit
     * @return bool
     */
    public static function lst(array $where, int $page, int $limit): bool
    {
        // TODO: Implement lst() method.
        $offset = page_to_offset($page, $limit); // 获取起始值
        $list = self::$model::lst($where, $offset, $limit);// 配置栏目列表
        return self::setMsg('配置栏目列表', true, $list);
    }

    /**
     * 配置栏目总数
     *
     * @param array $where
     * @return bool
     */
    public static function count(array $where): bool
    {
        // TODO: Implement count() method.
        $count = self::$model::count($where);// 配置栏目总数
        return self::setMsg('配置栏目总数', true, [$count]);
    }

    /**
     * 配置分类添加
     *
     * @param array $data
     * @return bool
     */
    public static function insert(array $data): bool
    {
        // TODO: Implement insert() method.
        $configCategory = [];
        $configCategory['name'] = array_key_exists('name', $data) ? $data['name'] : null;// 配置分类名称
        $configCategory['description'] = array_key_exists('description', $data) ? $data['description'] : $configCategory['name'];// 配置分类描述
        if(is_null($configCategory['name'])){ // 配置分类名称是否为空
            return self::setMsg('参数错误', false);
        }
        $configCategory['is_del'] = 0;
        $configCategory['add_time'] = time();
        $status = self::$model::base_bool('insert', $configCategory, 0);
        return self::setMsg($status ? '添加成功' : '添加失败', $status);
    }

    /**
     * 配置分类修改
     *
     * @param array $data
     * @param int $id
     * @return bool
     */
    public static function update(array $data, int $id): bool
    {
        // TODO: Implement update() method.
        $check = self::$model::base_bool('check', [], $id); // 验证编号
        if(!$check){
            return self::setMsg('参数错误', false);
        }
        $configCategory = [];
        $configCategory['name'] = array_key_exists('name', $data) ? $data['name'] : null;// 配置分类名称
        $configCategory['description'] = array_key_exists('description', $data) ? $data['description'] : $configCategory['name'];// 配置分类描述
        if(is_null($configCategory['name'])){ // 配置分类名称是否为空
            return self::setMsg('参数错误', false);
        }
        $message = self::$model::base_array('message', $id, array_keys($configCategory), []);
        if($message === $configCategory){ // 数据库的数据和修改的数据一致
            return self::setMsg('修改成功', true);
        }
        $status = self::$model::base_bool('update', $configCategory, $id); // 修改数据
        return self::setMsg($status ? '修改成功' : '修改失败', $status);
    }
}