<?php
/*************************refineit*****************************/
/**
 * 退换货创建订单接口
*/

define('IN_ECS', true);

require_once('../init.php');
require_once('config/config.php');
require_once('../token.php');
require_once(ROOT_PATH . 'includes/cls_image.php');
$image = new cls_image($_CFG['bgcolor']);

$val = new stdClass();
$uid = isset($_POST['uid'])? $_POST['uid']:'';//用户id
$token = isset($_REQUEST['token'])? $_REQUEST['token']:'';
$clientUUID = isset($_POST['clientUUID'])? $_POST['clientUUID']:'';//设备id
$order_id = isset($_POST['order_id'])? $_POST['order_id']:'';//原始订单id
$rec_id = isset($_POST['rec_id'])? $_POST['rec_id']:'';//原始订单商品表id
$order_type= isset($_POST['order_type'])? $_POST['order_type']:'';//类型1：退货 2：换货
$tdgood_question = isset($_POST['tdgood_question'])? $_POST['tdgood_question']:'';//退换货问题描述
$files = isset($_FILES['files'])? $_FILES['files']:'';//退换货问题图片数组最多3个
if (empty($_POST['clientUUID']) || empty($_POST['uid']) || empty($_POST['token'])|| empty($_POST['order_id'])|| empty($_POST['rec_id'])|| empty($_POST['order_type'])|| empty($_POST['tdgood_question'])|| empty($files))
{
    $val->code = 201;
	$val->msg = '缺少必要的参数';
	die(json_encode($val));
}
//token
$sql = "select * from" . $ecs->table("user_session") . "where token = '" . $token . "'";
$result = check_token($token, $sql, $db, $ecs);
if($result['code'] == "101")
{
	if(!empty($result['uid'])) {
		if(strcmp($result['uid'], $uid) != 0) {
			$result = array("code"=> "400", "msg"=> "该token不属于用户" . $uid);
			die(json_encode($result));
		}
	} else {
		echo "check token rerurn empty uid";
	}
} else {
	die(json_encode($result));
}

$val->code = 101;
$val->msg = '操作成功';
//添加ecs_thorder_info表
$order_data = array(
        'user_id'	=>	$uid,
        'order_id'	=>	$order_id,
        'rec_id'	=>$rec_id,
        'thorder_sn'	=>	$uid+time(),
        'order_type'	=>	$order_type,
        'tuihuan_state'	=>	0,
		'create_time' => time(),
);
$db->autoExecute('ecs_thorder_info', $order_data, "INSERT");
$thorder_id = mysql_insert_id();
//更新订单商品表中的订单商品状态
$parent = array(
	'thorder_id'		=>	$thorder_id,
	'tdgood_type'		=>	$order_type,
	'tdgood_question'	=>	$tdgood_question,
);
$db->autoExecute('ecs_order_goods', $parent, "UPDATE", "rec_id = '$rec_id'");
//插入退换货物品相册
$sql = "select count(*) as nums  from ecs_thgood_icon where thgood_id = '$rec_id'";
$icon_nums = $db->getRow($sql);
if($icon_nums['nums'] ==0){
    $icon=array();
    $icon['thgood_id']=$rec_id;
    foreach ($files['name'] as $k=>$v) {
        $file = array();
        $file['name'] = $v;
        $file['tmp_name'] = $files['tmp_name'][$k];
        $file['error'] = $files['error'][$k];
        $file['size'] = $files['size'][$k];
        $icon['img'] = $image->upload_image($file, 'bask');
        $db->autoExecute('ecs_thgood_icon', $icon, "INSERT");
    }
}else{
    $val->msg = '图片已存在上传失败';
}

//插入退换货记录中
$order_jilu = array(
    'order_type'	=>	1,
    'thorder_id'	=>	$thorder_id,
    'order_id'	=>$order_id,
    'remark'	=>'退换货申请正在审核',
    'th_type'	=>	0,
    'create_time' =>date('Y-m-d H:i:s'),
);
$db->autoExecute('ecs_delivery_order', $order_jilu, "INSERT");
//返回数据：退换货订单id
$val->thorder_id = $thorder_id;
$val = json_encode($val);

die($val);

?>