<?php
namespace app\api\controller;
use app\api\model\Admin as adminModel;
use app\api\controller\Common;

use think\Request;
use think\Validate;

class Admin extends Common
{
	//按用户名查找
	public function getadminname(){
		$this->request = Request::instance();
		$this->params = $this->request->param();
		$this->check_getname($this->params);
	}
	//查询全部
	public function adminover()
	{
		$this->request = Request::instance();
		$this->params = $this->request->param();
		$this->check_getover($this->params);
	} 
	//登录
	public function loginadmin()
	{
		$this->request = Request::instance();
		$this->params = $this->request->param();
		$this->check_login($this->params);
	} 
	
	//分页查询
	public function getadmin()
	{
		$this->request = Request::instance();
		$this->params = $this->request->param();
		$this->check_page($this->params);
	}
	
	//单条查询
	public function findadmin()
	{
		$this->request = Request::instance();
		$this->params = $this->request->param();
		$this->check_aid($this->params);
	}
	
	//添加
	public function addadmin()
	{
		$this->request = Request::instance();
		$this->params = $this->request->param();
		$this->check_addList($this->params);
	}
	
	//删除
	public function deladmin()
	{
		$this->request = Request::instance();
		$this->params = $this->request->param();
		$this->check_delaid($this->params);
	}
	
	//修改
	public function upadmin()
	{
		$this->request = Request::instance();
		$this->params = $this->request->param();
		$this->check_upuid($this->params);
	}
	
