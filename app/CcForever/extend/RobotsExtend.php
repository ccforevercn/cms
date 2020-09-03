<?php
/**
 * @author: cc_forever<1253705861@qq.com>
 * @day: 2020/9/3
 */

namespace App\CcForever\extend;

/**
 * Robots
 *
 * Class RobotsExtend
 * @package App\CcForever\extend
 */
class RobotsExtend
{
    private static $file = 'robots.txt';

    /**
     * 内容获取
     *
     * @return string
     */
    public static function content(): string
    {
        $content = ''; // 文件内容
        // 文件路径+文件名
        $path = public_path(DIRECTORY_SEPARATOR).self::$file;
        // 打开文件
        $file = @fopen($path, 'r');
        // 打开失败返回空串
        if(!$file) return $content;
        // 读取文件内容
        $content = fread($file, filesize($path));
        // 关闭文件
        fclose($file);
        return $content;
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
        $contentArrTotal = mb_str_split($content); // 用户穿过来的值切割为数组
        // 验证是否有非法字符
        foreach ($contentArrTotal as &$item){
            $ascii = ord($item); // 获取每个字符串的ascii值
            switch ($ascii){
                case $ascii > 127:
                    return false;
                default:;
            }
        }
        // 文件路径+文件名
        $path = public_path(DIRECTORY_SEPARATOR).self::$file;
        // 打开文件，并且删除之前的数据
        $file = @fopen($path, 'w+');
        if(!$file) return false;
        // 写入内容
        fwrite($file, $content);
        // 关闭文件
        fclose($file);
        return true;
    }
}