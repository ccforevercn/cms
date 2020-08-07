<?php
/**
 * @author: cc_forever<1253705861@qq.com>
 * @day: 2020/8/7
 */
namespace App\Http\Controllers\markets;

use App\CcForever\controller\BaseController;
use App\CcForever\extend\JsonExtend;
use App\CcForever\traits\ControllerTrait;
use App\Http\Requests\Chats\ChatsListRequest;
use App\Http\Requests\Chats\ChatsRequest;
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
     * @param ChatsRequest $chatsRequest
     * @param ChatsRepository $chatsRepository
     * @return object
     */
    public function message(ChatsRequest $chatsRequest, ChatsRepository $chatsRepository): object
    {
        // TODO: Implement message() method.

    }
}
