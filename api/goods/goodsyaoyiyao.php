<?php
/*************************refineit*****************************/
/**
 * 摇一摇看搭配接口
*/

define('IN_ECS', true);

require_once('../init.php');

$val = new stdClass();

$id = isset($_POST['id'])? $_POST['id']:'';
if (empty($_POST['id']))
{
    $val->code = 201;
    $val->msg = '缺少必要的参数';
    die(json_encode($val));
}
$val->code = 101;
$val->msg = '操作成功';
//该商品对应的品牌id
$sql = "select brand_id from ecs_goods where goods_id = '{$id}'";
$brand_id = $db->getOne($sql);
//取goods表10条记录
$sql = "select eg.goods_id,eg.goods_name,eg.market_price,eg.goods_thumb,eg.shop_price,eg.dapei_img,eb.brand_name from ecs_goods as eg left join ecs_brand as eb on eb.brand_id = eg.brand_id where eg.brand_id = '$brand_id'";

$sql .= " order by rand() limit 10";

$val->goodsyaoyiyao_list = $db->getAll($sql);
$val = json_encode($val);

die($val);

?>