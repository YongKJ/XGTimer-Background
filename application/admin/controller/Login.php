<?php
namespace app\admin\controller;

use think\Controller;
use app\admin\model\User;
use app\admin\model\Userdata;
use app\admin\model\Tool;

class Login extends Controller{

       public function test(){ return json(
	['0'=>Tool::HasBeenLastOf(0),'1'=>Tool::HasBeenLastOf(1),
'2'=>Tool::HasBeenLastOf(2),
'3'=>Tool::HasBeenLastOf(3),
'4'=>Tool::HasBeenLastOf(4),
'5'=>Tool::HasBeenLastOf(5),
'6'=>Tool::HasBeenLastOf(6),]
);
}
    public function i($username,$password,$method="user"){

        $user = User::getUser($username);

        if(!$user||$user["password"]!=$password)
        {
            return json(["status"=>"400","message"=>"账号或密码错误"]);
        }
        else
        {
            
            return call_user_func(Array($this,$method),$user);
        }
    }

    private function user($user)
    {
        $list = Userdata::getWeekDataOfUser(Userdata::getUserData($user["userName"],Tool::HasBeenLastOf(5),date("Y-m-d 00:00:00")));
        $total = 0;
        foreach($list as $vo)
        {
            $total = $total + $vo;
        }
        
        $user["list"] = $list;
        $user["total"] = $total;
        // $user["password"]="******";
        return json(["method"=>"user","status"=>"200","message"=>"成功登陆","user"=>$user]);
    }

    private function UserData($user)
    {

    }

    private function statistic($user)
    {
        $userList = User::getAllUser();
        foreach($userList as $key => $user)
        {
            $userList[$key]["password"] = "******";
            $userList[$key]["total"] = Userdata::getWeekDataTotalOfUser($user["userName"],Tool::HasBeenLastOf(5),date('Y-m-d 00:00:00'));
        }

        return json(["method"=>"statistic","status"=>200,"message"=>"获取成功","list"=>$userList]);
    }

    private function updateTime($user)
    {
        $seconds = input("seconds");

        Userdata::updateTime($user,$seconds);

        return json(["method"=>"updateTime","status"=>"200","message"=>"更新成功"]);
    }

    private function updateUser($user)
    {
        $data = [];
		$data['nickName'] = input('nickName');
		$data['trueName'] = input('trueName');
		$data['sex'] = input('sex');
		$data['motto'] = input('motto');
		$data['phone'] = input('phone');
		$data['schoolNumber'] = input('schoolNumber');
		$data['headImage'] = input('headImage');
		$data['profess'] = input('subjectName');
        $data["member"] = input("member");
        
        $userObject = new User();

        $userObject->update($data,["userName"=>$user["userName"]]);

        $newUser = User::getUser($user["userName"]);

        return json(["method"=>"updateUser","status"=>200,"message"=>"更新用户信息成功","user"=>$newUser]);
    }



}

?>