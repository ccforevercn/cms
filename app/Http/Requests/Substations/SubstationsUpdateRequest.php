<?php
/**
 * @author: cc_forever<1253705861@qq.com>
 * @day: 2020/9/7
 */
namespace App\Http\Requests\Substations;

use App\Http\Requests\Request;

/**
 * 分站修改验证
 *
 * Class SubstationsUpdateRequest
 * @package App\Http\Requests\Substations
 */
class SubstationsUpdateRequest extends Request
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
            'name' =>  'bail|required|max:64',
            'unique' =>  'bail|required|max:32',
        ];
    }

    /**
     * 重写参数描述
     *
     * @return array
     */
    public function messages()
    {
        return [
            'id.required' => '参数错误',
            'id.integer' => '参数错误',
            'id.min' => '参数错误',
            'name.required' => '请填写名称',
            'name.max' => '名称不能超过10个汉字',
            'unique.required' => '请填写唯一值',
            'unique.max' => '唯一值不能超过32个字符',
        ];
    }
}
