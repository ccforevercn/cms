<?php
/**
 * @author: cc_forever<1253705861@qq.com>
 * @day: 2020/7/21
 */

namespace App\CcForever\traits;

/**
 * Repository 返回信息
 * Trait RepositoryReturnMsgData
 * @package App\CcForever\traits
 */
trait RepositoryReturnMsgData
{

    protected static $model; // ModelClass object

    public static $returnMsg; // 返回信息 string

    public static $returnData; // 返回数据 array

    /**
     * 设置返回信息
     * @param string $msg
     * @param bool $status
     * @param array $data
     * @return bool
     */
    public static function setMsg(string $msg, bool $status, array $data = []): bool
    {
        self::$returnMsg = $msg;
        self::$returnData = $data;
        return $status;
    }

    /**
     * 获取返回msg
     * @param string $msg
     * @return string
     */
    public static function returnMsg(string $msg = "error"): string
    {
        return strlen(self::$returnMsg) ? self::$returnMsg : $msg;
    }

    /**
     * 获取返回Data
     * @param array $data
     * @return array
     */
    public static function returnData(array $data = []): array
    {
        return count(self::$returnData) ? self::$returnData : $data;
    }
}