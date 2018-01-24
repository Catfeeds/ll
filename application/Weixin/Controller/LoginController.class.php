<?php

/**
 * 用户登录
 */
namespace Weixin\Controller;
use Common\Controller\MemberbaseController;
use Think\Log;
class LoginController extends MemberbaseController {
	//用户判断
	function index(){
		//加个测试数据吧，我觉得可以啊
		$debug=0;
		if($debug){
			$wxuser = '{"openid":"oe92uwwqXmicoPM9YNQxDbdvlgsA","nickname":"fyh","sex":1,"language":"zh_CN","city":"\u82cf\u5dde","province":"\u6c5f\u82cf","country":"\u4e2d\u56fd","headimgurl":"http://wx.qlogo.cn/mmopen/SMzV7V82HUL0LzNIIeILLYuwiaSR99xewAGI5LudGNs2ib1tdb0wPCnXrjfVGd4Xkibia6qnIib2tVK9joNRzVKacRpA0HacRea7w/0","privilege":[],"access_token":"X1oRUxWiNC03AfjkBdCIUt9dmeONpfxe48nvw5uUShAc2zml9wuBn2wD0JCswHJSXavUhXXR__jd5W2H5PjVuq28iYc8q-vc5UXYSMQg_2wAZ_8G4ocadOhyEOUfXKPPOSJiCFABFW"}';
			$user = json_decode($wxuser, TRUE);
			$open_id = $user['openid'];
			$userinfo = $user ;
		}else{
				if (! isset ( $_GET ['userInfo'] )) {
				$url = URL1.urlencode(SITE_URLS.$_SERVER['PHP_SELF'] . '?' . $_SERVER['QUERY_STRING']."&");
				header("Location: $url");
				exit();
			}else{
				$_SESSION ['userinfo'] = $_GET ['userInfo'];
			}
			$userinfo =  json_decode($_GET ['userInfo'],true);
			$userinfo =  json_decode($userinfo,true);
			if(!isset($userinfo['openid'])){
				$url = URL1.urlencode(SITE_URLS.$_SERVER['PHP_SELF'] . '?' . $_SERVER['QUERY_STRING']."&");
				header("Location: $url");
				exit();
			}
			
			$open_id=$userinfo['openid'];
		}
		
		//设置session openid
		$_SESSION[weiopen_id]=$open_id;
		$users=M("user")->where("openid='$open_id'")->find();
		if(empty($users)){//跳转绑定页面
			$this->redirect("Center/index");
		}else{
			$_SESSION['weixin_user_id']=$users['id'];
			if ($_GET['type'] == 1) {
				$this->redirect("Course/course");
			} elseif ($_GET['type'] == 2) {
				$this->redirect("Mine/server");
			} else {
				$this->redirect("Mine/my");
			}
		}
	}
}
