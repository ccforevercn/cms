<?php
/**
 * @author: cc_forever<1253705861@qq.com>
 * @day: 2020/8/31
 */

namespace App\CcForever\extend;

use App\Repositories\ColumnsRepository;

/**
 * 栏目
 *
 * Class ColumnsExtend
 * @package App\CcForever\extend
 */
class ColumnsExtend
{
    /**
     * 栏目信息
     *
     * $id  栏目编号
     * $content true 展示内容  false 隐藏内容
     *
     * @param int $id
     * @param bool $content
     * @return array
     */
    public static function column(int $id, bool $content): array
    {
        $result = [];
        $columnsRepository = new ColumnsRepository();
        // 获取栏目信息
        $bool = $columnsRepository::message($id);
        // 栏目不存在
        if(!$bool){ return $result; }
        $column = $columnsRepository::returnData([]);
        if($content){
            // 获取栏目内容
            $bool = $columnsRepository::content(['type' => true, 'id' => $id, 'content' => ''] , true);
            $result['content'] = '';
            if($bool){ $result['content'] = $columnsRepository::returnData([])['content']; }
        }
        $result['unique'] = $column['id'];
        $result['name'] = $column['name'];
        $result['name_alias'] = $column['name_alias'];
        $result['image'] = $column['image'];
        $result['banner_image'] = $column['banner_image'];
        $result['keywords'] = $column['keywords'];
        $result['parent_id'] = $column['parent_id'];
        $result['limit'] = $column['limit'];
        $result['render'] = $column['render'];
        $result['description'] = $column['description'];
        if($column['render']){
            // 外链
            $result['url'] = $column['page'];
        }else{
            // 页面
            $result['url'] = '/'.$column['page'].'/'.$column['id'].page_suffix_message();
        }
        return $result;
    }

    /**
     * 栏目子集
     *
     * $id  父级栏目
     * $limit  栏目子集条数  0 为全部
     *
     * @param int $id
     * @param int $limit
     * @return array
     */
    public static function children(int $id, int $limit): array
    {
        $result = [];
        $columnsRepository = new ColumnsRepository();
        $bool = $columnsRepository::children($id, $limit);
        if(!$bool) return $result;
        $columns = $columnsRepository::returnData([]);
        foreach ($columns as $key=>&$column){
            $result[$key]['unique'] = $column['id'];
            $result[$key]['name'] = $column['name'];
            $result[$key]['name_alias'] = $column['name_alias'];
            $result[$key]['image'] = $column['image'];
            $result[$key]['banner_image'] = $column['banner_image'];
            $result[$key]['keywords'] = $column['keywords'];
            $result[$key]['description'] = $column['description'];
            if($column['render']){
                // 外链
                $result[$key]['url'] = $column['page'];
            }else{
                // 页面
                $result[$key]['url'] = '/'.$column['page'].'/'.$column['id'].page_suffix_message();
            }
        }
        return $result;
    }

    /**
     * 栏目列表
     *
     * $ids 指定栏目编号
     *
     * @param array $ids
     * @return array
     */
    public static function appointed(array $ids): array
    {
        $result = [];
        // 指定的栏目编号为空
        if(!count($ids)) return $result;
        $columnsRepository = new ColumnsRepository();
        $bool = $columnsRepository::appointed($ids);
        // 栏目为空时
        if(!$bool){ return $result; }
        $columns = $columnsRepository::returnData([]);
        foreach ($columns as $key=>&$column){
            $result[$key]['unique'] = $column['id'];
            $result[$key]['name'] = $column['name'];
            $result[$key]['name_alias'] = $column['name_alias'];
            $result[$key]['image'] = $column['image'];
            $result[$key]['banner_image'] = $column['banner_image'];
            $result[$key]['keywords'] = $column['keywords'];
            $result[$key]['description'] = $column['description'];
            if($column['render']){
                // 外链
                $result[$key]['url'] = $column['page'];
            }else{
                // 页面
                $result[$key]['url'] = $column['page'].'/'.$column['id'].page_suffix_message();
            }
        }
        return $result;
    }

    /**
     * 栏目排序和下级编号+
     *
     * @param int $id
     * @param bool $loop
     * @return array
     */
    public static function columnsMessagesOrderAndLoopIds(int $id, bool $loop): array
    {
        // 栏目编号
        $columnIds = [$id];
        // 实例化ColumnsRepository
        $columnsRepository = new ColumnsRepository();
        // 栏目信息
        $bool = $columnsRepository::message($id);
        // 栏目不存在
        if(!$bool) return [];
        // 获取栏目信息
        $column = $columnsRepository::returnData([]);
        // 获取排序方式
        $order = check_message_order($column['sort']);
        if($loop){
            // 获取子集信息
            $subsets = $columnsRepository::subsets($id);
            // 合并子集编号和栏目编号
            $columnIds = array_merge($columnIds, array_map(function ($item){
                return $item['id'];
            }, $subsets));
        }
        return compact('order', 'columnIds');
    }
}