<?php
/**
 * @author: cc_forever<1253705861@qq.com>
 * @day: 2020/7/31
 */

namespace App\Http\Controllers\message;
use App\CcForever\controller\BaseController;
use App\CcForever\extend\JsonExtend;
use App\CcForever\traits\ControllerTrait;
use App\Http\Requests\Columns\ColumnsListRequest;
use App\Repositories\ColumnsRepository;

/**
 * 栏目控制器
 *
 * Class ColumnsController
 * @package App\Http\Controllers
 */
class ColumnsController extends BaseController
{
    use ControllerTrait;

    /**
     * 栏目列表
     *
     * @param ColumnsListRequest $columnsListRequest
     * @param ColumnsRepository $columnsRepository
     * @return object
     */
    public function lst(ColumnsListRequest $columnsListRequest, ColumnsRepository $columnsRepository): object
    {
        // TODO: Implement lst() method.
        $where = $columnsListRequest->all();
        $page = $where['page'];
        $limit = $where['limit'];
        $list = [];
        $count = 0;
        $result = $columnsRepository::lst($where, $page, $limit);
        if($result){ $list = $columnsRepository::returnData($list); }
        $result = $columnsRepository::count($where);
        if($result){ list($count) = $columnsRepository::returnData([]); }
        return JsonExtend::success('菜单列表', compact('list', 'count'));
    }

    public function insert(): object
    {
        // TODO: Implement insert() method.
    }

    public function update(): object
    {
        // TODO: Implement update() method.
    }

    public function delete(): object
    {
        // TODO: Implement delete() method.
    }

    public function message(): object
    {
        // TODO: Implement message() method.
    }
}