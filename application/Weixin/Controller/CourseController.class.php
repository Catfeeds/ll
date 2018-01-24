<?php

/**
 * 用户登录
 */
namespace Weixin\Controller;
use Common\Controller\MemberbaseController;
use Think\Model;
//use Weixin\Controller\MineController;
use Think\Log;
class CourseController extends MemberbaseController {
	//课程
	function course(){
	    $pagesize=10;
	    $pagec=$_REQUEST['pagec']?$_REQUEST['pagec']:1;
	    $date = date('Y-m-d H:i:s', time());
	    $endtimes=($pagec-1)*$pagesize+$pagesize;
	    $c = M('Course')->where("start_time >='$date'")
	    ->distinct(true)
	    ->order("start_time asc")
	    ->limit("0,$endtimes")
	    ->select();
	    $arr=array();
	    count($c) < 10 ? $this->assign('is_load','1')  : $this->assign('is_load','0');
	    foreach ($c as $k => $v) {
	        $starttime = date("Y-m-d 00:00:00", strtotime($v[start_time]));
	        $endtime = date("Y-m-d 23:59:59", strtotime($v[start_time]));
	        $r = M('Course')->field("c.*,t.name as teacher")
	        ->table(C('DB_PREFIX') . "course as c")
	        ->join(C('DB_PREFIX') . "teacher as t on t.id = c.teacher_id", 'left')
	        ->where("c.start_time between '$starttime' and '$endtime'")
	        ->select();
	        foreach ($r as $k2 => $v2) {
	            $r[$k2][picture] = __ROOT__ . '/data/upload/avatar/' . $v2[picture];
	            $r[$k2][cover] = __ROOT__ . '/data/upload/avatar/' . $v2[cover];
	        }
	        $weeklist = array("1"=>"周一","2"=>"周二","3"=>"周三","4"=>"周四","5"=>"周五","6"=>"周六","0"=>"周日");
	        $wdate=$weeklist[date("w",strtotime($v[start_time]))];
	        $stime = date("Y-m-d", strtotime($v[start_time]));
	        $arr[$wdate.' '.$stime] = $r;
	    }
	    $rs = array();
	    foreach ($arr as $k => $v) {
	        $a = array();
	        $a['time'] = $k;
	        $b = array();
	        foreach ($v as $key => $value) {
	            $b[] = $value;
	        }
	        $a['list'] = $b;
	        $rs[] = $a;
	    }
	    $this->assign('rs',$rs);
	    $arr2="";
	    foreach($c as $b=>$d){
	        if($b == $pagesize-1){
	            $arr2=$d[start_time];
	        }
	    }
	    $e=M("course")->where("start_time like '$arr2%'")->select();
	    
        //课程意向数据
        $result_sub = M('subject')->order('index_id asc')->select();//科目数据
        $rest_tx = M('question_type')->order('index_id asc')->select();//题型数据
        $rest_nd = M('question_difficulty')->order('index_id asc')->select();//难度数据
        $rest_tj = M('topic_set')->order('index_id asc')->select();//题级数据
        $rest_ls = M('teacher_type')->field('id,title')->order('index_id asc')->select();//老师数据
        $rest_bj = M('class_type')->order('index_id asc')->select();//班级数据
        $resu_stu = M('member')
            ->alias('m')
            ->join('lailong_child c ON m.child_id = c.id')
            ->field('c.id,c.nickname,c.name')
            ->where(['m.user_id'=>session('weixin_user_id'),'vip_state'=>'3'])
            ->select();//小孩数据
        empty($resu_stu) ?  header('Location:'.U("c_jump")) : 0 ;
        $this->assign('clist',$result_sub);
        $this->assign('txlist',$rest_tx);
        $this->assign('ndlist',$rest_nd);
        $this->assign('tjlist',$rest_tj);
        $this->assign('lslist',$rest_ls);
        $this->assign('bjlist',$rest_bj);
        $this->assign('stulist',$resu_stu);
		$this->display(":course");
	}
	function page(){
	    $pagec=$_REQUEST['pagec'];
	    $pagesize=10;
	    $start_time=($pagec-1)*$pagesize;
	    $date = date('Y-m-d H:i:s', time());
	    $c = M('Course')->where("start_time >='$date'")
	    ->distinct(true)
	    ->order("start_time asc")
	    ->limit("$start_time,$pagesize")
	    ->select();
	    $arr=array();
	    foreach ($c as $k => $v) {
	        $starttime = date("Y-m-d 00:00:00", strtotime($v[start_time]));
	        $endtime = date("Y-m-d 23:59:59", strtotime($v[start_time]));
	        $r = M('Course')->field("c.*,t.name as teacher")
	        ->table(C('DB_PREFIX') . "course as c")
	        ->join(C('DB_PREFIX') . "teacher as t on t.id = c.teacher_id", 'left')
	        ->where("c.start_time between '$starttime' and '$endtime'")
	        ->select();
	        foreach ($r as $k2 => $v2) {
	            $r[$k2][picture] = __ROOT__ . '/data/upload/avatar/' . $v2[picture];
	            $r[$k2][cover] = __ROOT__ . '/data/upload/avatar/' . $v2[cover];
	        }
	        $weeklist = array("1"=>"周一","2"=>"周二","3"=>"周三","4"=>"周四","5"=>"周五","6"=>"周六","0"=>"周日");
	        $wdate=$weeklist[date("w",strtotime($v[start_time]))];
	        $stime = date("Y-m-d", strtotime($v[start_time]));
	        $arr[$wdate.' '.$stime] = $r;
	    }
	    $rs = array();
	    foreach ($arr as $k => $v) {
	        $a = array();
	        $a['time'] = $k;
	        $b = array();
	        foreach ($v as $key => $value) {
	            $b[] = $value;
	        }
	        $a['lists'] = $b;
	        $rs[] = $a;
	    }
	    $html = "";
	     foreach($rs as $a=>$r){
	     $inner = "";
	     $html .= '<div class="am-intro-hd" style=" padding-bottom: 2px">';
	     $html .= '<strong style="border-right: none">'.$r[time]. '</strong></div>';
	     foreach($r[lists] as $k=>$v){
	     if ($k == 0) {
	     $inner .= ' <div class="am-g am-intro-bd" style="padding-top: 7px; padding-bottom: 7px">';
	     } else {
	     $inner .= ' <div class="am-g am-intro-bd" style="padding-top: 0px; padding-bottom: 7px">';
	     }
	     if(date("H",strtotime($v[start_time])) > 12){
	     $dian = date("H",strtotime($v[start_time])) - 12;
	     $dians = "下午".$dian."点";
	     }else{
	     $dians = "上午".date("H",strtotime($v[start_time]))."点";
	     }
	     $detail=U('Course/course_detail?id=').$v[id];
	     $inner .= ' <a href="'.$detail.'">';
	     $inner .= '<div class="xq" style="background:#eff6ff;height: 60px">';
	     if (!empty($v[cover])) {
	     $imgurl =$v[cover];
	     } else {
	     $imgurl = "__TMPL__Public/images/math.png";
	     }
	     $inner .= '<div class="am-intro-left am-u-sm-2" style="width:45px;height: 45px;margin: 6px 0 0 6px;background-image: url(\''.$imgurl. '\');background-size: cover;background-position: 50% 50%;"></div>';
	     $inner .= '<div class="am-intro-right am-u-sm-10"><p style="font-size: 1.6rem;margin-top: 8px;max-height: 20px;overflow: hidden;">'.$v[title].'</p>';
	     $inner .= '<p style="font-size: 1.4rem;margin-top: -17px;">讲师：'.$v[teacher].'&nbsp;&nbsp; &nbsp;开课时间：'.$dians.'</div></div></a></div>';
	     }
	     $html .= $inner;
	     $html .= "</div>";
	     } 
	     $data['data']=$html;
	     if(empty($html)){
	        $data['mes'] = 0;
	     }else{
	         $data['mes'] = 1;
	     }
	    $this->ajaxReturn($data);
	}
	function more_course(){
	    $pagesize=1;
	    $datep=$_REQUEST['datep'];
	    //页数
	    //请求日期
	    $senddate=$_REQUEST['senddate'];
	    $lastcount=$_REQUEST['lastcount'];
	    $dates=$_REQUEST['dates'];
	    $params=explode('|',$dates);
	    $allpage=$_REQUEST['allpage'];
	    $arr2 = array();
	    $index_params=0;
	    $st_time="";
	    if($senddate!=""){
	        $starttime = date("Y-m-d 00:00:00", strtotime($senddate));
	        $st_time=$starttime;
	        $endtime = date("Y-m-d 23:59:59", strtotime($senddate));
	        $rsd = M('Course')
	        ->table(C('DB_PREFIX') . "course as c")
	        ->join(C('DB_PREFIX') . "teacher as t on t.id = c.teacher_id", 'left')
	        ->where("c.start_time between '$starttime' and '$endtime'")
	        ->limit($lastcount.','.$pagesize)
	        ->count();
	    }else{
	        $starttime = date("Y-m-d 00:00:00", strtotime($params[$index_params]));
	        $st_time=$starttime;
	        $endtime = date("Y-m-d 23:59:59", strtotime($params[$index_params]));
	        $rsd = M('Course')
	        ->table(C('DB_PREFIX') . "course as c")
	        ->join(C('DB_PREFIX') . "teacher as t on t.id = c.teacher_id", 'left')
	        ->where("c.start_time between '$starttime' and '$endtime'")
	        ->count();
	    }
	    //条数-查询数之差
	    $str=0;
	    //查询数大于每页条数
	    if($rsd>$pagesize){
	        if($senddate!=""){
	            $result = M('Course')->field("c.*,t.name as teacher")
	            ->table(C('DB_PREFIX') . "course as c")
	            ->join(C('DB_PREFIX') . "teacher as t on t.id = c.teacher_id", 'left')
	            ->where("c.start_time between '$starttime' and '$endtime'")
	            ->limit($lastcount.','.$pagesize)
	            ->select();
	        }else{
	            $result = M('Course')->field("c.*,t.name as teacher")
	            ->table(C('DB_PREFIX') . "course as c")
	            ->join(C('DB_PREFIX') . "teacher as t on t.id = c.teacher_id", 'left')
	            ->where("c.start_time between '$starttime' and '$endtime'")
	            ->limit('0,'.$pagesize)
	            ->select();
	        }
	        $arr2[$params[$index_params]][data]= $result;
	        $str=1;
	    }else{
	        if($senddate!=""){
	            $result = M('Course')->field("c.*,t.name as teacher")
	            ->table(C('DB_PREFIX') . "course as c")
	            ->join(C('DB_PREFIX') . "teacher as t on t.id = c.teacher_id", 'left')
	            ->where("c.start_time between '$starttime' and '$endtime'")
	            ->limit($lastcount.','.$pagesize)
	            ->select();
	        }else{
	            $result = M('Course')->field("c.*,t.name as teacher")
	            ->table(C('DB_PREFIX') . "course as c")
	            ->join(C('DB_PREFIX') . "teacher as t on t.id = c.teacher_id", 'left')
	            ->where("c.start_time between '$starttime' and '$endtime'")
	            ->select();
	        }
	        $arr2[$params[0]][data]=$result;
	        $str=$pagesize-$rsd;
	    }
	     //查询数小于每页条数
	    if($r<$pagesize){
	        $index_params+=1;
	           foreach($params as $p=>$s){
	               if($p == $index_params){
	                   if($senddate!=""){
	                       $starttimes = date("Y-m-d 00:00:00", strtotime($senddate));
	                       $endtimes = date("Y-m-d 23:59:59", strtotime($senddate));
	                       $c=M('Course')
	                       ->table(C('DB_PREFIX') . "course as c")
	                       ->join(C('DB_PREFIX') . "teacher as t on t.id = c.teacher_id", 'left')
	                       ->where("c.start_time between '$starttimes' and '$endtimes'")
	                       ->limit($lastcount.','.$pagesize)
	                       ->count();
	                       $n=M('Course')->field("c.*,t.name as teacher")
	                       ->table(C('DB_PREFIX') . "course as c")
	                       ->join(C('DB_PREFIX') . "teacher as t on t.id = c.teacher_id", 'left')
	                       ->where("c.start_time between '$starttimes' and '$endtimes'")
	                      ->limit($lastcount.','.$pagesize)
	                       ->select();
	                   }else{
	                       $starttimes = date("Y-m-d 00:00:00", strtotime($s));
	                       $endtimes = date("Y-m-d 23:59:59", strtotime($s));
	                       $n=M('Course')->field("c.*,t.name as teacher")
	                       ->table(C('DB_PREFIX') . "course as c")
	                       ->join(C('DB_PREFIX') . "teacher as t on t.id = c.teacher_id", 'left')
	                       ->where("c.start_time between '$starttimes' and '$endtimes'")
	                       ->limit('0,'.$str)
	                       ->select();
	                   }
	                $arr2[$s][data]= $n;
	                $datep=$params[$index_params+1];
	            }
	        }
	    } 
	    $html = "";
	   /*  foreach($arr2 as $a=>$r){
	        $inner = "";
	        $html .= '<div class="am-intro-hd" style=" padding-bottom: 2px">';
	        $html .= '<strong style="border-right: none">'.$a. '</strong></div>';
	        foreach($r[data] as $k=>$v){
	            if ($k == 0) {
	                $inner .= ' <div class="am-g am-intro-bd" style="padding-top: 7px; padding-bottom: 7px">';
	            } else {
	                $inner .= ' <div class="am-g am-intro-bd" style="padding-top: 0px; padding-bottom: 7px">';
	            }
	            if(date("H",strtotime($v[start_time])) > 12){
	                $dian = date("H",strtotime($v[start_time])) - 12;
	                $dians = "下午".$dian."点";
	            }else{
	                $dians = "上午".date("H",strtotime($v[start_time]))."点";
	            }
	            $inner .= ' <a href="{:U(\'Course/course_detail?id=\')}'.$v[cid]. '">';
	            $inner .= '<div class="xq" style="background:#eff6ff;height: 60px">';
	            if (!empty($v[cover])) {
	                $imgurl =__ROOT__.'/data/upload/avatar/'.$v[cover];
	            } else {
	                $imgurl = "__TMPL__Public/images/math.png";
	            }
	            $inner .= '<div class="am-intro-left am-u-sm-2" style="width:45px;height: 45px;margin: 6px 0 0 6px;background-image: url(\''.$imgurl. '\');background-size: cover;background-position: 50% 50%;"></div>';
	            $inner .= '<div class="am-intro-right am-u-sm-10"><p style="font-size: 1.6rem;margin-top: 8px;max-height: 20px;overflow: hidden;">'.$v[title].'</p>';
	            $inner .= '<p style="font-size: 1.4rem;margin-top: -17px;">讲师：'.$v[teacher].'&nbsp;&nbsp; &nbsp;开课时间：'.$dians.'</div></div></a></div>';
	        }
	        $html .= $inner;
	        $html .= "</div>";
	    } */
	    $this->ajaxReturn(array('0'=>$arr2,'1'=>$datep,'2'=>$allpage*$pagesize));
	}
	
