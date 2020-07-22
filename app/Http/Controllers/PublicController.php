<?php
/**
 * @author: cc_forever<1253705861@qq.com>
 * @day: 2020/7/20
 */

namespace App\Http\Controllers;


use App\CcForever\controller\BaseController;
use App\CcForever\extend\JsonExtend;

/**
 * 公共控制器(未授权)
 * Class PublicControllers
 * @package App\Http\Controllers
 */
class PublicController extends BaseController
{
    /**
     * 验证码
     * @return object
     */
    public function captcha()
    {
        $captcha = app('captcha')->create('login', true);
        return JsonExtend::success('验证码获取成功', ['url' => $captcha['img'], 'key' => $captcha['key']]);
    }
}