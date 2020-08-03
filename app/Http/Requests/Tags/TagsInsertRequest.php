<?php
/**
 * @author: cc_forever<1253705861@qq.com>
 * @day: 2020/8/3
 */
namespace App\Http\Requests\Tags;

use App\Http\Requests\Request;

/**
 * 标签添加验证
 *
 * Class TagsInsertRequest
 * @package App\Http\Requests\Tags
 */
class TagsInsertRequest extends Request
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
            'name' =>  'bail|required|max:8|unique:tags',
            'status' =>  'bail|required|integer|min:0|max:1',
        ];
    }

    /**
     * 重写参数描述
     * @return array
     */
    public function messages()
    {
        return [
            'name.required' => '请填写标签名称',
            'name.max' => '标签名称不能超过8个汉字',
            'name.unique' => '标签名称已存在',
            'status.required' => '请选择标签状态',
            'status.integer' => '标签状态类型错误',
            'status.min' => '标签状态错误，请重新选择',
            'status.max' => '标签状态错误，请重新选择',
        ];
    }
}
