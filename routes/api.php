<?php

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/
$admin = env('ADMIN_PREFIX', 'ccforever'); // 后台路由前缀
Route::group(['prefix'=> $admin], function() use($admin) { // 后台路由组
    Route::post('/login', 'LoginController@login')->name('login'.$admin);// 登陆
    Route::get('/captcha', 'PublicController@captcha')->name('captcha'.$admin);// 验证码
    Route::group(['middleware'=> ['login']], function() use($admin) {// 需要登陆的api
        Route::get('/admins/list', 'AdminsController@lst')->name('adminslist'.$admin);// 管理员列表
        Route::post('/admins/add', 'AdminsController@add')->name('adminsadd'.$admin);// 管理员添加
        Route::post('/admins/modify', 'AdminsController@modify')->name('adminsmodify'.$admin);// 管理员修改
        Route::post('/admins/recycle', 'AdminsController@recycle')->name('adminsrecycle'.$admin);// 管理员删除(假删除)
        Route::get('/admins/message', 'AdminsController@message')->name('adminsmessage'.$admin);// 管理员信息
        Route::get('/menus/list', 'MenusController@lst')->name('menuslist'.$admin);// 菜单列表
        Route::post('/menus/add', 'MenusController@add')->name('menusadd'.$admin);// 菜单添加
        Route::post('/menus/modify', 'MenusController@modify')->name('menusmodify'.$admin);// 菜单修改
        Route::post('/menus/recycle', 'MenusController@recycle')->name('menusrecycle'.$admin);// 菜单删除(假删除)
        Route::get('/menus/message', 'MenusController@message')->name('menusmessage'.$admin);// 菜单信息
    });
});
