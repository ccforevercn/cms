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
                // 实例化MessagesRepository
                $messagesRepository = new MessagesRepository();
                // 获取信息总条数
                $messagesCount = $messagesRepository::messagesCount($columnsMessagesOrderAndLoopIds['columnIds'], $messagesType);
                // 计算信息总页数
                $countPage = (int)ceil(floatval(bcdiv($messagesCount, $limit, 2)));
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
                        $result[] = compact('public', 'column', 'columnTop', 'children', 'messages', 'navigationId');
                    }
                    return $result;
                }
            }
            $result[] = compact('public', 'column', 'columnTop', 'children', 'messages', 'navigationId');
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
}