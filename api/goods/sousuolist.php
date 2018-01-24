<?php
/*************************refineit*****************************/
/**
 * 品牌、产品、款式、风格、色彩智能搜索提示列表接口
*/

define('IN_ECS', true);

require_once('../init.php');

$val = new stdClass();
$keywords = isset($_POST['keywords'])? $_POST['keywords']:'';
if (empty($_POST['keywords']))
{
    $val->code = 201;
    $val->msg = '请输入搜索关键字keywords';
    die(json_encode($val));
}
$val->code = 101;
$val->msg = '操作成功';
$sousuo=array();
//品牌列表
$sql = "select brand_name  as name,1 as type from ecs_brand where brand_name like '%$keywords%' and is_show = 1 order by brand_id desc";
$brands_list = $db->getAll($sql);
//商品列表
$sql2 = "select goods_name as name,2 as type from ecs_goods where goods_name like '%$keywords%' and is_on_sale = 1 order by goods_id desc";
$goods_list = $db->getAll($sql2);
//款式列表
$sql3 = "select name,3 as type from ecs_classify where name like '%$keywords%' and classify_type = 1 order by id desc";
$kuanshi_list = $db->getAll($sql3);
//风格列表
$sql4 = "select name,4 as type from ecs_classify where name like '%$keywords%' and classify_type = 4 order by id desc";
$style_list = $db->getAll($sql4);
//色彩列表
$sql3 = "select name,5 as type from ecs_color where name like '%$keywords%' order by id desc";
$color_list = $db->getAll($sql3);
$sousuo=array_merge_recursive($brands_list,$goods_list,$kuanshi_list,$style_list,$color_list);
$val->sousuolist = $sousuo;
$val = json_encode($val);

die($val);

?>