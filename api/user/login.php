<?php

/**
 * ECSHOP 用户登录 上海睿风信息技术有限公司添加
 
 * ============================================================================
 * * 版权所有 2005-2012 上海商派网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.ecshop.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * $Author: liubo $
 * $Id: goods.php 17217 2011-01-19 06:29:08Z liubo $
 */


define('IN_ECS', true);

require_once( '../../includes/init.php');
require_once('../../includes/cls_json.php');
require_once('../../config/config.php');

$json = new JSON;


$action = isset($_REQUEST['action'])? $_REQUEST['action']:'';
if (empty($_REQUEST['userName']) || empty($_REQUEST['password']))
{
    $results = array('code'=>'400', 'msg'=>'缺少必要的参数');
    exit($json->encode($results));
}
  $username= $_REQUEST['userName'];
  $password = $_REQUEST['password'];
  
   $sql = "SELECT " .
                   "user_id FROM " . $ecs->table("users").
                   " WHERE user_name='" . $username . "' AND password ='" . $user->compile_password(array('password'=>$password)) . "'";
   
	$sql = "select * from " . $ecs->table("users") . " where user_name='" . $username . "' and password='" . $user->compile_password(array("password"=>$password)) . "'";
	$userData = $db->getrow($sql);
	
  
if (!empty($userData['user_id'])) {
	$token=md5($username  . date("Y-m-d h-m-s"));
	$user_info = array('token' => $token, 'user_name'=>$userData['user_name'],"money"=>$userData['user_money'], "jifen"=>$userData['user_points'], "avatar"=>$userData['avatar'], "user_id"=>$userData['user_id']);
 	 $result = array('code'=> '101', 'msg' => '登录成功' , "user_info"=>$user_info);
 	 //检查是否是当天第一次登陆
 	 check_first_login($userData['user_id']);
  	// 保存token
     saveToken($username, $token, $db, $ecs);

        die(json_encode($result));
} else {
	$result = array('code'=> '102', 'msg' => '用户不存在或者密码错误');
  	exit($json->Encode($result));
}

  $result = array('code'=> '101', 'msg' => '登录成功' , 'token' => $token);
   exit($json->Encode($result));
   // 检查user_session是否有改用户的数据
   $SQL = "select * from " . $ecs->table("user_session") . "where user_id=" . $userData['user_id'];
   $userData = $db->getRow($SQL);
   if($userData != false ) {
		 // 更新数据库表的token
		 $field_values=array('token' => $token, 'expire_time' => time() + 86400);
		 $db->autoReplace($ecs->table('user_session'),$field_values, $field_values, "UPDATE");
	} else {
		// 创建用户的记录
		$session_record['user_id']= $user['user_id'];
		$session_record['token']= $token;
		$session_record['times']= 1;
		$session_record['login_time']= time();
		$session_record['expire_time']= time() +86400;
		$db->autoExecute($ecs->table("user_session"), $session_record, "INSERT");
	}

function check_first_login($uid) {
	$sql = "select login_time from ecs_user_session where user_id = $uid";
	$login_time = $GLOBALS['db']->getOne($sql);
	
	if (!empty($login_time)) {
		$login_time = date('Y-m-d', $login_time);
		if ($login_time < date('Y-m-d')) {
			//获取积分
			$points = array();
			$points['user_id'] = $uid;
			$points['points'] = login_points;
			$points['o_points'] = login_points;
			$points['expiration_time'] = date('Y-m-d H:i:s', strtotime("+1 year"));
			$points['create_time'] = date('Y-m-d H:i:s');
			$GLOBALS['db']->autoExecute('ecs_user_points', $points, "INSERT");
		}
	}
}

function saveToken($username, $token, $db, $ecs) {
	$sql = "select * from " . $ecs->table("users") . "where user_name='" . $username . "'";
	$userData = $GLOBALS['db']->getRow($sql);
	$sql = "select * from " . $ecs->table("user_session") . " where user_id = " . $userData['user_id'];
	$session = $GLOBALS['db']->getRow($sql);
	
	//print($session);
	
	if(!empty($session["id"])) {
		// 用户存在
		$session_record= array();
		$session_record['user_id']= $session['user_id'];
		$session_record['token']= $token;
		$session_record['times']= $session['times'] + 1;
		$session_record['login_time'] = time();
		$session_record['expires_time'] = time() + 86400;
		
	    $sql = "update " . $ecs->table("user_session") . " set token ='" . $token  . "',login_time = " . time() .", times=". ($session['times'] + 1) . ",expires_time= ". (time() +86400)  . " where id = " . $session['id'] . "";
	    $field_values= array("token", "timesz", "login_time", "expires_Time");
	    
	    $db->autoReplace($ecs->table('user_session'),$field_values, $session_record, "id = ". $session['id'], "UPDATE");
		 $GLOBALS['db']->query($sql);
		return true;
	} else {
		// 新建记录
		$session_record = array();
		$session_record['user_id']= $userData['user_id'];
		$session_record['token']= $token;
		$session_record['times']= 1;
		$session_record['login_time'] = time();
		$session_record['expires_time'] = time() + 86400;
		
		$db->autoExecute($ecs->table('user_session'), $session_record,'INSERT');
		
		return false;
	}
}

?>