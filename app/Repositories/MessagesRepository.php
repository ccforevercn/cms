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
 * 信息信息
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
        $where['columns_id'] = array_key_exists('columns_id', $where) && !is_null($where['columns_id']) ? $where['columns_id'] : '';// 信息栏目是否存在
        $where['index'] = array_key_exists('index', $where) && !is_null($where['index']) ? $where['index'] : '';// 首页推荐
        $where['hot'] = array_key_exists('hot', $where) && !is_null($where['hot']) ? $where['hot'] : '';// 热门推荐
        $where['release'] = array_key_exists('release', $where) && !is_null($where['release']) ? $where['release'] : '';// 发布状态
        $count = self::$model::count($where);// 信息总数
        return self::setMsg('信息总数', true, [$count]);
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
        $messages = []; // 信息
        $messages['name'] = array_key_exists('name', $data) && !is_null($data['name'])  ? $data['name'] : null;// 信息名称
        $messages['columns_id'] = array_key_exists('columns_id', $data) && !is_null($data['columns_id'])  ? (int)$data['columns_id'] : null;// 信息栏目
        $tagsIds = array_key_exists('tags_id', $data) && !is_null($data['tags_id']) ? $data['tags_id'] : null;// 信息标签
        $messages['image'] = array_key_exists('image', $data) && !is_null($data['image'])  ? $data['image'] : '';// 信息图片
        $messages['writer'] = array_key_exists('writer', $data) && !is_null($data['writer'])  ? $data['writer'] : 'ccforever<1253705861@qq.com>';// 信息作者
        $messages['click'] = array_key_exists('click', $data) && !is_null($data['click'])  ? (int)$data['click'] : 1;// 信息点击量
        $messages['weight'] = array_key_exists('weight', $data) && !is_null($data['weight'])  ? (int)$data['weight'] : 1;// 信息权重
        $messages['keywords'] = array_key_exists('keywords', $data) && !is_null($data['keywords'])  ? $data['keywords'] : $messages['name'];// 信息关键字
        $messages['description'] = array_key_exists('description', $data) && !is_null($data['description'])  ? $data['description'] : $messages['name'];// 信息描述
        $messages['index'] = array_key_exists('index', $data) && !is_null($data['index'])  ? (int)$data['index'] : 1;// 信息首页推荐状态 1 是 0 否
        $messages['hot'] = array_key_exists('hot', $data) && !is_null($data['hot'])  ? (int)$data['hot'] : 1;// 信息热门推荐状态 1 是 0 否
        $messages['release'] = array_key_exists('release', $data) && !is_null($data['release'])  ? (int)$data['release'] : 1;// 信息是否发布状态 1 是 0 否
        $messages['update_time'] = array_key_exists('update_time', $data) && !is_null($data['update_time'])  ? (int)$data['update_time'] : time();// 信息修改时间
        $messages['release_time'] = array_key_exists('release_time', $data) && !is_null($data['release_time'])  ? (int)$data['release_time'] : ($messages['release']  ? time() : bcadd(time(), 86400));// 信息发布时间
        $messages['page'] = array_key_exists('page', $data) && !is_null($data['page'])  ? $data['page'] : null;// 信息页面
        if(!check_null($messages['name'], $messages['columns_id'], $messages['page'])){
            return self::setMsg('参数错误', false);
        }
        $messagesTags = []; // 信息标签
        $messagesTagsCount = 0; // 信息标签添加总数
        $unique = create_admin_password(create_millisecond(), $data['username'].$data['admin_id']); // 信息和信息标签的唯一值
        $time = time(); // 添加时间
        if(!is_null($tagsIds)){ // 信息标签存在
            $tagsIds = explode(',', $tagsIds); // 格式化标签编号
            $tagsRepository = new TagsRepository(); // 实例化TagsRepository类
            $tagsRepositoryModel = $tagsRepository::GetModel(); // 获取TagsModel
            $count = $tagsRepositoryModel::checkIds($tagsIds); // 验证标签编号
            if($count !== count($tagsIds)){  // 编号和数据库编号不一致
                return self::setMsg('标签不存在', false);
            }
            foreach ($tagsIds as $key=>$tagsId){
                $messagesTags[$messagesTagsCount]['tag_id'] = (int)$tagsId; // 标签编号
                $messagesTags[$messagesTagsCount]['unique'] = $unique; // 唯一值
                $messagesTags[$messagesTagsCount]['add_time'] = $time; // 添加时间
                $messagesTags[$messagesTagsCount]['clear_time'] = $time; // 清除时间 默认添加时间
                $messagesTags[$messagesTagsCount]['is_del'] = 0; // 是否删除  删除时修改清除时间
                $messagesTagsCount++; // key自增
            }
        }
        // 验证栏目编号
        $columnsRepository =  new ColumnsRepository();  // 实例化ColumnsRepository类
        $columnsRepositoryModel = $columnsRepository::GetModel(); // 获取ColumnsModel
        $check =$columnsRepositoryModel::base_bool('check', [], $messages['columns_id']); // 验证编号
        if(!$check){ // 编号不存
            return self::setMsg('栏目不存在', false);
        }
        $messages['unique'] = $unique;
        $messages['is_del'] = 0;
        $messages['add_time'] = $time;
        // 开始添加数据
        self::$model::beginTransaction(); // 开启事务
        $messageStatus = self::$model::base_bool('insert', $messages, 0); // 添加信息信息
        $messagesTagsStatus = true; // 设置默认信息标签添加成功
        if($messagesTagsCount){ // 信息标签存在
            self::$model::SetModelTable('messages_tags'); // 修改表为messages_tags
            $messagesTagsStatus = self::$model::base_bool('insert', $messagesTags, 0); // 添加信息标签信息
            self::$model::SetModelTable('messages');// 修改表为messages
        }
        $status = $messageStatus && $messagesTagsStatus;
        self::$model::checkTransaction($status); // 提交事务
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
        $messages['name'] = array_key_exists('name', $data) && !is_null($data['name'])  ? $data['name'] : null;// 信息名称
        $messages['columns_id'] = array_key_exists('columns_id', $data) && !is_null($data['columns_id'])  ? (int)$data['columns_id'] : null;// 信息栏目
        $tagsIds = array_key_exists('tags_id', $data) && !is_null($data['tags_id']) ? $data['tags_id'] : null;// 信息标签
        $messages['image'] = array_key_exists('image', $data) && !is_null($data['image'])  ? $data['image'] : '';// 信息图片
        $messages['writer'] = array_key_exists('writer', $data) && !is_null($data['writer'])  ? $data['writer'] : 'ccforever<1253705861@qq.com>';// 信息作者
        $messages['click'] = array_key_exists('click', $data) && !is_null($data['click'])  ? (int)$data['click'] : 1;// 信息点击量
        $messages['weight'] = array_key_exists('weight', $data) && !is_null($data['weight'])  ? (int)$data['weight'] : 1;// 信息权重
        $messages['keywords'] = array_key_exists('keywords', $data) && !is_null($data['keywords'])  ? $data['keywords'] : $messages['name'];// 信息关键字
        $messages['description'] = array_key_exists('description', $data) && !is_null($data['description'])  ? $data['description'] : $messages['name'];// 信息描述
        $messages['index'] = array_key_exists('index', $data) && !is_null($data['index'])  ? (int)$data['index'] : 1;// 信息首页推荐状态 1 是 0 否
        $messages['hot'] = array_key_exists('hot', $data) && !is_null($data['hot'])  ? (int)$data['hot'] : 1;// 信息热门推荐状态 1 是 0 否
        $messages['release'] = array_key_exists('release', $data) && !is_null($data['release'])  ? (int)$data['release'] : 1;// 信息是否发布状态 1 是 0 否
        $messages['update_time'] = array_key_exists('update_time', $data) && !is_null($data['update_time'])  ? (int)$data['update_time'] : time();// 信息修改时间
        $messages['release_time'] = array_key_exists('release_time', $data) && !is_null($data['release_time'])  ? (int)$data['release_time'] : ($messages['release']  ? time() : bcadd(time(), 86400));// 信息发布时间
        $messages['page'] = array_key_exists('page', $data) && !is_null($data['page'])  ? $data['page'] : null;// 信息页面
        if(!check_null($messages['name'], $messages['columns_id'], $messages['page'])){
            return self::setMsg('参数错误', false);
        }
        $messagesTags = []; // 信息标签
        $messagesTagsCount = 0; // 信息标签添加总数
        $unique = create_admin_password(create_millisecond(), $data['username'].$data['admin_id']); // 信息和信息标签的唯一值
        $time = time(); // 添加时间
        if(!is_null($tagsIds)){ // 信息标签存在
            $tagsIds = explode(',', $tagsIds); // 格式化标签编号
            $tagsRepository = new TagsRepository(); // 实例化TagsRepository类
            $tagsRepositoryModel = $tagsRepository::GetModel(); // 获取TagsModel
            $count = $tagsRepositoryModel::checkIds($tagsIds); // 验证标签编号
            if($count !== count($tagsIds)){  // 编号和数据库编号不一致
                return self::setMsg('标签不存在', false);
            }
            foreach ($tagsIds as $key=>$tagsId){
                $messagesTags[$messagesTagsCount]['tag_id'] = (int)$tagsId; // 标签编号
                $messagesTags[$messagesTagsCount]['unique'] = $unique; // 唯一值
                $messagesTags[$messagesTagsCount]['add_time'] = $time; // 添加时间
                $messagesTags[$messagesTagsCount]['clear_time'] = $time; // 清除时间 默认添加时间
                $messagesTags[$messagesTagsCount]['is_del'] = 0; // 是否删除  删除时修改清除时间
                $messagesTagsCount++; // key自增
            }
        }
        // 验证栏目编号
        $columnsRepository =  new ColumnsRepository(); // 实例化ColumnsRepository类
        $columnsRepositoryModel = $columnsRepository::GetModel(); // 获取ColumnsModel
        $check = $columnsRepositoryModel::base_bool('check', [], $messages['columns_id']); // 验证编号
        if(!$check){
            return self::setMsg('栏目不存在', false);
        }
        $messages['unique'] = $unique;
        // 开始添加数据
        self::$model::beginTransaction(); // 开启事务
        $messageStatus = self::$model::base_bool('update', $messages, $id); // 修改信息信息
        $messagesTagsStatus = true; // 设置默认信息标签添加成功
        if($messagesTagsCount){ // 信息标签存在
            self::$model::SetModelTable('messages_tags'); // 修改表为messages_tags
            $messagesTagsStatus = self::$model::base_bool('insert', $messagesTags, 0); // 添加信息标签信息
            self::$model::SetModelTable('messages');// 修改表为messages
        }
        $status = $messageStatus && $messagesTagsStatus;
        self::$model::checkTransaction($status); // 提交事务
        return self::setMsg($status ? '修改成功' : '修改失败', $status);
    }

    /**
     * 信息内容  添加/修改/查询
     *
     * @param array $data
     * @param bool $type
     * @return bool
     */
    public static function content(array $data, bool $type):bool
    {
        unset($data['type']); // $type  false 添加/修改  true 查询
        $id = array_key_exists('id', $data) ? (int)$data['id'] : null; // 信息编号
        $content = array_key_exists('content', $data) && !is_null($data['content']) ? $data['content'] : ''; // 信息内容
        $markdown = array_key_exists('markdown', $data) && !is_null($data['markdown']) ? $data['markdown'] : ''; // 信息内容
        $images = array_key_exists('images', $data) && !is_null($data['images']) ? $data['images'] : ''; // 信息图片
        $returnMsg = '信息内容'; // 返回提示
        $returnStatus = true; // 返回状态
        $returnData = []; // 返回信息
        self::$model::SetModelTable('messages_content');
        $check = self::$model::base_bool('check', [], $id);
        if($type){ // 查询
            if($check){
                $returnData = self::$model::base_array('message', $id, ['content', 'markdown', 'images'], []);
            }
            if(!count($returnData)){
                $returnData = ['content' => '', 'markdown' => '', 'images' => ''];
            }
        }else{ // 添加/修改
            $messages = []; // 信息内容数据
            $messages['content'] = $content; // 信息内容
            $messages['markdown'] = $markdown; // 信息内容
            $messages['images'] = $images; // 信息图片
            if(!$check){ // 添加
                $messages['id'] = $id; // 信息编号
                $messages['is_del'] = 0; // 信息是否删除
                $returnStatus = self::$model::base_bool('insert', $messages, 0);
                $returnMsg = $returnStatus ? '添加成功' : '添加失败';
            }else{ // 修改
                $message = self::$model::base_array('message', $id, array_keys($messages), []);
                if($message === $messages){ // 数据库的数据和修改的数据一致
                    $returnMsg = '修改成功';
                }else{
                    $returnStatus = self::$model::base_bool('update', $messages, $id);
                    $returnMsg = $returnStatus ? '修改成功' : '修改失败';
                }
            }
        }
        self::$model::SetModelTable('messages');
        return self::setMsg($returnMsg, $returnStatus, $returnData);
    }

    /**
     * 信息标签
     *
     * @param int $id
     * @return bool
     */
    public static function tags(int $id): bool
    {
        $check = self::$model::base_bool('check', [], $id); // 验证编号
        if(!$check){
            return self::setMsg('参数错误', false);
        }
        $unique = self::$model::base_string('select', $id, 'unique');  // 查询信息标签唯一值
        $tags = self::$model::tags($unique);
        return self::setMsg('信息标签列表', true, $tags);
    }

    /**
     * 信息视图列表
     *
     * @return bool
     */
    public static function views(): bool
    {
        $viewsRepository = new ViewsRepository();
        $viewsRepositoryModel = $viewsRepository::GetModel();
        $viewsColumns = $viewsRepositoryModel::base_array('equal', ['type' => 2], ['name', 'path'], []);
        $status = (bool)count($viewsColumns);
        return self::setMsg($status ? '信息视图列表' : '获取失败', $status, $viewsColumns);
    }

    /**
     * 信息 点击量
     *
     * @param int $id
     * @param int $click
     * @return bool
     */
    public static function click(int $id, int $click): bool
    {
        $check = self::$model::base_bool('check', [], $id); // 验证编号
        if(!$check){
            return self::setMsg('参数错误', false);
        }
        $clicked = (int)self::$model::base_string('select', $id, 'click');
        if(!$clicked && $click < 0){
            return self::setMsg('修改失败，参数错误', false);
        }
        $total = (int)bcadd($click, $clicked, 0);
        if($total > 999) {
            return self::setMsg('修改失败，点击量最多三位数', false);
        }
        $total = (int)bcadd($click, $clicked, 0);
        if($total < 0){ $click = (int)('-'.$clicked); }
        $status = self::$model::click($id, $click);
        return self::setMsg($status ? '修改成功' : '修改失败', $status);
    }

    /**
     * 信息状态
     *
     * @param int $id
     * @param string $type
     * @param int $value
     * @return bool
     */
    public static function state(int $id, string $type, int $value): bool
    {
        if(!in_array($type, self::$model::GetState())){ // 验证类型
            return self::setMsg('状态类型错误', false);
        }
        if(!in_array($value, [0, 1])){ // 验证状态值
            return self::setMsg('状态值错误', false);
        }
        $check = self::$model::base_bool('check', [], $id); // 验证编号
        if(!$check){
            return self::setMsg('参数错误', false);
        }
        $messages = [];
        $messages[$type] = $value;
        $message = self::$model::base_array('message', $id, array_keys($messages), []);
        if($message === $messages){ // 数据库的数据和修改的数据一致
            return self::setMsg('修改成功', true);
        }
        $status = self::$model::base_bool('update', $messages, $id);
        return self::setMsg($status ? '修改成功' : '修改失败', $status);
    }

    /**
     * 信息列表
     *
     * @param array $columnIds
     * @param array $order
     * @param int $offset
     * @param int $limit
     * @param int $type
     * @return bool
     */
    public static function messages(array $columnIds, array $order, int $offset, int $limit, int $type): bool
    {
        $messages = self::$model::messages($columnIds, $order, $offset, $limit, $type);
        return self::setMsg('信息列表', (bool)count($messages), $messages);
    }

    /**
     * 信息列表总数
     * @param array $columnIds
     * @param int $type
     * @return int
     */
    public static function messagesCount(array $columnIds, int $type): int
    {
        return self::$model::messagesCount($columnIds, $type);
    }

    /**
     * 信息数据(当前栏目下信息所有数据)
     *
     * @param int $columnId
     * @return array
     */
    public static function messageTotal(int $columnId): array
    {
        return self::$model::messageTotal($columnId);
    }

    /**
     * 信息(上一页和下一页)
     *
     * @param int $columnId
     * @param array $order
     * @param int $value
     * @return array
     */
    public static function messageEnter(int $columnId, array $order, int $value): array
    {
        $message = self::$model::messageEnter($columnId, $order, $value);
        return count($message) ? $message[0] : [];
    }
}