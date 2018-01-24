<?php
ini_set('date.timezone','Asia/Shanghai');
error_reporting(E_ERROR);
define('IN_ECS', true);
require_once "lib/WxPay.Api.php";
require_once 'lib/WxPay.Notify.php';
require_once 'unit/log.php';
require_once('../includes/cls_message.php');
require_once('../config/config.php');
require_once('../api/init.php');

//初始化日志
$logHandler= new CLogFileHandler("../log/".date('Y-m-d').'.log');
$log = Log::Init($logHandler, 15);
class PayNotifyCallBack extends WxPayNotify
{
	//查询订单
	public function Queryorder($transaction_id)
	{
		$input = new WxPayOrderQuery();
		$input->SetTransaction_id($transaction_id);
		$result = WxPayApi::orderQuery($input);
		Log::DEBUG("query:" . json_encode($result));
		if(array_key_exists("return_code", $result)
			&& array_key_exists("result_code", $result)
			&& $result["return_code"] == "SUCCESS"
			&& $result["result_code"] == "SUCCESS")
		{
			Log::DEBUG("回调处理结果开始:" . json_encode($result));
			$data=array();
		    $data['zy_ddh']            = $result["out_trade_no"];//我们自己的订单号
		    $data['openid']            = $result["openid"];//卖家帐号
		    $data['out_trade_no']      = $result["out_trade_no"];//微信订单号
		    $data['zongjia']           = $result["total_fee"]/100;//总金额
		    $data['ctime']             = $result["time_end"];//交易付款时间
		    $data['trade_state']       = $result["trade_state"];	//公众号
		    $data['success']           = 1;		//转账是否成功
			Log::DEBUG("回调处理结果赋值" . json_encode( $data));
		    //成功之后的业务逻辑处理
		    $this->billandpay($data);
			return true;
		} else {
			return false;
		}
	}
	
