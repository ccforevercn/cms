<?php
/**
 * @author: cc_forever<1253705861@qq.com>
 * @day: 2020/7/20
 */
namespace App\Http\Middleware;

use App\CcForever\extend\JsonExtend;
use Closure;

/**
 * 登陆中间件
 * Class LoginMiddleware
 * @package App\Http\Middleware
 */
class LoginMiddleware
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
        $id = auth('login')->id();
        if(is_null($id)){
            return JsonExtend::login('请先登陆');
        }
        return $next($request);
    }
}
