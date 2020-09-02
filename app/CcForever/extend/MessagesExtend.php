<?php
/**
 * @author: cc_forever<1253705861@qq.com>
 * @day: 2020/8/31
 */

namespace App\CcForever\extend;

use App\Repositories\MessagesRepository;

/**
 * 信息
 *
 * Class MessageExtend
 * @package App\CcForever\extend
 */
class MessagesExtend
{
    /**
     * 信息列表(直接获取)
     *
     * @param int $columnId
     * @param bool $loop
     * @param int $offset
     * @param int $limit
     * @param int $type
     * @return array
     */
    public static function messages(int $columnId, bool $loop, int $offset, int $limit, int $type): array
    {
        $columnsMessagesOrderAndLoopIds = ColumnsExtend::columnsMessagesOrderAndLoopIds($columnId, $loop);
        if(!count($columnsMessagesOrderAndLoopIds)) return [];
        $messages = MessagesExtend::messageList($columnsMessagesOrderAndLoopIds['columnIds'], $columnsMessagesOrderAndLoopIds['order'], $offset, $limit, $type);
        return $messages;
    }

    /**
     * 信息列表(调用需获取栏目排序和栏目编号)
     *
     * $columnId 栏目编号
     * $order 排序方式
     * $offset 信息记录起始值
     * $limit 信息记录长度
     * $type 信息类型 1 首页推荐  2 热门推荐  3 全部
     *
     * @param array $columnIds
     * @param array $order
     * @param int $offset
     * @param int $limit
     * @param int $type
     * @return array
     */
    public static function messageList(array $columnIds, array $order, int $offset, int $limit, int $type): array
    {
        $result = [];
        $messagesRepository = new MessagesRepository();
        $bool = $messagesRepository::messages($columnIds, $order, $offset, $limit, $type);
        if(!$bool) return $result;
        $messages = $messagesRepository::returnData([]);
        foreach ($messages as $key=>&$message){
            $result[$key]['cname'] = $message['cname'];
            $result[$key]['cname_alias'] = $message['cname_alias'];
            $result[$key]['name'] = $message['name'];
            $result[$key]['image'] = $message['image'];
            $result[$key]['writer'] = $message['writer'];
            $result[$key]['click'] = $message['click'];
            $result[$key]['keywords'] = $message['keywords'];
            $result[$key]['description'] = $message['description'];
            $result[$key]['update_time'] = $message['update_time'];
            $result[$key]['time'] = date('Y-m-d H:i', $message['update_time']);
            $result[$key]['tag'] = $message['tag'];
            $result[$key]['url'] = '/'.$message['page'].'/'.$message['id'].page_suffix_message();
        }
        return $result;
    }

    /**
     * 栏目信息总页数
     *
     * $columnIds  栏目编号
     * $messagesType 信息类型
     * $limit 每页条数
     *
     * @param array $columnIds
     * @param int $messagesType
     * @param int $limit
     * @return int
     */
    public static function messagesCountPage(array $columnIds, int $messagesType, int $limit): int
    {
        // 实例化MessagesRepository
        $messagesRepository = new MessagesRepository();
        // 获取信息总条数
        $messagesCount = $messagesRepository::messagesCount($columnIds, $messagesType);
        // 计算信息总页数
        $countPage = (int)ceil(floatval(bcdiv($messagesCount, $limit, 2)));
        // 总页数
        return $countPage;
    }

    /**
     * 信息数据(当前栏目下信息所有数据)
     *
     * @param int $columnId
     * @param int $order
     * @return array
     */
    public static function message(int $columnId, int $order): array
    {
        $result = [];
        // 实例化MessagesRepository
        $messagesRepository = new MessagesRepository();
        // 获取栏目下的信息
        $message = $messagesRepository::messageTotal($columnId);
        // 上一条信息条件获取
        $preWhere = check_message_order_pre($order);
        // 下一条信息条件获取
        $nextWhere = check_message_order_next($order);
        // 格式化信息
        foreach ($message as $key=>&$item){
            $result[$key]['id'] = $item['id'];
            $result[$key]['name'] = $item['name'];
            $result[$key]['cname'] = $item['cname'];
            $result[$key]['cname_alias'] = $item['cname_alias'];
            $result[$key]['cid'] = $item['cid'];
            $result[$key]['content'] = $item['content'];
            $result[$key]['images'] = $item['images'];
            $result[$key]['image'] = $item['image'];
            $result[$key]['writer'] = $item['writer'];
            $result[$key]['click'] = $item['click'];
            $result[$key]['keywords'] = $item['keywords'];
            $result[$key]['description'] = $item['description'];
            $result[$key]['time'] = date('Y-m-d H:i', $item['update_time']);
            $result[$key]['url'] = '/'.$item['page'].'/'.$item['id'].page_suffix_message();
            // 上一条获取
            $result[$key]['pre'] = $messagesRepository::messageEnter($columnId, $preWhere, $item[$preWhere['select']]);
            // 下一条获取
            $result[$key]['next'] = $messagesRepository::messageEnter($columnId, $nextWhere, $item[$nextWhere['select']]);
        }
        return $result;
    }
}