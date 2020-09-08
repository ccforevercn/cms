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

if(! function_exists('set_html_to_text')){
    /**
     * 处理html中的样式等符号
     *
     * @param string $str
     * @return mixed|null|string|string[]
     */
    function set_html_to_text(string $str): string
    {
        $str = preg_replace("/<sty(.*)\\/style>|<scr(.*)\\/script>|<!--(.*)-->/isU", "", $str);
        $text = "";
        $start = 1;
        for($i = 0; $i < strlen($str); $i++)
        {
            if($start == 0 && $str[$i] ==">"){
                $start = 1;
            }else if($start == 1){
                if($str[$i]=="<"){
                    $start = 0;
                    $text .= " ";
                }else if(ord($str[$i]) > 31){
                    $text .= $str[$i];
                }
            }
        }
        $text = str_replace("　"," ",$text);
        $text = preg_replace("/&([^;&]*)(;|&)/","",$text);
        $text = preg_replace("/[ ]+/s"," ",$text);
        return $text;
    }
}

if (! function_exists('get_str_cn_str')) {

    /**
     * 获取字符串中的中文
     *
     * @param $str              $str         字符串
     * @param int $start        $start       获取中文后 中文字符串 截取 起始值
     * @param int $length       $length      获取中文后 中文字符串 截取 长度
     * @param bool $ellipsis    $ellipsis    是否展示省略号  true 展示 false 隐藏
     * @param string $ending    $ending      省略号方式
     * @return string
     */
    function get_str_cn_str($str, $start = 0, $length = 200, bool $ellipsis = true, string $ending = '...'): string
    {
        if(!is_string($str)) return '';
        $str = htmlspecialchars_decode($str);
        $str = set_html_to_text($str);
        if($ellipsis){
            $ending = mb_strlen($str) > bcsub($length, $start) ? $ending : '';
            return mb_substr($str, $start, $length).$ending;
        }
        return mb_substr($str, $start, $length);
    }
}
if(!function_exists('ws_script')){
    /**
     * worker js(留言的页面引入)
     *
     * @param string $url
     * @return string
     */
    function ws_script(string $url):string
    {
        return "<script>var url = '{$url}';var ws;var timer;var cookieName = 'ws_unique';ws = new WebSocket(url);ws.onopen = function () {console.log('open');};ws.onmessage = function (event) {const {type, message, data = {}} = JSON.parse(event.data);if (type === 'user_notice') {alert(message);} else if (type === 'user_message') {alert(message);messages(data.customer, data.content)} else if (type === 'connect') {if (getCookie() === null) {setCookie(data.unique);}heartbeat();};};ws.onclose = function () {clearInterval(timer);delCookie();};function heartbeat() {timer = setInterval(function () {send('heartbeat', {});}, 10000);};ws.onerror = function (event) {console.log(event);};function messages(customer, content) {console.log(customer);console.log(content);};function chat(content) {send('chats_user', {content: content});};function send(type, data) {var send = {'type': type, 'unique': getCookie(),};ws.send(JSON.stringify(Object.assign(send, data)));};function setCookie(value) {var exp = new Date();exp.setTime(exp.getTime() + 60 * 60 * 1000);document.cookie = cookieName + '=' + escape(value);};function getCookie() {var arr, reg = new RegExp('(^| )' + cookieName + '=([^;]*)(;|$)');if (arr = document.cookie.match(reg)) {return unescape(arr[2]);}else{return null;}};function delCookie() {var exp = new Date();exp.setTime(exp.getTime() - 60 * 60 * 1000);var value = getCookie(cookieName);if (value != null) {document.cookie = cookieName + '=' + value + ';expires=' + exp.toGMTString();}};</script>";
    }
}

