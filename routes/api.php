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
$admin = config('ccforever.prefix.admin', 'ccforever'); // 后台路由前缀
Route::group(['prefix'=> $admin], function() use($admin) { // 后台路由组
    Route::post('/login', 'LoginController@login')->name('login'.$admin);// 登陆
    Route::get('/captcha', 'PublicController@captcha')->name('captcha'.$admin);// 验证码
    Route::group(['middleware'=> ['login']], function() use($admin) {// 需要登陆的api
        Route::delete('/logout', 'LoginController@logout')->name('logout'.$admin);// 退出
        Route::namespace('system')->group(function () use($admin) { // 系统路由组
            Route::get('/admins/list', 'AdminsController@lst')->name('adminslist'.$admin);// 管理员列表
            Route::post('/admins/insert', 'AdminsController@insert')->name('adminsinsert'.$admin);// 管理员添加
            Route::put('/admins/update', 'AdminsController@update')->name('adminsupdate'.$admin);// 管理员修改
            Route::delete('/admins/delete', 'AdminsController@delete')->name('adminsdelete'.$admin);// 管理员删除
            Route::get('/admins/message', 'AdminsController@message')->name('adminsmessage'.$admin);// 管理员信息
            Route::get('/menus/list', 'MenusController@lst')->name('menuslist'.$admin);// 菜单列表
            Route::post('/menus/insert', 'MenusController@insert')->name('menusinsert'.$admin);// 菜单添加
            Route::put('/menus/update', 'MenusController@update')->name('menusupdate'.$admin);// 菜单修改
            Route::delete('/menus/delete', 'MenusController@delete')->name('menusdelete'.$admin);// 菜单删除
            Route::get('/menus/message', 'MenusController@message')->name('menusmessage'.$admin);// 菜单信息
            Route::get('/menus/menus', 'MenusController@menus')->name('menusmenus'.$admin);// 所有菜单
            Route::get('/menus/button', 'MenusController@button')->name('menusbutton'.$admin);// 后台菜单按钮(后台左侧菜单)
            Route::get('/rules/list', 'RulesController@lst')->name('ruleslist'.$admin);// 规则列表
            Route::post('/rules/insert', 'RulesController@insert')->name('rulesinsert'.$admin);// 规则添加
            Route::put('/rules/update', 'RulesController@update')->name('rulesupdate'.$admin);// 规则修改
            Route::delete('/rules/delete', 'RulesController@delete')->name('rulesdelete'.$admin);// 规则删除
            Route::get('/rules/message', 'RulesController@message')->name('rulesmessage'.$admin);// 规则信息
            Route::get('/rules/menus', 'RulesController@menus')->name('rulesmenus'.$admin);// 规则菜单
            Route::get('/rules/rules', 'RulesController@rules')->name('rulesrules'.$admin);// 规则列表信息
        });
        Route::namespace('message')->group(function () use($admin) { // 信息路由组
            Route::get('/columns/list', 'ColumnsController@lst')->name('columnslist'.$admin);// 栏目列表
            Route::post('/columns/insert', 'ColumnsController@insert')->name('columnsinsert'.$admin);// 栏目添加
            Route::put('/columns/update', 'ColumnsController@update')->name('columnsupdate'.$admin);// 栏目修改
            Route::delete('/columns/delete', 'ColumnsController@delete')->name('columnsdelete'.$admin);// 栏目删除
            Route::get('/columns/message', 'ColumnsController@message')->name('columnsmessage'.$admin);// 栏目信息
            Route::post('/columns/content', 'ColumnsController@content')->name('columnscontent'.$admin);// 栏目内容 添加、修改、查询
            Route::get('/columns/views', 'ColumnsController@views')->name('columnsviews'.$admin);// 栏目视图
            Route::get('/columns/columns', 'ColumnsController@columns')->name('columnscolumns'.$admin);// 栏目列表(全部)
            Route::get('/messages/list', 'MessagesController@lst')->name('messageslist'.$admin);// 信息列表
            Route::post('/messages/insert', 'MessagesController@insert')->name('messagesinsert'.$admin);// 信息添加
            Route::put('/messages/update', 'MessagesController@update')->name('messagesupdate'.$admin);// 信息修改
            Route::delete('/messages/delete', 'MessagesController@delete')->name('messagesdelete'.$admin);// 信息删除
            Route::get('/messages/message', 'MessagesController@message')->name('messagesmessage'.$admin);// 信息信息
            Route::post('/messages/content', 'MessagesController@content')->name('messagescontent'.$admin);// 信息内容 添加、修改、查询
            Route::get('/messages/tags', 'MessagesController@tags')->name('messagestags'.$admin);// 信息标签
            Route::get('/messages/views', 'MessagesController@views')->name('messagesviews'.$admin);// 信息视图
            Route::put('/messages/click', 'MessagesController@click')->name('messagesclick'.$admin);// 信息 点击量添加
            Route::put('/messages/state', 'MessagesController@state')->name('messagesstate'.$admin);// 信息内容 状态修改
            Route::get('/messages/statistics', 'MessagesController@statistics')->name('messagesstatistics'.$admin);// 信息内容统计
            Route::get('/tags/list', 'TagsController@lst')->name('tagslist'.$admin);// 标签列表
            Route::post('/tags/insert', 'TagsController@insert')->name('tagsinsert'.$admin);// 标签添加
            Route::put('/tags/update', 'TagsController@update')->name('tagsupdate'.$admin);// 标签修改
            Route::delete('/tags/delete', 'TagsController@delete')->name('tagsdelete'.$admin);// 标签删除
            Route::get('/tags/message', 'TagsController@message')->name('tagsmessage'.$admin);// 标签信息
            Route::get('/tags/tags', 'TagsController@tags')->name('tagstags'.$admin);// 标签列表(全部)
            Route::get('/views/list', 'ViewsController@lst')->name('viewslist'.$admin);// 视图列表
            Route::post('/views/insert', 'ViewsController@insert')->name('viewsinsert'.$admin);// 视图添加
            Route::put('/views/update', 'ViewsController@update')->name('viewsupdate'.$admin);// 视图修改
            Route::delete('/views/delete', 'ViewsController@delete')->name('viewsdelete'.$admin);// 视图删除
            Route::get('/views/message', 'ViewsController@message')->name('viewsmessage'.$admin);// 视图信息
        });
        Route::namespace('config')->group(function () use($admin) { // 配置路由组
            Route::get('/config/category/list', 'ConfigCategoryController@lst')->name('configcategorylist'.$admin);// 配置分类列表
            Route::post('/config/category/insert', 'ConfigCategoryController@insert')->name('configcategoryinsert'.$admin);// 配置分类添加
            Route::put('/config/category/update', 'ConfigCategoryController@update')->name('configcategoryupdate'.$admin);// 配置分类修改
            Route::delete('/config/category/delete', 'ConfigCategoryController@delete')->name('configcategorydelete'.$admin);// 配置分类删除
            Route::get('/config/category/message', 'ConfigCategoryController@message')->name('configcategorymessage'.$admin);// 配置分类信息
            Route::get('/config/category/category', 'ConfigCategoryController@category')->name('configcategorycategory'.$admin);// 配置分类列表(all)
            Route::get('/config/message/list', 'ConfigMessageController@lst')->name('configmessagelist'.$admin);// 配置信息列表
            Route::post('/config/message/insert', 'ConfigMessageController@insert')->name('configmessageinsert'.$admin);// 配置信息添加
            Route::put('/config/message/update', 'ConfigMessageController@update')->name('configmessageupdate'.$admin);// 配置信息修改
            Route::delete('/config/message/delete', 'ConfigMessageController@delete')->name('configmessagedelete'.$admin);// 配置信息删除
            Route::get('/config/message/message', 'ConfigMessageController@message')->name('configmessagemessage'.$admin);// 配置信息信息
            Route::get('/config/message/config', 'ConfigMessageController@config')->name('configmessageconfig'.$admin);// 配置信息获取
        });
        Route::namespace('markets')->group(function () use($admin) { // 营销路由组
            Route::get('/banners/list', 'BannersController@lst')->name('bannerslist'.$admin);// 轮播图列表
            Route::post('/banners/insert', 'BannersController@insert')->name('bannersinsert'.$admin);// 轮播图添加
            Route::put('/banners/update', 'BannersController@update')->name('bannersupdate'.$admin);// 轮播图修改
            Route::delete('/banners/delete', 'BannersController@delete')->name('bannersdelete'.$admin);// 轮播图删除
            Route::get('/banners/message', 'BannersController@message')->name('bannersmessage'.$admin);// 轮播图信息
            Route::get('/banners/banners', 'BannersController@banners')->name('bannersbanners'.$admin);// 轮播图
            Route::get('/chats/list', 'ChatsController@lst')->name('chatslist'.$admin);// 留言列表
            Route::get('/chats/users', 'ChatsController@users')->name('chatsusers'.$admin);// 留言用户列表
            Route::get('/chats/chats', 'ChatsController@chats')->name('chatschats'.$admin);// 留言客服和用户对话列表
            Route::put('/chats/see', 'ChatsController@see')->name('chatssee'.$admin);// 留言状态修改
            Route::get('/chats/statistics', 'ChatsController@statistics')->name('chatsstatistics'.$admin);// 留言统计
        });
        Route::namespace('seo')->group(function () use($admin) { // seo路由组
            Route::get('/links/list', 'LinksController@lst')->name('linkslist'.$admin);// 友情链接列表
            Route::post('/links/insert', 'LinksController@insert')->name('linksinsert'.$admin);// 友情链接添加
            Route::put('/links/update', 'LinksController@update')->name('linksupdate'.$admin);// 友情链接修改
            Route::delete('/links/delete', 'LinksController@delete')->name('linksdelete'.$admin);// 友情链接删除
            Route::get('/links/message', 'LinksController@message')->name('linksmessage'.$admin);// 友情链接信息
            Route::get('/partners/list', 'PartnersController@lst')->name('partnerslist'.$admin);// 合作伙伴列表
            Route::post('/partners/insert', 'PartnersController@insert')->name('partnersinsert'.$admin);// 合作伙伴添加
            Route::put('/partners/update', 'PartnersController@update')->name('partnersupdate'.$admin);// 合作伙伴修改
            Route::delete('/partners/delete', 'PartnersController@delete')->name('partnersdelete'.$admin);// 合作伙伴删除
            Route::get('/partners/message', 'PartnersController@message')->name('partnersmessage'.$admin);// 合作伙伴信息
            Route::post('/cache/index', 'CacheController@index')->name('cacheindex'.$admin);// 缓存首页
            Route::post('/cache/columns', 'CacheController@columns')->name('cachecolumns'.$admin);// 缓存栏目
            Route::post('/cache/message', 'CacheController@message')->name('cachemessage'.$admin);// 缓存信息
            Route::post('/cache/search', 'CacheController@search')->name('cachesearch'.$admin);// 缓存搜索页
            Route::get('/robots/content', 'RobotsController@content')->name('robotscontent'.$admin);// robots内容获取
            Route::put('/robots/update', 'RobotsController@update')->name('robotsupdate'.$admin);// robots内容修改
            Route::get('/sitemap/index', 'SiteMapController@index')->name('sitemapindex'.$admin);// 网站地图html缓存
            Route::post('/sitemap/html', 'SiteMapController@html')->name('sitemaphtml'.$admin);// 网站地图html缓存
            Route::post('/sitemap/xml', 'SiteMapController@xml')->name('sitemapxml'.$admin);// 网站地图xml缓存
            Route::post('/sitemap/txt', 'SiteMapController@txt')->name('sitemaptxt'.$admin);// 网站地图txt缓存
            Route::get('/substations/list', 'SubstationsController@lst')->name('substationslist'.$admin);// 分站列表
            Route::post('/substations/insert', 'SubstationsController@insert')->name('substationsinsert'.$admin);// 分站添加
            Route::put('/substations/update', 'SubstationsController@update')->name('substationsupdate'.$admin);// 分站修改
            Route::delete('/substations/delete', 'SubstationsController@delete')->name('substationsdelete'.$admin);// 分站删除
            Route::get('/substations/message', 'SubstationsController@message')->name('substationsmessage'.$admin);// 分站信息
            Route::post('/substations/cache', 'SubstationsController@cache')->name('substationscache'.$admin);// 分站缓存
            Route::get('/forbidden/word/forbidden', 'ForbiddenWordController@forbidden')->name('forbiddenwordforbidden'.$admin);// 违禁词查询
            Route::put('/forbidden/word/update', 'ForbiddenWordController@update')->name('forbiddenwordupdate'.$admin);// 违禁词修改
            Route::put('/forbidden/word/check', 'ForbiddenWordController@check')->name('forbiddenwordcheck'.$admin);// 违禁词验证
        });
        Route::namespace('upload')->group(function () use($admin) { // 上传文件路由组
            Route::post('/uploads/upload', 'UploadsController@upload')->name('uploadsupload'.$admin);// 单文件上传

        });
    });
});