<?php
namespace app\api\controller;

use think\Request;
use think\Controller;
use think\Image;
header('Access-Control-Allow-Origin:*');
// 响应类型  
header('Access-Control-Allow-Methods:*');
// 响应头设置  
header('Access-Control-Allow-Headers:x-requested-with,content-type');

class Common extends Controller
{
	protected $request;//获取参数
	protected $params;//参数
	//参数规则
	protected $rules = array(
	//房子
		"House" => array(
			//分页查询
			"gethouse" => array(
				'page' => "require|number"
			),
			//单条数据查询
			"findhouse" => array(
				"hid" =>"require|number"
			),
			//添加
			"addhouse"=>array(
				'h_title' => 'require',
				"h_deploy" => "require",
				"h_tag" => "require",
//				"cityid" => "require|number",
				"h_room" => "require",
				"h_basets" => "require",
				"uid" => "require|number",
				"h_detail" => "require",
				"cityname" => "require",
				"h_money" => "require|number",
//				"checkIn" => "require|date",
//				"checkOut" => "require|date"
 			),
 			"delhouse" => array(
 				"hid" => 'require|number' 
 			),
 			"uphouse" => array(
// 				"hid" => "require|number",
 				'h_title' => 'require',
				"h_deploy" => "require",
				"h_tag" => "require",
//				"h_images" => "image|require|fileSize:20000000|fileExt:jpg,png,bnp,jpeg",
//				"cityid" => "require|number",
				"h_room" => "require",
				"h_basets" => "require",
				"hid" => "require|number",
				"h_detail" => "require",
				"cityname" => "require",
				"h_money" => "require|number",
//				"checkIn" => "require|date",
//				"checkOut" => "require|date"
 			),
 			"housephoto" => array(
 				"hid" => 'require|number',
 				"h_images[]" => "image|fileSize:20000000|fileExt:jpg,png,bnp,jpeg"
 			),
 			//搜索
 			"searchhouse" => array(
 				"type" => "require",
 				"typeName"=>"require"
 			),
 			"getuseridhouse"=>array(
 				"uid"=>'require|number'
 			),
 			//按房源id查询
 			"gethousehid" =>array(
 				"hid"=>'require|number'
 			)
		),
		
		//管理员
		"Admin" => array(
			"getadmin" => array(
				'page' => "require|number"
			),
			//单条数据查询
			"findadmin" => array(
				"aid" =>"require|number"
			),
			//添加
			"addadmin"=>array(
				'admin_name' => 'require|min:4',
				"admin_pwd" => "require|min:6|/^(?=[0-9a-zA-Z@_.]+$)/",
				"admin_sex" => "require",
				"admin_tel" => "require|length:11|/^1[3-8]{1}[0-9]{9}$/",
				"admin_address" => "require",
				"admin_data" => "require|date",
 			),
 			"deladmin" => array(
 				"aid" => 'require|number' 
 			),
 			"upadmin" => array(
 				"aid" => 'require|number',
   				"admin_name" => "require|min:4",
//				"admin_pwd" => "require|min:6|/^(?=[0-9a-zA-Z@_.]+$)/",
				"admin_tel" => "require|length:11|/^1[3-8]{1}[0-9]{9}$/",
				"admin_data" => "require|date",
				"admin_address" => "require"
 			),
 			"adminphoto" => array(
 				"aid" => 'require|number',
 				"admin_photo" => "image|require|fileSize:20000000|fileExt:jpg,png,bnp,jpeg"
 			),
 			"loginadmin" =>array(
 				"admin_name" => "require|min:4",
 				"admin_pwd" => "require|min:6|/^(?=[0-9a-zA-Z@_.]+$)/",
 			),
 			"getadminname"=>array(
 				"admin_name" => "require",
 			)
		),
		
		//用户
		"User" => array(
			"getuser" => array(
				'page' => "require|number"
			),
			//单条数据查询
			"finduser" => array(
				"uid" =>"require|number"
			),
			//添加
			"adduser"=>array(
				'user_name' => 'require|min:4',
				"user_pwd" => "require|min:6|/^(?=[0-9a-zA-Z@_.]+$)/",
				"user_sex" => "require",
				"user_tel" => "require|length:11|/^1[3-8]{1}[0-9]{9}$/",
				"user_data" => "require|date",
 			),
 			"deluser" => array(
 				"uid" => 'require|number' 
 			),
 			"upuser" => array(
 				"uid" => 'require|number'
// 				"user_name" => "require|min:4",
//				"user_pwd" => "require|min:6|/^(?=[0-9a-zA-Z@_.]+$)/",
//				"user_tel" => "require|length:11|/^1[3-8]{1}[0-9]{9}$/",
//				"user_data" => "require|date",
 			),
 			"userphoto" => array(
 				"uid" => 'require|number'
// 				"user_photo" => "image|require|fileSize:20000000|fileExt:jpg,png,bnp,jpeg"
 			),
 			"loginuser" =>array(
 				"user_name" => "require",
 				"user_pwd" => "require",
 			),
 			"wdlwjmm" => array(
 				"user_tel" =>"require|length:11|/^1[3-8]{1}[0-9]{9}$/",
 				"user_pwd" => "require|min:6|/^(?=[0-9a-zA-Z@_.]+$)/",
 			),
 			"upusertel"=>array(
 				"uid" => 'require|number',
 				"user_tel" =>"require|length:11|/^1[3-8]{1}[0-9]{9}$/",
 				
 			),
 			"getusername"=>array(
 				"typeName" => "require",
 			)
		),
		
		//城市
		"City" =>array(
			"getcity" => array(
				'page' => "require|number"
			),
			//单条数据查询
			"findcity" => array(
				"cityid" =>"require|number"
			),
			//添加
			"addcity"=>array(
				'cityname' => 'require'
 			),
 			"delcity" => array(
 				"cityid" => 'require|number' 
 			),
 			"upcity" => array(
 				"cityid" => 'require|number',
 				"cityname" => "require"
 			)
		),
		
		//房东
		"Landlord" =>array(
			"getlandlord" => array(
				'page' => "require|number"
			),
			//单条数据查询
			"findlandlord" => array(
				"ldid" =>"require|number"
			),
			//添加
			"addlandlord"=>array(
				'ld_name' => 'require|min:4',
				"ld_sex" => "require",
				"ld_tel" => "require|length:11|/^1[3-8]{1}[0-9]{9}$/",
				"reg_time" => "require|date"
 			),
 			"dellandlord" => array(
 				"ldid" => 'require|number' 
 			),
 			"uplandlord" => array(
 				"ldid" => 'require|number',
 				"ld_name" => "require|min:4",
				"ld_tel" => "require|length:11|/^1[3-8]{1}[0-9]{9}$/",
				"reg_time" => "require|date"
 			),
 			"ldphoto" => array(
 				"ldid" => 'require|number',
 				"ld_photo" => "image|require|fileSize:20000000|fileExt:jpg,png,bnp,jpeg"
 			)
		),
		
		//收藏
		"Collect" =>array(
			"getcollect" => array(
				'page' => "require|number"
			),
			//单条数据查询
			"findcollect" => array(
				"colid" =>"require|number"
			),
			//添加
			"addcollect"=>array(
				"hid" =>"require|number",
				"uid" =>"require|number",
				'h_images' => 'require',
				"h_title" => "require",
				"cityname" => "require",
				"h_deploy" => "require"
 			),
 			"delcollect" => array(
 				"colid" => 'require|number' 
 			),
 			"usercollect"=>array(
 				"uid" =>"require|number"
 			)
		),
		
		//评论
		"Comment" =>array(
			"getcomment" => array(
				'page' => "require|number"
			),
			//单条数据查询
			"findcomment" => array(
				"comid" =>"require|number"
			),
			//添加
			"addcomment"=>array(
				"hid" =>"require|number",
				"uid" =>"require|number",
				"com_detail" => "require|min:5",
				"com_date" => "require|date",
				"user_name" => "require",
				"user_photo" => "require"
 			),
 			"hidcomment" => array(
 				"hid" =>"require|number",
 				'page' => "require|number"
 			),
 			"commentphoto" =>array(
 				"comid" =>"require|number",
 				"comment_photo[]" =>""
 			),
 			"findcommentorid" =>array(
 				"orid" =>"require|number"
 			),
 			"upcommentphoto"=>array(
 				"uid"=>"require|number",
 				"user_photo"=>"require"
 			),
 			"getcommentuid" =>array(
 				"uid"=>"require|number",
 			)
 			
		),
		
		//订单
		"Order" =>array(
			"getorder" => array(
				'page' => "require|number"
			),
			//单条数据查询
			"findorder" => array(
				"orid" =>"require|number"
			),
			//添加
			"addorder"=>array(
				"h_title" =>"require",
				"user_name" => "require",
				"h_money" =>"require|number",
				"h_images" => "require",
				"into_time" => "require|date",
				"exit_time" => "require|date",
				"uid" =>"require|number",
//				"county" => "require",
				"IDcard" => "require|length:18",
				"myName" => "require",
				"or_tel" => "require|length:11|/^1[3-8]{1}[0-9]{9}$/",
				"time_day" => "require|number",
				"isdel" => "require|number"
 			),
 			"delorder" => array(
 				"orid" => "require|number"
 			),
 			"userorder"=>array(
 				"uid" =>"require|number"
 			),
 			"uporderzt"=>array(
 				"orid" =>"require|number",
 				"isdel" => "require|number"
 			),
 			"uporderpl"=>array(
 				"orid" =>"require|number",
 				"isComment" => "require|number"
 			),
 			//是否评价
 			"getiscomment" =>array(
 				"isComment" => "require|number",
 				"user_name" =>"require",
 				"isdel" => "require"
 			),
 			//是否确认入住和取消订单
 			"getisdel" =>array(
 				"user_name" =>"require",
 				"isdel" => "require"
 			)	
 			
		)
	);
	protected $validate;
	
