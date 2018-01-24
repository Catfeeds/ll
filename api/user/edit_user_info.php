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
 * 修改用户信息接口
*/

define('IN_ECS', true);

require_once('../init.php');
require_once('../token.php');
require_once(ROOT_PATH . 'includes/cls_image.php');
require_once(ROOT_PATH . 'includes/cls_json.php');
require_once(ROOT_PATH . 'config/config.php');
//会员头像 by neo
$image = new cls_image($_CFG['bgcolor']);//会员头像 by neo
$allow_suffix = array('gif', 'jpg', 'png', 'jpeg', 'bmp');//会员头像 by neo

$val = new stdClass();
$uid = isset($_POST['uid'])? $_POST['uid']:'';
$avatar = isset($_POST['avatar'])? $_POST['avatar']:'';
$nick_name = isset($_POST['nick_name'])? $_POST['nick_name']:'';
$token = isset($_REQUEST['token'])? $_REQUEST['token']:'';
$lng = isset($_REQUEST['lng'])? $_REQUEST['lng']:'';
$lat = isset($_REQUEST['lat'])? $_REQUEST['lat']:'';
$type = isset($_REQUEST['type'])? $_REQUEST['type']:'';
$real_name = isset($_REQUEST['real_name']) ? $_REQUEST['real_name']:'';
$alipy_acount = isset($_REQUEST['alipy_acount']) ? $_REQUEST['alipy_acount']:'';
if (empty($_POST['uid']))
{
    $val->code = 201;
	$val->msg = '缺少必要的参数uid';
	die(json_encode($val));
}
 if(empty($token)) {
    $val->code = 400;
    $val->msg = '缺少必要的参数token';
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
//执行下面的修改逻辑
$parent = array();
if (!empty($_FILES['avatar']))
{
    //会员头像 by neo
    if (!empty($_FILES['avatar']))
    {
        /* 更新会员头像之前先删除旧的头像 */
        $sql = "SELECT avatar " .
            " FROM " . $GLOBALS['ecs']->table('users') .
            " WHERE user_id = '$uid'";
         
        $row = $GLOBALS['db']->getRow($sql);
         
        if ($row['avatar'] != '')
        {
            @unlink($row['avatar']);
        }
        //获取文件后缀名，并重命名文件
        
        $avatar = $image->upload_image($_FILES['avatar'], 'avatar'); // 原始图片
         
        //$avatar = $image->make_thumb($original_img, 55, 55, $target);
        if ($avatar === false)
        {
            $val->code = 102;
            $val->msg = '图片保存出错！';
            die(json_encode($val));
        }
    }
	$parent['avatar'] = $avatar;
	
}
if (!empty($_POST['nick_name']))
{
	$parent['nick_name'] = $nick_name;
}
if (!empty($_POST['lng']))
{
	$parent['lng'] = $lng;
}
if (!empty($_POST['lat']))
{
	$parent['lat'] = $lat;
}
if (!empty($_POST['type']))
{
   if($_POST['type'] == 1){
       $parent['is_qq'] = 1;
   }
   if($_POST['type'] == 2){
       $parent['is_weixin'] = 1;
   }
   if($_POST['type'] == 3){
       $parent['is_weobo'] = 1;
   }
   if($_POST['type'] == 4){
       $parent['is_qq'] = 0;
   }
   if($_POST['type'] == 5){
       $parent['is_weixin'] = 0;
   }
   if($_POST['type'] == 6){
       $parent['is_weobo'] = 0;
   } 
}

if(!empty($_POST['real_name'])){
    $parent['real_name'] = $real_name;
}

if(!empty($_POST['alipy_acount'])){
    $parent['alipy_acount'] = $alipy_acount;
}

$db->autoExecute('ecs_users', $parent, "UPDATE", "user_id = '$uid'");

$val->code = 101;
$val->msg = '操作成功';
die(json_encode($val));

?>