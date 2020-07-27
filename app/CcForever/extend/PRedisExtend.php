<?php
/**
 * @author: cc_forever<1253705861@qq.com>
 * @day: 2020/7/27
 */

namespace App\CcForever\extend;


class PRedisExtend
{
    protected  static $redis;

    public function __construct()
    {
        try{
            self::$redis = app('redis.connection');
        }catch (\Exception $e){
            throw new \Exception("Redis连接失败");
        }
    }

    /**
     * 获取redis实例
     * @return \Illuminate\Contracts\Foundation\Application|mixed
     */
    public static function redis()
    {
        return self::$redis;
    }
}