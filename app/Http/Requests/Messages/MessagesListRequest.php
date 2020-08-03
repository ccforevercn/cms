<?php
/**
 * @author: cc_forever<1253705861@qq.com>
 * @day: 2020/8/3
 */

namespace App\Http\Requests\Messages;

use App\Http\Requests\Request;

/**
 * 信息列表验证
 *
 * Class MessagesListRequest
 * @package App\Http\Requests\Messages
 */
class MessagesListRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'page' => 'bail|required|integer|min:1',  // 页数
            'limit' => 'bail|required|integer|min:1', // 每页条数
            'columns_id' => 'bail|present', // 栏目编号
            'index' => 'bail|present', // 首页推荐
            'hot' => 'bail|present', // 热门推荐
            'release' => 'bail|present', // 发布状态
        ];
    }

    /**
     * 重写参数描述
     * @return array
     */
    public function messages()
    {
        return [
            'page.required' => '请选择页数',
            'page.integer' => '页数类型错误',
            'page.min' => '页数不能小于1',
            'limit.required' => '请选择条数',
            'limit.integer' => '条数类型错误',
            'limit.min' => '条数不能小于1',
            'columns_id.present' => '参数错误',
            'index.present' => '参数错误',
            'hot.present' => '参数错误',
            'release.present' => '参数错误',
        ];
    }
}
