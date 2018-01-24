<?php
/*************************refineit*****************************/
/**
 * 收货地址列表接口
*/

define('IN_ECS', true);

require_once('../init.php');
require_once('../token.php');

$val = new stdClass();
$uid = isset($_POST['uid'])? $_POST['uid']:'';
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
$sql = "select ad.address_id, ad.consignee, rcity.region_name as city, rdistrict.region_name as district, rprovince.region_name as province, ad.address, ad.mobile, ad.is_default".
		" from ecs_user_address as ad left join ecs_region as rcity on rcity.region_id = ad.city".
		" left join ecs_region as rdistrict on rdistrict.region_id = ad.district".
		" left join ecs_region as rprovince on rprovince.region_id = ad.province".
		" where ad.user_id = '$uid' order by is_default desc";
$address_list = $db->getAll($sql);

$val->address_list = $address_list;

$val = json_encode($val);

die($val);

?>