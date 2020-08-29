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
        $pagePublic = self::pagePublic();
        // 友情链接
        $linksRepository = new LinksRepository();
        $links = $linksRepository::links();
        // 合作伙伴
        // 分站

        dd($pagePublic, $links);
    }

    /**
     * 栏目
     *
     * @param int $id
     * @param int $page
     * @param int $limit
     * @return array
     */
    public static function pageColumns(int $id, int $page, int $limit): array
    {

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
        $configList = $configMessageRepository::batch(['webname', 'website']);
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