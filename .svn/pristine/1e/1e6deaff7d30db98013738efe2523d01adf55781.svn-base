<?php

namespace Testbase\Controller;
use Common\Controller\AdminbaseController;
class CourseController extends AdminbaseController {
	function _initialize() {
	}
    /**
     *排课列表
     */
    public function courselist() {
        //测试清除session
        // $_SESSION['xiaoxi']="";
        // $_SESSION['res']="";
        $teacher=M('teacher')->select();
        $this->assign('teacher',$teacher);
        $title=$_REQUEST['title'];
        $teacher_id=$_REQUEST['teacher_id'];
        $rated_number=$_REQUEST['rated_number'];//小于这个数的额定人数
        $integral=$_REQUEST['integral'];//小于这个数的积分
        $sstart_time=$_REQUEST['sstart_time'];
        $estart_time=$_REQUEST['estart_time'];
        $where= "1=1";
        if(!empty($title)){
            $where.=" and c.title like '%".$title."%' ";
            $parameter['title']=$title;
            $this->assign('title',$title);
        }
        if(!empty($teacher_id)){
            $where.=" and c.teacher_id = ".$teacher_id;
            $parameter['teacher_id']=$teacher_id;
            $this->assign('teacher_id',$teacher_id);
        }
        if(!empty($rated_number)){
            $where.=" and c.rated_number <=".$rated_number;
            $parameter['rated_number']=$rated_number;
            $this->assign('rated_number',$rated_number);
        }
        if(!empty($integral)){
            $where.=" and c.integral <=".$integral;
            $parameter['integral']=$integral;
            $this->assign('integral',$integral);
        }
        if(!empty($sstart_time)){
            $where.=" and c.start_time>= '".$sstart_time."' ";
            $parameter['sstart_time']=$sstart_time;
            $this->assign('sstart_time',$sstart_time);
        }
        if(!empty($estart_time)){
            $where.=" and c.start_time <= '".$estart_time."' ";
            $parameter['estart_time']=$estart_time;
            $this->assign('estart_time',$estart_time);
        }
        $model = M ("course");
        $count = $model->table(C('DB_PREFIX')."course as c")
        ->join(C('DB_PREFIX')."teacher as t on t.id = c.teacher_id",'left')
        ->join(C('DB_PREFIX')."h5 as h on h.id = c.h5_id",'left')
        ->where($where)->count();
        $page = $this->page($count, C('PAGENUM'));
        $list = $model->table(C('DB_PREFIX')."course as c")
        ->field("c.id,c.title,c.picture,c.start_time,c.rated_number,c.integral,c.createtime,t.name as teacher,h.title as h5") 
        ->join(C('DB_PREFIX')."teacher as t on t.id = c.teacher_id",'left')
        ->join(C('DB_PREFIX')."h5 as h on h.id = c.h5_id",'left')->order("c.id DESC")->limit($page->firstRow . ',' . $page->listRows)->where($where)->select();
        //已经连接2张表了不能再多了，foreach添加
        foreach ($list as $k => $v) {
            if($v['id']){
                $list[$k]['sign_up_num']=M('enrollment')->where(" course_id = ".$v['id']." and (state = 1 or state = 3 ) ")->count();//报名人数
                $list[$k]['intention_num']=M('intention')->where(" course_id = ".$v['id'])->count();//意向人数
            }
        }
        $this->assign('list', $list);
        if($parameter){
            foreach ($parameter as $key => $value) {
                $page->parameter .= "$key=".urlencode($value)."&";
            }
        } 
        $this->assign("page", $page->show('Admin'));
       	$this->display();
    }
    //添加课程
     public function addcourse(){
         $teacher=M('teacher')->select();
         $classroom = M("classroom")->select();
         
         $this->assign('classroom',$classroom);
         $this->assign('teacher',$teacher);
         $this->display();
     }
     public function add_post(){
         $title=$_REQUEST['title'];
         $picture=$_REQUEST['picture'];
         $cover=$_REQUEST['cover'];
         $rated_number=$_REQUEST['rated_number'];
         $integral=$_REQUEST['integral'];
         $teacher_id=$_REQUEST['teacher_id'];
         $classroom_id=$_REQUEST['classroom_id'];
         $h5_textareas=$_REQUEST['textareas'];
         $start_time=$_REQUEST['start_time'];
         if(empty($title)){
             $this->error("请填写名称");
         }
         if(empty($picture)){
             $this->error("请选择详情图片");
         }
         if(empty($cover)){
             $this->error("请选择列表图片");
         }
         if(empty($rated_number)){
             $this->error("请填写额定人数");
         }
         if(empty($integral)){
             $this->error("请填写兑换积分");
         }
         if($teacher_id == 0){
             $this->error("请选择讲师");
         }
         if($classroom_id == 0){
             $this->error("请选择教室");
         }
         if(empty($start_time)){
            $this->error("请选择开课时间");
         }
         /*if($h5_textareas == ""){
         	$this->error("请填写课程详情");
         }*/
         if(M('course')->where("title = '$name'")->find()){
             $this->error("已有此课程");
         }
         if($h5_textareas){
         	//h5添加
	         $data_h5 = array(
	         	"title"=>"",
	         	"content"=>$h5_textareas,
	         	"url"=>"",
	         	"createtime"=>date("Y-m-d H:i:s"),
	         );
	         $h5_id = M("h5")->add($data_h5);
	         $_POST['h5_id'] = $h5_id;
         }
         if(IS_POST){
            $_POST['createtime']=date("Y-m-d H:i:s");
            $_POST['updatetime']=date("Y-m-d H:i:s");
            if (M("course")->create()!==false){
                if (M("course")->add()!==false) {
                    $this->success(L('ADD_SUCCESS'), U("Course/courselist"));
                } else {
                    $this->error(L('ADD_FAILED'));
                }
            } else {
                $this->error(M("question_difficulty")->getError());
            }
        }
     }
     public function editcourse(){
         $editid=$_REQUEST['editid'];
         $res=M('course')->where("id = $editid")->find();
         if($res[h5_id]){
         	$h5=M("H5")->where("id = $res[h5_id]")->find();
         }
         $teacher=M('teacher')->select();
         $classroom = M("classroom")->select();
         
         $this->assign('classroom',$classroom);
         $this->assign('id',$editid);
         $this->assign('h5',$h5);
         $this->assign('teacher',$teacher);
         $this->assign('res',$res);
         $this->display();
     }
     public function edit_post(){
         $editid=$_REQUEST['editid'];
         $title=$_REQUEST['title'];
         $picture=$_REQUEST['picture'];
         $cover=$_REQUEST['cover'];
         $rated_number=$_REQUEST['rated_number'];
         $integral=$_REQUEST['integral'];
         $teacher_id=$_REQUEST['teacher_id'];
         $classroom_id = $_REQUEST['classroom_id'];
         $h5_textareas=$_REQUEST['textareas'];
         $h5_id=$_REQUEST['h5_id'];
         $start_time=$_REQUEST['start_time'];
         if(empty($title)){
             $this->error("请填写名称");
         }
         if(empty($picture)){
             $this->error("请选择详情图片");
         }
         if(empty($cover)){
             $this->error("请选择列表图片");
         }
         if(empty($rated_number)){
             $this->error("请填写额定人数");
         }
         if(empty($integral)){
             $this->error("请填写兑换积分");
         }
         if($teacher_id == 0){
             $this->error("请选择讲师");
         }
         if($classroom_id == 0){
             $this->error("请选择教室");
         }
         if(empty($start_time)){
            $this->error("请选择开课时间");
         }
         /*if($h5_textareas == ""){
         	$this->error("请填写课程详情");
         }*/
        if($h5_id){
        	//h5修改
	         $data_h5 = array(
	         	"content"=>$h5_textareas,
	         );
	         $h5_id = M("h5")->where("id = $h5_id")->save($data_h5);
        }else{
        	if($h5_textareas){
        		//h5添加
		        $data_h5 = array(
		         	"title"=>"",
		         	"content"=>$h5_textareas,
		         	"url"=>"",
		         	"createtime"=>date("Y-m-d H:i:s"),
		         );
		         $h5_id = M("h5")->add($data_h5);
		         $_POST['h5_id'] = $h5_id;
        	}
        }
         
         if(IS_POST){
            $_POST['updatetime']=date("Y-m-d H:i:s");
            if (M("course")->create()!==false){
                if (M("course")->save()!==false) {
                    $this->success(L('ADD_SUCCESS'), U("Course/courselist"));
                } else {
                    $this->error(L('ADD_FAILED'));
                }
            } else {
                $this->error(M("question_difficulty")->getError());
            }
        }
     }
     public function delete(){
         $id=$_REQUEST[id];
         if(M('course')->where("id = $id")->delete()){
             $this->success("删除成功");
         }else{
             $this->error("删除失败");
         }
     }
     //过滤效率图
     function up(){
         $savename="";
         $config = array (
             'FILE_UPLOAD_TYPE' => sp_is_sae () ? "Sae" : 'Local',
             'rootPath' =>  C ( "UPLOADPATH" ),
             /* 'maxSize' => 2097152, // 2M  */
             /* 'maxSize' => 104857600, // 100M  */
             'saveName' => array (
                 'uniqid',
                 $param.time()
             ),
             'exts' => array (
                 'jpg',
                 'png',
                 'jpeg',
                 'gif',
                 'bmp'
             ),
             'autoSub' => false
         );
         $upload = new \Think\Upload ( $config );
         $info = $upload->upload ();
         $first = array_shift($info);
         $savename= $first['savename'];
         //ajax返回数据
         if ($savename) {
             $this->ajaxReturn ( sp_ajax_return ( array (
                 'iconname'=>$savename
             ), "上传成功！", 1 ), "AJAX_UPLOAD" );
         } else {
             $this->ajaxReturn ( sp_ajax_return ( array (), $upload->getError (), 0 ), "AJAX_UPLOAD" );
         }
     }
     //过滤效率图
     function up2(){
         $savename="";
         $config = array (
             'FILE_UPLOAD_TYPE' => sp_is_sae () ? "Sae" : 'Local',
             'rootPath' =>  C ( "UPLOADPATH" ),
             /* 'maxSize' => 2097152, // 2M  */
             /* 'maxSize' => 104857600, // 100M  */
             'saveName' => array (
                 'uniqid',
                 $param.time()
             ),
             'exts' => array (
                 'jpg',
                 'png',
                 'jpeg',
                 'gif',
                 'bmp'
             ),
             'autoSub' => false
         );
         $upload = new \Think\Upload ( $config );
         $info = $upload->upload ();
         $first = array_shift($info);
         $savename= $first['savename'];
         //ajax返回数据
         if ($savename) {
             $this->ajaxReturn ( sp_ajax_return ( array (
                 'iconname2'=>$savename
             ), "上传成功！", 1 ), "AJAX_UPLOAD" );
         } else {
             $this->ajaxReturn ( sp_ajax_return ( array (), $upload->getError (), 0 ), "AJAX_UPLOAD" );
         }
     }
     function deleteicon()
     {
         if(!empty($_POST['img2']))
         {
             unlink("./data/upload/avatar/$_POST[img2]");
         }
     }
     function deleteicon2()
     {
         if(!empty($_POST['img3']))
         {
             unlink("./data/upload/avatar/$_POST[img3]");
         }
     }

