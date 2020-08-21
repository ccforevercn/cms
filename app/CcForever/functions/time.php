<?php
/**
 * @author: cc_forever<1253705861@qq.com>
 * @day: 2020/8/21
 */

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
if (!function_exists('make_time_path')){

    /**
     * 日期文件路径
     * @param $path
     * @param int $type
     * @param string $ds
     * @return string
     */
    function make_time_path($path, $type = 2, $ds = '/')
    {
        $path =  $ds.ltrim(rtrim($path));
        switch ($type){
            case 1:
                $path .= $ds.date('Y');
                break;
            case 2:
                $path .=  $ds.date('Y').$ds.date('m');
                break;
            case 3:
                $path .=  $ds.date('Y').$ds.date('m').$ds.date('d');
                break;
        }
        return $path.$ds;
    }
}
