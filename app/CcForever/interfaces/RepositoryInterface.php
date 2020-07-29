<?php
/**
 * @author: cc_forever<1253705861@qq.com>
 * @day: 2020/7/21
 */

namespace App\CcForever\interfaces;

/**
 * Repository接口
 * Interface ControllerInterface
 * @package App\CcForever\interfaces
 */
interface RepositoryInterface
{
    public static function GetModel(): object;// 外部调用Model

    public static function lst(array $where, int $page, int $limit) :bool; // 列表

    public static function count(array $where): bool; // 总数

    public static function insert(array $data): bool; // 添加

    public static function update(array $data, int $id): bool; // 修改

    public static function delete(int $id): bool; // 删除

    public static function message(int $id): bool; // 查询单条信息
}