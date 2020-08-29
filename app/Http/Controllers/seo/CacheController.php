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
        $path = 'pc/index';// 需要生成的页面地址
        $string = view($path, $index)->__toString(); // 获取生成后的页面字符串
        $page = 'index.html'; // 生成后的页面地址
        if(file_put_contents($page, $string)){
            return JsonExtend::success('缓存成功', compact('path'));
        }
    }

    /**
     * 栏目缓存
     *
     * @return object
     */
    public function columns(): object
    {

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