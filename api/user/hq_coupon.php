<?php
/*************************refineit*****************************/
/**
 * 获取优惠券接口
*/

define('IN_ECS', true);

require_once('../init.php');
require_once('../token.php');

$val = new stdClass();
$uid = isset($_POST['uid'])? $_POST['uid']:'';
$id = isset($_POST['id'])? $_POST['id']:'';
$token = isset($_REQUEST['token'])? $_REQUEST['token']:'';
$xz_id = isset($_POST['xz_id'])? $_POST['xz_id']:'';
if (empty($_POST['uid']) || empty($_POST['id']) || empty($_POST['token']))
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

$sql = "select id from ecs_user_coupon where user_id = $uid and coupon_id = $id and xz_id = $xz_id";
$uc_id = $db->getOne($sql);

if (empty($uc_id)) {
	$sql = "select nums from ecs_xiangzhuan where id = $xz_id";
	$nums = $db->getOne($sql);
	for ($i = 0; $i < $nums; $i ++) {
		$data['user_id'] = $uid;
		$data['coupon_id'] = $id;
		$data['card'] = time() . $uid . $id . $i;
		$data['is_used'] = 0;
		$data['xz_id'] = $xz_id;
		$data['create_time'] = date('Y-m-d H:i:s');
		$db->autoExecute('ecs_user_coupon', $data, 'INSERT');
	}
} else {
	$val->code = 102;
	$val->msg = '无法重复领取';
	die(json_encode($val));
}


die(json_encode($val));

?>