<?php
/**
 * @author: cc_forever<1253705861@qq.com>
 * @day: 2020/7/23
 */

namespace App\Http\Controllers;

use App\CcForever\controller\BaseController;
use App\CcForever\extend\JsonExtend;
use App\CcForever\traits\ControllerTrait;
use App\Http\Requests\RulesListRequest;
use App\Repositories\RulesRepository;

/**
 * 规则控制器
 * Class RulesController
 * @package App\Http\Controllers
 */
class RulesController extends BaseController
{
    use ControllerTrait;

    public function lst(RulesListRequest $rulesListRequest, RulesRepository $rulesRepository): object
    {
        // TODO: Implement lst() method.
        $where = $rulesListRequest->all();
        $page = $where['page'];
        $limit = $where['limit'];
        $list = [];
        $count = 0;
        $result = $rulesRepository::lst($where, $page, $limit);
        if($result){ $list = $rulesRepository::returnData($list); }
        $result = $rulesRepository::count($where);
        if($result){ list($count) = $rulesRepository::returnData([]); }
        return JsonExtend::success('规则列表', compact('list', 'count'));
    }

    public function  add(): object
    {
        // TODO: Implement add() method.
    }

    public function modify(): object
    {
        // TODO: Implement modify() method.
    }

    public function recycle(): object
    {
        // TODO: Implement recycle() method.
    }

    public function message(): object
    {
        // TODO: Implement message() method.
    }
}