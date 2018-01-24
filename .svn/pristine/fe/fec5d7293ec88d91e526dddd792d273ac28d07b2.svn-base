<?php

/*************************refineit*****************************/
/**
 * 提交提现记录接口
 */

define('IN_ECS', true);

require_once('../init.php');
require_once('../token.php');

$val = new stdClass();

$uid = isset($_POST['uid'])? $_POST['uid']:'';//设备id
$token = isset($_REQUEST['token'])? $_REQUEST['token']:'';
$money = isset($_REQUEST['money']) ? $_REQUEST['money']:'';

if (empty($_POST['uid']) || empty($_POST['token']) || empty($_POST['money'])){
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

$data['user_id'] = $uid;
$data['money'] = $money;
$data['add_time'] = date('Y-m-d H:i:s');
$db->autoExecute("ecs_tixian_record",$data,"INSERT");

$val->id = mysql_insert_id();
$val = json_encode($val);

die($val);



?>