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
 * 找回用户密码接口
*/

define('IN_ECS', true);

require_once('../init.php');
require_once('../token.php');
require_once(ROOT_PATH . 'includes/cls_json.php');
require_once(ROOT_PATH . 'config/config.php');

$val = new stdClass();
$username = isset($_POST['username'])? $_POST['username']:'';
$password = isset($_POST['password'])? $_POST['password']:'';
$respassword = isset($_POST['respassword'])? $_POST['respassword']:'';
if (empty($_POST['username']))
{
    $val->code = 201;
	$val->msg = '缺少必要的参数username';
	die(json_encode($val));
}
if (empty($_POST['password']))
{
    $val->code = 201;
    $val->msg = '缺少必要的参数password';
    die(json_encode($val));
}
if (empty($_POST['respassword']))
{
    $val->code = 201;
    $val->msg = '缺少必要的参数respassword';
    die(json_encode($val));
}
//执行下面的修改逻辑
$parent = array();
if($password != $respassword){
    $val->code = 102;
    $val->msg = '两次输入密码不一致';
    die(json_encode($val));
}else{
	$parent['password'] = MD5($password);
}
$db->autoExecute('ecs_users', $parent, "UPDATE", "user_name = '$username'");
$val->code = 101;
$val->msg = '操作成功';
die(json_encode($val));

?>