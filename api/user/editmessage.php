<?php
/*************************refineit*****************************/
/**
 * 修改消息状态接口
*/

define('IN_ECS', true);

require_once('../init.php');
require_once('../token.php');

$val = new stdClass();
$uid = isset($_POST['uid'])? $_POST['uid']:'';
$id = isset($_POST['id'])? $_POST['id']:'';
$token = isset($_REQUEST['token'])? $_REQUEST['token']:'';
if (empty($_POST['uid']) || empty($_POST['token']))
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

$parent['state'] = 1;
if (empty($_POST['id'])) {
	$db->autoExecute('ecs_message', $parent, "UPDATE", "to_userid = '$uid'");
} else {
	$db->autoExecute('ecs_message', $parent, "UPDATE", "id = '$id'");
}

die(json_encode($val));

?>