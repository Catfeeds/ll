<?php
/*************************refineit*****************************/
/**
 * 达人发布信息列表接口
*/

define('IN_ECS', true);

require_once('../init.php');
require_once('../token.php');

$val = new stdClass();
$sty_id = isset($_POST['sty_id'])? $_POST['sty_id']:'';
$page_index= isset($_POST['page_index'])? $_POST['page_index']:'';
$page_size=isset($_POST['page_size'])? $_POST['page_size']:'';

$val->code = 101;
$val->msg = '操作成功';

$sql = "select s.id as sty_id, s.name, s.avatar, e.id as exp_id, e.cover_img, e.title, e.pl_count, e.fx_count, e.create_time from ecs_expert as e left join ecs_stylist as s on s.id = e.sty_id";
if ( !empty($_POST['sty_id']) ) {
	$sql .= " where e.sty_id = $sty_id";
}
$sql .= " order by e.id desc";
//分页算法
if ($page_index != '' && $page_size != '') {
	$pageID = ($page_index - 1);
	if($pageID < 0){
		$pageID =0;
	}
	$pageID=$pageID*$page_size;
	$sql .= " LIMIT $page_size OFFSET $pageID";
}
$expertlist = $db->getAll($sql);

$val->expertlist = $expertlist;

$val = json_encode($val);

die($val);

?>