	//管理员上传头像
	public function adminphoto()
	{
		$this->request = Request::instance();
		$this->params = $this->request->param(true);
		$this->check_upphoto($this->params);
	}
	//查询全部
	public function check_getover(){
		$house_obj = new adminModel;
		$houseList = $house_obj->getadminOver();
		if($houseList)
		{
			$this->check_msg(200,"请求成功！",$houseList);
		}else
		{
			$this->check_msg(400,"暂无数据");
		}
	}
	//按姓名查找
	public function check_getname($name)
	{
		$rule = $this->rules[$this->request->controller()][$this->request->action()];
		$this->validate = new Validate($rule,
			[
				"admin_name.require" => "admin_name不能为空！"
			]
		);
		if(!$this->validate->check($name))
		{
			$this->check_msg(400,$this->validate->getError());
		}else
		{
			$house_obj = new adminModel;
			$houseList = $house_obj->getadminnameModel($name);
			
			if($houseList)
			{
				$this->check_msg(200,"查询成功！",$houseList);
			}else
			{
				$this->check_msg(400,"查询失败");
			}
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
			$house_obj = new adminModel;
			$houseList = $house_obj->getadminLimit($page);
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
	public function check_aid($aid)
	{
		$rule = $this->rules[$this->request->controller()][$this->request->action()];
		$this->validate = new Validate($rule,
			[
				"aid.require" => "aid不能为空！",
				"aid.number" => "aid只能是数字！"
			]
		);
		if(!$this->validate->check($aid))
		{
			$this->check_msg(400,$this->validate->getError());
		}else
		{
			$house_obj = new adminModel;
			$houseList = $house_obj->getadminFind($aid);
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
				"list['admin_name'].require" => "用户名不能为空！",
				"list['admin_name'].min" => "用户名最小长度为4！",
				"list['admin_pwd'].require" => "密码不能为空！",
				"list['admin_pwd'].min" => "密码最小长度为6！",
				"list['admin_pwd']./^(?=[0-9a-zA-Z@_.]+$)/" => "密码不能有特殊字符！",
				"list['admin_sex'].require" => "性别不能为空！",
				"list['admin_tel'].require" => "联系电话不能为空！",
				"list['admin_tel']./^1[3-8]{1}[0-9]{9}$/" => "联系电话格式不正确！",
				"list['admin_tel'].length" => "联系电话长度为11！",
				"list['admin_address'].require" => "住址不能为空！",
				"list['admin_data'].require" => "注册日期不能为空！",
				"list['admin_data'].date" => "注册日期格式为2020-11-11！",
				
				
			]
		);
		if(!$this->validate->check($list))
		{
			$this->check_msg(400,$this->validate->getError());
		}else{
			$house_obj = new adminModel;
			$getuser = model('admin')->where('admin_name',$list['admin_name'])->select();
			if($getuser){
				$this->check_msg(400,"该管理员已注册！");
			}else{
				//设置电话中间4位用*表示
				$list["admin_tel"] = $this->keepsth($list["admin_tel"],3,4);
				$list['admin_pwd'] = md5(md5($list['admin_pwd']));
				$houseList = $house_obj->addadminModel($list);
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
	public function check_delaid($aid)
	{
		$rule = $this->rules[$this->request->controller()][$this->request->action()];
		$this->validate = new Validate($rule,
			[
				"aid.require" => "aid不能为空！",
				"aid.number" => "aid只能是数字！"
			]
		);
		if(!$this->validate->check($aid))
		{
			$this->check_msg(400,$this->validate->getError());
		}else{
			$house_obj = new adminModel;
			$houseList = $house_obj->deladminModel($aid);
			if($houseList)
			{
				$this->check_msg(200,"删除成功！",$houseList);
			}else
			{
				$this->check_msg(400,"删除失败，请重新操作！");
			}
			
		}
	}
	
	//修改
	public function check_upuid($aid)
	{
		$rule = $this->rules[$this->request->controller()][$this->request->action()];
		$this->validate = new Validate($rule,
			[
				"aid['admin_name'].require" => "用户名不能为空！",
				"aid['admin_name'].min" => "用户名最小长度为4！",
//				"aid['admin_pwd'].require" => "密码不能为空！",
//				"aid['admin_pwd'].min" => "密码最小长度为6！",
//				"aid['admin_pwd']./^(?=[0-9a-zA-Z@_.]+$)/" => "密码不能有特殊字符！",
				"aid['admin_sex'].require" => "性别不能为空！",
				"aid['admin_tel'].require" => "联系电话不能为空！",
				"aid['admin_tel']./^1[3-8]{1}[0-9]{9}$/" => "联系电话格式不正确！",
				"aid['admin_tel'].length" => "联系电话长度为11！",
				"aid['admin_address'].require" => "住址不能为空！",
				"aid['admin_data'].require" => "注册日期不能为空！",
				"aid['admin_data'].date" => "注册日期格式为2020-11-11！",
				"aid['admin_address'].require" => "地址不能为空！"
				
			]
		);
		if(!$this->validate->check($aid))
		{
			$this->check_msg(400,$this->validate->getError());
		}else{
			//密码不为空
			if(!empty($aid['admin_pwd']))
			{
				$aid['admin_pwd'] = md5(md5($aid['admin_pwd']));
			}
			$house_obj = new adminModel;
			$houseList = $house_obj->upadminModel($aid);
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
				"aid.require" => "aid不能为空！",
				"aid.number" => "aid只能是数字！",
				"aid['admin_photo'].image" => "上传文件是图片！",
				"aid['admin_photo'].require" => "上传文件不能为空！",
				"aid['admin_photo'].fileSize" => "上传文件大小不能超过20M!",
				"aid['admin_photo'].fileExt" => "上传文件格式是jpg,png,bnp,jpeg",
				
			]);
		if(!$this->validate->check($uid))
		{
			$this->check_msg(400,$this->validate->getError());
		}else{
			//上传文件，获取路径
			$head_img_path = $this->upload_file($uid["admin_photo"],'head_img');
//			dump($head_img_path);die;
			$uid['admin_photo'] = $head_img_path;
			//存入数据库库
			$house_obj = new adminModel;
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
				"list['admin_name'].require" => "用户名不能为空！",
				"list['admin_name'].min" => "用户名最小长度为4！",
				"list['admin_pwd'].require" => "密码不能为空！",
				"list['admin_pwd'].min" => "密码最小长度为6！",
				"list['admin_pwd']./^(?=[0-9a-zA-Z@_.]+$)/" => "密码不能有特殊字符！",
			]);
		if(!$this->validate->check($data))
		{
			$this->check_msg(400,$this->validate->getError());
		}else{
			$house_obj = new adminModel;
			$houseList = $house_obj->loginadminModel($data);
//			dump($houseList);die;
			if($houseList)
			{
				if($houseList!="改名称已被注册，请修改")
				{
					$this->check_msg(200,"登录成功！",$houseList);
				}else
				{
					$this->check_msg(400,"登录失败！",$houseList);
				}
				
			}
			else{
				$this->check_msg(400,"用户名或密码错误！");
			}
		}
	}
} 