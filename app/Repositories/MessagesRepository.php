<?php
/**
 * @author: cc_forever<1253705861@qq.com>
 * @day: 2020/8/3
 */

namespace App\Repositories;
use App\CcForever\interfaces\RepositoryInterface;
use App\CcForever\traits\RepositoryReturnMsgData;
use App\Messages;

/**
 * 文章信息
 * Class MessagesRepository
 * @package App\Repositories
 */
class MessagesRepository implements RepositoryInterface
{
    use RepositoryReturnMsgData;

    public function __construct(Messages $model = null)
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
        self::$model = new Messages();
    }

    /**
     * 信息列表
     *
     * @param array $where
     * @param int $page
     * @param int $limit
     * @return bool
     */
    public static function lst(array $where, int $page, int $limit): bool
    {
        // TODO: Implement lst() method.
        $where['columns_id'] = array_key_exists('columns_id', $where) && !is_null($where['columns_id']) ? $where['columns_id'] : '';// 信息栏目是否存在
        $where['index'] = array_key_exists('index', $where) && !is_null($where['index']) ? $where['index'] : '';// 首页推荐
        $where['hot'] = array_key_exists('hot', $where) && !is_null($where['hot']) ? $where['hot'] : '';// 热门推荐
        $where['release'] = array_key_exists('release', $where) && !is_null($where['release']) ? $where['release'] : '';// 发布状态
        $offset = page_to_offset($page, $limit); // 获取起始值
        $list = self::$model::lst($where, $offset, $limit);// 信息列表
        return self::setMsg('信息列表', true, $list);
    }

    /**
     * 信息总数
     *
     * @param array $where
     * @return bool
     */
    public static function count(array $where): bool
    {
        // TODO: Implement count() method.
        $where['columns_id'] = array_key_exists('columns_id', $where) ? $where['columns_id'] : '';// 信息栏目是否存在
        $where['index'] = array_key_exists('index', $where) ? $where['index'] : '';// 首页推荐
        $where['hot'] = array_key_exists('hot', $where) ? $where['hot'] : '';// 热门推荐
        $where['release'] = array_key_exists('release', $where) ? $where['release'] : '';// 发布状态
        $count = self::$model::count($where);// 信息总数
        return self::setMsg('信息列表', true, [$count]);
    }

    /**
     * 信息添加
     *
     * @param array $data
     * @return bool
     */
    public static function insert(array $data): bool
    {
        // TODO: Implement insert() method.
        $messages = [];
        $messages['name'] = array_key_exists('name', $data) ? $data['name'] : null;// 文章名称
        $messages['columns_id'] = array_key_exists('columns_id', $data) ? (int)$data['columns_id'] : null;// 文章栏目
        $messages['image'] = array_key_exists('image', $data) ? $data['image'] : '';// 文章图片
        $messages['writer'] = array_key_exists('writer', $data) ? $data['writer'] : 'ccforever<1253705861@qq.com>"';// 文章作者
        $messages['click'] = array_key_exists('click', $data) ? (int)$data['click'] : 1;// 文章点击量
        $messages['weight'] = array_key_exists('weight', $data) ? (int)$data['weight'] : 1;// 文章权重
        $messages['keywords'] = array_key_exists('keywords', $data) ? $data['keywords'] : $messages['name'];// 文章关键字
        $messages['description'] = array_key_exists('description', $data) ? $data['description'] : $messages['name'];// 文章描述
        $messages['index'] = array_key_exists('index', $data) ? (int)$data['index'] : 1;// 文章首页推荐状态 1 是 0 否
        $messages['hot'] = array_key_exists('hot', $data) ? (int)$data['hot'] : 1;// 文章热门推荐状态 1 是 0 否
        $messages['release'] = array_key_exists('release', $data) ? (int)$data['release'] : 1;// 文章是否发布状态 1 是 0 否
        $messages['update_time'] = array_key_exists('update_time', $data) ? (int)$data['update_time'] : time();// 文章修改时间
        $messages['release_time'] = array_key_exists('release_time', $data) ? (int)$data['release_time'] : ($messages['release']  ? time() : bcadd(time(), 86400));// 文章发布时间
        $messages['page'] = array_key_exists('page', $data) ? $data['page'] : null;// 文章页面
        if(!check_null($messages['name'], $messages['columns_id'], $messages['page'])){
            return self::setMsg('参数错误', false);
        }
        // 验证栏目编号
        $columnsRepository =  new ColumnsRepository();
        $columnsRepositoryModel = $columnsRepository::GetModel();
        $check =$columnsRepositoryModel::base_bool('check', [], $messages['columns_id']); // 验证编号
        if(!$check){
            return self::setMsg('栏目不存在', false);
        }
        $message['is_del'] = 0;
        $message['add_time'] = time();
        $status = self::$model::base_bool('insert', $messages, 0);
        return self::setMsg($status ? '添加成功' : '添加失败', $status);
    }

    /**
     * 信息修改
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
        $messages = [];
        $messages['name'] = array_key_exists('name', $data) ? $data['name'] : null;// 文章名称
        $messages['columns_id'] = array_key_exists('columns_id', $data) ? (int)$data['columns_id'] : null;// 文章栏目
        $messages['image'] = array_key_exists('image', $data) ? $data['image'] : '';// 文章图片
        $messages['writer'] = array_key_exists('writer', $data) ? $data['writer'] : 'ccforever<1253705861@qq.com>"';// 文章作者
        $messages['click'] = array_key_exists('click', $data) ? (int)$data['click'] : 1;// 文章点击量
        $messages['weight'] = array_key_exists('weight', $data) ? (int)$data['weight'] : 1;// 文章权重
        $messages['keywords'] = array_key_exists('keywords', $data) ? $data['keywords'] : $messages['name'];// 文章关键字
        $messages['description'] = array_key_exists('description', $data) ? $data['description'] : $messages['name'];// 文章描述
        $messages['index'] = array_key_exists('index', $data) ? (int)$data['index'] : 1;// 文章首页推荐状态 1 是 0 否
        $messages['hot'] = array_key_exists('hot', $data) ? (int)$data['hot'] : 1;// 文章热门推荐状态 1 是 0 否
        $messages['release'] = array_key_exists('release', $data) ? (int)$data['release'] : 1;// 文章是否发布状态 1 是 0 否
        $messages['update_time'] = array_key_exists('update_time', $data) ? (int)$data['update_time'] : time();// 文章修改时间
        $messages['release_time'] = array_key_exists('release_time', $data) ? (int)$data['release_time'] : ($messages['release']  ? time() : bcadd(time(), 86400));// 文章发布时间
        $messages['page'] = array_key_exists('page', $data) ? $data['page'] : null;// 文章页面
        if(!check_null($messages['name'], $messages['columns_id'], $messages['page'])){
            return self::setMsg('参数错误', false);
        }
        // 验证栏目编号
        $columnsRepository =  new ColumnsRepository();
        $columnsRepositoryModel = $columnsRepository::GetModel();
        $check = $columnsRepositoryModel::base_bool('check', [], $messages['columns_id']); // 验证编号
        if(!$check){
            return self::setMsg('栏目不存在', false);
        }
        $message = self::$model::base_array('message', [], $id, array_keys($messages));
        if($message === $messages){ // 数据库的数据和修改的数据一致
            return self::setMsg('修改成功', true);
        }
        $status = self::$model::base_bool('update', $messages, $id); // 修改数据
        return self::setMsg($status ? '修改成功' : '修改失败', $status);
    }
}