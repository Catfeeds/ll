<?php
/*************************refineit*****************************/
/**
 * 提交定制接口
*/

define('IN_ECS', true);

require_once('../init.php');
require_once('../token.php');

$val = new stdClass();
$uid = isset($_POST['uid'])? $_POST['uid']:'';//设备id
$token = isset($_REQUEST['token'])? $_REQUEST['token']:'';
$goods_id = isset($_POST['goods_id'])? $_POST['goods_id']:'';//产品id
$color_id = isset($_POST['color_id'])? $_POST['color_id']:'';//颜色id
$texture_id = isset($_POST['texture_id'])? $_POST['texture_id']:'';//材质id
$price = isset($_POST['price'])? $_POST['price']:'';//价格
$ID = isset($_POST['ID'])? $_POST['ID']:'';//定制id

if (empty($_POST['uid']) || empty($_POST['token']) || empty($_POST['goods_id']) || empty($_POST['color_id']) || empty($_POST['texture_id']))
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
//预约
$data['user_id'] = $uid;
$data['goods_id'] = $goods_id;
$data['color_id'] = $color_id;
$data['texture_id'] = $texture_id;
if (!empty($_POST['price'])) {
	$data['price'] = $price;
}
if (!empty($_POST['ID'])) {
    $data['Idcard'] = $ID;
}
$data['create_time'] = date('Y-m-d H:i:s');
$db->autoExecute("ecs_customize", $data, "INSERT");
$val->id = mysql_insert_id();

$val = json_encode($val);

die($val);

?>