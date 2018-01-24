<?php
/*************************refineit*****************************/
/**
 * 订单列表接口
 */
define ( 'IN_ECS', true );

require_once ('../init.php');
require_once ('config/config.php');
require_once ('../token.php');

$val = new stdClass ();
$token = isset ( $_REQUEST ['token'] ) ? $_REQUEST ['token'] : '';
$page_index = isset ( $_POST ['page_index'] ) ? $_POST ['page_index'] : '';
$page_size = isset ( $_POST ['page_size'] ) ? $_POST ['page_size'] : '';

if (empty ( $_POST ['page_index'] ) || empty ( $_POST ['page_size'] ) || empty ( $_POST ['token'] )) {
	$val->code = 201;
	$val->msg = '缺少必要的参数';
	die ( json_encode ( $val ) );
}
// token
if (md5($token) != Token) {
	$val->code = 102;
	$val->msg = 'Token错误';
	die ( json_encode ( $val ) );
}


$val->code = 101;
$val->msg = '操作成功';

$sql = "select eoi.order_id,eoi.order_type,eoi.user_id,eoi.ziti_nums, eoi.order_sn, eoi.order_status, eoi.shipping_status, eoi.pay_status, eoi.province, eoi.city, eoi.district, eoi.consignee, eoi.address, eoi.mobile, eoi.goods_amount, eoi.pay_name, eoi.shipping_fee, eoi.rebate_money, eoi.rebate_points, eoi.add_time from ecs_order_info as eoi left join ecs_order_address as eoa on eoa.id = eoi.ziti_address";
$sql .= " order by eoi.order_id desc";
$pageID = ($page_index - 1);
if ($pageID < 0) {
	$pageID = 0;
}
$pageID = $pageID * $page_size;
$sql .= " LIMIT $page_size OFFSET $pageID";
$order1 = $db->getAll ( $sql );

foreach ( $order1 as $k => $v ) {
	$sql = "select goods_id, goods_name, goods_number, color_img, size, goods_thumb, cus_id from ecs_order_goods where order_id = {$v['order_id']}";
	$goods = $db->getRow ( $sql );
	
	$order1 [$k] ['goods_id'] = $goods ['goods_id'];
	$order1 [$k] ['goods_name'] = $goods ['goods_name'];
	$order1 [$k] ['goods_number'] = $goods ['goods_number'];
	$order1 [$k] ['goods_thumb'] = $goods ['goods_thumb'];
	// 查询是否有未退换货的商品
	$sql = "select count(goods_id) as nums from ecs_order_goods where order_id = {$v['order_id']} and tdgood_type=0";
	$thnums = $db->getRow ( $sql );
	if ($thnums ['nums'] > 0) {
		$order1 [$k] ['isbutton'] = 1;
	} else {
		$order1 [$k] ['isbutton'] = 0;
	}
	if ($goods ['cus_id'] != 0) {
		$sql = "select cp.img from ecs_customize as c left join ecs_cus_color as cp on cp.id = c.color_id where c.id = '{$goods['cus_id']}'";
		$order1 [$k] ['color_img'] = $db->getOne ( $sql );
		$sql = "select size from ecs_user_info where user_id = '{$v['user_id']}'";
		$order1 [$k] ['size'] = $db->getOne ( $sql );
	} else {
		$order1 [$k] ['color_img'] = $goods ['color_img'];
		$order1 [$k] ['size'] = $goods ['size'];
	}
}
$val->order = $order1;
$val = json_encode ( $val );

die ( $val );

?>