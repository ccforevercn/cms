<?php
/**
 * @author: cc_forever<1253705861@qq.com>
 * @day: 2020/5/6
 */

namespace App\Http\Requests;

use App\CcForever\extend\JsonExtend;
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
        $error= $validator->errors()->all(); // 获取所有错误
        $errorMsg = (string)$error[0]; // 获取第一条错误并修改格式为string
        $jsonError = JsonExtend::error($errorMsg);// 获取返回的参数
        throw new HttpResponseException($jsonError);// 抛出异常
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
