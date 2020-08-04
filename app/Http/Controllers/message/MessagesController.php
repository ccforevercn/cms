<?php
/**
 * @author: cc_forever<1253705861@qq.com>
 * @day: 2020/8/3
 */

namespace App\Http\Controllers\message;

use App\CcForever\controller\BaseController;
use App\CcForever\extend\JsonExtend;
use App\CcForever\traits\ControllerTrait;
use App\Http\Requests\Messages\MessagesContentRequest;
use App\Http\Requests\Messages\MessagesInsertRequest;
use App\Http\Requests\Messages\MessagesListRequest;
use App\Http\Requests\Messages\MessagesRequest;
use App\Http\Requests\Messages\MessagesUpdateRequest;
use App\Repositories\MessagesRepository;

/**
 * 信息控制器
 *
 * Class MessagesController
 * @package App\Http\Controllers\message
 */
class MessagesController extends BaseController
{
    use ControllerTrait;

    /**
     * 信息列表
     *
     * @param MessagesListRequest $messagesListRequest
     * @param MessagesRepository $messagesRepository
     * @return object
     */
    public function lst(MessagesListRequest $messagesListRequest, MessagesRepository $messagesRepository): object
    {
        // TODO: Implement lst() method.
        $where = $messagesListRequest->all();
        $page = (int)$where['page'];
        $limit = (int)$where['limit'];
        $list = [];
        $result = $messagesRepository::lst($where, $page, $limit);
        if($result){ $list = $messagesRepository::returnData($list); }
        $result = $messagesRepository::count($where);
        if($result){ list($count) = $messagesRepository::returnData([0]); }
        return JsonExtend::success('栏目列表', compact('list', 'count'));
    }

    /**
     * 信息添加
     *
     * @param MessagesInsertRequest $messagesInsertRequest
     * @param MessagesRepository $messagesRepository
     * @return object
     */
    public function insert(MessagesInsertRequest $messagesInsertRequest, MessagesRepository $messagesRepository): object
    {
        // TODO: Implement insert() method.
        $data = $messagesInsertRequest->all();
        $admin = auth('login')->user();
        $data['admin_id'] = $admin->id;
        $data['username'] = $admin->username;
        $bool = $messagesRepository::insert($data);
        if($bool){
            return JsonExtend::success($messagesRepository::returnMsg('添加成功'));
        }
        return JsonExtend::error($messagesRepository::returnMsg('添加失败'));
    }

    /**
     * 信息修改
     *
     * @param MessagesUpdateRequest $messagesUpdateRequest
     * @param MessagesRepository $messagesRepository
     * @return object
     */
    public function update(MessagesUpdateRequest $messagesUpdateRequest, MessagesRepository $messagesRepository): object
    {
        // TODO: Implement update() method.
        $data = $messagesUpdateRequest->all();
        $id = (int)$data['id'];
        $admin = auth('login')->user();
        $data['admin_id'] = $admin->id;
        $data['username'] = $admin->username;
        $bool = $messagesRepository::update($data, $id);
        if($bool){
            return JsonExtend::success($messagesRepository::returnMsg('修改成功'));
        }
        return JsonExtend::error($messagesRepository::returnMsg('修改失败'));
    }

    /**
     * 信息删除
     *
     * @param MessagesRequest $messagesRequest
     * @param MessagesRepository $messagesRepository
     * @return object
     */
    public function delete(MessagesRequest $messagesRequest, MessagesRepository $messagesRepository): object
    {
        // TODO: Implement delete() method.
        $id = (int)$messagesRequest->input('id');
        $bool = $messagesRepository::delete($id);
        if($bool){
            return JsonExtend::success($messagesRepository::returnMsg('删除成功'));
        }
        return JsonExtend::error($messagesRepository::returnMsg('删除失败'));
    }

    /**
     * 信息信息
     *
     * @param MessagesRequest $messagesRequest
     * @param MessagesRepository $messagesRepository
     * @return object
     */
    public function message(MessagesRequest $messagesRequest, MessagesRepository $messagesRepository): object
    {
        // TODO: Implement message() method.
        $id = (int)$messagesRequest->input('id');
        if(!$id){ return JsonExtend::error($messagesRepository::returnMsg('参数错误')); }
        $bool = $messagesRepository::message($id);
        if($bool){
            return JsonExtend::success($messagesRepository::returnMsg('栏目信息'), $messagesRepository::returnData([]));
        }
        return JsonExtend::error($messagesRepository::returnMsg('数据不存在'));
    }

    /**
     * 信息内容 添加/修改
     * @param MessagesContentRequest $messagesContentRequest
     * @param MessagesRepository $messagesRepository
     * @return object
     */
    public function content(MessagesContentRequest $messagesContentRequest, MessagesRepository $messagesRepository): object
    {
        $data = $messagesContentRequest->all();
        $type = (bool)$data['type'];
        $bool = $messagesRepository::content($data, $type);
        if($bool){
            return JsonExtend::success($messagesRepository::returnMsg('内容信息'), $messagesRepository::returnData([]));
        }
        return JsonExtend::error($messagesRepository::returnMsg('内容信息不存在'));
    }

    /**
     * 信息 添加点击量
     *
     * @param MessagesRequest $messagesRequest
     * @param MessagesRepository $messagesRepository
     * @return object
     */
    public function click(MessagesRequest $messagesRequest, MessagesRepository $messagesRepository): object
    {
        $id = (int)$messagesRequest->input('id');
        $click = (int)$messagesRequest->input('click', 1);
        if(is_null($id)){ $click = 1; } // 如果没有登录添加的点击量为1
        $bool = $messagesRepository::click($id, $click);
        if($bool){
            return JsonExtend::success($messagesRepository::returnMsg('修改成功'));
        }
        return JsonExtend::error($messagesRepository::returnMsg('修改失败'));

    }

    /**
     * 信息 状态修改
     *
     * @param MessagesRequest $messagesRequest
     * @param MessagesRepository $messagesRepository
     * @return object
     */
    public function state(MessagesRequest $messagesRequest, MessagesRepository $messagesRepository): object
    {
        $id = (int)$messagesRequest->input('id');
        $type = $messagesRequest->input('type', '');
        $value = (int)$messagesRequest->input('value', 0);
        $bool = $messagesRepository::state($id, $type, $value);
        if($bool){
            return JsonExtend::success($messagesRepository::returnMsg('修改成功'));
        }
        return JsonExtend::error($messagesRepository::returnMsg('修改失败'));
    }
}
