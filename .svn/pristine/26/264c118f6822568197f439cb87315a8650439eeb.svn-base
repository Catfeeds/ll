<?php
/*************************refineit*****************************/
/**
 * 商品信息接口
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
/*获取商品详情*/
$goods_info = array();
$sql = "select ecs_goods.goods_id,ecs_goods.goods_thumb,ecs_goods.shop_price,ecs_goods.market_price,ecs_color.img as color_img,ecs_goods.goods_name,ecs_goods.goods_brief,ecs_goods.goods_desc".
		" from ecs_goods left join ecs_color on ecs_color.id = ecs_goods.color_id".
		" where ecs_goods.goods_id = $id";
$goods_info = $db->getRow($sql);
$val->goods_info = $goods_info;
/*获取关联商品（颜色）*/
$link_goods = array();
$sql = "select goods.goods_id,goods.goods_thumb".
		" from ecs_link_goods as link left join ecs_goods as goods on goods.goods_id = link.link_goods_id".
		" where link.goods_id = $id and goods.is_on_sale = 1";
$link_goods = $db->getAll($sql);
$_goods = array();
$_goods['goods_id'] = $goods_info['goods_id'];
$_goods['goods_thumb'] = $goods_info['goods_thumb'];
array_unshift($link_goods, $_goods);
$val->link_goods = $link_goods;
/*获取规格参数（尺码）*/
$spec = array();
$sql = "select es.value,esg.nums".
			" from ecs_spec_goods as esg left join ecs_specification as es on es.id=esg.spec_id where esg.goods_id=".$id." and es.value <> 0 and es.type = 1 order by es.value asc";
	$spec = $GLOBALS['db']->getAll($sql);
$val->spec = $spec;

$val = json_encode($val);

die($val);

?>