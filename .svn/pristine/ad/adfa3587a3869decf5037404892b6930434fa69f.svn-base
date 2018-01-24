<?php
/*************************refineit*****************************/
/**
 * 分类列表接口
*/

define('IN_ECS', true);

require_once('../init.php');

$val = new stdClass();
$classify_type = isset($_POST['classify_type'])? $_POST['classify_type']:'';//1：款式，2：色彩，3：价格，4：风格
$type = isset($_POST['type'])? $_POST['type']:'';//1：鞋履，2：包袋
if (empty($_POST['classify_type']) || empty($_POST['type']))
{
    $val->code = 201;
	$val->msg = '缺少必要的参数';
	die(json_encode($val));
}
$val->code = 101;
$val->msg = '操作成功';
/*获取分类列表*/
$sql = "select id,name,img,min_price,max_price,classify_type".
		" from ecs_classify".
		" where classify_type = '$classify_type' and type = '$type'";
$list = $db->getAll($sql);
$val->list = $list;

$val = json_encode($val);

die($val);

?>