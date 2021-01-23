<?php
namespace app\api\controller;
use app\api\model\User as userModel;
use app\api\controller\Common;

use think\Request;
use think\Validate;

class User extends Common
{
	//按用户名查找
	public function getusername(){
		$this->request = Request::instance();
		$this->params = $this->request->param();
		$this->check_getname($this->params);
	}
	//查询全部
	public function getuserover()
	{
		$this->request = Request::instance();
		$this->params = $this->request->post();
		$this->check_userover($this->params);
	}
	//更换手机
	public function upusertel()
	{
		$this->request = Request::instance();
		$this->params = $this->request->post();
		$this->check_uptel($this->params);
	} 
	//登录
	public function loginuser()
	{
		$this->request = Request::instance();
		$this->params = $this->request->post();
		$this->check_login($this->params);
	} 
	//分页查询
	public function getuser()
	{
		$this->request = Request::instance();
		$this->params = $this->request->param();
		$this->check_page($this->params);
	}
	
	public function finduser()
	{
		$this->request = Request::instance();
		$this->params = $this->request->param();
		$this->check_aid($this->params);
	}
	
	public function adduser()
	{
		$this->request = Request::instance();
		$this->params = $this->request->param();
//		
		
		$this->check_addList($this->params);
	}
	
	public function deluser()
	{
		$this->request = Request::instance();
		$this->params = $this->request->param();
		$this->check_delaid($this->params);
	}
	
	//修改
	public function upuser()
	{
		$this->request = Request::instance();
		$this->params = $this->request->param();
		$this->check_upuid($this->params);
	}
	
	//用户上传头像
	public function userphoto()
	{
		$this->request = Request::instance();
		$this->params = $this->request->param(true);
		$this->check_upphoto($this->params);
	}
//	未登录忘记密码
	public function wdlwjmm()
	{
		$this->request = Request::instance();
		$this->params = $this->request->param(true);
		$this->check_wanjmm($this->params);
	}
	//按姓名查找
	public function check_getname($name)
	{
		$rule = $this->rules[$this->request->controller()][$this->request->action()];
		$this->validate = new Validate($rule,
			[
				"typeName.require" => "user_name不能为空！"
			]
		);
		if(!$this->validate->check($name))
		{
			$this->check_msg(400,$this->validate->getError());
		}else
		{
			$house_obj = new userModel;
			$houseList = $house_obj->getuserNameModel($name);
			
			if($houseList)
			{
				$this->check_msg(200,"查询成功！",$houseList);
			}else
			{
				$this->check_msg(400,"查询失败");
			}
		}
	}
	//查询全部
	public function check_userover()
	{
		$house_obj = new userModel;
		$houseList = $house_obj->getuserSelect();
		if($houseList)
		{
			$this->check_msg(200,"请求成功！",$houseList);
		}else
		{
			$this->check_msg(400,"暂无数据");
		}	
	}
	//分页查询
	public function check_page($page)
	{
		//过滤参数
		$rule = $this->rules[$this->request->controller()][$this->request->action()];
		$this->validate = new Validate($rule,
			[
				"page.require" => "page不能为空！",
				"page.number" => "page只能是数字！"
			]
		);
		if(!$this->validate->check($page))
		{
			$this->check_msg(400,$this->validate->getError());
		}else
		{
			$house_obj = new userModel;
			$houseList = $house_obj->getuserLimit($page);
			if($houseList)
			{
				$this->check_msg(200,"请求成功！",$houseList);
			}else
			{
				$this->check_msg(400,"请求数据为空,请输入有效参数！");
			}
		}
		
	}
	//单条查询
	public function check_aid($uid)
	{
		$rule = $this->rules[$this->request->controller()][$this->request->action()];
		$this->validate = new Validate($rule,
			[
				"uid.require" => "uid不能为空！",
				"uid.number" => "uid只能是数字！"
			]
		);
		if(!$this->validate->check($uid))
		{
			$this->check_msg(400,$this->validate->getError());
		}else
		{
			$house_obj = new userModel;
			$houseList = $house_obj->getuserFind($uid);
//			dump($houseList);die;
			
			if($houseList)
			{
				$this->check_msg(200,"请求成功！",$houseList);
			}else
			{
				$this->check_msg(400,"请求数据为空,请输入有效参数！");
			}
		}
	}
	//添加
	public function check_addList($list)
	{
		$rule = $this->rules[$this->request->controller()][$this->request->action()];
		$this->validate = new Validate($rule,
			[
				"list['user_name'].require" => "用户名不能为空！",
				"list['user_name'].min" => "用户名最小长度为4！",
				"list['user_pwd'].require" => "密码不能为空！",
				"list['user_pwd'].min" => "密码最小长度为6！",
				"list['user_pwd']./^(?=[0-9a-zA-Z@_.]+$)/" => "密码不能有特殊字符！",
				"list['user_sex'].require" => "性别不能为空！",
				"list['user_tel'].require" => "联系电话不能为空！",
				"list['user_tel']./^1[3-8]{1}[0-9]{9}$/" => "联系电话格式不正确！",
				"list['usern_tel'].length" => "联系电话长度为11！",
				"list['user_data'].require" => "注册日期不能为空！",
				"list['user_data'].date" => "注册日期格式为2020-11-11或2020/11/11！",
			]
		);
		if(!$this->validate->check($list))
		{
			$this->check_msg(400,$this->validate->getError());
		}else{
			$getdata = model("user")->where("user_name",$list["user_name"])->select();
			if($getdata){
				$this->check_msg(400,"该用户已注册！");
			}else{
				//设置电话中间4位用*表示
				$list["user_tel"] = $this->keepsth($list["user_tel"],3,4);
				$userPwd = md5(md5($list['user_pwd']));
				$list['user_pwd'] = $userPwd;
//				$head_img_path = $this->upload_file($list["user_photo"],'head_img');
//				$list['user_photo'] = $head_img_path;
//				dump($list['user_pwd']);
//				dump($userPwd);
//				dump(md5(md5($list['user_pwd'])));
//				dump(md5($list['user_pwd']));
//				die;
				$house_obj = new userModel;
				$houseList = $house_obj->adduserModel($list);
				if($houseList)
				{
					$this->check_msg(200,"添加成功！",$houseList);
				}else
				{
					$this->check_msg(400,"添加失败，请重新操作！");
				}
			}
		}
		
	}
	
