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
    /**
     * 表名称
     *
     * @var string
     */
    protected $table = 'admin_tokens';

    /**
     * 表名称 ModelTraits 使用
     *
     * @var string
     */
    protected static $modelTable = 'admin_tokens';

    public static function scopeId($query, int $id)
    {
        return $query->where('id', $id);
    }

    public static function scopeTokenEncode($query, string $tokenEncode)
    {
        return $query->where('token_encode', $tokenEncode);
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
           $token_encode = md5($token);
           return self::insert(compact('username', 'token', 'token_encode', 'admin_id', 'start_time', 'stop_time'));
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
        $token = md5($token);
        $count = self::tokenEncode($token)->count();
        // 未登录
        if(!$count){ return 0; }
        $message = self::tokenEncode($token)->pluck('stop_time', 'admin_id')->toArray();
        $adminId = array_keys($message)[0];
        // 登录过期
        if($message[$adminId] <= time()){ return 0; }
        return $adminId;
    }

    /**
     * 获取编号
     *
     * @param string $token
     * @return int
     */
    public static function tokenSelectId(string $token): int
    {
        return (int)self::tokenEncode(md5($token))->value('id');
    }

    /**
     * 修改token过期时间
     *
     * @param int $id
     * @param int $time
     * @return bool
     */
    public static function time(int $id, int $time): bool
    {
        $stopTime = self::id($id)->pluck('stop_time', 'id')->toArray();
        if(!count($stopTime)) return false;
        if($time === $stopTime[$id]) return true;
        try{
            return (bool)self::id($id)->update(['stop_time' => $time]);
        }catch (\Exception $exception){
            return false;
        }
    }
}