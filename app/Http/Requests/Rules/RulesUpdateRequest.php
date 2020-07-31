<?php
/**
 * @author: cc_forever<1253705861@qq.com>
 * @day: 2020/7/23
 */
namespace App\Http\Requests\Rules;

use App\Http\Requests\Request;

/**
 * 规则修改验证
 * Class RulesUpdateRequest
 * @package App\Http\Requests
 */
class RulesUpdateRequest extends Request
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
            'id' => 'bail|required|integer|min:1',  // 规则编号
            'name' => 'bail|required|min:2|max:20',  // 规则名称
            'menus_id' => 'bail|required|min:1', // 规则菜单
        ];
    }

    /**
     * 重写参数描述
     * @return array
     */
    public function messages()
    {
        return [
            'id.required' => '参数错误',
            'id.integer' => '参数错误',
            'id.min' => '参数错误',
            'name.required' => '请填写规则名称',
            'name.min' => '规则名称最少2个汉字',
            'name.max' => '规则名称最多20个汉字',
            'menus_id.required' => '请选择菜单',
            'menus_id.min' => '请选择菜单',
        ];
    }
}
