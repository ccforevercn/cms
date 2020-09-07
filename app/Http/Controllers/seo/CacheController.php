<?php
/**
 * @author: cc_forever<1253705861@qq.com>
 * @day: 2020/8/29
 */

namespace App\Http\Controllers\seo;

use App\CcForever\controller\BaseController;
use App\CcForever\extend\CachesExtend;
use App\CcForever\extend\JsonExtend;

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
        $urlPrefix = '/'; // 地址前缀
        $sourcePathPrefix = 'pc/'; // 源文件前缀
        // 缓存首页
        $path = CachesExtend::index($urlPrefix, $sourcePathPrefix);
        return JsonExtend::success('缓存成功', $path);
    }

    /**
     * 栏目缓存
     *
     * @return object
     * @throws \Throwable
     */
    public function columns(): object
    {
        // 地址前缀
        $urlPrefix = '/';
        // 源文件前缀
        $sourcePathPrefix = 'pc/';
        // 获取栏目编号
        $id = (int)app('request')->input('id', 0);
        // 缓存栏目
        $path = CachesExtend::columns($id, $urlPrefix, $sourcePathPrefix);
        if(count($path)){
            return JsonExtend::success('缓存成功', $path);
        }else{
            return JsonExtend::error('缓存失败，没有可缓存的页面');
        }
    }

    /**
     * 信息缓存
     *
     * @return object
     * @throws \Throwable
     */
    public function message():object
    {
        $urlPrefix = '/'; // 地址前缀
        $sourcePathPrefix = 'pc/'; // 源文件前缀
        // 栏目编号
        $id = (int)app('request')->input('id', 0);
        // 缓存信息
        $path = CachesExtend::message($id, $urlPrefix, $sourcePathPrefix);
        if(count($path)){
            return JsonExtend::success('缓存成功', $path);
        }else{
            return JsonExtend::error('缓存失败，没有可缓存的页面');
        }
    }
}