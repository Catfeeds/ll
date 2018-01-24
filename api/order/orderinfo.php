<?php
/*************************refineit*****************************/
/**
 * 订单详情接口
*/

define('IN_ECS', true);

require_once('../init.php');
require_once('config/config.php');
require_once('../token.php');

$val = new stdClass();
$uid = isset($_POST['uid'])? $_POST['uid']:'';//设备id
$token = isset($_REQUEST['token'])? $_REQUEST['token']:'';
$order_id = isset($_POST['order_id'])? $_POST['order_id']:'';

if (empty($_POST['uid']) || empty($_POST['order_id']) || empty($_POST['token']))
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

$sql = "select eoi.order_id,eoi.order_type,eoi.ziti_nums, eoi.order_sn, eoi.order_status, eoi.shipping_status, eoi.pay_status, eoi.province, eoi.city, eoi.district, eoi.consignee, eoi.address, eoi.mobile, eoi.goods_amount, eoi.pay_name, eoi.shipping_fee, eoi.rebate_money, eoi.rebate_points, eoi.add_time from ecs_order_info as eoi left join ecs_order_address as eoa on eoa.id = eoi.ziti_address where eoi.order_id = '$order_id'";
$order = $db->getRow($sql);
$order['add_time'] = date('Y-m-d H:i:s', $order['add_time']);
$order['pinkage'] = PINKAGE;//免邮费
/*地区*/
$sql = "select region_name from ecs_region where region_id = '{$order['province']}'";
$province = $db->getRow($sql);
$order['province'] = $province['region_name'];

$sql = "select region_name from ecs_region where region_id = '{$order['city']}'";
$city = $db->getRow($sql);
$order['city'] = $city['region_name'];

$sql = "select region_name from ecs_region where region_id = '{$order['district']}'";
$district = $db->getRow($sql);
$order['district'] = $district['region_name'];
/*查询返利和积分最高使用比例和数量
 * */
$sql="SELECT fanli_bili,jifen_bili FROM ecs_guize_bili WHERE 1 = 1";
$bili = $db->getRow($sql);
//计算最高能使用返利金额
$order['fanli_bili']=$bili['fanli_bili'];
$order['fanli_nums']=round($order['goods_amount']*($bili['fanli_bili']/100),2);
//计算最高能使用积分数量
$order['jifen_bili']=$bili['jifen_bili'];
$order['jifen_nums']=round($order['goods_amount']*($bili['jifen_bili']/100),0);

$sql = "select rec_id, goods_id,tdgood_type,goods_name, goods_number as nums, color_img, size, goods_price as shop_price, goods_thumb, cus_id from ecs_order_goods where order_id = {$order['order_id']}";
$goods = $db->getAll($sql);

foreach ($goods as $k=>$v) {
	if ($v['cus_id'] != 0) {
		$sql = "select cp.img, c.price from ecs_customize as c left join ecs_cus_color as cp on cp.id = c.color_id where c.id = '{$v['cus_id']}'";
		$customize = $db->getRow($sql);
		$goods[$k]['color_img'] = $customize['img'];
		$goods[$k]['shop_price'] = $customize['price'];
		$sql = "select size from ecs_user_info where user_id = '$uid'";
		$goods[$k]['size'] = $db->getOne($sql);
	}
}

$val->order = $order;
$val->goods_list = $goods;
$val = json_encode($val);

die($val);

?>