<?php
/**
 * @author: cc_forever<1253705861@qq.com>
 * @day: 2020/8/5
 */
namespace App\Http\Requests\Banners;

use App\Http\Requests\Request;

/**
 * 轮播图修改验证
 *
 * Class BannersUpdateRequest
 * @package App\Http\Requests\Banners
 */
class BannersUpdateRequest extends Request
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
            'link' =>  'bail|present',
            'image' =>  'bail|required|max:128',
            'weight' =>  'bail|required|integer|min:1',
            'type' =>  'bail|required|integer|min:1|max:2',  // 1 PC 2 WAP
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
            'link.present' => '参数错误',
            'image.required' => '请选择图片',
            'image.max' => '图片地址不能超过128个字符',
            'weight.required' => '请输入权重',
            'weight.integer' => '权重类型错误',
            'weight.min' => '权重错误，请重新输入',
            'type.required' => '请选择类型',
            'type.integer' => '类型错误',
            'type.min' => '类型错误，请重新选择',
            'type.max' => '类型错误，请重新选择',
        ];
    }
}
