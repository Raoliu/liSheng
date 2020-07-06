<?php
// +----------------------------------------------------------------------
// | ThinkPHP [ WE CAN DO IT JUST THINK ]
// +----------------------------------------------------------------------
// | Copyright (c) 2006~2018 http://thinkphp.cn All rights reserved.
// +----------------------------------------------------------------------
// | Licensed ( http://www.apache.org/licenses/LICENSE-2.0 )
// +----------------------------------------------------------------------
// | Author: liu21st <liu21st@gmail.com>
// +----------------------------------------------------------------------
/**
 * 后台管理路由
 */

/**
 * 免权限验证路由
 */
Route::group('admin', [
    'login$'=>'admin/Login/login',                                           //登录
    'editPassword'=>'admin/User/editPassword',                              //重置密码
    'logout$'=>'admin/Login/logout',                                         //退出
    'check$'=>'admin/User/check',                                            //验证用户是否存在
    'unlock'=>'admin/Login/unlock',                                        //验证用户是否存在
])->ext('html');
/**
 * 需要权限验证路由
 */
Route::group('admin', [

    //图片上传
    'upload$'=>'admin/Flie/upload',                                           //普通图片上传
    'textUpload$'=>'admin/Flie/textUpload',                                   //富文本框图片上传
    //首页
    'index$'=>'admin/Index/index',                                           //首页
    'home'=>'admin/Index/home',                                              //系统信息

    //用户管理
    'userList$'=>'admin/User/userList',                                      //用户列表
    'edit$'=>'admin/User/edit',                                              //添加/编辑用户
    'delete$'=>'admin/User/delete',                                          //删除用户
    'groupList$'=>'admin/User/groupList',                                    //用户组列表
    'editGroup$'=>'admin/User/editGroup',                                    //添加编辑用户组
    'disableGroup$'=>'admin/User/disableGroup',                              //禁用用户组
    'ruleList$'=>'admin/User/ruleList',                                      //用户组规则列表
    'editRule$'=>'admin/User/editRule',                                      //修改用户组规则

    //系统管理
    'cleanCache$'=>'admin/System/cleanCache',                                //清除缓存
    'log$'=>'admin/System/loginLog',                                         //登录日志
    'menu$'=>'admin/System/menu',                                            //系统菜单
    'editMenu$'=>'admin/System/editMenu',                                    //编辑菜单
    'deleteMenu$'=>'admin/System/deleteMenu',                                //删除菜单
    'config'=>'admin/System/config',                                         //系统配置
    'siteConfig'=>'admin/System/siteConfig',                                 //站点配置

    //商品管理
    'productList'=>'admin/Product/productList',                              //商品列表
    'productEdit$'=>'admin/Product/productEdit',                             //添加/编辑商品
    'productDelete$'=>'admin/Product/productDelete',                         //删除商品

    //活动管理
    'activeList'=>'admin/Active/activeList',                                 //活动列表
    'activeEdit$'=>'admin/Active/activeEdit',                                //添加/编辑活动
    'activeDelete$'=>'admin/Active/activeDelete',                            //删除活动
    'product'=>'admin/Active/product',                                       //选择商品展示页
    'selectJson'=>'admin/Active/selectJson',                                 //商品选择
    'winner'=>'admin/Active/winner',                                         //中奖查询
    'winnerList'=>'admin/Active/winnerList',                                 //中奖查询
    'expload'=>'admin/Active/expload',                                       //中奖查询

    //预约管理
    'appointment'=>'admin/Appointment/index',                                //预约首页
    'appexpload'=>'admin/Appointment/expload',                                  //预约下载
])->middleware(app\admin\middleware\CheckAuth::class)->ext('html');          //使用中间件验证

/**
 * miss路由
 * 没有定义的路由全部使用该路由
 */
Route::miss('admin/Login/login');
return [
];
