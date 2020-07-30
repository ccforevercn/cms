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
use App\Http\Requests\RulesRequest;
use App\Http\Requests\RulesUpdateRequest;
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
        $where['login_id'] = auth('login')->id();
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

    /**
     * 规则修改
     * @param RulesUpdateRequest $rulesUpdateRequest
     * @param RulesRepository $rulesRepository
     * @return object
     */
    public function update(RulesUpdateRequest $rulesUpdateRequest, RulesRepository $rulesRepository): object
    {
        // TODO: Implement update() method.
        $data = $rulesUpdateRequest->all();
        $id = (int)$data['id'];
        $admin = auth('login')->user();
        $data['admin_id'] = $admin->id;
        $data['username'] = $admin->username;
        $bool = $rulesRepository::update($data, $id);
        if($bool){
            return JsonExtend::success($rulesRepository::returnMsg('修改成功'));
        }
        return JsonExtend::error($rulesRepository::returnMsg('修改失败'));
    }

    /**
     * 规则删除
     * @param RulesRequest $rulesRequest
     * @param RulesRepository $rulesRepository
     * @return object
     */
    public function delete(RulesRequest $rulesRequest, RulesRepository $rulesRepository): object
    {
        // TODO: Implement delete() method.
        $id = (int)$rulesRequest->input('id');
        $bool = $rulesRepository::delete($id);
        if($bool){
            return JsonExtend::success($rulesRepository::returnMsg('修改成功'));
        }
        return JsonExtend::error($rulesRepository::returnMsg('修改失败'));
    }

    /**
     * 规则基本信息
     * @param RulesRequest $rulesRequest
     * @param RulesRepository $rulesRepository
     * @return object
     */
    public function message(RulesRequest $rulesRequest, RulesRepository $rulesRepository): object
    {
        // TODO: Implement message() method.
        $id = (int)$rulesRequest->input('id');
        $bool = $rulesRepository::message($id);
        if($bool){
            return JsonExtend::success($rulesRepository::returnMsg('规则信息'), $rulesRepository::returnData([]));
        }
        return JsonExtend::error($rulesRepository::returnMsg('规则不存在'));
    }

    /**
     * 规则菜单
     * @param RulesRequest $rulesRequest
     * @param RulesRepository $rulesRepository
     * @return object
     */
    public function menus(RulesRequest $rulesRequest, RulesRepository $rulesRepository): object
    {
        $id = (int)$rulesRequest->input('id');
        $bool = $rulesRepository::menus($id);
        if($bool){
            return JsonExtend::success($rulesRepository::returnMsg('规则菜单不存在'), $rulesRepository::returnData([]));
        }
        return JsonExtend::error($rulesRepository::returnMsg('规则菜单不存在'));
    }
}