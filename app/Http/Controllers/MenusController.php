<?php
/**
 * @author: cc_forever<1253705861@qq.com>
 * @day: 2020/7/21
 */

namespace App\Http\Controllers;

use App\CcForever\controller\BaseController;
use App\CcForever\extend\JsonExtend;
use App\CcForever\traits\ControllerTrait;
use App\Http\Requests\MenusAddRequest;
use App\Http\Requests\MenusListRequest;
use App\Http\Requests\MenusModifyRequest;
use App\Http\Requests\MenusRequest;
use App\Repositories\MenusRepository;

/**
 * 菜单控制器
 * Class MenusController
 * @package App\Http\Controllers
 */
class MenusController extends BaseController
{
    use  ControllerTrait;

    public function lst(MenusListRequest $menusListRequest, MenusRepository $menusRepository): object
    {
        // TODO: Implement lst() method.
        $where = $menusListRequest->all();
        $page = $where['page'];
        $limit = $where['limit'];
        $list = [];
        $count = 0;
        $result = $menusRepository::lst($where, $page, $limit);
        if($result){ $list = $menusRepository::returnData($list); }
        $result = $menusRepository::count($where);
        if($result){ list($count) = $menusRepository::returnData([]); }
        return JsonExtend::success('菜单列表', compact('list', 'count'));
    }

    public function add(MenusAddRequest $menusAddRequest, MenusRepository $menusRepository): object
    {
        // TODO: Implement add() method.
        $menu = $menusAddRequest->all();
        $bool = $menusRepository::add($menu);
        if($bool){
            return JsonExtend::success($menusRepository::returnMsg('添加成功'));
        }
        return JsonExtend::error($menusRepository::returnMsg('添加失败'));
    }

    public function modify(MenusModifyRequest $menusModifyRequest, MenusRepository $menusRepository): object
    {
        // TODO: Implement modify() method.
        $menu = $menusModifyRequest->all();
        $id = (int)$menu['id'];
        if(!$id){ return JsonExtend::error($menusRepository::returnMsg('参数错误')); }
        $bool = $menusRepository::modify($menu, $id);
        if($bool){
            return JsonExtend::success($menusRepository::returnMsg('修改成功'));
        }
        return JsonExtend::error($menusRepository::returnMsg('修改失败'));
    }

    public function recycle(MenusRequest $menusRequest, MenusRepository $menusRepository): object
    {
        // TODO: Implement recycle() method.
        $id = (int)$menusRequest->input('id');
        if(!$id){ return JsonExtend::error($menusRepository::returnMsg('参数错误')); }
        $bool = $menusRepository::recycle($id);
        if($bool){
            return JsonExtend::success($menusRepository::returnMsg('删除成功'));
        }
        return JsonExtend::error($menusRepository::returnMsg('删除失败'));

    }

    public function message(MenusRequest $menusRequest, MenusRepository $menusRepository): object
    {
        // TODO: Implement message() method.
        $id = (int)$menusRequest->input('id');
        if(!$id){ return JsonExtend::error($menusRepository::returnMsg('参数错误')); }
        $bool = $menusRepository::message($id);
        if($bool){
            return JsonExtend::success($menusRepository::returnMsg('菜单信息'), $menusRepository::returnData([]));
        }
        return JsonExtend::error($menusRepository::returnMsg('数据不存在'));

    }
}