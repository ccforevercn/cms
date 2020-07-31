<?php
/**
 * @author: cc_forever<1253705861@qq.com>
 * @day: 2020/7/20
 */

namespace App;

use App\CcForever\model\BaseModel;

/**
 * 管理员登陆记录Model
 * Class AdminTokens
 * @package App
 */
class AdminTokens extends BaseModel
{

    protected $primaryKey = 'id';

    protected $table = 'admin_tokens';

    public static function scopeId($query, int $id)
    {
        return $query->where('id', $id);
    }


    public static function scopeToken($query, string $token)
    {
        return $query->where('token', $token);
    }

    public static function scopeAdminId($query, int $adminId)
    {
        return $query->where('admin_id', $adminId);
    }

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

    /**
     * 管理员编号
     * @param string $token
     * @return int
     */
    public static function tokenSelectAdminId(string $token):int
    {
        $count = self::token($token)->count();
        if(!$count){// 未登录
            return 0;
        }
        $message = self::token($token)->first()->toArray();
        if($message['stop_time'] <= time()){ // 登录过期
            return 0;
        }
        return $message['admin_id']; // 返回管理员编号
    }


}