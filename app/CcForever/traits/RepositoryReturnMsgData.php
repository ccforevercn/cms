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

    public static function GetModel(): object
    {
        // TODO: Implement GetModel() method.
        return self::$model;
    }

    /**
     * 信息删除
     *
     * @param int $id
     * @return bool
     */
    public static function delete(int $id): bool
    {
        // TODO: Implement delete() method.
        $check = self::$model::base_bool('check', [], $id); // 验证编号
        if(!$check){
            return self::setMsg('已删除', true);
        }
        $status = self::$model::base_bool('delete', [], $id);
        return self::setMsg($status ? '删除成功' : '删除失败', $status);
    }

    /**
     * 信息查询
     *
     * @param int $id
     * @return bool
     */
    public static function message(int $id): bool
    {
        // TODO: Implement message() method.
        $check = self::$model::base_bool('check', [], $id);
        if(!$check){// 编号不存在
            return self::setMsg('数据不存在', false);
        }
        $message = self::$model::base_array('message', $id, self::$model::GetMessage(), []);
        return self::setMsg('信息', true, $message);
    }
}