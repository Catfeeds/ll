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
$token = isset($_REQUEST['token'])? $_REQUEST['token']:'';
$consignee = isset($_POST['consignee'])? $_POST['consignee']:'';
$city = isset($_POST['city'])? $_POST['city']:'';
$district = isset($_POST['district'])? $_POST['district']:'';
$province = isset($_POST['province'])? $_POST['province']:'';
$address = isset($_POST['address'])? $_POST['address']:'';
$mobile = isset($_POST['mobile'])? $_POST['mobile']:'';
$zipcode = isset($_POST['zipcode'])? $_POST['zipcode']:'';
if (empty($_POST['uid']) || empty($_POST['token']) || empty($_POST['consignee']) || empty($_POST['city']) || empty($_POST['district']) || empty($_POST['province']) || empty($_POST['address']) || empty($_POST['mobile']) || empty($_POST['zipcode']))
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
$parent['user_id'] = $uid;
$parent['consignee'] = $consignee;
$parent['city'] = $city;
$parent['district'] = $district;
$parent['province'] = $province;
$parent['address'] = $address;
$parent['mobile'] = $mobile;
$parent['zipcode'] = $zipcode;
$sql ="select address_id from ecs_user_address where user_id = '$uid'";
$address = $db->getOne($sql);
if (!$address) {
	$parent['is_default'] = 1;
}

$db->autoExecute('ecs_user_address', $parent, "INSERT");
$id = mysql_insert_id();
$val->id = $id;

die(json_encode($val));

?>