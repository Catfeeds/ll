<?php
/*************************refineit*****************************/
/**
 * 预约接口
*/

define('IN_ECS', true);

require_once('../init.php');
require_once('../token.php');

$val = new stdClass();
$uid = isset($_POST['uid'])? $_POST['uid']:'';//设备id
$token = isset($_REQUEST['token'])? $_REQUEST['token']:'';
$id = isset($_POST['id'])? $_POST['id']:'';//服务id
$app_time = isset($_POST['app_time'])? $_POST['app_time']:'';//预约时间
$size = isset($_POST['size'])? $_POST['size']:'';//鞋码s
$contact = isset($_POST['contact'])? $_POST['contact']:'';//姓名
$mobile = isset($_POST['mobile'])? $_POST['mobile']:'';//手机号
$claim = isset($_POST['claim'])? $_POST['claim']:'';//其他要求
$type = isset($_POST['type'])? $_POST['type']:'';//预约类型

if (empty($_POST['uid']) || empty($_POST['token']) || empty($_POST['id']) || empty($_POST['app_time']) || empty($_POST['size']) || empty($_POST['contact']) || empty($_POST['mobile']) || empty($_POST['type']))
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
//预约
$data['ser_id'] = $id;
$data['contact'] = $contact;
$data['mobile'] = $mobile;
$data['size'] = $size;
if (!empty($claim)) {
	$data['claim'] = $claim;
}
$data['app_time'] = $app_time;
$data['state'] = 0;
$data['type'] = $type;
$data['user_id'] = $uid;
$data['create_time'] = date('Y-m-d H:i:s');
$db->autoExecute("ecs_appointment", $data, "INSERT");
$val->id = mysql_insert_id();

$val = json_encode($val);

die($val);

?>