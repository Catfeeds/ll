<?php
/*************************refineit*****************************/
/**
 * 筛选品牌列表接口
*/

define('IN_ECS', true);

require_once('../init.php');
require_once(ROOT_PATH . 'includes/cls_log.php');
require_once(ROOT_PATH . 'includes/cls_message.php');
require_once(ROOT_PATH . 'config/config.php');

$val = new stdClass();

$val->code = 101;
$val->msg = '操作成功';

//推送信息
$msg = new ecs_message();
$c = $msg->delete_aliatses(1);
$val->c = $c;

$val = json_encode($val);

die($val);

?>