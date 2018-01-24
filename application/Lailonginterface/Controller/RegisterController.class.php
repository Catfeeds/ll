<?php
namespace Lailonginterface\Controller;
use Lailonginterface\Controller\PublicController;
require 'php/jiguang.php';
use Think\Log;
use JPush\Client as JPush;
class RegisterController  extends PublicController {
    /**
     * 用户注册
     */
    public function index()
    {
       $phone =$_REQUEST['phone'];
       $token=$_REQUEST['token'];
       $pwd=$_REQUEST['password'];
       //验证码
       $code=$_REQUEST['code'];
       //推荐人
       $referees=$_REQUEST['referees'];
       $s=M('sms')->where("phone = '$phone' and code = $code")->find();
       if(!$s){
           $msg = array(
               "code" => 204,
               "msg" => '验证码错误',
           );
           echo json_encode($msg);
           exit();
       }
       if(empty($phone) || empty($pwd)){
           $this->emptyResult();
       }
       $u=M('user')->where("phone = '$phone'")->find();
       if($u){
           //微信注册
           if($u['password'] =='' && $u['openid'] !=''){
               M('user')->where("phone = '$phone'")->save(array('password'=>md5($pwd)));
               $this->successShortResult("注册成功");
               exit();
           }else{
               $this->errorResult("此手机号已注册");
           }
       } 
       
       $data4=array('phone'=>$phone,'password'=>md5($pwd),'integral'=>0,'createtime'=>date('Y-m-d H:i:s',time()),'recommended_person'=>$referees);
       if(!empty($referees)){
            $ph=M('user')->where("phone = '$referees'")->find();
            if(empty($ph)){
                $msg = array(
                    "code" => 205,
                    "msg" => '查无此联系人，请重新选择',
                );
                echo json_encode($msg);
                exit();
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
            $datax=array('integral'=>intval($ph['integral']+$ec[integral]));
           M('user')->where("phone ='$referees'")->save($datax);
           //推送至安卓
           $push = new \JPushZDY();
           $receive = array('alias'=>array($ph[id]));//别名
           $content='您的好友已通过您注册成功，您获得'.$ec[integral].'积分';
           $result = $push->push($receive,$content,'','','86400');
           //推送至微信
           $data = array (
               'productType' => array ( 'value' => urlencode ( '您的好友已通过您注册成功，您获得'.$ec[integral].'积分' )),
               'name' => array ( 'value' => urlencode ("test")),
               'number' => array ( 'value' => urlencode ( "1份" )),
               'expDate' => array ( 'value' => urlencode (date("Y-m-d",time()+$timend*3600*24))),
               'remark'=>array ( 'value' => urlencode ('sss')),
           );
           $usa=M('user')->field("openid")->where("id = '$ph[id]'")->find();
           $this->doSend ( 0, $usa['openid'], TONGZHI_MODEL,"", $data );
          /*  //$client = new JPush($this->_appkeys,$this->_masterSecret);
           $platform="android";
           $msg_content = json_encode(array('n_builder_id'=>$ph[id],'您的好友已通过您注册成功，您获得'.$ec[integral].'积分'));
           $this->send(16,3,"8",1,$msg_content,$platform); */
       }
       if(M('user')->add($data4)){
           $this->successResult( "注册成功");
       }
       //$this->checkAccess($token);
       
    }
    //发送验证码
    public function sendcode()
    {
        $log=new log();
        $user_id = $_REQUEST['user_id'];
        $phone=$_REQUEST['phone'];
        //$this->send_note($phone,$user_id);
        //测试
        $code=rand(1000,9999);
        if(!preg_match("/^1[0-9]{10}$/", $phone)){
              $msg = array(
                "code" => 203,
                "msg" => '手机号有误！请重新输入',
            );
            echo json_encode($msg);
            exit();
        }
        //等有短信应用时启用
        $this->send_note($phone);
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
    
        $dataRes = $this->request_post2 ( $url, urldecode ( $json_template ) );
        $log->write($dataRes.'555');
         
    }
    function get_access_token() {
        $appid = APPID;
        $appsecret = APPSECRET;
        $url = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=$appid&secret=$appsecret";
        $log = new Log();
        $log->write($url);
        $ch = curl_init ();
        curl_setopt ( $ch, CURLOPT_URL, $url );
        curl_setopt ( $ch, CURLOPT_SSL_VERIFYPEER, FALSE );
        curl_setopt ( $ch, CURLOPT_SSL_VERIFYHOST, FALSE );
        curl_setopt ( $ch, CURLOPT_RETURNTRANSFER, 1 );
        $output = curl_exec ( $ch );
        curl_close ( $ch );
        $jsoninfo = json_decode ( $output, true );
        $log->write($jsoninfo);
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
    function request_post2($url = '', $param = '') {
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