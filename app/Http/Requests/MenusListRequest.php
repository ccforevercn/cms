<?php
/**
 * @author: cc_forever<1253705861@qq.com>
 * @day: 2020/7/21
 */

namespace App\Http\Requests;

/**
 * 菜单列表
 * Class MenusListRequest
 * @package App\Http\Requests
 */
class MenusListRequest extends Request
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
            'parent_id' => 'bail|nullable|integer|min:0', // 上级菜单编号
            'menu' => 'bail|nullable|integer|min:0|max:2', // 0 全部 1 非菜单 2 菜单
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
            'parent_id.integer' => '父级编号错误',
            'parent_id.min' => '父级编号错误',
            'menu.min' => '按钮状态错误',
            'menu.max' => '按钮状态错误',
        ];
    }
}
