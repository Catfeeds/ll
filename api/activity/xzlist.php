<?php
/**
 * ECSHOP 用户登录 上海睿风信息技术有限公司添加
 
 * ============================================================================
 * * 版权所有 2005-2012 上海商派网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.ecshop.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * $Author: liubo $
 * $Id: goods.php 17217 2011-01-19 06:29:08Z liubo $
 */
/**
 * 获取易享赚列表接口
*/

define('IN_ECS', true);

require_once('../init.php');
require_once('../token.php');
require_once(ROOT_PATH . 'includes/cls_json.php');
require_once(ROOT_PATH . 'config/config.php');

$val = new stdClass();
$page_index= isset($_REQUEST['page_index'])? $_REQUEST['page_index']:'';
$page_size=isset($_REQUEST['page_size'])? $_REQUEST['page_size']:'';
if (!$page_index) {
    $page_index = '';
}
if (!$page_size) {
    $page_size = '';
}
$val->code = 101;
$val->msg = '操作成功';

$sql = "select id, img, hour(timediff(`start_time`,`end_time`)) as time, title from ecs_xiangzhuan
where start_time < now() and end_time > now() order by create_time desc";
//分页算法
if ($page_index != '' && $page_size != '') {
	$pageID = ($page_index - 1);
	if($pageID < 0){
		$pageID =0;
	}
	$pageID=$pageID*$page_size;
	$sql .= " LIMIT $page_size OFFSET $pageID";
}
$list = $db->getAll($sql);
$val->list = $list;
$val = json_encode($val);
die($val);
?>