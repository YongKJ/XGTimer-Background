<?php

namespace app\admin\controller;

use app\admin\model\Login;
use app\admin\model\Manage;
use app\admin\model\Tool;

class Refer
{
    public static function index()
    {

        $userName = input("userName");
        $type = input('type');

        switch ($type) {
            case 1:
                $result = Login::getALLMessage($userName);
                $result["password"] = "******";
                break;
            default:
                $result['request'] = 200;
                $result['reason'] = 405;
                break;
        }
        return json($result);
    }

    public static function getUpdateVersionMessage()
    {
        return json(self::$appVersionMessage);
    }

    public static function getAllUserTimerList()
    {

        $userList = Manage::getUserList();
        $index = 0;

        foreach ($userList as $key => $item) {

            $allay = Login::getUserData($userList[$key]["userName"], Tool::DateOfFirday(), date("Y-m-d"));

            if (count($allay) <= 0) {
                continue;
            }

            $userTime["seconds"] = 0;

            foreach ($allay as $item) {
                $userTime["userName"] = $item["userName"];
                $userTime["seconds"] += $item["seconds"];
            }

            $userTimeList[$index++] = $userTime;

        }
        $temp = [];
        for ($i = 0; $i < count($userTimeList); $i++) {

            for ($j = 0; $j < count($userTimeList) - 1; $j++) {

                if ($userTimeList[$j]["seconds"] < $userTimeList[$j + 1]["seconds"]) {

                    $temp = $userTimeList[$j];
                    $userTimeList[$j] = $userTimeList[$j + 1];
                    $userTimeList[$j + 1] = $temp;

                }

            }

        }

        return $userTimeList;

    }

    public static function getAllUserTimerListByChoose($dayOfStart,$dayOfEnd)
    {

        $userList = Manage::getUserList();
        $index = 0;

        foreach ($userList as $key => $item) {

            $allay = Login::getUserData($userList[$key]["userName"], $dayOfStart,$dayOfEnd);

            if (count($allay) <= 0) {
                continue;
            }

            $userTime["seconds"] = 0;

            foreach ($allay as $item) {
                $userTime["userName"] = $item["userName"];
                $userTime["seconds"] += $item["seconds"];
            }

            $userTimeList[$index++] = $userTime;

        }

        foreach ($userTimeList as $key => $item) {
            $alley = Login::getUserMessage($item["userName"]);

            $userTimeList[$key]["trueName"] = $alley["trueName"];
            $userTimeList[$key]["motto"] = $alley["motto"];
        }

        $temp = [];
        for ($i = 0; $i < count($userTimeList); $i++) {

            for ($j = 0; $j < count($userTimeList) - 1; $j++) {

                if ($userTimeList[$j]["seconds"] < $userTimeList[$j + 1]["seconds"]) {

                    $temp = $userTimeList[$j];
                    $userTimeList[$j] = $userTimeList[$j + 1];
                    $userTimeList[$j + 1] = $temp;

                }

            }

        }
        echo "<pre>";
        print_r($userTimeList);
        echo "</pre>";

    }

    static $appVersionMessage = ["version" => "V 1.0.8", "downloadURL" => "http://120.79.91.253:8082//tp5//public//TimerV1.0.exe"];

    public static function test(){
	return json(Tool::DateOfFirday());
	}
}

