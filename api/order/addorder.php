<?php
/*************************refineit*****************************/
/**
 * 添加订单接口
 */
define ( 'IN_ECS', true );

require_once ('../init.php');
require_once ('config/config.php');
require_once ('../token.php');

$val = new stdClass ();
$uid = isset ( $_POST ['uid'] ) ? $_POST ['uid'] : ''; // 设备id
$token = isset ( $_REQUEST ['token'] ) ? $_REQUEST ['token'] : '';
$clientUUID = isset ( $_POST ['clientUUID'] ) ? $_POST ['clientUUID'] : ''; // 设备id
$order_type = isset ( $_POST ['order_type'] ) ? $_POST ['order_type'] : 0;
if (empty ( $_POST ['clientUUID'] ) || empty ( $_POST ['uid'] ) || empty ( $_POST ['token'] )) {
	$val->code = 201;
	$val->msg = '缺少必要的参数';
	die ( json_encode ( $val ) );
}

/* if ($order_type == 1) {
	if (empty ( $_POST ['address'] )) {
		$val->code = 201;
		$val->msg = '缺少必要的参数';
		die ( json_encode ( $val ) );
	}
} */

// token
$sql = "select * from" . $ecs->table ( "user_session" ) . "where token = '" . $token . "'";
$result = check_token ( $token, $sql, $db, $ecs );
if ($result ['code'] == "101") {
	if (! empty ( $result ['uid'] )) {
		if (strcmp ( $result ['uid'], $uid ) != 0) {
			$result = array (
					"code" => "400",
					"msg" => "该token不属于用户" . $uid 
			);
			die ( json_encode ( $result ) );
		}
	} else {
		echo "check token rerurn empty uid";
	}
} else {
	die ( json_encode ( $result ) );
}

$val->code = 101;
$val->msg = '操作成功';
/* 获取购物车详情 */
$sql = "select ecs_cart.rec_id as cart_id,ecs_cart.unid,ecs_cart.type,ecs_goods.goods_id,ecs_goods.goods_name,ecs_goods.goods_thumb,ecs_goods.shop_price,ecs_goods.market_price,ecs_color.img as color_img,ecs_cart.goods_number,ecs_cart.size,ecs_cart.cus_id,ecs_cart.source,ecs_cart.mold" . " from ecs_cart left join ecs_goods on ecs_goods.goods_id = ecs_cart.goods_id" . " left join ecs_color on ecs_color.id = ecs_goods.color_id" . " where ecs_cart.session_id = '$clientUUID' and is_del = 0";
$cart_info = $GLOBALS ['db']->getAll ( $sql );
if (empty ( $cart_info )) {
	$val->code = 105;
	$val->msg = '购物车中没有商品';
	die ( json_encode ( $val ) );
}
$goods_amount = 0; // 总价
/* 获取商品列表 */
foreach ( $cart_info as $k => $v ) {
	$sql = "SELECT goods_id, goods_name, is_on_sale, goods_type" . " FROM ecs_goods" . " WHERE goods_id = {$v['goods_id']}";
	$goods = $db->getRow ( $sql );
	if (! $goods) {
		$val->code = 102;
		$val->msg = '该商品不存在';
		die ( json_encode ( $val ) );
	}
	if ($goods ['is_on_sale'] == 0) {
		$val->code = 103;
		$val->msg = $goods ['goods_name'] . '未开放购买';
		die ( json_encode ( $val ) );
	}
	if ($v ['cus_id'] == 0) {
		/* 检查：库存 */
		$sql = "SELECT g.id, g.nums " . " FROM ecs_spec_goods AS g" . " LEFT JOIN ecs_specification ON ecs_specification.id = g.spec_id" . " WHERE g.goods_id = {$goods['goods_id']} AND ecs_specification.value = '{$v['size']}' AND g.type = '{$v['type']}'";
		$product = $db->getRow ( $sql );
		if (empty ( $product )) {
			$val->code = 104;
			$val->msg = $goods ['goods_name'] . '库存数量不足';
			die ( json_encode ( $val ) );
		}
		if ($v ['goods_number'] > $product ['nums']) {
			$val->code = 104;
			$val->msg = $goods ['goods_name'] . '库存数量不足';
			die ( json_encode ( $val ) );
		}
	}
	
	$goods_amount += $v ['shop_price'];
}
if ($order_type == 2) {
    /* 获取默认收货地址 */
    $sql = "select address_id, consignee, province, city, district, address, zipcode, mobile from ecs_user_address where user_id = '$uid' and is_default = 1";
    $address = $db->getRow ( $sql );
    // 配送费用
    if ($goods_amount >= PINKAGE) {
        $shipping_fee = 0;
        $pay_fee = $goods_amount;
    } else {
        $shipping_fee = POSTAGE;
        $pay_fee = $goods_amount + $shipping_fee;
    } 
}
if ($order_type == 1) { // 自提，产生自提码
	$ziti_nums = $uid . time ();
	$val->ziti_nums = $ziti_nums;
	$shipping_fee = 0;
	$pay_fee = $goods_amount;
	$address='';
} else {
	$ziti_nums = '';
}
// 添加ecs_order_info表
$order_data = array (
		'order_sn' => $uid . time (),
		'user_id' => $uid,
		'order_status' => 0,
		'shipping_status' => 0,
		'pay_status' => 0,
		'goods_amount' => $goods_amount,
		'shipping_fee' => $shipping_fee,
		'pay_fee' => $pay_fee,
		'order_amount' => $pay_fee,
		'add_time' => time (),
		'order_type' => $order_type,
		'ziti_nums' => $ziti_nums,
		'rebate_points' => $goods_amount * rebate_points 
);
if ($address !='') {
	$order_data ['consignee'] = $address ['consignee'];
	$order_data ['province'] = $address ['province'];
	$order_data ['city'] = $address ['city'];
	$order_data ['district'] = $address ['district'];
	$order_data ['province'] = $address ['province'];
	$order_data ['address'] = $address ['address'];
	$order_data ['zipcode'] = $address ['zipcode'];
	$order_data ['mobile'] = $address ['mobile'];
}
$db->autoExecute ( 'ecs_order_info', $order_data, "INSERT" );
$order_id = mysql_insert_id ();

