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
$admin = config('ccforever.admin_prefix', 'ccforever'); // 后台路由前缀
Route::group(['prefix'=> $admin], function() use($admin) { // 后台路由组
    Route::post('/login', 'LoginController@login')->name('login'.$admin);// 登陆
    Route::get('/captcha', 'PublicController@captcha')->name('captcha'.$admin);// 验证码
    Route::group(['middleware'=> ['login']], function() use($admin) {// 需要登陆的api
        Route::namespace('system')->group(function () use($admin) { // 系统路由组
            Route::get('/admins/list', 'AdminsController@lst')->name('adminslist'.$admin);// 管理员列表
            Route::post('/admins/insert', 'AdminsController@insert')->name('adminsinsert'.$admin);// 管理员添加
            Route::post('/admins/update', 'AdminsController@update')->name('adminsupdate'.$admin);// 管理员修改
            Route::post('/admins/delete', 'AdminsController@delete')->name('adminsdelete'.$admin);// 管理员删除
            Route::get('/admins/message', 'AdminsController@message')->name('adminsmessage'.$admin);// 管理员信息
            Route::get('/menus/list', 'MenusController@lst')->name('menuslist'.$admin);// 菜单列表
            Route::post('/menus/insert', 'MenusController@insert')->name('menusinsert'.$admin);// 菜单添加
            Route::post('/menus/update', 'MenusController@update')->name('menusupdate'.$admin);// 菜单修改
            Route::post('/menus/delete', 'MenusController@delete')->name('menusdelete'.$admin);// 菜单删除
            Route::get('/menus/message', 'MenusController@message')->name('menusmessage'.$admin);// 菜单信息
            Route::get('/menus/button', 'MenusController@button')->name('menusbutton'.$admin);// 后台菜单按钮(后台左侧菜单)
            Route::get('/rules/list', 'RulesController@lst')->name('ruleslist'.$admin);// 规则列表
            Route::post('/rules/insert', 'RulesController@insert')->name('rulesinsert'.$admin);// 规则添加
            Route::post('/rules/update', 'RulesController@update')->name('rulesupdate'.$admin);// 规则修改
            Route::post('/rules/delete', 'RulesController@delete')->name('rulesdelete'.$admin);// 规则删除
            Route::get('/rules/message', 'RulesController@message')->name('rulesmessage'.$admin);// 规则信息
            Route::get('/rules/menus', 'RulesController@menus')->name('rulesmenus'.$admin);// 规则菜单
        });
        Route::namespace('message')->group(function () use($admin) { // 文章信息路由组
            Route::get('/columns/list', 'ColumnsController@lst')->name('ruleslist'.$admin);// 栏目列表
            Route::post('/columns/insert', 'ColumnsController@insert')->name('rulesinsert'.$admin);// 栏目添加
            Route::post('/columns/update', 'ColumnsController@update')->name('rulesupdate'.$admin);// 栏目修改
            Route::post('/columns/delete', 'ColumnsController@delete')->name('rulesdelete'.$admin);// 栏目删除
            Route::get('/columns/message', 'ColumnsController@message')->name('rulesmessage'.$admin);// 栏目信息
        });
    });
});