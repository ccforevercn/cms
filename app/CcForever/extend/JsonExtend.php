<?php
/**
 * @author: cc_forever<1253705861@qq.com>
 * @day: 2020/7/20
 */

namespace App\CcForever\extend;

/**
 * 返回值处理
 * Class JsonExtend
 * @package App\CcForever\extend
 */
class JsonExtend
{

    public static $success = 200; // 成功状态码

    public static $error = 400; // 失败状态码

    public static $login = 401; // 登陆状态码

    /**
     * success
     * @param string $message
     * @param array $data
     * @return object
     */
    public static function success(string $message, array $data = []): object
    {
        $code = self::$success;
        return self::response($message, $data, $code);
    }

    /**
     * error
     * @param string $message
     * @return object
     */
    public static function error(string $message): object
    {
        $code = self::$error;
        return self::response($message, [], $code);
    }

    /**
     * login
     * @param string $message
     * @return object
     */
    public static function login(string $message): object
    {
        $code = self::$login;
        return self::response($message, [], $code);
    }

    /**
     * 格式化返回值
     * @param string $message
     * @param array $data
     * @param int $code
     * @return object
     */
    public static function response(string $message, array $data, int $code): object
    {
        return response()->json(['msg' => $message, 'data' => $data, 'code'=> $code], $code);
    }
}