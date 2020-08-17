<?php
/**
 * @author: cc_forever<1253705861@qq.com>
 * @day: 2020/8/17
 */
namespace App\Http\Controllers\seo;

use App\CcForever\controller\BaseController;
use App\CcForever\extend\JsonExtend;
use App\CcForever\traits\ControllerTrait;
use App\Http\Requests\Partners\PartnersInsertRequest;
use App\Http\Requests\Partners\PartnersListRequest;
use App\Http\Requests\Partners\PartnersRequest;
use App\Http\Requests\Partners\PartnersUpdateRequest;
use App\Repositories\PartnersRepository;

/**
 * 合作伙伴控制器
 *
 * Class PartnersController
 * @package App\Http\Controllers\seo
 */
class PartnersController extends BaseController
{
    use ControllerTrait;

    /**
     * 合作伙伴列表
     *
     * @param PartnersListRequest $partnersListRequest
     * @param PartnersRepository $partnersRepository
     * @return object
     */
    public function lst(PartnersListRequest $partnersListRequest, PartnersRepository $partnersRepository): object
    {
        // TODO: Implement lst() method.
        $where = $partnersListRequest->all();
        $page = (int)$where['page'];
        $limit = (int)$where['limit'];
        $list = [];
        $result = $partnersRepository::lst($where, $page, $limit);
        if($result){ $list = $partnersRepository::returnData($list); }
        $result = $partnersRepository::count($where);
        if($result){ list($count) = $partnersRepository::returnData([0]); }
        return JsonExtend::success('合作伙伴列表', compact('list', 'count'));
    }

    /**
     * 合作伙伴添加
     *
     * @param PartnersInsertRequest $partnersInsertRequest
     * @param PartnersRepository $partnersRepository
     * @return object
     */
    public function insert(PartnersInsertRequest $partnersInsertRequest, PartnersRepository $partnersRepository): object
    {
        // TODO: Implement insert() method.
        $data = $partnersInsertRequest->all();
        $bool = $partnersRepository::insert($data);
        if($bool){
            return JsonExtend::success($partnersRepository::returnMsg('添加成功'));
        }
        return JsonExtend::error($partnersRepository::returnMsg('添加失败'));
    }

    /**
     * 合作伙伴修改
     *
     * @param PartnersUpdateRequest $partnersUpdateRequest
     * @param PartnersRepository $partnersRepository
     * @return object
     */
    public function update(PartnersUpdateRequest $partnersUpdateRequest, PartnersRepository $partnersRepository): object
    {
        // TODO: Implement update() method.
        $data = $partnersUpdateRequest->all();
        $id = (int)$data['id'];
        $bool = $partnersRepository::update($data, $id);
        if($bool){
            return JsonExtend::success($partnersRepository::returnMsg('修改成功'));
        }
        return JsonExtend::error($partnersRepository::returnMsg('修改失败'));
    }

    /**
     * 合作伙伴删除
     *
     * @param PartnersRequest $partnersRequest
     * @param PartnersRepository $partnersRepository
     * @return object
     */
    public function delete(PartnersRequest $partnersRequest, PartnersRepository $partnersRepository): object
    {
        // TODO: Implement delete() method.
        $id = (int)$partnersRequest->input('id');
        $bool = $partnersRepository::delete($id);
        if($bool){
            return JsonExtend::success($partnersRepository::returnMsg('删除成功'));
        }
        return JsonExtend::error($partnersRepository::returnMsg('删除失败'));
    }

    /**
     * 合作伙伴信息
     *
     * @param PartnersRequest $partnersRequest
     * @param PartnersRepository $partnersRepository
     * @return object
     */
    public function message(PartnersRequest $partnersRequest, PartnersRepository $partnersRepository): object
    {
        // TODO: Implement message() method.
        $id = (int)$partnersRequest->input('id');
        if(!$id){ return JsonExtend::error($partnersRepository::returnMsg('参数错误')); }
        $bool = $partnersRepository::message($id);
        if($bool){
            return JsonExtend::success($partnersRepository::returnMsg('合作伙伴信息'), $partnersRepository::returnData([]));
        }
        return JsonExtend::error($partnersRepository::returnMsg('数据不存在'));
    }
}