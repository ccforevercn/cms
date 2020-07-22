<?php
/**
 * @author: cc_forever<1253705861@qq.com>
 * @day: 2020/7/21
 */

namespace App\Repositories;

use App\CcForever\interfaces\RepositoryInterface;
use App\CcForever\traits\RepositoryReturnMsgData;
use App\Menus;

/**
 * 菜单
 * Class MenusRepository
 * @package App\Repositories
 */
class MenusRepository implements RepositoryInterface
{
    use RepositoryReturnMsgData;

    public function __construct(Menus $model) {
        self::$model = $model;
    }

    /**
     * 菜单列表
     * @param array $where
     * @param int $page
     * @param int $limit
     * @return bool
     */
    public static function lst(array $where, int $page, int $limit): bool
    {
        // TODO: Implement lst() method.
        $where['parent_id'] = array_key_exists('parent_id', $where) ? $where['parent_id'] : '';// 上级菜单是否存在
        if(array_key_exists('menu', $where)){// 菜单状态是否存在
            try{
                $where['menu'] = reduce_status($where['menu'], 1);
            }catch (\Exception $exception){
                $where['menu'] = '';
            }
        }else{
            $where['menu'] = '';
        }
        $offset = page_to_offset($page, $limit); // 获取起始值
        $list = self::$model::lst($where, $offset, $limit);// 菜单列表
        return self::setMsg('菜单列表', true, $list);
    }

    /**
     * 菜单总数
     * @param array $where
     * @return bool
     */
    public static function count(array $where): bool
    {
        // TODO: Implement count() method.
        $where['parent_id'] = array_key_exists('parent_id', $where) ? $where['parent_id'] : '';// 上级菜单是否存在
        if(array_key_exists('menu', $where)){// 菜单状态是否存在
            try{
                $where['menu'] = reduce_status($where['menu'], 1);
            }catch (\Exception $exception){
                $where['menu'] = '';
            }
        }else{
            $where['menu'] = '';
        }
        $count = self::$model::count($where);
        return self::setMsg('菜单总数', true, [$count]);
    }

    /**
     * 菜单添加
     * @param array $data
     * @return bool
     */
    public static function add(array $data): bool
    {
        // TODO: Implement add() method.
        $data['icon'] = array_key_exists('icon', $data) ? $data['icon'] : '';// icon是否存在
        $data['sort'] = array_key_exists('sort', $data) ? (int)$data['sort'] : 1;// 排序是否存在
        $data['menu'] = array_key_exists('menu', $data) ? (int)$data['menu'] : 1;// 状态是否存在
        $data['is_del'] = 0;
        $data['add_time'] = time();
        $status = self::$model::add($data);
        return self::setMsg($status ? '添加成功' : '添加失败', $status);
    }

    /**
     * 菜单修改
     * @param array $data
     * @param int $id
     * @return bool
     */
    public static function modify(array $data, int $id): bool
    {
        // TODO: Implement modify() method.
        $routesListIds = self::$model::checkRoutes($data['routes']); // 获取相同路由地址数组
        $routesListIdsCount = count($routesListIds);// 获取相同路由地址条数
        switch ($routesListIdsCount){
            case 0: // 没有
                break;
            case 1:// 一条
                if($routesListIds[0]['id'] != $id){ // 修改的记录编号和查出来的不一样返回 false
                    return self::setMsg('路由地址已存在', false);
                }
                break;
            default:
                return self::setMsg('路由地址已存在', false);
        }
        $menu = [];
        $menu['name'] = array_key_exists('name', $data) ? $data['name'] : null;
        $menu['parent_id'] = array_key_exists('parent_id', $data) ? (int)$data['parent_id'] : null;
        $menu['routes'] = array_key_exists('routes', $data) ? $data['routes'] : null;
        $menu['page'] = array_key_exists('page', $data) ? $data['page'] : '';
        $menu['icon'] = array_key_exists('icon', $data) ? $data['icon'] : '';
        $menu['sort'] = array_key_exists('sort', $data) ? (int)$data['sort'] : 1;
        $menu['menu'] = array_key_exists('menu', $data) ? (int)$data['menu'] : 0;
        $status = self::$model::modify($menu, $id);
        return self::setMsg($status ? '修改成功' : '修改失败', $status);
    }

    /**
     * 菜单删除(假删除)
     * @param int $id
     * @return bool
     */
    public static function recycle(int $id): bool
    {
        // TODO: Implement recycle() method.
        $check = self::$model::checkId($id);
        if(!$check){// 编号不存在
            return self::setMsg('删除成功', true);
        }
        $status = self::$model::recycle($id);
        return self::setMsg($status ? '删除成功' : '删除失败', $status);
    }

    /**
     * 菜单信息
     * @param int $id
     * @return bool
     */
    public static function message(int $id): bool
    {
        // TODO: Implement message() method.
        $check = self::$model::checkId($id);
        if(!$check){// 编号不存在
            return self::setMsg('数据不存在', false);
        }
        $message = self::$model::message($id);
        return self::setMsg('菜单信息', true, $message);
    }


}