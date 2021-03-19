<?php
namespace app\admin\model;

class Tool {

	public static function dateFrom($number) {
		return date('Y-m-d', strtotime($number . ' day'));
	}

	public static function DateOfThisMonday() {
		$nowDayOfWeek = date('w');
		if ($nowDayOfWeek == 0) {
			$nowDayOfWeek = 7;
		}

		$nowDayOfWeek -= 1;

		return Tool::dateFrom($nowDayOfWeek);
	}

	public static function DateOfFirday(){
		$nowDayOfWeek = date('w');
		$date = 0;
		switch($nowDayOfWeek)
		{
		case 0:$date = 2;break;
		case 1:$date = 3;break;
		case 2:$date = 4;break;
		case 3:$date = 5;break;
		case 4:$date = 6;break;
		case 5:$date = 0;break;
		case 6;$date = 1;break;
		}
		return Tool::dateFrom($date);

	}


	//星期一是1，星期日是7
	public static function dateOfWeek($dayOfWeek) {
		$nowDayOfWeek = date('w');

		if ($nowDayOfWeek == 0) {
			$nowDayOfWeek = 7;
		}

		$minuDayOfNow = $nowDayOfWeek - $dayOfWeek;

		$minuDayOfNow = -$minuDayOfNow;

		$str = $minuDayOfNow . " day";

		return date('Y-m-d', strtotime($str));

	}

	public static function getInputData() {
		$data['userName'] = input('userName');
		$data['password'] = input('password');
		$data['nickName'] = input('nickName');
		$data['trueName'] = input('trueName');
		$data['sex'] = input('sex');
		$data['motto'] = input('motto');
		$data['phoneNumber'] = input('phoneNumber');
		$data['schoolNumber'] = input('schoolNumber');
		$data['schoolName'] = input('schoolName');
		$data['headImage'] = input('headImage');
		$data['subjectName'] = input('subjectName');
		$data["newPassword"] = input('newPassword');
		$data["member"] = input("member");

		return $data;
	}

	public static function getInputGuestBook() {
		$data['id'] = input("id");
		$data['sender'] = input("sender");
		$data['userName'] = input("userName");
		$data['password'] = input('password');
		$data['receiver'] = input('receiver');
		$data['property'] = input('property');
		$data['title'] = input('title');
		$data['text'] = input('text');
		$data['read'] = input('read');
		$data['love'] = input("love");
		$data['type'] = input("type");
		$data["guestType"] = input("guestType");

		return $data;
	}

	public static function FirstDayOfMonth($month) {
		return date("Y-m-01");
	}

	public static function LastDayOfMonth($month) {
		$date = self::FirstDayOfMonth($month);
		return date("Y-m-d", strtotime($date . "+1 month -1 day"));
	}

/**
	 * 获取已经过去的星期几的日期
	 */
	public static function HasBeenLastOf($chooseWeekday)
	{
		$number = 0;
		while(date('w', strtotime($number . ' day'))!=$chooseWeekday)
		{
			$number=$number-1;
		}
		return date('Y-m-d', strtotime($number . ' day'));
	}

	public static function HasNotBeenNextOf($chooseWeekday)
	{
		$number = 0;
		while(date('w', strtotime($number . ' day'))!=$chooseWeekday)
		{
			$number=$number+1;
		}
		return date('Y-m-d', strtotime($number . ' day'));
	}
	public static function sortStatisticBags($list)
	{
		$len = count($list);
		for($i = 0;$i<$len;$i+=1)
		{
			$max = $i;
			for($j=$i;$j<$len;$j+=1)
			{
				if((int)$list[$max]["user_count"]<(int)$list[$j]["user_count"])
				{
					$max = $j;
				}
			}

			$t = $list[$max];
			$list[$max] = $list[$i];
			$list[$i] = $t;

		}
		return $list;	
	}

}