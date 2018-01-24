<?php
/**
 * ECSHOP 上海睿风信息技术有限公司添加
 
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
 * 获取我的预约列表接口
*/

define('IN_ECS', true);

require_once('../init.php');
require_once('../token.php');
require_once(ROOT_PATH . 'includes/cls_json.php');
require_once(ROOT_PATH . 'config/config.php');

$val = new stdClass();
$uid = isset($_REQUEST['uid'])? $_REQUEST['uid']:'';
$token = isset($_REQUEST['token'])? $_REQUEST['token']:'';
$type = isset($_REQUEST['type'])? $_REQUEST['type']:'';//1：线下服务，2：售后服务，3：VIP服务
$page_index= isset($_REQUEST['page_index'])? $_REQUEST['page_index']:'';
$page_size=isset($_REQUEST['page_size'])? $_REQUEST['page_size']:'';
if (empty($uid))
{
    $val->code = 201;
	$val->msg = '缺少必要的参数uid';
	die(json_encode($val));
}
if (!isset($type))
{
    $val->code = 301;
    $val->msg = '缺少必要的参数type';
    die(json_encode($val));
}
if(empty($token)) {
    $val->code = 400;
    $val->msg = '缺少必要的参数token';
    die(json_encode($val));
}
if (!$page_index) {
    $page_index = '';
}
if (!$page_size) {
    $page_size = '';
}
//检查用户的登录状态
$sql = "select * from" . $ecs->table("user_session") . "where token = '" . $token . "'";
$result = check_token($token, $sql, $db, $ecs);
if($result['code'] == "101")
{
    if(!empty($result['uid'])) {
        if(strcmp($result['uid'], $uid) != 0) {
            $val->code = 400;
            $val->msg = '该token不属于用户'. $uid;
            die(json_encode($val));
        }
    } else {
        echo "check token rerurn empty uid";
    }
} else {
    exit(json_encode($result));
}

$val->code = 101;
$val->msg = '操作成功';

$sql = "select a.id, a.state, s.icon, s.name, s.phone from ecs_appointment as a".
		" left join ecs_service as s on s.id = a.ser_id".
		" where a.user_id = $uid";
if (!empty($type)) {
	$sql .= " and a.type = '$type'";
}
$sql .= " order by a.id desc";
//分页算法
if ($page_index != '' && $page_size != '') {
	$pageID = ($page_index - 1);
	if($pageID < 0){
		$pageID =0;
	}
	$pageID=$pageID*$page_size;
	$sql .= " LIMIT $page_size OFFSET $pageID";
}
$val->list = $db->getAll($sql);
   
$val = json_encode($val);
die($val);
?>