<?php
/**
 * @author: cc_forever<1253705861@qq.com>
 * @day: 2020/9/7
 */

namespace App\CcForever\extend;

use App\Repositories\ColumnsRepository;

/**
 * 缓存静态页面
 *
 * Class CachesExtend
 * @package App\CcForever\extend
 */
class CachesExtend
{
    /**
     * 设置分站
     *
     * @param string $substation
     * @param string $unique
     */
    public static function substation(string $substation, string $unique): void
    {
        PageDataExtend::SetSubstation($substation, $unique);
    }
    /**
     * 首页缓存
     *
     * $urlPrefix   地址前缀
     * $sourcePathPrefix  源文件前缀
     *
     * @param string $urlPrefix
     * @param string $sourcePathPrefix
     * @return array
     * @throws \Throwable
     */
    public static function index(string  $urlPrefix, string $sourcePathPrefix): array
    {
        // 生成文件地址
        $path = [];
        // 首页数据
        $index = PageDataExtend::pageIndex($urlPrefix);
        // 添加首页地址
        $index['index']['url'] = $urlPrefix.'index'.page_suffix_message();
        // 缓存静态文件
        $path[] = self::write($index, 'index', $urlPrefix, $sourcePathPrefix);
        return $path;
    }

    /**
     * 栏目缓存
     *
     * $id 栏目编号
     * $urlPrefix   地址前缀
     * $sourcePathPrefix  源文件前缀
     *
     * @param int $id
     * @param string $urlPrefix
     * @param string $sourcePathPrefix
     * @return array
     * @throws \Throwable
     */
    public static function columns(int $id, string  $urlPrefix, string $sourcePathPrefix): array
    {
        // 生成页面地址
        $path = [];
        // 栏目编号为0 缓存所有栏目页面
        if($id > 0){
            // 缓存单个栏目
            $columns = PageDataExtend::pageColumns($id, $urlPrefix);
            // 栏目不存在
            if(!count($columns)){ return $path; }
            // 栏目存在
            foreach ($columns as &$column){
                $path[] = self::write($column, 'column', $urlPrefix, $sourcePathPrefix);
            }
            return $path;
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
                    $path[] = self::write($column, 'column', $urlPrefix, $sourcePathPrefix);
                }
            }
        }
        return $path;
    }

    /**
     * 信息缓存
     *
     * $id 栏目编号
     * $urlPrefix   地址前缀
     * $sourcePathPrefix  源文件前缀
     *
     * @param int $id
     * @param string $urlPrefix
     * @param string $sourcePathPrefix
     * @return array
     * @throws \Throwable
     */
    public static function message(int $id, string  $urlPrefix, string $sourcePathPrefix):array
    {
        // 生成页面地址
        $path = [];
        // 缓存单个栏目下的信息
        if($id > 0){
            $messages = PageDataExtend::pageMessage($id, $urlPrefix);
            if(!count($messages)) { return $path; }
            foreach ($messages as &$message){
                $path[] = self::write($message, 'message', $urlPrefix, $sourcePathPrefix);
            }
            return $path;
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
                    $path[] = self::write($message, 'message', $urlPrefix, $sourcePathPrefix);
                }
            }
        }
        return $path;
    }


    /**
     * 静态文件写入
     *
     * $date  数据
     * $key   数据中的key
     * $urlPrefix 地址前缀
     * $sourcePathPrefix 缓存源文件前缀
     *
     * @param array $date
     * @param string $key
     * @param string $urlPrefix
     * @param string $sourcePathPrefix
     * @return string
     * @throws \Throwable
     */
    private static function write(array $date, string $key, string $urlPrefix, string $sourcePathPrefix): string
    {
        // 替换模板文件前缀(地址前缀)
        $pages = str_replace($urlPrefix, '/', $date[$key]['url']);
        // 使用/分割源文件地址
        $pages = explode('/', $pages);
        // 删除第一个键值(空串)
        $pages = array_slice($pages, 1);
        // 获取原文件前缀
        $sourcePath = $sourcePathPrefix; // 源文件
        $resourcesPath = ''; // 生成后的文件
        $fileName = ''; // 生成后的文件名
        // 使用/分割地址前缀
        $urlPrefixArr = explode('/', $urlPrefix);
        // 删除第一个元素
        array_shift($urlPrefixArr);
        // 删除最后一个元素
        array_pop($urlPrefixArr);
        // 地址前缀存在时
        if(count($urlPrefixArr)){
            // 追加到生成后的文件地址路径
            foreach ($urlPrefixArr as &$url){
                $resourcesPath .= $url.'/';
                if(!is_dir($resourcesPath)){
                    mkdir($resourcesPath, 0755);
                }
            }
        }
        // 获取源文件地址和生成后文件地址
        foreach ($pages as $loop=>&$page){
            if((int)$loop !== (int)bcsub(count($pages), 1, 0)){
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
        // 截取源文件后面
        $sourcePath = substr($sourcePath, 0 , bcsub(strlen($sourcePath), 1, 0));
        // 首页缓存时添加index
        if($key === 'index'){ $sourcePath .= '/index'; }
        try{
            // 获取生成后的页面字符串
            $string = view($sourcePath, $date)->__toString();
            // 生成静态文件
            // 打开文件，如果没有就创建
            $file = @fopen($resourcesPath.$fileName, 'w+');
            if(!$file) return '';
            // 写入页面
            fwrite($file, $string);
            // 关闭文件
            fclose($file);
            return $resourcesPath.$fileName;
        }catch (\Exception $exception){
            return '';
        }
    }
}