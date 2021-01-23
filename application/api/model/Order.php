<?php
namespace app\api\model;

use think\Model;
use think\Request;

class Order extends Model
{
	protected $pk = 'orid';
	//查询全部
	public function getorderSelect()
	{
		return $this->select();
	}
	//分页查询
	public function getorderLimit($page)
	{
		$pagesize = 10;
		$limitList = ($page['page']-1)*$pagesize;
		return $this->where("isdel",0)->limit($limitList,$pagesize)->select();
	}
	
	//单条语句查询
	public function getorderFind($orid)
	{
		return $this->where('orid',$orid['orid'])->
		where('user_name',$orid['user_name'])->find();
	}
	
	//添加
	public function addorderModel($list)
	{
		return $this->save($list);
	}
	
	//删除
	public function delorderModel($orid)
	{
		//逻辑删除，可以恢复
		return $this->destroy($orid['orid']);
	}
	
	//根据用户查询个人订单
	public function getuserorderModel($userid)
	{
		return $this->where("uid",$userid['uid'])->select();
	}
	//修改订单状态
	public function uporderZTModel($orid)
	{
		return $this->save($orid,["orid"=>$orid["orid"]]);
	}
	//修改订单的评论状态
	public function uporderPLModel($orid)
	{
		return $this->save($orid,["orid"=>$orid["orid"]]);
	}
	//	是否评价
	public function isCommentModel($data)
	{
		return $this->where("user_name",$data['user_name'])->
		where("isdel",$data['isdel'])->
		where("isComment",$data['isComment'])->select();
	}
	//	待确认入住和取消订单
	public function isDelModel($data)
	{
		return $this->where("user_name",$data['user_name'])->
		where("isdel",$data['isdel'])->select();
	}
	
}

