<?php
/**
 * @author: cc_forever<1253705861@qq.com>
 * @day: 2020/8/14
 */
namespace App\Http\Requests\Links;

use App\Http\Requests\Request;

/**
 * 友情链接验证
 *
 * Class LinksRequest
 * @package App\Http\Requests\Links
 */
class LinksRequest extends Request
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
        ];
    }
}
