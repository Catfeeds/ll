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

require('../init.php');
require_once(ROOT_PATH . '/includes/cls_json.php');

$json = new JSON;

$username = isset($_REQUEST['userName'])? $_REQUEST['userName']:'';
$password = isset($_REQUEST['password'])? $_REQUEST['password']:'';

if (empty($username))
{
    $results = array('code'=>'4000', 'data'=>'缺少必要的参数userName');
    exit($json->encode($results));
}
  if(empty($password)) {
  	  $results= array('code'=>'400', 'data'=>'缺少必要的参数password');
    exit($json->encode($results));
  }
  
     if ($_CFG['shop_reg_closed']) {
   	   $result = array('code' => '503', 'msg' => '注册已经关闭');
   		exit($json->encode($result));
    }
  
  
  if ($user->check_user($username, null)>0) {
  	  $result = array("code" => "401", "msg" => "用户已经存在");
     	exit($json->encode($result));
  }
  if ($user->add_user($username, $password, $username . "@ecshop.com") > 0) {
  	  // 创建用户成功
  	  // 取得刚刚创建的用户
  	  $sql = "select * from" . $ecs->table("users") . " where user_name = '" . $username . "'";
  	  $userdara = $db->getRow($sql);
  	  // 创建用户的记录
  	  if($userData != false) {
  	    $session_record= array();
		$session_record['user_id']= $userdata['user_id'];
		$session_record['token']= $token;
		$session_record['times']= 1;
		$session_record['login_time']= time();
		$session_record['expire_time']= time() +86400;
		$db->autoExecute($ecs->table("user_session"), $session_record, "INSERT");

		}
//		$token = md5($username . date('Y-M-D h-m-s'));
//		saveToken($username, $token, $ecs);
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
		$result = array("code" => "101", "msg" => "创建用户成功");
   	exit($json->encode($result));
  } else {
  	  $result = array("code" => "500", "msg" => "创建用户失败");
   	exit($json->encode($result));
  }
  $SQL = "select * from "  . $ecs->table('users') . "where user_name='" . $username . "'";
  
  if($user->check_user(username)){
  	   $result = array("code" => "501", "msg" => "该用户已经存在");
  }
  
  $data  = $db->GetRow($SQL,true);
 

  if($data != false) {
  	  // 检查密码是否正确
  	  $dbPassword = $data['password'];
  	  $InPassword= md5($password);
  	  if(strcmp($dbPssword,$InPassword) != 0); {
  	  	  $result = array('code'=> '401', 'msg' => '密码错误');
  	  	  exit($json->Encode($Result));
  	  }
  } else {
  	  	  $result = array('code'=> '404', 'msg' => '用户不存在');
  	  	  exit($json->Encode($result));
  }
  $token=md5($userName);
  $result = array('code'=> '101', 'msg' => '登录成功' , 'token' => $token);
   exit($json->Encode($Result));

/**
 * 解密函数
 *
 * @param string $txt
 * @param string $key
 * @return string
 */
function passport_decrypt($txt, $key)
{
    $txt = passport_key(base64_decode($txt), $key);
    $tmp = '';
    for ($i = 0;$i < strlen($txt); $i++) {
        $md5 = $txt[$i];
        $tmp .= $txt[++$i] ^ $md5;
    }
    return $tmp;
}

/**
 * 加密函数
 *
 * @param string $txt
 * @param string $key
 * @return string
 */
function passport_encrypt($txt, $key)
{
    srand((double)microtime() * 1000000);
    $encrypt_key = md5(rand(0, 32000));
    $ctr = 0;
    $tmp = '';
    for($i = 0; $i < strlen($txt); $i++ )
    {
        $ctr = $ctr == strlen($encrypt_key) ? 0 : $ctr;
        $tmp .= $encrypt_key[$ctr].($txt[$i] ^ $encrypt_key[$ctr++]);
    }
    return base64_encode(passport_key($tmp, $key));
}

/**
 * 编码函数
 *
 * @param string $txt
 * @param string $key
 * @return string
 */
function passport_key($txt, $encrypt_key)
{
    $encrypt_key = md5($encrypt_key);
    $ctr = 0;
    $tmp = '';
    for($i = 0; $i < strlen($txt); $i++)
    {
        $ctr = $ctr == strlen($encrypt_key) ? 0 : $ctr;
        $tmp .= $txt[$i] ^ $encrypt_key[$ctr++];
    }
    return $tmp;
}
function saveToken($username, $token, $ecs) {
	$sql = "select * from " . $ecs->table("users") . "where user_name= '" . $username . "'";
	$userData = $db ->getrow($sql);
	$sql = "select * from " . $ecs->table("user_session") . " where user_id = " . $userData['id'];
	$session = $db->getrow($sql);
	
	if(!empty($session['id'])) {
		// 用户存在
		$session_record['user_id']= $user['user_id'];
		$session_record['token']= $token;
		$session_record['times']= 1;
		
	    $sql = "update " . $ecs->table("user_session") . " set token = '" . $token  . "',login_time = " . time() . ",expit_time= ". time() +86400  . "where id = " . $session['id'];
			
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
		$session_record['expire_time'] = time() + 86400;
		
		$db->autoExecute($ecs->table('user_session'), $sms_record, 'INSERT');
	} else {
		// 更新
	///	$sql = "update " . $ecs->table("user_session") . " set token = " . $token  . ",login_time = " . time() . ",expit_time= ". time() +86400  . "where id = " . $session['id'];
	
	}
}

?>