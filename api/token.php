<?php

/**
 * ECSHOP API 公用初始化文件
 * ============================================================================
 * * 版权所有 2005-2012 上海商派网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.ecshop.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * $Author: liubo $
 * $Id: init.php 17217 2011-01-19 06:29:08Z liubo $
*/

if (!defined('IN_ECS'))
{
    die('Hacking attempt');
}

error_reporting(E_ALL);

if (__FILE__ == '')
{
    die('Fatal error code: 0');
}



if (file_exists(ROOT_PATH . 'data/config.php'))
{
    require_once(ROOT_PATH . 'data/config.php');
}

require_once(ROOT_PATH . 'config/config.php');

if (defined('DEBUG_MODE') == false)
{
    define('DEBUG_MODE', 0);
}

if (PHP_VERSION >= '5.1' && !empty($timezone))
{
    date_default_timezone_set($timezone);
}


function check_token($token, $sql, $db, $ecs) {
	
	$session = $db -> getRow($sql);
//	echo "sesion user_id is ". $session['user_id'];
	if($session == false) {
		// token 不存在
		$result = array("code" => "404", "msg"=> "token不存在");
		return $result;
	} else {
		// 检查过期时间
		$expire = $session["expires_time"];
		$currentTime = time();
		if($currentTime > $expire) {
			// Token  已过期
			$result = array("code" => "404", "msg"=> "token已过期");
			return $result;
		}
		// 判断token 是否快过期
		/* if(($expire - $currentTime) < TOKEN_EXPIRE_CHECK_DURATION) {
			$new_token = md5($session["user_id"] . date("Y-m-d h-m-s"));
			// 更新token
			$sql = "update " . $ecs->table("user_session") . " set token ='" . $new_token  . "',login_time = " . time()  . ",times=". ($session['times'] + 1) . ",expires_time= ". (time() + 3600 * 24)  . " where id = " . $session['id'] . "";
	
			$db->query($sql);
			
				$result = array("code"=>"101", "msg"=>"token更新", "uid"=>$session['user_id'], "token"=>$new_token);
		
			return $result;
		} */
		
		// 检查通过
		$result = array("code"=>"101", "msg"=>"检查通过", "uid"=>$session['user_id']);
		return $result;
	}
}

?>