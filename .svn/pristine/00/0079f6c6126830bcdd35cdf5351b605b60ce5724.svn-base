<?php

namespace Record\Controller;
use Common\Controller\AdminbaseController;
class RecordController extends AdminbaseController {
	function _initialize() {
	}
	//选择型意向
     public function intention(){
        $child=M('child')->select();
        $this->assign("child",$child);
        $grade=M('grade')->select();
        $this->assign("grade",$grade);
        $subject=M('subject')->select();
        $this->assign('subject',$subject);
        $question_type=M('question_type')->select();
        $this->assign('question_type',$question_type);
        $question_difficulty=M('question_difficulty')->select();
        $this->assign('question_difficulty',$question_difficulty);
        $class_type=M('class_type')->select();
        $this->assign('class_type',$class_type);
        $child=$_POST[child];
        $grade=$_POST[grade];
        $subject=$_POST[subject];
        $question_type=$_POST[question_type];
        $question_difficulty=$_POST[question_difficulty];
        $wanted_start_time=$_POST[wanted_start_time];
        $teacher=$_POST[teacher];
        $class_type=$_POST[class_type];
        $_SESSION['num_intention']="";
        $_SESSION['i_res']="";
         $where= "1=1";
         if($_REQUEST['leixing']==1){
             $_SESSION['child']=$child;
             $_SESSION['grade']=$grade;
             $_SESSION['subject']=$subject;
             $_SESSION['question_type']=$question_type;
             $_SESSION['question_difficulty']=$question_difficulty;
             $_SESSION['wanted_start_time']=$wanted_start_time;
             $_SESSION['teacher']=$teacher;
             $_SESSION['class_type']=$class_type;
         }
         
         if($_SESSION['child']!=""){
             $where.=" and ch.id =".$_SESSION['child'];
         }
         if($_SESSION[grade]!=""){
             $where.=" and i.grade like '%".$_SESSION['grade']."%'";
         }
         if($_SESSION[subject]!=""){
             $where.=" and i.subject like '%".$_SESSION['subject']."%'";
         }
         if($_SESSION[question_type]!=""){
             $where.=" and i.question_type like '%".$_SESSION['question_type']."%'";
         }
         if($_SESSION[question_difficulty]!=""){
             $where.=" and i.question_difficulty like '%".$_SESSION['question_difficulty']."%'";
         }
         if($_SESSION[wanted_start_time]!=""){
             $where.=" and i.wanted_start_time like '%".$_SESSION['wanted_start_time']."%'";
         }
         if($_SESSION[teacher]!=""){
             $where.=" and i.teacher like '%".$_SESSION['teacher']."%'";
         }
         if($_SESSION[class_type]!=""){
             $where.=" and i.class_type like '%".$_SESSION['class_type']."%'";
         }
         $where.=" and (i.content is null or i.content = '') ";
         $model = M ("intention");
         $field="i.*,u.phone,ch.name";
         $count = $model->table(C('DB_PREFIX')."intention as i")
         ->join(C('DB_PREFIX')."user as u on u.id = i.user_id",'left')
         ->join(C('DB_PREFIX').'child as ch on ch.id =i.child_id','left')
         ->where($where)->count();
         $page = $this->page($count, 10);
         $list = $model->field($field)->table(C('DB_PREFIX')."intention as i")->join(C('DB_PREFIX')."user as u on u.id = i.user_id",'left')->join(C('DB_PREFIX').'child as ch on ch.id =i.child_id','left')->order("i.createtime DESC")->limit($page->firstRow . ',' . $page->listRows)->where($where)->select();
         $this->assign("list",$list);
         //var_dump($list);die;
         // $str="";
         // foreach($list as $l =>$li){
         //     if($li[content] == ""){
         //         $str.=$li[id].',';
         //     }
         // }
         // $str=trim($str,',');
         // //var_dump($str);
         // if($str){
         //     $lists = $model->field($field)->table(C('DB_PREFIX')."intention as i")->join(C('DB_PREFIX')."user as u on u.id = i.user_id",'left')->join(C('DB_PREFIX').'child as ch on ch.id =i.child_id','left')->order("i.createtime DESC")->limit($page->firstRow . ',' . $page->listRows)->select();
         //     //var_dump($lists);
         //     $this->assign('list', $lists);
         // }
         //die;
         $this->assign("page", $page->show('Admin'));
          $this->assign("formget",$_SESSION);
         //$this->assign("formget",$_SESSION);
         $this->display();
     }
     //填写型意向
     public function intention2(){
        $_SESSION['num_intention']="";
        $_SESSION['i_res']="";
         $where= "1=1";
         $model = M ("intention");
         //$field="i.*,u.phone";
         //修改
         $where.=" and i.content is not null and i.content !='' ";//content字段不为空
         $field="i.id,i.content,i.createtime,u.phone,ch.name as childname";
         $count = $model->table(C('DB_PREFIX')."intention as i")->join(C('DB_PREFIX')."user as u on u.id = i.user_id",'left')->join(C('DB_PREFIX').'child as ch on ch.id =i.child_id','left')->where($where)->count();
         $page = $this->page($count, 10);
         $list = $model->field($field)->table(C('DB_PREFIX')."intention as i")->join(C('DB_PREFIX')."user as u on u.id = i.user_id",'left')->join(C('DB_PREFIX').'child as ch on ch.id =i.child_id','left')->order("i.createtime DESC")->limit($page->firstRow . ',' . $page->listRows)->where($where)->select();
         //$array=array();
         // foreach($list as $l =>$li){
         //     if($li[content] != ''){
         //         $array[$l][id]=$li[id];
         //         $array[$l][content]=$li[content];
         //         $array[$l][createtime]=$li[createtime];
         //         $array[$l][phone]=$li[phone];
         //     }
         // }
         //$this->assign('list', $array);
         $this->assign("list",$list);
         $this->assign("page", $page->show('Admin'));
         $this->assign("formget",$_SESSION);
         $this->display();
     }
     //
     public function find(){
         $model = M ("intention");
         $field="i.*,u.phone,ch.name";
         $where="i.id = $_GET[id]";
         $list = $model->field($field)->table(C('DB_PREFIX')."intention as i")->join(C('DB_PREFIX')."user as u on u.id = i.user_id",'left')->join(C('DB_PREFIX').'child as ch on ch.id =i.child_id','left')->where($where)->find();
         $this->assign('list', $list);
         $this->display();
     }
     //关联意向表
     public function relation(){
        $today=date("Y-m-d");
        $intention_id = $_REQUEST['id'];
        $this->assign("id",$intention_id);
        $type=$_REQUEST['type'];
        $this->assign("type",$type);
        //先展示意向资料//弹窗会不会好一点？//然后放课程资料我觉得不错//
        $intention_info=M("intention")->alias('i')
        ->field("i.*,u.phone as uphone,u.name as uname ,ch.name as chname,i.course_id")
        ->join(" left join ".C("DB_PREFIX")."user as u on u.id = i.user_id left join ".C("DB_PREFIX")."child as ch on ch.id = i.child_id  ")
        ->where(" i.id = ".$intention_id)->find();
        $this->assign("intention_info",$intention_info);
        //课程信息
        $course = M('course')->alias("c")
        ->field("c.*,t.name as tname")
        ->join(" left join ".C("DB_PREFIX")."teacher t on t.id = c.teacher_id ")
        ->where(" start_time >= '".$today."' ")->select();
        //查看关联课程
        if($intention_info['course_id']){
            $cinfo=M('course')->alias("c")
        ->field("c.*,t.name as tname")
        ->join(" left join ".C("DB_PREFIX")."teacher t on t.id = c.teacher_id ")
        ->where(" c.id = '".$intention_info['course_id']."' ")->find();
        $this->assign("cinfo",$cinfo);
        }
        $this->assign("course",$course);
         $this->display();

     }

     public function relation_post(){
        if(empty($_POST['id'])){
            $this->error("用户信息获取失败，请重试");
        }
        if(empty($_POST['course_id'])){
            $this->error("请选择关联课程");
        }
        if(IS_POST){
            $type=$_POST['type'];
            unset($_POST['type']);
            if (M("intention")->create()!==false){
                if (M("intention")->save()!==false) {
                    if($type=='1'){
                       $this->success(L('ADD_SUCCESS'), U("Record/intention")); 
                    }elseif($type=='2'){
                        $this->success(L('ADD_SUCCESS'), U("Record/intention2"));
                    }
                    
                } else {
                    $this->error(L('ADD_FAILED'));
                }
            } else {
                $this->error(M("intention")->getError());
            }
        
        }
     }
}
