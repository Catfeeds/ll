<?php

/**
 * ECSHOP API 公用初始化文件
 * ============================================================================
 * * 版权所有 2005-2012 上海商派网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.ecshop.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * $Author: liubo $
 * $Id: init.php 17217 2011-01-19 06:29:08Z liubo $
*/

if (!defined('IN_ECS'))
{
    die('Hacking attempt');
}
error_reporting(E_ALL);

if (__FILE__ == '')
{
    die('Fatal error code: 0');
}



if (file_exists(ROOT_PATH . 'data/config.php'))
{
    require_once(ROOT_PATH . 'data/config.php');
}

require_once(ROOT_PATH . 'config/config.php');
require_once(ROOT_PATH . 'includes/cls_log.php');
$log = new ecs_log();

if (defined('DEBUG_MODE') == false)
{
    define('DEBUG_MODE', 0);
}

if (PHP_VERSION >= '5.1' && !empty($timezone))
{
    date_default_timezone_set($timezone);
}


/**
	 *
	 * 容联云通信API接入
	 */
	/**
	 * 发送模板短信
	 * @param to 短信接收彿手机号码集合,用英文逗号分开
	 * @param datas 内容数据
	 * @param $tempId 模板Id
	 */
	function sendTemplateSMS($to,$datas,$tempId)
	{
		$AccountSid = AccountSid;
		$AccountToken = AccountToken;
		$AppId = AppId;
		$ServerIP = ServerIP;
		$ServerPort = ServerPort;
		$SoftVersion = SoftVersion;
		$Batch = date("YmdHis");  //时间戳
		$BodyType = "xml";//包体格式，可填值：json 、xml
		//主帐号鉴权信息验证，对必选参数进行判空。
		$auth=accAuth($ServerIP,$ServerPort,$SoftVersion,$AccountSid,$AccountToken,$AppId);
		if($auth!=""){
			return $auth;
		}
		// 拼接请求包体
		if($BodyType=="json"){
			$data="";
			for($i=0;$i<count($datas);$i++){
				$data = $data. "'".$datas[$i]."',";
			}
			$body= "{'to':'$to','templateId':'$tempId','appId':'$AppId','datas':[".$data."]}";
		}else{
			$data="";
			for($i=0;$i<count($datas);$i++){
				$data = $data. "<data>".$datas[$i]."</data>";
			}
			$body="<TemplateSMS>
			<to>$to</to>
			<appId>$AppId</appId>
			<templateId>$tempId</templateId>
			<datas>".$data."</datas>
			</TemplateSMS>";
        }
	    // 大写的sig参数
	    $sig =  strtoupper(md5($AccountSid . $AccountToken . $Batch));
	    // 生成请求URL
	    $url="https://$ServerIP:$ServerPort/$SoftVersion/Accounts/$AccountSid/SMS/TemplateSMS?sig=$sig";
	    // 生成授权：主帐户Id + 英文冒号 + 时间戳。
	    $authen = base64_encode($AccountSid . ":" . $Batch);
	    // 生成包头
	    $header = array("Accept:application/$BodyType","Content-Type:application/$BodyType;charset=utf-8","Authorization:$authen");
	    // 发送请求
	    $result =curl_post($url,$body,$header,1,$BodyType);
	    //$log->debug( "sms:$result" );
        if($BodyType=="json"){//JSON格式
	        $datas=json_decode($result);
	    }else{ //xml格式
	        $datas = simplexml_load_string(trim($result," \t\n\r"));
	    }
	    //  if($datas == FALSE){
	    //            $datas = new stdClass();
	    //            $datas->statusCode = '172003';
	    //            $datas->statusMsg = '返回包体错误';
	    //        }
	    //重新装填数据
	    if($datas->statusCode==0){
	        if($BodyType=="json"){
	        $datas->TemplateSMS =$datas->templateSMS;
	        unset($datas->templateSMS);
	    }
	}
	
	return $datas;
	}
	
	/**
	 * 发起HTTPS请求
	 */
	function curl_post($url,$data,$header,$post=1,$BodyType)
	{
		//初始化curl
		$ch = curl_init();
		//参数设置
		$res= curl_setopt ($ch, CURLOPT_URL,$url);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, FALSE);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, FALSE);
		curl_setopt ($ch, CURLOPT_HEADER, 0);
		curl_setopt($ch, CURLOPT_POST, $post);
		if($post)
			curl_setopt($ch, CURLOPT_POSTFIELDS, $data);
		curl_setopt ($ch, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($ch,CURLOPT_HTTPHEADER,$header);
		$result = curl_exec ($ch);
		//连接失败
		if($result == FALSE){
			if($BodyType=='json'){
				$result = "{\"statusCode\":\"172001\",\"statusMsg\":\"网络错误\"}";
			} else {
				$result = "<?xml version=\"1.0\" encoding=\"UTF-8\" standalone=\"yes\"?><Response><statusCode>172001</statusCode><statusMsg>网络错误</statusMsg></Response>";
			}
		}
	
		curl_close($ch);
		return $result;
	}
	 
	/**
	* 主帐号鉴权
	*/
	function accAuth($ServerIP,$ServerPort,$SoftVersion,$AccountSid,$AccountToken,$AppId)
	{
		if($ServerIP==""){
			$data = new stdClass();
			$data->statusCode = '172004';
			$data->statusMsg = 'IP为空';
			return $data;
		}
		if($ServerPort<=0){
			$data = new stdClass();
			$data->statusCode = '172005';
			$data->statusMsg = '端口错误（小于等于0）';
			return $data;
		}
		if($SoftVersion==""){
			$data = new stdClass();
			$data->statusCode = '172013';
			$data->statusMsg = '版本号为空';
			return $data;
		}
		if($AccountSid==""){
			$data = new stdClass();
			$data->statusCode = '172006';
			$data->statusMsg = '主帐号为空';
			return $data;
		}
		if($AccountToken==""){
			$data = new stdClass();
			$data->statusCode = '172007';
			$data->statusMsg = '主帐号令牌为空';
			return $data;
		}
		if($AppId==""){
			$data = new stdClass();
			$data->statusCode = '172012';
			$data->statusMsg = '应用ID为空';
			return $data;
		}
	}

?>