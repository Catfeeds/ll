<?php
/*************************refineit*****************************/
/**
 * 订单列表接口
 */
define ( 'IN_ECS', true );

require_once ('../init.php');
require_once ('config/config.php');
require_once ('../token.php');

$val = new stdClass ();
$token = isset ( $_REQUEST ['token'] ) ? $_REQUEST ['token'] : '';
$list = isset ( $_REQUEST ['list'] ) ? $_REQUEST ['list'] : '';//json

if (empty ( $_POST ['token'] ) || empty ( $_POST ['list'] )) {
	$val->code = 201;
	$val->msg = '缺少必要的参数';
	die ( json_encode ( $val ) );
}
// token
if (md5($token) != Token) {
	$val->code = 102;
	$val->msg = 'Token错误';
	die ( json_encode ( $val ) );
}


$val->code = 101;
$val->msg = '操作成功';
foreach ( $list as $k => $v ) {
	$sql = "select id from ecs_specification where value = '{$v['size']}'";
	$specification = $db->getRow ( $sql );
	$sp_id = $specification['id'];
	$sql = "select id from ecs_goods where goods_sn = '{$v['goods_sn']}'";
	$goods = $db->getRow ( $sql );
	$g_id = $goods['id'];
	
	$parent = array();
	if (isset($v['nums']))
	{
		$parent['nums'] = $v['nums'];
	}
	$db->autoExecute('ecs_spec_goods', $parent, "UPDATE", "goods_id = '$g_id' and spec_id = '$g_id'");
}

$val = json_encode ( $val );

die ( $val );

?>