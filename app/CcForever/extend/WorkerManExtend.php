<?php
/**
 * @author: cc_forever<1253705861@qq.com>
 * @day: 2020/7/25
 */

namespace App\CcForever\extend;

use Workerman\Worker;

/**
 * WorkerMan基类
 * Class WorkerManExtend
 * @package App\CcForever\extend
 */
class WorkerManExtend
{
    public static $worker;

    public static $class;

    public function __construct(string $url, array $options)
    {
        self::$worker = new Worker($url);
        self::$worker->name = $options['name'];  // 当前Worker实例的名称
        self::$worker->count = $options['count'];  // 当前Worker实例启动多少个进程
        self::$worker->transport = $options['transport'];  // 当前Worker实例所使用的传输层协议
        self::$worker->reusePort = $options['reusePort'];  // 设置当前worker是否开启监听端口复用
        self::$worker->user = $options['user'];  // 设置当前Worker实例以哪个用户运行
        self::$class = $options['class']; // 类的静态方法作为回调
    }

    public static function start()
    {
        // 开启Worker实例
        self::onConnect();
        self::onMessage();
        self::onClose();
    }

    public static function stop()
    {
        // 关闭Worker实例
        self::reloadable();
        self::onClose();
    }

    public static function restart()
    {
        // 重启Worker实例
        self::reloadable();
        self::onWorkerReload();
    }

    public static function onWorkerStart()
    {
        // 设置Worker子进程启动时的回调函数，每个子进程启动时都会执行。
        self::$worker->onWorkerStart = array(self::$class, 'onWorkerStart');
    }


    public static function onConnect()
    {
        // 当客户端与Workerman建立连接时(TCP三次握手完成后)触发的回调函数。每个连接只会触发一次onConnect回调
        self::$worker->onConnect = array(self::$class, 'onConnect');
    }

    public static function onMessage()
    {
        // 当客户端通过连接发来数据时(Workerman收到数据时)触发的回调函数
        self::$worker->onMessage = array(self::$class, 'onMessage');
    }

    public static function onClose()
    {
        // 当客户端连接与Workerman断开时触发的回调函数。不管连接是如何断开的，只要断开就会触发onClose。每个连接只会触发一次onClose
        self::$worker->onClose = array(self::$class, 'onClose');
    }

    public static function onWorkerStop()
    {
        // Worker子进程关闭时触发
        self::$worker->onWorkerStop = array(self::$class, 'onWorkerStop');
    }

    public static function onBufferFull()
    {
        // 每个连接都有一个单独的应用层发送缓冲区，如果客户端接收速度小于服务端发送速度，数据会在应用层缓冲区暂存，
        // 如果缓冲区满则会触发onBufferFull回调
        self::$worker->onBufferFull = array(self::$class, 'onBufferFull');
    }

    public static function onBufferDrain()
    {
        // 每个连接都有一个单独的应用层发送缓冲区，缓冲区大小由TcpConnection::$maxSendBufferSize决定，默认值为1MB，
        // 可以手动设置更改大小，更改后会对所有连接生效。
        self::$worker->onBufferDrain = array(self::$class, 'onBufferDrain');
    }

    public static function onError()
    {
        // 当客户端的连接上发生错误时触发。
        self::$worker->onError = array(self::$class, 'onError');
    }

    public static function onWorkerReload()
    {
        // 设置Worker收到reload信号后执行的回调
        self::$worker->onWorkerReload = array(self::$class, 'onWorkerReload');
    }

    public static function runAll()
    {
        // 运行worker
        Worker::runAll();
    }

    public static function stopAll()
    {
        // 关闭worker
        Worker::stopAll();
    }

    public static function reloadable()
    {
        self::$worker->reloadable = false;
    }
}