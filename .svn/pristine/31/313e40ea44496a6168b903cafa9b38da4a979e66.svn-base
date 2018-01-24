<?php
/*************************refineit*****************************/
/**
 * 修改收货地址接口
*/

define('IN_ECS', true);

require_once('../init.php');
require_once('../token.php');

$val = new stdClass();
$uid = isset($_POST['uid'])? $_POST['uid']:'';
$address_id = isset($_POST['address_id'])? $_POST['address_id']:'';
$token = isset($_REQUEST['token'])? $_REQUEST['token']:'';
$consignee = isset($_POST['consignee'])? $_POST['consignee']:'';
$city = isset($_POST['city'])? $_POST['city']:'';
$district = isset($_POST['district'])? $_POST['district']:'';
$province = isset($_POST['province'])? $_POST['province']:'';
$address = isset($_POST['address'])? $_POST['address']:'';
$mobile = isset($_POST['mobile'])? $_POST['mobile']:'';
$zipcode = isset($_POST['zipcode'])? $_POST['zipcode']:'';
$is_default = isset($_POST['is_default'])? $_POST['is_default']:'';
if (empty($_POST['uid']) || empty($_POST['address_id']) || empty($_POST['token']))
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

$parent = array();
if (!empty($_POST['consignee']))
{
	$parent['consignee'] = $consignee;
}
if (!empty($_POST['city']))
{
	$parent['city'] = $city;
}
if (!empty($_POST['district']))
{
	$parent['district'] = $district;
}
if (!empty($_POST['province']))
{
	$parent['province'] = $province;
}
if (!empty($_POST['address']))
{
	$parent['address'] = $address;
}
if (!empty($_POST['mobile']))
{
	$parent['mobile'] = $mobile;
}
if (!empty($_POST['zipcode']))
{
	$parent['zipcode'] = $zipcode;
}
if (!empty($_POST['is_default']))
{
	$parent['is_default'] = $is_default;
	if ($is_default == 1) {
		$_parents = array();
		$_parents['is_default'] = 0;
		$db->autoExecute('ecs_user_address', $_parents, "UPDATE", "user_id = '$uid'");
	}
}

$db->autoExecute('ecs_user_address', $parent, "UPDATE", "address_id = '$address_id'");

die(json_encode($val));

?>