<?php
/*************************refineit*****************************/
/**
 * 易搭配列表接口
*/

define('IN_ECS', true);

require_once('../init.php');
require_once('../token.php');

$val = new stdClass();
$page_index= isset($_POST['page_index'])? $_POST['page_index']:'';
$page_size=isset($_POST['page_size'])? $_POST['page_size']:'';

$val->code = 101;
$val->msg = '操作成功';

$sql = "select id, img from ecs_match order by create_time";
//分页算法
if ($page_index != '' && $page_size != '') {
	$pageID = ($page_index - 1);
	if($pageID < 0){
		$pageID =0;
	}
	$pageID=$pageID*$page_size;
	$sql .= " LIMIT $page_size OFFSET $pageID";
}
$matchlist = $db->getAll($sql);

foreach ($matchlist as $k=>$v) {
	$img = getimagesize(ROOT_PATH . $v['img']);
	$matchlist[$k]['weight'] = $img[0];
	$matchlist[$k]['height'] = $img[1];
}

$val->matchlist = $matchlist;

$val = json_encode($val);

die($val);

?>