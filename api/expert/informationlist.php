<?php
/*************************refineit*****************************/
/**
 * 易情报列表接口
*/

define('IN_ECS', true);

require_once('../init.php');
require_once('../token.php');

$val = new stdClass();
$page_index= isset($_POST['page_index'])? $_POST['page_index']:'';
$page_size=isset($_POST['page_size'])? $_POST['page_size']:'';

$val->code = 101;
$val->msg = '操作成功';

$sql = "select id, cover_img, title from ecs_information order by id desc";
//分页算法
if ($page_index != '' && $page_size != '') {
	$pageID = ($page_index - 1);
	if($pageID < 0){
		$pageID =0;
	}
	$pageID=$pageID*$page_size;
	$sql .= " LIMIT $page_size OFFSET $pageID";
}
$informationlist = $db->getAll($sql);

$val->informationlist = $informationlist;

$val = json_encode($val);

die($val);

?>