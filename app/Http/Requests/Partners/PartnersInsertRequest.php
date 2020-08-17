<?php
/**
 * @author: cc_forever<1253705861@qq.com>
 * @day: 2020/8/17
 */
namespace App\Http\Requests\Partners;

use App\Http\Requests\Request;

/**
 * 合作伙伴添加验证
 *
 * Class PartnersInsertRequest
 * @package App\Http\Requests\Partners
 */
class PartnersInsertRequest extends Request
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
            'name' =>  'bail|required|max:30',
            'link' =>  'bail|required|max:128',
            'image' =>  'bail|present',
            'weight' =>  'bail|required|integer|min:1',
        ];
    }

    /**
     * 重写参数描述
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => '请填写名称',
            'name.max' => '名称不能超过20个汉字',
            'image.present' => '参数错误',
            'link.required' => '请填写链接',
            'link.max' => '链接不能超过128个字符',
            'weight.required' => '请输入权重',
            'weight.integer' => '权重类型错误',
            'weight.min' => '权重错误，请重新输入',
        ];
    }
}
