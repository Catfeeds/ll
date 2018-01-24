<?php
/*************************refineit*****************************/
/**
 * 取消订单接口
*/

define('IN_ECS', true);

require_once('../init.php');
require_once('config/config.php');
require_once('../token.php');

$val = new stdClass();
$uid = isset($_POST['uid'])? $_POST['uid']:'';//设备id
$token = isset($_REQUEST['token'])? $_REQUEST['token']:'';
$order_id = isset($_POST['order_id'])? $_POST['order_id']:'';//订单id
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
$order_data['order_status'] = 2;
$db->autoExecute('ecs_order_info', $order_data, "UPDATE", "order_id = '$order_id'");
/*查询订单商品*/
$sql = "SELECT province_id, goods_number FROM ecs_order_goods WHERE order_id = '$order_id'";
$goods_list = $db->getAll($sql);
/*增加商品库存*/
foreach ($goods_list as $k=>$v) {
	$sql = "SELECT nums FROM ecs_spec_goods WHERE id = '{$v['province_id']}'";
	$province = $db->getRow($sql);
	if (!empty($province)) {
		$parent['nums'] = $province['nums'] + $v['goods_number'];
		$db->autoExecute('ecs_spec_goods', $parent, "UPDATE", "id = '{$v['province_id']}'");
	}
}

$val = json_encode($val);

die($val);

?>