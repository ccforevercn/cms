<?php
/**
 * @author: cc_forever<1253705861@qq.com>
 * @day: 2020/8/29
 */

namespace App\Http\Controllers\seo;

use App\CcForever\controller\BaseController;
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
     */
    public function index():object
    {
        $index = PageDataExtend::pageIndex();
        dd($index);

//        $id = 0;
//        $string = view('index/default/index', compact('id'))->__toString();
//        file_put_contents("demo.html", $string);

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