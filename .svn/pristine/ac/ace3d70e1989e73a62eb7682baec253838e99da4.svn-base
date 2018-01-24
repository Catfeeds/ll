<?php
/*************************refineit*****************************/
/**
 * 主页信息接口
*/

define('IN_ECS', true);

require_once('../init.php');

$val = new stdClass();

$val->code = 101;
$val->msg = '操作成功';
//banner
$sql = "select id as banner_id,icon as banner_icon,link,tar_id,type from ecs_banner";
$val->banner_list = $db->getAll($sql);
//theme pavilion
$sql = "select id as tp_id,name as tp_name,icon as tp_icon,type as tp_type from ecs_theme_pavilion where recommend = 1 and hide = 0 group by type order by sort_order";
$val->tp_list = $db->getAll($sql);
//stylist
$sql = "select id as stylist_id,name as stylist_name,icon as stylist_icon from ecs_stylist where recommend = 1 and hide = 0 order by sort_order";
$val->stylist_list = $db->getAll($sql);
//goods
$sql = "select goods_id,goods_name,goods_img as goods_icon,market_price,shop_price from ecs_goods where is_new = 1 and is_best = 1 and is_on_sale = 1 order by sort_order";
$val->goods_list = $db->getAll($sql);

$val = json_encode($val);

die($val);

?>