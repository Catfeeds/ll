<?php
/*************************refineit*****************************/
/**
 * 收货地址详情接口
*/

define('IN_ECS', true);

require_once('../init.php');
require_once('../token.php');

$val = new stdClass();
$uid = isset($_POST['uid'])? $_POST['uid']:'';
$address_id = isset($_POST['address_id'])? $_POST['address_id']:'';
$token = isset($_POST['token'])? $_POST['token']:'';
if (empty($_POST['address_id']) || empty($_POST['token']))
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
//$val->token = $token['token'];
/*获取钱包详情*/
$sql = "select ad.consignee, rcity.region_name as city, rdistrict.region_name as district, rprovince.region_name as province, ad.address, ad.mobile, zipcode, is_default".
		" from ecs_user_address as ad left join ecs_region as rcity on rcity.region_id = ad.city".
		" left join ecs_region as rdistrict on rdistrict.region_id = ad.district".
		" left join ecs_region as rprovince on rprovince.region_id = ad.province".
		" where ad.address_id = '$address_id'";
$address_info = $db->getRow($sql);

$val->address_info = $address_info;

$val = json_encode($val);

die($val);

?>