    public function Questiondifflist(){
        $where= "1=1";
        $title=$_REQUEST['title'];
        if(!empty($title)){
            $where.=" and title like '%".$title."%' ";
            $parameter['title']=$title;
            $this->assign('title',$title);
        }
        $model=M("question_difficulty");
        $count = $model->where($where)->count();
        $page = $this->page($count, C('PAGENUM'));
        $list=$model->where($where)->order("index_id ASC")->limit($page->firstRow . ',' . $page->listRows)->select();
        if($parameter){
            foreach ($parameter as $key => $value) {
                $page->parameter .= "$key=".urlencode($value)."&";
            }
        } 
        $this->assign("page", $page->show('Admin'));
        $this->assign("list",$list);
        $this->display();
    }

    public function addQuestiondiff(){
        $this->display();
    }

    public function addQuestiondiff_post(){
        if(empty($_POST['title'])){
            $this->error("题难度名称不能为空");
        }
        if(empty($_POST['index_id'])&&$_POST['index_id']!='0'){
            $_POST['index_id']='99';
        }
        $is_exist=M('question_difficulty')->where("title = '".$_POST['title']."'")->find();
        if(empty($is_exist)){
            if(IS_POST){
                $_POST['createtime']=date("Y-m-d H:i:s");
                if (M("question_difficulty")->create()!==false){
                    if (M("question_difficulty")->add()!==false) {
                        $this->success(L('ADD_SUCCESS'), U("Course/Questiondifflist"));
                    } else {
                        $this->error(L('ADD_FAILED'));
                    }
                } else {
                    $this->error(M("question_difficulty")->getError());
                }
        
            }
        }else{
            $this->error("题难度名称已存在");
        }
    }

