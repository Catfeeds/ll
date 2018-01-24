<?php
/*************************refineit*****************************/
/**
 * 测量接口
*/

define('IN_ECS', true);

require_once('../init.php');
require_once('../token.php');

$val = new stdClass();
$uid = isset($_POST['uid'])? $_POST['uid']:'';//设备id
$token = isset($_REQUEST['token'])? $_REQUEST['token']:'';
$size = isset($_POST['size'])? $_POST['size']:'';//鞋码
$type = isset($_POST['type'])? $_POST['type']:'';//尺码类型，0：中国尺码，1：美国尺码
$style = isset($_POST['style'])? $_POST['style']:'';//鞋型
$clothes = isset($_POST['clothes'])? $_POST['clothes']:'';//穿衣习惯

if (empty($_POST['uid']) || empty($_POST['token']) || empty($_POST['size']) || !isset($_POST['type']) || empty($_POST['style']) || empty($_POST['clothes']))
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
//测量
$sql = "SELECT id FROM ecs_user_info WHERE user_id = '$uid'";
$user_info = $db->getOne($sql);

if ( !$user_info || $user_info == null ) {
	$data['user_id'] = $uid;
	$data['size'] = $size;
	$data['type'] = $type;
	$data['style'] = $style;
	$data['clothes'] = $clothes;
	$data['create_time'] = date('Y-m-d H:i:s');
	$db->autoExecute("ecs_user_info", $data, "INSERT");
} else {
	$data['user_id'] = $uid;
	$data['size'] = $size;
	$data['type'] = $type;
	$data['style'] = $style;
	$data['clothes'] = $clothes;
	$data['create_time'] = date('Y-m-d H:i:s');
	$db->autoExecute("ecs_user_info", $data, "UPDATE", "id = '$user_info'");
}

$val = json_encode($val);

die($val);

?>