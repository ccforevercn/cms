<?php
/**
 * @author: cc_forever<1253705861@qq.com>
 * @day: 2020/8/7
 */

namespace App\Repositories;

use App\CcForever\interfaces\RepositoryInterface;
use App\CcForever\traits\RepositoryReturnMsgData;
use App\Chats;

/**
 * 留言
 *
 * Class ChatsRepository
 * @package App\Repositories
 */
class ChatsRepository implements RepositoryInterface
{
    use RepositoryReturnMsgData;

    public function __construct(Chats $model = null)
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
        self::$model = new Chats();
    }

    /**
     * 留言列表
     *
     * @param array $where
     * @param int $page
     * @param int $limit
     * @return bool
     */
    public static function lst(array $where, int $page, int $limit): bool
    {
        // TODO: Implement lst() method.
        $where['see'] = array_key_exists('see', $where) && !is_null($where['see']) ? (int)$where['see'] : '';
        if(strlen($where['see']) && !in_array($where['see'], self::$model::GetSee())){
            return self::setMsg('参数错误', false);
        }
        $offset = page_to_offset($page, $limit); // 获取起始值
        $list = self::$model::lst($where, $offset, $limit);//留言列表
        return self::setMsg('留言列表', true, $list);
    }

    /**
     * 留言总数
     *
     * @param array $where
     * @return bool
     */
    public static function count(array $where): bool
    {
        // TODO: Implement count() method.
        $where['see'] = array_key_exists('see', $where) && !is_null($where['see']) ? (int)$where['see'] : '';
        if(strlen($where['see']) && !in_array($where['see'], self::$model::GetSee())){
            return self::setMsg('参数错误', false);
        }
        $count = self::$model::count($where);//留言总数
        return self::setMsg('留言总数', true, [$count]);
    }

    /**
     * 留言添加
     *
     * @param array $data
     * @return bool
     */
    public static function insert(array $data): bool
    {
        // TODO: Implement insert() method.
        dd($data);
    }

    /**
     * 留言不支持修改
     *
     * @param array $data
     * @param int $id
     * @return bool
     */
    public static function update(array $data, int $id): bool
    {
        // TODO: Implement update() method.
        dd($data, $id);
    }

    public static function message(int $id): bool
    {
        // TODO: Implement message() method.
        dd($id);
    }

    /**
     * 留言删除
     *
     * @param int $id
     * @return bool
     */
    public static function delete(int $id): bool
    {
        // TODO: Implement delete() method.
        return self::setMsg('留言不能删除', false);
    }

}