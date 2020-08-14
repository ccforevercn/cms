<?php
/**
 * @author: cc_forever<1253705861@qq.com>
 * @day: 2020/8/14
 */
namespace App\Http\Requests\Chats;

use App\Http\Requests\Request;

/**
 * 留言用户验证
 *
 * Class ChatsUserRequest
 * @package App\Http\Requests\Chats
 */
class ChatsUsersRequest extends Request
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
            'customer' => 'bail|required|min:6|max:16',  // 客服名称
            'page' => 'bail|required|integer|min:1',  // 页数
            'limit' => 'bail|required|integer|min:1', // 每页条数
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
            'customer.required' => '客服名称错误',
            'customer.min' => '客服名称错误',
            'customer.max' => '客服名称错误'
        ];
    }

}
