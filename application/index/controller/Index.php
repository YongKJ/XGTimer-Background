<?php

namespace app\index\controller;

use app\admin\controller\Refer;
use app\admin\model\Login;
use app\admin\model\Manage;
use app\admin\model\Update;
use think\Controller;
use think\Session;

class Index extends Controller {
	public function index() {

	}

	public function login() {
		return $this->fetch("", ['request' => 0, 'reason' => 0]);
	}

	public function test() {
		$res = Login::isOnLine("admin_001");
		print_r($res);
	}

	public function check() {
		$username = input("username");
		$password = input("password");

		$result = Login::login($username, $password);

		//登录失败
		if ($result['request'] != 100) {
			return $this->fetch("login", $result);
		}

		Session::set("login", $username);

		$result = array_merge($result, Login::getAllMessage($username));

		$userList = Manage::getAllUserMessage();

//        print_r($userList);

		$this->assign("list", $userList);

		return $this->fetch("admin", $result);
	}

	public function updateUserPermit() {
		if (!Session::has("login")) {
			return $this->fetch("login", ['request' => 0, 'reason' => 0]);
		}
		$loginAdmin = Session::get("login");
		$userName = input("userName");
		$type = input("type");

		$loginer = Login::getAllMessage($loginAdmin);
		$user = Login::getUserPermit($userName);
		$userList = Manage::getAllUserMessage();

		$this->assign("list", $userList);

		if ($loginer["permit"] <= $user["permit"] + 1 || $loginer["permit"] <= 4) {

			echo "权限不足,操作失败";

			$loginer = array_merge($loginer, ['request' => 200, 'reason' => 401]);

			return $this->fetch("admin", $loginer);

		}

		if ($type == 1) {
			Update::updateUserPermit($user["userName"], $user["permit"] + 1);
		} else {
			Update::updateUserPermit($user["userName"], $user["permit"] - 1);
		}

		$userList = Manage::getAllUserMessage();

		$this->assign("list", $userList);

		$loginer = array_merge($loginer, ['request' => 100, 'reason' => 0]);
		return $this->fetch("admin", $loginer);
	}

	public function admin() {

		if (!Session::has("login")) {
			return $this->fetch("login", ['request' => 0, 'reason' => 0]);
		}
		$loginAdmin = Session::get("login");
		$loginer = Login::getAllMessage($loginAdmin);

		$userList = Manage::getAllUserMessage();

		$this->assign("list", $userList);

		$loginer = array_merge($loginer, ['request' => 100, 'reason' => 0]);

		return $this->fetch("admin", $loginer);
	}

	public function unLogin() {

		Session::clear();

		return $this->fetch("login", ['request' => 0, 'reason' => 0]);

	}

	public function TimerStatistic() {
		if (!Session::has("login")) {
			return $this->fetch("login", ['request' => 0, 'reason' => 0]);
		}
		$loginAdmin = Session::get("login");
		$loginer = Login::getAllMessage($loginAdmin);

		$userTimerList = Refer::getAllUserTimerList();

		foreach ($userTimerList as $key => $item) {
			$alley = Login::getUserMessage($item["userName"]);

			$userTimerList[$key]["trueName"] = $alley["trueName"];
			$userTimerList[$key]["motto"] = $alley["motto"];
		}

		$this->assign("list", $userTimerList);

		$loginer = array_merge($loginer, ['request' => 100, 'reason' => 0]);
		return $this->fetch("", $loginer);
	}
	public function getMac()
	{
		return "mac_address";
	}


}
