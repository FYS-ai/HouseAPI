<?php
namespace app\api\model;

use think\Model;
use think\Request;

class City extends Model
{
	protected $pk = 'cityid';
	
	//分页查询
	public function getcityLimit($page)
	{
		$pagesize = 10;
		$limitList = ($page['page']-1)*$pagesize;
		return $this->limit($limitList,$pagesize)->select();
	}
	
	//单条语句查询
	public function getcityFind($cityid)
	{
		return $this->where('cityid',$cityid['cityid'])->find();
	}
	
	//添加
	public function addcityModel($list)
	{
		return $this->save($list);
	}
	
	//删除
	public function delcityModel($cityid)
	{
		return $this->destroy($cityid['cityid']);
	}
	
	//修改
	public function upcityModel($cityid)
	{
		return $this->save($cityid,['cityid'=>$cityid['cityid']]);
	}
}
