<?php
/**
 * @author: cc_forever<1253705861@qq.com>
 * @day: 2020/8/29
 */

namespace App\Http\Controllers\seo;

use App\CcForever\controller\BaseController;
use App\CcForever\extend\JsonExtend;
use App\CcForever\extend\PageDataExtend;

/**
 * 缓存控制器
 *
 * Class CacheController
 * @package App\Http\Controllers\seo
 */
class CacheController extends BaseController
{
    /**
     * 首页缓存
     *
     * @return object
     * @throws \Throwable
     */
    public function index():object
    {
        $index = PageDataExtend::pageIndex(); // 首页数据
        $page = 'index';
        $path = 'pc/'.$page;// 需要生成的页面地址
        $string = view($path, $index)->__toString(); // 获取生成后的页面字符串
        $page = $page.page_suffix_message(); // 生成后的页面地址
        if(file_put_contents($page, $string)){
            return JsonExtend::success('缓存成功', compact('path'));
        }
    }

    /**
     * 栏目缓存
     *
     * @return object
     * @throws \Throwable
     */
    public function columns(): object
    {
        // 获取栏目编号
        $id = (int)app('request')->input('id', 0);
        $page = (int)app('request')->input('page', 1);
        $limit = (int)app('request')->input('limit', 10);
        // 栏目编号为0 缓存所有栏目页面
        if($id > 0){
            $columns = PageDataExtend::pageColumns($id, $page, $limit);
            // 栏目存在
            if(count($columns['column'])){
                $page = explode('/', $columns['column']['url'])[0];
                $path = 'pc/'.$page;// 需要生成的页面地址
                $string = view($path, $columns)->__toString(); // 获取生成后的页面字符串
                $page = $columns['column']['url']; // 生成后的页面地址
                if(file_put_contents($page, $string)){
                    return JsonExtend::success('缓存成功', compact('path'));
                }
            }
        }
        dd($id);
    }

    /**
     * 信息缓存
     *
     * @return object
     */
    public function message():object
    {

    }
}