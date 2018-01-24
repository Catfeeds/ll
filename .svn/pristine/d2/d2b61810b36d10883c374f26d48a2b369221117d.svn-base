<?php

/**
 * ECSHOP 微信登录接口 上海睿风信息技术有限公司
 * ============================================================================
 * * 版权所有 2005-2012 上海商派网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.ecshop.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * $Author: jianguohua $
 * $Id: goods.php 17217 2011-01-19 06:29:08Z jianguohua $
 */


define('IN_ECS', true);

require('../init.php');
require_once(ROOT_PATH . 'includes/cls_json.php');
require_once(ROOT_PATH . 'api/token.php');

if (File_exists(ROOT_PATH . "config/config.php")) {
	require_once(ROOT_PATH . 'config/config.php');
}
$nick_name = isset($_REQUEST['nick_name'])? $_REQUEST['nick_name']:'';
$openId=isset($_REQUEST['openId'])? $_REQUEST['openId']:'';
$avatar = isset($_REQUEST['avatar'])? $_REQUEST['avatar']:'';
$username=isset($_REQUEST['openId'])? $_REQUEST['openId']:'';
if(empty($openId)) {
    $result = array("code"=>"400", 'data'=>'缺少必要的参数openId');
    exit(json_encode($result));
}
if (empty($_REQUEST['nick_name']) )
{
    $result = array("code"=>"401", 'data'=>'缺少必要的参数nick_name');
    exit(json_encode($result));
}
if (empty($_REQUEST['avatar']) )
{
    $result = array("code"=>"402", 'data'=>'缺少必要的参数avatar');
    exit(json_encode($result));
}
 $sql = "SELECT *  FROM " . $ecs->table('users') . " WHERE `openId`='" . $openId . "'";
 $userData = $db->getRow($sql);
 $password='111111';
 if($userData == false) {
 	 // 创建用户
 	 $result = $user->add_user($username, $password, $nick_name . "@qq.com");
 	 if ($result == false) {
 	 	 $sql = "select * from " .  $ecs->table('users') . " where user_name='". $username . "'";
 	 	 $userdata=  $db->getRow($sql);
 	 	 if (!empty($userdata['user_id']) ) {
 	 	 	 // 更新 nick_name ,头像等字段
 	 	 	 $token = md5($openId);
 	 	 	 $sql = "update " .  $ecs->table('users') . "set nick_name='" . $nick_name . "', avatar = '" . $avatar . "',openId='" . $openId . "' where user_id=" . $userdata['user_id'];
 	 	 	 $db->query($sql);
 	 	 } else {
 	 	 	 $result=array("code"=>"500", "msg"=>"创建用户失败");
 	 	 	 exit(json_encode($result));
 	 	 }
 	 	 //$result=array("code"=>"500", "msg"=>"创建用户失败2");
 	 	 //exit(json_encode($result));
 	 } else {
 	 	 // 获取刚刚创建的用户，更新头像，昵称等字段
 	 	 $sql = "select * from " .  $ecs->table('users') . " where user_name='". $username . "'";
 	 	 $userdata= $db->getRow($sql);
 	 	 if (!empty($userdata['user_id']) ) {
 	 	 	 // 更新 nick_name ,头像等字段
 	 	 	 $token = md5($openId);
 	 	 	 $sql = "update " .  $ecs->table('users') . "set nick_name='" . $nick_name . "', avatar = '" . $avatar . "',openId='" . $openId . "' where user_id=" . $userdata['user_id'];
 	 	 	 $db->query($sql);
 	 	 } else {
 	 	 //	 print_r($userdata);
 	 	 	 $Result=array("code"=>"500", "msg"=>"创建用户失败");
 	 	 	 exit(json_encode($Result));
 	 	 }
 	 }
 	 // 创建user_session 	
 	 $session_record = array();
 	 $session_record['user_id']= $userdata['user_id'];
 	 $session_record['token']= $token;
 	 $session_record['times']= 1;
 	 $session_record['login_time'] = time();
 	 $session_record['expires_time'] = time() + TOKEN_EXPIRE_DURATION; 
 	 $db->autoExecute($ecs->table('user_session'), $session_record,'INSERT');
 	 // 暂不处理注册送积分的情形, 交付之前需要处理
 	 //获取优惠券
 	 $sql = "select id from ecs_coupon where is_send = 1 and start_time <= now() and expiration_time >= now()";
 	 $coupon = $db->getAll($sql);
 	 foreach ($coupon as $v) {
 	 	$data1['user_id'] = $userdata['user_id'];
 	 	$data1['coupon_id'] = $v['id'];
 	 	$data1['card'] = time() . $userdata['user_id'] . $v['coupon_id'];
 	 	$data1['is_used'] = 0;
 	 	$data1['create_time'] = date('Y-m-d H:i:s');
 	 	$db->autoExecute('ecs_user_coupon', $data1, 'INSERT');
 	 }
 	// $user_info= array("nick_name"=>$nick_name, "avatar"=>$aavatar, "token"=>$token, "money"=>"0.00", "jifen"=>"0");
 	// $result=array("code"=>"101", "msg"=>"创建用户成功", "user_info"=>$user_info);
 	 //exit(json_encode($result));
 	 
 	// $result = array("code"=>"404", "msg"=>"无法找到该微信用户");
 	// exit(json_encode($result));
 	 $user_info =array("user_name"=>$username, "nick_name"=>$nick_name, "user_id"=>$userdata['user_id'],"token"=>$token);
 	 $result = array('code'=> '101', 'msg' => '登录成功' , "user_info"=>$user_info);
 	 die(json_encode($result));
 } else {
 	 $sql = "select * from " . $ecs->table('user_session') . " where user_id =" . $userData['user_id'];
	 $session = $db->getRow($sql);
	 $token=md5($openId . date("Y-M-D H:m:s"));
	 if($session == false ) {
	 	$session_record['user_id']= $userData['user_id'];
		$session_record['token']= $token;
		$session_record['times']= 1;
		$session_record['login_time']= time();
		$session_record['expire_time']= time() + TOKEN_EXPIRE_DURATION;
		$db->autoExecute($ecs->table("user_session"), $session_record, "INSERT");
		$result = array("user_id"=>$userData['user_id'], "token"=>$token, "times"=>1, "login_time"=> time(), "expires_time"=>(time() + TOKEN_EXPIRE_DURATION));
	 }else {
	 	 // 检查token是否快过期，如果是，更新token
	 	 $expires_time=$session['expires_time'];
	 	 if ($expires_time != false) {
	 	 	 if ($expires_time-time() < TOKEN_EXPIRE_CHECK_DURATION) {//如果token快过期则更新token和过期时间
	 	 	     // 更新session 表
	 	 	     $sql = "update " .  $ecs->table('user_session') . "set token='" . $token . "', login_time = '" .time(). "', expires_time='" .(time() + $expires_time). "', times='" .($session['times'] +1). "' where id=" . $session['id'];
	 	 	     $db->query($sql);
	 	 	 }else{//如果未到过期时间则更新token，不更新过期时间
	 	 	     // 更新session 表
	 	 	     $sql = "update " .  $ecs->table('user_session') . "set token='" . $token . "', login_time = '" .time(). "', times='" .($session['times'] +1). "' where id=" . $session['id'];
	 	 	     $db->query($sql);
	 	 	 }
	 	 }
	 $user_info =array("user_name"=>$username, "nick_name"=>$nick_name,"user_id"=>$userData['user_id'],"token"=>$token);
	 //检查是否是当天第一次登陆
	 check_first_login($userData['user_id']);
 	 $result = array('code'=> '101', 'msg' => '登录成功' , "user_info"=>$user_info);
 	 die(json_encode($result));
 	}
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
?>