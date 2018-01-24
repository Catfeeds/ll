<?php

/**
 * 用户登录
 */
namespace Weixin\Controller;
use Think\Log;
use Common\Controller\HomebaseController;
class RulepageController extends HomebaseController {
    //积分规则
    function integral_rule(){
        $ec=M('EncourageConfig')->order("type asc")->select();
        $this->assign('ec',$ec);
        $this->display(":integral_rule");
    }
    //我的推荐
	function recommend(){
	    $appid=$_REQUEST[anzhuoappid];
	    if(!empty($appid)){
	        $userid=$appid;
	    }else{
	        $userid=$_GET[userid];
	    }
	    $u=M('user')->field("phone")->where("id = $userid")->find();
	    $res=M('user')->field("phone")->where("recommended_person = $u[phone]")->select();
	    $ec=M('encourage_config')->field("integral")->where("type = 1")->find();
	    $this->assign('integral',$ec[integral]);
	    $this->assign('res',$res);
		$this->display(":recommend");
	}
	//用户协议
	function user_protocol(){
	    $this->display(":user_protocol");
	}
}