	//重写回调处理函数
	public function NotifyProcess($data, &$msg)
	{
		Log::DEBUG("call back:" . json_encode($data));
		$notfiyOutput = array();
		
		if(!array_key_exists("transaction_id", $data)){
			$msg = "输入参数不正确";
			return false;
		}
		//查询订单，判断订单真实性
		if(!$this->Queryorder($data["transaction_id"])){
			$msg = "订单查询失败";
			return false;
		}
		return true;
	}
	//回调具体方法
	function billandpay($data) {
	    $sql = "SELECT order_id, user_id, pay_status, rebate_points, points, pay_fee, rebate, user_coupon_id FROM ecs_order_info WHERE order_sn = '{$data['zy_ddh']}'";
	    $order = $GLOBALS['db']->getRow($sql);
	    if ($order['pay_status'] == 0) {
	        //支付记录
	        $pay_log = array();
	        $pay_log['order_id'] = $order['order_id'];
	        $pay_log['order_amount'] = $order['pay_fee'];
	        $pay_log['is_paid'] = 1;
	        $GLOBALS['db']->autoExecute('ecs_pay_log', $pay_log, "INSERT");
	        //修改订单状态
	        $order_data = array();
	        $order_data['pay_status'] = 1;
	        $order_data['pay_time'] = time();
	        $GLOBALS['db']->autoExecute('ecs_order_info', $order_data, "UPDATE", "order_sn = '{$data['zy_ddh']}'");
	        //返利
	        $points = array();
	        $points['user_id'] = $order['user_id'];
	        $points['points'] = $order['rebate_points'];
	        $points['o_points'] = $order['rebate_points'];
	        $points['expiration_time'] = date('Y-m-d H:i:s', strtotime("+1 year"));
	        $points['create_time'] = date('Y-m-d H:i:s');
	        $GLOBALS['db']->autoExecute('ecs_user_points', $points, "INSERT");
	        Log::DEBUG("订单里面使用的积分" . json_encode( $order['points'] ));
	        //扣除积分
	        if ($order['points']) {
	            $sql = "select id, points from ecs_user_points where user_id = '{$order['user_id']}' and points > 0 and expiration_time > now() order by expiration_time asc";
	            $ups = $GLOBALS['db']->getAll($sql);
	            foreach ($ups as $k=>$v) {
	                $order['points'] = $order['points'] - $v['points'];
	                if ( $order['points'] <= 0 ) {
	                    $up_data['points'] = abs($order['points']);
	                } else {
	                    $up_data['points'] = 0;
	                }
	                $GLOBALS['db']->autoExecute('ecs_user_points', $up_data, "UPDATE", "id = '{$v['id']}'");
	                if ($order['points'] <= 0) {
	                    break;
	                }
	            }
	        }
	        //扣除返利金额
	        Log::DEBUG("订单里面使用返利金额" . json_encode( $order['rebate'] ));
	        if ($order['rebate'] ) {
	            Log::DEBUG("扣除金额开始" . json_encode( $order['rebate']));
	            $sql = "select user_money from ecs_users where user_id = '{$order['user_id']}'";
	            $rebate = $GLOBALS['db']->getOne($sql);
	            Log::DEBUG("查询用户的金额" . json_encode( $rebate));
	            $u_data['user_money'] = $rebate - $order['rebate'];
	            Log::DEBUG("扣除后用户的金额" . json_encode( $u_data['user_money']));
	            $GLOBALS['db']->autoExecute('ecs_users', $u_data, "UPDATE", "user_id = '{$order['user_id']}'");
	        }
	        //使用优惠券
	        Log::DEBUG("订单里面使用优惠券" . json_encode($order['user_coupon_id']));
	        if ($order['user_coupon_id'] ) {
	            $uc_data['is_used'] = 1;
	            $GLOBALS['db']->autoExecute('ecs_user_coupon', $uc_data, "UPDATE", "id = '{$order['user_coupon_id']}'");
	        }
	        //$log = new ecs_log();
	        //$log->debug('send_start');
	        //推送信息
	        Log::DEBUG("推送消息开始" . json_encode(order_msg1));
	        $msg = new ecs_message();
	        $result=$msg->send($order['user_id'], 1, sprintf(order_msg1, $data['zy_ddh']));
	        Log::DEBUG("推送消息结果赋值" . json_encode( $result));
	        //获取优惠券
	        $sql = "select goods_id from ecs_order_goods where order_id = '{$order['order_id']}'";
	        $goods_list = $GLOBALS['db']->getAll($sql);
	        foreach ($goods_list as $v) {
	            $sql = "select xz.coupon_id from ecs_xiangzhuan_goods as xg left join ecs_xiangzhuan as xz on xz.id = xg.xz_id
	            where xg.goods_id = {$v['goods_id']} and xz.start_time < now() and xz.end_time > now()";
	            $coupon_list = $GLOBALS['db']->getAll($sql);
	            foreach ($coupon_list as $c) {
	                $data1['user_id'] = $order['user_id'];
	                $data1['coupon_id'] = $c['coupon_id'];
	                $data1['card'] = time() . $order['user_id'] . $c['coupon_id'];
	                $data1['is_used'] = 0;
	                $data1['create_time'] = date('Y-m-d H:i:s');
	                $db->autoExecute('ecs_user_coupon', $data1, 'INSERT');
	            }
	            // 分享人返利
	            if ($v ['source'] != 0 && $v ['mold'] == 2 && $order ['user_id'] != $v ['source']) {
	                $sql="SELECT rebate_bili FROM ".$GLOBALS['ecs']->table('guize_bili') .' WHERE 1 = 1';
	                $bili = $GLOBALS['db']->getRow($sql);
	                $rebate_money=$bili['rebate_bili']/100;
	                $rebate = array ();
	                $rebate ['user_id'] = $v ['source'];
	                $rebate ['buyer_id'] = $order ['user_id'];
	                $rebate ['money'] = $rebate_money * $v ['goods_price'];
	                $rebate ['create_time'] = date ( 'Y-m-d' );
	                $db->autoExecute ( 'ecs_user_rebate', $rebate, 'INSERT' );
	                	
	                $sql = "select user_money from ecs_users where user_id = '{$v ['source']}'";
	                $user_info = $GLOBALS ['db']->getRow ( $sql );
	                $money = array ();
	                $money ['user_money'] = $user_info ['user_money'] + $rebate ['money'];
	                $GLOBALS ['db']->autoExecute ( 'ecs_users', $money, "UPDATE", "user_id = '{$v ['source']}'" );
	            }
	        }
	    }
	}
}

Log::DEBUG("begin notify");
$notify = new PayNotifyCallBack();
$notify->Handle(false);