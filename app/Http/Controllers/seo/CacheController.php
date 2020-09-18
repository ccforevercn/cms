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
        // 地址前缀
        $urlPrefix = app('request')->input('url', '/');
        // 地址前缀错误
        if(!in_array($urlPrefix, ['/', '/wap/'])){
            return JsonExtend::error('缓存失败，没有可缓存的页面');
        }
        // 源文件前缀
        $sourcePathPrefix = app('request')->input('source', 'pc');
        // 源文件前缀错误
        if(!in_array($sourcePathPrefix, ['pc', 'wap'])){
            return JsonExtend::error('缓存失败，没有可缓存的页面');
        }
        $sourcePathPrefix = $sourcePathPrefix.DIRECTORY_SEPARATOR;
        CachesExtend::substation('', substr($urlPrefix, 1, strlen($urlPrefix)));
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
        $urlPrefix = app('request')->input('url', '/');
        // 地址前缀错误
        if(!in_array($urlPrefix, ['/', '/wap/'])){
            return JsonExtend::error('缓存失败，没有可缓存的页面');
        }
        // 源文件前缀
        $sourcePathPrefix = app('request')->input('source', 'pc');
        // 源文件前缀错误
        if(!in_array($sourcePathPrefix, ['pc', 'wap'])){
            return JsonExtend::error('缓存失败，没有可缓存的页面');
        }
        $sourcePathPrefix = $sourcePathPrefix.DIRECTORY_SEPARATOR;
        // 获取栏目编号
        $id = (int)app('request')->input('id', 0);
        CachesExtend::substation('', substr($urlPrefix, 1, strlen($urlPrefix)));
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
        // 地址前缀
        $urlPrefix = app('request')->input('url', '/');
        // 地址前缀错误
        if(!in_array($urlPrefix, ['/', '/wap/'])){
            return JsonExtend::error('缓存失败，没有可缓存的页面');
        }
        // 源文件前缀
        $sourcePathPrefix = app('request')->input('source', 'pc');
        // 源文件前缀错误
        if(!in_array($sourcePathPrefix, ['pc', 'wap'])){
            return JsonExtend::error('缓存失败，没有可缓存的页面');
        }
        $sourcePathPrefix = $sourcePathPrefix.DIRECTORY_SEPARATOR;
        // 栏目编号
        $id = (int)app('request')->input('id', 0);
        CachesExtend::substation('', substr($urlPrefix, 1, strlen($urlPrefix)));
        // 缓存信息
        $path = CachesExtend::message($id, $urlPrefix, $sourcePathPrefix);
        if(count($path)){
            return JsonExtend::success('缓存成功', $path);
        }else{
            return JsonExtend::error('缓存失败，没有可缓存的页面');
        }
    }

    /**
     * 搜索页缓存
     *
     * @return object
     * @throws \Throwable
     */
    public function search():object
    {
        // 地址前缀
        $urlPrefix = app('request')->input('url', '/');
        // 地址前缀错误
        if(!in_array($urlPrefix, ['/', '/wap/'])){
            return JsonExtend::error('缓存失败，没有可缓存的页面');
        }
        // 源文件前缀
        $sourcePathPrefix = app('request')->input('source', 'pc');
        // 源文件前缀错误
        if(!in_array($sourcePathPrefix, ['pc', 'wap'])){
            return JsonExtend::error('缓存失败，没有可缓存的页面');
        }
        $sourcePathPrefix = $sourcePathPrefix.DIRECTORY_SEPARATOR;
        CachesExtend::substation('', substr($urlPrefix, 1, strlen($urlPrefix)));
        $path = CachesExtend::search($urlPrefix, $sourcePathPrefix);
        if(count($path)){
            return JsonExtend::success('缓存成功', $path);
        }else{
            return JsonExtend::error('缓存失败，没有可缓存的页面');
        }
    }
}