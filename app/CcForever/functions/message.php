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
        return "<style>.chat{position: fixed;bottom: 0;right: 0;z-index: 9999;width: 480px;}.chat .header{width: 100%;height: 50px;background-color: #6666CC;color: #fff;}.chat .header .title{box-sizing: border-box;width: calc(100vw - 80px);padding-top: 0;height: 50px;line-height: 50px;margin: 0 auto;text-align: left;position: relative;padding-left: 15px;float: left;}.chat .header .title .content{display: inline-block;width: calc(100% - 160px);font-size: 12px;white-space: nowrap;text-overflow: ellipsis;overflow: hidden;}.chat .header .bottom{position: absolute;z-index: 120;height: 20px;bottom: 12px;top: 12px;width: 80px;right: 5px;}.chat .header .bottom .bottom-min {margin-right: 10px;width: 16px;height: 16px;display: inline-block;cursor: pointer;float: right;background-size: 16px 16px;background-position: 5px 5px;padding: 2px 5px 5px 5px;}.chat .header .bottom .bottom-close {margin-right: 10px;width: 16px;height: 16px;display: inline-block;cursor: pointer;float: right;background-size: 16px 16px;background-position: 5px 5px;padding: 2px 5px 5px 5px;}.chat .chat-content{width: 100%;height: 100%;overflow: hidden;}.chat .chat-content .content{width: 480px;height: 450px;position: relative;float: left;overflow: hidden;background-color: #f7f7f7;}.chat .chat-content .content .header-content{position: absolute;height: auto;top: 0;bottom: 130px;right: 0;left: 0;background-color: #f7f7f7;overflow-y: auto;display: block;}.chat .chat-content .content .header-content .chat-record{list-style: none;padding: 12px;}.chat .chat-content .content .header-content .chat-record .chat-message{margin-bottom: 14px;position: relative;overflow: hidden;}.chat .chat-content .content .header-content .chat-record .chat-message .customer-time{font-size: 12px;color: #8d8d8d;margin-right: 10px;float: right;}.chat .chat-content .content .header-content .chat-record .chat-message .service-content-right .customer{margin-left: 10px;margin-top: 5px;background-color: #19caa6;display: inline-block;padding: 10px 10px;float: right;word-break: break-all;word-wrap: break-word;color: #fff;border-radius: 3px;position: relative;max-width: 100%;}.chat .chat-content .content .header-content .chat-record .chat-message .service-name{float: left;display: block;position: relative;font-size: 12px;color: #8d8d8d;margin-left: 0;}.chat .chat-content .content .header-content .chat-record .chat-message .service-name .service-time{margin-left: 9px;}.chat .chat-content .content .header-content .chat-record .chat-message p, .chat .chat-content .content .header-content .chat-record .chat-message:after{content: \"\";display: table;clear: both;word-break: break-word;}.chat .chat-content .content .header-content .chat-record .chat-message .service-content-left{float: left;}.service-content-left, .service-content-right {float: right;width: 80%;position: relative;clear: both;font-size: 14px;margin-right: 3px;}.chat .chat-content .content .header-content .chat-record .chat-message .service-content-left .service{margin-right: 10px;margin-top: 5px;background-color: #feffff;display: inline-block;padding: 10px 10px;float: left;word-break: break-all;word-wrap: break-word;color: #000;border-radius: 3px;max-width: 100%;box-sizing: border-box;border: 1px solid #e5e6e7;}.chat .chat-content .content .footer-content{position: absolute;right: 0;left: 0;bottom: 0;height: 170px;background: #fff;}.chat .chat-content .content .footer-content .message-input{display: block;position: absolute;left: 0;right: 0;top: 0;height: 130px;}.chat .chat-content .content .footer-content .message-input .input-box{display: block;left: 0;height: 130px;}.chat .chat-content .content .footer-content .message-input .input-box .text{width: 100%;resize: none;height: 130px;border: 0;padding: 5px 0 5px 8px;outline: 0;font-size: 14px;}.chat .chat-content .content .footer-content .message-submit{position: absolute;bottom: 0;right: 0;left: 0;height: 40px;display: block;background-color: #FFFFFF;}.chat .chat-content .content .footer-content .message-submit span{display: block;height: 40px;text-align: center;}.chat .chat-content .content .footer-content .message-submit span .submit{font-size: 16px;padding: 0;margin: 0;border: 0;width: 100%;height: 100%;text-align: center;color: #fff;outline: 0;cursor: pointer;background-color: #6666CC;line-height: 24px;}</style><div class='chat' id='chat'><div class='header'><div class='title'><div class='content'>在线咨询客服</div></div><div class='bottom'><span class='bottom-close' onclick='closeChat()'>×</span><span class='bottom-min' id='min' onclick='minChat()'>-</span></div></div><div class='chat-content' id='chat-content'><div class='content'><div class='header-content'><ul class='chat-record' id='chat-record'></ul></div><div class='footer-content'><div class='message-input'><div class='input-box'><textarea class='text' id='textarea'></textarea></div></div><div class='message-submit'><span><input onclick='sendChat()' type='button' value='发送' class='submit'/></span></div></div></div></div></div><script>function closeChat(){document.getElementById('chat').style.display = 'none';}function minChat(){var minChatBottom = document.getElementById('min');if(minChatBottom.innerHTML === '□'){document.getElementById('chat-content').style.display = 'block';document.getElementById('min').innerHTML = '-';}else{document.getElementById('chat-content').style.display = 'none';document.getElementById('min').innerHTML = '□';}}function time(time) { var date = new Date(time);var hh = (date.getHours() < 10 ? '0' + date.getHours() : date.getHours()) + ':';var mm = (date.getMinutes() < 10 ? '0' + date.getMinutes() : date.getMinutes()) + ':';var ss = (date.getSeconds() < 10 ? '0' + date.getSeconds() : date.getSeconds());return hh + mm + ss;}function sendChat() {var textarea = document.getElementById('textarea');chat(textarea.value);var content = '';content += '<li class=\"chat-message\">';content += '<p class=\"customer-time\">'+ time(new Date().getTime()) +'</p>';content += '<div class=\"service-content-right\"><div class=\"customer\">'+textarea.value+'</div></div>';content += '</li>';document.getElementById('chat-record').insertAdjacentHTML('beforeend', content);textarea.value = '';}var url = '{$url}';var ws;var timer;var cookieName = 'ws_unique';ws = new WebSocket(url);ws.onopen = function () {console.log('open');};ws.onmessage = function (event) {const {type, message, data = {}} = JSON.parse(event.data);if (type === 'user_notice') {alert(message);} else if (type === 'user_message') {messages(data.customer, data.content)} else if (type === 'connect') {if (getCookie() === null) {setCookie(data.unique);}heartbeat();};};ws.onclose = function () {clearInterval(timer);delCookie();};function heartbeat() {timer = setInterval(function () {send('heartbeat', {});}, 10000);};ws.onerror = function (event) {console.log(event);};function messages(customer, value) {var content = '';content += '<li class=\"chat-message\">';content += '<p class=\"service-name\">'+ customer +time(new Date().getTime())+'</p>';content += '<div class=\"service-content-left\"><div class=\"service\">'+value+'</div></div>';content += '</li>';document.getElementById('chat-record').insertAdjacentHTML('beforeend', content);}function chat(content) {send('chats_user', {content: content});};function send(type, data) {var send = {'type': type, 'unique': getCookie(),};ws.send(JSON.stringify(Object.assign(send, data)));};function setCookie(value) {var exp = new Date();exp.setTime(exp.getTime() + 60 * 60 * 1000);document.cookie = cookieName + '=' + escape(value);};function getCookie() {var arr, reg = new RegExp('(^| )' + cookieName + '=([^;]*)(;|$)');if (arr = document.cookie.match(reg)) {return unescape(arr[2]);}else{return null;}};function delCookie() {var exp = new Date();exp.setTime(exp.getTime() - 60 * 60 * 1000);var value = getCookie(cookieName);if (value != null) {document.cookie = cookieName + '=' + value + ';expires=' + exp.toGMTString();}};</script>";
    }
}

