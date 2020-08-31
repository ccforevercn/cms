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
        $result['description'] = $column['description'];
        if($column['render']){
            // 外链
            $result['url'] = $column['page'];
        }else{
            // 页面
            $result['url'] = $column['page'].'/'.$column['id'].config('ccforever.suffix.page');
        }
        return $result;
    }

    /**
     * 栏目子集
     *
     * $id  父级栏目
     * $limit  栏目子集条数
     *
     * @param int $id
     * @param int $limit
     * @return array
     */
    public static function children(int $id, int $limit): array
    {
        $result = [];
        if($limit < 1) return $result;
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
                $result[$key]['url'] = $column['page'].'/'.$column['id'].config('ccforever.suffix.page');
            }
        }
        return $result;
    }
}