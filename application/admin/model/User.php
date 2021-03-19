<?php
namespace app\admin\model;

use think\Model;
use think\Db;

class User extends Model{

    public static function getUser($username)
    {
        $user = new User();
        $LoginUser = $user->where(["userName"=>$username])->select();

        if(count($LoginUser)>0)
        {
            return $LoginUser[0]->toArray();
        }
        else
        {
            return [];
        }
    }

    public static function getAllUser() {
		$result = Db::query("select *from user ");

		return $result;
    }
    
    

}