<?php
/*************************refineit*****************************/
/**
 * 退换货订单列表接口
*/

define('IN_ECS', true);

require_once('../init.php');
require_once('config/config.php');
require_once('../token.php');

$val = new stdClass();
$uid = isset($_POST['uid'])? $_POST['uid']:'';//设备id
$token = isset($_REQUEST['token'])? $_REQUEST['token']:'';
$page_index= isset($_POST['page_index'])? $_POST['page_index']:'';
$page_size=isset($_POST['page_size'])? $_POST['page_size']:'';

if (empty($_POST['uid']) || empty($_POST['page_index']) || empty($_POST['page_size']) || empty($_POST['token']))
{
    $val->code = 201;
	$val->msg = '缺少必要的参数';
	die(json_encode($val));
}
//token
$sql = "select * from" . $ecs->table("user_session") . "where token = '" . $token . "'";
$result = check_token($token, $sql, $db, $ecs);
if($result['code'] == "101")
{
	if(!empty($result['uid'])) {
		if(strcmp($result['uid'], $uid) != 0) {
			$result = array("code"=> "400", "msg"=> "该token不属于用户" . $uid);
			die(json_encode($result));
		}
	} else {
		echo "check token rerurn empty uid";
	}
} else {
	die(json_encode($result));
}

$val->code = 101;
$val->msg = '操作成功';
//查询退换货订单中的内容
$sql = "select id as thorder_id,order_id,rec_id,tuihuan_state from ecs_thorder_info where user_id = '$uid'";
$sql .= " order by id desc";
$pageID = ($page_index - 1);
if($pageID < 0){
	$pageID = 0;
}
$pageID=$pageID*$page_size;
$sql .= " LIMIT $page_size OFFSET $pageID";
$order = $db->getAll($sql);
//查询商品的详情
foreach ($order as $k=>$v) {
	$sql = "select  goods_name,goods_price,color_img,size,goods_thumb,goods_type,cus_id from ecs_order_goods where rec_id = {$v['rec_id']}";
	$goods = $db->getRow($sql);
	
	$order[$k]['goods_name'] = $goods['goods_name'];
	$order[$k]['goods_price'] = $goods['goods_price'];
	$order[$k]['goods_thumb'] = $goods['goods_thumb'];
	$order[$k]['goods_type'] = $goods['goods_type'];
	if ($goods['cus_id'] != 0) {
		$sql = "select cp.img from ecs_customize as c left join ecs_cus_parameter as cp on cp.id = c.color_id where c.id = '{$goods['cus_id']}'";
		$order[$k]['color_img'] = $db->getOne($sql);
		$sql = "select size from ecs_user_info where user_id = '$uid'";
		$order[$k]['size'] = $db->getOne($sql);
	} else {
		$order[$k]['color_img'] = $goods['color_img'];
		$order[$k]['size'] = $goods['size'];
	}
}

$val->order = $order;
$val = json_encode($val);

die($val);

?>