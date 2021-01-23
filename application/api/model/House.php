<?php
namespace app\api\model;
use think\Model;
use app\api\model\User as userSearchModel;

class House extends Model
{
	protected $pk = "hid";
//	按照房源id查询
	public function gethousehid($hid)
	{
		return $this->where('hid',$hid['hid'])->select();
	}
	//用户id查询房源
	public function getUserIDHouse($uid)
	{
		return $this->where('uid',$uid['uid'])->select();
	}
	//查询全部
	public function gethouseOver()
	{
		return $this->select();
	}
	//分页查询
	public function gethouseLimit($page)
	{
		$pagesize = 9;
		$limitList = ($page['page']-1)*$pagesize;
		return $this->limit($limitList,$pagesize)->select();
	}
	
	//单条语句查询
	public function gethouseFind($hid)
	{
		return $this->where('hid',$hid['hid'])->find();
	}
	//添加
	public function addhouseModel($list)
	{
		return $this->save($list);
	}
	
	//删除
	public function delhouseModel($hid)
	{
		return $this->destroy($hid['hid']);
	}
	
	//修改
	public function uphouseModel($hid)
	{
		return $this->save($hid,['hid'=>$hid['hid']]);
	}
	//上传图片
	public function upphotoModel($hid)
	{
		return $this->save($hid,['hid'=>$hid['hid']]);
	}
	//搜索
	public function searchhouseModel($cityname)
	{
		
		//搜索用户
		if($cityname['type']=='yh')
		{
			$userSearch =  new userSearchModel;
			$userList = $userSearch->getuserNameModel($cityname);
			return $userList;
		}
		//按房源搜索
		if($cityname['type']=='fy')
		{
			return $this
				->where("h_title","like","%".$cityname['typeName']."%")
				->select();
		}
//		区域
		else{
			return $this
				->where("cityname","like","%".$cityname['typeName']."%")
				->select();
		}
		
	}
}
