<?php
/*************************refineit*****************************/
/**
 * 商品列表接口
*/

define('IN_ECS', true);

require_once('../init.php');

$val = new stdClass();

$type = isset($_POST['type'])? $_POST['type']:'';
$classify_id = isset($_POST['classify_id'])? $_POST['classify_id']:'';
$min_price = isset($_POST['min_price'])? $_POST['min_price']:'';
$max_price = isset($_POST['max_price'])? $_POST['max_price']:'';
$page_index= isset($_POST['page_index'])? $_POST['page_index']:'';
$page_size=isset($_POST['page_size'])? $_POST['page_size']:'';
if (!$page_index) {
    $page_index = '';
}
if (!$page_size) {
    $page_size = '';
}
$val->code = 101;
$val->msg = '操作成功';
//goods列表
$sql = "select goods_id,goods_name,goods_thumb,shop_price from ecs_goods where is_on_sale = 1";
if (!empty($classify_id)) {
	$sql .= " and FIND_IN_SET('$classify_id', `classify_ids`)";
}
if (!empty($min_price)) {
	$sql .= " and shop_price >= '$min_price'";
}
if (!empty($max_price)) {
	$sql .= " and shop_price <= '$max_price'";
}
if (!empty($type)) {
	$sql .= " and goods_type = '$type'";
}
$sql .= " order by sort_order";
//分页算法
if ($page_index != '' && $page_size != '') {
    $pageID = ($page_index - 1);
    if($pageID < 0){
        $pageID =0;
    }
    $pageID=$pageID*$page_size;
    $sql .= " LIMIT $page_size OFFSET $pageID";
}
$val->goods_list = $db->getAll($sql);
$val = json_encode($val);

die($val);

?>