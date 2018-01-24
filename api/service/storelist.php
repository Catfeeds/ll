<?php
/*************************refineit*****************************/
/**
 * 门店列表接口
*/

define('IN_ECS', true);

require_once('../init.php');
require_once('../token.php');

$val = new stdClass();
$city = isset($_REQUEST['city'])? $_REQUEST['city']:'';
$page_index= isset($_POST['page_index'])? $_POST['page_index']:'';
$page_size=isset($_POST['page_size'])? $_POST['page_size']:'';

if (empty($_POST['city']))
{
	$val->code = 201;
	$val->msg = '缺少必要的参数';
	die(json_encode($val));
}

$val->code = 101;
$val->msg = '操作成功';
//门店
$sql = "select id, city, name, icon, lng, lat from ecs_service where city = '$city'";
//分页算法
if ($page_index != '' && $page_size != '') {
	$pageID = ($page_index - 1);
	if($pageID < 0){
		$pageID =0;
	}
	$pageID=$pageID*$page_size;
	$sql .= " LIMIT $page_size OFFSET $pageID";
}
$storelist = $db->getAll($sql);

$val->storelist = $storelist;

$val = json_encode($val);

die($val);

?>