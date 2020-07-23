<?php
/**
 * @author: cc_forever<1253705861@qq.com>
 * @day: 2020/7/21
 */
namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class EmailRule implements Rule
{
    /**
     * Create a new rule instance.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Determine if the validation rule passes.
     *
     * @param  string  $attribute
     * @param  mixed  $value
     * @return bool
     */
    public function passes($attribute, $value)
    {
        return check_email($value);
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return '邮箱格式错误';
    }
}
