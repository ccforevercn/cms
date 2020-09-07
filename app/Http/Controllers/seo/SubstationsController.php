<?php
/**
 * @author: cc_forever<1253705861@qq.com>
 * @day: 2020/9/7
 */
namespace App\Http\Controllers\seo;

use App\CcForever\controller\BaseController;
use App\CcForever\extend\JsonExtend;
use App\CcForever\traits\ControllerTrait;
use App\Http\Requests\Substations\SubstationsInsertRequest;
use App\Http\Requests\Substations\SubstationsListRequest;
use App\Http\Requests\Substations\SubstationsRequest;
use App\Http\Requests\Substations\SubstationsUpdateRequest;
use App\Repositories\SubstationsRepository;

/**
 * 分站控制器
 *
 * Class SubstationsController
 * @package App\Http\Controllers\seo
 */
class SubstationsController extends BaseController
{
    use ControllerTrait;

    /**
     * 分站列表
     *
     * @param SubstationsListRequest $substationsListRequest
     * @param SubstationsRepository $substationsRepository
     * @return object
     */
    public function lst(SubstationsListRequest $substationsListRequest, SubstationsRepository $substationsRepository): object
    {
        // TODO: Implement lst() method.
        $where = $substationsListRequest->all();
        $page = (int)$where['page'];
        $limit = (int)$where['limit'];
        $list = [];
        $result = $substationsRepository::lst($where, $page, $limit);
        if($result){ $list = $substationsRepository::returnData($list); }
        $result = $substationsRepository::count($where);
        if($result){ list($count) = $substationsRepository::returnData([0]); }
        return JsonExtend::success('分站列表', compact('list', 'count'));
    }

    /**
     * 分站添加
     *
     * @param SubstationsInsertRequest $substationsInsertRequest
     * @param SubstationsRepository $substationsRepository
     * @return object
     */
    public function insert(SubstationsInsertRequest $substationsInsertRequest, SubstationsRepository $substationsRepository): object
    {
        // TODO: Implement insert() method.
        $data = $substationsInsertRequest->all();
        $bool = $substationsRepository::insert($data);
        if($bool){
            return JsonExtend::success($substationsRepository::returnMsg('添加成功'));
        }
        return JsonExtend::error($substationsRepository::returnMsg('添加失败'));
    }

    /**
     * 分站修改
     *
     * @param SubstationsUpdateRequest $substationsUpdateRequest
     * @param SubstationsRepository $substationsRepository
     * @return object
     */
    public function update(SubstationsUpdateRequest $substationsUpdateRequest, SubstationsRepository $substationsRepository): object
    {
        // TODO: Implement update() method.
        $data = $substationsUpdateRequest->all();
        $id = (int)$data['id'];
        $bool = $substationsRepository::update($data, $id);
        if($bool){
            return JsonExtend::success($substationsRepository::returnMsg('修改成功'));
        }
        return JsonExtend::error($substationsRepository::returnMsg('修改失败'));
    }

    /**
     * 分站删除
     *
     * @param SubstationsRequest $substationsRequest
     * @param SubstationsRepository $substationsRepository
     * @return object
     */
    public function delete(SubstationsRequest $substationsRequest, SubstationsRepository $substationsRepository): object
    {
        // TODO: Implement message() method.
        $id = (int)$substationsRequest->input('id');
        $bool = $substationsRepository::delete($id);
        if($bool){
            return JsonExtend::success($substationsRepository::returnMsg('删除成功'));
        }
        return JsonExtend::error($substationsRepository::returnMsg('删除失败'));
    }

    /**
     * 分站查询
     *
     * @param SubstationsRequest $substationsRequest
     * @param SubstationsRepository $substationsRepository
     * @return object
     */
    public function message(SubstationsRequest $substationsRequest, SubstationsRepository $substationsRepository): object
    {
        // TODO: Implement delete() method.
        $id = (int)$substationsRequest->input('id');
        if(!$id){ return JsonExtend::error($substationsRepository::returnMsg('参数错误')); }
        $bool = $substationsRepository::message($id);
        if($bool){
            return JsonExtend::success($substationsRepository::returnMsg('分站信息'), $substationsRepository::returnData([]));
        }
        return JsonExtend::error($substationsRepository::returnMsg('数据不存在'));
    }
}
