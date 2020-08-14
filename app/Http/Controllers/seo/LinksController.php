<?php
/**
 * @author: cc_forever<1253705861@qq.com>
 * @day: 2020/8/14
 */

namespace App\Http\Controllers\seo;

use App\CcForever\controller\BaseController;
use App\CcForever\extend\JsonExtend;
use App\CcForever\traits\ControllerTrait;
use App\Http\Requests\Links\LinksInsertRequest;
use App\Http\Requests\Links\LinksListRequest;
use App\Http\Requests\Links\LinksRequest;
use App\Http\Requests\Links\LinksUpdateRequest;
use App\Repositories\LinksRepository;

/**
 * 友情链接控制器
 *
 * Class LinksController
 * @package App\Http\Controllers\seo
 */
class LinksController extends BaseController
{
    use ControllerTrait;

    /**
     * 友情链接列表
     *
     * @param LinksListRequest $linksListRequest
     * @param LinksRepository $linksRepository
     * @return object
     */
    public function lst(LinksListRequest $linksListRequest, LinksRepository $linksRepository): object
    {
        // TODO: Implement lst() method.
        $where = $linksListRequest->all();
        $page = (int)$where['page'];
        $limit = (int)$where['limit'];
        $list = [];
        $result = $linksRepository::lst($where, $page, $limit);
        if($result){ $list = $linksRepository::returnData($list); }
        $result = $linksRepository::count($where);
        if($result){ list($count) = $linksRepository::returnData([0]); }
        return JsonExtend::success('友情链接列表', compact('list', 'count'));
    }

    /**
     * 友情链接添加
     *
     * @param LinksInsertRequest $linksInsertRequest
     * @param LinksRepository $linksRepository
     * @return object
     */
    public function insert(LinksInsertRequest $linksInsertRequest, LinksRepository $linksRepository): object
    {
        // TODO: Implement insert() method.
        $data = $linksInsertRequest->all();
        $bool = $linksRepository::insert($data);
        if($bool){
            return JsonExtend::success($linksRepository::returnMsg('添加成功'));
        }
        return JsonExtend::error($linksRepository::returnMsg('添加失败'));
    }

    /**
     * 友情链接修改
     *
     * @param LinksUpdateRequest $linksUpdateRequest
     * @param LinksRepository $linksRepository
     * @return object
     */
    public function update(LinksUpdateRequest $linksUpdateRequest, LinksRepository $linksRepository): object
    {
        // TODO: Implement update() method.
        $data = $linksUpdateRequest->all();
        $id = (int)$data['id'];
        $bool = $linksRepository::update($data, $id);
        if($bool){
            return JsonExtend::success($linksRepository::returnMsg('修改成功'));
        }
        return JsonExtend::error($linksRepository::returnMsg('修改失败'));
    }

    /**
     * 友情链接删除
     *
     * @param LinksRequest $linksRequest
     * @param LinksRepository $linksRepository
     * @return object
     */
    public function delete(LinksRequest $linksRequest, LinksRepository $linksRepository): object
    {
        // TODO: Implement delete() method.
        $id = (int)$linksRequest->input('id');
        $bool = $linksRepository::delete($id);
        if($bool){
            return JsonExtend::success($linksRepository::returnMsg('删除成功'));
        }
        return JsonExtend::error($linksRepository::returnMsg('删除失败'));
    }

    /**
     * 友情链接查询
     *
     * @param LinksRequest $linksRequest
     * @param LinksRepository $linksRepository
     * @return object
     */
    public function message(LinksRequest $linksRequest, LinksRepository $linksRepository): object
    {
        // TODO: Implement message() method.
        $id = (int)$linksRequest->input('id');
        if(!$id){ return JsonExtend::error($linksRepository::returnMsg('参数错误')); }
        $bool = $linksRepository::message($id);
        if($bool){
            return JsonExtend::success($linksRepository::returnMsg('轮播图信息'), $linksRepository::returnData([]));
        }
        return JsonExtend::error($linksRepository::returnMsg('数据不存在'));
    }
}