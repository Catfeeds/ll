<?php
/*************************refineit*****************************/
/**
 * 购物车信息接口
*/

define('IN_ECS', true);

require_once('../init.php');

$val = new stdClass();
$clientUUID = isset($_POST['clientUUID'])? $_POST['clientUUID']:'';//设备id
if (empty($_POST['clientUUID']))
{
    $val->code = 201;
	$val->msg = '缺少必要的参数';
	die(json_encode($val));
}
$val->code = 101;
$val->msg = '操作成功';
/*获取购物车详情*/
$goods_info = array();
$sql = "select ecs_cart.rec_id as cart_id,ecs_goods.goods_id,ecs_goods.goods_name,ecs_goods.goods_thumb,ecs_goods.shop_price,ecs_goods.market_price,ecs_color.img as color_img,ecs_cart.goods_number,ecs_cart.size,ecs_cart.is_del,ecs_cart.cus_id".
		" from ecs_cart left join ecs_goods on ecs_goods.goods_id = ecs_cart.goods_id".
		" left join ecs_color on ecs_color.id = ecs_goods.color_id".
		" where ecs_cart.session_id = '$clientUUID'";
$cart_info = $GLOBALS['db']->getAll($sql);
$val->cart_info = $cart_info;

$val = json_encode($val);

die($val);

?>