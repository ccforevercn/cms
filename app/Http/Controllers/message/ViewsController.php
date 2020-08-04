<?php
/**
 * @author: cc_forever<1253705861@qq.com>
 * @day: 2020/8/4
 */

namespace App\Http\Controllers\message;

use App\CcForever\controller\BaseController;
use App\CcForever\extend\JsonExtend;
use App\CcForever\traits\ControllerTrait;
use App\Http\Requests\Views\ViewsInsertRequest;
use App\Http\Requests\Views\ViewsListRequest;
use App\Http\Requests\Views\ViewsRequest;
use App\Http\Requests\Views\ViewsUpdateRequest;
use App\Repositories\ViewsRepository;

/**
 * 视图控制器
 *
 * Class ViewsController
 * @package App\Http\Controllers\message
 */
class ViewsController extends BaseController
{
    use ControllerTrait;

    /**
     * 视图列表
     *
     * @param ViewsListRequest $viewsListRequest
     * @param ViewsRepository $viewsRepository
     * @return object
     */
    public function lst(ViewsListRequest $viewsListRequest, ViewsRepository $viewsRepository): object
    {
        // TODO: Implement lst() method.
        $where = $viewsListRequest->all();
        $page = (int)$where['page'];
        $limit = (int)$where['limit'];
        $list = [];
        $result = $viewsRepository::lst($where, $page, $limit);
        if($result){ $list = $viewsRepository::returnData($list); }
        $result = $viewsRepository::count($where);
        if($result){ list($count) = $viewsRepository::returnData([0]); }
        return JsonExtend::success('视图列表', compact('list', 'count'));
    }

    /**
     * 视图添加
     *
     * @param ViewsInsertRequest $viewsInsertRequest
     * @param ViewsRepository $viewsRepository
     * @return object
     */
    public function insert(ViewsInsertRequest $viewsInsertRequest, ViewsRepository $viewsRepository): object
    {
        // TODO: Implement insert() method.
        $data = $viewsInsertRequest->all();
        $bool = $viewsRepository::insert($data);
        if($bool){
            return JsonExtend::success($viewsRepository::returnMsg('添加成功'));
        }
        return JsonExtend::error($viewsRepository::returnMsg('添加失败'));
    }

    /**
     * 视图修改
     *
     * @param ViewsUpdateRequest $viewsUpdateRequest
     * @param ViewsRepository $viewsRepository
     * @return object
     */
    public function update(ViewsUpdateRequest $viewsUpdateRequest, ViewsRepository $viewsRepository): object
    {
        // TODO: Implement update() method.
        $data = $viewsUpdateRequest->all();
        $id = (int)$data['id'];
        $bool = $viewsRepository::update($data, $id);
        if($bool){
            return JsonExtend::success($viewsRepository::returnMsg('修改成功'));
        }
        return JsonExtend::error($viewsRepository::returnMsg('修改失败'));
    }

    /**
     * 视图修改
     *
     * @param ViewsRequest $viewsRequest
     * @param ViewsRepository $viewsRepository
     * @return object
     */
    public function delete(ViewsRequest $viewsRequest, ViewsRepository $viewsRepository): object
    {
        // TODO: Implement delete() method.
        $id = (int)$viewsRequest->input('id');
        $bool = $viewsRepository::delete($id);
        if($bool){
            return JsonExtend::success($viewsRepository::returnMsg('删除成功'));
        }
        return JsonExtend::error($viewsRepository::returnMsg('删除失败'));
    }

    /**
     * 视图信息
     *
     * @param ViewsRequest $viewsRequest
     * @param ViewsRepository $viewsRepository
     * @return object
     */
    public function message(ViewsRequest $viewsRequest, ViewsRepository $viewsRepository): object
    {
        // TODO: Implement message() method.
        $id = (int)$viewsRequest->input('id');
        if(!$id){ return JsonExtend::error($viewsRepository::returnMsg('参数错误')); }
        $bool = $viewsRepository::message($id);
        if($bool){
            return JsonExtend::success($viewsRepository::returnMsg('标签信息'), $viewsRepository::returnData([]));
        }
        return JsonExtend::error($viewsRepository::returnMsg('数据不存在'));
    }
}
