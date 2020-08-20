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