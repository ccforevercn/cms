<?php
/**
 * @author: cc_forever<1253705861@qq.com>
 * @day: 2020/5/6
 */

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;

/**
 * 父级验证类
 * Class Request
 * @package App\Http\Requests
 */
class Request extends FormRequest
{
    protected function failedValidation(Validator $validator) {
        $error= $validator->errors()->all();
        throw new HttpResponseException(response()->json(['msg'=>$error[0],'code'=>'400']));
    }
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

        ];
    }
}
