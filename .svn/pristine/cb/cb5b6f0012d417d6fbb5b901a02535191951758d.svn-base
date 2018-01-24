<?php
namespace Lailonginterface\Controller;
use Lailonginterface\Controller\PublicController;

class ForgetpasswordController  extends PublicController {
    /**
     * 忘记密码
     */
    public function index()
    {
       $phone =$_REQUEST['phone'];
       $pwd=$_REQUEST['password'];
       //验证码
       $code=$_REQUEST['code'];
       if(empty($code)){
           $this->emptyResult();
       }
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
       $data=array('password'=>md5($pwd));
      
       if(M('user')->where("phone = '$phone'")->save($data)){
           $this->successShortResult("修改成功");
       }else{
           $this->errorResult("修改失败");
       }
       
    }
}