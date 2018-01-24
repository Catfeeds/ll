<?php 
ini_set('date.timezone','Asia/Shanghai');
//error_reporting(E_ERROR);
require_once "lib/WxPay.Api.php";
//require_once "unit/WxPay.JsApiPay.php";
require_once 'unit/log.php';
define('IN_ECS', true);

//接收订单号
$out_trade_no = $_REQUEST['order_sn'];
//接受订单id
$order_id=$_REQUEST['order_id'];
//价格
$price=$_REQUEST['price'];
//初始化日志
$logHandler= new CLogFileHandler("./logs/".date('Y-m-d').'.log');
$log = Log::Init($logHandler, 15);

function printf_info($data)
{
    foreach($data as $key=>$value){
        echo "<font color='#00ff55;'>$key</font> : $value <br/>";
    }
}
//获取用户openid
//$tools = new JsApiPay();
//$openId = $tools->GetOpenid();
//统一下单
if ( $_REQUEST['body'] == '' ) {
	$_REQUEST['body'] = '来龙教育-积分充值';
}
$body = '来龙教育-积分充值';
//$attach = iconv ( "gbk", "utf-8", $_REQUEST['attach'] );
$input = new WxPayUnifiedOrder();
$input->SetBody($body);
$input->SetAttach($order_id);
$input->SetOut_trade_no($out_trade_no);
$input->SetTotal_fee($price*100);
$input->SetTime_start(date("YmdHis"));
//$input->SetGoods_tag("test");
$input->SetNotify_url(NOTIFY_URL);
$log->DEBUG(json_encode(NOTIFY_URL));
$input->SetTrade_type("APP");
//$input->SetOpenid($openId);
$order = WxPayApi::unifiedOrder($input);
//echo '<font color="#f00"><b>统一下单支付单信息</b></font><br/>';
// printf_info($order);
//$jsApiParameters = $tools->GetJsApiParameters($order);
//echo $jsApiParameters;
$log->DEBUG(json_encode($order));
if ($order['result_code'] == "SUCCESS") {
  $pay_order = array();
  $pay_order['appid'] = $order['appid'];
  $pay_order['noncestr'] = $order['nonce_str'];
  $pay_order['package'] = "Sign=WXPay";
  $pay_order['partnerid'] = $order['mch_id'];
  $pay_order['timestamp'] = time();
  $pay_order['prepayid'] = $order['prepay_id'];
  $result = new WxPayResults();

  $result->FromArray($pay_order);
  $result->SetSign();
  $pay_order['sign'] = $result->GetSign();

  $pay_order ['code'] = '101';
  $pay_order ['url'] = NOTIFY_URL;
  //$order ['input'] = $input->GetValues();
  echo json_encode($pay_order);
  $log->DEBUG(json_encode($order));
} else {
  $order ['code'] = '102';
  $order ['input'] = $input->GetValues();
  echo json_encode($order);
}
?>
