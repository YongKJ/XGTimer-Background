<?php
namespace app\admin\model;

use app\admin\model\Login;
use think\Db;

class GuestBook {

	public static function index() {

	}
	public static function insertGuestBook($data) {

		if (strlen($data['sender']) < 3) {
			return ["request" => 200, "reason" => 402];
		}

		if ($data['id'] != 0) {
			return ['request' => 200, 'reason' => 406];
		}
		Db::query("insert into guestbook values(
			default,
			'$data[sender]',
			'$data[receiver]',
			'$data[property]',
			'$data[title]',
			'$data[text]',
			NOW(),
			'$data[read]',
			'$data[love]',
			'$data[guestType]'
		)");

		return ['request' => 100];
	}

	public static function updateGuestBook($data) {
		$findBook = Db::query("select *from guestbook where id = '$data[id]' ");

		if (count($findBook) == 0) {
			return ['request' => 200, "reason" => 407];
		}

		return ['request' => 100];
	}

	public static function deleteGuestBook($data) {
		$findBook = Db::query("select *from guestbook where id = '$data[id]' ");

		if (count($findBook) == 0) {
			return ['request' => 200, "reason" => 407];
		}
		Db::query("delete from guestbook where id = '$data[id]'");
		return ['request' => 100];
	}

	public static function getAllGuestBook() {
		$result = Db::query("select *from guestbook");

		foreach ($result as $key => $book) {
			$userMessage = Login::getUserMessage($book['sender']);

			if ($userMessage['request'] != 100) {
				return ['request' => 200, 'reason' => 402];
			}
			$result[$key]['headImage'] = $userMessage['headImage'];
			$result[$key]['trueName'] = $userMessage['trueName'];

			$userPermit = Login::getUserPermit($book['sender']);

			if ($userPermit["request"] == 200) {
				return ['request' => 200, 'reason' => 402];
			}
			$result[$key]['permit'] = $userPermit['permit'];
			if ($userPermit['permit'] <= 0) {
				$result[$key]["text"] = "***由于某种原因屏蔽了这条消息***";
			}
		}
		$result['request'] = 100;
		return $result;
	}
	public static function getGuestBookOnly($type) {
		$result = Db::query("select *from guestbook where property = '$type' ");

		foreach ($result as $key => $book) {
			$userMessage = Login::getUserMessage($book['sender']);

			if ($userMessage['request'] != 100) {
				return ['request' => 200, 'reason' => 402];
			}
			$result[$key]['headImage'] = $userMessage['headImage'];
			$result[$key]['trueName'] = $userMessage['trueName'];

			$userPermit = Login::getUserPermit($book['sender']);

			if ($userPermit["request"] == 200) {
				return ['request' => 200, 'reason' => 402];
			}
			$result[$key]['permit'] = $userPermit['permit'];
			if ($userPermit['permit'] <= 0) {
				$result[$key]["text"] = "***由于某种原因屏蔽了这条消息***";
			}
		}
		$result['request'] = 100;
		return $result;
	}
}