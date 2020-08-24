<?php
/**
 * @author: cc_forever<1253705861@qq.com>
 * @day: 2020/8/14
 */
namespace App\Http\Requests\Links;

use App\Http\Requests\Request;

/**
 * 友情链接修改验证
 *
 * Class LinksUpdateRequest
 * @package App\Http\Requests\Links
 */
class LinksUpdateRequest extends Request
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
            'id' => 'bail|required|integer|min:1',
            'name' =>  'bail|required|max:30',
            'link' =>  'bail|required|max:128',
            'image' =>  'bail|present',
            'weight' =>  'bail|required|integer|min:1',
            'follow' =>  'bail|required|integer|min:0',
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
            'name.required' => '请填写名称',
            'name.max' => '名称不能超过20个汉字',
            'image.present' => '参数错误',
            'link.required' => '请填写链接',
            'link.max' => '链接不能超过128个字符',
            'weight.required' => '请输入权重',
            'weight.integer' => '权重类型错误',
            'weight.min' => '权重错误，请重新输入',
            'follow.required' => '请输入网站权重传递状态',
            'follow.integer' => '网站权重传递状态类型错误',
            'follow.min' => '网站权重传递状态错误，请重新输入',
        ];
    }
}
