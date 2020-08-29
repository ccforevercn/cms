<?php
/**
 * @author: cc_forever<1253705861@qq.com>
 * @day: 2020/8/29
 */

namespace App\CcForever\extend;

use App\Repositories\ColumnsRepository;
use App\Repositories\ConfigMessageRepository;

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
        self::pagePublic();
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
        $configs = $configMessageRepository::batch(['webname', 'website']);
        // 获取公共配置前缀
        $labelPrefixBool = $configMessageRepository::config('label_prefix');
        $labelPrefix = ''; // 公共配置前缀
        if($labelPrefixBool) list($labelPrefix) = $configMessageRepository::returnData(['']);
        $publicConfigs = []; // 公共配置
        foreach ($configs as $key=>$config){
            $publicConfigs[strtolower($labelPrefix.$configs[$key]['select'])] = $configs[$key]['value'];
        }
        // 导航
        $columnsRepository = new ColumnsRepository();
        $publicNavigation = $columnsRepository::navigation(); // 获取导航
        dd($publicNavigation);
        // 轮播图

        return compact('publicConfigs', 'publicNavigation');
    }
}