    public function editQuestiondiff(){
        $res=M("question_difficulty")->where("id = $_REQUEST[editid]")->find();
        $this->assign($res);
        $this->display();
    }

    public function editQuestiondiff_post(){
        if(empty($_POST['title'])){
            $this->error("题难度名称不能为空");
        }
        if(empty($_POST['index_id'])&&$_POST['index_id']!='0'){
            $_POST['index_id']='99';
        }
        $is_exist=M('question_difficulty')->where("title = '".$_POST['title']."'")->find();
        if(empty($is_exist)){
            if(IS_POST){
                $_POST['createtime']=date("Y-m-d H:i:s");
                if (M("question_difficulty")->create()!==false){
                    if (M("question_difficulty")->save()!==false) {
                        $this->success(L('ADD_SUCCESS'), U("Course/Questiondifflist"));
                    } else {
                        $this->error(L('ADD_FAILED'));
                    }
                } else {
                    $this->error(M("question_difficulty")->getError());
                }
        
            }
        }else{
            $this->error("题难度名称已存在");
        }
    }

    public function deleteQuestiondiff(){
        $id = I("get.id",0,"intval");
        if (M('question_difficulty')->delete($id)!==false) {
            $this->success("删除成功！");
        } else {
            $this->error("删除失败！");
        }
    }

