<?php
/*************************refineit*****************************/
/**
 * 地区列表接口
*/

define('IN_ECS', true);

require_once('../init.php');

$val = new stdClass();
$city = isset($_POST['city'])? $_POST['city']:'';
$province = isset($_POST['province'])? $_POST['province']:'';
$val->code = 101;
$val->msg = '操作成功';

$dis_list = array();
$sql = "select region_id, region_name".
		" from ecs_region".
		" where region_type = 1 order by agency_id desc, CONVERT( region_name USING gbk ) COLLATE gbk_chinese_ci asc";
$dis_list = $db->getAll($sql);
if (!empty($_POST['city']))
{
	$sql = "select region_id, region_name".
			" from ecs_region".
			" where parent_id = '$city' and region_type = 3 order by CONVERT( region_name USING gbk ) COLLATE gbk_chinese_ci asc";
	$dis_list = $db->getAll($sql);
}
if (!empty($_POST['province']))
{
	$sql = "select region_id, region_name".
			" from ecs_region".
			" where parent_id = '$province' and region_type = 2 order by CONVERT( region_name USING gbk ) COLLATE gbk_chinese_ci asc";
	$dis_list = $db->getAll($sql);
}
$val->address_info = $dis_list;

die(json_encode($val));

?>