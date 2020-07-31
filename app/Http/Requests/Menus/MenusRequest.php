<?php
/**
 * @author: cc_forever<1253705861@qq.com>
 * @day: 2020/7/21
 */

namespace App\Http\Requests\Menus;

use App\Http\Requests\Request;
/**
 * 按钮规则
 * Class MenusRequest
 * @package App\Http\Requests
 */
class MenusRequest extends Request
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
            'id' =>  'bail|required|integer|min:1',
        ];
    }

    /**
     * 重写参数描述
     * @return array
     */
    public function messages()
    {
        return [
            'id.required' => '编号不存在',
            'id.integer' => '编号格式错误',
            'id.min' => '编号错误',
        ];
    }
}
