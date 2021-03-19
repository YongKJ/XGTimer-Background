<?php
namespace app\admin\model;

use think\Model;
use think\Db;

class Userdata extends Model{

    public static function getUserData($userName,$day1,$day2)
    {
        $result = Db::query("select *from userdata where userName = '$userName' and dateTime >= '$day1'&& dateTime<= '$day2' ");
        return $result;
    }

    public static function getWeekDataOfUser($list)
    {
        $data = ["0"=>0,"1"=>0,"2"=>0,"3"=>0,"4"=>0,"5"=>0,"6"=>0];



        foreach($list as $vo)
        {
            $data[date("w",strtotime($vo["dateTime"]))] = $vo["seconds"];
        }
        return $data;
    }

    public static function getWeekDataTotalOfUser($userName,$day1,$day2)
    {
        $result = Db::query("select sum(seconds) as total from userdata where userName = '$userName' and dateTime >= '$day1'&& dateTime<= '$day2' ");

        if(!$result[0]["total"])
        {
            $result[0]["total"] = "0";
        }
        return $result[0]["total"];
    }

    //更新时间
    public static function updateTime($user,$seconds)
    {
        $check = Userdata::getUserData($user["userName"], date("y-m-d 00:00:00"), date("Y-m-d 00:00:00"));

		if (count($check) <= 0) {
			Db::query("insert into userdata values (default,'$user[userName]',curDate(),'$seconds')");
		} else {
			Db::query("update userdata set seconds = '$seconds' where userName = '$user[userName]' and dateTime = curdate()");
        }
    }

    




}

?>