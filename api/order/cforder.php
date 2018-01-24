<?php
/*************************refineit*****************************/
/**
 * 确认订单接口
*/

define('IN_ECS', true);

require_once('../init.php');
require_once('config/config.php');
require_once('../token.php');

$val = new stdClass();
$uid = isset($_POST['uid'])? $_POST['uid']:'';
$token = isset($_REQUEST['token'])? $_REQUEST['token']:'';
$order_id = isset($_POST['order_id'])? $_POST['order_id']:'';//订单id
$address_id = isset($_POST['address_id'])? $_POST['address_id']:'';//收货id
$coupon_id = isset($_POST['coupon_id'])? $_POST['coupon_id']:'';//优惠券id
$rebate = isset($_POST['rebate'])? $_POST['rebate']:'';//使用返利
$points = isset($_POST['points'])? $_POST['points']:'';//使用积分
$pay_money = isset($_POST['pay_money'])? $_POST['pay_money']:'';//支付金额
$clientUUID = isset($_POST['clientUUID'])? $_POST['clientUUID']:'';//设备id
$pay_name = isset($_POST['pay_name'])? $_POST['pay_name']:'';//支付方式

if (empty($_POST['order_id']) || empty($_POST['uid']) || empty($_POST['address_id']) || empty($_POST['pay_name']) || empty($_POST['token']))
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

/*查询订单是否过期*/
$sql = "select order_status from ecs_order_info where order_id = $order_id";
$order_status = $db->getOne($sql);
if ($order_status == 2) {
	$val->code = 102;
	$val->msg = '该订单已过期取消，无法支付';
}

$parent = array();
/*查询库存*/
$sql = "select goods_id,size,goods_type,goods_number,cus_id from ecs_order_goods where order_id = '$order_id'";
$goods_list = $db->getAll($sql);
foreach ($goods_list as $k=>$v) {
	//产品
	$sql = "SELECT goods_id, goods_name, is_on_sale, goods_type, goods_thumb".
			" FROM ecs_goods".
			" WHERE goods_id = {$v['goods_id']}";
	$goods = $db->getRow($sql);
	if ($v['cus_id'] == 0) {
		//库存
		$sql = "SELECT g.id, g.nums ".
				" FROM ecs_spec_goods AS g".
				" LEFT JOIN ecs_specification ON ecs_specification.id = g.spec_id".
				" WHERE g.goods_id = {$goods['goods_id']} AND ecs_specification.value = '{$v['size']}' AND g.type = '{$v['goods_type']}'";
		$product = $db->getRow($sql);
		
		/* 减少库存 */
		$prodate = array();
		$prodate['nums'] = $product['nums'] - $v['goods_number'];
		$db->autoExecute('ecs_spec_goods', $prodate, "UPDATE", "id = {$product['id']}");
	}
}
$sql = "select * from ecs_order_info where order_id = $order_id";
$order_info = $db->getRow($sql);
if($order_info['order_type']==2){//送货上门
    /*收货地址*/
    $sql = "select * from ecs_user_address where address_id = '$address_id'";
    $address = $db->getRow($sql);
    $parent['consignee'] = $address['consignee'];
    $parent['province'] = $address['province'];
    $parent['city'] = $address['city'];
    $parent['district'] = $address['district'];
    $parent['province'] = $address['province'];
    $parent['address'] = $address['address'];
    $parent['zipcode'] = $address['zipcode'];
    $parent['mobile'] = $address['mobile'];
}
if($order_info['order_type']==1){//自提
    $parent['ziti_address'] = $address_id;
}
$parent['user_coupon_id'] = $coupon_id;//优惠券id
$parent['rebate'] = $rebate;
$parent['points'] = $points;
$parent['pay_fee'] = $pay_money;
$parent['is_cf'] = 1;
$parent['pay_name'] = $pay_name;

$db->autoExecute('ecs_order_info', $parent, "UPDATE", "order_id = '$order_id'");

$sql = "SELECT order_sn FROM ecs_order_info WHERE order_id = '$order_id'";
$order = $db->getRow($sql);
$val->order_sn = $order['order_sn'];

$val = json_encode($val);
die($val);

?>