<?php
/**
 * @author: cc_forever<1253705861@qq.com>
 * @day: 2020/8/3
 */

namespace App\Http\Requests\Messages;

use App\Http\Requests\Request;

/**
 * 信息内容验证
 *
 * Class MessagesContentRequest
 * @package App\Http\Requests\Messages
 */
class MessagesContentRequest extends Request
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
