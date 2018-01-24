<?php
/*************************refineit*****************************/
/**
 *退换货 订单详情接口
*/

define('IN_ECS', true);

require_once('../init.php');
require_once('config/config.php');
require_once('../token.php');

$val = new stdClass();
$uid = isset($_POST['uid'])? $_POST['uid']:'';//用户id
$token = isset($_REQUEST['token'])? $_REQUEST['token']:'';
$thorder_id = isset($_POST['thorder_id'])? $_POST['thorder_id']:'';//退换货订单id
$rec_id = isset($_POST['rec_id'])? $_POST['rec_id']:'';//订单商品表编号id

if (empty($_POST['uid']) || empty($_POST['thorder_id']) || empty($_POST['rec_id']) || empty($_POST['token']))
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
//查询退换货订单表中的信息
$sql = "select id as thorder_id,order_id,order_type,thorder_sn,rec_id,tuihuan_state,chuli,address,user,phone from ecs_thorder_info where id = '$thorder_id'";
$order = $db->getRow($sql);
//查询对应商品的信息
$sql = "select  goods_name,goods_price,color_img,size,goods_thumb,goods_type,cus_id,tdgood_question from ecs_order_goods where rec_id = '$rec_id'";
$goods = $db->getRow($sql);

$order['goods_name'] = $goods['goods_name'];
$order['goods_price'] = $goods['goods_price'];
$order['goods_thumb'] = $goods['goods_thumb'];
$order['goods_type'] = $goods['goods_type'];
$order['tdgood_question'] = $goods['tdgood_question'];
if ($goods['cus_id'] != 0) {
    $sql = "select cp.img from ecs_customize as c left join ecs_cus_parameter as cp on cp.id = c.color_id where c.id = '{$goods['cus_id']}'";
    $order['color_img'] = $db->getOne($sql);
    $sql = "select size from ecs_user_info where user_id = '$uid'";
    $order['size'] = $db->getOne($sql);
} else {
    $order['color_img'] = $goods['color_img'];
    $order['size'] = $goods['size'];
}
//查询问题描述图册
$sql = "select img from ecs_thgood_icon where thgood_id = '$rec_id'";
$iconlist = $db->getAll($sql);
if(!empty($iconlist)){
    $order['tdgood_iconlist'] = $iconlist;
}else{
    $order['tdgood_iconlist'] = '';
}
$sql = "select id,company,delivery_sn from ecs_delivery_order where thorder_id = '$thorder_id' ";
$delivery = $db->getRow($sql);
$order['company'] = $delivery['company'];
$order['delivery_sn'] = $delivery['delivery_sn'];

$val->order = $order;
$val = json_encode($val);

die($val);

?>