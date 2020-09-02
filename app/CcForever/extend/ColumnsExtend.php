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
            if($bool){
                // 获取栏目内容
                $result['content'] = $columnsRepository::returnData([])['content'];
                // 获取域名
                $url = config('app.url');
                // 替换域名信息
                $result['content'] = str_replace($url.'/upload', '/upload', $result['content']);
            }
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
        $result['sort'] = $column['sort'];
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

    /**
     * 栏目分页
     *
     * $id 栏目编号
     * $current 当前页
     * $messagesType 信息类型 1 首页推荐 2 热门推荐 3 所有
     * $classUl ul标签样式
     * $classLi li标签样式
     * $classA a标签样式
     * $classCurrentLi 当前页li标签样式
     * $classCurrentA 当前页a标签样式
     * $extremes 是否展示首页和尾页(默认true)   true 是   false 否
     * $enter 是否展示上一页和下一页(默认true)   true 是   false 否
     * $number 是否展示之前一页，之前两页，之后一页，之后两页(默认true)   true 是   false 否
     *
     * @param int $id
     * @param int $current
     * @param int $messagesType
     * @param string $classUl
     * @param string $classLi
     * @param string $classA
     * @param string $classCurrentLi
     * @param string $classCurrentA
     * @param bool $extremes
     * @param bool $enter
     * @param bool $number
     * @return string
     */
    public static function page(int $id, int $current, int $messagesType, string $classUl, string $classLi, string $classA, string $classCurrentLi, string $classCurrentA, bool $extremes = true, bool $enter = true, bool $number = true):string
    {
        $result = '';
        // 当前栏目信息
        $column = self::column($id, false);
        // 栏目不存在
        if(!count($column)) return $result;
        // 获取 栏目排序和下级编号+
        $columnsMessagesOrderAndLoopIds = ColumnsExtend::columnsMessagesOrderAndLoopIds($id ,true);
        // 获取每页条数
        $limit = $column['limit'];
        // 当前栏目总页数
        $countPage = MessagesExtend::messagesCountPage($columnsMessagesOrderAndLoopIds['columnIds'], $messagesType, $limit);
        if(!$countPage) return $result;
        // 当前栏目首页
        $url = $column['url'];
        $result .= '<ul class="'. $classUl .'">';
        // 是否展示首页和尾页
        if($extremes){
            // 首页
            $result .= self::pageFirst($url, $column['name'], $classLi, $classA);
        }
        // 是否展示上一页和下一页
        if($enter){
            // 上一页
            $result .= self::pageBefore($current, 1, $url, $column['name'], $classLi, $classA, '上一页');
        }
        // 是否展示之前一页，之前两页，之后一页，之后两页
        if($number){
            // 之前两页
            $result .= self::pageBefore($current, 2, $url, $column['name'], $classLi, $classA, '');
            // 之前一页
            $result .= self::pageBefore($current, 1, $url, $column['name'], $classLi, $classA, '');
        }
        // 当前页
        $result .= '<li class="'. $classCurrentLi .'"><a class="'. $classCurrentA .'" href="javascript:void(0);" title="'. $column['name'] .'">当前页</a></li>';
        // 是否展示之前一页，之前两页，之后一页，之后两页
        if($number) {
            // 之后一页
            $result .= self::pageAfter($countPage, $current, 1, $url, $column['name'], $classLi, $classA, '');
            // 之后二页
            $result .= self::pageAfter($countPage, $current, 2, $url, $column['name'], $classLi, $classA, '');
        }
        // 是否展示上一页和下一页
        if($enter) {
            // 下一页
            $result .= self::pageAfter($countPage, $current, 1, $url, $column['name'], $classLi, $classA, '下一页');
        }
        // 是否展示首页和尾页
        if($extremes) {
            // 尾页
            $result .= self::pageLast($countPage, $url, $column['name'], $classLi, $classA);
        }
        $result .= '</ul>';
        return $result;
    }

    /**
     * 分页--首页
     *
     * $url 首页地址
     * $title 栏目名称
     * $classLi li标签样式
     * $classA a标签样式
     *
     * @param string $url
     * @param string $title
     * @param string $classLi
     * @param string $classA
     * @return string
     */
    private static function pageFirst(string $url, string $title, string $classLi, string $classA): string
    {
        return '<li class="'. $classLi .'"><a class="'. $classA .'" href="'.$url.'" title="'. $title .'">首页</a></li>';
    }

    /**
     * 分页--尾页
     *
     * $url 首页地址
     * $title 栏目名称
     * $classLi li标签样式
     * $classA a标签样式
     *
     * @param int $countPage
     * @param string $url
     * @param string $title
     * @param string $classLi
     * @param string $classA
     * @return string
     */
    private static function pageLast(int $countPage, string $url, string $title, string $classLi, string $classA):string
    {
        if($countPage === 1){
            return '<li class="'. $classLi .'"><a class="'. $classA .'" href="'.$url.'" title="'. $title .'">尾页</a></li>';
        }else{
            $url = str_replace(page_suffix_message(),'', $url).'-'.$countPage.page_suffix_message();
            return '<li class="'. $classLi .'"><a class="'. $classA .'" href="'.$url.'" title="'. $title .'">尾页</a></li>';
        }
    }

    /**
     * 分页--之前页
     *
     * $current 当前页
     * $page 之前页( 1 之前一页  2 之前2页 ....)
     * $url 首页地址
     * $title 栏目名称
     * $classLi li标签样式
     * $classA a标签样式
     * $name 页面名称
     *
     * @param int $current
     * @param int $page
     * @param string $url
     * @param string $title
     * @param string $classLi
     * @param string $classA
     * @param string $name
     * @return string
     */
    private static function pageBefore(int $current, int $page, string $url, string $title, string $classLi, string $classA, string $name):string
    {
        $result = '';
        $before = (int)bcsub($current, $page, 0);
        $name = strlen($name) ? $name : $before;
        if($before > 0){
            if($before === 1){
                $result .= '<li class="'. $classLi .'"><a class="'. $classA .'" href="'. $url .'" title="'.$title .'">'. $name .'</a></li>';
            }else{
                $url = str_replace(page_suffix_message(),'', $url).'-'.$before.page_suffix_message();
                $result .= '<li class="'. $classLi .'"><a class="'. $classA .'" href="'. $url .'" title="'. $title .'">'. $name .'</a></li>';
            }
        }
        return $result;
    }

    /**
     * 分页--之后页
     *
     * $countPage 总页数
     * $current 当前页
     * $page 之后页( 1 之后一页  2 之后2页 ....)
     * $url 首页地址
     * $title 栏目名称
     * $classLi li标签样式
     * $classA a标签样式
     * $name 页面名称
     *
     * @param int $countPage
     * @param int $current
     * @param int $page
     * @param string $url
     * @param string $title
     * @param string $classLi
     * @param string $classA
     * @param string $name
     * @return string
     */
    private static function pageAfter(int $countPage, int $current, int $page, string $url, string $title, string $classLi, string $classA, string $name): string
    {
        $result = '';
        $after = (int)bcadd($current, $page, 0);
        $name = strlen($name) ? $name : $after;
        if($after <= $countPage){
            $url = str_replace(page_suffix_message(),'', $url).'-'.$after.page_suffix_message();
            $result .= '<li class="'. $classLi .'"><a class="'. $classA .'" href="'. $url .'" title="'. $title .'">'. $name .'</a></li>';
        }
        return $result;
    }
}