<?php
/**
 * @author: cc_forever<1253705861@qq.com>
 * @day: 2020/8/3
 */

namespace App\Http\Controllers\message;

use App\CcForever\controller\BaseController;
use App\CcForever\extend\JsonExtend;
use App\CcForever\traits\ControllerTrait;
use App\Http\Requests\Tags\TagsInsertRequest;
use App\Http\Requests\Tags\TagsListRequest;
use App\Http\Requests\Tags\TagsRequest;
use App\Http\Requests\Tags\TagsUpdateRequest;
use App\Repositories\TagsRepository;

/**
 * 标签控制器
 *
 * Class TagsController
 * @package App\Http\Controllers\message
 */
class TagsController extends  BaseController
{
    use ControllerTrait;

    /**
     * 标签列表
     *
     * @param TagsListRequest $tagsListRequest
     * @param TagsRepository $tagsRepository
     * @return object
     */
    public function lst(TagsListRequest $tagsListRequest, TagsRepository $tagsRepository): object
    {
        // TODO: Implement lst() method.
        $where = $tagsListRequest->all();
        $page = (int)$where['page'];
        $limit = (int)$where['limit'];
        $list = [];
        $result = $tagsRepository::lst($where, $page, $limit);
        if($result){ $list = $tagsRepository::returnData($list); }
        $result = $tagsRepository::count($where);
        if($result){ list($count) = $tagsRepository::returnData([0]); }
        return JsonExtend::success('标签列表', compact('list', 'count'));
    }

    /**
     * 标签添加
     *
     * @param TagsInsertRequest $tagsInsertRequest
     * @param TagsRepository $tagsRepository
     * @return object
     */
    public function insert(TagsInsertRequest $tagsInsertRequest, TagsRepository $tagsRepository): object
    {
        // TODO: Implement insert() method.
        $data = $tagsInsertRequest->all();
        $bool = $tagsRepository::insert($data);
        if($bool){
            return JsonExtend::success($tagsRepository::returnMsg('添加成功'));
        }
        return JsonExtend::error($tagsRepository::returnMsg('添加失败'));
    }

    /**
     * 标签修改
     *
     * @param TagsUpdateRequest $tagsUpdateRequest
     * @param TagsRepository $tagsRepository
     * @return object
     */
    public function update(TagsUpdateRequest $tagsUpdateRequest, TagsRepository $tagsRepository): object
    {
        // TODO: Implement update() method.
        $data = $tagsUpdateRequest->all();
        $id = (int)$data['id'];
        $bool = $tagsRepository::update($data, $id);
        if($bool){
            return JsonExtend::success($tagsRepository::returnMsg('修改成功'));
        }
        return JsonExtend::error($tagsRepository::returnMsg('修改失败'));
    }

    /**
     * 标签删除
     *
     * @param TagsRequest $tagsRequest
     * @param TagsRepository $tagsRepository
     * @return object
     */
    public function delete(TagsRequest $tagsRequest, TagsRepository $tagsRepository): object
    {
        // TODO: Implement delete() method.
        $id = (int)$tagsRequest->input('id');
        $bool = $tagsRepository::delete($id);
        if($bool){
            return JsonExtend::success($tagsRepository::returnMsg('删除成功'));
        }
        return JsonExtend::error($tagsRepository::returnMsg('删除失败'));
    }

    /**
     * 标签信息
     *
     * @param TagsRequest $tagsRequest
     * @param TagsRepository $tagsRepository
     * @return object
     */
    public function message(TagsRequest $tagsRequest, TagsRepository $tagsRepository): object
    {
        // TODO: Implement message() method.
        $id = (int)$tagsRequest->input('id');
        if(!$id){ return JsonExtend::error($tagsRepository::returnMsg('参数错误')); }
        $bool = $tagsRepository::message($id);
        if($bool){
            return JsonExtend::success($tagsRepository::returnMsg('标签信息'), $tagsRepository::returnData([]));
        }
        return JsonExtend::error($tagsRepository::returnMsg('数据不存在'));
    }

}