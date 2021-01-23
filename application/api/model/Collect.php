<?php
namespace app\api\model;

use think\Model;
use think\Request;

class Collect extends Model
{
	protected $pk = 'colid';
	//查询全部
	public function getcollectSelect()
	{
		return $this->select();
	}
	//分页查询
	public function getcollectLimit($page)
	{
		$pagesize = 10;
		$limitList = ($page['page']-1)*$pagesize;
		return $this->limit($limitList,$pagesize)->select();
	}
	
	//单条语句查询
	public function getcollectFind($colid)
	{
		return $this->where('colid',$colid['colid'])->find();
	}
	
	//添加
	public function addcollectModel($list)
	{
		return $this->save($list);
	}
	
	//删除
	public function delcollectModel($colid)
	{
		return $this->destroy($colid['colid']);
	}
	
	//修改
	public function upcollectModel($colid)
	{
		return $this->save($colid,['colid'=>$colid['colid']]);
	}
	
	//根据用户名查询个人收藏
	public function getusercollectModel($userid)
	{
		return $this->where('uid',$userid['uid'])->select();
	}
}

