<?php

/**
 * ECSHOP 用户信息取得 上海睿风信息技术有限公司添加
 
 * ============================================================================
 * * 版权所有 2005-2012 上海商派网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.ecshop.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * $Author: jiangguohua $
 * $Id: goods.php 17217 2011-01-19 06:29:08Z jiangguohua $
 */


define('IN_ECS', true);

require_once('../init.php');
require_once('../token.php');
require_once(ROOT_PATH . 'includes/cls_json.php');
require_once(ROOT_PATH . 'config/config.php');

$json = new JSON;

$uid = isset($_REQUEST['uid'])? $_REQUEST['uid']:'';
$token = isset($_REQUEST['token'])? $_REQUEST['token']:'';
if(empty($token)) {
	$result = array("code"=> "400", "msg"=> "缺少必要的参数token");
	exit($json->encode($result));
}
if (empty($uid))
{
    $results = array("code"=> "201", "msg"=> "缺少必要的参数uid");
    exit($json->encode($results));
}

$sql = "select * from ecs_user_session where token = '" . $token . "' and  user_id = '".$uid."'";
$result = check_token($token, $sql, $db, $ecs);
if($result['code'] == "101")
{
// 检查user_info是否有该用户的数据
   	$SQL = "select * from " . $ecs->table("users") . "where user_id=" . $uid;
   	$userData = $db->getRow($SQL);
   	if($userData) {
   			
   		$user_info = array("is_qq"=>$userData['is_qq'], "is_weixin"=>$userData['is_weixin'], "is_weobo"=>$userData['is_weobo'], "user_name"=>$userData['user_name'],
			"nick_name"=>$userData['nick_name'],"money"=>$userData['user_money'], 'avatar'=>$userData['avatar'], 'token'=>$token,"real_name"=>$userData['real_name'],"alipy_acount"=>$userData['alipy_acount']);
   			
   		$sql = "select * from ecs_user_info where user_id = '$uid'";
   		$info = $db->getRow($sql);
   		if ( $info ) {
   			$user_info['size'] = $info['size'];
   			$user_info['type'] = $info['type'];
   			$user_info['style'] = $info['style'];
   			$user_info['clothes'] = $info['clothes'];
   		} else {
   			$user_info['size'] = '';
   			$user_info['type'] = '';
   			$user_info['style'] = '';
   			$user_info['clothes'] = '';
   		}
   		$result = array("code"=>"101","msg"=>"取得用户信息成功", "user_info"=>$user_info);
   		$resp_str=json_encode($result);
   		// 替换null为空字符串
   		$resp_str = str_replace(":null", ":\"\"", $resp_str);
   		exit($resp_str);
   	}else {
   		$result = array("code"=> "102", "msg"=> "暂无该用户详情数据");
	    exit($json->encode($result));	
   	}   
}else{
		exit($json->Encode($result));
}
   	
	
/* function saveToken($username, $token) {
	$sql = "select * from " . $ecs->table("users") . "where user_name=" . $username;
	$userData = $db ->getrow($sql);
	$sql = "select * from " . $ecs->table("user_session") . " where user_id = " . $userData['id'];
	$session = $db->getrow($sql);
	
	if($userData != false ) {
		// 用户存在
		echo "user_id is " . $userData['user_id'];
		$session_record['user_id']= $user['user_id'];
		$session_record['token']= $token;
		$session_record['times']= 1;
		
	    $sql = "update " . $ecs->table("user_session") . " set token = " . $token  . ",login_time = " . time() . ",expit_time= ". time() + TOKEN_EXPIRE_DURATION  . "where id = " . $session['id'];
			
		$db->query($sql);
		return true;
	} else {
		// 用户不存在!
		return false;
	}
	
	if($session == false ) {
		// 新建记录
		$session_record['user_id']= $user['user_id'];
		$session_record['token']= $token;
		$session_record['times']= 1;
		$session_record['login_time'] = time();
		$session_record['expires_time'] = time() + TOKEN_EXPIRE_DURATION;
		
		$db->autoExecute($ecs->table('user_session'), $sms_record, 'INSERT');
	} else {
		// 更新
	///	$sql = "update " . $ecs->table("user_session") . " set token = " . $token  . ",login_time = " . time() . ",expit_time= ". time() +86400  . "where id = " . $session['id'];
	
	}
} */
?>