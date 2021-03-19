<?php

namespace app\admin\controller;

use think\Controller;

class Index extends Controller
{
    public function i($method)
    {
        return call_user_func(array($this,$method));
    }


    private function getStudioMac()
    {
        return json([
            "method"=>"getStudioMac",
            "status"=>200,
            "message"=>"获取成功",
            "list"=>[
                "14-e6-e4-b4-76-24",
                "30-fc-68-43-bc-00",
		"14-14-4b-74-cd-bb",
		"14-d6-4d-cc-83-76",
		"9c-71-3a-27-6b-75"
            ]
        ]);
    }

}

?>
