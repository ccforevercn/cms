<?php
/**
 * @author: cc_forever<1253705861@qq.com>
 * @day: 2020/7/23
 */
namespace App\Http\Requests;

/**
 * 规则验证
 * Class RulesRequest
 * @package App\Http\Requests
 */
class RulesRequest extends Request
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
