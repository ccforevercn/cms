<?php
/**
 * @author: cc_forever<1253705861@qq.com>
 * @day: 2020/8/13
 */
namespace App\Http\Requests\Chats;

use App\Http\Requests\Request;

/**
 * 留言状态信息验证
 *
 * Class ChatsSeeRequest
 * @package App\Http\Requests\Chats
 */
class ChatsSeeRequest extends Request
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
            'user' => 'bail|required|max:32|min:32',  // 用户唯一值
        ];
    }

    /**
     * 重写参数描述
     * @return array
     */
    public function messages()
    {
        return [
            'user.required' => '参数错误',
            'user.max' => '参数错误',
            'user.min' => '参数错误',
        ];
    }
}
