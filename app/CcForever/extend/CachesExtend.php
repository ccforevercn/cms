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
        $columnIds = $columnsRepository::columnsSelects(['id']);
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
        $columnIds = $columnsRepository::columnsSelects(['id']);
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
     * 搜索缓存
     *
     * @param string $urlPrefix
     * @param string $sourcePathPrefix
     * @return array
     * @throws \Throwable
     */
    public static function search(string $urlPrefix, string $sourcePathPrefix): array
    {
        $path = []; // 生成文件路径
        // 获取所有信息
        $search = PageDataExtend::pageSearch($urlPrefix);
        // 验证文件是否存在
        $searchPath = public_path('resources'.DIRECTORY_SEPARATOR.'search'.DIRECTORY_SEPARATOR);
        if(!is_dir(public_path('resources'.DIRECTORY_SEPARATOR))){
            mkdir(public_path('resources'.DIRECTORY_SEPARATOR), 0755);
        }
        if(!is_dir($searchPath)){
            mkdir($searchPath, 0755);
        }
        // 缓存到js文件中
        $message = json_encode($search['message'], JSON_UNESCAPED_UNICODE);
        $script = "var data = [];var html = '';function getQuerySelect(select){var query = window.location.search.substring(1);var selects = query.split(\"&\");for(var i = 0; i < selects.length; i++){var param = selects[i].split(\"=\");if (param[0] === select){return param[1];}}return false;}function search(){var name = decodeURIComponent(getQuerySelect('search'));if(name.length < 1 || name === false){document.getElementById('search').innerHTML = '暂无搜索内容';}else{document.getElementById('search').innerHTML = '搜索【' + decodeURIComponent(getQuerySelect('search')) + '】';for (let index in messages){if(messages[index].name.indexOf(name) >= 0){data.push(messages[index])}}}}";
        $script .= 'search();
    for (var index in data) {
        if(data[index].image.length > 0){
            html += \'<li>\';
            html += \' <a href="\' + data[index].url + \'" title="\' + data[index].name + \'" class="pic">\';
            html += \'<img class="lazy" src="\' + data[index].image + \'" alt="\' + data[index].name + \'">\';
            html += \'</a>\';
            html += \'<h2 class="title"><a href="\' + data[index].url + \'" title="\' + data[index].name + \'"><span class="top">热门</span></a></h2>\';
            html += \'<div class="date_hits">\';
            html += \'<span>\' + data[index].time + \'</span>\';
            html += \'<span><a href="javascript:void(0);">\' + data[index].name + \'</a></span>\';
            html += \'<span class="hits"><i class="layui-icon" title="点击量">&#xe62c;</i> \' + data[index].click + \' ℃</span>\';
            html += \'</div>\';
            html += \'<div class="desc">\' + data[index].description + \'</div>\';
            html += \'</li>\';
        }else{
            html += \'<li class="no_pic">\';
            html += \'<h2 class="title"><a href="\' + data[index].url + \'" title="\' + data[index].name + \'"><span class="top">热门</span></a></h2>\';
            html += \'<div class="date_hits">\';
            html += \'<span>\' + data[index].time + \'</span>\';
            html += \'<span><a href="javascript:void(0);">\' + data[index].name + \'</a></span>\';
            html += \'<span class="hits"><i class="layui-icon" title="点击量">&#xe62c;</i> \' + data[index].click + \' ℃</span>\';
            html += \'</div>\';
            html += \'<div class="desc">\' + data[index].description + \'</div>\';
            html += \'</li>\';
        }
    }
    document.getElementById(\'search-list\').insertAdjacentHTML(\'beforeend\', html);';
        $searchFile = 'search.js';
        if($urlPrefix !== '/'){
            $searchFile = 'wapsearch.js';
        }
        $file = @fopen($searchPath.$searchFile, 'w+');
        fwrite($file, 'var messages = '.$message.";".$script);
        fclose($file);
        // 缓存静态文件
        $search['search']['url'] = $urlPrefix.'search'.page_suffix_message();
        $path[] = self::write($search, 'search', $urlPrefix, $sourcePathPrefix);
        if(count($path)){
            // 缓存成功添加search.js到搜索页面
            $tpl = public_path($path[0]);
            $file = @fopen($tpl, 'r');
            if(!$file) return $path;
            $searchContent = fread($file, filesize($tpl));
            fclose($file);
            $searchContent = str_replace("</body>", "<script type='text/javascript' src=\"/resources/search/".$searchFile."\"></script>\r\n</body>", $searchContent);
            $file = @fopen($tpl, 'w+');
            fwrite($file, $searchContent);
            fclose($file);
        }
        return $path;
    }


    /**
     * 静态文件写入
     *
     * $data  数据
     * $key   数据中的key
     * $urlPrefix 地址前缀
     * $sourcePathPrefix 缓存源文件前缀
     *
     * @param array $data
     * @param string $key
     * @param string $urlPrefix
     * @param string $sourcePathPrefix
     * @return string
     * @throws \Throwable
     */
    private static function write(array $data, string $key, string $urlPrefix, string $sourcePathPrefix): string
    {
        // 替换模板文件前缀(地址前缀)
        $pages = str_replace($urlPrefix, '/', $data[$key]['url']);
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
                $resourcesPath .= $url.DIRECTORY_SEPARATOR;
                if(!is_dir($resourcesPath)){
                    mkdir($resourcesPath, 0755);
                }
            }
        }
        // 获取源文件地址和生成后文件地址
        foreach ($pages as $loop=>&$page){
            if((int)$loop !== (int)bcsub(count($pages), 1, 0)){
                // 获取文件目录
                $sourcePath .= $page.DIRECTORY_SEPARATOR;
                $resourcesPath .= $page.DIRECTORY_SEPARATOR;
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
        if($key === 'index'){ $sourcePath .= DIRECTORY_SEPARATOR.'index'; }
        if($key === 'search'){ $sourcePath .= DIRECTORY_SEPARATOR.'search'; }
        try{
            // 获取生成后的页面字符串
            $string = view($sourcePath, $data)->__toString();
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
            dd($exception->getMessage(), $exception->getLine());
            return '';
        }
    }
}