$goods_list = array ();

$rebate_money = 0;
$rebate_points = 0;
foreach ( $cart_info as $k => $v ) {
	// 产品
	$sql = "SELECT goods_id, goods_name, is_on_sale, goods_type, goods_thumb, rebate, rebate_points, coupon_id" . " FROM ecs_goods" . " WHERE goods_id = {$v['goods_id']}";
	$goods = $db->getRow ( $sql );
	$goods ['color_img'] = $v ['color_img'];
	$goods ['nums'] = $v ['goods_number'];
	$goods ['shop_price'] = $v ['shop_price'];
	$goods ['size'] = $v ['size'];
	// 库存
	if ($v ['cus_id'] == 0) {
		$sql = "SELECT g.id, g.nums " . " FROM ecs_spec_goods AS g" . " LEFT JOIN ecs_specification ON ecs_specification.id = g.spec_id" . " WHERE g.goods_id = {$goods['goods_id']} AND ecs_specification.value = '{$v['size']}' AND g.type = '{$v['type']}'";
		$product = $db->getRow ( $sql );
	} else {
		$product ['id'] = 0;
	}
	
	// 添加ecs_order_goods表
	$parent = array (
			'order_id' => $order_id,
			'goods_id' => $v ['goods_id'],
			'goods_name' => $v ['goods_name'],
			'goods_number' => $v ['goods_number'],
			'market_price' => $v ['market_price'],
			'goods_price' => $v ['shop_price'],
			'color_img' => $v ['color_img'],
			'size' => $v ['size'],
			'goods_type' => $v ['type'],
			'province_id' => $product ['id'],
			'goods_thumb' => $goods ['goods_thumb'],
			'cus_id' => $v ['cus_id'],
			'source' => $v ['source'],
			'unid' => $v ['unid'],
			'mold' => $v ['mold'] 
	);
	$db->autoExecute ( 'ecs_order_goods', $parent, "INSERT" );
	// 产品列表信息
	$goods_list [$k] = $goods;
	$rebate_money += $goods ['rebate'];
	$rebate_points += $goods ['rebate_points'];
}

// 删除购物车
$sql = "delete from ecs_cart where session_id = '$clientUUID' and is_del = 0";
$db->query ( $sql );

$val->goods_list = $goods_list;
$val->order_id = $order_id;
$val->shipping_fee = $shipping_fee;
$val->pinkage = PINKAGE; // 免邮费
$val->rebate_money = $rebate_money;
$val->rebate_points = $rebate_points;

$val = json_encode ( $val );

die ( $val );

?>