<?php
/*************************refineit*****************************/
/**
 * 快递进度信息接口
*/

define('IN_ECS', true);

require_once('../init.php');
require_once('config/config.php');
require_once('../token.php');

$val = new stdClass();
$uid = isset($_POST['uid'])? $_POST['uid']:'';//设备id
$token = isset($_REQUEST['token'])? $_REQUEST['token']:'';
$order_id = isset($_POST['order_id'])? $_POST['order_id']:'';

if (empty($_POST['uid']) || empty($_POST['order_id']) || empty($_POST['token']))
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


$sql = "select add_time, shipping_status from ecs_order_info where order_id = '$order_id'";
$order = $db->getRow($sql);

$sql = "select * from ecs_delivery_order where order_id = '$order_id'";
$shippment = $db->getAll($sql);

$shipinfo = array();
$shipinfo['shipping_status'] = $order['shipping_status'];//发货状态
$shipinfo['setout_time'] = date('Y-m-d H:i:s', $order['add_time']);//准备时间
foreach ($shippment as $v) {
	if ($v['type'] == 1) {
		$shipinfo['send_time'] = $v['create_time'];//发货时间
	} else if ($v['type'] == 2) {
		$shipinfo['finish_time'] = $v['create_time'];//确认收货时间
	}
	$shipinfo['company'] = $v['company'];//快递公司
	$shipinfo['delivery_sn'] = $v['delivery_sn'];//快递单号
}

$val->shipinfo = $shipinfo;
$val = json_encode($val);

die($val);

?>