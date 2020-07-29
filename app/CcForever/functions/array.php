<?php
/**
 * @author: cc_forever<1253705861@qq.com>
 * @day: 2020/7/29
 */

/**
 * 数组处理函数
 */


if(!function_exists('two_key_and_value_one')){

    /**
     * 二维数组转一位数组
     *
     * @param array $twoDimensionalArray
     * @param string $key
     * @param string $value
     * @return array
     */
    function two_key_and_value_one(array $twoDimensionalArray, string $key, string $value): array
    {
        $array = [];
        foreach ($twoDimensionalArray as $child){
            if(array_key_exists($key, $child) && array_key_exists($value, $child)){
                $array[$child[$key]] = $child[$value];
            }
        }
        return $array;
    }
}