<?php
/*************************refineit*****************************/
/**
 * 分享商品接口
 */
define ( 'IN_ECS', true );

require_once ('../init.php');
require_once ('../token.php');

$val = new stdClass ();
$uid = isset ( $_REQUEST ['uid'] ) ? $_REQUEST ['uid'] : '';
$goods_id = isset ( $_REQUEST ['goods_id'] ) ? $_REQUEST ['goods_id'] : '';
$source = isset ( $_REQUEST ['source'] ) ? $_REQUEST ['source'] : '';
$url = isset ( $_REQUEST ['url'] ) ? $_REQUEST ['url'] : '';
$unid = isset ( $_REQUEST ['unid'] ) ? $_REQUEST ['unid'] : '';

$parent = array ();
$parent ['superior_id'] = $uid;
$parent ['goods_id'] = $goods_id;
$parent ['source'] = $source;
$parent ['create_time'] = date ( "Y-m-d H:i:s" );
$parent ['unid'] = $unid;
$db->autoExecute ( 'ecs_share', $parent, "INSERT" );

$mold = 1;//第三方平台分享
if ($uid != '') {
	$mold = 2;//个人分享
	$source = $uid;
}

$url = $url . "?id=$goods_id&source=$source&mold=$mold&unid=$unid&up=index";

header("location:$url");

?>