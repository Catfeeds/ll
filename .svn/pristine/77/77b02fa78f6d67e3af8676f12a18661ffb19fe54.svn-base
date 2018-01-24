<?php
/*************************refineit*****************************/
/**
 * 判断是否收藏接口
*/

define('IN_ECS', true);

require_once('../init.php');
require_once('../token.php');

$val = new stdClass();
$uid = isset($_POST['uid'])? $_POST['uid']:'';
$tar_id = isset($_POST['tar_id'])? $_POST['tar_id']:'';
$type = isset($_POST['type'])? $_POST['type']:'';//1:商品，2:品牌
$token = isset($_REQUEST['token'])? $_REQUEST['token']:'';
if (empty($_POST['uid']) || empty($_POST['tar_id']) || empty($_POST['type']) || empty($_POST['token']))
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

$sql = "select rec_id from ecs_collect where user_id = $uid and tar_id = $tar_id and type = $type";
$id = $db->getOne($sql);

if (empty($id)) {
	$val->is_collect = 0;
} else {
	$val->is_collect = 1;
}

die(json_encode($val));

?>