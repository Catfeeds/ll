<?php
/*************************refineit*****************************/
/**
 * 判断用户是否已存在接口
*/

define('IN_ECS', true);

require_once('../init.php');
require_once('../token.php');

$val = new stdClass();
$username = isset($_POST['username'])? $_POST['username']:'';
if (empty($_POST['username']))
{
    $val->code = 201;
	$val->msg = '缺少必要的参数';
	die(json_encode($val));
}

$val->code = 101;
$val->msg = '操作成功';

$sql = "select user_id from ecs_users where user_name = '$username'";
$user_id = $db->getOne($sql);

if (empty($user_id)) {
	$val->is_exist = 0;
} else {
	$val->is_exist = 1;
}

die(json_encode($val));

?>