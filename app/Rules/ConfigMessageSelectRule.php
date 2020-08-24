<?php
/**
 * @author: cc_forever<1253705861@qq.com>
 * @day: 2020/8/24
 */
namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

/**
 * 配置信息唯一值规则
 *
 * Class ConfigMessageSelectRule
 * @package App\Rules
 */
class ConfigMessageSelectRule implements Rule
{

    /**
     * 验证数据
     *
     * @var string
     */
    private $value = '';

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
        $status = false; // 返回值
        $this->value = $value; // 唯一值
        $value = encode_change($value, 'utf-8'); // 设置编号为urf-8
        $valueArrTotal = mb_str_split($value); // 用户穿过来的值切割为数组
        // 验证是否有非法字符
        foreach ($valueArrTotal as &$item){
            $ascii = ord($item); // 获取每个字符串的ascii值
            switch ($ascii){
                // 0-9的阿拉伯数字字符
                case $ascii >= 48 && $ascii <= 57:
                    $status = true;
                    break;
                // A-Z英文字母字符
                case $ascii >= 65 && $ascii <= 90:
                    $status = true;
                    break;
                // _ 下划线字符
                case $ascii === 95: // _
                    $status = true;
                    break;
                // a-z英文字母字符
                case $ascii >= 97 && $ascii <= 122:
                    $status = true;
                    break;
                // 其他字符
                default:
                    $status = false;
            }
            if(!$status){ break; }
        }
        return $status;
    }

    /**
     * Get the validation error message.
     *
     * @return string
     */
    public function message()
    {
        return '唯一值[' . $this->value . ']格数错误，格式为：0-9、A-Z、a-z、下划线字符(_)';
    }
}
