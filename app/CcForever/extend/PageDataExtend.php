<?php
/**
 * @author: cc_forever<1253705861@qq.com>
 * @day: 2020/8/29
 */

namespace App\CcForever\extend;

use App\Repositories\BannersRepository;
use App\Repositories\ColumnsRepository;
use App\Repositories\ConfigMessageRepository;
use App\Repositories\LinksRepository;
use App\Repositories\PartnersRepository;

/**
 * 页面数据
 *
 * Class PageDataExtend
 * @package App\CcForever\extend
 */
class PageDataExtend
{
    /**
     * 首页
     *
     * @return array
     */
    public static function pageIndex(): array
    {
        // 公共配置
        $public = self::pagePublic();
        // 友情链接
        $linksRepository = new LinksRepository();
        $links = $linksRepository::links();
        // 合作伙伴
        $partnersRepository = new PartnersRepository();
        $partners = $partnersRepository::partners();
        // 分站
        $substation = [];
        // 导航编号
        $navigationId = 0;
        return compact('public', 'links', 'partners', 'substation', 'navigationId');
    }

    /**
     * 栏目
     *
     * @param int $id
     * @return array
     */
    public static function pageColumns(int $id): array
    {
        // 公共配置
        $public = self::pagePublic();
        // 当前导航编号
        $navigationId = $id;
        // 信息列表
        $messages = [];
        // 返回数据
        $result = [];
        // 当前页
        $page = 1;
        // 获取栏目信息
        $column = ColumnsExtend::column($id, true);
        // 栏目存在时
        if(count($column) && !$column['render']){
            // 获取当前栏目的顶级栏目
            $columnTop = $column;
            if($column['parent_id']){
                // 当前栏目非顶级栏目时重置顶级栏目数据
                $columnsRepository = new ColumnsRepository();
                $topId = $columnsRepository::topColumnId($id);
                $navigationId = $topId;
                $columnTop = ColumnsExtend::column($topId, true);
            }
            // 当前栏目的顶级栏目的子栏目信息
            $children  = ColumnsExtend::children($columnTop['unique'], 0);
            // 获取 栏目排序和下级编号+
            $columnsMessagesOrderAndLoopIds = ColumnsExtend::columnsMessagesOrderAndLoopIds($id ,true);
            // 获取每页条数
            $limit = $column['limit'];
            if($limit){  // limit不为0时分页处理
                // 信息类型 1 首页推荐 2 热门推荐 3 所有
                $messagesType = 3;
                // 获取总页数
                $countPage = MessagesExtend::messagesCountPage($columnsMessagesOrderAndLoopIds['columnIds'], $messagesType, $limit);
                if($countPage){
                    $url = $column['url'];
                    for ($page = 1; $page <= $countPage; $page++){
                        // 获取起始值
                        $offset = page_to_offset($page, $limit);
                        // 信息页数大于1时
                        if($page > 1){
                            // 页数大于1时修改页面地址
                            $column['url'] =  str_replace(page_suffix_message(),'', $url).'-'.$page.page_suffix_message();
                        }
                        // 栏目文章
                        $messages = MessagesExtend::messageList($columnsMessagesOrderAndLoopIds['columnIds'], $columnsMessagesOrderAndLoopIds['order'], $offset, $limit, $messagesType);
                        $result[] = compact('public', 'column', 'page', 'columnTop', 'children', 'messages', 'navigationId');
                    }
                    return $result;
                }
            }
            $result[] = compact('public', 'column', 'columnTop', 'page', 'children', 'messages', 'navigationId');
        }
        return $result;
    }

    /**
     * 信息
     *
     * @param int $id
     * @return array
     */
    public static function pageMessage(int $id): array
    {
        // 返回数据
        $result = [];
        // 公共配置
        $public = self::pagePublic();
        // 导航编号
        $navigationId = $id;
        // 栏目信息
        $column = ColumnsExtend::column($id, true);
        // 栏目不存在
        if(!count($column)) return $result;
        // 当前栏目下的所有文章
        $messages = MessagesExtend::message($id, $column['sort']);
        // 文章不存在
        if(!count($messages)) return $result;
        // 顶级栏目
        $columnTop = $column;
        if($column['parent_id']){
            // 当前栏目非顶级栏目时重置顶级栏目数据
            $columnsRepository = new ColumnsRepository();
            $topId = $columnsRepository::topColumnId($id);
            $navigationId = $topId;
            $columnTop = ColumnsExtend::column($topId, true);
        }
        // 当前栏目的顶级栏目的子栏目信息
        $children  = ColumnsExtend::children($columnTop['unique'], 0);
        foreach ($messages as $message){
            $result[] = compact('public', 'column', 'columnTop', 'children', 'message', 'navigationId');
        }
        return $result;
    }

    /**
     * 公共
     *
     * @return array
     */
    public static function pagePublic(): array
    {
        // 公共配置
        $configMessageRepository = new ConfigMessageRepository();
        // 获取公共配置
        $configList = $configMessageRepository::batch(explode(',', config('ccforever.config.unique_list')));
        // 获取公共配置前缀
        $labelPrefixBool = $configMessageRepository::config('label_prefix');
        $labelPrefix = ''; // 公共配置前缀
        if($labelPrefixBool) list($labelPrefix) = $configMessageRepository::returnData(['']);
        $configs = []; // 配置
        foreach ($configList as &$config){
            $configs[strtolower($labelPrefix.$config['select'])] = $config['value'];
        }
        // 导航
        $columnsRepository = new ColumnsRepository();
        $navigation = $columnsRepository::navigation(); // 获取导航
        // 轮播图
        $bannersRepository = new BannersRepository();
        $banners = $bannersRepository::banners(1);
        return compact('configs', 'navigation', 'banners');
    }

    /**
     * 静态文件写入
     *
     * @param array $date
     * @param string $key
     * @return string
     * @throws \Throwable
     */
    public static function pageWrite(array $date, string $key): string
    {
        // 获取栏目模板文件
        $pages = explode('/', $date[$key]['url']);
        $pages = array_slice($pages, 1);
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
        // 截取源文件后面
        $sourcePath = substr($sourcePath, 0 , bcsub(strlen($sourcePath), 1, 0));
        // 获取生成后的页面字符串
        $string = view($sourcePath, $date)->__toString();
        // 生成静态文件
        // 打开文件，如果没有就创建
        $file = fopen($resourcesPath.$fileName, 'w+');
        // 写入页面
        fwrite($file, $string);
        // 关闭文件
        fclose($file);
        return $resourcesPath.$fileName;
    }
}