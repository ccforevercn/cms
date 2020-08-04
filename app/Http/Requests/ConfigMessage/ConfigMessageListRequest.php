<?php
/**
 * @author: cc_forever<1253705861@qq.com>
 * @day: 2020/8/4
 */
namespace App\Http\Requests\ConfigMessage;

use App\Http\Requests\Request;

/**
 * 配置信息列表
 *
 * Class ConfigMessageListRequest
 * @package App\Http\Requests\ConfigMessage
 */
class ConfigMessageListRequest extends Request
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
            'category_id' => 'bail|required|integer|min:1', // 配置分类
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
            'category_id.required' => '请选择配置分类',
            'category_id.integer' => '配置分类类型错误',
            'category_id.min' => '配置分类错误',
        ];
    }
}
