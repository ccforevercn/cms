<?php
/**
 * @author: cc_forever<1253705861@qq.com>
 * @day: 2020/7/21
 */

namespace App\Http\Controllers\system;

use App\CcForever\controller\BaseController;
use App\CcForever\extend\JsonExtend;
use App\CcForever\traits\ControllerTrait;
use App\Http\Requests\Menus\MenusInsertRequest;
use App\Http\Requests\Menus\MenusListRequest;
use App\Http\Requests\Menus\MenusUpdateRequest;
use App\Http\Requests\Menus\MenusRequest;
use App\Repositories\MenusRepository;

/**
 * 菜单控制器
 * Class MenusController
 * @package App\Http\Controllers
 */
class MenusController extends BaseController
{
    use  ControllerTrait;

    /**
     * 菜单列表
     * @param MenusListRequest $menusListRequest
     * @param MenusRepository $menusRepository
     * @return object
     */
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
        if($result){ list($count) = $menusRepository::returnData([0]); }
        return JsonExtend::success('菜单列表', compact('list', 'count'));
    }

    /**
     * 菜单添加
     * @param MenusInsertRequest $menusAddRequest
     * @param MenusRepository $menusRepository
     * @return object
     */
    public function insert(MenusInsertRequest $menusAddRequest, MenusRepository $menusRepository): object
    {
        // TODO: Implement insert() method.
        $menu = $menusAddRequest->all();
        $bool = $menusRepository::insert($menu);
        if($bool){
            return JsonExtend::success($menusRepository::returnMsg('添加成功'));
        }
        return JsonExtend::error($menusRepository::returnMsg('添加失败'));
    }

    /**
     * 菜单修改
     * @param MenusUpdateRequest $menusModifyRequest
     * @param MenusRepository $menusRepository
     * @return object
     */
    public function update(MenusUpdateRequest $menusModifyRequest, MenusRepository $menusRepository): object
    {
        // TODO: Implement update() method.
        $menu = $menusModifyRequest->all();
        $id = (int)$menu['id'];
        if(!$id){ return JsonExtend::error($menusRepository::returnMsg('参数错误')); }
        $bool = $menusRepository::update($menu, $id);
        if($bool){
            return JsonExtend::success($menusRepository::returnMsg('修改成功'));
        }
        return JsonExtend::error($menusRepository::returnMsg('修改失败'));
    }

    /**
     * 菜单删除
     * @param MenusRequest $menusRequest
     * @param MenusRepository $menusRepository
     * @return object
     */
    public function delete(MenusRequest $menusRequest, MenusRepository $menusRepository): object
    {
        // TODO: Implement delete() method.
        $id = (int)$menusRequest->input('id');
        if(!$id){ return JsonExtend::error($menusRepository::returnMsg('参数错误')); }
        $bool = $menusRepository::delete($id);
        if($bool){
            return JsonExtend::success($menusRepository::returnMsg('删除成功'));
        }
        return JsonExtend::error($menusRepository::returnMsg('删除失败'));

    }

    /**
     * 菜单信息
     * @param MenusRequest $menusRequest
     * @param MenusRepository $menusRepository
     * @return object
     */
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

    /**
     * 菜单按钮(后台左侧菜单)
     * @param MenusRequest $menusRequest
     * @param MenusRepository $menusRepository
     * @return object
     */
    public function button(MenusRequest $menusRequest, MenusRepository $menusRepository): object
    {
        $id = (int)$menusRequest->input('id'); // 管理员编号
        $loginId = auth('login')->id(); // 当前登录的管理员编号
        if($loginId !== $id){ return JsonExtend::error('权限不足'); } // 两个编号不相同
        $bool = $menusRepository::button($id);
        if($bool){
            return JsonExtend::success($menusRepository::returnMsg('按钮列表'), $menusRepository::returnData([]));
        }
        return JsonExtend::error($menusRepository::returnMsg('权限不足'));
    }

    /**
     * 所有菜单
     *
     * @param MenusRequest $menusRequest
     * @param MenusRepository $menusRepository
     * @return object
     */
    public function menus(MenusRequest $menusRequest, MenusRepository $menusRepository): object
    {
        $id = (int)$menusRequest->input('id'); // 管理员编号
        $user = auth('login')->user(); // 当前登录的管理员信息
        $adminId = (int)$user['id']; // 管理员编号
        $ruleId = (int)$user['rule_id']; // 管理员规则编号
        if($adminId !== $id){ return JsonExtend::error('权限不足'); } // 两个编号不相同
        $bool = $menusRepository::menus($adminId, $ruleId);
        if($bool){
            return JsonExtend::success($menusRepository::returnMsg('菜单列表'), $menusRepository::returnData([]));
        }
        return JsonExtend::error($menusRepository::returnMsg('权限不足'));
    }
}