        public function questiontypelist(){
        $where= "1=1";
        $title=$_REQUEST['title'];
        if(!empty($title)){
            $where.=" and title like '%".$title."%' ";
            $parameter['title']=$title;
            $this->assign('title',$title);
        }
        $model=M("question_type");
        $count = $model->where($where)->count();
        $page = $this->page($count, C('PAGENUM'));
        $list=$model->where($where)->order("index_id ASC")->limit($page->firstRow . ',' . $page->listRows)->select();
        if($parameter){
            foreach ($parameter as $key => $value) {
                $page->parameter .= "$key=".urlencode($value)."&";
            }
        } 
        $this->assign("page", $page->show('Admin'));
        $this->assign("list",$list);
        $this->display();
    }

    public function addquestiontype(){
        $this->display();
    }

    public function addquestiontype_post(){
        if(empty($_POST['title'])){
            $this->error("题型不能为空");
        }
        if(empty($_POST['index_id'])&&$_POST['index_id']!='0'){
            $_POST['index_id']='99';
        }
        $is_exist=M('question_type')->where("title = '".$_POST['title']."'")->find();
        if(empty($is_exist)){
            if(IS_POST){
                $_POST['createtime']=date("Y-m-d H:i:s");
                if (M("question_type")->create()!==false){
                    if (M("question_type")->add()!==false) {
                        $this->success(L('ADD_SUCCESS'), U("Course/questiontypelist"));
                    } else {
                        $this->error(L('ADD_FAILED'));
                    }
                } else {
                    $this->error(M("question_type")->getError());
                }
        
            }
        }else{
            $this->error("题型已存在");
        }
    }

    public function editquestiontype(){
        $res=M("question_type")->where("id = $_REQUEST[editid]")->find();
        $this->assign($res);
        $this->display();
    }

    public function editquestiontype_post(){
        if(empty($_POST['title'])){
            $this->error("题型不能为空");
        }
        if(empty($_POST['index_id'])&&$_POST['index_id']!='0'){
            $_POST['index_id']='99';
        }
        $is_exist=M('question_type')->where("title = '".$_POST['title']."'")->find();
        if(empty($is_exist)){
            if(IS_POST){
                $_POST['createtime']=date("Y-m-d H:i:s");
                if (M("question_type")->create()!==false){
                    if (M("question_type")->save()!==false) {
                        $this->success(L('ADD_SUCCESS'), U("Course/questiontypelist"));
                    } else {
                        $this->error(L('ADD_FAILED'));
                    }
                } else {
                    $this->error(M("question_type")->getError());
                }
        
            }
        }else{
            $this->error("题型已存在");
        }
    }

    public function deletequestiontype(){
        $id = I("get.id",0,"intval");
        if (M('question_type')->delete($id)!==false) {
            $this->success("删除成功！");
        } else {
            $this->error("删除失败！");
        }
    }

    public function topicsetlist(){
        $where= "1=1";
        $title=$_REQUEST['title'];
        if(!empty($title)){
            $where.=" and title like '%".$title."%' ";
            $parameter['title']=$title;
            $this->assign('title',$title);
        }
        $model=M("topic_set");
        $count = $model->where($where)->count();
        $page = $this->page($count, C('PAGENUM'));
        $list=$model->where($where)->order("index_id ASC")->limit($page->firstRow . ',' . $page->listRows)->select();
        if($parameter){
            foreach ($parameter as $key => $value) {
                $page->parameter .= "$key=".urlencode($value)."&";
            }
        } 
        $this->assign("page", $page->show('Admin'));
        $this->assign("list",$list);
        $this->display();
    }

    public function addtopicset(){
        $this->display();
    }

