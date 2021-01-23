<?php
namespace app\api\model;
use think\Model;

class User extends Model
{
	protected $pk = 'uid';
	//查询全部
	public function getuserSelect()
	{
		return $this->field('user_pwd',true)->select();
	}
//	用户名模糊查找
	public function getuserNameModel($cityname)
	{
		return $this->field('user_pwd',true)
		->where("user_name","like","%".$cityname['typeName']."%")->select();
	}
	//分页查询
	public function getuserLimit($page)
	{
		$pagesize = 10;
		$limitList = ($page['page']-1)*$pagesize;
		return $this->field('user_pwd',true)->limit($limitList,$pagesize)->select();
	}
	//单条语句查询
	public function getuserFind($uid)
	{
		return $this->field('user_pwd',true)->where('uid',$uid['uid'])->find();
	}
	
	//添加
	public function adduserModel($list)
	{
		return $this->save($list);
	}
	
	//删除
	public function deluserModel($uid)
	{
		return $this->destroy($uid['uid']);
	}
	//修改
	public function upuserModel($uid)
	{
		return $this->save($uid,['uid'=>$uid['uid']]);
	}
	
	public function upphotoModel($uid)
	{
		return $this->save($uid,['uid'=>$uid['uid']]);
	}
	public function loginuserModel($data)
	{
		return $this->where("user_name",$data["user_name"])->
					 where("user_pwd",md5(md5($data["user_pwd"])))->
					 field('user_pwd',true)->find();
	}
//	未登录忘记密码
	public function	upwdlwjmmModel($data)
	{
		return $this->save(['user_pwd'=>$data['user_pwd']],['user_tel'=>$data['user_tel']]);
	}

}