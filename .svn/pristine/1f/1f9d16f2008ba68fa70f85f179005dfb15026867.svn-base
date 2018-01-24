<?php
class ecs_message
{
	/**
	 * 极光推送
	 * @var unknown
	 */
	/**
	 * 发送
	 * @param int $sendno 发送编号。由开发者自己维护，标识一次发送请求
	 * @param int $receiver_type 接收者类型。1、指定的 IMEI。此时必须指定 appKeys。2、指定的 tag。3、指定的 alias。4、 对指定 appkey 的所有用户推送消息。
	 * @param string $receiver_value 发送范围值，与 receiver_type相对应。 1、IMEI只支持一个 2、tag 支持多个，使用 "," 间隔。 3、alias 支持多个，使用 "," 间隔。 4、不需要填
	 * @param int $msg_type 发送消息的类型：1、通知 2、自定义消息
	 * @param string $msg_content 发送消息的内容。 与 msg_type 相对应的值
	 * @param string $platform 目标用户终端手机的平台类型，如： android, ios 多个请使用逗号分隔
	 */
	function send($user_id,$msg_type,$content,$details='') {
		$user_ids = explode(',', $user_id);
		$jpush_registrationid = array();
		foreach ($user_ids as $v) {
			$jpush_registrationid[] = $v;//极光推送设备注册id
			
			$data['from_userid'] = 0;
			$data['to_userid'] = $v;
			$data['msg_type'] = $msg_type;
			$data['content'] = $content;
			$data['details'] = $details;
			$data['create_time'] = date('Y-m-d H:i:s');
			$GLOBALS['db']->autoExecute('ecs_message', $data, "INSERT");
		}
		//组装需要的参数
		//$receive = 'all';     //全部
		//$receive = array('tag'=>array('2401','2588','9527'));      //标签
		//$userid=$jpush->usesrid;//用户id
		//$devicetype='all';//设备类型 1：Android手机 2：Android平板 3：IOS设备
		$tag=$msg_type;//极光推送tag:1：交易 2：商品 3：系统 4：社交
		//$alias=$jpush->jpush_alias;// 极光推送设备别名(AndroidPad,AndroidPhone,IOS)
		$receive = array('alias'=>$jpush_registrationid);    //别名
		$m_type = 'http';
		$m_txt = 'http://a.refineit.cn/post/account.html';
		$m_time = '600';        //离线保留时间
		//$this->log->debug( 'send:              ' . print_r($receive) );
		//调用推送,并处理
		$msg = $this->push($receive,$content,$m_type,$m_txt,$m_time);
		$log = new ecs_log();
		$log->debug($msg);
		return $msg;
		/* $result = $this->push($receive,$content,$m_type,$m_txt,$m_time);
			if($result){
		$res_arr = json_decode($result, true);
		if(isset($res_arr['error'])){                       //如果返回了error则证明失败
		//echo $res_arr['error']['message'];          //错误信息
		//echo $res_arr['error']['code'];             //错误码
		return false;
		}else{
		//处理成功的推送......
		//echo '推送成功.....';
		//echo $receive.$content.$m_type.$m_txt.$m_time.$tag;
		return true;
		}
		}else{      //接口调用失败或无响应
		//echo '接口调用失败或无响应';
		return false;
		} */
	}
	/*  $receiver 接收者的信息
	 all 字符串 该产品下面的所有用户. 对app_key下的所有用户推送消息
	tag(20个)Array标签组(并集): tag=>array('昆明','北京','曲靖','上海');
	tag_and(20个)Array标签组(交集): tag_and=>array('广州','女');
	alias(1000)Array别名(并集): alias=>array('93d78b73611d886a74*****88497f501','606d05090896228f66ae10d1*****310');
	registration_id(1000)注册ID设备标识(并集): registration_id=>array('20effc071de0b45c1a**********2824746e1ff2001bd80308a467d800bed39e');
	*/
	//$content 推送的内容。
	//$m_type 推送附加字段的类型(可不填) http,tips,chat....
	//$m_txt 推送附加字段的类型对应的内容(可不填) 可能是url,可能是一段文字。
	//$m_time 保存离线时间的秒数默认为一天(可不传)单位为秒
	public function push($receiver,$content='',$m_type='',$m_txt='',$m_time='86400'){
		$base64=base64_encode(appkeys.':'.masterSecret);
		$header=array("Authorization:Basic $base64","Content-Type:application/json");
		$data = array();
		$data['platform'] = 'all';          //目标用户终端手机的平台类型android,ios,winphone
		$data['audience'] = $receiver;      //目标用户
		$data['notification'] = array(
				//统一的模式--标准模式
				"alert"=>$content,
				//安卓自定义
				"android"=>array(
						"alert"=>$content,
						"title"=>"",
						"builder_id"=>1,
						"extras"=>array("type"=>$m_type, "txt"=>$m_txt)
				),
				//ios的自定义
				"ios"=>array(
						"alert"=>$content,
						"badge"=>"1",
						"sound"=>"default",
						"extras"=>array("type"=>$m_type, "txt"=>$m_txt)
				),
		);
	
		//苹果自定义---为了弹出值方便调测
		$data['message'] = array(
				"msg_content"=>$content,
				"extras"=>array("type"=>$m_type, "txt"=>$m_txt)
		);
	
		//附加选项
		$data['options'] = array(
				"sendno"=>time(),
				"time_to_live"=>$m_time, //保存离线时间的秒数默认为一天
				"apns_production"=>0,        //指定 APNS 通知发送环境：0开发环境，1生产环境。
		);
		$param = json_encode($data);
		//print_r($param);
		$res = $this->push_curl($param,$header);
			
		if($res){       //得到返回值--成功已否后面判断
			return $res;
		}else{          //未得到返回值--返回失败
			return false;
		}
	}
	//推送的Curl方法
	public function push_curl($param="",$header="") {
		if (empty($param)) { return false; }
		$postUrl = "https://api.jpush.cn/v3/push";
		$curlPost = $param;
		$ch = curl_init();                                      //初始化curl
		curl_setopt($ch, CURLOPT_URL,$postUrl);                 //抓取指定网页
		curl_setopt($ch, CURLOPT_HEADER, 0);                    //设置header
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);            //要求结果为字符串且输出到屏幕上
		curl_setopt($ch, CURLOPT_POST, 1);                      //post提交方式
		curl_setopt($ch, CURLOPT_POSTFIELDS, $curlPost);
		curl_setopt($ch, CURLOPT_HTTPHEADER,$header);           // 增加 HTTP Header（头）里的字段
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);        // 终止从服务端进行验证
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		$data = curl_exec($ch);                                 //运行curl
		curl_close($ch);
		return $data;
	}
	public function delete_aliatses($uid){
		$base64=base64_encode(appkeys.':'.masterSecret);
		$header=array("Authorization:Basic $base64","Content-Type:application/json");
		$res = $this->device_curl($uid,$header);
		print_r($res);
		exit();
	}
	//推送的Curl方法
	public function device_curl($uid="",$header="") {
		if (empty($uid)) { return false; }
		$data['platform'] = 'all';
		$param = json_encode($data);
		$postUrl = "https://device.jpush.cn/v3/aliases/".$uid;
		$ch = curl_init();                                      //初始化curl
		curl_setopt($ch, CURLOPT_URL,$postUrl);                 //抓取指定网页
		curl_setopt($ch, CURLOPT_HEADER, 0);                    //设置header
		curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);            //要求结果为字符串且输出到屏幕上
		curl_setopt($ch, CURLOPT_CUSTOMREQUEST, "DELETE");
		curl_setopt($ch, CURLOPT_POSTFIELDS,$param);
		curl_setopt($ch, CURLOPT_HTTPHEADER,$header);           // 增加 HTTP Header（头）里的字段
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);        // 终止从服务端进行验证
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		$data = curl_exec($ch);                                 //运行curl
		curl_close($ch);
		return $data;
	}
}
