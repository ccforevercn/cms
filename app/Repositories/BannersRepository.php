<?php
/**
 * @author: cc_forever<1253705861@qq.com>
 * @day: 2020/8/5
 */
namespace App\Repositories;

use App\Banners;
use App\CcForever\interfaces\RepositoryInterface;
use App\CcForever\traits\RepositoryReturnMsgData;

/**
 * 轮播图
 *
 * Class BannersRepository
 * @package App\Repositories
 */
class BannersRepository implements RepositoryInterface
{
    use RepositoryReturnMsgData;

    public function __construct(Banners $model = null)
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
        self::$model = new Banners();
    }

    /**
     * 轮播图列表
     *
     * @param array $where
     * @param int $page
     * @param int $limit
     * @return bool
     */
    public static function lst(array $where, int $page, int $limit): bool
    {
        // TODO: Implement lst() method.
        // 轮播图类型
        $where['type'] = array_key_exists('type', $where) && !is_null($where['type']) ? (int)$where['type'] : '';
        $offset = page_to_offset($page, $limit); // 获取起始值
        $list = self::$model::lst($where, $offset, $limit);//轮播图列表
        return self::setMsg('轮播图列表', true, $list);
    }

    /**
     * 轮播图总数
     *
     * @param array $where
     * @return bool
     */
    public static function count(array $where): bool
    {
        // TODO: Implement count() method.
        $where['type'] = array_key_exists('type', $where) && !is_null($where['type']) ? (int)$where['type'] : '';
        $count = self::$model::count($where);//轮播图总数
        return self::setMsg('轮播图总数', true, [$count]);
    }

    /**
     * 轮播图添加
     *
     * @param array $data
     * @return bool
     */
    public static function insert(array $data): bool
    {
        // TODO: Implement insert() method.
        $banners = [];
        $banners['name'] = array_key_exists('name', $data) ? $data['name'] : null;// 轮播图名称
        $banners['link'] = array_key_exists('link', $data)&& !is_null($data['link']) ? $data['link'] : '';// 轮播图链接
        $banners['image'] = array_key_exists('image', $data) ? $data['image'] : null;// 轮播图图片
        $banners['weight'] = array_key_exists('weight', $data) ? (int)$data['weight'] : 1;// 轮播图权重
        $banners['type'] = array_key_exists('type', $data) ? (int)$data['type'] : null;// 轮播图类型
        // 轮播图名称、轮播图图片、轮播图类型
        if(!check_null($banners['name'], $banners['image'], $banners['type'])){
            return self::setMsg('参数错误', false);
        }
        // 验证链接
        if(strlen($banners['link'])){
            $bool = (bool)filter_var($banners['link'], FILTER_VALIDATE_URL);
            if(!$bool){
                return self::setMsg('轮播图链接地址错误', false);
            }
        }
        $banners['is_del'] = 0;
        $banners['add_time'] = time();
        $status = self::$model::base_bool('insert', $banners, 0);
        return self::setMsg($status ? '添加成功' : '添加失败', $status);
    }

    /**
     * 轮播图修改
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
        $banners = [];
        $banners['name'] = array_key_exists('name', $data) ? $data['name'] : null;// 轮播图名称
        $banners['link'] = array_key_exists('link', $data)&& !is_null($data['link']) ? $data['link'] : '';// 轮播图链接
        $banners['image'] = array_key_exists('image', $data) ? $data['image'] : null;// 轮播图图片
        $banners['weight'] = array_key_exists('weight', $data) ? (int)$data['weight'] : 1;// 轮播图权重
        $banners['type'] = array_key_exists('type', $data) ? (int)$data['type'] : null;// 轮播图类型
        // 轮播图名称、轮播图图片、轮播图类型
        if(!check_null($banners['name'], $banners['image'], $banners['type'])){
            return self::setMsg('参数错误', false);
        }
        // 验证链接
        if(strlen($banners['link'])){
            $bool = (bool)filter_var($banners['link'], FILTER_VALIDATE_URL);
            if(!$bool){
                return self::setMsg('轮播图链接地址错误', false);
            }
        }
        $message = self::$model::base_array('message', $id, array_keys($banners), []);
        if($message === $banners){ // 数据库的数据和修改的数据一致
            return self::setMsg('修改成功', true);
        }
        $status = self::$model::base_bool('update', $banners, $id); // 修改数据
        return self::setMsg($status ? '修改成功' : '修改失败', $status);
    }

    /**
     * 轮播图  $type 1 PC 2 WAP
     *
     * @param int $type
     * @return array
     */
    public static function banners(int $type): array
    {
        if(!in_array($type, self::$model::GetType())){ return []; }
        $where = [];
        $where['type'] = $type;
        $order = [];
        $order['select'] = 'weight';
        $order['value'] = 'ASC';
        return self::$model::base_array('equal', $where, ['name', 'image', 'link'], $order);
    }
}