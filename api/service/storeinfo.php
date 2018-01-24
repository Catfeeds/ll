<?php
/*************************refineit*****************************/
/**
 * 门店信息接口
*/

define('IN_ECS', true);

require_once('../init.php');
require_once('../token.php');

$val = new stdClass();
$id = isset($_POST['id'])? $_POST['id']:'';//服务id

if (empty($_POST['id']))
{
	$val->code = 201;
	$val->msg = '缺少必要的参数';
	die(json_encode($val));
}

$val->code = 101;
$val->msg = '操作成功';
//门店
$sql = "select * from ecs_service where id = '$id'";
$storeinfo = $db->getRow($sql);

$val->storeinfo = $storeinfo;

$val = json_encode($val);

die($val);

?>