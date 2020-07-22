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

    public static function add(array $data): bool; // 添加

    public static function modify(array $data, int $id): bool; // 修改

    public static function recycle(int $id): bool; // 假删除

    public static function message(int $id): array; // 查询单条信息

    public static function checkId(int $id): bool; // 验证编号是否存在

    public static function select(int $id, string $select): string; // 查询 $select 字段的值
}