<?php 
ini_set('date.timezone','Asia/Shanghai');
//error_reporting(E_ERROR);
require_once "lib/WxPay.Api.php";
//require_once "unit/WxPay.JsApiPay.php";

class WxPayindex
{
	public function unifiedOrder(){
		//获取用户openid
		//$tools = new JsApiPay();
		//$openId = $tools->GetOpenid();
		//统一下单
		$input = new WxPayUnifiedOrder();
		$input->SetBody("test");
		$input->SetAttach("test");
		$input->SetOut_trade_no(WxPayConfig::MCHID.date("YmdHis"));
		$input->SetTotal_fee("1");
		$input->SetTime_start(date("YmdHis"));
		$input->SetTime_expire(date("YmdHis", time() + 600));
		$input->SetGoods_tag("test");
		$input->SetNotify_url(WxPayConfig::NOTIFY_URL);
		$input->SetTrade_type("APP");
		//$input->SetOpenid($openId);
		$order = WxPayApi::unifiedOrder($input);
		//echo '<font color="#f00"><b>统一下单支付单信息</b></font><br/>';
		//printf_info($order);
		//$jsApiParameters = $tools->GetJsApiParameters($order);
		//echo $jsApiParameters;
		return $order;
	}
}
?>
