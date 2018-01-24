<?php
/*************************refineit*****************************/
/**
 * 删除订单接口
*/

define('IN_ECS', true);

require_once('../init.php');
require_once('config/config.php');
require_once('../token.php');

$val = new stdClass();
$uid = isset($_POST['uid'])? $_POST['uid']:'';//用户id
$token = isset($_REQUEST['token'])? $_REQUEST['token']:'';
$thorder_id = isset($_POST['thorder_id'])? $_POST['thorder_id']:'';//订单id

if (empty($_POST['thorder_id']) || empty($_POST['uid']) || empty($_POST['token']))
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

$parent = array();

//删除订单
$sql = "DELETE FROM ecs_thorder_info WHERE id = '$thorder_id'";
$db->query($sql);
//删除退换货记录
$sql = "DELETE FROM ecs_delivery_order WHERE thorder_id = '$thorder_id'";
$db->query($sql);

$val = json_encode($val);
die($val);

?>