<?php
/**
 * @author: cc_forever<1253705861@qq.com>
 * @day: 2020/7/20
 */

namespace App\CcForever\traits;

use Illuminate\Support\Facades\DB;

trait ModelTraits
{
    /**
     * 链接表
     * @param string $table
     * @return object
     */
    public static function table(string $table): object
    {
        return DB::table($table);
    }
}