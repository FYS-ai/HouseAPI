<?php
namespace app\api\model;

use think\Model;
use think\Request;

class Landlord extends Model
{
	protected $pk = 'ldid';
	
	//分页查询
	public function getlandlordLimit($page)
	{
		$pagesize = 10;
		$limitList = ($page['page']-1)*$pagesize;
		return $this->limit($limitList,$pagesize)->select();
	}
	
	//单条语句查询
	public function getlandlordFind($ldid)
	{
		return $this->where('ldid',$ldid['ldid'])->find();
	}
	
	//添加
	public function addlandlordModel($list)
	{
		return $this->save($list);
	}
	
	//删除
	public function dellandlordModel($ldid)
	{
		return $this->destroy($ldid['ldid']);
	}
	
	//修改
	public function uplandlordModel($ldid)
	{
		return $this->save($ldid,['ldid'=>$ldid['ldid']]);
	}
	//上传头像
	public function ldphotoModel($ldid)
	{
		return $this->save($ldid,['ldid'=>$ldid['ldid']]);
	}
}
