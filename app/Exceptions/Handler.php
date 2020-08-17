<?php

namespace App\Exceptions;

use App\CcForever\extend\JsonExtend;
use Exception;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Symfony\Component\Debug\Exception\FlattenException;
use Symfony\Component\HttpKernel\Exception\MethodNotAllowedHttpException;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array
     */
    protected $dontFlash = [
        'password',
        'password_confirmation',
    ];

    /**
     * Report or log an exception.
     *
     * @param  \Exception  $exception
     * @return void
     *
     * @throws \Exception
     */
    public function report(Exception $exception)
    {
        parent::report($exception);
    }

    /**
     * 处理访问失败
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Exception  $exception
     * @return \Symfony\Component\HttpFoundation\Response
     *
     * @throws \Exception
     */
    public function render($request, Exception $exception)
    {
        $errorObject = FlattenException::create($exception);
        $code = $errorObject->getStatusCode(); // 获取状态码
        $debug = config('app.debug', false); // 获取是否开启debug
        if($debug){ // 开启debug时，获取错误信息
            $errorMessage = $errorObject->getMessage();
        }else{ // 获取自定义提示
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
        }
        if(strlen($errorMessage)){
            return JsonExtend::error($errorMessage);
        }
        return parent::render($request, $exception);
    }
}
