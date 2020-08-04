<?php
/**
 * @author: cc_forever<1253705861@qq.com>
 * @day: 2020/8/4
 */
namespace App\Http\Requests\ConfigCategory;

use App\Http\Requests\Request;

/**
 * 配置分类添加验证
 *
 * Class ConfigCategoryInsertRequest
 * @package App\Http\Requests\ConfigCategory
 */
class ConfigCategoryInsertRequest extends Request
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
            'name.required' => '请填写名称',
            'name.max' => '名称不能超过20个汉字',
            'description.required' => '请填写描述',
            'description.max' => '描述不能超过80个汉字',
        ];
    }
}
