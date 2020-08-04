<?php
/**
 * @author: cc_forever<1253705861@qq.com>
 * @day: 2020/8/4
 */
namespace App\Http\Requests\ConfigMessage;

use App\Http\Requests\Request;

/**
 * 配置信息添加验证
 *
 * Class ConfigMessageInsertRequest
 * @package App\Http\Requests\ConfigMessage
 */
class ConfigMessageInsertRequest extends Request
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
            'select' =>  'bail|required|max:32',
            'category_id' =>  'bail|required|integer|min:1',
            'type' =>  'bail|required|integer|min:1|max:5',
            'type_value' =>  'bail|present',
            'value' =>  'bail|present',
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
            'select.required' => '请填写唯一值',
            'select.max' => '唯一值不能超过32个字符',
            'category_id.required' => '请选择栏目分类',
            'category_id.integer' => '栏目分类类型错误',
            'category_id.min' => '栏目分类错误，请重新选择',
            'type.required' => '请选择类型',
            'type.integer' => '类型错误',
            'type.min' => '类型错误，请重新选择',
            'type.max' => '类型错误，请重新选择',
            'type_value.present' => '请填写类型值',
            'value.present' => '请填写配置信息值',
        ];
    }
}
