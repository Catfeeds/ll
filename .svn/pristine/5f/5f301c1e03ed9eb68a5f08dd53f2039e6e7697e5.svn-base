<?php
/*************************refineit*****************************/
/**
 * 删除购物车接口
*/

define('IN_ECS', true);

require_once('../init.php');

$val = new stdClass();

$cart_ids = isset($_POST['cart_ids'])? $_POST['cart_ids']:'';//购物袋ids,已逗号分隔

//必填参数
if (empty($_POST['cart_ids']))
{
	$val->code = 201;
	$val->msg = '缺少必要的参数';
	die(json_encode($val));
}
$val->code = 101;
$val->msg = '操作成功';
$cart_ids = explode(',', $cart_ids);
foreach ($cart_ids as $v) {
	$sql = "DELETE FROM ecs_cart WHERE rec_id = '$v'";
	$db->query($sql);
}

$val = json_encode($val);

die($val);

?>