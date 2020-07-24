<?php
/**
 * @author: cc_forever<1253705861@qq.com>
 * @day: 2020/7/23
 */

namespace App\Http\Controllers;

use App\CcForever\controller\BaseController;
use App\CcForever\extend\JsonExtend;
use App\CcForever\traits\ControllerTrait;
use App\Http\Requests\RulesInsertRequest;
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

    /**
     * 规则列表
     * @param RulesListRequest $rulesListRequest
     * @param RulesRepository $rulesRepository
     * @return object
     */
    public function lst(RulesListRequest $rulesListRequest, RulesRepository $rulesRepository): object
    {
        // TODO: Implement lst() method.
        $where = $rulesListRequest->all();
        $page = $where['page']; // 页数
        $limit = $where['limit']; // 每页数据
        $list = []; // 查询的列表
        $count = 0; // 查询的总数
        $result = $rulesRepository::lst($where, $page, $limit);
        if($result){ $list = $rulesRepository::returnData($list); }
        $result = $rulesRepository::count($where);
        if($result){ list($count) = $rulesRepository::returnData([]); }
        return JsonExtend::success('规则列表', compact('list', 'count'));
    }

    /**
     * 规则添加
     * @param RulesInsertRequest $rulesAddRequest
     * @param RulesRepository $rulesRepository
     * @return object
     */
    public function  insert(RulesInsertRequest $rulesAddRequest, RulesRepository $rulesRepository): object
    {
        // TODO: Implement insert() method.
        $data = $rulesAddRequest->all();
        $admin = auth('login')->user();
        $data['admin_id'] = $admin->id;
        $data['username'] = $admin->username;
        $bool = $rulesRepository::insert($data);
        if($bool){
            return JsonExtend::success($rulesRepository::returnMsg('添加成功'));
        }
        return JsonExtend::error($rulesRepository::returnMsg('添加失败'));
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