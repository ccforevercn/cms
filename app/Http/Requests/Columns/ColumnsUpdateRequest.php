<?php
/**
 * @author: cc_forever<1253705861@qq.com>
 * @day: 2020/7/31
 */

namespace App\Http\Requests\Columns;

use App\Http\Requests\Request;

/**
 * 栏目修改验证
 *
 * Class ColumnsUpdateRequest
 * @package App\Http\Requests\Columns
 */
class ColumnsUpdateRequest extends Request
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
            //
        ];
    }
}
