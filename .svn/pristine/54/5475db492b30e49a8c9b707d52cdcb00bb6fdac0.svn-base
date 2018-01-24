<?php
/*************************refineit*****************************/
/**
 * 加入购物车接口
 */
define ( 'IN_ECS', true );

require_once ('../init.php');

$val = new stdClass ();

$goods_id = isset ( $_POST ['goods_id'] ) ? $_POST ['goods_id'] : ''; // 商品id
$size = isset ( $_POST ['size'] ) ? $_POST ['size'] : ''; // 尺寸
$nums = isset ( $_POST ['nums'] ) ? $_POST ['nums'] : ''; // 数量
$type = isset ( $_POST ['type'] ) ? $_POST ['type'] : ''; // 鞋型
$clientUUID = isset ( $_POST ['clientUUID'] ) ? $_POST ['clientUUID'] : ''; // 设备id
$cus_id = isset($_POST['cus_id'])? $_POST['cus_id']:'';//设备id
$source = isset ( $_POST ['source'] ) ? $_POST ['source'] : ''; // 来源id
$mold = isset ( $_POST ['mold'] ) ? $_POST ['mold'] : ''; // 分享来源类型；1：第三方平台，2：用户
$unid = isset ( $_POST ['unid'] ) ? $_POST ['unid'] : '';
                                                          
// 必填参数
if (empty ( $_POST ['clientUUID'] ) || empty ( $_POST ['goods_id'] ) || empty ( $_POST ['size'] ) || empty ( $_POST ['type'] ) || empty ( $_POST ['nums'] )) {
	$val->code = 201;
	$val->msg = '缺少必要的参数';
	die ( json_encode ( $val ) );
}

$val->code = 101;
$val->msg = '操作成功';
/* 取得商品信息 */
$sql = "SELECT goods_id, goods_name, goods_thumb, market_price, shop_price, is_on_sale " . " FROM ecs_goods" . " WHERE goods_id = '$goods_id'";
$goods = $db->getRow ( $sql );
if (empty ( $goods )) {
	$val->code = 102;
	$val->msg = '该商品不存在';
	die ( json_encode ( $val ) );
}
/* 是否正在销售 */
if ($goods ['is_on_sale'] == 0) {
	$val->code = 103;
	$val->msg = '该商品未开放购买';
	die ( json_encode ( $val ) );
}
if (! $cus_id) {
	/* 检查：库存 */
	$sql = "SELECT g.id, g.nums " . " FROM ecs_spec_goods AS g" . " LEFT JOIN ecs_specification ON ecs_specification.id = g.spec_id" . " WHERE g.goods_id = '$goods_id' AND ecs_specification.value = '$size' AND g.type = '$type'";
	$product = $db->getRow ( $sql );
	if (empty ( $product )) {
		$val->code = 104;
		$val->msg = '库存数量不足';
		die ( json_encode ( $val ) );
	}
	if ($nums > $product ['nums']) {
		$val->code = 104;
		$val->msg = '库存数量不足';
		die ( json_encode ( $val ) );
	}
}

/* 添加购物车 */
/* 检查购物车中是否有相同的商品  */
$sql = "SELECT rec_id,goods_number,market_price,goods_price from ecs_cart where session_id = '$clientUUID' and goods_id = '$goods_id' and product_id = '{$product['id']}'";
$cart_info = $db->getRow ( $sql );
if (! empty ( $cart_info )) { // 存在
	/* 初始化要插入购物车的基本件数据 */
	$parent = array (
			'goods_number' => $cart_info ['goods_number'] + $nums,
			'market_price' => $cart_info ['market_price'] + $goods ['market_price'] * $nums,
			'goods_price' => $cart_info ['goods_price'] + $goods ['shop_price'] * $nums 
	);
	$db->autoExecute ( 'ecs_cart', $parent, "UPDATE", "rec_id = '{$cart_info['rec_id']}'" );
} else { // 不存在
	/* 初始化要插入购物车的基本件数据 */
	$parent = array (
			// 'user_id' => $_SESSION['user_id'],
			'session_id' => $clientUUID,
			'goods_id' => $goods_id,
			// 'goods_sn' => addslashes($goods['goods_sn']),
			'product_id' => $product ['id'],
			'goods_name' => $goods ['goods_name'],
			'market_price' => $goods ['market_price'] * $nums,
			'goods_price' => $goods ['shop_price'] * $nums,
			'goods_number' => $nums,
			'size' => $size,
			'type' => $type,
			'source' => $source,
			'unid' => $unid,
			'mold' => $mold 
	// 'goods_attr' => addslashes($goods_attr),
	// 'goods_attr_id' => $goods_attr_id,
	// 'is_real' => $goods['is_real'],
	// 'extension_code'=> $goods['extension_code'],
	// 'is_gift' => 0,
	// 'is_shipping' => $goods['is_shipping'],
	// 'rec_type' => CART_GENERAL_GOODS
		);
	if ($cus_id) {
		$parent ['cus_id'] = $cus_id;
	}
	$db->autoExecute ( 'ecs_cart', $parent, "INSERT" );
}

$val = json_encode ( $val );

die ( $val );

?>