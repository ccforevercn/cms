<?php
/**
 * @author: cc_forever<1253705861@qq.com>
 * @day: 2020/8/5
 */
namespace App\Http\Requests\Banners;

use App\Http\Requests\Request;

/**
 * 轮播图验证
 *
 * Class BannersRequest
 * @package App\Http\Requests\Banners
 */
class BannersRequest extends Request
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
            'type' => 'bail|nullable',  // 轮播图状态
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
