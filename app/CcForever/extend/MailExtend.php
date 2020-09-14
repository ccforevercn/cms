<?php
/**
 * @author: cc_forever<1253705861@qq.com>
 * @day: 2020/9/14
 */

namespace App\CcForever\extend;

use Illuminate\Support\Facades\Mail;

/**
 * 邮箱
 *
 * Class MailExtend
 * @package App\CcForever\extend
 */
class MailExtend
{
    /**
     * 发送邮件
     *
     * @param string $subject
     * @param string $message
     * @param string $receive
     */
    public static function send(string $subject, string $message, string $receive): void
    {
        try{
            Mail::raw($message, function($message) use($receive, $subject){
                $message->to($receive);
                $message->subject($subject);
            });
        }catch (\Exception $e){
            info('缓存到期提示失败：'.$e->getMessage().'，邮件内容'.$message.' 时间：'.date('Y-m-d H:i:s'));
        }
    }
}