<?php
/**
 * @author: cc_forever<1253705861@qq.com>
 * @day: 2020/8/20
 */

if(!function_exists('power_message')){
    /**
     * 没有权限提示信息
     *
     * @return string
     */
    function power_message(): string
    {
        return '暂无权限操作';
    }
}

if(!function_exists('exceptions_message')){
    /**
     * 错误码对应的提示信息获取
     *
     * @param int $code
     * @return string
     */
    function exceptions_message(int $code): string
    {
        switch ($code){
            case $code < 300 && $code >= 200:
                $errorMessage = config('illegal.error_message_success');
                break;
            case $code < 400 && $code >= 300:
                $errorMessage = config('illegal.error_message_redirect');
                break;
            case $code < 500 && $code >= 400:
                $errorMessage = config('illegal.error_message_error');
                break;
            case $code < 600 && $code >= 500:
                $errorMessage = config('illegal.error_message_inside_error');
                break;
            default:
                $errorMessage = config('illegal.error_message_default');
        }
        return $errorMessage;
    }
}

if (! function_exists('page_suffix_message')){
    /**
     * 页面后缀
     *
     * @return string
     */
    function page_suffix_message(): string
    {
        return config('ccforever.suffix.page');
    }
}