<?php
namespace app\api\controller;
use app\api\model\Comment as commentModel;
use app\api\controller\Common;

use think\Request;
use think\Validate;

class Comment extends Common
{
	//查询全部
	public function getcommentover()
	{
		$this->request = Request::instance();
		$this->params = $this->request->post();
		$this->check_commentover($this->params);
	}
	//修改头像
	public function getcommentuid()
	{
		$this->request = Request::instance();
		$this->params = $this->request->param();
		$this->check_uidcom($this->params);
	}
	//修改头像
	public function upcommentphoto()
	{
		$this->request = Request::instance();
		$this->params = $this->request->param();
		$this->check_upcomphoto($this->params);
	}
	//分页查询
	public function getcomment()
	{
		$this->request = Request::instance();
		$this->params = $this->request->param();
		$this->check_page($this->params);
	}
	
	//单条查询
	public function findcomment()
	{
		$this->request = Request::instance();
		$this->params = $this->request->param();
		$this->check_aid($this->params);
	}
	
	//根据房子id查询评论
	public function hidcomment()
	{
		$this->request = Request::instance();
		$this->params = $this->request->param();
		$this->check_hid($this->params);
	}
	//订单id查询
	public function findcommentorid()
	{
		$this->request = Request::instance();
		$this->params = $this->request->param();
		$this->check_orid($this->params);
	}
	
	//添加
	public function addcomment()
	{
		$this->request = Request::instance();
		$this->params = $this->request->param();
		$this->check_addList($this->params);
	}
	
	//上传评论图片
	public function commentphoto()
	{
		$this->request = Request::instance();
		$this->params = $this->request->param(true);
		$this->check_upphoto($this->params);
	}
	//查询全部
	public function check_commentover()
	{
		$house_obj = new commentModel;
		$houseList = $house_obj->getcommentSelect();
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
			$house_obj = new commentModel;
			$houseList = $house_obj->getcommentLimit($page);
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
	public function check_aid($comid)
	{
		$rule = $this->rules[$this->request->controller()][$this->request->action()];
		$this->validate = new Validate($rule,
			[
				"comid.require" => "comid不能为空！",
				"comid.number" => "comid只能是数字！"
			]
		);
		if(!$this->validate->check($comid))
		{
			$this->check_msg(400,$this->validate->getError());
		}else
		{
			$house_obj = new commentModel;
			$houseList = $house_obj->getcommentFind($comid);
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
				"com_detail.require" => "com_detail不能为空！",
				"com_detail.min" => "com_detail不能小于5！",
				"com_date.require" => "com_date不能为空！",
				"com_date.date" => "com_date格式不正确！",
				"user_name.require" => "user_name不能为空！",
//				"user_photo.require" => "user_photo不能为空！",
				
			]
		);
		if(!$this->validate->check($list))
		{
			$this->check_msg(400,$this->validate->getError());
		}else{
			$house_obj = new commentModel;
			$houseList = $house_obj->addcommentModel($list);
			if($houseList)
			{
				$this->check_msg(200,"添加成功！",$houseList);
			}else
			{
				$this->check_msg(400,"添加失败，请重新操作！");
			}
			
		}
		
	}
	
	//根据房子id查询
	public function check_hid($hid){
		$rule = $this->rules[$this->request->controller()][$this->request->action()];
		$this->validate = new Validate($rule,
			[
				"hid.require" => "hid不能为空！",
				"hid.number" => "hid只能是数字！",
				"page.require" => "page不能为空！",
				"page.number" => "page只能是数字！",
			]
		);
		if(!$this->validate->check($hid))
		{
			$this->check_msg(400,$this->validate->getError());
		}else{
			$house_obj = new commentModel;
			$houseList = $house_obj->hidcommentLimit($hid);
			if($houseList)
			{
				$this->check_msg(200,"查询成功！",$houseList);
			}else
			{
				$this->check_msg(400,"暂无评论！",$houseList);
			}
			
		}
	}
	
	//上传评论图片
	public function check_upphoto($hid)
	{
		$rule = $this->rules[$this->request->controller()][$this->request->action()];
		$this->validate = new Validate($rule,
			[
				"comid.require" => "comid不能为空！",
				"comid.number" => "comid只能是数字！"
//				"h_images.image" => "上传文件是图片！",
////			"h_images.require" => "h_images上传文件不能为空！",
//				"h_images[].fileSize" => "上传文件大小不能超过20M!",
//				"h_images[].fileExt" => "上传文件格式是jpg,png,bnp,jpeg",
			]);
		if(!$this->validate->check($hid))
		{
			$this->check_msg(400,$this->validate->getError());
		}else{
			$file=request()->file('comment_photo');
//			dump($file);die;
			//返回路径存入数组
			foreach($file as $values)
			{
				
				$head_img_path[] = $this->upload_file($values,'head_img');
				
			}
			//数组变成字符串
			$hid["comment_photo"] = implode(",", $head_img_path);
			//存入数据库库
			$house_obj = new commentModel;
			$houseList = $house_obj->commentphotoModel($hid);
			if($houseList)
			{
				$this->check_msg(200,"上传图片成功！",$head_img_path);
			}else
			{
				$this->check_msg(400,"上传图片失败，请重新操作！");
			}
		}
	}
	//根据订单id查询
	public function check_orid($orid){
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
			$house_obj = new commentModel;
			$houseList = $house_obj->oridcommentLimit($orid);
			if($houseList)
			{
				$this->check_msg(200,"查询成功！",$houseList);
			}else
			{
				$this->check_msg(400,"查询失败！",$houseList);
			}
			
		}
	}
	//用户头像，评论头像修改
	public function check_upcomphoto($orid)
	{
		$rule = $this->rules[$this->request->controller()][$this->request->action()];
		$this->validate = new Validate($rule,
			[
				"uid.require" => "uid不能为空！",
				"uid.number" => "uid只能是数字！",
				"user_photo.require" =>"user_photo不能为空"
			]
		);
		if(!$this->validate->check($orid))
		{
			$this->check_msg(400,$this->validate->getError());
		}else{
			$house_obj = new commentModel;
			$houseList = $house_obj->upcommentPhoto($orid);
			if($houseList)
			{
				$this->check_msg(200,"修改头像同步成功！",$houseList);
			}else
			{
				$this->check_msg(400,"修改头像同步失败！",$houseList);
			}
			
		}
	}
	//更具用户id查询
	public function check_uidcom($uid)
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
			$house_obj = new commentModel;
			$houseList = $house_obj->getuidcomment($uid);
			if($houseList)
			{
				$this->check_msg(200,"查询成功！",$houseList);
			}else
			{
				$this->check_msg(400,"查询失败！",$houseList);
			}
			
		}
	}
	
} 