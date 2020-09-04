<?php
/**
 * @author: cc_forever<1253705861@qq.com>
 * @day: 2020/8/29
 */

namespace App\Http\Controllers\seo;

use App\CcForever\controller\BaseController;
use App\CcForever\extend\JsonExtend;
use App\CcForever\extend\PageDataExtend;
use App\Repositories\ColumnsRepository;

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
        $urlPrefix = '/';
        // 源文件前缀
        $sourcePathPrefix = 'pc/';
        // 生成文件地址
        $path = [];
        // 首页数据
        $index = PageDataExtend::pageIndex($urlPrefix);
        // 添加首页地址
        $index['index']['url'] = $urlPrefix.'index'.page_suffix_message();
        // 缓存静态文件
        $path[] = PageDataExtend::pageWrite($index, 'index', $urlPrefix, $sourcePathPrefix);
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
        // 栏目编号为0 缓存所有栏目页面
        if($id > 0){
            // 缓存单个栏目
            $columns = PageDataExtend::pageColumns($id, $urlPrefix);
            // 生成页面地址
            $path = [];
            // 栏目不存在
            if(!count($columns)){ return JsonExtend::error('栏目不存在(外链页面不能缓存)'); }
            // 栏目存在
            foreach ($columns as &$column){
                $path[] = PageDataExtend::pageWrite($column, 'column', $urlPrefix, $sourcePathPrefix);
            }
            return JsonExtend::success('缓存成功', $path);
        }
        // 全部栏目缓存
        $columnsRepository = new ColumnsRepository();
        // 获取页面栏目编号
        $columnIds = $columnsRepository::pageColumnsIds(['id']);
        // 生成页面地址
        $path = [];
        // 循环缓存栏目
        for ($loop = 0; $loop < count($columnIds);  $loop++){
            // 缓存单个栏目
            $columns = PageDataExtend::pageColumns($columnIds[$loop], $urlPrefix);
            // 栏目存在
            if(count($columns)){
                foreach ($columns as &$column){
                    $path[] = PageDataExtend::pageWrite($column, 'column', $urlPrefix, $sourcePathPrefix);
                }
            }
        }
        return JsonExtend::success('缓存成功', $path);
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
        $urlPrefix = '/';
        // 源文件前缀
        $sourcePathPrefix = 'pc/';
        $id = (int)app('request')->input('id', 0);
        // 缓存单个栏目下的信息
        if($id > 0){
            $messages = PageDataExtend::pageMessage($id, $urlPrefix);
            if(!count($messages)) { return JsonExtend::error('当前栏目下暂无信息'); }
            // 生成页面地址
            $path = [];
            foreach ($messages as &$message){
                $path[] = PageDataExtend::pageWrite($message, 'message', $urlPrefix, $sourcePathPrefix);
            }
            return JsonExtend::success('缓存成功', $path);
        }
        // 全部栏目下的信息缓存
        $columnsRepository = new ColumnsRepository();
        // 获取页面栏目编号
        $columnIds = $columnsRepository::pageColumnsIds(['id']);
        // 生成页面地址
        $path = [];
        // 循环缓存栏目
        for ($loop = 0; $loop < count($columnIds);  $loop++){
            // 缓存单个栏目下的信息
            $messages = PageDataExtend::pageMessage($columnIds[$loop], $urlPrefix);
            if(count($messages)){
                foreach ($messages as &$message){
                    $path[] = PageDataExtend::pageWrite($message, 'message', $urlPrefix, $sourcePathPrefix);
                }
            }
        }
        return JsonExtend::success('缓存成功', $path);
    }
}