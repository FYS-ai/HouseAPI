<?php
namespace app\api\controller;
use app\api\controller\Common;
use app\api\model\Collect as collectModel;

use think\Request;
use think\Validate;
class Collect extends Common
{
	//查询全部
	public function getcollectover()
	{
		$this->request = Request::instance();
		$this->params = $this->request->param();
		$this->check_collectover($this->params);
	}
	//根据用户名显示个人收藏
	public function usercollect()
	{
		$this->request = Request::instance();
		$this->params = $this->request->param();
		$this->check_user($this->params);
	}
	//分页查询
	public function getcollect()
	{
		$this->request = Request::instance();
		$this->params = $this->request->param();
		$this->check_page($this->params);
	}
	
	//单条查询
	public function findcollect()
	{
		$this->request = Request::instance();
		$this->params = $this->request->param();
		$this->check_aid($this->params);
	}
	
	//添加
	public function addcollect()
	{
		$this->request = Request::instance();
		$this->params = $this->request->param();
		$this->check_addList($this->params);
	}
	
	//删除
	public function delcollect()
	{
		$this->request = Request::instance();
		$this->params = $this->request->param();
		$this->check_delaid($this->params);
	}
	
	//查询全部
	public function check_collectover()
	{
		$house_obj = new collectModel;
		$houseList = $house_obj->getcollectSelect();
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
			$house_obj = new collectModel;
			$houseList = $house_obj->getcollectLimit($page);
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
	public function check_aid($colid)
	{
		$rule = $this->rules[$this->request->controller()][$this->request->action()];
		$this->validate = new Validate($rule,
			[
				"colid.require" => "colid不能为空！",
				"colid.number" => "colid只能是数字！"
			]
		);
		if(!$this->validate->check($colid))
		{
			$this->check_msg(400,$this->validate->getError());
		}else
		{
			$house_obj = new collectModel;
			$houseList = $house_obj->getcollectFind($colid);
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
				"hid.require" => "hid不能为空！",
				"hid.number" => "hid只能是数字！",
				"uid.require" => "uid不能为空！",
				"uid.number" => "uid只能是数字！",
				"h_images.require" => "h_images不能为空！",
				"h_title.require" => "h_title不能为空！",
				"cityname.require" => "cityname不能为空！",
				"h_deploy.require" => "h_deploy不能为空！",
				
				
			]
		);
		if(!$this->validate->check($list))
		{
			$this->check_msg(400,$this->validate->getError());
		}else{
			$house_obj = new collectModel;
			$houseList = $house_obj->addcollectModel($list);
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
	public function check_delaid($colid)
	{
		$rule = $this->rules[$this->request->controller()][$this->request->action()];
		$this->validate = new Validate($rule,
			[
				"colid.require" => "colid不能为空！",
				"colid.number" => "colid只能是数字！"
			]
		);
		if(!$this->validate->check($colid))
		{
			$this->check_msg(400,$this->validate->getError());
		}else{
			$house_obj = new collectModel;
			$houseList = $house_obj->delcollectModel($colid);
			if($houseList)
			{
				$this->check_msg(200,"删除成功！",$houseList);
			}else
			{
				$this->check_msg(400,"删除失败，请重新操作！");
			}
			
		}
	}
	public function check_user($data)
	{
		$rule = $this->rules[$this->request->controller()][$this->request->action()];
		$this->validate = new Validate($rule,
			[
				"uid.require" => "uid不能为空！",
				"uid.number" => "uid只能是数字！"
			]
		);	
		if(!$this->validate->check($data))
		{
			$this->check_msg(400,$this->validate->getError());
		}else{
			$house_obj = new collectModel;
			$houseList = $house_obj->getusercollectModel($data);
			if($houseList)
			{
				$this->check_msg(200,"查询成功！",$houseList);
			}else
			{
				$this->check_msg(400,"查询失败，请重新操作！");
			}
			
		}
	}
	
}
