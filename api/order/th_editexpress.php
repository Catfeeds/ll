<?php
/*************************refineit*****************************/
/**
 * 修改退换货快递信息接口
*/

define('IN_ECS', true);

require_once('../init.php');
require_once('config/config.php');
require_once('../token.php');

$val = new stdClass();
$uid = isset($_POST['uid'])? $_POST['uid']:'';//用户id
$token = isset($_REQUEST['token'])? $_REQUEST['token']:'';
$thorder_id = isset($_POST['thorder_id'])? $_POST['thorder_id']:'';//退换货订单id
$company = isset($_POST['company'])? $_POST['company']:'';//快递公司
$delivery_sn = isset($_POST['delivery_sn'])? $_POST['delivery_sn']:'';//快递单号

if (empty($_POST['uid']) || empty($_POST['thorder_id']) || empty($_POST['company']) || empty($_POST['delivery_sn']) || empty($_POST['token']))
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
/* 修改退换货订单审核记录表 */
$parent = array();
$parent['company'] = $company;
$parent['delivery_sn'] = $delivery_sn;
$parent['type'] = 2;
$db->autoExecute('ecs_delivery_order', $parent, "UPDATE", "thorder_id = '$thorder_id'");
$val = json_encode($val);
die($val);

?>