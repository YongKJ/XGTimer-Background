<?php

namespace app\admin\model;

use think\Db;

class Manage {
	public static function getUserList() {
		$result = Db::query("select *from userpermit ");

		return $result;
	}

	public static function getAllUserMessage() {

		$result = Manage::getUserList();

		foreach ($result as $key => $value) {

			$result[$key]["trueName"] = "无效";
			$result[$key]["phoneNumber"] = "未定义";

			$res = Login::isOnLine($result[$key]["userName"]);

			$res["request"] == 100 ? $result[$key]["online"] = "在线" : $result[$key]["online"] = "不在线";

			$result[$key] = array_merge($result[$key], Login::getUserMessage($result[$key]["userName"]));
		}

		return $result;

	}
}