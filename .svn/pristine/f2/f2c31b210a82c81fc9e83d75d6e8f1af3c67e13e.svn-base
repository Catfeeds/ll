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
 * 修改手机号接口
*/

define('IN_ECS', true);

require_once('../init.php');
require_once('../token.php');
require_once(ROOT_PATH . 'includes/cls_json.php');
require_once(ROOT_PATH . 'config/config.php');

$val = new stdClass();
$uid = isset($_POST['uid'])? $_POST['uid']:'';
$phone = isset($_POST['phone'])? $_POST['phone']:'';
$sms_code = isset($_REQUEST['code'])? $_REQUEST['code']:'';
$token = isset($_REQUEST['token'])? $_REQUEST['token']:'';
if (empty($_POST['uid']))
{
    $val->code = 201;
	$val->msg = '缺少必要的参数uid';
	die(json_encode($val));
}
if(empty($phone)) {
	$val->code = 201;
	$val->msg = '缺少必要的参数phone';
	die(json_encode($val));
}
 if(empty($token)) {
    $val->code = 400;
    $val->msg = '缺少必要的参数token';
    die(json_encode($val));
}
if (empty($_POST['code']))
{
    $val->code = 201;
    $val->msg = '缺少必要的参数code';
    die(json_encode($val));
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
if ($user->check_user($phone, null)>0) {
	$result = array("code" => "401", "msg" => "用户已经存在");
	die(json_encode($result));
}
//执行下面的修改逻辑
$parent = array();
$parent['user_name'] = $phone;
$db->autoExecute('ecs_users', $parent, "UPDATE", "user_id = '$uid'");
$val->code = 101;
$val->msg = '操作成功';
die(json_encode($val));

?>