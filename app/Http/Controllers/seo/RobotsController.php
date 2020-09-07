<?php
/**
 * @author: cc_forever<1253705861@qq.com>
 * @day: 2020/9/3
 */
namespace App\Http\Controllers\seo;

use App\CcForever\controller\BaseController;
use App\CcForever\extend\JsonExtend;
use App\CcForever\extend\RobotsExtend;

/**
 * Robots控制器
 *
 * Class RobotsController
 * @package App\Http\Controllers\seo
 */
class RobotsController extends BaseController
{
    /**
     * robots内容获取
     *
     * @return object
     */
    public function content(): object
    {
        $content = RobotsExtend::content();
        return JsonExtend::success('robots内容获取', ['content'=> $content]);
    }

    /**
     * robots内容修改
     *
     * @return object
     */
    public function update(): object
    {
        $content = app('request')->input('content', '');
        if(is_null($content)){
            return JsonExtend::error('修改失败');
        }
        $bool = RobotsExtend::update($content);
        if($bool){
            return JsonExtend::success('修改成功');
        }
        return JsonExtend::error('修改失败，有非法字符(不能输入汉字)');
    }
}
