<?php
/**
 * @author: cc_forever<1253705861@qq.com>
 * @day: 2020/7/20
 */
namespace App\Http\Middleware;

use Closure;

/**
 * 跨域请求中间件
 * Class CrossRequestMiddleware
 * @package App\Http\Middleware
 */
class CrossRequestMiddleware
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        header('Content-Type: text/html;charset=utf-8');
        header('Access-Control-Allow-Origin:*');
        header('Access-Control-Allow-Methods:POST,GET,PUT,OPTIONS,DELETE'); // 允许请求的类型
        header('Access-Control-Allow-Credentials: true'); // 设置是否允许发送 cookies
        header('Access-Control-Allow-Headers: Authori-zation,Authorization,Content-Type,Access-Control-Allow-Origin,Access-token,Content-Length,Accept-Encoding,X-Requested-with, Origin,Access-Control-Allow-Methods'); // 设置允许自定义请求头的字段
        return $next($request);
    }
}