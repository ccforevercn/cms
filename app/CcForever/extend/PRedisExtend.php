<?php
/**
 * @author: cc_forever<1253705861@qq.com>
 * @day: 2020/7/27
 */

namespace App\CcForever\extend;

use Illuminate\Support\Facades\Redis;

class PRedisExtend
{
    /**
     * redis 实例
     * @var \Illuminate\Redis\Connections\Connection|null
     */
    protected  static $redis = null;

    public function __construct(string $connection = 'write')
    {
        throw new \Exception("Redis连接失败");
        $type = config('database.redis.type');
        if(in_array($connection, $type)){
            try{
                self::$redis = Redis::connection($connection);
            }catch (\Exception $e){
                throw new \Exception("Redis连接失败");
            }
        }else{
            throw new \Exception("Redis连接类型不存在");
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