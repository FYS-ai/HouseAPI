<?php
namespace app\api\controller;
use app\api\model\Landlord as landlordModel;
use app\api\controller\Common;

use think\Request;
use think\Validate;

class Landlord extends Common
{
	//分页查询
	public function getlandlord()
	{
		$this->request = Request::instance();
		$this->params = $this->request->param();
		$this->check_page($this->params);
	}
	
	//单条查询
	public function findlandlord()
	{
		$this->request = Request::instance();
		$this->params = $this->request->param();
		$this->check_aid($this->params);
	}
	
	//添加
	public function addlandlord()
	{
		$this->request = Request::instance();
		$this->params = $this->request->param();
		$this->check_addList($this->params);
	}
	
	//删除
	public function dellandlord()
	{
		$this->request = Request::instance();
		$this->params = $this->request->param();
		$this->check_delldid($this->params);
	}
	
	//修改
	public function uplandlord()
	{
		$this->request = Request::instance();
		$this->params = $this->request->param();
		$this->check_upuid($this->params);
	}
	
	//图片上传
	public function ldphoto()
	{
		$this->request = Request::instance();
		$this->params = $this->request->param(true);
		$this->check_upphoto($this->params);
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
			$house_obj = new landlordModel;
			$houseList = $house_obj->getlandlordLimit($page);
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
	public function check_aid($ldid)
	{
		$rule = $this->rules[$this->request->controller()][$this->request->action()];
		$this->validate = new Validate($rule,
			[
				"ldid.require" => "ldid不能为空！",
				"ldid.number" => "ldid只能是数字！"
			]
		);
		if(!$this->validate->check($ldid))
		{
			$this->check_msg(400,$this->validate->getError());
		}else
		{
			$house_obj = new landlordModel;
			$houseList = $house_obj->getlandlordFind($ldid);
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
				"list['ld_name'].require" => "房东名称不能为空！",
				"list['ld_name'].min" => "房东名称最小长度为4！",
				"list['ld_sex'].require" => "性别不能为空！",
				"list['ld_tel'].require" => "联系电话不能为空！",
				"list['ld_tel']./^1[3-8]{1}[0-9]{9}$/" => "联系电话格式不正确！",
				"list['ld_tel'].length" => "联系电话长度为11！",
				"list['reg_time'].require" => "注册日期不能为空！",
				"list['reg_time'].date" => "注册日期格式为2020-11-11！",
			]
		);
		if(!$this->validate->check($list))
		{
			$this->check_msg(400,$this->validate->getError());
		}else{
			$house_obj = new landlordModel;
			$houseList = $house_obj->addlandlordModel($list);
			if($houseList)
			{
				$this->check_msg(200,"添加成功！",$houseList);
			}else
			{
				$this->check_msg(400,"添加失败，请重新操作！");
			}
			
		}
		
	}
	
	//删除
	public function check_delldid($ldid)
	{
		$rule = $this->rules[$this->request->controller()][$this->request->action()];
		$this->validate = new Validate($rule,
			[
				"ldid.require" => "ldid不能为空！",
				"ldid.number" => "ldid只能是数字！"
			]
		);
		if(!$this->validate->check($ldid))
		{
			$this->check_msg(400,$this->validate->getError());
		}else{
			$house_obj = new landlordModel;
			$houseList = $house_obj->dellandlordModel($ldid);
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
	public function check_upuid($ldid)
	{
		$rule = $this->rules[$this->request->controller()][$this->request->action()];
		$this->validate = new Validate($rule,
			[
				"ldid.require" => "ldid不能为空！",
				"ldid.number" => "ldid只能是数字！",
				"ldid['ld_name'].require" => "房东名称不能为空！",
				"ldid['ld_name'].min" => "房东名称最小长度为4！",
				"ldid['ld_sex'].require" => "性别不能为空！",
				"ldid['ld_tel'].require" => "联系电话不能为空！",
				"ldid['ld_tel']./^1[3-8]{1}[0-9]{9}$/" => "联系电话格式不正确！",
				"ldid['ld_tel'].length" => "联系电话长度为11！",
				"ldid['reg_time'].require" => "注册日期不能为空！",
				"ldid['reg_time'].date" => "注册日期格式为2020-11-11！"
			]
		);
		if(!$this->validate->check($ldid))
		{
			$this->check_msg(400,$this->validate->getError());
		}else{
			$house_obj = new landlordModel;
			$houseList = $house_obj->uplandlordModel($ldid);
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
	public function check_upphoto($ldid)
	{
		$rule = $this->rules[$this->request->controller()][$this->request->action()];
		$this->validate = new Validate($rule,
			[
				"ldid.require" => "ldid不能为空！",
				"ldid.number" => "ldid只能是数字！",
				"ldid['ld_photo'].image" => "上传文件是图片！",
				"ldid['ld_photo'].require" => "上传文件不能为空！",
				"ldid['ld_photo'].fileSize" => "上传文件大小不能超过20M!",
				"ldid['ld_photo'].fileExt" => "上传文件格式是jpg,png,bnp,jpeg",
				
			]);
		if(!$this->validate->check($ldid))
		{
			$this->check_msg(400,$this->validate->getError());
		}else{
			//上传文件，获取路径
			$head_img_path = $this->upload_file($ldid["ld_photo"],'head_img');
			$ldid['ld_photo'] = $head_img_path;
			//存入数据库库
			$house_obj = new landlordModel;
			$houseList = $house_obj->ldphotoModel($ldid);
			if($houseList)
			{
				$this->check_msg(200,"上传头像成功！",$head_img_path);
			}else
			{
				$this->check_msg(400,"上传头像失败，请重新操作！");
			}
		}
	}
}
