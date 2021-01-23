<?php
namespace app\api\controller;
use app\api\controller\Common;
use app\api\model\House as houseModel;

use think\Request;
use think\Validate;
class House extends Common
{
	//更具用户id和当前房源的hid查询房源
//	public function getuseruidhousehid()
//	{
//		$this->request = Request::instance();
//		$this->params = $this->request->param();
//		$this->check_uhidselect($this->params);
//	}
	//根据房源id查询
	public function gethousehid()
	{
		$this->request = Request::instance();
		$this->params = $this->request->param();
		$this->check_hidselect($this->params);
	}
	//根据用户id查询房源
	public function getuseridhouse()
	{
		$this->request = Request::instance();
		$this->params = $this->request->param();
		$this->check_userid($this->params);
	}
	//	查询所有数据
	public function gethouseover()
	{
		$this->request = Request::instance();
		$this->params = $this->request->param();
		$this->check_over($this->params);
	}
	//分页查询
	public function gethouse()
	{
		$this->request = Request::instance();
		$this->params = $this->request->param();
		$this->check_page($this->params);
	}
	
	//单条数据查询
	public function findhouse()
	{
		$this->request = Request::instance();
		$this->params = $this->request->param();
		$this->check_hid($this->params);
	}
	
	public function addhouse()
	{
		$this->request = Request::instance();
		$this->params = $this->request->param(true);//接收到文件上传的路径
		$this->check_addList($this->params);
	}
	
	public function delhouse()
	{
		$this->request = Request::instance();
		$this->params = $this->request->param();
		$this->check_delaid($this->params);
	}
	
	//修改
	public function uphouse()
	{
		$this->request = Request::instance();
		$this->params = $this->request->param();
		$this->check_upuid($this->params);
	}
	
	//上传房子图片
	public function housephoto()
	{
		$this->request = Request::instance();
		$this->params = $this->request->param(true);
//		dump($this->request->param(true));die;
		$this->check_upphoto($this->params);
	}
	
