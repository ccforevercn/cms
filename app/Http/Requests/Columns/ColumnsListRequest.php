<?php
/**
 * @author: cc_forever<1253705861@qq.com>
 * @day: 2020/7/31
 */

namespace App\Http\Requests\Columns;

use App\Http\Requests\Request;

/**
 * 栏目列表验证
 *
 * Class ColumnsListRequest
 * @package App\Http\Requests\Columns
 */
class ColumnsListRequest extends Request
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
            'page' => 'bail|required|integer|min:1',  // 页数
            'limit' => 'bail|required|integer|min:1', // 每页条数
            'parent_id' => 'bail|required|integer|min:0', // 上级栏目编号
        ];
    }

    /**
     * 重写参数描述
     * @return array
     */
    public function messages()
    {
        return [
            'page.required' => '请选择页数',
            'page.integer' => '页数类型错误',
            'page.min' => '页数不能小于1',
            'limit.required' => '请选择条数',
            'limit.integer' => '条数类型错误',
            'limit.min' => '条数不能小于1',
            'parent_id.required' => '请选择上级栏目',
            'parent_id.integer' => '上级栏目格式错误',
            'parent_id.min' => '上级栏目格式错误',
        ];
    }
}
