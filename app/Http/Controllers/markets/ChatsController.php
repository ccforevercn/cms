<?php
/**
 * @author: cc_forever<1253705861@qq.com>
 * @day: 2020/8/7
 */
namespace App\Http\Controllers\markets;

use App\CcForever\controller\BaseController;
use App\CcForever\extend\JsonExtend;
use App\CcForever\traits\ControllerTrait;
use App\Http\Requests\Chats\ChatsChatsRequest;
use App\Http\Requests\Chats\ChatsListRequest;
use App\Http\Requests\Chats\ChatsSeeRequest;
use App\Http\Requests\Chats\ChatsUsersRequest;
use App\Repositories\ChatsRepository;

/**
 * 留言控制器
 *
 * Class ChatsController
 * @package App\Http\Controllers\markets
 */
class ChatsController extends BaseController
{
    use ControllerTrait;

    /**
     * 留言列表
     *
     * @param ChatsListRequest $chatsListRequest
     * @param ChatsRepository $chatsRepository
     * @return object
     */
    public function lst(ChatsListRequest $chatsListRequest, ChatsRepository $chatsRepository): object
    {
        // TODO: Implement lst() method.
        $where = $chatsListRequest->all();
        $page = (int)$where['page'];
        $limit = (int)$where['limit'];
        $list = [];
        $result = $chatsRepository::lst($where, $page, $limit);
        if(!$result){ return JsonExtend::error($chatsRepository::returnMsg('参数错误')); }
        $list = $chatsRepository::returnData($list);
        $result = $chatsRepository::count($where);
        if(!$result){ return JsonExtend::error($chatsRepository::returnMsg('参数错误')); }
        list($count) = $chatsRepository::returnData([0]);
        return JsonExtend::success('留言列表', compact('list', 'count'));
    }

    /**
     * 留言添加
     *
     * @return object
     */
    public function insert(): object
    {
        // TODO: Implement insert() method.
        return JsonExtend::error('留言添加');
    }

    /**
     * 留言修改
     *
     * @return object
     */
    public function update(): object
    {
        // TODO: Implement update() method.
        return JsonExtend::error('留言不支持修改');
    }

    /**
     * 留言删除
     *
     * @return object
     */
    public function delete(): object
    {
        // TODO: Implement delete() method.
        return JsonExtend::error('留言不支持删除');
    }

    /**
     * 留言信息列表
     *
     * @return object
     */
    public function message(): object
    {
        // TODO: Implement message() method.
        return JsonExtend::error('留言不支持查询留言信息');
    }

    /**
     * 留言状态修改
     *
     * @param ChatsSeeRequest $chatsSeeRequest
     * @param ChatsRepository $chatsRepository
     * @return object
     */
    public function see(ChatsSeeRequest $chatsSeeRequest, ChatsRepository $chatsRepository): object
    {
        $data = $chatsSeeRequest->all();
        $customer = auth('login')->user()->username;
        $bool = $chatsRepository::see($data['user'], $customer);
        if($bool){
            return JsonExtend::success($chatsRepository::returnMsg('获取成功'));
        }
        return JsonExtend::error($chatsRepository::returnMsg('获取失败'));
    }

    /**
     * 留言用户列表
     *
     * @param ChatsUsersRequest $chatsUsersRequest
     * @param ChatsRepository $chatsRepository
     * @return object
     */
    public function users(ChatsUsersRequest $chatsUsersRequest, ChatsRepository $chatsRepository): object
    {
        $where = $chatsUsersRequest->all();
        $chatsRepository::users($where['customer'], (int)$where['page'], (int)$where['limit']);
        return JsonExtend::success($chatsRepository::returnMsg('获取成功'), $chatsRepository::returnData([]));
    }

    /**
     * 留言客服和用户对话列表
     *
     * @param ChatsChatsRequest $chatsChatsRequest
     * @param ChatsRepository $chatsRepository
     * @return object
     */
    public function chats(ChatsChatsRequest $chatsChatsRequest, ChatsRepository $chatsRepository): object
    {
        $where = $chatsChatsRequest->all();
        $bool = $chatsRepository::chats($where['customer'], $where['user'], (int)$where['page'], (int)$where['limit']);
        if($bool){
            return JsonExtend::success($chatsRepository::returnMsg('获取成功'), $chatsRepository::returnData([]));
        }
        return JsonExtend::error($chatsRepository::returnMsg('获取失败'));
    }

    /**
     * 留言用户统计
     *
     * @param ChatsRepository $chatsRepository
     * @return object
     */
    public function statistics(ChatsRepository $chatsRepository): object
    {
        $limit = (int)config('ccforever.config.chart_limit');
        $limit = $limit > 7 ? 7 : $limit;
        $bool = $chatsRepository::statistics($limit);
        if($bool){
            return JsonExtend::success($chatsRepository::returnMsg('留言用户'), $chatsRepository::returnData([]));
        }
        return JsonExtend::error($chatsRepository::returnMsg('留言用户'));
    }
}
