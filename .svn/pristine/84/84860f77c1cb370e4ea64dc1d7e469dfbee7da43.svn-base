<?php
/*************************refineit*****************************/
/**
 * 删除消息接口
*/

define('IN_ECS', true);

require_once('../init.php');
require_once('../token.php');

$val = new stdClass();
$uid = isset($_POST['uid'])? $_POST['uid']:'';
$id = isset($_POST['id'])? $_POST['id']:'';
$token = isset($_POST['token'])? $_POST['token']:'';
if (empty($_POST['id']) || empty($_POST['token']) || empty($_POST['uid']))
{
    $val->code = 201;
	$val->msg = '缺少必要的参数';
	die(json_encode($val));
}
//token
$sql = "select * from" . $ecs->table("user_session") . "where token = '" . $token . "'";
$result = check_token($token, $sql, $db, $ecs);
if($result['code'] == "101")
{
	if(!empty($result['uid'])) {
		if(strcmp($result['uid'], $uid) != 0) {
			$result = array("code"=> "400", "msg"=> "该token不属于用户" . $uid);
			die(json_encode($result));
		}
	} else {
		echo "check token rerurn empty uid";
	}
} else {
	die(json_encode($result));
}

$val->code = 101;
$val->msg = '操作成功';
//$val->token = $token['token'];
/*获取钱包详情*/
$sql = "delete from ecs_message where id = '$id'";
$db->query($sql);

$val = json_encode($val);

die($val);

?>