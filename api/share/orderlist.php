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
$source = isset ( $_REQUEST ['source'] ) ? $_REQUEST ['source'] : '';

if (empty ( $_POST ['page_index'] ) || empty ( $_POST ['page_size'] ) || empty ( $_POST ['token'] ) || empty ( $_POST ['source'] ) || empty ( $_POST ['unid'] )) {
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

$sql = "select order_id,goods_id,goods_name,goods_thumb,unid,goods_price as goods_amount,goods_number as nums from ecs_order_goods where tdgood_type = 0 and source = '$source'";
$sql .= " order by rec_id desc";
$pageID = ($page_index - 1);
if ($pageID < 0) {
	$pageID = 0;
}
$pageID = $pageID * $page_size;
$sql .= " LIMIT $page_size OFFSET $pageID";
$orderlist = $db->getAll ( $sql );

foreach ( $orderlist as $k => $v ) {
	$sql = "select order_sn,order_status,pay_status,add_time from ecs_order_info where order_id = '{$v['order_id']}'";
	$info = $db->getRow ( $sql );
	
	$orderlist [$k] ['order_sn'] = $info ['order_sn'];
	$orderlist [$k] ['order_status'] = $info ['order_status'];
	$orderlist [$k] ['pay_status'] = $info ['pay_status'];
	$orderlist [$k] ['add_time'] = $info ['add_time'];
}

$val->orderlist = $orderlist;
$val = json_encode ( $val );

die ( $val );

?>