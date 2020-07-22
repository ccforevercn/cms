<?php
/**
 * @author: cc_forever<1253705861@qq.com>
 * @day: 2020/7/20
 */

namespace App;

use App\CcForever\model\BaseModel;

class AdminTokens extends BaseModel
{

    protected $primaryKey = 'id';

    protected $table = 'admin_tokens';

    /**
     * 添加登陆记录
     * @param string $username
     * @param string $token
     * @param int $admin_id
     * @param int $start_time
     * @param int $stop_time
     * @return bool
     */
    public static function login(string $username, string $token, int $admin_id, int $start_time, int $stop_time): bool
    {
       try{
           return self::insert(compact('username', 'token', 'admin_id', 'start_time', 'stop_time'));
       }catch (\Exception $exception){
           return false;
       }
    }


}