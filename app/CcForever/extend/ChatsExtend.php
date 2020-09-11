<?php
/**
 * @author: cc_forever<1253705861@qq.com>
 * @day: 2020/8/7
 */

namespace App\CcForever\extend;

use App\Repositories\AdminsRepository;
use App\Repositories\ChatsRepository;

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
     * 已接入用户(已发送消息)
     *
     * @var array
     */
    private static $users = [];

    /**
     * 所有接入的用户(所有连接过得用户)
     *
     * @var array
     */
    private static $total = [];

    /**
     * 已接入用户(发送过消息) 唯一值
     *
     * @var array
     */
    private static $usersUnique = [];

    /**
     * 已查看用户(管理员已查看) 唯一值
     *
     * @var array
     */
    private static $speak = [];

    const SEND_TYPE_CONNECT = 'connect'; // 连接成功

    const SEND_TYPE_ADMIN_CHECK = 'admin_check'; // 管理员验证

    const SEND_TYPE_ADMIN_MESSAGE = 'admin_message'; // 管理员消息

    const SEND_TYPE_ADMIN_NOTICE_MESSAGE = 'admin_notice_message';  // 管理员新消息

    const SEND_TYPE_ADMIN_NOTICE_SUCCESS = 'admin_notice_success';  // 管理员信息发送成功提示

    const SEND_TYPE_ADMIN_NOTICE_ERROR = 'admin_notice_error';  // 管理员信息发送失败提示

    const SEND_TYPE_ADMIN_SHUT_USER = 'admin_shut_user'; // 未接入用户

    const SEND_TYPE_ADMIN_SHUT_CHECK = 'admin_user_check'; // 验证当前用户是否在线

    const SEND_TYPE_USER_CHECK = 'user_check'; // 用户验证

    const SEND_TYPE_USER_MESSAGE = 'user_message'; // 用户消息

    const SEND_TYPE_USER_NOTICE = 'user_notice'; // 用户员通知

    const SEND_TYPE_CONNECT_NOTICE = 'connect_notice'; // 链接通知

    const SEND_TYPE_HEARTBEAT = 'heartbeat'; // 链接通知

    /**
     * 格式化数据并发送
     *
     * @param object $connection
     * @param string $sendType
     * @param string $message
     * @param array $data
     */
    private static function formatDataSend(object $connection, string $sendType, string $message, array $data = []): void
    {
        $seed = [];
        $seed['type'] = $sendType;  // 发送类型
        $seed['message'] = $message; // 提示信息
        $seed['data'] = $data; // 发送数据
        $connection->send(json_encode($seed, JSON_UNESCAPED_UNICODE));
    }

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
        var_dump("ChatsExtend onWorkerStart");
    }

    /**
     * Worker连接后触发
     * @param $connection
     */
    public static function onConnect($connection)
    {
        // 生成唯一值
        $unique = md5(implode(',', app('request')->getClientIps()).create_millisecond().mt_rand(10000, 99999));
        // 添加到所有用户组
        self::$total[$unique] = $connection;
        self::formatDataSend($connection, self::SEND_TYPE_CONNECT, '基本信息', compact('unique'));
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
                case 'user_check': // 验证用户是否在线
                    // 管理员验证   验证token和unique是否存在
                    if(array_key_exists('token', $messageArr) && array_key_exists('unique', $messageArr) && array_key_exists('check', $messageArr) &&$messageArr['unique'] !== 'undefined') {
                        try{
                            // 验证token
                            auth('login')->setToken($messageArr['token']);
                            $adminId = auth('login')->id();
                            if($adminId){ // 管理员访问
                                // 验证用户是否在线
                                if(in_array($messageArr['check'], self::$usersUnique)){
                                    self::formatDataSend($connection, self::SEND_TYPE_ADMIN_SHUT_CHECK, '用户在线', ['status' => true]);
                                    break;
                                }
                            }
                        }catch (\Exception $exception){}
                    }
                    self::formatDataSend($connection, self::SEND_TYPE_ADMIN_SHUT_CHECK, '用户下线', ['status' => false]);
                    break;
                case 'heartbeat': // 心跳和重置未接入的用户
                    // 管理员验证   验证token和unique是否存在
                    if(array_key_exists('token', $messageArr) && array_key_exists('unique', $messageArr) && $messageArr['unique'] !== 'undefined') {
                        try{
                            // 验证token
                            auth('login')->setToken($messageArr['token']);
                            $adminId = auth('login')->id();
                            if($adminId){ // 管理员访问
                                // 验证管理员是否已登陆
                                if(array_key_exists($messageArr['unique'], self::$admins)){
                                    // 检测未读取的用户发送给客服
                                    $shut = array_diff(self::$usersUnique, self::$speak);
                                    if(count($shut)){
                                        $shut = array_values($shut);
                                        self::formatDataSend($connection, self::SEND_TYPE_ADMIN_SHUT_USER, '未接入用户', $shut);
                                    }
                                }
                            }
                        }catch (\Exception $exception){}
                    }
                    self::formatDataSend($connection, self::SEND_TYPE_HEARTBEAT, '心跳', []);
                    break;
                case 'chats_admin': // 聊天管理员
                    // 管理员验证   验证token和unique是否存在
                    if(array_key_exists('token', $messageArr) && array_key_exists('unique', $messageArr) && $messageArr['unique'] !== 'undefined') {
                        try{
                            // 验证token
                            auth('login')->setToken($messageArr['token']);
                            $adminId = auth('login')->id();
                            if($adminId){ // 管理员访问
                                self::$speak[$messageArr['unique']] = $messageArr['unique']; // 添加客服
                                if(array_key_exists('newunique', $messageArr)) {
                                    self::$speak[$messageArr['newunique']] = $messageArr['newunique']; // 添加重复客服
                                }
                                // 验证管理员是否已登陆
                                if(array_key_exists($messageArr['unique'], self::$admins)){
                                    // 验证  发送内容是否存在 接收的用户是否存在
                                    if(array_key_exists('content', $messageArr) && array_key_exists('user', $messageArr)){
                                        self::$speak[$messageArr['user']] = $messageArr['user']; // 添加已查看用户
                                        $data = []; // 发送数据
                                        $data['content'] = $messageArr['content']; // 内容
                                        $data['customer'] = self::$admins[$messageArr['unique']]['info']['username']; // 客服名称
                                        $data['speak'] = $data['customer']; // 发言者
                                        $data['user'] = $messageArr['user']; // 用户名称
                                        $data['see'] = 1; // 是否查看
                                        self::$admins[$messageArr['unique']]['user_unique'][] = $messageArr['user']; // 绑定当前用户到接收消息的管理员
                                        // 插入数据库
                                        $chatsRepository =  new ChatsRepository();
                                        $bool = $chatsRepository::insert($data);
                                        if($bool){
                                            // 管理员提示 发送成功
                                            self::formatDataSend($connection, self::SEND_TYPE_ADMIN_NOTICE_SUCCESS, '回复成功', $data);
                                            // 给用户发送消息
                                            self::formatDataSend(self::$users[$messageArr['user']], self::SEND_TYPE_USER_MESSAGE, '客服回复', $data);
                                        }else{
                                            // 管理员提示 发送失败
                                            self::formatDataSend($connection, self::SEND_TYPE_ADMIN_NOTICE_ERROR, '回复失败', []);
                                        }
                                    }else{  // 发送的数据不完整
                                        self::formatDataSend($connection, self::SEND_TYPE_ADMIN_CHECK, '连接成功', []);
                                    }
                                }else{ // 未登录状态
                                    $adminLoginStatus = false; // 登陆状态
                                    $unique = ''; // 登陆唯一值
                                    $admin = []; // 管理员信息
                                    if(count(self::$admins)){
                                        // 查看管理员是否已登陆
                                        foreach (self::$admins as $key=>$value){
                                            if($adminId == $value['admin_id']){
                                                $adminLoginStatus = true;
                                                $unique = $key;
                                                $admin = $value;
                                            }
                                        }
                                    }
                                    if(!$adminLoginStatus){
                                        $adminsRepository = new AdminsRepository(); // 实例化AdminsRepository类
                                        $adminStatus = $adminsRepository::message($adminId); // 获取管理员信息
                                        if($adminStatus){
                                            $adminInfo = $adminsRepository::returnData([]);
                                            $admin['user_unique'] = []; // 正在聊天的用户
                                            $admin['info'] = $adminInfo; // 管理员信息
                                            $admin['admin_id'] = $adminId; // 管理员编号
                                            $admin['connection'] = $connection; // $connection
                                            self::$admins[$messageArr['unique']] = $admin; // 保存管理员
                                            self::formatDataSend($connection, self::SEND_TYPE_ADMIN_CHECK, '连接成功', []);
                                        }else{
                                            self::formatDataSend($connection, self::SEND_TYPE_ADMIN_CHECK, '连接失败', []);
                                        }
                                    }else{
                                        // 客服已存在重新验证
                                        self::formatDataSend($connection, self::SEND_TYPE_CONNECT, '基本信息', compact('unique'));
                                    }
                                }
                            }else{ // 验证失败
                                self::formatDataSend($connection, self::SEND_TYPE_ADMIN_CHECK, '连接失败', []);
                            }
                        }catch (\Exception $exception){
                            self::formatDataSend($connection, self::SEND_TYPE_ADMIN_CHECK, '连接失败', []);
                        }
                    }else{
                        self::formatDataSend($connection, self::SEND_TYPE_ADMIN_CHECK, '连接失败', []);
                    }
                    break;
                case 'chats_user': // 聊天用户
                    // 判断当前发送消息的用户是否在用户组中
                    if(!array_key_exists($messageArr['unique'], self::$users)){
                        // 不存在时，添加到用户组中
                        // 添加用户唯一值
                        self::$usersUnique[$messageArr['unique']] = $messageArr['unique'];
                        // 添加用户到用户组中
                        self::$users[$messageArr['unique']] = $connection;
                    }
                    $data = []; // 留言记录
                    $adminSendData = []; // 发送数据的管理员
                    $data['content'] = $messageArr['content']; // 内容
                    $data['user'] = $messageArr['unique']; // 用户名称
                    $data['speak'] = $messageArr['unique']; // 发言者
                    $seed = false;
                    foreach (self::$admins as $value){
                        // 有管理员对话状态
                        if(in_array($messageArr['unique'], $value['user_unique'])){
                            // 给对应的管理员发送消息
                            $adminSendData[] = $value['connection'];
                            $data['customer'] = $value['info']['username']; // 管理员账号
                            $data['see'] = 1; // 是否查看
                            $seed = true; // 是否发送
                        }
                    }
                    // 未发送状态
                    $chatsRepository =  new ChatsRepository();
                    if(!$seed){
                        // 判断是否有管理员登陆
                        if(count(self::$admins)){
                            // 给全部管理员发送通知
                            $api = $chatsRepository::GetModel()::GetSeeApi();
                            foreach (self::$admins as $value){
                                $bool = LoginExtend::admin($value['admin_id'], $api); // 获取客服是否有权限
                                if($bool){// 有权限访问
                                    $adminSendData[] = $value['connection'];
                                }
                            }
                        }
                        $data['customer'] = ''; // 客服名称
                        $data['see'] = 0; // 是否查看
                    }
                    // 插入数据库
                    $bool = $chatsRepository::insert($data);
                    if($bool){ // 添加数据库成功
                        $message  = count($adminSendData) == 1 ? "用户发送消息" : "客户消息";
                        foreach ($adminSendData as $value){
                            if($seed) {
                                self::formatDataSend($value, self::SEND_TYPE_ADMIN_MESSAGE, $message, $data);
                            }else{
                                self::formatDataSend($value, self::SEND_TYPE_ADMIN_NOTICE_MESSAGE, $message, $data);
                            }
                        }
                        // 给客户提示发送成功
                        self::formatDataSend($connection, self::SEND_TYPE_USER_NOTICE, '发送成功', []);
                    }else{ // 添加数据库失败
                        self::formatDataSend($connection, self::SEND_TYPE_USER_NOTICE, '发送失败"', []);
                    }
                    break;
                default:
                    self::formatDataSend($connection, self::SEND_TYPE_CONNECT_NOTICE, '连接失败', []);
            }
        }else{
            self::formatDataSend($connection, self::SEND_TYPE_CONNECT_NOTICE, '连接失败', []);
        }
    }

    /**
     * 连接聊天
     * var ws = new WebSocket('ws://192.168.99.100:2222')
     * 用户发送消息
     * ws.send('{"type":"chats_user","unique":"123123","content":"客户发言"}')
     * 客服验证
     * ws.send('{"type":"chats_admin","token":"123123","unique":"123123"}')
     * 客服回复用户信息
     * ws.send('{"type":"chats_admin","token":"123123","unique":"123123","user":"123123","content":"管理员发言"}')
     */


    /**
     * 客户端连接与Worker断开时触发
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
                unset(self::$speak[$key]);
                unset(self::$usersUnique[$key]);
                unset(self::$total[$key]);
                $data = []; // 留言记录
                $data['content'] = "我离开了:)"; // 内容
                $data['user'] = $key; // 用户名称
                $data['speak'] = $key; // 发言者
                $data['customer'] = ''; // 管理员账号
                $data['see'] = 0; // 是否查看
                foreach (self::$admins as $admin){
                    // 有管理员对话状态
                    if(in_array($key, $admin['user_unique'])){
                        // 给对应的管理员发送消息
                        $data['customer'] = $admin['info']['username'];
                        $data['see'] = 1;
                        // 存入数据库
                        $chatsRepository = new ChatsRepository();
                        $bool = $chatsRepository::insert($data);
                        if($bool){
                            // 给管理员发送提示
                            self::formatDataSend($admin['connection'], self::SEND_TYPE_ADMIN_MESSAGE, '用户留言', $data);
                        }
                        // 删除管理员绑定的参数
                        $userKey = array_keys($admin['user_unique'], $key); // 获取用户的键值
                        unset($admin['user_unique'][$userKey[0]]); // 删除用户键值对应的元素
                    }
                }
            }
        }
    }
}