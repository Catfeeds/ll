<?php
/*************************refineit*****************************/
/**
 * 主题馆信息接口
*/

define('IN_ECS', true);

require_once('../init.php');

$val = new stdClass();

$id = isset($_POST['id'])? $_POST['id']:'';
if (empty($_POST['id']))
{
	$val->code = 201;
	$val->msg = '缺少必要的参数id';
	die(json_encode($val));
}

$val->code = 101;
$val->msg = '操作成功';
//theme pavilion
$sql = "select id as tp_id,name as tp_name,icon as tp_icon,description from ecs_theme_pavilion where id = $id";
$val->tp_info = $db->getRow($sql);

//goods
$sql = "select goods.goods_id,goods.goods_name,goods.goods_thumb,goods.shop_price from ecs_tp_goods as etg left join ecs_goods as goods on goods.goods_id = etg.goods_id where etg.tp_id = $id and goods.is_on_sale = 1 order by goods.sort_order";
$val->goods_list = $db->getAll($sql);

$val = json_encode($val);

die($val);

?>