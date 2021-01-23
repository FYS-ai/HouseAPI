<?php
namespace app\api\controller;
use app\api\model\City as cityModel;
use app\api\controller\Common;

use think\Request;
use think\Validate;

class City extends Common
{
	//分页查询
	public function getcity()
	{
		$this->request = Request::instance();
		$this->params = $this->request->param();
		$this->check_page($this->params);
	}
	
	//单条查询
	public function findcity()
	{
		$this->request = Request::instance();
		$this->params = $this->request->param();
		$this->check_aid($this->params);
	}
	
	//添加
	public function addcity()
	{
		$this->request = Request::instance();
		$this->params = $this->request->param();
		$this->check_addList($this->params);
	}
	
	//删除
	public function delcity()
	{
		$this->request = Request::instance();
		$this->params = $this->request->param();
		$this->check_delaid($this->params);
	}
	
	//修改
	public function upcity()
	{
		$this->request = Request::instance();
		$this->params = $this->request->param();
		$this->check_upuid($this->params);
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
			$house_obj = new cityModel;
			$houseList = $house_obj->getcityLimit($page);
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
	public function check_aid($cityid)
	{
		$rule = $this->rules[$this->request->controller()][$this->request->action()];
		$this->validate = new Validate($rule,
			[
				"cityid.require" => "cityid不能为空！",
				"cityid.number" => "cityid只能是数字！"
			]
		);
		if(!$this->validate->check($cityid))
		{
			$this->check_msg(400,$this->validate->getError());
		}else
		{
			$house_obj = new cityModel;
			$houseList = $house_obj->getcityFind($cityid);
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
				"list['cityname'].require" => "城市名称不能为空！"
			]
		);
		if(!$this->validate->check($list))
		{
			$this->check_msg(400,$this->validate->getError());
		}else{
			$house_obj = new cityModel;
			$houseList = $house_obj->addcityModel($list);
//			dump($houseList);die;
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
	public function check_delaid($cityid)
	{
		$rule = $this->rules[$this->request->controller()][$this->request->action()];
		$this->validate = new Validate($rule,
			[
				"cityid.require" => "cityid不能为空！",
				"cityid.number" => "cityid只能是数字！"
			]
		);
		if(!$this->validate->check($cityid))
		{
			$this->check_msg(400,$this->validate->getError());
		}else{
			$house_obj = new cityModel;
			$houseList = $house_obj->delcityModel($cityid);
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
	public function check_upuid($cityid)
	{
		$rule = $this->rules[$this->request->controller()][$this->request->action()];
		$this->validate = new Validate($rule,
			[
				"cityid.require" => "cityid不能为空！",
				"cityid.number" => "cityid只能是数字！",
				"cityid['cityname'].require" => "城市名称不能为空！"
			]
		);
		if(!$this->validate->check($cityid))
		{
			$this->check_msg(400,$this->validate->getError());
		}else{
			$house_obj = new cityModel;
			$houseList = $house_obj->upcityModel($cityid);
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
