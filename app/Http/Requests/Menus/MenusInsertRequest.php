<?php
/**
 * @author: cc_forever<1253705861@qq.com>
 * @day: 2020/7/21
 */

namespace App\Http\Requests\Menus;

use App\Http\Requests\Request;

/**
 * 菜单添加
 * Class MenusInsertRequest
 * @package App\Http\Requests
 */
class MenusInsertRequest extends Request
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
            'name' =>  'bail|required|max:20',
            'parent_id' => 'bail|required|integer|min:0',
            'routes' =>  'bail|required|max:64|unique:menus',
            'page' =>  'bail|required|max:64',
            'icon' => ['bail', 'filled', 'max:16'],
            'sort' => ['bail', 'filled', 'integer'],
            'menu' => ['bail', 'filled', 'min:0', 'max:1'],
        ];
    }

    /**
     * 重写参数描述
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => '请填写菜单名称',
            'name.max' => '菜单名称不能超过20个汉字',
            'parent_id.required' => '请选择父级菜单',
            'parent_id.min' => '父级菜单不存在',
            'routes.required' => '请填写路由地址',
            'routes.unique' => '路由地址已存在',
            'routes.max' => '路由地址不能超过64个字母',
            'page.required' => '请填写页面链接',
            'page.max' => '页面链接不能超过64个字符',
            'icon.filled' => '请填写菜单icon',
            'icon.max' => '菜单icon不能超过16个字符',
            'sort.integer' => '菜单排序格式错误',
            'sort.filled' => '请填写菜单排序',
            'menu.integer' => '菜单状态格式错误',
            'menu.min' => '菜单状态错误',
            'menu.max' => '菜单状态错误',
            'menu.filled' => '请选择菜单状态',
        ];
    }
}
