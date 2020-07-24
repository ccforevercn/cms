<?php
/**
 * @author: cc_forever<1253705861@qq.com>
 * @day: 2020/7/22
 */

namespace App\Http\Controllers;

use App\CcForever\controller\BaseController;
use App\CcForever\extend\JsonExtend;
use App\CcForever\traits\ControllerTrait;
use App\Http\Requests\AdminsInsertRequest;
use App\Http\Requests\AdminsListRequest;
use App\Http\Requests\AdminsRequest;
use App\Http\Requests\AdminsUpdateRequest;
use App\Repositories\AdminsRepository;

/**
 * 管理员控制器
 * Class AdminController
 * @package App\Http\Controllers
 */
class AdminsController extends BaseController
{
    use ControllerTrait;

    /**
     * 管理员列表
     * @param AdminsListRequest $adminsListRequest
     * @param AdminsRepository $adminsRepository
     * @return object
     */
    public function lst(AdminsListRequest $adminsListRequest, AdminsRepository $adminsRepository): object
    {
        // TODO: Implement lst() method.
        $where = $adminsListRequest->all();
        $page = $where['page'];
        $limit = $where['limit'];
        $list = [];
        $count = 0;
        $result = $adminsRepository::lst($where, $page, $limit);
        if($result){ $list = $adminsRepository::returnData($list); }
        $result = $adminsRepository::count($where);
        if($result){ list($count) = $adminsRepository::returnData([]); }
        return JsonExtend::success('菜单列表', compact('list', 'count'));
    }

    /**
     * 管理员添加
     * @param AdminsInsertRequest $adminsAddRequest
     * @param AdminsRepository $adminsRepository
     * @return object
     */
    public function insert(AdminsInsertRequest $adminsAddRequest, AdminsRepository $adminsRepository): object
    {
        // TODO: Implement insert() method.
        $data = $adminsAddRequest->all();
        $user = auth('login')->user();
        if(!$user->found){
            return JsonExtend::error('没有权限创建管理员');
        }
        $data['parent_id'] = $user->id;
        $bool = $adminsRepository::insert($data);
        if($bool){
            return JsonExtend::success($adminsRepository::returnMsg('添加成功'));
        }
        return JsonExtend::error($adminsRepository::returnMsg('添加失败'));
    }

    /**
     * 管理员修改
     * @param AdminsUpdateRequest $adminsModifyRequest
     * @param AdminsRepository $adminsRepository
     * @return object
     */
    public function update(AdminsUpdateRequest $adminsModifyRequest, AdminsRepository $adminsRepository): object
    {
        // TODO: Implement update() method.
        $data = $adminsModifyRequest->all();
        $id = (int)$data['id'];
        $user = auth('login')->user();
        if(!$user->found){
            return JsonExtend::error('没有权限修改管理员');
        }
        $admin['parent_id'] = $user->id;
        $bool = $adminsRepository::update($data, $id);
        if($bool){
            return JsonExtend::success($adminsRepository::returnMsg('修改成功'));
        }
        return JsonExtend::error($adminsRepository::returnMsg('修改失败'));
    }

    /**
     * 管理员删除
     * @param AdminsRequest $adminsRequest
     * @param AdminsRepository $adminsRepository
     * @return object
     */
    public function delete(AdminsRequest $adminsRequest, AdminsRepository $adminsRepository): object
    {
        // TODO: Implement delete() method.
        $id = (int)$adminsRequest->input('id', 0);
        if(!$id){
            return JsonExtend::error('参数错误');
        }
        $bool = $adminsRepository::delete($id);
        if($bool){
            return JsonExtend::success($adminsRepository::returnMsg('删除成功'));
        }
        return JsonExtend::error($adminsRepository::returnMsg('删除失败'));
    }

    public function message(AdminsRequest $adminsRequest, AdminsRepository $adminsRepository): object
    {
        // TODO: Implement message() method.
        $id = (int)$adminsRequest->input('id', 0);
        if(!$id){
            return JsonExtend::error('参数错误');
        }
        $bool = $adminsRepository::message($id);
        if($bool){
            return JsonExtend::success($adminsRepository::returnMsg('管理员信息'), $adminsRepository::returnData([]));
        }
        return JsonExtend::error($adminsRepository::returnMsg('删除失败'));
    }
}