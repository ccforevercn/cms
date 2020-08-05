<?php
/**
 * @author: cc_forever<1253705861@qq.com>
 * @day: 2020/8/5
 */
namespace App\Http\Controllers\markets;

use App\CcForever\controller\BaseController;
use App\CcForever\extend\JsonExtend;
use App\CcForever\traits\ControllerTrait;
use App\Http\Requests\Banners\BannersInsertRequest;
use App\Http\Requests\Banners\BannersListRequest;
use App\Http\Requests\Banners\BannersRequest;
use App\Http\Requests\Banners\BannersUpdateRequest;
use App\Repositories\BannersRepository;

/**
 * 轮播图控制器
 *
 * Class BannersController
 * @package App\Http\Controllers\markers
 */
class BannersController extends BaseController
{
    use ControllerTrait;

    /**
     * 轮播图列表
     *
     * @param BannersListRequest $bannersListRequest
     * @param BannersRepository $bannersRepository
     * @return object
     */
    public function lst(BannersListRequest $bannersListRequest, BannersRepository $bannersRepository): object
    {
        // TODO: Implement lst() method.
        $where = $bannersListRequest->all();
        $page = (int)$where['page'];
        $limit = (int)$where['limit'];
        $list = [];
        $result = $bannersRepository::lst($where, $page, $limit);
        if($result){ $list = $bannersRepository::returnData($list); }
        $result = $bannersRepository::count($where);
        if($result){ list($count) = $bannersRepository::returnData([0]); }
        return JsonExtend::success('轮播图列表', compact('list', 'count'));
    }

    /**
     * 轮播图添加
     *
     * @param BannersInsertRequest $bannersInsertRequest
     * @param BannersRepository $bannersRepository
     * @return object
     */
    public function insert(BannersInsertRequest $bannersInsertRequest, BannersRepository $bannersRepository): object
    {
        // TODO: Implement insert() method.
        $data = $bannersInsertRequest->all();
        $bool = $bannersRepository::insert($data);
        if($bool){
            return JsonExtend::success($bannersRepository::returnMsg('添加成功'));
        }
        return JsonExtend::error($bannersRepository::returnMsg('添加失败'));
    }

    /**
     * 轮播图修改
     *
     * @param BannersUpdateRequest $bannersUpdateRequest
     * @param BannersRepository $bannersRepository
     * @return object
     */
    public function update(BannersUpdateRequest $bannersUpdateRequest, BannersRepository $bannersRepository): object
    {
        // TODO: Implement update() method.
        $data = $bannersUpdateRequest->all();
        $id = (int)$data['id'];
        $bool = $bannersRepository::update($data, $id);
        if($bool){
            return JsonExtend::success($bannersRepository::returnMsg('修改成功'));
        }
        return JsonExtend::error($bannersRepository::returnMsg('修改失败'));
    }

    /**
     * 轮播图删除
     *
     * @param BannersRequest $bannersRequest
     * @param BannersRepository $bannersRepository
     * @return object
     */
    public function delete(BannersRequest $bannersRequest, BannersRepository $bannersRepository): object
    {
        // TODO: Implement delete() method.
        $id = (int)$bannersRequest->input('id');
        $bool = $bannersRepository::delete($id);
        if($bool){
            return JsonExtend::success($bannersRepository::returnMsg('删除成功'));
        }
        return JsonExtend::error($bannersRepository::returnMsg('删除失败'));
    }

    /**
     * 轮播图信息
     *
     * @param BannersRequest $bannersRequest
     * @param BannersRepository $bannersRepository
     * @return object
     */
    public function message(BannersRequest $bannersRequest, BannersRepository $bannersRepository): object
    {
        // TODO: Implement message() method.
        $id = (int)$bannersRequest->input('id');
        if(!$id){ return JsonExtend::error($bannersRepository::returnMsg('参数错误')); }
        $bool = $bannersRepository::message($id);
        if($bool){
            return JsonExtend::success($bannersRepository::returnMsg('轮播图信息'), $bannersRepository::returnData([]));
        }
        return JsonExtend::error($bannersRepository::returnMsg('数据不存在'));
    }

    /**
     * 轮播图
     *
     * @param BannersRequest $bannersRequest
     * @param BannersRepository $bannersRepository
     * @return object
     */
    public function banners(BannersRequest $bannersRequest, BannersRepository $bannersRepository): object
    {
        $type = (int)$bannersRequest->input('type', 0);
        $bool = $bannersRepository::banners($type);
        if($bool){
            return JsonExtend::success($bannersRepository::returnMsg('轮播图'), $bannersRepository::returnData([]));
        }
        return JsonExtend::error($bannersRepository::returnMsg('数据不存在'));

    }
}
