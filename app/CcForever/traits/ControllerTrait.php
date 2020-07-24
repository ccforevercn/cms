<?php
/**
 * @author: cc_forever<1253705861@qq.com>
 * @day: 2020/7/21
 */

namespace App\CcForever\traits;

trait ControllerTrait
{
    public abstract function lst(): object; // 列表

    public abstract function insert(): object; // 添加

    public abstract function update(): object; // 修改

    public abstract function delete(): object; // 删除

    public abstract function message(): object; // 查询单条信息
}