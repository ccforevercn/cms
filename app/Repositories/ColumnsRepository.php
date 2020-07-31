<?php
/**
 * @author: cc_forever<1253705861@qq.com>
 * @day: 2020/7/31
 */

namespace App\Repositories;
use App\CcForever\interfaces\RepositoryInterface;
use App\CcForever\traits\RepositoryReturnMsgData;
use App\Columns;

/**
 * 栏目
 *
 * Class ColumnsRepository
 * @package App\Repositories
 */
class ColumnsRepository implements RepositoryInterface
{
    use RepositoryReturnMsgData;

    public function __construct(Columns $model = null) {
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
        self::$model = new Columns();
    }

    public static function GetModel(): object
    {
        // TODO: Implement GetModel() method.
        return self::$model;
    }

    /**
     * 栏目列表
     * @param array $where
     * @param int $page
     * @param int $limit
     * @return bool
     */
    public static function lst(array $where, int $page, int $limit): bool
    {
        // TODO: Implement lst() method.
        $where['parent_id'] = array_key_exists('parent_id', $where) ? $where['parent_id'] : '';// 上级栏目是否存在
        $offset = page_to_offset($page, $limit); // 获取起始值
        $list = self::$model::lst($where, $offset, $limit);// 菜单列表
        return self::setMsg('栏目列表', true, $list);

    }

    /**
     * 栏目总数
     *
     * @param array $where
     * @return bool
     */
    public static function count(array $where): bool
    {
        // TODO: Implement count() method.
        $where['parent_id'] = array_key_exists('parent_id', $where) ? $where['parent_id'] : '';// 上级栏目是否存在
        $count = self::$model::count($where);
        return self::setMsg('栏目总数', true, [$count]);
    }

    /**
     * 栏目添加
     *
     * @param array $data
     * @return bool
     */
    public static function insert(array $data): bool
    {
        // TODO: Implement insert() method.
        $columns = [];
        $columns['name'] = array_key_exists('name', $data) ? $data['name'] : null;// 栏目名称
        $columns['name_alias'] = array_key_exists('name_alias', $data) ? $data['name_alias'] : null;// 栏目别名
        $columns['parent_id'] = array_key_exists('parent_id', $data) ? (int)$data['parent_id'] : null;// 栏目父级
        $columns['image'] = array_key_exists('image', $data) ? $data['image'] : '';// 栏目图片
        $columns['banner_image'] = array_key_exists('banner_image', $data) ? $data['banner_image'] : '';// 栏目轮播
        $columns['description'] = array_key_exists('description', $data) ? $data['description'] : $columns['name'];// 栏目描述
        $columns['weight'] = array_key_exists('weight', $data) ? (int)$data['weight'] : 1;// 栏目权重
        $columns['sort'] = array_key_exists('sort', $data) ? (int)$data['sort'] : 2;// 栏目排序
        $columns['navigation'] = array_key_exists('navigation', $data) ? (int)$data['navigation'] : 1;// 栏目导航状态
        $columns['render'] = array_key_exists('render', $data) ? (int)$data['render'] : 0;// 栏目渲染类型
        $columns['page'] = array_key_exists('page', $data) ? $data['page'] : null;// 栏目页面
        if(!check_null($columns['name'], $columns['name_alias'], $columns['parent_id'], $columns['page'])){
            return self::setMsg('参数错误', false);
        }
        $columns['is_del'] = 0;
        $columns['add_time'] = time();
        $status = self::$model::base_bool('insert', $columns, 0);
        return self::setMsg($status ? '添加成功' : '添加失败', $status);
    }

    /**
     * 栏目 修改
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
        $columns = [];
        $columns['name'] = array_key_exists('name', $data) ? $data['name'] : null;// 栏目名称
        $columns['name_alias'] = array_key_exists('name_alias', $data) ? $data['name_alias'] : null;// 栏目别名
        $columns['parent_id'] = array_key_exists('parent_id', $data) ? (int)$data['parent_id'] : null;// 栏目父级
        $columns['image'] = array_key_exists('image', $data) ? $data['image'] : '';// 栏目图片
        $columns['banner_image'] = array_key_exists('banner_image', $data) ? $data['banner_image'] : '';// 栏目轮播
        $columns['description'] = array_key_exists('description', $data) ? $data['description'] : $columns['name'];// 栏目描述
        $columns['weight'] = array_key_exists('weight', $data) ? (int)$data['weight'] : 1;// 栏目权重
        $columns['sort'] = array_key_exists('sort', $data) ? (int)$data['sort'] : 2;// 栏目排序
        $columns['navigation'] = array_key_exists('navigation', $data) ? (int)$data['navigation'] : 1;// 栏目导航状态
        $columns['render'] = array_key_exists('render', $data) ? (int)$data['render'] : 0;// 栏目渲染类型
        $columns['page'] = array_key_exists('page', $data) ? $data['page'] : null;// 栏目页面
        if(!check_null($columns['name'], $columns['name_alias'], $columns['parent_id'], $columns['page'])){
            return self::setMsg('参数错误', false);
        }
        $message = self::$model::base_array('message', [], $id, array_keys($columns));
        if($message === $columns){ // 数据库的数据和修改的数据一致
            return self::setMsg('修改成功', true);
        }
        $status = self::$model::base_bool('update', $columns, $id); // 修改数据
        return self::setMsg($status ? '修改成功' : '修改失败', $status);
    }

    /**
     * 栏目删除
     *
     * @param int $id
     * @return bool
     */
    public static function delete(int $id): bool
    {
        // TODO: Implement delete() method.
        $check = self::$model::base_bool('check', [], $id); // 验证编号
        if(!$check){
            return self::setMsg('已删除', true);
        }
        $status = self::$model::base_bool('delete', [], $id);
        return self::setMsg($status ? '删除成功' : '删除失败', $status);
    }

    /**
     * 栏目信息
     *
     * @param int $id
     * @return bool
     */
    public static function message(int $id): bool
    {
        // TODO: Implement message() method.
        $check = self::$model::base_bool('check', [], $id);
        if(!$check){// 编号不存在
            return self::setMsg('数据不存在', false);
        }
        $message = self::$model::base_array('message', [], $id, self::$model::GetMessage());
        return self::setMsg('菜单信息', true, $message);
    }
}