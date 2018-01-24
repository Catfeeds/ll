<?php
/*************************refineit*****************************/
/**
 * 取消/删除预约接口
*/

define('IN_ECS', true);

require_once('../init.php');
require_once('../token.php');

$val = new stdClass();
$uid = isset($_POST['uid'])? $_POST['uid']:'';//设备id
$token = isset($_REQUEST['token'])? $_REQUEST['token']:'';
$id = isset($_POST['id'])? $_POST['id']:'';//预约id
$type = isset($_POST['type'])? $_POST['type']:'';//1：取消，2：删除

if (empty($_POST['uid']) || empty($_POST['token']) || empty($_POST['id']) || empty($_POST['type']))
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
//取消
if ($type == 1) {
	$data['state'] = 2;
	$db->autoExecute("ecs_appointment", $data, "UPDATE", "id = '$id'");
} 
//删除
else {
	$sql = "DELETE FROM ecs_appointment WHERE id = '$id'";
	$db->query($sql);
}

$val = json_encode($val);

die($val);

?>