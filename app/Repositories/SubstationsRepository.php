<?php
/**
 * @author: cc_forever<1253705861@qq.com>
 * @day: 2020/9/7
 */

namespace App\Repositories;

use App\CcForever\extend\CachesExtend;
use App\CcForever\interfaces\RepositoryInterface;
use App\CcForever\traits\RepositoryReturnMsgData;
use App\Substations;

/**
 * 分站
 *
 * Class SubstationsRepository
 * @package App\Repositories
 */
class SubstationsRepository implements RepositoryInterface
{
    use RepositoryReturnMsgData;

    public function __construct(Substations $model = null)
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
        self::$model = new Substations();
    }

    /**
     * 分站列表
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
        $list = self::$model::lst($where, $offset, $limit);// 分站列表
        return self::setMsg('分站列表', true, $list);
    }

    /**
     * 分站总数
     *
     * @param array $where
     * @return bool
     */
    public static function count(array $where): bool
    {
        // TODO: Implement count() method.
        $count = self::$model::count($where);// 分站总数
        return self::setMsg('分站总数', true, [$count]);
    }

    /**
     * 分站添加
     *
     * @param array $data
     * @return bool
     */
    public static function insert(array $data): bool
    {
        // TODO: Implement insert() method.
        $substation = [];
        $substation['name'] = array_key_exists('name', $data) ? $data['name'] : null;// 分站名称
        $substation['unique'] = array_key_exists('unique', $data) ? $data['unique'] : null;// 分站唯一值
        if(!check_null($substation['name'], $substation['unique'])){
            return self::setMsg('参数错误', false);
        }
        // 验证分站唯一值是否重复
        $equal = self::$model::base_array('equal', ['unique'=>$substation['unique']], ['id'], []);
        if(count($equal)) {
            return self::setMsg('分站唯一值已存在', false);
        }
        $substation['is_del'] = 0;
        $substation['add_time'] = time();
        $status = self::$model::base_bool('insert', $substation, 0);
        return self::setMsg($status ? '添加成功' : '添加失败', $status);
    }

    /**
     * 分站修改
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
        $substation = [];
        $substation['name'] = array_key_exists('name', $data) ? $data['name'] : null;// 分站名称
        $substation['unique'] = array_key_exists('unique', $data) ? $data['unique'] : null;// 分站唯一值
        if(!check_null($substation['name'], $substation['unique'])){
            return self::setMsg('参数错误', false);
        }
        // 验证分站唯一值是否重复
        $equal = self::$model::base_array('equal', ['unique'=>$substation['unique']], ['id'], []);
        switch (count($equal)){
            case 0:
                break;
            case 1:
                if($equal[0]['id'] !== $id){
                    return self::setMsg('分站唯一值已存在', false);
                }
                break;
            default:
                return self::setMsg('分站唯一值已存在', false);
        }
        $message = self::$model::base_array('message', $id, array_keys($substation), []);
        if($message === $substation){ // 数据库的数据和修改的数据一致
            return self::setMsg('修改成功', true);
        }
        $status = self::$model::base_bool('update', $substation, $id); // 修改数据
        return self::setMsg($status ? '修改成功' : '修改失败', $status);
    }

    /**
     * 分站缓存
     *
     * @param int $id
     * @return bool
     * @throws \Throwable
     */
    public static function cache(int $id): bool
    {
        // 验证编号
        $check = self::$model::base_bool('check', [], $id);
        if(!$check){
            return self::setMsg('参数错误', false);
        }
        // 获取分站名称和唯一值
        $substation = self::$model::base_array('message', $id, ['name', 'unique'], []);
        $urlPrefix = '/'.$substation['unique'].'/'; // 地址前缀
        $sourcePathPrefix = 'pc/'; // 源文件前缀
        // 分站设置
        CachesExtend::substation($substation['name'], $substation['unique'].'/');
        // 缓存首页
        $page = CachesExtend::index($urlPrefix, $sourcePathPrefix);
        // 缓存栏目
        $page = array_merge($page, CachesExtend::columns(0, $urlPrefix, $sourcePathPrefix));
        // 缓存信息
        $page = array_merge($page, CachesExtend::message(0, $urlPrefix, $sourcePathPrefix));
        $status = (bool)count($page);
        return self::setMsg($status ? '缓存成功' : '缓存失败', $status, $page);
    }
}