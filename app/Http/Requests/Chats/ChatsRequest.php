<?php
/**
 * @author: cc_forever<1253705861@qq.com>
 * @day: 2020/8/7
 */
namespace App\Http\Requests\Chats;

use App\Http\Requests\Request;

/**
 * 客服验证
 *
 * Class ChatsRequest
 * @package App\Http\Requests\Chats
 */
class ChatsRequest extends Request
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
            'customer' => 'bail|present', //  客服名称
            'user' => 'bail|present',  // 用户名称
        ];
    }

    /**
     * 重写参数描述
     * @return array
     */
    public function messages()
    {
        return [
            'customer.present' => '参数错误',
            'user.present' => '参数错误',
        ];
    }
}
