<?php
/**
 * @author: cc_forever<1253705861@qq.com>
 * @day: 2020/8/31
 */

namespace App\CcForever\extend;

use App\Repositories\ColumnsRepository;
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
     * 信息列表
     *
     * $columnId 栏目编号
     * $loop false 当前栏目信息  true 当前栏目和下级+ 栏目信息
     * $offset 信息记录起始值
     * $limit 信息记录长度
     * $type 信息类型 1 首页推荐  2 热门推荐  3 全部
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
        $result = [];
        // 栏目编号
        $columnIds = [$columnId];
        // 判断栏目是否存在 并 获取排序方式
        $columnsRepository = new ColumnsRepository();
        // 获取栏目
        $bool = $columnsRepository::message($columnId);
        // 栏目不存在
        if(!$bool) return $result;
        // 栏目信息
        $column = $columnsRepository::returnData([]);
        // 获取排序方式
        $order = check_message_order($column['sort']);
        // 下级栏目+ 编号
        if($loop){
            $bool  = $columnsRepository::subsets($columnId);
            if($bool){
                // 子集存在
                // 获取子集信息
                $subsets = $columnsRepository::returnData([]);
                // 合并子集编号和栏目编号
                $columnIds = array_merge($columnIds, array_map(function ($item){
                    return $item['id'];
                }, $subsets));
            }
        }
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
            $result[$key]['url'] = $message['page'].'/'.$message['id'].page_suffix_message();
        }
        return $result;
    }
}