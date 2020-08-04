<?php
/**
 * @author: cc_forever<1253705861@qq.com>
 * @day: 2020/8/4
 */

namespace App\Http\Requests\Views;

use App\Http\Requests\Request;

/**
 * 视图列表验证
 *
 * Class ViewsListRequest
 * @package App\Http\Requests\Views
 */
class ViewsListRequest extends Request
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
            'type' =>  'bail|present',
        ];
    }

    /**
     * 重写参数描述
     * @return array
     */
    public function messages()
    {
        return [
            'type.present' => '请选择视图类型',
        ];
    }
}