	//删除
	public function check_delaid($uid)
	{
		$rule = $this->rules[$this->request->controller()][$this->request->action()];
		$this->validate = new Validate($rule,
			[
				"uid.require" => "uid不能为空！",
				"uid.number" => "uid只能是数字！"
			]
		);
		if(!$this->validate->check($uid))
		{
			$this->check_msg(400,$this->validate->getError());
		}else{
			$house_obj = new userModel;
			$houseList = $house_obj->deluserModel($uid);
			if($houseList)
			{
				$this->check_msg(200,"删除成功！",$houseList);
			}else
			{
				$this->check_msg(400,"删除失败，请重新操作！");
			}
			
		}
	}
	
	//修改密码
	public function check_upuid($uid)
	{
		$rule = $this->rules[$this->request->controller()][$this->request->action()];
		$this->validate = new Validate($rule,
			[
				"uid.require" => "uid不能为空！",
				"uid.number" => "uid只能是数字！"
//				"uid['user_name'].require" => "用户名不能为空！",
//				"uid['user_name'].min" => "用户名最小长度为4！",
//				"uid['user_pwd'].require" => "密码不能为空！",
//				"uid['user_pwd'].min" => "密码最小长度为6！",
//				"uid['user_pwd']./^(?=[0-9a-zA-Z@_.]+$)/" => "密码不能有特殊字符！",
//				"uid['user_tel'].require" => "联系电话不能为空！",
//				"uid['user_tel']./^1[3-8]{1}[0-9]{9}$/" => "联系电话格式不正确！",
//				"uid['usern_tel'].length" => "联系电话长度为11！",
//				"uid['user_data'].require" => "注册日期不能为空！",
//				"uid['user_data'].date" => "注册日期格式为2020-11-11或2020/11/11或20201111！",
				
			]
		);
		if(!$this->validate->check($uid))
		{
			$this->check_msg(400,$this->validate->getError());
		}else{
			//密码不为空md5加密
			if(!empty($uid['user_pwd']))
			{
				$uid['user_pwd'] = md5(md5($uid['user_pwd']));
			}
			//手机号不为空
			if(!empty($uid['user_tel'])){
				$uid["user_tel"] = $this->keepsth($uid["user_tel"],3,4);
			}
			$house_obj = new userModel;
			$houseList = $house_obj->upuserModel($uid);
			if($houseList)
			{
				$this->check_msg(200,"修改成功！",$houseList);
			}else
			{
				$this->check_msg(400,"修改失败，请重新操作！");
			}
			
		}
	}
	//上传头像
	public function check_upphoto($uid)
	{
		$rule = $this->rules[$this->request->controller()][$this->request->action()];
		$this->validate = new Validate($rule,
			[
				"uid.require" => "uid不能为空！",
				"uid.number" => "uid只能是数字！"
//				"uid['user_photo'].image" => "上传文件是图片！",
//				"uid['user_photo'].require" => "上传文件不能为空！",
//				"uid['user_photo'].fileSize" => "上传文件大小不能超过20M!",
//				"uid['user_photo'].fileExt" => "上传文件格式是jpg,png,bnp,jpeg",
			]);
		if(!$this->validate->check($uid))
		{
			$this->check_msg(400,$this->validate->getError());
		}else{
			//上传文件，获取路径
			$head_img_path = $this->upload_file($uid["user_photo"],'head_img');
//			dump($head_img_path);die;
			$uid['user_photo'] = $head_img_path;
			//存入数据库库
			$house_obj = new userModel;
			$houseList = $house_obj->upphotoModel($uid);
			if($houseList)
			{
				$this->check_msg(200,"上传头像成功！",$head_img_path);
			}else
			{
				$this->check_msg(400,"上传头像失败，请重新操作！");
			}
		}
	}
	//登录
	public function check_login($data)
	{
		$rule = $this->rules[$this->request->controller()][$this->request->action()];
		$this->validate = new Validate($rule,
			[
				"list['user_name'].require" => "用户名不能为空！",
//				"list['user_name'].min" => "用户名最小长度为4！",
				"list['user_pwd'].require" => "密码不能为空！",
//				"list['user_pwd'].min" => "密码最小长度为6！",
//				"list['user_pwd']./^(?=[0-9a-zA-Z@_.]+$)/" => "密码不能有特殊字符！",
			]);
		if(!$this->validate->check($data))
		{
			$this->check_msg(400,$this->validate->getError());
		}else{
			$house_obj = new userModel;
			$houseList = $house_obj->loginuserModel($data);
			if($houseList)
			{
				$this->check_msg(200,"登录成功！",$houseList);
			}
			else{
				$this->check_msg(400,"用户名或密码错误！");
			}
		}
	}
	
//	未登录忘记密码,利用手机号登录
	public function check_wanjmm($data)
	{
		$rule = $this->rules[$this->request->controller()][$this->request->action()];
		$this->validate = new Validate($rule,
			[
				"user_tel.require" => "usern_tel不能为空！",
				"user_tel./^1[3-8]{1}[0-9]{9}$/" => "usern_tel格式不正确！",
				"usern_tel.length" => "usern_tel长度为11！",
				"user_pwd.require" => "user_pwd不能为空！",
				"user_pwd.min" => "user_pwd最小长度为6！",
				"user_pwd./^(?=[0-9a-zA-Z@_.]+$)/" => "user_pwd不能有特殊字符！",
				
			]);
		if(!$this->validate->check($data))
		{
			$this->check_msg(400,$this->validate->getError());
		}else{
			//密码不为空md5加密
			if(!empty($data['user_pwd']))
			{
				$data['user_pwd'] = md5(md5($data['user_pwd']));
			}

			if(!empty($data['user_tel'])){
				$data["user_tel"] = $this->keepsth($data["user_tel"],3,4);
			}
			$tel = model('user')->where('user_tel',$data["user_tel"])->find();
			if(empty($tel))
			{
				$this->check_msg(401,"改手机号还未注册，请注册");
			}else{
				$house_obj = new userModel;
				$houseList = $house_obj->upwdlwjmmModel($data);
				if($houseList)
				{
					$this->check_msg(200,"修改成功！",$houseList);
				}
				else{
					
					$this->check_msg(400,"修改失败，请重新操作！");
				}
			}
			
		}
	}
//	更换手机
	public function check_uptel($uid)
	{
		$rule = $this->rules[$this->request->controller()][$this->request->action()];
		$this->validate = new Validate($rule,
			[
				"uid.require" => "uid不能为空！",
				"uid.number" => "uid只能是数字！",
//				"uid['user_name'].require" => "用户名不能为空！",
//				"uid['user_name'].min" => "用户名最小长度为4！",
//				"uid['user_pwd'].require" => "密码不能为空！",
//				"uid['user_pwd'].min" => "密码最小长度为6！",
//				"uid['user_pwd']./^(?=[0-9a-zA-Z@_.]+$)/" => "密码不能有特殊字符！",
				"user_tel.require" => "联系电话不能为空！",
				"user_tel./^1[3-8]{1}[0-9]{9}$/" => "联系电话格式不正确！",
				"user_tel.length" => "联系电话长度为11！",
//				"uid['user_data'].require" => "注册日期不能为空！",
//				"uid['user_data'].date" => "注册日期格式为2020-11-11或2020/11/11或20201111！",
				
			]
		);
		if(!$this->validate->check($uid))
		{
			$this->check_msg(400,$this->validate->getError());
		}else{
			//手机号不为空
			if(!empty($uid['user_tel'])){
				$uid["user_tel"] = $this->keepsth($uid["user_tel"],3,4);
			}
			$house_obj = new userModel;
			$houseList = $house_obj->upuserModel($uid);
			if($houseList)
			{
				$this->check_msg(200,"修改成功！",$houseList);
			}else
			{
				$this->check_msg(400,"修改失败，请重新操作！");
			}
			
		}
	}
}
