<?php
/**
 * @author: cc_forever<1253705861@qq.com>
 * @day: 2020/7/31
 */

namespace App\Http\Requests\Columns;

use App\Http\Requests\Request;

/**
 * 栏目内容验证
 *
 * Class ColumnsContentRequest
 * @package App\Http\Requests\Columns
 */
class ColumnsContentRequest extends Request
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
            'content' =>  'bail|required',
            'markdown' =>  'bail|present',
            'type' => 'bail|required|integer|min:0|max:1',  // 0 添加/修改  1 查询
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
            'content.required' => '请填写栏目内容',
            'markdown.present' => '参数错误',
            'type.required' => '类型错误',
            'type.integer' => '类型错误',
            'type.min' => '参数错误',
            'type.max' => '参数错误',
        ];
    }

}
