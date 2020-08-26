<?php
/**
 * @author: cc_forever<1253705861@qq.com>
 * @day: 2020/7/31
 */

namespace App\Http\Controllers\message;

use App\CcForever\controller\BaseController;
use App\CcForever\extend\JsonExtend;
use App\CcForever\traits\ControllerTrait;
use App\Http\Requests\Columns\ColumnsContentRequest;
use App\Http\Requests\Columns\ColumnsInsertRequest;
use App\Http\Requests\Columns\ColumnsListRequest;
use App\Http\Requests\Columns\ColumnsRequest;
use App\Http\Requests\Columns\ColumnsUpdateRequest;
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
        if($result){ list($count) = $columnsRepository::returnData([0]); }
        return JsonExtend::success('栏目列表', compact('list', 'count'));
    }

    /**
     * 栏目添加
     *
     * @param ColumnsInsertRequest $columnsInsertRequest
     * @param ColumnsRepository $columnsRepository
     * @return object
     */
    public function insert(ColumnsInsertRequest $columnsInsertRequest, ColumnsRepository $columnsRepository): object
    {
        // TODO: Implement insert() method.
        $data = $columnsInsertRequest->all();
        $bool = $columnsRepository::insert($data);
        if($bool){
            return JsonExtend::success($columnsRepository::returnMsg('添加成功'));
        }
        return JsonExtend::error($columnsRepository::returnMsg('添加失败'));

    }

    /**
     * 栏目修改
     *
     * @param ColumnsUpdateRequest $columnsUpdateRequest
     * @param ColumnsRepository $columnsRepository
     * @return object
     */
    public function update(ColumnsUpdateRequest $columnsUpdateRequest, ColumnsRepository $columnsRepository): object
    {
        // TODO: Implement update() method.
        $data = $columnsUpdateRequest->all();
        $id = (int)$data['id'];
        $bool = $columnsRepository::update($data, $id);
        if($bool){
            return JsonExtend::success($columnsRepository::returnMsg('修改成功'));
        }
        return JsonExtend::error($columnsRepository::returnMsg('修改失败'));
    }

    /**
     * 栏目删除
     *
     * @param ColumnsRequest $columnsRequest
     * @param ColumnsRepository $columnsRepository
     * @return object
     */
    public function delete(ColumnsRequest $columnsRequest, ColumnsRepository $columnsRepository): object
    {
        // TODO: Implement delete() method.
        $id = (int)$columnsRequest->input('id');
        $bool = $columnsRepository::delete($id);
        if($bool){
            return JsonExtend::success($columnsRepository::returnMsg('删除成功'));
        }
        return JsonExtend::error($columnsRepository::returnMsg('删除失败'));
    }

    /**
     * 栏目信息
     *
     * @param ColumnsRequest $columnsRequest
     * @param ColumnsRepository $columnsRepository
     * @return object
     */
    public function message(ColumnsRequest $columnsRequest, ColumnsRepository $columnsRepository): object
    {
        // TODO: Implement message() method.
        $id = (int)$columnsRequest->input('id');
        if(!$id){ return JsonExtend::error($columnsRepository::returnMsg('参数错误')); }
        $bool = $columnsRepository::message($id);
        if($bool){
            return JsonExtend::success($columnsRepository::returnMsg('栏目信息'), $columnsRepository::returnData([]));
        }
        return JsonExtend::error($columnsRepository::returnMsg('数据不存在'));
    }

    /**
     * 栏目内容
     *
     * @param ColumnsContentRequest $columnsContentRequest
     * @param ColumnsRepository $columnsRepository
     * @return object
     */
    public function content(ColumnsContentRequest $columnsContentRequest, ColumnsRepository $columnsRepository): object
    {
        $data = $columnsContentRequest->all();
        $type = (bool)$data['type'];
        $bool = $columnsRepository::content($data, $type);
        if($bool){
            return JsonExtend::success($columnsRepository::returnMsg('内容信息'), $columnsRepository::returnData([]));
        }
        return JsonExtend::error($columnsRepository::returnMsg('内容信息不存在'));
    }

    /**
     * 栏目视图列表
     *
     * @param ColumnsRepository $columnsRepository
     * @return object
     */
    public function views(ColumnsRepository $columnsRepository): object
    {
        $bool = $columnsRepository::views();
        if($bool){
            return JsonExtend::success($columnsRepository::returnMsg('栏目视图列表'), $columnsRepository::returnData([]));
        }
        return JsonExtend::error($columnsRepository::returnMsg('栏目视图列表'));
    }

    /**
     * 栏目列表(全部)
     *
     * @param ColumnsRepository $columnsRepository
     * @return object
     */
    public function columns(ColumnsRepository $columnsRepository): object
    {
        $bool = $columnsRepository::columns();
        if($bool){
            return JsonExtend::success($columnsRepository::returnMsg('栏目视图列表'), $columnsRepository::returnData([]));
        }
        return JsonExtend::error($columnsRepository::returnMsg('栏目视图列表'));
    }
}