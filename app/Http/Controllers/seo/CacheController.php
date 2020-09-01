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
            // 缓存单个栏目
            $columns = PageDataExtend::pageColumns($id, $page, $limit);
            // 栏目存在
            if(count($columns['column'])){
                // 获取栏目模板文件
                $pages = explode('/', $columns['column']['url']);
                $sourcePath = 'pc/'; // 源文件
                $resourcesPath = ''; // 生成后的文件
                $fileName = ''; // 生成后的文件名
                foreach ($pages as $key=>&$page){
                    if((int)$key !== (int)bcsub(count($pages), 1, 0)){
                        // 获取文件目录
                        $sourcePath .= $page.'/';
                        $resourcesPath .= $page.'/';
                        if(!is_dir($resourcesPath)){
                            mkdir($resourcesPath, 0755);
                        }
                    }else{
                        // 获取文件名称
                        $fileName = $page;
                    }
                }

                // 截取源文件后面/
                $sourcePath = substr($sourcePath, 0 , bcsub(strlen($sourcePath), 1, 0));
                // 获取生成后的页面字符串
                $string = view($sourcePath, $columns)->__toString();
                // 生成静态文件
                // 打开文件，如果没有就创建
                $file = fopen($resourcesPath.$fileName, 'w+');
                // 写入页面
                fwrite($file, $string);
                // 关闭文件
                fclose($file);
                return JsonExtend::success('缓存成功', compact('path'));
            }
            return JsonExtend::error('栏目不存在');
        }else{
            // 全部栏目缓存


            return JsonExtend::error('栏目不存在');
        }
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