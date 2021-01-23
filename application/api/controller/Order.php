<?php
namespace app\api\controller;
use app\api\model\Order as orderModel;
use app\api\controller\Common;

use think\Request;
use think\Validate;

class Order extends Common
{
	//查询全部
	public function getorderover()
	{
		$this->request = Request::instance();
		$this->params = $this->request->param();
		$this->check_orderover($this->params);
	}
	//	按评价查询
	public function getiscomment()
	{
		$this->request = Request::instance();
		$this->params = $this->request->param();
		$this->check_ispingjai($this->params);
	}
	//是否确认入住和取消订单
	
	public function getisdel()
	{
		$this->request = Request::instance();
		$this->params = $this->request->param();
		$this->check_isdelaqx($this->params);
	}
	//	修改订单状态
	public function uporderzt()
	{
		$this->request = Request::instance();
		$this->params = $this->request->param();
		$this->check_orderzt($this->params);
	}
	//	修改订单的评论状态
	public function uporderpl()
	{
		$this->request = Request::instance();
		$this->params = $this->request->param();
		$this->check_orderpl($this->params);
	}
	
	//根据用户来查询个人订单
	public function userorder()
	{
		$this->request = Request::instance();
		$this->params = $this->request->param();
		$this->check_user($this->params);
	}
	//分页查询
	public function getorder()
	{
		$this->request = Request::instance();
		$this->params = $this->request->param();
		$this->check_page($this->params);
	}
	
	//单条查询
	public function findorder()
	{
		$this->request = Request::instance();
		$this->params = $this->request->param();
		$this->check_aid($this->params);
	}
	
	//添加
	public function addorder()
	{
		$this->request = Request::instance();
		$this->params = $this->request->param();
		$this->check_addList($this->params);
	}
	
	//取消
	public function delorder()
	{
		$this->request = Request::instance();
		$this->params = $this->request->param();
		$this->check_delldid($this->params);
	}
	
