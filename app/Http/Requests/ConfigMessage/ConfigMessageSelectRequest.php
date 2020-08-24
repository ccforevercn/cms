<?php
/**
 * @author: cc_forever<1253705861@qq.com>
 * @day: 2020/8/24
 */
namespace App\Http\Requests\ConfigMessage;

use App\Http\Requests\Request;
use App\Rules\ConfigMessageSelectRule;

/**
 * 配置信息唯一值验证
 *
 * Class ConfigMessageSelectRequest
 * @package App\Http\Requests\ConfigMessage
 */
class ConfigMessageSelectRequest extends Request
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
            'select' =>  ['bail', 'required', new ConfigMessageSelectRule(), 'max:32'],
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
            'select.required' => '请填写唯一值',
            'select.max' => '唯一值不能超过32个字符',
        ];
    }
}
