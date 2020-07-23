<?php
/**
 * @author: cc_forever<1253705861@qq.com>
 * @day: 2020/7/22
 */

namespace App\Http\Controllers;

use App\CcForever\controller\BaseController;
use App\CcForever\extend\JsonExtend;
use App\CcForever\traits\ControllerTrait;
use App\Http\Requests\AdminsAddRequest;
use App\Http\Requests\AdminsListRequest;
use App\Repositories\AdminsRepository;

/**
 * 管理员控制器
 * Class AdminController
 * @package App\Http\Controllers
 */
class AdminsController extends BaseController
{
    use ControllerTrait;

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

    public function add(AdminsAddRequest $adminsAddRequest, AdminsRepository $adminsRepository): object
    {
        // TODO: Implement add() method.
        $admin = $adminsAddRequest->all();
        $user = auth('login')->user();
        if(!$user->found){
            return JsonExtend::error('没有权限创建管理员');
        }
        $admin['parent_id'] = $user->id;
        $bool = $adminsRepository::add($admin);
        if($bool){
            return JsonExtend::success($adminsRepository::returnMsg('添加成功'));
        }
        return JsonExtend::error($adminsRepository::returnMsg('添加失败'));
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