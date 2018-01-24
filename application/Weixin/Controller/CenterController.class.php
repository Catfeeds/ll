<?php

/**
 * 会员中心
 */
namespace Weixin\Controller;
use Common\Controller\MemberbaseController;
use Other\Controller\MessageController;
use Think\Log;
class CenterController extends MemberbaseController {
	
	function _initialize(){
	}
    //绑定
	function index() {
	    $log=new log();
	    $log->write($_SESSION['weixin_user_id']);
    	$this->display(':bind');
    }
    //记录绑定信息
    function bang_go(){
    	$phone=$_REQUEST['phone'];
    	$code=$_REQUEST['code'];
    	$log=new log();
    	$recommend=isset($_REQUEST['recommend']) ? $_REQUEST['recommend']: '';
    	if(empty($phone)){
    		$this->ajaxReturn(array("0"=>"102","1"=>"请输入手机号!"));
    	}
    	if(empty($code)){
    		$this->ajaxReturn(array("0"=>"102","1"=>"请输入验证码!"));
    	}
    	//验证码是否匹配或者过期
    	$note_info = M("sms")->where("phone='$phone'")->find();
    	if(empty($note_info)){
    		$this->ajaxReturn(array("0"=>"102","1"=>"验证码不正确!"));
    	}else{
    		if($note_info['code']==$code){
    			if(strtotime($note_info['createtime']) < time() - (CODE_LAST_TIME*60)){
    				$this->ajaxReturn(array("0"=>"102","1"=>"验证码已过期!"));
    			}
    		}else{
    			$this->ajaxReturn(array("0"=>"102","1"=>"验证码不正确!"));
    		}
    	}
    	$users=M("user")->where("phone='$phone'")->find();
    	if(empty($users)){
    	    M("user")->add(array("openid"=>$_SESSION['weiopen_id'],'phone'=>$phone ,'recommended_person'=>$recommend,'createtime'=>date('Y-m-d H:i:s',time())));
/*     	    $m=new MessageController();
    		$data = array (
    		    'productType' => array ( 'value' => urlencode ( "绑定成功，为您生成默认密码位123456，请牢记" )),
    		    'name' => array ( 'value' => urlencode ("test")),
    		    'number' => array ( 'value' => urlencode ( "1份" )),
    		    'expDate' => array ( 'value' => urlencode (date("Y-m-d",time()+$timend*3600*24))),
    		    'remark'=>array ( 'value' => urlencode ('sss')),
    		);
    		$m->doSend ( 0, $_SESSION['weiopen_id'], TONGZHI_MODEL,"", $data );
 */    		if(!empty($recommend)){
    		    $ph=M('user')->where("phone = '$recommend'")->find();
    		    if(!$ph){
    		       $this->ajaxReturn(array("0"=>"102","1"=>"当前无此推荐人，请重新选择"));
    		    }
    		    $ec=M('encourage_config')->field("integral,content")->where("type = 1")->find();
    		    $data3=array(
    		        'user_id'=>$ph[id],
    		        'obtain_type'=>1,
    		        'is_obtain'=>1,
    		        'integral'=>$ec[integral],
    		        'content'=>$ec[content],
    		        'createtime'=>date('Y-m-d H:i:s',time())
    		    );
    		    M('integral')->add($data3);
    		    $log->write($data3);
    		    $datax=array('integral'=>intval($ph['integral']+$ec[integral]),'phone'=>$recommend);
    		    $log->write($datax);
    		    M('user')->where("phone ='$recommend'")->save($datax);
    		    $log->write(M('user')->getLastSql());
    		    $data2 = array (
    		        'productType' => array ( 'value' => urlencode ( "商品名" )),
    		        'name' => array ( 'value' => urlencode ("test")),
    		        'number' => array ( 'value' => urlencode ( "1份" )),
    		        'expDate' => array ( 'value' => urlencode (date("Y-m-d",time()+$timend*3600*24))),
    		        'remark'=>array ( 'value' => urlencode ('sss')),
    		    );
    		    $pher=M("user")->where("id = $ph[id]")->find();
    		    $m->doSend ( 0, $pher['openid'], TONGZHI_MODEL,"", $data2 );
				$push = new \JPushZDY();
				$receives = array('alias'=>array($ph['id']));//别名
				$result = $push->push($receives,'成功推荐用户','','','86400');
    		}
    		$_SESSION['weixin_user_id']=M('user')->getLastInsID();
    	}else{
    	    M("user")->where("id=".$users['id'])->save(array("openid"=>$_SESSION['weiopen_id'],'recommended_person'=>$recommend));
    	    $_SESSION['weixin_user_id']=$users['id'];
    	}
    	
    	$this->ajaxReturn(array("0"=>"101","1"=>"绑定成功！"));
    }
    //记录登录信息
    function login_to(){
    	$phone=$_REQUEST['phone'];
    	$pass=md5($_REQUEST['pass']);
    	$users=M("user")->where("phone='$phone' and password='$pass'")->find();
        var_dump($users);die;
    	if(empty($users)){
    		$this->ajaxReturn(array("1"=>"用户名或密码错误！"));
    	}else{
    		if(empty($users['openid'])){
    			M("user")->where("id=".$users['id'])->save(array("openid"=>$_SESSION['weiopen_id'],"last_login_time"=>date("Y-m-d H:i:s")));
				M('login_record')->add(array('user_id'=>$users['id'],'login_time'=>date('Y-m-d H:i:s'),'createtime'=>date('Y-m-d H:i:s'),'app_version'=>'weixin','device_name'=>''));
    		}
    		$_SESSION['weixin_user_id']=$users['id'];
    	}
    	$this->ajaxReturn(array("0"=>"101"));
    }
    //注册
    function regist(){
    	$this->display(':regist');
    }
    //注册信息
    function regist_to(){
    	$phone=$_REQUEST['phone'];
    	$code=$_REQUEST['code'];
    	$password=$_REQUEST['password'];
    	$recommend=$_REQUEST['recommend'];
    	if(empty($phone)){
    		$this->ajaxReturn(array("0"=>"102","1"=>"请输入手机号!"));
    	}
    	if(empty($code)){
    		$this->ajaxReturn(array("0"=>"102","1"=>"请输入验证码!"));
    	}
    	if(empty($password)){
    		$this->ajaxReturn(array("0"=>"102","1"=>"请输入密码!"));
    	}
    	/* if(strlen($password)<6){
    		$this->ajaxReturn(array("0"=>"102","1"=>"密码长度小于6位!"));
    	} */
    	//手机号是否注册
    	$user_p=M("user")->where("phone='$phone'")->find();
    	if($user_p){
    		$this->ajaxReturn(array("0"=>"102","1"=>"该手机号已被注册!"));
    	}
    	//微信号是否注册
    	$user_wei=M("user")->where("openid='".$_SESSION['weiopen_id']."'")->find();
    	if($user_wei){
    		$this->ajaxReturn(array("0"=>"102","1"=>"该微信号已被注册!"));
    	}
    	//验证码是否匹配或者过期
    	$note_info = M("sms")->where("phone='$phone'")->find();
    	if(empty($note_info)){
    		$this->ajaxReturn(array("0"=>"102","1"=>"验证码不正确!"));
    	}else{
    		if($note_info['code']==$code){
    			if(strtotime($note_info['createtime']) < time() - (CODE_LAST_TIME*60)){
    				$this->ajaxReturn(array("0"=>"102","1"=>"验证码已过期!"));
    			}
    		}else{
    			$this->ajaxReturn(array("0"=>"102","1"=>"验证码不正确!"));
    		}
    	}
    	$user_d=array(
    		"phone"=>$phone,
    		"password"=>md5($password),
    		"openid"=>$_SESSION['weiopen_id'],
    		"name"=>$_SESSION['weimes']['nickname'],
    		"last_login_time"=>date("Y-m-d H:i:s",time()),
    		"recommended_person"=>empty($recommend)?"":$recommend,
    		"createtime"=>date("Y-m-d H:i:s",time()),
    	);
    	$lastid=M("user")->add($user_d);
    	if($lastid){
    		$_SESSION['weixin_user_id']=$lastid;
    		$this->ajaxReturn(array("0"=>"101","1"=>"注册成功！"));
    	}else{
    		$this->ajaxReturn(array("0"=>"102","1"=>"注册失败！"));
    	}
    }
    //忘记密码
    function findPw(){
    	$this->display(":findPw");
    }
    //发送找回短信
    function black_code(){
    	$phone=$_REQUEST['phone'];
    	$users=M("user")->where("phone='$phone'")->find();
    	if(empty($users)){
    		$this->ajaxReturn(array("0"=>"102","1"=>"该账号未被注册!"));
    	}
    	$mes=$this->send_note();
    }
    //记录找回密码信息
    function black_pas(){
    	$phone=$_REQUEST['phone'];
    	$code=$_REQUEST['code'];
    	$password=$_REQUEST['password'];
    	if(empty($phone)){
    		$this->ajaxReturn(array("0"=>"102","1"=>"请输入手机号!"));
    	}
    	if(empty($code)){
    		$this->ajaxReturn(array("0"=>"102","1"=>"请输入验证码!"));
    	}
    	if(empty($password)){
    		$this->ajaxReturn(array("0"=>"102","1"=>"请输入密码!"));
    	}
    	if(strlen($password)<6){
    		$this->ajaxReturn(array("0"=>"102","1"=>"密码长度小于6位!"));
    	}
    	//验证码是否匹配或者过期
    	$note_info = M("sms")->where("phone='$phone'")->find();
    	if(empty($note_info)){
    		$this->ajaxReturn(array("0"=>"102","1"=>"验证码不正确!"));
    	}else{
    		if($note_info['code']==$code){
    			if(strtotime($note_info['createtime']) < time() - (CODE_LAST_TIME*60)){
    				$this->ajaxReturn(array("0"=>"102","1"=>"验证码已过期!"));
    			}
    		}else{
    			$this->ajaxReturn(array("0"=>"102","1"=>"验证码不正确!"));
    		}
    	}
    	M("user")->where("phone='$phone'")->save(array("password"=>md5($password)));
    	$this->ajaxReturn(array("0"=>"101","1"=>"密码找回成功!"));
    }
    //修改密码
    function getpas() {
    	$this->display(':xgTel');
    }
    //绑定新手机
    function newphone(){
        $userid= $_SESSION['weixin_user_id'];
        $phone=$_REQUEST['phone'];
        $pwd=$_REQUEST['pwd'];
        $u=M('user')->field("password")->where("id = '$userid'")->find();
        if($u['password'] != md5($pwd)){
            $this->ajaxReturn(array("0"=>"102","1"=>'账户密码不匹配，无法修改'));
        }
        $count=M('user')->where("phone = '$phone'")->count();
        if($count >0){
           $this->ajaxReturn(array("0"=>"102","1"=>'此手机号已存在！'));
        }
        $this->send_note();
    }
	function send_note() {
	    $phone=$_REQUEST['phone'];
	    $note_model = M("sms");
	    if(empty($phone)){//手机号不能为空
	    	$this->ajaxReturn(array("0"=>"102","1"=>"手机号不能为空！"));
	    }
	    $note_info = $note_model->where("phone='$phone'")->find();
	    $key = '';
	    $pattern = '1234567890';
	    //生成6位随机数字作为验证码
	    for($i = 0; $i < 6; $i ++) {
	        $key .= $pattern {mt_rand ( 0, 9 )}; // 生成php随机数
	    }
	    //插入数据库的数据包装
	    $data = array("code"=>$key,"createtime"=>date("Y-m-d H:i:s",time()));
	    if (empty($note_info)) {//如果数据库中不存在该用户新增一个
	        $data ['phone'] = $phone;
	        $note_model->add($data);
	    } else {
	        if (strtotime($note_info['createtime']) < time() - CODE_LAST_TIME*60) {//过期时间
	            $note_model->where("phone='$phone'")->save($data);
	        } else {//验证码未过期不重新生成
	            $key = $note_info['code'];
	        }
	    }
	    //向手机发送验证码短信
	    $datas [] = $key;
	    $datas [] = CODE_LAST_TIME.'分钟';
	    $result=$this->sendTemplateSMS($phone,$datas);
	    if($result->statusCode !='000000') {//判断发送结果
	        $this->ajaxReturn(array("0"=>$result->statusCode,"1"=>$result->statusMsg));
	    }else{//成功
	        $this->ajaxReturn(array("0"=>"101","1"=>"发送验证码成功"));
	    }
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
	public function sendTemplateSMS($to,$datas){
		$notes=C("SEND_NOTE");
	    $AccountSid = $notes['AccountSid'];
	    $AccountToken = $notes['AccountToken'];
	    $AppId = $notes['AppId'];
	    $ServerIP = $notes['ServerIP'];
	    $ServerPort = $notes['ServerPort'];
	    $SoftVersion = $notes['SoftVersion'];
	    $tempId=$notes['tempId'];
	    $Batch = date("YmdHis");  //时间戳
	    $BodyType = "json";//包体格式，可填值：json 、xml
	    //主帐号鉴权信息验证，对必选参数进行判空。
	    $auth=$this->accAuth($ServerIP,$ServerPort,$SoftVersion,$AccountSid,$AccountToken,$AppId);
	    if($auth!=""){
	        return $auth;
	    }
	    // 拼接请求包体
	    if($BodyType=="json"){
	        $data="";
	        for($i=0;$i<count($datas);$i++){
	            $data = $data. "'".$datas[$i]."',";
	        }
	        $body= "{'to':'$to','templateId':'$tempId','appId':'$AppId','datas':[  ".$data."]}";
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
	    $result = $this->curl_post($url,$body,$header,1,$BodyType);
	    $this->showlog ( "sms:$result" );
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
	 * 打印日志
	 *
	 * @param log 日志内容
	 */
	function showlog($log){
	    if($this->enabeLog){
	        fwrite($this->Handle,$log."\n");
	    }
	}
	
	/**
	 * 发起HTTPS请求
	 */
	function curl_post($url,$data,$header,$post=1)
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
	        if($this->BodyType=='json'){
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
	function accAuth(){
		$notes=C("SEND_NOTE");
		$AccountSid = $notes['AccountSid'];
		$AccountToken = $notes['AccountToken'];
		$AppId = $notes['AppId'];
		$ServerIP = $notes['ServerIP'];
		$ServerPort = $notes['ServerPort'];
		$SoftVersion = $notes['SoftVersion'];
		$tempId=$notes['tempId'];
	    if($ServerIP==""){
	        $data = new \stdClass();
	        $data->statusCode = '172004';
	        $data->statusMsg = 'IP为空';
	        return $data;
	    }
	    if($ServerPort<=0){
	        $data = new \stdClass();
	        $data->statusCode = '172005';
	        $data->statusMsg = '端口错误（小于等于0）';
	        return $data;
	    }
	    if($SoftVersion==""){
	        $data = new \stdClass();
	        $data->statusCode = '172013';
	        $data->statusMsg = '版本号为空';
	        return $data;
	    }
	    if($AccountSid==""){
	        $data = new\ stdClass();
	        $data->statusCode = '172006';
	        $data->statusMsg = '主帐号为空';
	        return $data;
	    }
	    if($AccountToken==""){
	        $data = new \stdClass();
	        $data->statusCode = '172007';
	        $data->statusMsg = '主帐号令牌为空';
	        return $data;
	    }
	    if($AppId==""){
	        $data = new \stdClass();
	        $data->statusCode = '172012';
	        $data->statusMsg = '应用ID为空';
	        return $data;
	    }
	}
}
