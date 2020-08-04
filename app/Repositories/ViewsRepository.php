<?php
/**
 * @author: cc_forever<1253705861@qq.com>
 * @day: 2020/8/4
 */

namespace App\Repositories;

use App\CcForever\interfaces\RepositoryInterface;
use App\CcForever\traits\RepositoryReturnMsgData;
use App\Views;

/**
 * 视图
 *
 * Class ViewsRepository
 * @package App\Repositories
 */
class ViewsRepository implements RepositoryInterface
{
    use RepositoryReturnMsgData;

    public function __construct(Views $model = null)
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
        self::$model = new Views();
    }

    /**
     * 视图列表
     *
     * @param array $where
     * @param int $page
     * @param int $limit
     * @return bool
     */
    public static function lst(array $where, int $page, int $limit): bool
    {
        // TODO: Implement lst() method.
        // 视图类型是否存在
        $where['type'] = array_key_exists('type', $where) && !is_null($where['type']) ? (int)$where['type'] : '';
        $offset = page_to_offset($page, $limit); // 获取起始值
        $list = self::$model::lst($where, $offset, $limit);// 视图列表
        return self::setMsg('视图列表', true, $list);
    }

    /**
     * 视图总数
     *
     * @param array $where
     * @return bool
     */
    public static function count(array $where): bool
    {
        // TODO: Implement count() method.
        // 视图类型是否存在
        $where['type'] = array_key_exists('type', $where) && !is_null($where['type']) ? (int)$where['type'] : '';
        $count = self::$model::count($where);// 视图总数
        return self::setMsg('视图总数', true, [$count]);
    }

    /**
     * 视图添加
     *
     * @param array $data
     * @return bool
     */
    public static function insert(array $data): bool
    {
        // TODO: Implement insert() method.
        $views = [];
        $views['name'] = array_key_exists('name', $data) ? $data['name'] : null;// 视图名称
        $views['path'] = array_key_exists('path', $data) ? $data['path'] : null;// 视图地址
        $views['type'] = array_key_exists('type', $data) ? (int)$data['type'] : 1;// 视图类型
        if(!check_null($views['name'], $views['path'])){ // 验证视图名称、地址是否为空
            return self::setMsg('参数错误', false);
        }
        // 验证视图地址是否已存在
        $equal = self::$model::base_array('equal', ['path' => $views['path']], ['path'], []);
        if(count($equal)){
            return self::setMsg('视图地址已存在', false);
        }
        $views['is_del'] = 0;
        $views['add_time'] = time();
        $status = self::$model::base_bool('insert', $views, 0);
        return self::setMsg($status ? '添加成功' : '添加失败', $status);
    }

    /**
     * 视图修改
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
        $views = [];
        $views['name'] = array_key_exists('name', $data) ? $data['name'] : null;// 视图名称
        $views['path'] = array_key_exists('path', $data) ? $data['path'] : null;// 视图地址
        $views['type'] = array_key_exists('type', $data) ? (int)$data['type'] : 1;// 视图类型
        if(!check_null($views['name'], $views['path'])){ // 验证视图名称、地址是否为空
            return self::setMsg('参数错误', false);
        }
        // 验证视图地址是否已存在
        $equal = self::$model::base_array('equal', ['path'=>$views['path']], ['id', 'path'], []);
        switch (count($equal)){
            case 0:
                break;
            case 1:
                if($equal[0]['id'] !== $id){
                    return self::setMsg('视图地址已存在', false);
                }
                break;
            default:
                return self::setMsg('视图地址已存在', false);
        }
        $message = self::$model::base_array('message', $id, array_keys($views), []);
        if($message === $views){ // 数据库的数据和修改的数据一致
            return self::setMsg('修改成功', true);
        }
        $status = self::$model::base_bool('update', $views, $id); // 修改数据
        return self::setMsg($status ? '修改成功' : '修改失败', $status);
    }
}