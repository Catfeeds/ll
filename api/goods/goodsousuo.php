<?php
/*************************refineit*****************************/
/**
 * 商品分类搜索接口
*/

define('IN_ECS', true);

require_once('../init.php');

$val = new stdClass();
$keywords = isset($_POST['keywords'])? $_POST['keywords']:'';
$type = isset($_POST['type'])? $_POST['type']:'';
$page_index= isset($_POST['page_index'])? $_POST['page_index']:'';
$page_size=isset($_POST['page_size'])? $_POST['page_size']:'';
if (!$page_index) {
    $page_index = '';
}
if (!$page_size) {
    $page_size = '';
}
if (empty($_POST['keywords']))
{
    $val->code = 201;
    $val->msg = '请输入搜索关键字';
    die(json_encode($val));
}
$val->code = 101;
$val->msg = '操作成功';
//goods列表
if($type==1){
    //按品牌名搜索
    $sql = "select goods_id,goods_sn,goods_name,brand_name,goods_thumb,goods_img,original_img,market_price,shop_price,promote_price from ecs_goods where brand_name like '%$keywords%' and is_on_sale = 1 order by sort_order";
}elseif($type==2){
    //按商品名搜索
    $sql = "select goods_id,goods_sn,goods_name,brand_name,goods_thumb,goods_img,original_img,market_price,shop_price,promote_price from ecs_goods where goods_name like '%$keywords%' and is_on_sale = 1 order by sort_order";
}elseif($type==3){
    //按款式名称搜索
    $sql = "select g.goods_id,g.goods_sn,g.goods_name,g.brand_name,g.goods_thumb,g.goods_img,g.original_img,g.market_price,g.shop_price,g.promote_price from ecs_goods as g left join ecs_classify as cl on cl.id=g.classify_ids where cl.name like '%$keywords%' and g.is_on_sale = 1 and cl.classify_type = 1 order by g.sort_order";
}elseif($type==4){
    //按风格名搜索
    $sql = "select g.goods_id,g.goods_sn,g.goods_name,g.brand_name,g.goods_thumb,g.goods_img,g.original_img,g.market_price,g.shop_price,g.promote_price from ecs_goods as g left join ecs_classify as cl on cl.id=g.classify_ids where cl.name like '%$keywords%' and g.is_on_sale = 1 and cl.classify_type = 4 order by g.sort_order";
}elseif($type==5){
    //按色彩名搜索
    $sql = "select g.goods_id,g.goods_sn,g.goods_name,g.brand_name,g.goods_thumb,g.goods_img,g.original_img,g.market_price,g.shop_price,g.promote_price from ecs_goods as g left join ecs_color as cl on cl.id=g.color_id where cl.name like '%$keywords%' and g.is_on_sale = 1 order by g.sort_order";
}else{
    $sql = "select goods_id,goods_sn,goods_name,brand_name,goods_thumb,goods_img,original_img,market_price,shop_price,promote_price from ecs_goods where (brand_name like '%$keywords%' or goods_name like '%$keywords%' or keywords like '%$keywords%') and is_on_sale = 1 order by sort_order";
}
//分页算法
if ($page_index != '' && $page_size != '') {
    $pageID = ($page_index - 1);
    if($pageID < 0){
        $pageID =0;
    }
    $pageID=$pageID*$page_size;
    $sql .= " LIMIT $page_size OFFSET $pageID";
}
$val->goods_list = $db->getAll($sql);
$val = json_encode($val);

die($val);

?>