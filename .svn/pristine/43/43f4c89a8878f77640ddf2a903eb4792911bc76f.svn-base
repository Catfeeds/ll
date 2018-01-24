<?php
/*************************refineit*****************************/
/**
 * 钱包信息接口
*/

define('IN_ECS', true);

require_once('../init.php');
require_once('config/config.php');
require_once('../token.php');

$val = new stdClass();
$uid = isset($_POST['uid'])? $_POST['uid']:'';//设备id
$token = isset($_REQUEST['token'])? $_REQUEST['token']:'';
if (empty($_POST['uid']) || empty($_POST['token']))
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
/*获取钱包详情*/
$goods_info = array();
$sql = "select user_id, user_money, user_points ".
		" from ecs_users".
		" where user_id = '$uid'";
$user_info = $db->getRow($sql);
//积分
$sql = "select sum(points) as user_points from ecs_user_points where user_id = '{$user_info['user_id']}' and expiration_time > now()";
$user_points = $db->getOne($sql);
if ( $user_points != null && $user_points != '' ) {
	$user_info['user_points'] = $user_points;
} else {
	$user_info['user_points'] = 0;
}
$user_info['user_points_money'] = sprintf('%.2f', floor($user_info['user_points'] * POINTS_RATIO));
$yes_date = date("Y-m-d",strtotime("-1 day"));
$sql = "select sum(money) as money from ecs_user_rebate where user_id = '$uid' and create_time = '$yes_date'";
$yes_money = $db->getRow($sql);
if ( $yes_money ) {//昨日收益
	$user_info['yes_money'] = sprintf('%.2f', $yes_money['money']);
} else {
	$user_info['yes_money'] = '0.00';
}

$val->user_info = $user_info;

/*获取积分列表*/
$date = date("Y-m-d");
$sql = "select points, expiration_time from ecs_user_points where user_id = '$uid' and expiration_time >= '$date'";
$jflist = $db->getAll($sql);
$val->jflist = $jflist;
/*获取优惠券列表*/
$date = date("Y-m-d");
$sql = "select uc.id, uc.card, c.name, c.money, c.condition, c.start_time, c.expiration_time from ecs_user_coupon as uc left join ecs_coupon as c on c.id = uc.coupon_id where uc.user_id = '$uid' and is_used = 0 and c.expiration_time >= '$date'";
$yhlist = $db->getAll($sql);
$val->yhlist = $yhlist;

$val = json_encode($val);

die($val);

?>