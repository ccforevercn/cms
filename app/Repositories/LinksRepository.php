<?php
/**
 * @author: cc_forever<1253705861@qq.com>
 * @day: 2020/8/14
 */

namespace App\Repositories;

use App\CcForever\interfaces\RepositoryInterface;
use App\CcForever\traits\RepositoryReturnMsgData;
use App\Links;

/**
 * 友情链接
 *
 * Class LinksRepository
 * @package App\Repositories
 */
class LinksRepository implements RepositoryInterface
{
    use RepositoryReturnMsgData;

    public function __construct(Links $model = null)
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
        self::$model = new Links();
    }

    /**
     * 友情链接列表
     *
     * @param array $where
     * @param int $page
     * @param int $limit
     * @return bool
     */
    public static function lst(array $where, int $page, int $limit): bool
    {
        // TODO: Implement lst() method.
        // 是否传递权重
        $where['follow'] = array_key_exists('follow', $where) && !is_null($where['follow']) ? (int)$where['follow'] : '';
        $offset = page_to_offset($page, $limit); // 获取起始值
        $list = self::$model::lst($where, $offset, $limit);//友情链接列表
        return self::setMsg('友情链接列表', true, $list);
    }

    /**
     * 友情链接总数
     *
     * @param array $where
     * @return bool
     */
    public static function count(array $where): bool
    {
        // TODO: Implement count() method.
        // 是否传递权重
        $where['follow'] = array_key_exists('follow', $where) && !is_null($where['follow']) ? (int)$where['follow'] : '';
        $count = self::$model::count($where);//友情链接总数
        return self::setMsg('友情链接总数', true, [$count]);
    }

    /**
     * 友情链接添加
     *
     * @param array $data
     * @return bool
     */
    public static function insert(array $data): bool
    {
        // TODO: Implement insert() method.
        $links = [];
        $links['name'] = array_key_exists('name', $data) ? $data['name'] : null;// 友情链接名称
        $links['link'] = array_key_exists('link', $data) ? $data['link'] : null;// 友情链接
        $links['image'] = array_key_exists('image', $data)&& !is_null($data['image']) ? $data['image'] : '';// 友情链接图片
        $links['weight'] = array_key_exists('weight', $data) ? (int)$data['weight'] : 1;// 友情链接权重
        $links['follow'] = array_key_exists('follow', $data) ? (int)$data['follow'] : 1;// 是否传递权重 1是 0否
        // 友情链接名称、友情链接
        if(!check_null($links['name'], $links['link'])){
            return self::setMsg('参数错误', false);
        }
        // 验证链接
        if(strlen($links['link'])){
            $bool = (bool)filter_var($links['link'], FILTER_VALIDATE_URL);
            if(!$bool){
                return self::setMsg('友情链接地址错误', false);
            }
        }
        $links['is_del'] = 0;
        $links['add_time'] = time();
        $status = self::$model::base_bool('insert', $links, 0);
        return self::setMsg($status ? '添加成功' : '添加失败', $status);
    }

    /**
     * 友情链接修改
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
        $links = [];
        $links['name'] = array_key_exists('name', $data) ? $data['name'] : null;// 友情链接名称
        $links['link'] = array_key_exists('link', $data) ? $data['link'] : null;// 友情链接
        $links['image'] = array_key_exists('image', $data)&& !is_null($data['image']) ? $data['image'] : '';// 友情链接图片
        $links['weight'] = array_key_exists('weight', $data) ? (int)$data['weight'] : 1;// 友情链接权重
        $links['follow'] = array_key_exists('follow', $data) ? (int)$data['follow'] : 1;// 是否传递权重 1是 0否
        // 友情链接名称、友情链接
        if(!check_null($links['name'], $links['link'])){
            return self::setMsg('参数错误', false);
        }
        // 验证链接
        if(strlen($links['link'])){
            $bool = (bool)filter_var($links['link'], FILTER_VALIDATE_URL);
            if(!$bool){
                return self::setMsg('友情链接地址错误', false);
            }
        }
        $message = self::$model::base_array('message', $id, array_keys($links), []);
        if($message === $links){ // 数据库的数据和修改的数据一致
            return self::setMsg('修改成功', true);
        }
        $status = self::$model::base_bool('update', $links, $id); // 修改数据
        return self::setMsg($status ? '修改成功' : '修改失败', $status);
    }
}