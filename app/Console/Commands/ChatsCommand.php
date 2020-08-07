<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\CcForever\extend\ChatsExtend;
use App\CcForever\extend\WorkerManExtend;

/**
 * 留言worker
 *
 * Class ChatsCommand
 * @package App\Console\Commands
 */
class ChatsCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'chats {status} {--d}';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = '留言worker 启动留言 chats start  关闭留言 chats stop 重启留言 chats restart 启动守护进程 chats start --d';


    /**
     * worker 配置
     *
     * @var array
     */
    private $workerConfig = [];

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->check();  // 验证配置
        global $argv;
        $argv[0] = $this->workerConfig['options']['chats']['name']; // 设置当前worker名称
        $status = $this->argument('status'); // 获取终端输入的状态 start 开启 stop 关闭 restart 重启
        $argv[1] = $status; // 设置当前worker状态
        $guard = $this->option('d'); // 获取是否守护进程 如果传 --d 则为守护进程(系统后台运行)
        $argv[2] = $guard ? '-d' : ''; // 设置当前worker守护进程状态
        switch ($status) {
            case 'start':
                // 开启
                $this->start();
                break;
            case 'stop':
                // 关闭
                $this->stop();
                break;
            case 'restart':
                // 重启
                $this->restart();
                break;
        }
    }


    /**
     * 加载管理员配置
     */
    public function check()
    {
        $this->workerConfig = config('worker', []); // 获取config文件夹中的worker.php配置内容
        if(!count($this->workerConfig)){
            var_dump("请创建添加配置文件 文件路径：/config/worker.php   / : 项目根目录");
            exit();
        }
        if(!array_key_exists('options', $this->workerConfig)){
            var_dump("配置格式错误  文件路径：/config/worker.php    / : 项目根目录");
            exit();
        }
        if(!array_key_exists('chats', $this->workerConfig['options'])){
            var_dump("配置格式错误 没有options中【chats】配置 文件路径：/config/worker.php    / : 项目根目录");
            exit();
        }
    }

    /**
     * 启动
     */
    public function start()
    {
        new ChatsExtend($this->workerConfig['options']['chats']);
        WorkerManExtend::start();
        WorkerManExtend::runAll();
    }

    /**
     * 关闭
     */
    public function stop()
    {
        new ChatsExtend($this->workerConfig['options']['chats']);
        WorkerManExtend::stop();
        WorkerManExtend::runAll();
    }

    /**
     * 重启
     */
    public function restart()
    {
        new ChatsExtend($this->workerConfig['options']['chats']);
        WorkerManExtend::restart();
        WorkerManExtend::runAll();
    }
}
