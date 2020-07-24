<?php
/**
 * @author: cc_forever<1253705861@qq.com>
 * @day: 2020/7/21
 */

namespace App\CcForever\interfaces;

/**
 * Model接口
 * Interface ModelInterface
 * @package App\CcForever\interfaces
 */
interface ModelInterface
{
    public static function lst(array $where, int $offset, int $limit) :array; // 列表

    public static function count(array $where): int; // 总数
}