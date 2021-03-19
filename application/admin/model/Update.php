<?php
namespace app\admin\model;

use app\admin\model\Login;
use think\Db;

class Update {

	public static function update() {

	}

	public static function updateUserLoginTime($userName) {
		$request = Db::query("update userpermit set
			lastTime = NOW() where userName = '$userName'
			");

		return ['request' => 100];
	}

	public static function updateUserPermitByMember($data) {

		if (strlen($data['password']) < 6 || trlen($data['password']) > 20) {
			return ['request' => 200, "reason" => 402];
		}

		$request = Db::query("update userpermit set
			password = '$data[password]',
			lastTime = NOW() where userName = '$data[userName]'
			");

		return ['request' => 100];
	}

	public static function updateUserPermit($userName, $permit) {
		Db::query("update userpermit set
			permit = '$permit' where userName = '$userName'
			");

		return ['request' => 100];
	}

	public static function updateUserTodayTimer($userName, $timer) {
		$check = Login::getUserData($userName, Tool::dateFrom(0), date("Y-m-d"));

		if (count($check) <= 0) {
			Db::query("insert into userdate values (default,'$userName',curDate(),'$timer')");
		} else {
			Db::query("update userdate set seconds = '$timer' where userName = '$userName' and dateTime = curdate()");
		}

		return ['request' => 100];
	}

	public static function updateUserMessage($data) {
		$check = Login::checkUser($data);
		if ($check['request'] != 100) {
			return $check;
		}

		$check = Login::getUserMessage($data['userName']);

		if ($check["request"] != 100) {
			Db::query("insert into usermessage values (
          		default,
         		'$data[userName]',
          		'$data[nickName]',
          		'$data[trueName]',
          		'$data[sex]',
          		'$data[motto]',
          		'$data[phoneNumber]',
          		'$data[schoolNumber]',
          		'$data[schoolName]',
          		'$data[headImage]',
         	 	'$data[subjectName]',
          		NOW(),
          		1
        )");

		} else {
			Db::query("update usermessage set
          	nickName = '$data[nickName]',
          	trueName = '$data[trueName]',
          	sex = '$data[sex]',
          	motto = '$data[motto]',
          	phoneNumber = '$data[phoneNumber]',
          	schoolNumber = '$data[schoolNumber]',
          	schoolNumber = '$data[schoolName]',
          	headImage = '$data[headImage]',
          	subjectName = '$data[subjectName]',
          	member = '$data[member]' where userName = '$data[userName]'
          ");
		}

		return ['request' => 100];
	}

	public static function insertNewUserPermit($data) {
		Db::query("insert into userpermit values (
          default,
          '$data[userName]',
          '$data[password]',
        1,
          NOW()
        )");

		return ['request' => 100];
	}

	public static function updatePassword($userName, $password) {
		Db::query("update userpermit set password = '$password' where userName='$userName'");

		return ["request" => 100];
	}

}
