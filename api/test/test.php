<?php
/*************************refineit*****************************/
/**
 * 主页信息接口
*/

define('IN_ECS', true);

require_once('../init.php');

$val = new stdClass();

$val->code = 101;
$val->msg = '操作成功';
//brand
$sql = "select brand_id,brand_name from ecs_brand";
$brand_list = $db->getAll($sql);

$val->brand_list = $brand_list;
//test
$sql = "select id,msg from test";
$val->test = $test_db->getAll($sql);


$val = json_encode($val);

die($val);

?>