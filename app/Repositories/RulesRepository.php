<?php
/**
 * @author: cc_forever<1253705861@qq.com>
 * @day: 2020/7/23
 */

namespace App\Repositories;

use App\CcForever\interfaces\RepositoryInterface;
use App\CcForever\traits\RepositoryReturnMsgData;
use App\Rules;

/**
 * 规则
 * Class RulesRepository
 * @package App\Repositories
 */
class RulesRepository implements RepositoryInterface
{
    use RepositoryReturnMsgData;

    public function __construct(Rules $model)
    {
        self::$model = $model;
    }

    public static function lst(array $where, int $page, int $limit): bool
    {
        // TODO: Implement lst() method.
    }

    public static function count(array $where): bool
    {
        // TODO: Implement count() method.
    }

    public static function add(array $data): bool
    {
        // TODO: Implement add() method.
    }

    public static function modify(array $data, int $id): bool
    {
        // TODO: Implement modify() method.
    }

    public static function recycle(int $id): bool
    {
        // TODO: Implement recycle() method.
    }

    public static function message(int $id): bool
    {
        // TODO: Implement message() method.
    }


}