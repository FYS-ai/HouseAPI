<?php
namespace app\api\model;

use think\Model;
use think\Request;

class Comment extends Model
{
	protected $pk = 'comid';
	//查询全部
	public function getcommentSelect()
	{
		return $this->select();
	}
	//根据用户id查询
	public function getuidcomment($uid)
	{
		return $this->where('uid',$uid['uid'])->select();
	}
	//用户更换头像，评论头像同步
	public function upcommentPhoto($uid)
	{
		return $this->save($uid,['uid'=>$uid['uid']]);
	}
	//分页查询
	public function getcommentLimit($page)
	{
		$pagesize = 10;
		$limitList = ($page['page']-1)*$pagesize;
		return $this->limit($limitList,$pagesize)->select();
	}
	//根据房子id分页查询
	public function hidcommentLimit($hid)
	{
		$pagesize = 10;
		$limitList = ($hid['page']-1)*$pagesize;
		return $this->where('hid',$hid['hid'])->limit($limitList,$pagesize)->select();
	}
	
	//根据订单id查询
	public function oridcommentLimit($hid)
	{
		return $this->where('orid',$hid['orid'])->find();
	}
	
	//单条语句查询
	public function getcommentFind($comid)
	{
		return $this->where('comid',$comid['comid'])->find();
	}
	
	//添加
	public function addcommentModel($list)
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
	
//	上传图片
	public function commentphotoModel($colid)
	{
		return $this->save($colid,['comid'=>$colid['comid']]);
	}

}

