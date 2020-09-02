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

if(!function_exists('check_message_order')){

    /**
     * 验证信息排序
     *
     * @param int $type
     * @return array
     */
    function check_message_order(int $type): array
    {
        // 0 默认编号倒叙 1 修改时间升序 2 修改时间倒叙 3 权重升序 4 权重倒叙 5 点击量升序 6 点击量降序
        switch ($type) {
            case 1:
                $select = 'update_time';
                $value = 'ASC';
                break;
            case 2:
                $select = 'update_time';
                $value = 'DESC';
                break;
            case 3:
                $select = 'weight';
                $value = 'ASC';
                break;
            case 4:
                $select = 'weight';
                $value = 'DESC';
                break;
            case 5:
                $select = 'click';
                $value = 'ASC';
                break;
            case 6:
                $select = 'click';
                $value = 'DESC';
                break;
            default:
            $select = 'id';
            $value = 'DESC';
        }
        return compact('select', 'value');
    }
}

if (!function_exists('check_message_order_pre')){
    /**
     * 验证信息上一条where
     *
     * @param int $type
     * @return array
     */
    function check_message_order_pre(int $type): array
    {
        // 0 默认编号倒叙 1 修改时间升序 2 修改时间倒叙 3 权重升序 4 权重倒叙 5 点击量升序 6 点击量降序
        switch ($type){
            case 1:
                // 修改时间升序
                $select = 'update_time';
                $value = 'DESC';
                $condition = '<';
                break;
            case 2:
                // 修改时间倒叙
                $select = 'update_time';
                $value = 'ASC';
                $condition = '>';
                break;
            case 3:
                // 权重升序
                $select = 'weight';
                $value = 'DESC';
                $condition = '<';
                break;
            case 4:
                // 权重倒叙
                $select = 'weight';
                $value = 'ASC';
                $condition = '>';
                break;
            case 5:
                // 点击量升序
                $select = 'click';
                $value = 'DESC';
                $condition = '<';
                break;
            case 6:
                // 点击量降序
                $select = 'click';
                $value = 'ASC';
                $condition = '>';
                break;
            default:
                $select = 'id';
                $value = 'DESC';
                $condition = '<';
                break;
        }
        return compact('select', 'value', 'condition');
    }
}

if(!function_exists('check_message_order_next')){
    /**
     * 验证信息下一条where
     *
     * @param int $type
     * @return array
     */
    function check_message_order_next(int $type): array
    {
        // 0 默认编号倒叙 1 修改时间升序 2 修改时间倒叙 3 权重升序 4 权重倒叙 5 点击量升序 6 点击量降序
        switch ($type){
            case 1:
                // 修改时间升序
                $select = 'update_time';
                $value = 'ASC';
                $condition = '>';
                break;
            case 2:
                // 修改时间倒叙
                $select = 'update_time';
                $value = 'DESC';
                $condition = '<';
                break;
            case 3:
                // 权重升序
                $select = 'weight';
                $value = 'ASC';
                $condition = '>';
                break;
            case 4:
                // 权重倒叙
                $select = 'weight';
                $value = 'DESC';
                $condition = '<';
                break;
            case 5:
                // 点击量升序
                $select = 'click';
                $value = 'ASC';
                $condition = '>';
                break;
            case 6:
                // 点击量降序
                $select = 'click';
                $value = 'DESC';
                $condition = '<';
                break;
            default:
                $select = 'id';
                $value = 'DESC';
                $condition = '<';
                break;
        }
        return compact('select', 'value', 'condition');
    }
}
