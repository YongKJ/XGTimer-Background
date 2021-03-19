<?php

namespace app\admin\controller;

use think\Controller;
use app\admin\model\User;
class Register extends Controller 
{
    public function i($method="register")
    {
        return call_user_func(array($this,$method));
    }


    private function register()
    {
        $data = [];
        $data["userName"] = input("userName");
        $data["trueName"] = input("trueName");
        $data["password"] = input("password");
        $data["phone"] = input("phone");
        $data["sex"] = input("sex");
        $data["member"] = 0;
        $data["headImage"] = 0;

        

        $userObject = new User();

        $user = User::getUser($data["userName"]);

        if($user)
        {
            return json(["method"=>"register","status"=>400,"message"=>"用户名已注册"]);
        }

        $userObject->save($data);

        return json(["method"=>"register","status"=>200,"message"=>"注册成功"]);
    }

    private function version()
    {
        return json(["method"=>"version","status"=>200,"message"=>"获取成功","version"=>"V 1.1.2","downloadUrl"=>"http:/www.714club.cn:8082/xgtimer/public/app/1.1.0/app.exe"]);
    }
}

?>