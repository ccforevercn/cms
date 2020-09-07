<?php
/**
 * @author: cc_forever<1253705861@qq.com>
 * @day: 2020/9/7
 */

namespace App\CcForever\extend;

use App\Repositories\ColumnsRepository;
use App\Repositories\MessagesRepository;

/**
 * 违禁词
 *
 * Class ForbiddenWordExtend
 * @package App\CcForever\extend
 */
class ForbiddenWordExtend
{
    /**
     * 违禁词文件地址
     *
     * @var string
     */
    private static $path = '';

    /**
     * 设置违禁词
     */
    private static function setPath(): void
    {
        self::$path = app_path('CcForever'.DIRECTORY_SEPARATOR.'txt'.DIRECTORY_SEPARATOR.'ForbiddenWord');
    }

    /**
     * 违禁词获取
     *
     * @return string
     */
    public static function GetForbiddenWord(): string
    {
        $result = '';
        self::setPath();
        $file = @fopen(self::$path, 'r');
        if(!$file) return $result;
        $result = fread($file, filesize(self::$path));
        fclose($file);
        return $result;
    }

    /**
     * 内容修改
     *
     * @param string $content
     * @return bool
     */
    public static function update(string $content): bool
    {
        if(!strlen($content)) return false;
        $content = str_replace("\r\n", "\n", $content);
        $content = str_replace("\n", "\r\n", $content);
        $content = encode_change($content, 'utf-8'); // 设置编号为urf-8
        self::setPath();
        // 打开文件，并且删除之前的数据
        $file = @fopen(self::$path, 'w+');
        if(!$file) return false;
        // 写入内容
        fwrite($file, $content);
        // 关闭文件
        fclose($file);
        return true;
    }

    /**
     * 违禁词验证
     *
     * @return array
     */
    public static function check(): array
    {
        $result = [];
        // 验证信息名称和内容
        // 获取违禁词内容
        $content = self::GetForbiddenWord();
        // 替换违禁词内容换行
        $content = str_replace("\r\n", "", $content);
        // 违禁词转为数组
        $forbiddenWord = explode('、', $content);
        // 违禁词不存在
        if(!count($forbiddenWord)){ return $result; }
        // 验证栏目名称和内容

        // 全部栏目下的信息缓存
        $columnsRepository = new ColumnsRepository();
        // 获取页面栏目编号
        $columnIds = $columnsRepository::columnsSelects(['id']);
        // 获取栏目内容
        $contents = $columnsRepository::contents($columnIds);
        // 有违禁词栏目的编号
        $columnsIds = [];
        // 验证违禁词
        foreach ($contents as &$content){
            // 栏目内容验证
            if(array_check_string($content['content'], $forbiddenWord)){
                // 违禁词存在时获取栏目编号
                $columnsIds[] = $content['id'];
            }
        }
        if(count($columnsIds)){
            // 获取页面栏目编号
            $columnsBool = $columnsRepository::appointed($columnsIds);
            // 栏目不存在是清空$result
            if(!$columnsBool) { $result = []; }
            // 栏目存在违禁词时
            $result[] = '栏目内容';
            // 栏目信息获取
            $columns = $columnsRepository::returnData([]);
            foreach ($columns as &$column){
                $result[] = '------'.$column['name'].'/'.$column['id'];
            }
        }
        // 实例化MessagesRepository
        $messagesRepository = new MessagesRepository();
        $messages = $messagesRepository::messagesSelects(['id', 'name', 'keywords', 'description']);
        $messagesNameIds = []; // 有违禁词栏目的信息名称
        $messagesKeywordsIds = []; // 有违禁词栏目的信息关键字
        $messagesDescriptionIds = []; // 有违禁词栏目的信息描述
        $messagesContentIds = []; // 有违禁词栏目的信息内容
        $messagesNameAndId = []; // 信息名称和编号
        $messagesIds = []; // 信息编号
        foreach ($messages as &$message){
            // 信息名称
            if(array_check_string($message['name'], $forbiddenWord)){
                // 违禁词存在时获取栏目编号
                $messagesNameIds[] = $message['id'];
            }
            // 信息关键字
            if(array_check_string($message['keywords'], $forbiddenWord)){
                // 违禁词存在时获取栏目编号
                $messagesKeywordsIds[] = $message['id'];
            }
            // 信息描述
            if(array_check_string($message['description'], $forbiddenWord)){
                // 违禁词存在时获取栏目编号
                $messagesDescriptionIds[] = $message['id'];
            }
            $messagesIds[] = $message['id'];
            $messagesNameAndId[$message['id']] = $message['name'];
        }
        // 批量获取信息内容
        $messagesContents = $messagesRepository::contents($messagesIds);
        foreach ($messagesContents as &$content){
            // 信息内容
            if(array_check_string($content['content'], $forbiddenWord)){
                // 违禁词存在时获取栏目编号
                $messagesContentIds[] = $content['id'];
            }
        }
        if(count($messagesNameIds)){
            //  信息名称有违禁词
            $result[] = '信息名称';
            foreach ($messagesNameIds as &$id){
                $result[] = '------'.$messagesNameAndId[$id].'/'.$id;
            }
        }
        if(count($messagesKeywordsIds)){
            //  信息关键字有违禁词
            $result[] = '信息关键字';
            foreach ($messagesKeywordsIds as &$id){
                $result[] = '------'.$messagesNameAndId[$id].'/'.$id;
            }
        }
        if(count($messagesDescriptionIds)){
            //  信息描述有违禁词
            $result[] = '信息描述';
            foreach ($messagesDescriptionIds as &$id){
                $result[] = '------'.$messagesNameAndId[$id].'/'.$id;
            }
        }
        if(count($messagesContentIds)){
            //  信息内容有违禁词
            $result[] = '信息内容';
            foreach ($messagesContentIds as &$id){
                $result[] = '------'.$messagesNameAndId[$id].'/'.$id;
            }
        }
        return $result;
    }

}