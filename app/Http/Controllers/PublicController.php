<?php
/**
 * @author: cc_forever<1253705861@qq.com>
 * @day: 2020/7/20
 */

namespace App\Http\Controllers;


use App\CcForever\controller\BaseController;
use App\CcForever\extend\JsonExtend;
use App\CcForever\extend\PRedisExtend;

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

        try{
            $pRedis = new PRedisExtend('write');
            dd($pRedis::redis()->lLen('aaa'));
            $pRedis::redis()->rpush('aaa',123);
            $pRedis::redis()->rpush('aaa',123);
            $pRedis::redis()->rpush('aaa',123);
            $pRedis::redis()->rpush('aaa',123);
            $pRedis::redis()->rpush('aaa',123);
            $pRedis::redis()->lrange('aaa');

            //  lLen(key)  获取队列长度
            //  rpush(key, value)  插入队列
            //  lrange(key) 获取队列
        }catch (\Exception $exception){
            dd($exception->getMessage());
        }

        dd(1);


        $captcha = app('captcha')->create('login', true);
        return JsonExtend::success('验证码获取成功', ['url' => $captcha['img'], 'key' => $captcha['key']]);
    }
}