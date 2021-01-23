<?php
namespace app\api\model;

use think\Model;
use think\Request;
use app\api\model\User as UserModelInAdmin;

class Admin extends Model
{
	protected $pk = 'aid';
	//按姓名查找
	public function getadminnameModel($name)
	{
		return $this->field('admin_pwd',true)
				->where("admin_name","like","%".$name['admin_name']."%")
				->select();
	}
	//查询全部
	public function getadminOver()
	{
		return $this->field('admin_pwd',true)->select();
	}
	//分页查询
	public function getadminLimit($page)
	{
		$pagesize = 10;
		$limitList = ($page['page']-1)*$pagesize;
		return $this->field('admin_pwd',true)->limit($limitList,$pagesize)->select();
	}
	
	//单条语句查询
	public function getadminFind($aid)
	{
		
		return $this->field('admin_pwd',true)->where('aid',$aid['aid'])->find();
	}
	
	//添加
	public function addadminModel($list)
	{
		return $this->save($list);
	}
	
	//删除
	public function deladminModel($aid)
	{
		return $this->destroy($aid['aid']);
	}
	
	//修改
	public function upadminModel($aid)
	{
		return $this->save($aid,['aid'=>$aid['aid']]);
	}
	public function upphotoModel($aid)
	{
		return $this->save($aid,['aid'=>$aid['aid']]);
	}
	
	//登录查询
	public function loginadminModel($data)
	{
		if($data){
			$newData = array(
				"user_name" => $data['admin_name'],
				"user_pwd" => $data['admin_pwd']
			);
		$usermodel = new UserModelInAdmin;
		$usernum=$usermodel->loginuserModel($newData);
		}
		
		if($usernum)
		{
			return "改名称已被注册，请修改";
		}else{
			return $this->where("admin_name",$data["admin_name"])->
					 where("admin_pwd",md5(md5($data["admin_pwd"])))->
					 field('admin_pwd',true)->find();
		}
		
	}
}

