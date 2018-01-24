<?php
/*************************refineit*****************************/
/**
 * 晒单接口
*/

define('IN_ECS', true);

require_once('../init.php');
require_once('config/config.php');
require_once('../token.php');
require_once(ROOT_PATH . 'includes/cls_image.php');
$image = new cls_image($_CFG['bgcolor']);

$val = new stdClass();
$uid = isset($_POST['uid'])? $_POST['uid']:'';//设备id
$token = isset($_REQUEST['token'])? $_REQUEST['token']:'';
$order_id = isset($_POST['order_id'])? $_POST['order_id']:'';//订单id
$content = isset($_POST['content'])? $_POST['content']:'';//评论
$files = isset($_FILES['files'])? $_FILES['files']:'';//图册

if (empty($_POST['order_id']) || empty($_POST['uid']) || empty($_POST['token']) || empty($_POST['content']))
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

//删除订单
$data['user_id'] = $uid;
$data['order_id'] = $order_id;
$data['content'] = $content;
$data['create_time'] = date('Y-m-d H:i:s');
$db->autoExecute('ecs_order_bask', $data, "INSERT");
$id = mysql_insert_id();

$icon['bask_id'] = $id;
foreach ($files['name'] as $k=>$v) {
	$file = array();
	$file['name'] = $v;
	$file['tmp_name'] = $files['tmp_name'][$k];
	$file['error'] = $files['error'][$k];
	$file['size'] = $files['size'][$k];
	$icon['img'] = $image->upload_image($file, 'bask');
	$db->autoExecute('ecs_bask_icon', $icon, "INSERT");
}
//修改订单状态
$data2['pay_status'] = 3;
$db->autoExecute('ecs_order_info', $data2, "UPDATE", "order_id = '$order_id'");
//获取积分
$points = array();
$points['user_id'] = $uid;
$points['points'] = bask_points;
$points['o_points'] = bask_points;
$points['expiration_time'] = date('Y-m-d H:i:s', strtotime("+1 year"));
$points['create_time'] = date('Y-m-d H:i:s');
$GLOBALS['db']->autoExecute('ecs_user_points', $points, "INSERT");

$val = json_encode($val);
die($val);

?>