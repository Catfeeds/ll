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
 * 获取我的收藏接口
*/

define('IN_ECS', true);

require_once('../init.php');
require_once('../token.php');
require_once(ROOT_PATH . 'includes/cls_json.php');
require_once(ROOT_PATH . 'config/config.php');

$val = new stdClass();
$uid = isset($_REQUEST['uid'])? $_REQUEST['uid']:'';
$token = isset($_REQUEST['token'])? $_REQUEST['token']:'';
$type = isset($_REQUEST['type'])? $_REQUEST['type']:'';
$page_index= isset($_REQUEST['page_index'])? $_REQUEST['page_index']:'';
$page_size=isset($_REQUEST['page_size'])? $_REQUEST['page_size']:'';
if (empty($uid))
{
    $val->code = 201;
	$val->msg = '缺少必要的参数uid';
	die(json_encode($val));
}
if (empty($type))
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
//执行下面的查询收藏的逻辑
$val->code = 101;
$val->msg = '操作成功';
//当type=1时获取收藏的商品列表
if($type==1){
    $sql = "select ecg.rec_id,ecg.tar_id as goods_id,ecg.add_time,eg.goods_name,eg.goods_thumb,eg.market_price from ecs_collect as ecg".
        " left join ecs_goods as eg on eg.goods_id = ecg.tar_id".
        " where ecg.user_id = $uid and eg.goods_id !='' and ecg.type = 1";
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
}
//当type等于2时获取品牌列表
if($type==2){
    $sql = "select ecb.rec_id,ecb.tar_id as brand_id,ecb.add_time,eb.icon as brand_icon,eb.brand_name from ecs_collect as ecb".
        " left join ecs_brand as eb on eb.brand_id = ecb.tar_id".
        " where ecb.user_id = $uid and eb.brand_id !='' and ecb.type = 2";
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
}
$val = json_encode($val);
die($val);
?>