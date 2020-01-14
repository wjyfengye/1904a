<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Route::get('index/index',"Index\IndexController@index" );
Route::get('index/sucai',"Index\WeekController@sucai" );//素材

Route::any('week/index',"Index\WeekController@index" );//第一次周考重链微信接口

Route::any('week/threeWeeks',"Index\WeekController@threeWeeks" );//第三次周考  
Route::any('week/personal',"Index\WeekController@personal" ); //个人中心
Route::any('week/perList',"Index\WeekController@perList" ); //个人中心展示

/**
 *  第二次周考  wechat文件夹
 *  自定义微信回复
 */
Route::get('wechat/save',"Wechat\WechatController@save" );// 关注后添加回复
Route::post('wechat/savedo',"Wechat\WechatController@savedo" );//执行添加
Route::get('wechat/list',"Wechat\WechatController@list" );//    回复列表
Route::get('wechat/update/{id}',"Wechat\WechatController@update" );//回复修改
Route::get('wechat/getMedia',"Wechat\WechatController@getMedia" );//ajax查询素材

Route::get('week/curl',"Index\WeekController@curl" );//创建CURL请求

Route::post('index/index',"Index\IndexController@reponseMsg" );
Route::get('index/test',"Index\IndexController@test" );//天气接口测试
Route::get('index/usertst',"Index\IndexController@usertst" );

/**
 *  路由分组   admin管理员模块
 *  prefix    路由前缀
 *  middleware  中间件
 */
Route::prefix('admin/')->middleware('CheckLogin')->group(function(){
        // return view('welcome');
    Route::any('index',"Admin\AdminController@index");
    Route::any('save',"Admin\AdminController@save");    //管理员添加
    Route::any('savedo',"Admin\AdminController@savedo");//执行管理员添加
    Route::any('show',"Admin\AdminController@show");    //管理员列表展示
    Route::get('weather',"Admin\AdminController@weather" );//天气视图
    Route::get('getweather',"Admin\AdminController@getWeather" );//
});

/**
 *  月考
 */
Route::any('adminwechat/wechat',"Admin\WechatController@wechat");//接入

/**
 *  粉丝标签模块 
 */
Route::get('fans/list',"Admin\FansController@list");//粉丝列表
Route::get('fans/add',"Admin\FansController@add");//标签添加
Route::post('fans/addDo',"Admin\FansController@addDo");//标签执行添加
Route::get('fans/show',"Admin\FansController@show");//标签展示
Route::get('fans/edit/{id}',"Admin\FansController@edit");//标签编辑
Route::post('fans/update',"Admin\FansController@update");//执行标签编辑
Route::get('fans/del/{id}',"Admin\FansController@del");//标签编辑
Route::get('fans/getFans',"Admin\FansController@getFans");//
Route::get('fans/saveFans',"Admin\FansController@saveFans");//
Route::get('fans/group',"Admin\FansController@group");//群发消息
Route::post('fans/groupDo',"Admin\FansController@groupDo");//执行群发消息
/**
 *  微信菜单
 */
Route::get('menu/add',"Admin\MenuController@add");//菜单添加视图 
Route::post('menu/addDo',"Admin\MenuController@addDo" );//菜单执行添加
Route::get('menu/index',"Admin\MenuController@index");//菜单视图 

/**
 *  素材模块
 */
Route::get('media/save',"Admin\MediaController@save" );//素材添加视图
Route::post('media/savedo',"Admin\MediaController@saveDo" );//素材执行添加
Route::get('media/list',"Admin\MediaController@list" );//素材列表

/**
 *  渠道模块
 */
Route::get('channel/save',"Admin\ChannelController@save");//渠道添加视图
Route::post('channel/savedo',"Admin\ChannelController@saveDo");//渠道添加
Route::get('channel/list',"Admin\ChannelController@list");//渠道列表

/**
 * 测试控制器
 */
Route::get('test/index',"Admin\TestController@index");//渠道测试 二维码
Route::get('test/test',"Admin\TestController@test");//自定义菜单测试 
Route::get('test/login',"Admin\TestController@login");//验证码测试 
Route::get('test/authTest',"Admin\TestController@authTest");//网页授权
Route::get('test/auth',"Admin\TestController@auth");//网页授权

/**
 *  登录模块
 */
Route::any('login/login',"Admin\LoginController@login");//登录视图
Route::any('login/loginDo',"Admin\LoginController@loginDo");//执行登录
Route::get('login/send',"Admin\LoginController@send");//验证码
Route::get('login/bind',"Admin\LoginController@bind");//绑定账号
Route::post('login/bindDo',"Admin\LoginController@bindDo");//执行绑定

/**
 *  RBAC 权限管理模块
 */
Route::get('power/save',"Admin\PowerController@save");//权限
Route::post('power/saveDo',"Admin\PowerController@saveDo");//执行权限添加 
Route::get('power/index',"Admin\PowerController@index");//权限列表
Route::any('power/list/{id?}',"Admin\PowerController@list");//分配权限列表

Route::get('role/save',"Admin\RoleController@save");//角色添加视图
Route::post('role/saveDo',"Admin\RoleController@saveDo");//执行角色添加
Route::any('role/index/{id?}',"Admin\RoleController@index");//角色分配列表
Route::any('role/list',"Admin\RoleController@list");//角色列表