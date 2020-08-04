<?php
/**
 * @author: cc_forever<1253705861@qq.com>
 * @day: 2020/8/4
 */
namespace App\Http\Controllers\config;

use App\CcForever\controller\BaseController;
use App\CcForever\extend\JsonExtend;
use App\CcForever\traits\ControllerTrait;
use App\Http\Requests\ConfigMessage\ConfigMessageInsertRequest;
use App\Http\Requests\ConfigMessage\ConfigMessageListRequest;
use App\Http\Requests\ConfigMessage\ConfigMessageRequest;
use App\Http\Requests\ConfigMessage\ConfigMessageUpdateRequest;
use App\Repositories\ConfigMessageRepository;

/**
 * 配置信息控制器
 *
 * Class ConfigMessageController
 * @package App\Http\Controllers\config
 */
class ConfigMessageController extends BaseController
{
    use ControllerTrait;

    /**
     * 配置信息列表
     *
     * @param ConfigMessageListRequest $configMessageListRequest
     * @param ConfigMessageRepository $configMessageRepository
     * @return object
     */
    public function lst(ConfigMessageListRequest $configMessageListRequest, ConfigMessageRepository $configMessageRepository): object
    {
        // TODO: Implement lst() method.
        $where = $configMessageListRequest->all();
        $page = (int)$where['page'];
        $limit = (int)$where['limit'];
        $list = [];
        $result = $configMessageRepository::lst($where, $page, $limit);
        if($result){ $list = $configMessageRepository::returnData($list); }
        $result = $configMessageRepository::count($where);
        if($result){ list($count) = $configMessageRepository::returnData([0]); }
        return JsonExtend::success('配置信息列表', compact('list', 'count'));
    }

    /**
     * 配置信息添加
     *
     * @param ConfigMessageInsertRequest $configMessageInsertRequest
     * @param ConfigMessageRepository $configMessageRepository
     * @return object
     */
    public function insert(ConfigMessageInsertRequest $configMessageInsertRequest, ConfigMessageRepository $configMessageRepository): object
    {
        // TODO: Implement insert() method.
        $data = $configMessageInsertRequest->all();
        $bool = $configMessageRepository::insert($data);
        if($bool){
            return JsonExtend::success($configMessageRepository::returnMsg('添加成功'));
        }
        return JsonExtend::error($configMessageRepository::returnMsg('添加失败'));
    }

    /**
     * 配置信息修改
     *
     * @param ConfigMessageUpdateRequest $configMessageUpdateRequest
     * @param ConfigMessageRepository $configMessageRepository
     * @return object
     */
    public function update(ConfigMessageUpdateRequest $configMessageUpdateRequest, ConfigMessageRepository $configMessageRepository): object
    {
        // TODO: Implement update() method.
        $data = $configMessageUpdateRequest->all();
        $id = (int)$data['id'];
        $bool = $configMessageRepository::update($data, $id);
        if($bool){
            return JsonExtend::success($configMessageRepository::returnMsg('修改成功'));
        }
        return JsonExtend::error($configMessageRepository::returnMsg('修改失败'));
    }

    /**
     * 配置信息删除
     *
     * @param ConfigMessageRequest $configMessageRequest
     * @param ConfigMessageRepository $configMessageRepository
     * @return object
     */
    public function delete(ConfigMessageRequest $configMessageRequest, ConfigMessageRepository $configMessageRepository): object
    {
        // TODO: Implement delete() method.
        $id = (int)$configMessageRequest->input('id');
        $bool = $configMessageRepository::delete($id);
        if($bool){
            return JsonExtend::success($configMessageRepository::returnMsg('删除成功'));
        }
        return JsonExtend::error($configMessageRepository::returnMsg('删除失败'));
    }

    /**
     * 配置信息
     *
     * @param ConfigMessageRequest $configMessageRequest
     * @param ConfigMessageRepository $configMessageRepository
     * @return object
     */
    public function message(ConfigMessageRequest $configMessageRequest, ConfigMessageRepository $configMessageRepository): object
    {
        // TODO: Implement message() method.
        $id = (int)$configMessageRequest->input('id');
        if(!$id){ return JsonExtend::error($configMessageRepository::returnMsg('参数错误')); }
        $bool = $configMessageRepository::message($id);
        if($bool){
            return JsonExtend::success($configMessageRepository::returnMsg('配置栏目信息'), $configMessageRepository::returnData([]));
        }
        return JsonExtend::error($configMessageRepository::returnMsg('数据不存在'));
    }
}