    public function addtopicset_post(){
        if(empty($_POST['title'])){
            $this->error("题集不能为空");
        }
        if(empty($_POST['index_id'])&&$_POST['index_id']!='0'){
            $_POST['index_id']='99';
        }
        $is_exist=M('topic_set')->where("title = '".$_POST['title']."'")->find();
        if(empty($is_exist)){
            if(IS_POST){
                $_POST['createtime']=date("Y-m-d H:i:s");
                if (M("topic_set")->create()!==false){
                    if (M("topic_set")->add()!==false) {
                        $this->success(L('ADD_SUCCESS'), U("Course/topicsetlist"));
                    } else {
                        $this->error(L('ADD_FAILED'));
                    }
                } else {
                    $this->error(M("topic_set")->getError());
                }
        
            }
        }else{
            $this->error("题集已存在");
        }
    }

    public function edittopicset(){
        $res=M("topic_set")->where("id = $_REQUEST[editid]")->find();
        $this->assign($res);
        $this->display();
    }

    public function edittopicset_post(){
        if(empty($_POST['title'])){
            $this->error("题集不能为空");
        }
        if(empty($_POST['index_id'])&&$_POST['index_id']!='0'){
            $_POST['index_id']='99';
        }
        $is_exist=M('topic_set')->where("title = '".$_POST['title']."'")->find();
        if(empty($is_exist)){
            if(IS_POST){
                $_POST['createtime']=date("Y-m-d H:i:s");
                if (M("topic_set")->create()!==false){
                    if (M("topic_set")->save()!==false) {
                        $this->success(L('ADD_SUCCESS'), U("Course/topicsetlist"));
                    } else {
                        $this->error(L('ADD_FAILED'));
                    }
                } else {
                    $this->error(M("topic_set")->getError());
                }
        
            }
        }else{
            $this->error("题集已存在");
        }
    }

    public function deletetopicset(){
        $id = I("get.id",0,"intval");
        if (M('topic_set')->delete($id)!==false) {
            $this->success("删除成功！");
        } else {
            $this->error("删除失败！");
        }
    }
//查询意向人员
    public function intention_num_info(){
        $course_id=$_POST['id'];
        $info=M("intention")->alias("i")
        ->field(" u.id as uid ,u.name as uname , u.phone as uphone ,ch.name as chname ")
        ->join(" left join ".C("DB_PREFIX")."user u on u.id = i.user_id left join ".C("DB_PREFIX")."child ch on ch.id=i.child_id ")
        ->where(" i.course_id = ".$course_id)->select();
        echo json_encode($info);
    }
//查询已报名人员
    public function sign_up_num_info(){
        $course_id=$_POST['id'];
        $info=M("enrollment")->alias("i")
        ->field(" u.id as uid ,u.name as uname , u.phone as uphone ,ch.name as chname ")
        ->join(" left join ".C("DB_PREFIX")."user u on u.id = i.user_id left join ".C("DB_PREFIX")."child ch on ch.id=i.child_id ")
        ->where(" i.course_id = ".$course_id." and ( i.state = 1 or i.state = 3 )")->select();
        
        echo json_encode($info);
    }

    public function questiontypelistorders(){
        $listorders=$_POST['listorders'];
        //遍历取值
        if($listorders){
            foreach ($listorders as $k => $v) {
                //$k为需要修改的id，$v为修改的值
                if($k&&($v||$v=='0')){
                    //存在才修改
                    $data="";//初始化
                    $data['id']=$k;
                    $data['index_id']=$v;
                    M("question_type")->save($data);
                }
            }
        }
        $this->success("排序成功");
    }

    public function Questiondifflistorders(){
        $listorders=$_POST['listorders'];
        //遍历取值
        if($listorders){
            foreach ($listorders as $k => $v) {
                //$k为需要修改的id，$v为修改的值
                if($k&&($v||$v=='0')){
                    //存在才修改
                    $data="";//初始化
                    $data['id']=$k;
                    $data['index_id']=$v;
                    M("question_difficulty")->save($data);
                }
            }
        }
        $this->success("排序成功");
    }

    public function topicsetlistorders(){
        $listorders=$_POST['listorders'];
        //遍历取值
        if($listorders){
            foreach ($listorders as $k => $v) {
                //$k为需要修改的id，$v为修改的值
                if($k&&($v||$v=='0')){
                    //存在才修改
                    $data="";//初始化
                    $data['id']=$k;
                    $data['index_id']=$v;
                    M("topic_set")->save($data);
                }
            }
        }
        $this->success("排序成功");
    }
}
