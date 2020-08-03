<?php
/**
 * @author: cc_forever<1253705861@qq.com>
 * @day: 2020/8/3
 */
namespace App\Http\Requests\Tags;

use App\Http\Requests\Request;

/**
 * 标签列表验证
 *
 * Class TagsListRequest
 * @package App\Http\Requests\Tags
 */
class TagsListRequest extends Request
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
            'status' =>  'bail|present', // 标签状态
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
            'status.present' => '参数错误',
        ];
    }
}
