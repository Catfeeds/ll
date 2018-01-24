<?php
/*************************refineit*****************************/
/**
 * 修改购物车接口
*/

define('IN_ECS', true);

require_once('../init.php');

$val = new stdClass();

$cart_id = isset($_POST['cart_id'])? $_POST['cart_id']:'';//购物袋id
$nums = isset($_POST['nums'])? $_POST['nums']:'';//数量
$is_del = isset($_POST['is_del'])? $_POST['is_del']:0;//是否排除

//必填参数
if (empty($_POST['cart_id']))
{
	$val->code = 201;
	$val->msg = '缺少必要的参数';
	die(json_encode($val));
}
$val->code = 101;
$val->msg = '操作成功';
/* 检查购物车中是否有商品  */
$sql = "SELECT rec_id,goods_number,goods_id,product_id from ecs_cart where rec_id = '$cart_id'";
$cart_info = $db->getRow($sql);
if (empty($cart_info)) {
	$val->code = 105;
	$val->msg = '购物车中无此商品';
	die(json_encode($val));
}
/* 取得商品信息 */
$sql = "SELECT goods_id, goods_name, goods_thumb, market_price, shop_price, is_on_sale ".
        " FROM ecs_goods".
        " WHERE goods_id = '{$cart_info['goods_id']}'";
$goods = $db->getRow($sql);
if (empty($goods))
{
	$val->code = 102;
	$val->msg = '该商品不存在';
	die(json_encode($val));
}
/* 是否正在销售 */
if ($goods['is_on_sale'] == 0)
{
	$val->code = 103;
	$val->msg = '该商品未开放购买';
	die(json_encode($val));
}
/* 检查：库存 */
$sql = "SELECT g.id, g.nums ".
        " FROM ecs_spec_goods AS g".
        " LEFT JOIN ecs_specification ON ecs_specification.id = g.spec_id".
        " WHERE g.id = '{$cart_info['product_id']}'";
$product = $db->getRow($sql);
if (empty($product))
{
	$val->code = 104;
	$val->msg = '库存数量不足';
	die(json_encode($val));
}
if ($nums > $product['nums']) 
{
	$val->code = 104;
	$val->msg = '库存数量不足';
	die(json_encode($val));
}

/* 修改购物车 */
/* 初始化要插入购物车的基本件数据 */
$parent = array();
if (isset($_POST['nums']))
{
	$parent['goods_number'] = $nums;
}
if (isset($_POST['is_del']))
{
	$parent['is_del'] = $is_del;
}
$db->autoExecute('ecs_cart', $parent, "UPDATE", "rec_id = '$cart_id'");

$val = json_encode($val);

die($val);

?>