<?php
/*************************refineit*****************************/
/**
 * 完成订单接口
*/

define('IN_ECS', true);

require_once('../init.php');
require_once('config/config.php');
require_once('../token.php');
require_once('config/config.php');
require_once(ROOT_PATH . 'includes/cls_message.php');
require_once(ROOT_PATH . 'includes/cls_log.php');

$val = new stdClass();
$uid = isset($_POST['uid'])? $_POST['uid']:'';//设备id
$token = isset($_REQUEST['token'])? $_REQUEST['token']:'';
$order_id = isset($_POST['order_id'])? $_POST['order_id']:'';//订单id
$is_return = isset($_POST['is_return'])? $_POST['is_return']:'';//是否是退货,0：否，1：是
if (empty($_POST['order_id']) || empty($_POST['uid']) || empty($_POST['token']))
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
/*修改订单状态*/
$order_data['order_status'] = 1;
if ($is_return != 1) {
	$order_data['shipping_status'] = 2;
	$order_data['pay_status'] = 2;
	
	/* 记录发货信息 */
	$sql = "SELECT id, delivery_sn, company FROM ecs_delivery_order WHERE order_id = '$order_id' AND type = 1";
	$old_delivery_order1 = $GLOBALS['db']->getRow($sql);
	
	if ( !$old_delivery_order1 || $old_delivery_order1['id'] == null) {
		$val->code = 102;
		$val->msg = '此订单无法确认收货';
		die(json_encode($val));
	}
	$sql = "SELECT id FROM ecs_delivery_order WHERE order_id = '$order_id' AND type = 2";
	$old_delivery_order = $GLOBALS['db']->getRow($sql);
	
	$data['order_id'] = $order_id;
	//$data['remark'] = $_REQUEST['action_note'];
	$data['delivery_sn'] = $old_delivery_order1['delivery_sn'];
	$data['company'] = $old_delivery_order1['company'];
	$data['type'] = 2;
	$data['create_time'] = date('Y-m-d H:i:s');
	if ( !$old_delivery_order || $old_delivery_order['id'] == null) {
		$GLOBALS['db']->autoExecute('ecs_delivery_order', $data, 'INSERT');
	}
}
$db->autoExecute('ecs_order_info', $order_data, "UPDATE", "order_id = '$order_id'");

//推送信息
$msg = new ecs_message();
$sql = "SELECT order_sn FROM ecs_order_info WHERE order_id = '$order_id'";
$order_sn = $GLOBALS['db']->getOne($sql);
$msg->send($uid, 1, sprintf(order_msg2, $order_sn));

$val = json_encode($val);

die($val);

?>