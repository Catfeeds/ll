<?php

/**
 * ECSHOP 验证码接口 用于取得和校验验证码 上海睿风
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
require_once(ROOT_PATH . 'includes/cls_json.php');
require_once('../sendsms.php');
require('../sendmail.php');
if (File_exists(ROOT_PATH . "config/config.php")) {
	require_once(ROOT_PATH . 'config/config.php');
}
$json = new JSON;


$action = isset($_REQUEST['action'])? $_REQUEST['action']:'';
$type = isset($_REQUEST['type'])? $_REQUEST['type']:'';
$email = isset($_REQUEST['email'])? $_REQUEST['email']:'';
$sms_code = isset($_REQUEST['code'])? $_REQUEST['code']:'';

$userName = isset($_REQUEST['phone'])? $_REQUEST['phone']:'';
if(empty($action) ) {
	$results = array('code'=>'400', 'msg'=>'缺少必要的参数action');
    exit($json->encode($results));
} 
if(empty($type) ) {
    $results = array('code'=>'400', 'msg'=>'缺少必要的参数type');
    exit($json->encode($results));
}
/*
 $SQL = "select * from " . $ecs->table("users") . "where user_name= '" . $userName . "'";
 $query = $db->getOne($SQL);
 	 print_r($query);
 if(!empty($query['user_id'])) {
 	 // 用户不存在ry()
 //	 $results = array('result'=>'false', 'data'=>'用户不存在');*
   //  exit($json->encode($results));
	 echo "userid is '" . $query['user_id'] . "'";
	 $sql = "select `id`,`user_id`, `token`, `times`, FROM " .$ecs->table("user_session") . "where user_id=" . $query['user_id'];
	 $query2 = $db->getOne($sql);
	 if ($query2 != false) {
	 	 $times = $query2['times'];
	 	 $times += 1;
	 	 $where = "where id=". $query2['id'];
	 	  $Session = array('user_id'=>$query['user_id'], 'token'=>$token,  'times' => $times, 'login_time'=>time(), 'expires_time'=>time() + 86400);
	 	  // update
	 	  
	 } else {
	 	 
	 }  // empty
*/
	switch ($action)
	{
	    case 'get_sms_code':
	    {
	    	$code = "";
	    	
	    	$base = '1234567890';
	    	for($loop = 0 ; $loop < 6; $loop++) {
	    	    $num = mt_rand(0,9);
	    	//    echo "loop is "  . $loop . ", rand is " . $num;
	    	    $code .= $base[$num];
	    	}
			// 保存验证码
	//		 $mem = new Memcache;
	 //        $mem->connect($memcache_host,$memcache_port);
	 //        $mem->set($phone . "_code", $code, 0, 15 * 60); // 15分钟之内有效
			
	//		$results = array('result'=>'true', 'msg'=>'成功', 'code'=>$code);
	    	$email = urldecode($email);
		  	$sms_record= array();
		    $sms_record['code']  = $code;
		    if(($type==1)||($type==2)||($type==3)){
		        $sms_record['phone'] = $userName;
		    }else{
		        $sms_record['phone'] = $email;
		    }
		  	

	        /* 添加到sms_code 表里面*/
	        $db->autoExecute($ecs->table('sms_code'), $sms_record, 'INSERT');
			$results=array();
			
			$results['']= true;
			$results['code']= '101';
			$results['msg']= 'Success';
			$results['sms_code']= '';
			$datas [] = $code;
			if($type==1){//注册发短信
			    $tempId=tempId;
			}
			if($type==2){//找回密码发短信
			    $tempId=tempId2;
			}
			if($type==3){//绑定手机发短信
			    $tempId=tempId3;
			}
//			if($type == 6){//提现验证手机短信
//				$tempId=tempId3;
//			}

			if(($type==1)||($type==2)||($type==3)){
			    $res = sendTemplateSMS($userName,$datas,$tempId);
			    $log->debug("testSingleMt:  $res");
			}
			if(($type==4)||($type==5)){
			    $res = sendmail($email,$code,$type);
			    $log->debug("test_email_res:  $res");
			    $log->debug($email);
			    if($res==101){
			        $results['code']= '101';
			        $results['msg']= 'Success';
			    }else{
			        $results = array('code'=>'102', 'msg'=>'邮箱验证码发送失败，请检查邮箱格式是否有误');
			    }
			}
	        exit($json->encode($results));
	        break;
	    }
	    case 'verify':
	    {
	    	if(empty($sms_code) ) {
				$results = array('code'=>'400', 'msg'=>'缺少必要的参数code');
	    		exit($json->encode($results));
	    	}
	    	if(($type==1)||($type==2)||($type==3)){
	    	    $SQL = "select * from " . $ecs->table("sms_code") . " where phone ='". $userName  . "' order by sent_Time desc limit 1";
	    	}
	    	if(($type==4)||($type==5)){
	    	    $SQL = "select * from " . $ecs->table("sms_code") . " where phone ='". $email  . "' order by sent_Time desc limit 1";
	    	}  
	    	$query = $db->getRow($SQL);
	        if ($query['code'] != $sms_code) {
	    	     $results = array('code'=>'400', 'msg'=>'验证码错误');
	    	     exit($json->encode($results));
	    	}
	        $results = array('code'=> '101','result' => 'true', 'data' => array());
	       // $sql = "SELECT `code` FROM " . $ecs->table('sms_code') . " WHERE phone=$phone";
	       // $shop_name = $db->getOne($sql);
	        exit($json->encode($results));
	        break;
	    }
	    default:
	    {
	        $results = array('code'=>'400', 'msg'=>'缺少参数action');
	        exit(json_encode($results));
	        break;
	    }
	}
?>