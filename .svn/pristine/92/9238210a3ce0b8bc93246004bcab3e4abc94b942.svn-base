<?php
/*************************refineit*****************************/
/**
 * 意见反馈接口
*/

define('IN_ECS', true);

require_once('../init.php');
require_once('../token.php');

$val = new stdClass();
$uid = isset($_POST['uid'])? $_POST['uid']:'';
$token = isset($_REQUEST['token'])? $_REQUEST['token']:'';
$content = isset($_REQUEST['content'])? $_REQUEST['content']:'';
if (empty($_POST['uid']) || empty($_POST['content']) || empty($_POST['token']))
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
		'user_id'		=>	$uid,
		'content'		=>	$content,
		'create_time'	=>	date('Y-m-d H:i:s')
);
$db->autoExecute('ecs_feedback', $parent, "INSERT");

die(json_encode($val));

?>