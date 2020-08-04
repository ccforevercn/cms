<?php
/**
 * @author: cc_forever<1253705861@qq.com>
 * @day: 2020/8/4
 */
namespace App\Http\Requests\ConfigCategory;

use App\Http\Requests\Request;

/**
 * 配置分类修改验证
 *
 * Class ConfigCategoryUpdateRequest
 * @package App\Http\Requests\ConfigCategory
 */
class ConfigCategoryUpdateRequest extends Request
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
            'name' =>  'bail|required|max:20',
            'description' =>  'bail|required|max:80',
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
            'description.required' => '请填写描述',
            'description.max' => '描述不能超过80个汉字',
        ];
    }
}