	//返回数据
	public function check_msg($code, $msg, $data=[])
	{
		$return->data['code'] = $code;
		$return->data['msg'] = $msg;
		$return->data['data'] = $data; 
		echo json_encode($return->data);
	}
	
	//上传头像
	public function upload_file($file,$type='')
	{
		
//		dump($file);die;
		$info = $file->move(ROOT_PATH . 'public' . DS . 'uploads');
		
		if($info)
		{
			$path = '/uploads/' . $info->getSaveName();		
			//图片裁剪
			if(!empty($type))
			{
				$this->image_edit($path,$type);
			}
			return 'http://localhost:8081/mybuilding/public'.str_replace("\\", '/', $path);
		}else
		{
			$this->check_msg(400,$file->getError());
		}
	}
	//图片裁剪
	public function image_edit($path,$type)
	{
		$image = Image::open(ROOT_PATH.'public'.$path);
		switch($type)
		{
			case 'head_img':
				$image->thumb(200,200,Image::THUMB_CENTER)->save(ROOT_PATH.'public'.$path);
				break;
			case 'house_img':
				
		}
	}
	//身份证、电话信息保密
	public function keepsth($data,$num,$numb)
	{
		//mb_strlen获取要替换的长度
		$length = mb_strlen($data,"utf-8")-$num-$numb;
		
		//str_repeat规定要替换的字符的长度
	    $str = str_repeat("*",$length);//替换字符数量
	    
	    //substr_replace用*来替换
	    $re = substr_replace($data,$str,$num,$length);
	    return $re;
	}
	//缓存资源
//	public function 
}
