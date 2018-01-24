<?php
namespace Lailonginterface\Controller;
use Lailonginterface\Controller\PublicController;

class PayController  extends PublicController {
    /**
     * 判断账户积分是否充足
     */
    public function integral()
    {
       $token=$_REQUEST['token'];
       $userid=$this->checkAccess($token);
       $integral=$_REQUEST['integral'];
       $u=M('user')->field("integral")->where("id = $userid")->find();
       if(intval($u[integral])<0){
           $this->errorResult("当前账户积分不足，请充值后支付");
       }
       if(intval($u[integral])<$integral){
           $this->errorResult("当前账户积分不足，请充值后支付");
       }else{
           $this->successShortResult("允许充值");
       }
    }
    //完成支付
    public function finish(){
        $token=$_REQUEST['token'];
        $orderid=$_REQUEST['orderid'];
        $integral=$_REQUEST['integral'];
        $userid=$this->checkAccess($token);
        /* $e=M('enrollment')->field("havenumber")->where("id = $orderid")->find();
        $havenumber=$e[havenumber] + 1; */
        $str=M('enrollment')->field("state")->where("id = $orderid")->find();
        if($str[state] == 1){
            $msg = array(
                "code" => 610,
                "msg" => "此订单已完成支付"
            );
            echo json_encode($msg);
            exit();
        }
        $u=M('user')->field("integral")->find($userid);
        if($u[integral]<$integral){
            $this->errorResult("积分不足");
        }
        M('user')->where("id = $userid")->save(array('integral'=>intval($u[integral]-$integral)));
        $data2=array(
            'user_id'=>$userid,
            'obtain_type'=>4,
            'is_obtain'=>0,
            'integral'=>intval(0-$integral),
            'content'=>"支付课程费".$integral.'积分',
            'createtime'=>date('Y-m-d H:i:s',time())
        );
        M('integral')->add($data2);
        
        M('enrollment')->where("id = $orderid")->save(array('state'=>1));
        $param=array('enrollment_id'=>$orderid,'state'=>1,'state_text'=>"支付成功",'createtime'=>date('Y-m-d H:i:s',time()));
        M('enrollment_state')->add($param);
        $this->successShortResult("完成支付");
    }
    //获取充值积分列表
    public function getrechargescore(){
        $res=M('integral_order_config')->order("index_id asc")->select();
        if($res){
            $this->successLongResult($res, "获取成功");
        }else{
            $this->successShortResult("获取失败");
        }
    }
    //微信创建充值订单
    public function rechargepay(){
        $token=$_REQUEST['token'];
        $goods = $_REQUEST['goods'];//所买的积分-即商品
        $price = $_REQUEST['price'];//支付金额
        $order_sn = "lailong".uniqid();//订单号
        $userid=$this->checkAccess($token);//用户id
        $data = array(
            "user_id"=>$userid,
            "createtime"=>date("Y-m-d H:i:s"),
            "updatetime"=>"",
            "order_id"=>$order_sn,
            "order_id_time"=>$order_sn."_".time(),
            "ext_order_id"=>"",
            "pay_type"=>"0",
            "content"=>"来龙教育-积分充值",
            "amount"=>$price,
            "pay_amount"=>"",
            "state"=>"0",
            "integral"=>$goods,
        );
        $success = M("order")->add($data);
        $result=array('order_sn'=>$order_sn."_".time(),'order_id'=>$success,'price'=>$price);
        if($success){
            $msg="创建微信订单成功";
            $this->successLongResult($result, $msg);
        }else{
            $this->errorResult("创建微信订单失败");
        }
    }
}