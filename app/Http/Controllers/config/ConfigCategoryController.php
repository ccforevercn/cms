<?php
/**
 * @author: cc_forever<1253705861@qq.com>
 * @day: 2020/8/4
 */
namespace App\Http\Controllers\config;

use App\CcForever\controller\BaseController;
use App\CcForever\extend\JsonExtend;
use App\CcForever\traits\ControllerTrait;
use App\Http\Requests\ConfigCategory\ConfigCategoryInsertRequest;
use App\Http\Requests\ConfigCategory\ConfigCategoryListRequest;
use App\Http\Requests\ConfigCategory\ConfigCategoryRequest;
use App\Http\Requests\ConfigCategory\ConfigCategoryUpdateRequest;
use App\Repositories\ConfigCategoryRepository;

/**
 * 配置分类控制器
 *
 * Class ConfigCategoryController
 * @package App\Http\Controllers\config
 */
class ConfigCategoryController extends BaseController
{
    use ControllerTrait;

    /**
     * 配置分类列表
     *
     * @param ConfigCategoryListRequest $configCategoryListRequest
     * @param ConfigCategoryRepository $configCategoryRepository
     * @return object
     */
    public function lst(ConfigCategoryListRequest $configCategoryListRequest, ConfigCategoryRepository $configCategoryRepository): object
    {
        // TODO: Implement lst() method.
        $where = $configCategoryListRequest->all();
        $page = (int)$where['page'];
        $limit = (int)$where['limit'];
        $list = [];
        $result = $configCategoryRepository::lst($where, $page, $limit);
        if($result){ $list = $configCategoryRepository::returnData($list); }
        $result = $configCategoryRepository::count($where);
        if($result){ list($count) = $configCategoryRepository::returnData([0]); }
        return JsonExtend::success('配置分类列表', compact('list', 'count'));
    }

    /**
     * 配置分类添加
     *
     * @param ConfigCategoryInsertRequest $configCategoryInsertRequest
     * @param ConfigCategoryRepository $configCategoryRepository
     * @return object
     */
    public function insert(ConfigCategoryInsertRequest $configCategoryInsertRequest, ConfigCategoryRepository $configCategoryRepository): object
    {
        // TODO: Implement insert() method.
        $data = $configCategoryInsertRequest->all();
        $bool = $configCategoryRepository::insert($data);
        if($bool){
            return JsonExtend::success($configCategoryRepository::returnMsg('添加成功'));
        }
        return JsonExtend::error($configCategoryRepository::returnMsg('添加失败'));
    }

    /**
     * 配置分类修改
     *
     * @param ConfigCategoryUpdateRequest $configCategoryUpdateRequest
     * @param ConfigCategoryRepository $configCategoryRepository
     * @return object
     */
    public function update(ConfigCategoryUpdateRequest $configCategoryUpdateRequest, ConfigCategoryRepository $configCategoryRepository): object
    {
        // TODO: Implement update() method.
        $data = $configCategoryUpdateRequest->all();
        $id = (int)$data['id'];
        $bool = $configCategoryRepository::update($data, $id);
        if($bool){
            return JsonExtend::success($configCategoryRepository::returnMsg('修改成功'));
        }
        return JsonExtend::error($configCategoryRepository::returnMsg('修改失败'));
    }

    /**
     * 配置分类删除
     *
     * @param ConfigCategoryRequest $configCategoryRequest
     * @param ConfigCategoryRepository $configCategoryRepository
     * @return object
     */
    public function delete(ConfigCategoryRequest $configCategoryRequest, ConfigCategoryRepository $configCategoryRepository): object
    {
        // TODO: Implement delete() method.
        $id = (int)$configCategoryRequest->input('id');
        $bool = $configCategoryRepository::delete($id);
        if($bool){
            return JsonExtend::success($configCategoryRepository::returnMsg('删除成功'));
        }
        return JsonExtend::error($configCategoryRepository::returnMsg('删除失败'));
    }

    /**
     * 配置分类信息
     *
     * @param ConfigCategoryRequest $configCategoryRequest
     * @param ConfigCategoryRepository $configCategoryRepository
     * @return object
     */
    public function message(ConfigCategoryRequest $configCategoryRequest, ConfigCategoryRepository $configCategoryRepository): object
    {
        // TODO: Implement message() method.
        $id = (int)$configCategoryRequest->input('id');
        if(!$id){ return JsonExtend::error($configCategoryRepository::returnMsg('参数错误')); }
        $bool = $configCategoryRepository::message($id);
        if($bool){
            return JsonExtend::success($configCategoryRepository::returnMsg('配置分类信息'), $configCategoryRepository::returnData([]));
        }
        return JsonExtend::error($configCategoryRepository::returnMsg('数据不存在'));
    }

    /**
     * 配置分类列表(all)
     *
     * @param ConfigCategoryRepository $configCategoryRepository
     * @return object
     */
    public function category(ConfigCategoryRepository $configCategoryRepository): object
    {
        $bool = $configCategoryRepository::category();
        if($bool){
            return JsonExtend::success($configCategoryRepository::returnMsg('配置分类列表'), $configCategoryRepository::returnData([]));
        }
        return JsonExtend::error($configCategoryRepository::returnMsg('配置分类列表'));
    }
}
