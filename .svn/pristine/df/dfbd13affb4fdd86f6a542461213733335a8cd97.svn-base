<?php

namespace Classification\Controller;
use Common\Controller\AdminbaseController;
class GradeController extends AdminbaseController {
	function _initialize() {
	}
     public function gradelist(){
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
         $model = M ("Grades");
         $count = $model->where($where)->count();
         $page = $this->page($count, 10);
         $list = $model->order("id DESC")->limit($page->firstRow . ',' . $page->listRows)->where($where)->select();
         $this->assign('list', $list);
         $this->assign("page", $page->show('Admin'));
         $this->assign("formget",$_SESSION);
         $this->display();
     }
     function addgrade(){
         $this->display();
     }
     function add_post(){
         $gradename=$_REQUEST['gradename'];
         $desc=$_REQUEST['desc'];
         if(empty($gradename)){
             $this->error("请填写年级名称");
         }
         if(M("Grades")->where("gradename = '$gradename'")->find()){
             $this->error("此年级名称已存在");
         }
         $data=array('gradename'=>$gradename,'dsc'=>$desc,'ctime'=>date("Y-m-d H:i:s",time()));
         if(M("Grades")->add($data)){
             $this->success("添加成功",U('grade/gradelist'));
         }else{
             $this->error("添加失败");
         }
     }
     public function delete(){
         M('Grades')->delete($_REQUEST[id]);
         $this->success("删除成功");
     }
}
