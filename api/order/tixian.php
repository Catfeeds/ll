<?php
/*************************refineit*****************************/
/**
 * 提现接口
 */
define ( 'IN_ECS', true );

require_once ('../init.php');

$val = new stdClass ();

//$account = isset ( $_POST ['account'] ) ? $_POST ['account'] : ''; // 账号
//$name = isset ( $_POST ['name'] ) ? $_POST ['name'] : ''; // 姓名
$price = isset ( $_POST ['price'] ) ? $_POST ['price'] : ''; // 金额
$uid = isset ( $_POST ['uid'] ) ? $_POST ['uid'] : ''; // 用户id
                                                          
// 必填参数
if (empty ( $_POST ['price'] ) || empty ( $_POST ['uid'] )) {
	$val->code = 201;
	$val->msg = '缺少必要的参数';
	die ( json_encode ( $val ) );
}

$val->code = 101;
$val->msg = '操作成功';
/* 取得商品信息 */
$sql = "SELECT * " . " FROM ecs_users" . " WHERE user_id = '$uid'";
$user = $db->getRow ( $sql );
if (empty ( $user )) {
	$val->code = 102;
	$val->msg = '该用户不存在';
	die ( json_encode ( $val ) );
}

$acount = $user['user_money'];
if($price > $acount){
	$val->code = 103;
	$val->msg = '提现金额超过钱包余额';
	die ( json_encode ( $val ) );
}

$tx_data = array(
		'name'	=>	$user['real_name'],
		'account'	=>	$user['alipy_acount'],
		'price'	=> $price,
		'uid'	=>	$uid,
		'state'	=>	0,
		'ctime' => time(),
);
$db->autoExecute('ecs_tixian', $tx_data, "INSERT");

$parent = array();
$parent['user_money'] = $acount-$price;
$db->autoExecute('ecs_users', $parent, "UPDATE", "user_id = '$uid'");


$val = json_encode ( $val );

die ( $val );

?>