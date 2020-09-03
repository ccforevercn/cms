<?php
/**
 * @author: cc_forever<1253705861@qq.com>
 * @day: 2020/9/3
 */
namespace App\Http\Controllers\seo;

use App\CcForever\controller\BaseController;
use App\CcForever\extend\JsonExtend;
use App\CcForever\extend\SiteMapExtend;

/**
 * SiteMap控制器
 *
 * Class SiteMapController
 * @package App\Http\Controllers\seo
 */
class SiteMapController extends BaseController
{
    /**
     * 缓存网站地图HTML
     *
     * @return object
     */
    public function html(): object
    {
        $bool = SiteMapExtend::html();
        if($bool){
            return JsonExtend::success('缓存成功');
        }
        return JsonExtend::error('缓存失败');
    }

    /**
     * 缓存网站地图XML
     *
     * @return object
     */
    public function xml(): object
    {
        $bool = SiteMapExtend::xml();
        if($bool){
            return JsonExtend::success('缓存成功');
        }
        return JsonExtend::error('缓存失败');
    }

    /**
     * 缓存网站链接txt
     *
     * @return object
     */
    public function txt(): object
    {
        $bool = SiteMapExtend::txt();
        if($bool){
            return JsonExtend::success('缓存成功');
        }
        return JsonExtend::error('缓存失败');
    }
}
