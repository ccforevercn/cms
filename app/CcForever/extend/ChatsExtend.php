<?php
/**
 * @author: cc_forever<1253705861@qq.com>
 * @day: 2020/8/7
 */

namespace App\CcForever\extend;

/**
 * 留言
 *
 * Class ChatsExtend
 * @package App\CcForever\extend
 */
class ChatsExtend
{
    /**
     * 管理员worker配置
     * @var array
     */
    protected static $config;

    /**
     * 已登陆管理员(使用token验证成功后即是管理员)
     *
     * @var array
     */
    private static $admin = [];

    /**
     * 已接入用户
     *
     * @var array
     */
    private static $user = [];

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
        var_dump("ChatsExtend onWorkerStart~");
    }

    /**
     * Worker连接后触发
     * @param $connection
     */
    public static function onConnect($connection)
    {
        var_dump($connection);
        var_dump("ChatsExtend onConnect~");
    }

    /**
     * 客户端接收数据触发
     * @param $connection
     * @param $message
     */
    public static function onMessage($connection, $message)
    {
        $messageArr = json_decode($message, true);
        dump($messageArr);
    }

    /**
     *
     *  ['seed' => '客户得消息']
     *   //  客户端发送消息--》给正在登陆的管理员发送通知--》管理员收到消息后 在点击时加入队列 当队列数量到1时修改客户端发送的信息为已读，清除队列
     *
     * var ws = new WebSocket('ws://192.168.99.100:1111')
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
        var_dump("ChatsExtend onClose");
    }
}