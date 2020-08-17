<?php
/**
 * @author: cc_forever<1253705861@qq.com>
 * @day: 2020/7/20
 */


/**
 * 规则处理函数
 */
if(!function_exists('create_admin_password')){
    /**
     * 管理员密码加密方式
     * @param string $password
     * @param string $suffix
     * @return string
     */
    function create_admin_password(string $password, string $suffix = ''): string
    {
        return md5(md5($password).$suffix);
    }
}

if(!function_exists('check_phone')){
    /**
     * 手机号验证
     * @param string $phone
     * @return false|int
     */
    function check_phone(string $phone)
    {
        return preg_match("/^1[345678]\d{9}$/", $phone);
    }
}

if(!function_exists('check_email')){
    /**
     * 邮箱验证
     * @param string $email
     * @return false|int
     */
    function check_email(string $email)
    {
        return preg_match('/^[a-zA-Z0-9]+([-_.][a-zA-Z0-9]+)*@([a-zA-Z0-9]+[-.])+([a-z]{2,5})$/ims',$email);
    }
}

if(!function_exists('page_to_offset')){

    /**
     * 获取起始值
     * @param int $page
     * @param int $limit
     * @return int
     */
    function page_to_offset(int $page, int $limit): int
    {
        $page = $page < 1 ? 1: $page;
        $page = bcsub($page, 1, 0);
        $offset = (int)bcmul($page, $limit, 0);
        return $offset;
    }
}

if(!function_exists('reduce_status')){

    /**
     * 重置状态
     * @param int $status
     * @param int $step
     * @return int
     * @throws Exception
     */
    function reduce_status(int $status, int $step): int
    {
        $final = (int)bcsub($status, $step, 0);
        $final = $final < 0 ? '' : $final;
        if(!is_int($final)){
            throw new Exception();
        }
        return $final;
    }
}

if(!function_exists('create_millisecond')){
    /**
     * 毫秒
     * @return int
     */
    function create_millisecond(): int
    {
        list($milli, $second) = explode(' ', microtime());// 获取毫秒(单位是秒)$milli 秒$second
        $millisecond = (int)sprintf('%.0f', (floatval($milli) + floatval($second)) * 1000); // 获取格式化后的毫秒
        return $millisecond;
    }
}

if(!function_exists('check_null')){
    /**
     * 验证多个字段是否为空值
     *
     * @param mixed ...$value
     * @return bool
     */
    function check_null(...$value): bool
    {
        $status = true;
        foreach ($value as $item){
            if(is_null($item)){
                return false;
            }
        }
        return $status;
    }
}

if(!function_exists('format_config_message_type_value')){
    /**
     * 格式化配置信息类型值
     *
     * @param string $values
     * @return array
     */
    function format_config_message_type_value(string $values): array
    {
        $format = [];
        $formatCount = 0;
        if(strlen($values)){
            $values = explode('|', $values);
            if(count($values) >= 2){
                foreach ($values as $key=>$value){
                    $formatValue = explode(':', $value);
                    if(count($formatValue) !== 2){
                        $format = [];
                        break;
                    }
                    $format[$formatCount] = $formatValue;
                    $formatCount++;
                }
            }
        }
        return $format;
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