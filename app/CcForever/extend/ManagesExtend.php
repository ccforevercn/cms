<?php
/**
 * @author: cc_forever<1253705861@qq.com>
 * @day: 2020/7/25
 */

namespace App\CcForever\extend;

use App\Repositories\AdminsRepository;
use App\Repositories\AdminsTokenRepository;


/**
 * 管理员worker
 * Class ManagesExtend
 * @package App\CcForever\extend
 */
class ManagesExtend
{
    /**
     * 管理员worker配置
     * @var array
     */
    protected static $config;

    /**
     *
     * ManagesExtend constructor.
     * @param array $config
     */
    public function __construct(array $config)
    {
        self::$config = $config;
        new WorkerManExtend(self::$config['protocol'].self::$config['ip'].':'.self::$config['port'], self::$config);
    }
    /**
     * worker子进程启动触发
     * @param $worker
     * @throws \Exception
     */
    public static function onWorkerStart($worker)
    {
        var_dump("ManagesExtend onWorkerStart~");
    }

    /**
     * Worker连接后触发
     * @param $connection
     */
    public static function onConnect($connection)
    {
        var_dump("ManagesClass onConnect~");
    }

    /**
     * 客户端接收数据触发
     * @param $connection
     * @param $message
     */
    public static function onMessage($connection, $message)
    {
        $messageArr = json_decode($message, true);
        if($messageArr && is_array($messageArr) && array_key_exists('token', $messageArr)){ // 判断是否有token
//            $adminsTokenRepository = new AdminsTokenRepository();// 验证Token
//            $adminId = $adminsTokenRepository::checkToken($messageArr['token']); // 验证Token
            $adminId = 1;
            if(array_key_exists('type', $messageArr)){
                switch ($messageArr['type']){
                    case 'adminparentids': // 缓存管理员的编号和上级+编号
                        $adminsRepository = new AdminsRepository();
                        $status = $adminsRepository::adminParentIdsCache($messageArr);
                        $msg = $adminsRepository::returnMsg();
                        if($status){
                            $connection->send(json_encode(JsonExtend::success($msg)->original, JSON_UNESCAPED_UNICODE));
                        }else{
                            $connection->send(json_encode(JsonExtend::error($msg)->original, JSON_UNESCAPED_UNICODE));
                        }
                        break;
                    case 'adminmenusroutes': // 缓存管理员菜单路由
                        $adminsRepository = new AdminsRepository();
                        $status = $adminsRepository::adminRuleMenusRoutesCache($adminId);
                        $msg = $adminsRepository::returnMsg();
                        if($status){
                            $connection->send(json_encode(JsonExtend::success($msg)->original, JSON_UNESCAPED_UNICODE));
                        }else{
                            $connection->send(json_encode(JsonExtend::error($msg)->original, JSON_UNESCAPED_UNICODE));
                        }
                        break;
                    case 'adminmenusbottom': // 缓存管理员菜单按钮
                        $adminsRepository = new AdminsRepository();
                        $status = $adminsRepository::adminMenusBottomCache($adminId);
                        $msg = $adminsRepository::returnMsg();
                        if($status){
                            $connection->send(json_encode(JsonExtend::success($msg)->original, JSON_UNESCAPED_UNICODE));
                        }else{
                            $connection->send(json_encode(JsonExtend::error($msg)->original, JSON_UNESCAPED_UNICODE));
                        }
                        break;
                }
            }else{
                $connection->send(json_encode(JsonExtend::error("请选择执行方式")->original, JSON_UNESCAPED_UNICODE));
            }
        }else{
            $connection->send(json_encode(JsonExtend::error("请先登录")->original, JSON_UNESCAPED_UNICODE));
        }
    }

    /**
     *
     *
     * var ws = new WebSocket('ws://192.168.99.100:2222')
     * ws.send('{"token":"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC93d3cuY21zLm5ldFwvYXBpXC9ocmtqXC9sb2dpbiIsImlhdCI6MTU5NTgzODE0OCwiZXhwIjoxNTk1ODc0MTQ4LCJuYmYiOjE1OTU4MzgxNDgsImp0aSI6IklxQ1BqOFpiZjNubVRsRkwiLCJzdWIiOjEsInBydiI6ImQ1NzEwZGZiZjQ3YmRmMDFiMWQ3YmFlOTMxNDA4ZDUxZjc3YTA5MjkifQ.2a1CoTHSNydrbmtHdJWBf6rV7zva2yTGRWeCio7hwFI","type":"adminparentids","admintotalids":"1,2,3,4,5,6"}')
     *
     * ws.send('{"token":"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC93d3cuY21zLm5ldFwvYXBpXC9ocmtqXC9sb2dpbiIsImlhdCI6MTU5NTgzODE0OCwiZXhwIjoxNTk1ODc0MTQ4LCJuYmYiOjE1OTU4MzgxNDgsImp0aSI6IklxQ1BqOFpiZjNubVRsRkwiLCJzdWIiOjEsInBydiI6ImQ1NzEwZGZiZjQ3YmRmMDFiMWQ3YmFlOTMxNDA4ZDUxZjc3YTA5MjkifQ.2a1CoTHSNydrbmtHdJWBf6rV7zva2yTGRWeCio7hwFI","type":"adminmenusroutes"}')
     *
     * ws.send('{"token":"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ9.eyJpc3MiOiJodHRwOlwvXC93d3cuY21zLm5ldFwvYXBpXC9ocmtqXC9sb2dpbiIsImlhdCI6MTU5NTgzODE0OCwiZXhwIjoxNTk1ODc0MTQ4LCJuYmYiOjE1OTU4MzgxNDgsImp0aSI6IklxQ1BqOFpiZjNubVRsRkwiLCJzdWIiOjEsInBydiI6ImQ1NzEwZGZiZjQ3YmRmMDFiMWQ3YmFlOTMxNDA4ZDUxZjc3YTA5MjkifQ.2a1CoTHSNydrbmtHdJWBf6rV7zva2yTGRWeCio7hwFI","type":"adminmenusbottom"}')
     *
     *
     */


    /**
     * 客户端连接与Workerman断开时触发
     * @param $connection
     */
    public static function onClose($connection)
    {
        var_dump("onClose~");
    }
}