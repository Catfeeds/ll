<?php
namespace Weixin\Controller;
use Common\Controller\HomebaseController;
use Think\Log;
class WxpayController extends HomebaseController{
	//支付回调
    function notify(){
		error_log(date("Y-m-d H:i:s")."返回参数：".json_encode($_REQUEST)." \r\n",3,'error.log');
		$log = new Log();
		$log->write(date("Y-m-d H:i:s")."返回参数：".json_encode($_REQUEST));  
    	$order_sn2=$_REQUEST['out_trade_no'];//夹带时间戳
    	//匹配
		$op = M("order")->where("order_id_time = '$order_sn2'")->find();
		if(empty($op)){
			return false;
		}
		$order_sn = explode("_",$order_sn2);
		$order_sn = $order_sn[0];
		$orderid = $_REQUEST['attach'];
		if($_REQUEST['cash_fee']){
			$state = 1;
		}else{
			$state = 2;
		}
		$pay_money = $_REQUEST['cash_fee']/100;
		$data = array(
				'updatetime'=>date("Y-m-d H:i:s"),
				'state'=>$state,
				'pay_amount'=>$pay_money,
				'ext_order_id'=>$_REQUEST['transaction_id'],
		);
		//更改订单状态
		$success = M("order")->where("id = $orderid")->save($data);
		if($success){
			//积分记录
			$data_i = array(
				"user_id"=>$op['user_id'],
				"obtain_type"=>"4",
				"is_obtain"=>"1",
				"integral"=>$op['integral'],
				"content"=>"购买积分：".$op['integral'],
				"createtime"=>date("Y-m-d H:i:s"),
			);
			M("integral")->add($data_i);
			//更新用户表
			//用户表原积分 + 充值积分
			$user = M("user")->where("id = $op[user_id]")->find();
			$now_integral = $user['integral'] + $op['integral'];
			$data_u = array(
				"integral"=>$now_integral,
			);
			M("user")->where("id = $op[user_id]")->save($data_u);
			//发送模板信息
			$data_t = array (
					'productType' => array ( 'value' => urlencode ( "积分" )),
					'name' => array ( 'value' => urlencode ( $pay_money."元现金" )),
					'number' => array ( 'value' => urlencode ( "1份" )),
					'expDate' => array ( 'value' => urlencode (date("Y-m-d",time()+$timend*3600*24))),
					'remark'=>array ( 'value' => urlencode (trim($str,','))),
			);
			//用户openid
			$user = M("user")->where("id = $op[user_id]")->find();
			$this->doSend ( 0, $user['openid'], BUY_MODEL,"", $data_t );
			return true;
		}else{
			$log->write(date("Y-m-d H:i:s")."修改参数：".json_encode($data));
			return true;
		}
    }
    // 发送自定义的模板消息
	public function doSend($id, $touser, $template_id, $url, $data, $topcolor = '#7B68EE') {
	    /*
	     * $data = array ( 'first' => array ( 'value' => urlencode ( "您好,您已购买成功" ), 'color' => "#743A3A" ), 'name' => array ( 'value' => urlencode ( "商品信息:微时代电影票" ), 'color' => '#EEEEEE' ), 'remark' => array ( 'value' => urlencode ( '永久有效!密码为:1231313' ), 'color' => '#FFFFFF' ) );
	     */
	    $log = new Log();
	    
	    $template = array (
	        'touser' => $touser,
	        'template_id' => $template_id,
	        'url' => $url,
	        'topcolor' => $topcolor,
	        'data' => $data
	    );
	    $json_template = json_encode ( $template );
	    $log->write($json_template.'111');
	    $access_token = $this->get_access_token();
	    $log->write($access_token.'222');
	    $url = "https://api.weixin.qq.com/cgi-bin/message/template/send?access_token=" . $access_token;
	    
	    $dataRes = $this->request_post ( $url, urldecode ( $json_template ) );
	    $log->write($dataRes.'555');
	     
	}
	function get_access_token() {
	    $appid = APPID;
	    $appsecret = APPSECRET;
	    $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$appid&secret=$appsecret";
	
	    $ch = curl_init ();
	    curl_setopt ( $ch, CURLOPT_URL, $url );
	    curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, FALSE );
	    curl_setopt ( $ch, CURLOPT_SSL_VERIFYHOST, FALSE );
	    curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
	    $output = curl_exec ( $ch );
	    curl_close ( $ch );
	    $jsoninfo = json_decode ( $output, true );
	    $access_token = $jsoninfo ["access_token"];
	    return $access_token;
	}
	/**
	 * 发送post请求
	 *
	 * @param string $url
	 * @param string $param
	 * @return bool mixed
	 */
	function request_post($url = '', $param = '') {
	    $log = new Log();
	    $log->write($url.$param.'3333');
	    if (empty ( $url ) || empty ( $param )) {
	        return false;
	    }
	    $postUrl = $url;
	    $curlPost = $param;
	    $ch = curl_init (); // 初始化curl
	    curl_setopt ( $ch, CURLOPT_URL, $postUrl ); // 抓取指定网页
	    curl_setopt ( $ch, CURLOPT_HEADER, 0 ); // 设置header
	    curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 ); // 要求结果为字符串且输出到屏幕上
	    curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, false );
	    curl_setopt ( $ch, CURLOPT_POST, 1 ); // post提交方式
	    curl_setopt ( $ch, CURLOPT_POSTFIELDS, $curlPost );
	    $data = curl_exec ( $ch ); // 运行curl
	    $log->write(curl_error ( $ch ).'44444');
	    curl_close ( $ch );
	    return $data;
	}
}
?>