	//查询全部
	public function check_orderover()
	{
		$house_obj = new orderModel;
		$houseList = $house_obj->getorderSelect();
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
			$house_obj = new orderModel;
			$houseList = $house_obj->getorderLimit($page);
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
	public function check_aid($orid)
	{
		$rule = $this->rules[$this->request->controller()][$this->request->action()];
		$this->validate = new Validate($rule,
			[
				"orid.require" => "orid不能为空！",
				"orid.number" => "orid只能是数字！"
			]
		);
		if(!$this->validate->check($orid))
		{
			$this->check_msg(400,$this->validate->getError());
		}else
		{
			$house_obj = new orderModel;
			$houseList = $house_obj->getorderFind($orid);
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
				"user_name.require" => "user_name不能为空！",
				"h_images.require" => "h_images不能为空！",
				"into_time.require" => "into_time不能为空！",
				"into_time.date" => "into_time格式不正确！",
				"exit_time.require" => "exit_time不能为空！",
				"exit_time.date" => "exit_time格式不正确！",
				"uid.require" => "uid不能为空",
				"uid.number" => "uid只能是数字",
//				"county.require" => "county不能为空！",
				"IDcard.require" => "IDcard不能为空！",
				"IDcard.length" => "IDcard长度为18！",
				"myName.require" => "myName不能为空！",
				"or_tel.require" => "联系电话不能为空！",
				"or_tel./^1[3-8]{1}[0-9]{9}$/" => "联系电话格式不正确！",
				"or_tel.length" => "联系电话长度为11！",
				"time_day.require" => "time_day不能为空",
				"time_day.number" => "time_day只能是数字",
				"isdel.require" => "isdel不能为空",
				"isdel.number" => "isdel只能是数字",
				
			]
		);
		if(!$this->validate->check($list))
		{
			$this->check_msg(400,$this->validate->getError());
		}else{
			//设置电话中间4位用*表示
			$list["or_tel"] = $this->keepsth($list["or_tel"],3,4);
			//设置身份证中间8位用*表示
			$list["IDcard"] = $this->keepsth($list["IDcard"],6,4);
			
			$house_obj = new orderModel;
			$houseList = $house_obj->addorderModel($list);
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
	public function check_delldid($orid)
	{
		$rule = $this->rules[$this->request->controller()][$this->request->action()];
		$this->validate = new Validate($rule,
			[
				"orid.require" => "orid不能为空！",
				"orid.number" => "orid只能是数字！"
			]
		);
		if(!$this->validate->check($orid))
		{
			$this->check_msg(400,$this->validate->getError());
		}else{
			$house_obj = new orderModel;
			$houseList = $house_obj->delorderModel($orid);
			if($houseList)
			{
				$this->check_msg(200,"取消成功！",$houseList);
			}else
			{
				$this->check_msg(400,"取消失败，请重新操作！");
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
			$house_obj = new orderModel;
			$houseList = $house_obj->getuserorderModel($data);
			if($houseList)
			{
				$this->check_msg(200,"查询成功！",$houseList);
			}else
			{
				$this->check_msg(400,"查询失败，请重新操作！");
			}
			
		}
	}
	public function check_orderzt($data)
	{
		$rule = $this->rules[$this->request->controller()][$this->request->action()];
		$this->validate = new Validate($rule,
			[
				"orid.require" => "orid不能为空！",
				"orid.number" => "orid只能是数字！",
				"isdel.require" => "isdel不能为空！",
				"isdel.number" => "isdel只能是数字！"
				
			]
		);	
		if(!$this->validate->check($data))
		{
			$this->check_msg(400,$this->validate->getError());
		}else{
			$house_obj = new orderModel;
			$houseList = $house_obj->uporderZTModel($data);
			if($houseList)
			{
				$this->check_msg(200,"修改成功！",$houseList);
			}else
			{
				$this->check_msg(400,"修改失败，请重新操作！");
			}
			
		}
	}
	public function check_orderpl($data)
	{
		$rule = $this->rules[$this->request->controller()][$this->request->action()];
		$this->validate = new Validate($rule,
			[
				"orid.require" => "orid不能为空！",
				"orid.number" => "orid只能是数字！",
				"isisComment.require" => "isisComment不能为空！",
				"isisComment.number" => "isisComment只能是数字！"
				
			]
		);	
		if(!$this->validate->check($data))
		{
			$this->check_msg(400,$this->validate->getError());
		}else{
			$house_obj = new orderModel;
			$houseList = $house_obj->uporderPLModel($data);
			if($houseList)
			{
				$this->check_msg(200,"修改成功！",$houseList);
			}else
			{
				$this->check_msg(400,"修改失败，请重新操作！");
			}
			
		}
	}
	public function check_ispingjai($data)
	{
		$rule = $this->rules[$this->request->controller()][$this->request->action()];
		$this->validate = new Validate($rule,
			[
				"isComment.require"=>"isComment不能为空",
				"isComment.number"=>"isComment只能是数字",
				"user_name" =>"user_name不能为空",
				"isdel" =>"isdel不能为空"
			]
		);	
		if(!$this->validate->check($data))
		{
			$this->check_msg(400,$this->validate->getError());
		}else{
			$house_obj = new orderModel;
			$houseList = $house_obj->isCommentModel($data);
			if($houseList)
			{
				$this->check_msg(200,"查询成功！",$houseList);
			}else
			{
				$this->check_msg(400,"查询失败，请重新操作");
			}
			
		}
	}
	public function check_isdelaqx($data)
	{
		$rule = $this->rules[$this->request->controller()][$this->request->action()];
		$this->validate = new Validate($rule,
			[
//				"isComment.require"=>"isComment不能为空",
//				"isComment.number"=>"isComment只能是数字",
				"user_name" =>"user_name不能为空",
				"isdel" =>"isdel不能为空"
			]
		);	
		if(!$this->validate->check($data))
		{
			$this->check_msg(400,$this->validate->getError());
		}else{
			$house_obj = new orderModel;
			$houseList = $house_obj->isDelModel($data);
			if($houseList)
			{
				$this->check_msg(200,"查询成功！",$houseList);
			}else
			{
				$this->check_msg(400,"查询失败，请重新操作");
			}
			
		}
	}
} 