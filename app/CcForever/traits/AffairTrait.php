<?php
/**
 * @author: cc_forever<1253705861@qq.com>
 * @day: 2020/7/20
 */

namespace App\CcForever\traits;

use Illuminate\Support\Facades\DB;

trait AffairTrait
{
    /**
     * 开启事务
     */
    public static function beginTransaction(): void
    {
        DB::beginTransaction();
    }

    /**
     * 回滚事务
     */
    public static function rollBack(): void
    {
        DB::rollBack();
    }

    /**
     * 提交事务
     */
    public static function commit(): void
    {
        DB::commit();
    }

    /**
     * 验证状态 提交、回滚事务
     * @param bool $status
     */
    public static function checkTransaction(bool $status): void
    {
        if($status){
            self::commit();
        }else{
            self::rollBack();
        }
    }
}