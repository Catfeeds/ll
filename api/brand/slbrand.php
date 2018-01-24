<?php
/*************************refineit*****************************/
/**
 * 筛选品牌列表接口
*/

define('IN_ECS', true);

require_once('../init.php');

$val = new stdClass();
$page_index= isset($_POST['page_index'])? $_POST['page_index']:'';
$page_size=isset($_POST['page_size'])? $_POST['page_size']:'';

$val->code = 101;
$val->msg = '操作成功';
//brand
$sql = "select brand_id,brand_name,icon from ecs_brand where is_show = 1 order by sort_order";
//分页算法
if ($page_index != '' && $page_size != '') {
	$pageID = ($page_index - 1);
	if($pageID < 0){
		$pageID =0;
	}
	$pageID=$pageID*$page_size;
	$sql .= " LIMIT $page_size OFFSET $pageID";
}
$brand_list = $db->getAll($sql);

$val->brand_list = $brand_list;

$val = json_encode($val);

die($val);

?>