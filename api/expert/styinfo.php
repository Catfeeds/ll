<?php
/*************************refineit*****************************/
/**
 * 达人信息接口
*/

define('IN_ECS', true);

require_once('../init.php');
require_once('../token.php');

$val = new stdClass();
$sty_id = isset($_POST['sty_id'])? $_POST['sty_id']:'';

if (empty($_POST['sty_id'])) {
	$val->code = 201;
	$val->msg = '缺少必要的参数';
	die(json_encode($val));
}

$val->code = 101;
$val->msg = '操作成功';

$sql = "select id, name, avatar, description, tags from ecs_stylist where id = $sty_id";
$styinfo = $db->getRow($sql);

$val->styinfo = $styinfo;

$val = json_encode($val);

die($val);

?>