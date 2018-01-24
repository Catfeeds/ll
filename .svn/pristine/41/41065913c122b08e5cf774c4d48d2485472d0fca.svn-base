<?php
/*************************refineit*****************************/
/**
 * 收藏接口
*/

define('IN_ECS', true);

require_once('../init.php');
require_once('../token.php');

$val = new stdClass();
$uid = isset($_POST['uid'])? $_POST['uid']:'';
$tar_ids = isset($_POST['tar_ids'])? $_POST['tar_ids']:'';
$type = isset($_POST['type'])? $_POST['type']:'';//1:商品，2:品牌
$token = isset($_REQUEST['token'])? $_REQUEST['token']:'';
$is_del = isset($_REQUEST['is_del'])? $_REQUEST['is_del']:'';
if (empty($_POST['uid']) || empty($_POST['tar_ids']) || empty($_POST['type']) || empty($_POST['token']))
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

$parent = array(
		'user_id'	=>	$uid,
		'add_time'	=>	time(),
		'type'		=>	$type
);
$tar_ids = explode(',', $tar_ids);
foreach ($tar_ids as $v){
	if ($is_del != 1) {
		$sql = "SELECT rec_id FROM ecs_collect WHERE user_id = '$uid' AND tar_id = '$v' AND type = $type";
		$collect = $db->getOne($sql);
		if ($collect) {
			$val->code = 102;
			$val->msg = '已收藏过该商品';
			die(json_encode($val));
		}
		$parent['tar_id'] = $v; $db->autoExecute('ecs_collect', $parent, "INSERT");
	} else {
		$sql = "DELETE FROM ecs_collect WHERE user_id = '$uid' AND tar_id = '$v' AND type = $type"; $db->query($sql);
	}
}
$id = mysql_insert_id();
$val->id = $id;

die(json_encode($val));

?>