	//课程意向提交
	function course_sub(){
        if(IS_POST){
            $data = ['user_id'=>session('weixin_user_id'),'child_id'=>I('post.yx'),'grade'=>I('post.xd'),'press'=>I('post.jc'),'subject'=>I('post.km'),'chapter'=>I(post.zj),
                'sub_chapter'=>I('post.erzj'),'question_type'=>I('post.tx'),'question_difficulty'=>I('post.nd'),'topic_set'=>I('post.tj'),
                'teacher'=>I('post.ls'),'class_type'=>I('post.bj'),'createtime'=>date('Y-m-d H:i:s',time())];
            if(I('post.times')){
                $data['wanted_start_time']=I('post.times');
            }
            $rest =  M('intention')->add($data);
            if($rest){
                session('yx_stu',I('post.yx'));
                session('c_active','1');
                $code = ['status'=>'1','mes'=>'提交成功','cid'=>I('post.yx')];
            }else{
                $code = ['status'=>'0','mes'=>'提交失败'];
            }
            $this->ajaxReturn($code);
        }
    }
   //判断认证小孩跳转
    function c_jump(){
        $this->display('/nohuiyuan');
    }
    //ajax获取教材
    function course_textbook(){
        if(IS_POST){
            $subj = I('post.subj');
            $rest = M('textbook')->where(['subject'=>$subj])->group("press")->select();
            $this->ajaxReturn($rest);
        }
    }
    //ajax获取学段
    function course_pre(){
        if(IS_POST){
            $subj = I('post.subj');
            $pre = I('post.jc');
            $rest = M('textbook')->where(['subject'=>$subj,'press'=>$pre])->select();
            $this->ajaxReturn($rest);
        }
    }
    //ajax获取章
    function course_chapter(){
        if(IS_POST){
            $sub = I('post.sub');
            $pre = I('post.pre');
            $gra = I('post.gra');
            $where = ['subject'=>$sub,'press'=>$pre,'gra'=>$gra];
            $tbookid = M('textbook')->field('id')->where($where)->find();
            $rest = M('chapter')->field('title,textbook_id')->where(['textbook_id'=>$tbookid['id'],'parent_id'=>'0'])->order('id asc')->select();
            $this->ajaxReturn($rest);
        }
    }
    //ajax获取节
    function course_jie(){
        if(IS_POST){
            $sub = I('post.sub');
            $pre = I('post.pre');
            $gra = I('post.gra');
            $where = ['subject'=>$sub,'press'=>$pre,'gra'=>$gra];
            $tbook_id = M('textbook')->field('id')->where($where)->find();
            $title = I('post.zj');
            $id = M('chapter')->field('id')->where(['textbook_id'=>$tbook_id['id'],'title'=>$title])->find();
            $rest = M('chapter')->field('title')->where(['textbook_id'=>$tbook_id['id'],'parent_id'=>$id['id']])->select();
            $this->ajaxReturn($rest);
        }
    }
	//课程详情
	function course_detail(){
        session('c_active',null);
		$id = $_GET['id'];
		if($id){
			$list = M("course c")->field("c.*,t.id as tid,t.name as teacher,t.avatar as tavatar,t.teaching_results,h5.content,r.address,r.title as rtitle")
			->join(C('DB_PREFIX')."teacher as t on t.id = c.teacher_id","left")
			->join(C('DB_PREFIX')."h5 as h5 on h5.id = c.h5_id","left")
			->join(C('DB_PREFIX')."classroom as r on r.id = c.classroom_id","left")
			->where("c.id = $id")->find();
		}
		$open_id = $_SESSION['weiopen_id'];
		//是否被该用户收藏
		$user_id = get_user_id($open_id);
		$is_collected = M("collection")->where("user_id = $user_id and course_id = $id")->find();
		if(!empty($is_collected)){
			$is_collect = 1;
		}
		
		$this->assign("is_collect",$is_collect);
		$this->assign("list",$list);
		$this->display(":course_detail");
	}
	//教师详情
	function teacher_information(){
		$id = $_REQUEST['id'];
		$list = M("teacher")->where("id = $id")->find();
		
		
		$this->assign("list",$list);
		$this->display(":teacher_information");
	}
	//填写订单
	function write_order(){
	    $user=$_SESSION['weixin_user_id'];
	    $courseid=$_REQUEST['courseid'];
	    $course=M('course')->where("id = $courseid")->find();
	    $teacher=M('teacher')->where("id = '$course[teacher_id]'")->find();
	    $child=M('member')->field("c.id,c.name,c.nickname")->table(C('DB_PREFIX').'member as m')->join(C('DB_PREFIX').'child as c on c.id =m.child_id','left')->where("m.user_id = $user and c.vip_state =3")->select();
	    $this->assign("course",$course);
	    $this->assign("child",$child);
	    $this->assign("teacher",$teacher);
		$this->display(":write_order");
	}
	//支付积分
	function do_pay(){
	    $user=$_SESSION['weixin_user_id'];
	    $child=$_REQUEST['child'];
	    $integral=$_REQUEST['integral'];
	    $course_id=$_REQUEST['courseid'];
	    $enr=M('enrollment')->where("course_id = $course_id and user_id = $user and state =0")->find();
	    if($enr){
	        $m=new MineController();
	        $m->isjifen($integral, $enr[id]);
	       // $this->ajaxReturn(array("0"=>"104","1"=>$enr[id]));
	    }
	    $result=M('enrollment')->where("course_id = $course_id and user_id = $user and child_id= '$child' and state =1")->find();
	    if($result){
	        $this->ajaxReturn(array("0"=>"102","1"=>'已存在订单'));
	    }
	    //生成订单
	    $data=array('order_id'=>'lailong'.uniqid(),'child_id'=>$child,'state'=>0,'course_id'=>$course_id,'user_id'=>$user,'note'=>$note,'createtime'=>date('Y-m-d H:i:s',time()),'integral'=>$integral);
	    $res=M('enrollment')->add($data);
	    if($res){
	        $param=array('enrollment_id'=>$res,'state'=>0,'state_text'=>"订单已提交",'createtime'=>date('Y-m-d H:i:s',time()));
	        M('enrollment_state')->add($param);
	        //$res=M('course')->where("id = $course_id")->find();
	        $u=M('user')->field("integral")->where('id ='.$user)->find();
	        if($u[integral] <$integral){
	            $this->ajaxReturn(array("0"=>"103","1"=>'当前支付积分不足'));
	        }
	        M('user')->where("id = $user")->save(array('integral'=>intval($u[integral]-$integral)));
	         
	        $data2=array(
	            'user_id'=>$user,
	            'obtain_type'=>4,
	            'is_obtain'=>0,
	            'integral'=>intval(0-$integral),
	            'content'=>"支付课程费".$integral.'积分',
	            'createtime'=>date('Y-m-d H:i:s',time())
	        );
	        M('integral')->add($data2);
	        $str=M('enrollment')->field("state")->where("id = $res")->find();
	        if($str[state] == 1){
	            $this->ajaxReturn(array("0"=>"102","1"=>'此订单已完成支付'));
	        }
	        M('enrollment')->where("id = $res")->save(array('state'=>1));
	        $param=array('enrollment_id'=>$res,'state'=>1,'state_text'=>"支付成功",'createtime'=>date('Y-m-d H:i:s',time()));
	        M('enrollment_state')->add($param);
	        $this->ajaxReturn(array("0"=>"101","1"=>'完成支付','2'=>$res));
	        
	    }else{
	        $this->ajaxReturn(array("0"=>"102","1"=>'生成订单失败'));
	    }
	    
	}
	//课程意向
	function write_application(){
        $result = M('member')
            ->alias('m')
            ->join('lailong_child c ON m.child_id = c.id')
            ->field('c.id,c.nickname,c.name')
            ->where(['m.user_id'=>session('weixin_user_id'),'vip_state'=>'3'])
            ->select();
        $this->assign('child',$result);
        $this->display(":write_application");
	}
    //意见直接填写
	function stu_intention(){
	    if(IS_POST){
            $stu_id = I('post.child');
            $content = I('post.stu_i');
            empty($content) ? $this->error('输入反馈内容') : 0 ;
            $data = ['user_id'=>session('weixin_user_id'),'child_id'=>$stu_id,'content'=>$content,'createtime'=>date('Y-m-d H:i:s',time())];
            $result = M('intention')->add($data);
            if($result ){
                session('yx_stu',I('post.child'));
                session('c_active','1');
                $code = ['status'=>'添加成功','cid'=>I('post.child')];
                $this->ajaxReturn($code);
            }else{
                $code = ['status'=>'服务器忙请稍后重试'];
                $this->ajaxReturn($code);
            }
        }else{
	        $this->error('不存在你访问的页面');
        }

    }
    //添加收藏
    function put_collection(){
    	$course_id = $_REQUEST['course_id'];
    	$weiopen_id = $_SESSION['weiopen_id'];
    	$user_id = get_user_id($weiopen_id);
    	//是否存在
    	$is_collected = M("collection")->where("user_id = $user_id and course_id = $course_id")->find();
    	if(!empty($is_collected)){
    		//取消收藏
    		$success = M("collection")->where("user_id = $user_id and course_id = $course_id")->delete();
    		if($success){
	    		$msg = array("0"=>"103");
	    	}else{
	    		$msg = array("0"=>"104");
	    	}
    	}else{
    		//添加收藏
	    	$data = array(
	    		"course_id"=>$course_id,
	    		"user_id"=>$user_id,
	    		"createtime"=>date("Y-m-d H:i:s"),
	    	);
	    	$success = M("collection")->add($data);
	    	if($success){
	    		$msg = array("0"=>"101");
	    	}else{
	    		$msg = array("0"=>"102");
	    	}
    	}
    	
    	return $this->ajaxReturn($msg);
    }
}
