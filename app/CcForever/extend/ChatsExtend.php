<?php
/**
 * @author: cc_forever<1253705861@qq.com>
 * @day: 2020/8/7
 */

namespace App\CcForever\extend;

use App\Repositories\AdminsRepository;
use App\Repositories\AdminsTokenRepository;

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
    private static $admins = [];

    /**
     * 已接入用户
     *
     * @var array
     */
    private static $users = [];

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
        $id = md5(implode(',', app('request')->getClientIps()).create_millisecond().mt_rand(10000, 99999));
        $message = [];
        $message['unique'] = $id;
        self::$users[$id] = $connection;
        $connection->send(json_encode(JsonExtend::success("信息", $message)->original, JSON_UNESCAPED_UNICODE));
    }

    /**
     * 客户端接收数据触发
     *
     * @param $connection
     * @param $message
     * @return mixed
     */
    public static function onMessage($connection, $message)
    {
        $messageArr = json_decode($message, true);
        if($messageArr && array_key_exists('type', $messageArr)){ // 参数解析成功
            switch ($messageArr['type']){
                case 'chats_admin': // 聊天管理员
                    // 管理员验证   验证token和unique是否存在
                    if(array_key_exists('token', $messageArr) && array_key_exists('unique', $messageArr)) {
//                        $adminsTokenRepository = new AdminsTokenRepository();// 实例化AdminsTokenRepository类
//                        $adminId = $adminsTokenRepository::checkToken($messageArr['token']); // 验证Token获取管理员编号
                        $adminId = 1;
                        if($adminId){ // 管理员访问
                            // 验证管理员是否已登陆
                            if(array_key_exists($messageArr['unique'], self::$admins)){
                                // 验证  发送内容是否存在 接收的用户是否存在
                                if(array_key_exists('content', $messageArr) && array_key_exists('user', $messageArr)){
                                    $data = []; // 发送数据
                                    $data['content'] = $messageArr['content']; // 内容
                                    $data['customer'] = $messageArr['unique']; // 客服名称
                                    self::$users[$messageArr['user']]->send(json_encode(JsonExtend::success("客服回复:", $data)->original, JSON_UNESCAPED_UNICODE)); // 给用户发送消息
                                    $data['user'] = $messageArr['user']; // 用户名称
                                    $data['see'] = 1; // 是否查看
                                    self::$admins[$messageArr['unique']]['user_unique'][] = $messageArr['user']; // 绑定当前用户到接收消息的管理员
                                    // 管理员提示
                                    $connection->send(json_encode(JsonExtend::success("回复成功", $data)->original,JSON_UNESCAPED_UNICODE));
                                    // 插入数据库
                                    /************************************************************************************************************/
                                }else{  // 发送的数据不完整
                                    $connection->send(json_encode(JsonExtend::error("参数错误")->original, JSON_UNESCAPED_UNICODE));
                                }
                            }else{ // 未登录状态
                                $admin = []; // 管理员信息
//                                $adminsRepository = new AdminsRepository(); // 实例化AdminsRepository类
//                                $adminInfo = $adminsRepository::message($adminId); // 获取管理员信息
                                $adminInfo = ['username'=>'csadmin'];
                                $admin['user_unique'] = []; // 正在聊天的用户
                                $admin['info'] = $adminInfo; // 管理员信息
                                $admin['connection'] = $connection; // $connection
                                self::$admins[$messageArr['unique']] = $admin; // 保存管理员
                                // 管理员登陆成功
                                $connection->send(json_encode(JsonExtend::success("客服验证成功", $admin['info'])->original, JSON_UNESCAPED_UNICODE));
                            }
                        }else{ // 验证失败
                            $connection->send(json_encode(JsonExtend::error("客服验证失败")->original, JSON_UNESCAPED_UNICODE));
                        }
                    }else{
                        $connection->send(json_encode(JsonExtend::error("非法请求")->original, JSON_UNESCAPED_UNICODE));
                    }
                    break;
                case 'chats_user': // 聊天用户
                    $data = []; // 留言记录
                    $data['content'] = $messageArr['content']; // 内容
                    $data['user'] = $messageArr['unique']; // 用户名称
                    $seed = false;
                    foreach (self::$admins as $value){
                        // 有管理员对话状态
                        if(in_array($messageArr['unique'], $value['user_unique'])){
                            // 给对应的管理员发送消息
                            $value['connection']->send(json_encode(JsonExtend::success("用户发送消息:", $data)->original, JSON_UNESCAPED_UNICODE));
                            $data['customer'] = $value['info']['username']; // 管理员账号
                            $data['see'] = 1; // 是否查看
                            $seed = true; // 是否发送
                        }
                    }
                    // 未发送状态
                    if(!$seed){
                        // 判断是否有管理员登陆
                        if(count(self::$admins)){
                            // 给全部管理员发送通知
                            foreach (self::$admins as $value){
                                $value['connection']->send(json_encode(JsonExtend::success("客户消息", $data)->original, JSON_UNESCAPED_UNICODE));
                            }
                        }
                        // 给客户提示发送成功
                        $connection->send(json_encode(JsonExtend::success("发送成功", [])->original, JSON_UNESCAPED_UNICODE));
                        $data['customer'] = ''; // 客服名称
                        $data['see'] = 0; // 是否查看
                    }
                    // 插入数据库
                    break;
                default:
                    $connection->send(json_encode(JsonExtend::error("非法请求")->original, JSON_UNESCAPED_UNICODE));
            }
        }else{
            $connection->send(json_encode(JsonExtend::error("非法请求")->original, JSON_UNESCAPED_UNICODE));
        }
    }

    /**
     *
     *  ['seed' => '客户得消息']
     *   //  客户端发送消息--》给正在登陆的管理员发送通知--》管理员收到消息后 在点击时加入队列 当队列数量到1时修改客户端发送的信息为已读，清除队列
     *
     * var ws = new WebSocket('ws://192.168.99.100:2222')
     *
     * ws.send('{"type":"chats_user","unique":"107742c57242dc400a3b1593bab2d6b3","content":"客户发言"}')
     *
     * ws.send('{"type":"chats_admin","token":"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ","unique":"d7cd9714b7527b6d6997b2ff533d7dd3"}')
     *
     * ws.send('{"type":"chats_admin","token":"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ","unique":"2fffc8a300e4d61f4e82b437bd895f41"}')
     *
     * ws.send('{"type":"chats_admin","token":"eyJ0eXAiOiJKV1QiLCJhbGciOiJIUzI1NiJ","unique":"2fffc8a300e4d61f4e82b437bd895f41","user":"107742c57242dc400a3b1593bab2d6b3","content":"管理员发言"}')
     *
     *
     *
     */


    /**
     * 客户端连接与Workerman断开时触发
     * @param $connection
     */
    public static function onClose($connection)
    {
        // 管理员退出  清除管理员
        foreach (self::$admins as $key=>$admin){
            if($connection == $admin['connection']){
                unset(self::$admins[$key]);
            }
        }
        // 用户退出 清除用户
        foreach (self::$users as $key=>$user){
            if($connection == $user){
                unset(self::$users[$key]);
            }
        }
        var_dump("ChatsExtend onClose1");
    }
}