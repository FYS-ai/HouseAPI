<?php
use think\Route;

//房子
//分页查询
Route::GET("get_house","api/house/gethouse");
//单条数据查询
Route::GET("find_house","api/house/findhouse");
//添加
Route::rule("add_house","api/house/addhouse");
//删除
Route::GET("del_house","api/house/delhouse");
//修改
Route::rule("up_house","api/house/uphouse");
//上传图片
Route::rule("house_photo","api/house/housephoto");
//搜索
Route::GET("search_house","api/house/searchhouse");
//查询所有房子
Route::GET("get_house_over","api/house/gethouseover");
//根据用户id查询房子
Route::GET("get_userid_house","api/house/getuseridhouse");
//根据房源id查询房子
Route::GET("get_house_hid","api/house/gethousehid");


//管理员
//按用户名查找
Route::rule("get_admin_name","api/admin/getadminname");
//查询全部
Route::GET("admin_over","api/admin/adminover");
//分页查询
Route::GET("get_admin","api/admin/getadmin");
//单条查询
Route::GET("find_admin","api/admin/findadmin");
//添加
Route::rule("add_admin","api/admin/addadmin");
//删除
Route::rule("del_admin","api/admin/deladmin");
//修改
Route::rule("up_admin","api/admin/upadmin");
//管理员上传头像
Route::POST("admin_photo","api/admin/adminphoto");
//登录
Route::rule("login_admin","api/admin/loginadmin");


//用户
//按用户名查找
Route::rule("get_user_name","api/user/getusername");
//查询全部
Route::GET("over_user","api/user/getuserover");
//分页查询
Route::GET("get_user","api/user/getuser");
//单条查询
Route::GET("find_user","api/user/finduser");
//添加
Route::rule("add_user","api/user/adduser");
//删除
Route::rule("del_user","api/user/deluser");
//修改
Route::rule("up_user","api/user/upuser");
//用户上传头像
Route::rule("userheader_photo","api/user/userphoto");
//登录
Route::rule("login_user","api/user/loginuser");
//未登录忘记密码
Route::rule("user_wdlwjmm","api/user/wdlwjmm");
//更换手机
Route::rule("up_usertel","api/user/upusertel");


//城市
//分页查询
Route::GET("get_city","api/city/getcity");
//单条查询
Route::GET("find_city","api/city/findcity");
//添加
Route::rule("add_city","api/city/addcity");
//删除
Route::GET("del_city/:cityid","api/city/delcity");
//修改
Route::rule("up_city","api/city/upcity");


//房东
//分页查询
Route::GET("get_landlord","api/landlord/getlandlord");
//单条查询
Route::GET("find_landlord","api/landlord/findlandlord");
//添加
Route::rule("add_landlord","api/landlord/addlandlord");
//删除
Route::GET("del_landlord","api/landlord/dellandlord");
//修改
Route::rule("up_landlord","api/landlord/uplandlord");
//上传头像
Route::POST("ld_photo","api/landlord/ldphoto");


//收藏
//查询全部
Route::GET("over_collect","api/collect/getcollectover");
//分页查询
Route::GET("get_collect","api/collect/getcollect");
//单条查询
Route::GET("find_collect","api/collect/findcollect");
//添加
Route::rule("add_collect","api/collect/addcollect");
//删除
Route::GET("del_collect","api/collect/delcollect");
//显示个人收藏
Route::GET("user_collect","api/collect/usercollect");


//评论
//查询全部
Route::GET("comment_over","api/comment/getcommentover");
//分页查询
Route::GET("get_comment","api/comment/getcomment");
//单条查询
Route::GET("find_comment","api/comment/findcomment");
Route::GET("hid_comment","api/comment/hidcomment");
//添加
Route::rule("add_comment","api/comment/addcomment");
//上传图片
Route::rule("comment_photo","api/comment/commentphoto");
//根据订单id查询
Route::GET("find_commentorid","api/comment/findcommentorid");
//用户修改头像，评论头像同步
Route::rule("up_comment_photo","api/comment/upcommentphoto");
//用户id查询评论
Route::rule("get_comment_uid","api/comment/getcommentuid");


//订单
//查询全部
Route::GET("order_over","api/order/getorderover");
//分页查询
Route::GET("get_order","api/order/getorder");
//单条查询
Route::GET("find_order","api/order/findorder");
//添加
Route::rule("add_order","api/order/addorder");
//取消
Route::GET("del_order","api/order/delorder");
//根据个人显示个人订单
Route::rule("user_order","api/order/userorder");
//修改订单状态
Route::rule("up_orderzt","api/order/uporderzt");
//修改订单的评论状态
Route::rule("up_orderpl","api/order/uporderpl");
//是否评价
Route::rule("get_iscomment","api/order/getiscomment");
//是否确认入住和取消订单
Route::rule("get_isdel","api/order/getisdel");