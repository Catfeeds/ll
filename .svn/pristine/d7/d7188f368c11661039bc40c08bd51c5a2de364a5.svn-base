<?php

namespace Other\Controller;
use Common\Controller\AdminbaseController;
use Think\Log;
require 'php/jiguang.php';
error_reporting(E_ALL^E_NOTICE);
class FeedbackController extends AdminbaseController {
    private $_appkeys = 'fff82c736e828424fa1bbb80';
    private $_masterSecret = 'bc6ff9522db3d84edfafb4ac';
    private $bool=1;
	function _initialize() {
	}
    /**
     *意见反馈列表
     */
    public function index() {
        $_SESSION['num_feedback']="";
        $_SESSION['f_res']="";
        $user_key_word = isset ( $_REQUEST ['user_key_word'] ) ? $_REQUEST ['user_key_word'] : ''; // 关键字
        $phone_key_word = isset ( $_REQUEST ['phone_key_word'] ) ? $_REQUEST ['phone_key_word'] : ''; // 关键字
        $where= "1=1";
        //判断是否表单处提交的数据，如果是就重置session值
        if($_REQUEST['leixing']==1){
            $_SESSION['user_key_word']=$user_key_word;
            $_SESSION['phone_key_word']=$phone_key_word;
        }
        if($_SESSION['user_key_word'] != ''){
            $where .= " and (a.user_login like '%$_SESSION[user_key_word]%')";
        }
        if($_SESSION['phone_key_word'] != ''){
            $where .= " and (a.mobile like '%$_SESSION[phone_key_word]%')";
        }
        if($_POST['type']=='全部'){
            $_SESSION['user_key_word']="";
            $_SESSION['phone_key_word']="";
        }
        $model = M ("feedback");
        $count = $model->where($where)->count();
        $page = $this->page($count, C('PAGENUM'));
        $list = $model->field("f.content,f.id,f.createtime,u.phone as username,u.id as user_id")->table(C('DB_PREFIX')."feedback as f")->join(C('DB_PREFIX').'user as u on u.id =f.user_id','left')->order("id DESC")->limit($page->firstRow . ',' . $page->listRows)->where($where)->select();
        foreach ($list as $key => $value) {
        	$feedback_id = $value['id'];
        	$inte = M("integral")->field("sum(integral) as sum")->where("feedback_id = $feedback_id")->find();
        	$list[$key]['integral'] = $inte['sum'];
        }
        $this->assign('list', $list);
        $this->assign("page", $page->show('Admin'));
        $this->assign("formget",$_SESSION); 
       	$this->display();
    }
    public function delete(){
        if(M('feedback')->delete($_GET[id])){
            $this->success("删除成功");
        }else{
            $this->error("删除失败");
        }
    }
    //意见反馈积分添加详情
	public function getDetail(){
		$model = M('integral i');
		$where = 'feedback_id='.$_GET['id'];
		$count = $model->where($where)->count();
		$page = $this->page($count,5);
		$feedback = $model->field("i.id,i.integral,i.createtime as itime,f.createtime as ftime,f.content as fcontent,u.name")
		->join(C('DB_PREFIX')."feedback as f on f.id = i.feedback_id","left")
		->join(C('DB_PREFIX')."user as u on u.id = i.user_id","left")
		->limit($page->firstRow . ',' . $page->listRows)->where($where)->select();
		
		$this->assign('feedback',$feedback);
		$this->assign('Page',$page->show('Admin'));
		$this->display('Feedback/more');
	}
	//反馈消息
	public function feedbackmessage(){
	    $id=$_REQUEST[id];
	    $fdata=M('feedback')->table(C("DB_PREFIX")."feedback as fd")->field("fd.content,fd.createtime,u.phone")->join(C('DB_PREFIX')."user as u on u.id = fd.user_id",'left')->where("fd.id = '$id'")->find();
	    $refdata=M('news')->where("feedback_id = '$id'")->order("createtime asc")->select();
	    $data=array('0'=> $fdata,'1'=>$refdata);
	    $this->ajaxReturn($data);
	}
	function addfeedbackmessage(){
	    $id=$_REQUEST[id];
	    $textarea=$_REQUEST['textarea'];
	    $fd=M('feedback')->where("id = '$id'")->find();
	    $push = new \JPushZDY();
	    $receives = array('alias'=>array($fd['user_id']));//别名
	    $result = $push->push($receives,$content,'','','86400');
	   $data2 = array (
	        'firse' => array ( 'value' => urlencode ( "您收到一条新的意见反馈回复" )),
	        'keyword1' => array ( 'value' => urlencode ("意见反馈")),
	        'keyword2' => array ( 'value' => urlencode ( date('Y-m-d H:i:s',time()))),
	        'remark'=>array ( 'value' => urlencode ("请至微信公众号或来龙教育APP端查阅")),
	    );
	    $usa=M('user')->field("openid")->where("id = '$fd[user_id]'")->find();
	    if(!empty($usa['openid'])){
	        $this->doSend ( 0, $usa['openid'], 'BVlYMWmMSUrDp2MRZlAyLufEbBqNww2o7Cf1klGpkO8',"", $data2 );
	    } 
	   if($fd){
	       $data=array('title'=>'意见反馈回复','icon'=>__ROOT__.'/public/images/ic_logo.png','content'=>$textarea,'user_id'=>$fd['user_id'],'createtime'=>date('Y-m-d H:i:s',time()),'feedback_id'=>$id);
	       M('news')->add($data);
	       $data=array('0'=>101);
	   }else{
	       $data=array('0'=>201);
	   }
	   $this->ajaxReturn($data);
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