	//搜索
	public function searchhouse()
	{
		$this->request = Request::instance();
		$this->params = $this->request->param();
		$this->check_search($this->params);
	}
	//所有房子查询
	public function check_over()
	{
		$house_obj = new houseModel;
		$houseList = $house_obj->gethouseOver();
		if($houseList)
		{
			$this->check_msg(200,"请求成功！",$houseList);
		}else
		{
			$this->check_msg(400,"请求数据为空,请输入有效参数！");
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
			$house_obj = new houseModel;
			$houseList = $house_obj->gethouseLimit($page);
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
	public function check_hid($hid)
	{
		$rule = $this->rules[$this->request->controller()][$this->request->action()];
		$this->validate = new Validate($rule,
			[
				"hid.require" => "参数不能为空！",
				"hid.number" => "参数只能是数字！"
			]
		);
		if(!$this->validate->check($hid))
		{
			$this->check_msg(400,$this->validate->getError());
		}else
		{
			$house_obj = new houseModel;
			$houseList = $house_obj->gethouseFind($hid);
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
				"h_title.require" => "h_title不能为空！",
				"h_deploy.require" => "h_deploy最小长度为4！",
				"h_tag.require" => "h_tag不能为空！",
//				"h_images[].image" => "上传文件是图片！",
//				"h_images[].require" => "上传文件不能为空！",
//				"h_images[].fileSize" => "上传文件大小不能超过20M!",
//				"h_images[].fileExt" => "上传文件格式是jpg,png,bnp,jpeg",
				
				"h_room.require" => "h_room不能为空！",
				"h_basets.require" => "h_basets不能为空！",
				"uid.require" => "uid不能为空！",
				"uid.number" => "uid只能是数字！",
				
				"h_detail.require" => "h_detail不能为空！",
				"cityname.require" => "cityname不能为空！",
				"h_money.require" => "h_money不能为空！",
				"h_money.number" => "h_money只能是数字！",
				
//				"checkIn.require" => "checkIn不能为空！",
//				"checkIn.date" => "checkIn格式为2020-11-11或2020/11/11！",
//				"checkOut.require" => "checkOut不能为空！",
//				"checkOut.date" => "checkOut格式为2020-11-11或2020/11/11！",
//				
			]
		);
		if(!$this->validate->check($list))
		{
			$this->check_msg(400,$this->validate->getError());
		}else{
			$house_obj = new houseModel;
			$houseList = $house_obj->addhouseModel($list);
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
	public function check_delaid($hid)
	{
		$rule = $this->rules[$this->request->controller()][$this->request->action()];
		$this->validate = new Validate($rule,
			[
				"hid.require" => "hid不能为空！",
				"hid.number" => "hid只能是数字！"
			]
		);
		if(!$this->validate->check($hid))
		{
			$this->check_msg(400,$this->validate->getError());
		}else{
			$house_obj = new houseModel;
			$houseList = $house_obj->delhouseModel($hid);
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
	public function check_upuid($hid)
	{
		$rule = $this->rules[$this->request->controller()][$this->request->action()];
		$this->validate = new Validate($rule,
			[
				"h_title.require" => "h_title不能为空！",
				"h_deploy.require" => "h_deploy最小长度为4！",
				"h_tag.require" => "h_tag不能为空！",
//				"h_images[].image" => "上传文件是图片！",
//				"h_images[].require" => "上传文件不能为空！",
//				"h_images[].fileSize" => "上传文件大小不能超过20M!",
//				"h_images[].fileExt" => "上传文件格式是jpg,png,bnp,jpeg",
				
				"h_room.require" => "h_room不能为空！",
				"h_basets.require" => "h_basets不能为空！",
				"uid.require" => "uid不能为空！",
				"uid.number" => "uid只能是数字！",
				
				"h_detail.require" => "h_detail不能为空！",
				"cityname.require" => "cityname不能为空！",
				"h_money.require" => "h_money不能为空！",
				"h_money.number" => "h_money只能是数字！",
//				"hid['checkIn'].require" => "checkIn不能为空！",
//				"hid['checkIn'].date" => "checkIn格式为2020-11-11或2020/11/11！",
//				"hid['checkOut'].require" => "checkOut不能为空！",
//				"hid['checkOut'].date" => "checkOut格式为2020-11-11或2020/11/11！",
				
			]
		);
		if(!$this->validate->check($hid))
		{
			$this->check_msg(400,$this->validate->getError());
		}else{
			$house_obj = new houseModel;
			$houseList = $house_obj->uphouseModel($hid);
			if($houseList)
			{
				$this->check_msg(200,"修改成功！",$houseList);
			}else
			{
				$this->check_msg(400,"修改失败，请重新操作！");
			}
			
		}
	}
	//上传图片
	public function check_upphoto($hid)
	{
		$rule = $this->rules[$this->request->controller()][$this->request->action()];
		$this->validate = new Validate($rule,
			[
				"hid.require" => "hid不能为空！",
				"hid.number" => "hid只能是数字！"
//				"hid['h_images'].image" => "上传文件是图片！",
//				"h_images[].require" => "上传文件不能为空！",
//				"h_images[].fileSize" => "上传文件大小不能超过20M!",
//				"h_images[].fileExt" => "上传文件格式是jpg,png,bnp,jpeg",
			]);
		if(!$this->validate->check($hid))
		{
			$this->check_msg(400,$this->validate->getError());
		}else{
			$file=request()->file('h_images');
			
			//返回路径存入数组
			foreach($file as $values)
			{
				
				$head_img_path[] = $this->upload_file($values);
			}
			//数组变成字符串
			$hid["h_images"] = implode(",", $head_img_path);
			//存入数据库库
			$house_obj = new houseModel;
			$houseList = $house_obj->upphotoModel($hid);
			if($houseList)
			{
				$this->check_msg(200,"上传图片成功！",$head_img_path);
			}else
			{
				$this->check_msg(400,"上传图片失败，请重新操作！");
			}
		}
	}
	
	//搜索
	public function check_search($cityname)
	{
		$rule = $this->rules[$this->request->controller()][$this->request->action()];
		$this->validate = new Validate($rule,
			[
				"type.require" => "type不能为空！",
				"typeName.require" => "typeName不能为空！",
			]);
		if(!$this->validate->check($cityname))
		{
			$this->check_msg(400,$this->validate->getError());
		}else
		{
			$house_obj = new houseModel;
			$houseList = $house_obj->searchhouseModel($cityname);
			if($houseList)
			{
				$this->check_msg(200,"搜索成功！",$houseList);
			}else
			{
				$this->check_msg(400,"搜索失败，请重新操作！");
			}
		}	
	}
	//更具用户id查询房源
	public function check_userid($uid)
	{
		$rule = $this->rules[$this->request->controller()][$this->request->action()];
		$this->validate = new Validate($rule,
			[
				"uid.require" => "uid不能为空！",
				"uid.number" => "uid只能为数字！",
			]);
		if(!$this->validate->check($uid))
		{
			$this->check_msg(400,$this->validate->getError());
		}else
		{
			$house_obj = new houseModel;
			$houseList = $house_obj->getUserIDHouse($uid);
			if($houseList)
			{
				$this->check_msg(200,"查询成功！",$houseList);
			}else
			{
				$this->check_msg(400,"查询失败，请重新操作！");
			}
		}	
	}
	public function check_hidselect($hid)
	{
		$rule = $this->rules[$this->request->controller()][$this->request->action()];
		$this->validate = new Validate($rule,
			[
				"hid.require" => "hid不能为空！",
				"hid.number" => "hid只能是数字！"
			]
		);
		if(!$this->validate->check($hid))
		{
			$this->check_msg(400,$this->validate->getError());
		}else
		{
			$house_obj = new houseModel;
			$houseList = $house_obj->gethousehid($hid);
			if($houseList)
			{
				$this->check_msg(200,"请求成功！",$houseList);
			}else
			{
				$this->check_msg(400,"请求数据为空,请输入有效参数！");
			}
		}
	}
//	check_uhidselect
	//更具用户当前id查询
}