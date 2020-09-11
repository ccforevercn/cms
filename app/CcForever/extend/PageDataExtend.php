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
use App\Repositories\MessagesRepository;
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
     * 分站名称
     *
     * @var string
     */
    private static $substation_name = '';

    /**
     * 分站链接
     *
     * @var string
     */
    private static $substation_link = '/';

    /**
     * 设置分站
     *
     * @param string $substation
     * @param string $unique
     */
    public static function SetSubstation(string $substation, string $unique): void
    {
        self::$substation_name = $substation;
        self::$substation_link .= $unique;
    }

    /**
     * 获取分站名称
     *
     * @return string
     */
    public static function GetSubstationName(): string
    {
        return self::$substation_name;
    }

    /**
     * 首页数据
     *
     * @param string $urlPrefix
     * @return array
     */
    public static function pageIndex(string $urlPrefix): array
    {
        // 公共配置
        $public = self::pagePublic($urlPrefix);
        $configs = $public['configs']; // 全局配置
        $navigation = $public['navigation']; // 导航
        $banners = $public['banners']; // PC端banner
        $bannersWap = $public['bannersWap']; // WAP端banner
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
        return compact('configs', 'navigation', 'banners', 'bannersWap', 'links', 'partners', 'substation', 'navigationId');
    }

    /**
     * 栏目数据
     *
     * @param int $id
     * @param string $urlPrefix
     * @return array
     */
    public static function pageColumns(int $id, string $urlPrefix): array
    {
        // 公共配置
        $public = self::pagePublic($urlPrefix);
        $configs = $public['configs']; // 全局配置
        $navigation = $public['navigation']; // 导航
        $banners = $public['banners']; // PC端banner
        $bannersWap = $public['bannersWap']; // WAP端banner
        // 当前导航编号
        $navigationId = $id;
        // 信息列表
        $messages = [];
        // 返回数据
        $result = [];
        // 当前页
        $page = 1;
        // 获取栏目信息
        $column = ColumnsExtend::column($id, true, $urlPrefix);
        // 栏目存在时
        if(count($column) && !$column['render']){
            // 获取当前栏目的顶级栏目
            $columnTop = $column;
            if($column['parent_id']){
                // 当前栏目非顶级栏目时重置顶级栏目数据
                $columnsRepository = new ColumnsRepository();
                $topId = $columnsRepository::topColumnId($id);
                $navigationId = $topId;
                $columnTop = ColumnsExtend::column($topId, true, $urlPrefix);
            }  // 公共配置
            $configMessageRepository = new ConfigMessageRepository();
            // 获取公共配置前缀
            $labelPrefixBool = $configMessageRepository::config('label_prefix');
            $labelPrefix = ''; // 公共配置前缀
            if($labelPrefixBool) list($labelPrefix) = $configMessageRepository::returnData(['']);
            // 重置网站栏目标题
            if(array_key_exists($labelPrefix.'title', $public['configs'])){
                $public['configs'][$labelPrefix.'title'] = $column['name'].$public['configs'][$labelPrefix.'title'];
            }
            // 重置网站栏目关键字
            if(array_key_exists($labelPrefix.'keyword', $public['configs'])){
                $public['configs'][$labelPrefix.'keyword'] = $column['keywords'].$public['configs'][$labelPrefix.'keyword'];
            }
            // 重置网站栏目描述
            if(array_key_exists($labelPrefix.'description', $public['configs'])){
                $public['configs'][$labelPrefix.'description'] = $column['description'].$public['configs'][$labelPrefix.'description'];
            }
            $crumbs = ''; // 面包销导航
            $crumbs .= "<a href='{$public['configs'][$labelPrefix.'website']}' title='{$public['configs'][$labelPrefix.'name']}'>首页</a>>";
            $crumbs .= "<a href='{$columnTop['url']}' title='{$columnTop['name']}'>{$columnTop['name']}</a>>";
            if($columnTop['unique'] !== $column['unique']){
                $crumbs .= "<a href='{$column['url']}' title='{$column['name']}'>{$column['name']}</a>";
            }
            // 当前栏目的顶级栏目的子栏目信息
            $children  = ColumnsExtend::children($columnTop['unique'], 0, $urlPrefix);
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
                        $messages = MessagesExtend::messageList($columnsMessagesOrderAndLoopIds['columnIds'], $columnsMessagesOrderAndLoopIds['order'], $offset, $limit, $messagesType, $urlPrefix);
                        $result[] = compact('configs', 'navigation', 'banners', 'bannersWap', 'column', 'page', 'columnTop', 'children', 'crumbs', 'messages', 'navigationId');
                    }
                    return $result;
                }
            }
            $result[] = compact('configs', 'navigation', 'banners', 'bannersWap', 'column', 'columnTop', 'page', 'children', 'crumbs', 'messages', 'navigationId');
        }
        return $result;
    }

    /**
     * 信息数据
     *
     * @param int $id
     * @param string $urlPrefix
     * @return array
     */
    public static function pageMessage(int $id, string $urlPrefix): array
    {
        // 返回数据
        $result = [];
        // 公共配置
        $public = self::pagePublic($urlPrefix);
        $configs = $public['configs']; // 全局配置
        $navigation = $public['navigation']; // 导航
        $banners = $public['banners']; // PC端banner
        $bannersWap = $public['bannersWap']; // WAP端banner
        // 导航编号
        $navigationId = $id;
        // 栏目信息
        $column = ColumnsExtend::column($id, true, $urlPrefix);
        // 栏目不存在
        if(!count($column)) return $result;
        // 当前栏目下的所有文章
        $messages = MessagesExtend::message($id, $column['sort'], $urlPrefix);
        // 文章不存在
        if(!count($messages)) return $result;
        // 顶级栏目
        $columnTop = $column;
        if($column['parent_id']){
            // 当前栏目非顶级栏目时重置顶级栏目数据
            $columnsRepository = new ColumnsRepository();
            $topId = $columnsRepository::topColumnId($id);
            $navigationId = $topId;
            $columnTop = ColumnsExtend::column($topId, true, $urlPrefix);
        }
        // 当前栏目的顶级栏目的子栏目信息
        $children  = ColumnsExtend::children($columnTop['unique'], 0, $urlPrefix);
        // 公共配置
        $configMessageRepository = new ConfigMessageRepository();
        // 获取公共配置前缀
        $labelPrefixBool = $configMessageRepository::config('label_prefix');
        $labelPrefix = ''; // 公共配置前缀
        if($labelPrefixBool) list($labelPrefix) = $configMessageRepository::returnData(['']);
        foreach ($messages as $message){
            // 重置网站信息标题
            if(array_key_exists($labelPrefix.'title', $public['configs'])){
                $public['configs'][$labelPrefix.'title'] = $message['name'].$public['configs'][$labelPrefix.'title'];
            }
            // 重置网站信息关键字
            if(array_key_exists($labelPrefix.'keyword', $public['configs'])){
                $public['configs'][$labelPrefix.'keyword'] = $message['keywords'].$public['configs'][$labelPrefix.'keyword'];
            }
            // 重置网站信息描述
            if(array_key_exists($labelPrefix.'description', $public['configs'])){
                $public['configs'][$labelPrefix.'description'] = $message['description'].$public['configs'][$labelPrefix.'description'];
            }
            $crumbs = ''; // 面包销导航
            $crumbs .= "<a href='{$public['configs'][$labelPrefix.'website']}' title='{$public['configs'][$labelPrefix.'name']}'>首页</a>>";
            $crumbs .= "<a href='{$columnTop['url']}' title='{$columnTop['name']}'>{$columnTop['name']}</a>>";
            if($columnTop['unique'] !== $column['unique']){
                $crumbs .= "<a href='{$column['url']}' title='{$column['name']}'>{$column['name']}</a>>";
            }
            $crumbs .= "<a href='{$message['url']}' title='{$message['name']}'>{$message['name']}</a>";
            $result[] = compact('configs', 'navigation', 'banners', 'bannersWap', 'column', 'columnTop', 'children', 'crumbs', 'message', 'navigationId');
        }
        return $result;
    }

    /**
     * 搜索页数据
     *
     * @param string $urlPrefix
     * @return array
     */
    public static function pageSearch(string  $urlPrefix): array
    {
        // 公共配置
        $public = self::pagePublic($urlPrefix);
        $configs = $public['configs']; // 全局配置
        $navigation = $public['navigation']; // 导航
        $banners = $public['banners']; // PC端banner
        $bannersWap = $public['bannersWap']; // WAP端banner
        // 导航编号
        $navigationId = -1;
        // 实例化MessagesRepository
        $messagesRepository = new MessagesRepository();
        // 获取所有已发布的信息
        $messages = $messagesRepository::messagesSelects($messagesRepository::GetModel()::GetMessage());
        // 获取需要的信息数据
        foreach ($messages as $key=>&$item){
            $message[$key]['name'] = $item['name'];
            $message[$key]['image'] = $item['image'];
            $message[$key]['writer'] = $item['writer'];
            $message[$key]['click'] = $item['click'];
            $message[$key]['keywords'] = $item['keywords'];
            $message[$key]['description'] = $item['description'];
            $message[$key]['update_time'] = $item['update_time'];
            $message[$key]['time'] = date('Y-m-d H:i', $item['update_time']);
            $message[$key]['url'] = $urlPrefix.$item['page'].'/'.$item['id'].page_suffix_message();
        }
        return compact('configs', 'navigation', 'banners', 'bannersWap', 'message', 'navigationId');
    }

    /**
     * 公共数据
     *
     * @param string $urlPrefix
     * @return array
     */
    public static function pagePublic(string $urlPrefix): array
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
        // 添加自动跳转wap端
        if((int)config('ccforever.config.wap_type') && array_key_exists($labelPrefix.'pc_top_code', $configs)){
            $configs[$labelPrefix.'pc_top_code'] .= $configs[$labelPrefix.'pc_top_code'].automatic_skip_wap($configs[$labelPrefix.'website']);
        }
        // 域名追加分站地址
        if(array_key_exists($labelPrefix.'website', $configs)){
            $configs[$labelPrefix.'website'] = $configs[$labelPrefix.'website'].self::$substation_link;
        }
        // 分站名称添加到配置中
        $configs[$labelPrefix.'substation_name'] = self::$substation_name;
        // 分站地址前缀添加到配置中
        $configs[$labelPrefix.'substation_link'] = self::$substation_link;
        // 实例化ColumnsRepository
        $columnsRepository = new ColumnsRepository();
        // 获取导航
        $navigation = $columnsRepository::navigation($urlPrefix);
        // 实例化BannersRepository
        $bannersRepository = new BannersRepository();
        // 获取banners
        $banners = $bannersRepository::banners(1);
        // 获取banners
        $bannersWap = $bannersRepository::banners(2);
        return compact('configs', 'navigation', 'banners', 'bannersWap');
    }
}