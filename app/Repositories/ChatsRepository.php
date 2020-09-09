<?php
/**
 * @author: cc_forever<1253705861@qq.com>
 * @day: 2020/8/7
 */

namespace App\Repositories;

use App\CcForever\extend\PRedisExtend;
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
     * 留言客服列表
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
        $list = self::$model::lst($where, $offset, $limit);//留言客服列表
        return self::setMsg('留言客服列表', true, $list);
    }

    /**
     * 留言客服总数
     *
     * @param array $where
     * @return bool
     */
    public static function count(array $where): bool
    {
        // TODO: Implement count() method.
        $count = self::$model::count($where);//留言客服总数
        return self::setMsg('留言客服总数', true, [$count]);
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
        $chats = []; // 留言记录
        $chats['content'] = array_key_exists('content', $data) && !is_null($data['content']) ? $data['content'] : '';
        $chats['user'] = array_key_exists('user', $data) && !is_null($data['user']) ? $data['user'] : null;
        $chats['speak'] = array_key_exists('speak', $data) && !is_null($data['speak']) ? $data['speak'] : null;
        $chats['customer'] = array_key_exists('customer', $data) && !is_null($data['customer']) ? $data['customer'] : '';
        $chats['see'] = array_key_exists('see', $data) && !is_null($data['see']) ? (int)$data['see'] : 0;
        if(is_null($chats['user']) || is_null($chats['speak'])){
            return self::setMsg('用户不存在', false);
        }
        if(!in_array($chats['see'], self::$model::GetSee())){
            return self::setMsg('状态错误', false);
        }
        $chats['add_time'] = time();
        $chats['is_del'] = 0;
        $status = self::$model::base_bool('insert', $chats, 0);
        return self::setMsg($status ? '添加成功' : '添加失败', $status);
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
        return self::setMsg('留言不支持修改', false);
    }

    public static function message(int $id): bool
    {
        // TODO: Implement message() method.
        return self::setMsg('不支持编号查询', false);
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

    /**
     * 留言状态修改
     *
     * @param string $user
     * @param string $customer
     * @return bool
     */
    public static function see(string $user, string $customer): bool
    {
        try{
            $redisRead = new PRedisExtend('read');
            $redisWrite = new PRedisExtend('write');
            $len = (bool)$redisRead::redis()->lLen($user);
            $write = true;
            if(!$len){ // 没有$user队列
                $write = $redisWrite::redis()->rpush($user, $customer); // 插入到$user队列中
            }
            if($write){ // 写入队列成功
                $userValue = $redisWrite::redis()->lrange($user, 0, 0); // 获取插入到队列中的第一个客服
                if($userValue[0] === $customer){ // 判断当前客服是队列中的客服
                    // 获取用户未读取的留言
                    $equal = self::$model::base_array('equal', ['user' => $user, 'see' => 0], ['id'], []);
                    if(count($equal)){ // 留言存在
                        $ids = array_column($equal, 'id'); // 获取留言编号
                        // 修改留言状态
                        $status = self::$model::base_bool('updates', ['customer' => $customer, 'see' => 1], [implode(',', $ids), 'id']);
                        return self::setMsg($status ? '接入成功' : '接入失败', $status);
                    }
                    return self::setMsg('暂无留言', true, $equal);
                }
            }
            return self::setMsg('已有客服接入', false);
        }catch (\Exception $exception){
            // 未开启redis
            self::$model::beginTransaction(); // 开启事务
            $equal = self::$model::base_array('equal', ['user' => $user, 'see' => 0], ['id'], []);
            if(count($equal)){ // 留言存在
                $ids = array_column($equal, 'id'); // 获取留言编号
                // 修改留言状态
                $status = self::$model::base_bool('updates', ['customer' => $customer, 'see' => 1], [implode(',', $ids), 'id']);
                self::$model::checkTransaction($status); // 提交事务
                return self::setMsg($status ? '接入成功' : '接入失败', $status);
            }
            self::$model::checkTransaction(true); // 提交事务
            $equal = self::$model::base_array('equal', ['user' => $user], ['customer'], []);
            if(count($equal)){
                $customerEqual = array_column($equal, 'customer'); // 获取留言编号
                list($customerEqual) = array_merge(array_flip(array_flip($customerEqual))); // 删除重复的客服并且设置key值从0开始并获取第一个客户
                if($customerEqual == $customer){// 判断数据库的客服是否和当前客服一致
                    return self::setMsg('暂无留言', true, $equal);
                }
            }
            return self::setMsg('已有客服接入', false);
        }
    }

    /**
     * 留言用户列表
     *
     * @param string $customer
     * @param int $page
     * @param int $limit
     * @return bool
     */
    public static function users(string $customer, int $page, int $limit): bool
    {
        // 验证客服是否存在
        $check = self::$model::base_bool('check', [], [$customer, 'customer']);
        if(!$check){
            return self::setMsg('客服不存在', false);
        }
        $offset = page_to_offset($page, $limit); // 获取起始值
        $list = self::$model::users($customer, $offset, $limit); // 留言用户列表
        if(!count($list)){
            return self::setMsg('暂无留言用户', false);
        }
        $count = self::$model::usersCount($customer); // 留言用户总数
        return self::setMsg('留言用户列表', true, compact('list', 'count'));
    }

    /**
     * 留言客服和用户对话列表
     *
     * @param string $customer
     * @param string $user
     * @param int $page
     * @param int $limit
     * @return bool
     */
    public static function chats(string $customer, string $user, int $page, int $limit): bool
    {
        // 验证客服是否存在
        $check = self::$model::base_bool('check', [], [$customer, 'customer']);
        if(!$check){
            return self::setMsg('客服不存在', false);
        }
        // 验证用户是否存在
        $check = self::$model::base_bool('check', [], [$user, 'user']);
        if(!$check){
            return self::setMsg('用户不存在', false);
        }
        $offset = page_to_offset($page, $limit); // 获取起始值
        $list = self::$model::chats($customer, $user, $offset, $limit); // 留言客服和用户对话列表
        if(!count($list)){
            return self::setMsg('暂无对话记录', false);
        }
        $count = self::$model::chatsCount($customer, $user); // 留言客服和用户对话总数
        return self::setMsg('留言用户列表', true, compact('list', 'count'));
    }

    /**
     * 留言用户统计
     *
     * @param int $limit
     * @return bool
     */
    public static function statistics(int $limit): bool
    {
        // 获取结束时间
        $stopTime = date('Y/m/d', strtotime('0 week Monday'));
        // 获取开始时间
        $startTime = date('Y/m/d', strtotime('-'.$limit.' week Monday'));
        // 获取时间区间修改留言用户的时间
        $chats = self::$model::statistics(strtotime($startTime), strtotime($stopTime));
        // 格式化最近几周用户留言
        $result = self::formatStatistics($chats, $limit, []);
        return self::setMsg('留言用户', true, array_merge($result));
    }

    /**
     * 格式化留言用户统计
     *
     * @param array $chats
     * @param int $limit
     * @param array $result
     * @return array
     */
    public static function formatStatistics(array $chats, int $limit, array $result): array
    {
        // $limit 为0是返回
        if(!$limit){ return $result; }
        // 获取结束时间
        $stopTime = date('Y/m/d', strtotime('-'. (int)bcsub($limit, 1, 0) . ' week Monday'));
        // 获取开始时间
        $startTime = date('Y/m/d', strtotime('-'.$limit.' week Monday'));
        $count = 0; // 时间区间 留言用户总数
        foreach ($chats as &$chat){
            if($chat['time'] >= strtotime($startTime)  &&  $chat['time'] < strtotime($stopTime)){
                $count++;
            }
        }
        // 添加数据 周
        $result[$limit]['week'] = $startTime.'-'.$stopTime;
        // 添加数据 留言用户的总数
        $result[$limit]['count'] = $count;
        // $limit自减
        $limit--;
        return self::formatStatistics($chats, $limit, $result);
    }
}