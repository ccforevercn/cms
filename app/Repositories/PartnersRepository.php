<?php
/**
 * @author: cc_forever<1253705861@qq.com>
 * @day: 2020/8/17
 */

namespace App\Repositories;
use App\CcForever\interfaces\RepositoryInterface;
use App\CcForever\traits\RepositoryReturnMsgData;
use App\Partners;

/**
 * 合作伙伴
 *
 * Class PartnersRepository
 * @package App\Repositories
 */
class PartnersRepository implements RepositoryInterface
{
    use RepositoryReturnMsgData;

    public function __construct(Partners $model = null)
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
        self::$model = new Partners();
    }

    /**
     * 合作伙伴列表
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
        $list = self::$model::lst($where, $offset, $limit);//合作伙伴列表
        return self::setMsg('合作伙伴列表', true, $list);
    }

    /**
     * 合作伙伴总数
     *
     * @param array $where
     * @return bool
     */
    public static function count(array $where): bool
    {
        // TODO: Implement count() method.
        // 是否传递权重
        $where['follow'] = array_key_exists('follow', $where) && !is_null($where['follow']) ? (int)$where['follow'] : '';
        $count = self::$model::count($where);//合作伙伴总数
        return self::setMsg('合作伙伴总数', true, [$count]);
    }

    /**
     * 合作伙伴添加
     *
     * @param array $data
     * @return bool
     */
    public static function insert(array $data): bool
    {
        // TODO: Implement insert() method.
        $partners = [];
        $partners['name'] = array_key_exists('name', $data) ? $data['name'] : null;// 名称
        $partners['link'] = array_key_exists('link', $data) ? $data['link'] : null;// 链接
        $partners['image'] = array_key_exists('image', $data)&& !is_null($data['image']) ? $data['image'] : '';// 图片
        $partners['weight'] = array_key_exists('weight', $data) ? (int)$data['weight'] : 1;// 权重
        $partners['follow'] = array_key_exists('follow', $data) ? (int)$data['follow'] : 1;// 是否传递权重 1是 0否
        // 名称、链接
        if(!check_null($partners['name'], $partners['link'])){
            return self::setMsg('参数错误', false);
        }
        // 验证链接
        if(strlen($partners['link'])){
            $bool = (bool)filter_var($partners['link'], FILTER_VALIDATE_URL);
            if(!$bool){
                return self::setMsg('合作伙伴地址错误', false);
            }
        }
        $partners['is_del'] = 0;
        $partners['add_time'] = time();
        $status = self::$model::base_bool('insert', $partners, 0);
        return self::setMsg($status ? '添加成功' : '添加失败', $status);
    }

    /**
     * 合作伙伴修改
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
        $partners = [];
        $partners['name'] = array_key_exists('name', $data) ? $data['name'] : null;// 名称
        $partners['link'] = array_key_exists('link', $data) ? $data['link'] : null;// 链接
        $partners['image'] = array_key_exists('image', $data)&& !is_null($data['image']) ? $data['image'] : '';// 图片
        $partners['weight'] = array_key_exists('weight', $data) ? (int)$data['weight'] : 1;// 权重
        $partners['follow'] = array_key_exists('follow', $data) ? (int)$data['follow'] : 1;// 是否传递权重 1是 0否
        // 名称、链接
        if(!check_null($partners['name'], $partners['link'])){
            return self::setMsg('参数错误', false);
        }
        // 验证链接
        if(strlen($partners['link'])){
            $bool = (bool)filter_var($partners['link'], FILTER_VALIDATE_URL);
            if(!$bool){
                return self::setMsg('合作伙伴地址错误', false);
            }
        }
        $message = self::$model::base_array('message', $id, array_keys($partners), []);
        if($message === $partners){ // 数据库的数据和修改的数据一致
            return self::setMsg('修改成功', true);
        }
        $status = self::$model::base_bool('update', $partners, $id); // 修改数据
        return self::setMsg($status ? '修改成功' : '修改失败', $status);
    }

    /**
     * 合作伙伴
     *
     * @return array
     */
    public static function partners(): array
    {
        $order = [];
        $order['select'] = 'weight';
        $order['value'] = 'ASC';
        return self::$model::base_array('all', [], ['name', 'link', 'image', 'follow'], $order);
    }
}