<?php
/**
 * @author: cc_forever<1253705861@qq.com>
 * @day: 2020/8/3
 */
namespace App\Repositories;

use App\CcForever\interfaces\RepositoryInterface;
use App\CcForever\traits\RepositoryReturnMsgData;
use App\Tags;

/**
 * 标签
 *
 * Class TagsRepository
 * @package App\Repositories
 */
class TagsRepository implements RepositoryInterface
{
    use RepositoryReturnMsgData;

    public function __construct(Tags $model = null)
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
        self::$model = new Tags();
    }

    /**
     * 标签列表
     *
     * @param array $where
     * @param int $page
     * @param int $limit
     * @return bool
     */
    public static function lst(array $where, int $page, int $limit): bool
    {
        // TODO: Implement lst() method.
        $where['status'] = array_key_exists('status', $where) && !is_null($where['status']) ? (int)$where['status'] : '';// 标签状态是否存在
        $offset = page_to_offset($page, $limit); // 获取起始值
        $list = self::$model::lst($where, $offset, $limit);// 标签列表
        return self::setMsg('标签列表', true, $list);
    }

    /**
     * 标签总数
     *
     * @param array $where
     * @return bool
     */
    public static function count(array $where): bool
    {
        // TODO: Implement count() method.
        $where['status'] = array_key_exists('status', $where) && !is_null($where['status']) ? (int)$where['status'] : '';// 标签状态是否存在
        $count = self::$model::count($where);// 标签总数
        return self::setMsg('标签总数', true, [$count]);
    }

    /**
     * 标签添加
     *
     * @param array $data
     * @return bool
     */
    public static function insert(array $data): bool
    {
        // TODO: Implement insert() method.
        $tags = [];
        $tags['name'] = array_key_exists('name', $data) ? $data['name'] : null;// 标签名称
        $tags['status'] = array_key_exists('status', $data) ? (int)$data['status'] : 1;// 标签状态
        if(is_null($tags['name'])){
            return self::setMsg('参数错误', false);
        }
        $tags['is_del'] = 0;
        $tags['add_time'] = time();
        $status = self::$model::base_bool('insert', $tags, 0);
        return self::setMsg($status ? '添加成功' : '添加失败', $status);
    }

    /**
     * 标签修改
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
        $tags = [];
        $tags['name'] = array_key_exists('name', $data) ? $data['name'] : null;// 标签名称
        $tags['status'] = array_key_exists('status', $data) ? (int)$data['status'] : 1;// 标签状态
        if(is_null($tags['name'])){
            return self::setMsg('参数错误', false);
        }
        $equal = self::$model::base_array('equal', ['name'=>$tags['name']], self::$model::GetMessage(), []);
        switch (count($equal)){
            case 0:
                break;
            case 1:
                if($equal[0]['id'] !== $id){
                    return self::setMsg('标签名称已存在', false);
                }
                break;
            default:
                return self::setMsg('标签名称已存在', false);
        }
        $message = self::$model::base_array('message', $id, array_keys($tags), []);
        if($message === $tags){ // 数据库的数据和修改的数据一致
            return self::setMsg('修改成功', true);
        }
        $status = self::$model::base_bool('update', $tags, $id); // 修改数据
        return self::setMsg($status ? '修改成功' : '修改失败', $status);
    }
}