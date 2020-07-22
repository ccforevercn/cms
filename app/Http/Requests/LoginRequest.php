<?php
/**
 * @author: cc_forever<1253705861@qq.com>
 * @day: 2020/7/21
 */

namespace App\Http\Requests;

/**
 * 登陆验证
 * Class LoginRequest
 * @package App\Http\Requests
 */
class LoginRequest extends Request
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
            'username' => 'bail|required|min:6|max:16',
            'password' => 'bail|required|min:8|max:18',
            'captcha' => 'bail|required',
            'key' => 'bail|required',
        ];
    }

    /**
     * 重写参数描述
     * @return array
     */
    public function messages()
    {
        return [
            'username.required' => '请填写账号',
            'username.min' => '账号最少6个字符',
            'username.max' => '账号最多16个字符',
            'password.required' => '请填写密码',
            'password.min' => '密码至少是8个字符',
            'password.max' => '密码最多18个字符',
            'captcha.required' => '请填写验证码',
            'key.required' => '参数错误',
        ];
    }
}
