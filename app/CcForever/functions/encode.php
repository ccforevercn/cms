<?php
/**
 * @author: cc_forever<1253705861@qq.com>
 * @day: 2020/7/28
 */

if(!function_exists('encode_change')){

    /**
     * 编码转换
     * @param string $string  需要转码的字符串
     * @param string $encode  转码后的字符编码
     * @return string
     */
    function encode_change(string $string, string $encode): string
    {
        $encodeArr = ['ASCII','UTF-8','GB2312','GBK','BIG5']; // 编码格式
        if(!in_array(strtoupper($encode), $encodeArr)){ return $string; } // 编码格式错误
        $encodeString = mb_detect_encoding($string, $encodeArr);  // 获取$string的编码格式
        $strEncode = mb_convert_encoding($string, $encode, $encodeString); //  转码后的字符串
        return $strEncode;
    }
}