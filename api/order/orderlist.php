<?php
/*************************refineit*****************************/
/**
 * 订单列表接口
*/

define('IN_ECS', true);

require_once('../init.php');
require_once('config/config.php');
require_once('../token.php');

$val = new stdClass();
$uid = isset($_POST['uid'])? $_POST['uid']:'';//设备id
$token = isset($_REQUEST['token'])? $_REQUEST['token']:'';
$type = isset($_POST['type'])? $_POST['type']:0;//0:全部；1:待付款；2：待收货；3：退换货；4：已完成
$page_index= isset($_POST['page_index'])? $_POST['page_index']:'';
$page_size=isset($_POST['page_size'])? $_POST['page_size']:'';

if (empty($_POST['uid']) || !isset($_POST['type']) || empty($_POST['page_index']) || empty($_POST['page_size']) || empty($_POST['token']))
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
/**
 * 非退换货逻辑
 */
    $sql = "select order_id, order_sn, order_status,order_type, shipping_status, pay_status, goods_amount as goods_price, pay_name from ecs_order_info where user_id = '$uid'  and order_status <> 2";
    switch ($type) {
        case 1: $sql .= " AND pay_status = 0 AND order_status = 0";
        break;
        case 2: $sql .= " AND pay_status = 1 AND order_status = 0";
        break;
        case 4: $sql .= " AND order_status = 1";
        break;
        default: $sql .= ""; break;
    }
    $sql .= " order by order_id desc";
    $pageID = ($page_index - 1);
    if($pageID < 0){
        $pageID = 0;
    }
    $pageID=$pageID*$page_size;
    $sql .= " LIMIT $page_size OFFSET $pageID";
    $order1 = $db->getAll($sql);
    
    foreach ($order1 as $k=>$v) {
        $sql = "select goods_id, goods_name, goods_number, color_img, size, goods_thumb, cus_id from ecs_order_goods where order_id = {$v['order_id']}";
        $goods = $db->getRow($sql);
    
        $order1[$k]['goods_id'] = $goods['goods_id'];
        $order1[$k]['goods_name'] = $goods['goods_name'];
        $order1[$k]['goods_number'] = $goods['goods_number'];
        $order1[$k]['goods_thumb'] = $goods['goods_thumb'];
        //查询是否有未退换货的商品
        $sql = "select count(goods_id) as nums from ecs_order_goods where order_id = {$v['order_id']} and tdgood_type=0";
        $thnums = $db->getRow($sql);
        if($thnums['nums'] > 0){
            $order1[$k]['isbutton']=1;
        }else{
            $order1[$k]['isbutton']=0;
        }
        if ($goods['cus_id'] != 0) {
            $sql = "select cp.img from ecs_customize as c left join ecs_cus_color as cp on cp.id = c.color_id where c.id = '{$goods['cus_id']}'";
            $order1[$k]['color_img'] = $db->getOne($sql);
            $sql = "select size from ecs_user_info where user_id = '$uid'";
            $order1[$k]['size'] = $db->getOne($sql);
        } else {
            $order1[$k]['color_img'] = $goods['color_img'];
            $order1[$k]['size'] = $goods['size'];
        }
  /**
   * 退换货逻辑
   */
            //查询退换货订单中的内容
            $sql = "select id as thorder_id,order_id,order_type,rec_id,tuihuan_state from ecs_thorder_info where user_id = '$uid'";
            $sql .= " order by id desc";
            $pageID = ($page_index - 1);
            if($pageID < 0){
                $pageID = 0;
            }
            $pageID=$pageID*$page_size;
            $sql .= " LIMIT $page_size OFFSET $pageID";
            $order2 = $db->getAll($sql);
            //查询商品的详情
            foreach ($order2 as $k=>$v) {
                $sql = "select  goods_name,goods_price,color_img,size,goods_thumb,goods_type,cus_id from ecs_order_goods where rec_id = {$v['rec_id']}";
                $goods = $db->getRow($sql);
            
                $order2[$k]['order_sn'] = '';
                $order2[$k]['pay_name'] = '';
                $order2[$k]['order_status'] =4;
                $order2[$k]['shipping_status'] = 4;
                $order2[$k]['pay_status'] = '';
                $order2[$k]['goods_id'] = $v['rec_id'];
                $order2[$k]['goods_number'] = 1;
                $order2[$k]['goods_name'] = $goods['goods_name'];
                $order2[$k]['goods_price'] = $goods['goods_price'];
                $order2[$k]['goods_thumb'] = $goods['goods_thumb'];
                $order2[$k]['goods_type'] = $goods['goods_type'];
                $order2[$k]['isbutton']=0;
                if ($goods['cus_id'] != 0) {
                    $sql = "select cp.img from ecs_customize as c left join ecs_cus_color as cp on cp.id = c.color_id where c.id = '{$goods['cus_id']}'";
                    $order2[$k]['color_img'] = $db->getOne($sql);
                    $sql = "select size from ecs_user_info where user_id = '$uid'";
                    $order2[$k]['size'] = $db->getOne($sql);
                } else {
                    $order2[$k]['color_img'] = $goods['color_img'];
                    $order2[$k]['size'] = $goods['size'];
                }
            }          
    }
if($type==0){
    $order=array_merge_recursive($order1,$order2);
}elseif($type==3){
    $order=$order2;
}else{
    $order=$order1;
}
$val->order = $order;
$val = json_encode($val);

die($val);

?>