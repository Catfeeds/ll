<?php
/*************************refineit*****************************/
/**
 * 评论接口
*/

define('IN_ECS', true);

require_once('../init.php');
require_once('config/config.php');
require_once('../token.php');

$val = new stdClass();
$uid = isset($_POST['uid'])? $_POST['uid']:'';//设备id
$token = isset($_REQUEST['token'])? $_REQUEST['token']:'';
$id = isset($_POST['id'])? $_POST['id']:'';//信息id
$content = isset($_POST['content'])? $_POST['content']:'';//信息id
if (empty($_POST['uid']) || empty($_POST['token']) || empty($_POST['id']) || empty($_POST['content']))
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

$data['user_id'] = $uid;
$data['expert_id'] = $id;
$data['content'] = $content;
$data['create_time'] = date('Y-m-d H:i:s');
$db->autoExecute("ecs_comment", $data, 'INSERT');

$sql = "update ecs_expert set pl_count = pl_count + 1 where id = $id";
$db->query($sql);

//获取积分
$points = array();
$points['user_id'] = $uid;
$points['points'] = pl_points;
$points['o_points'] = pl_points;
$points['expiration_time'] = date('Y-m-d H:i:s', strtotime("+1 year"));
$points['create_time'] = date('Y-m-d H:i:s');
$GLOBALS['db']->autoExecute('ecs_user_points', $points, "INSERT");

$val = json_encode($val);

die($val);

?>