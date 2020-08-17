<?php
/**
 * @author: cc_forever<1253705861@qq.com>
 * @day: 2020/7/20
 */

namespace App\Http\Controllers;

use App\CcForever\controller\BaseController;
use App\CcForever\extend\JsonExtend;
use App\Http\Requests\Admins\AdminsRequest;
use App\Http\Requests\LoginRequest;
use App\Repositories\AdminsRepository;
use App\Repositories\AdminsTokenRepository;

/**
 * 登陆控制器
 * Class LoginController
 * @package App\Http\Controllers
 */
class LoginController extends BaseController
{
    public function __construct()
    {
        $this->middleware('auth:login', ['except' => ['login', 'logout']]);
    }

    /**
     * 登陆
     *
     * @param LoginRequest $loginRequest
     * @param AdminsRepository $adminsRepository
     * @param AdminsTokenRepository $adminsTokenRepository
     * @return object
     */
    public function login(LoginRequest $loginRequest, AdminsRepository $adminsRepository, AdminsTokenRepository $adminsTokenRepository)
    {
        $login = $loginRequest->all(); // 登陆请求数据
//        $login['username'] = 'ccforever';
//        $login['password'] = '688888886';
//        $login['captcha'] = '9epm';
//        $login['key'] = '$2y$10$Y6rM171zMdAy/B1almMLSOHrYu5e/moR9wfKEL1EI8WYdtU0GTY8y';
        if(!captcha_api_check($login['captcha'], $login['key'])){ // 验证码验证
            return JsonExtend::error('验证码错误');
        }
        $loginStatus = $adminsRepository::login($login['username'], $login['password']); // 验证管理员账号密码
        if(!$loginStatus){ // 验证失败
            return JsonExtend::error($adminsRepository::returnMsg("登陆失败"));
        }
        $loginData = $adminsRepository::returnData();
        $loginStatus = $adminsTokenRepository::login($loginData);
        if(!$loginStatus){ // 验证失败
            return JsonExtend::error($adminsTokenRepository::returnMsg("登陆失败"));
        }
        $loginData['token_type'] = 'bearer';
        unset($loginData['id']);
        return JsonExtend::success($adminsTokenRepository::returnMsg('登陆成功'), $loginData);
    }


    /**
     * 退出
     *
     * @param AdminsRequest $adminsRequest
     * @param AdminsRepository $adminsRepository
     * @return object
     */
    public function logout(AdminsRequest $adminsRequest, AdminsRepository $adminsRepository): object
    {
        $id = $adminsRequest->input('id');
        $bool = $adminsRepository::logout($id);
        if($bool){
            return JsonExtend::success($adminsRepository::returnMsg('退出成功'), $adminsRepository::returnData([]));
        }
        return JsonExtend::error($adminsRepository::returnMsg("退出失败"));
    }
}