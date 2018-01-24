<?php

namespace Other\Controller;
use Common\Controller\AdminbaseController;
class ServerController extends AdminbaseController {
	function _initialize() {
	}
    /**
     *服务列表
     */
    public function index() {
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
        $model = M ("service");
        $count = $model->where($where)->count();
        $page = $this->page($count, C('PAGENUM'));
        $list = $model->order("id DESC")->limit($page->firstRow . ',' . $page->listRows)->where($where)->select();
        $this->assign('list', $list);
        $this->assign("page", $page->show('Admin'));
        $this->assign("formget",$_SESSION); 
       	$this->display();
    }
    //添加
     public function add(){
         if($_GET[id]){
             $i=M('service')->where("id = $_GET[id]")->find();
             //h5
             if($i['h5_id']){
             	$h5 = M("h5")->where("id = $i[h5_id]")->find();
             }
             $this->assign('i',$i);
         }
         $this->assign('h5',$h5);
         $this->display();
     }
     public function add_post(){
         $editid=$_REQUEST['editid'];
         $picture=$_REQUEST['picture'];
         $title=$_REQUEST['title'];
         $content=$_REQUEST['content'];
         $h5_textareas = $_REQUEST['textareas']?$_REQUEST['textareas']:"";
         $h5_id = $_REQUEST['h5_id'];
         $url = $_REQUEST['url'];
         if(empty($title)){
            $this->error("请填写标题");
         }
         if(empty($picture)){
             $this->error("请选择图片");
         }
         if(empty($content)){
             $this->error("请填写描述");
         }
         if(empty($h5_textareas) && empty($url)){
             $this->error("请填写h5详情或网址");
         }
         if(empty($editid)){
         	//添加h5
         	$data_h5 = array(
         		"title"=>"",
	         	"content"=>$h5_textareas,
	         	"url"=>$url,
	         	"createtime"=>date("Y-m-d H:i:s"),
         	);
         	$h5_id = M("h5")->add($data_h5);
             $data=array('icon'=>$picture,'title'=>$title,'content'=>$content,'h5_id'=>$h5_id,'createtime'=>date('Y-m-d H:i:s',time()));
             if(M('service')->add($data)){
                 $this->success('添加成功',U('server/index'));
             }else{
                 $this->error("添加失败");
             }
         }else{
         	//修改h5
         	$data_h5 = array(
	         	"content"=>$h5_textareas,
	         	"url"=>$url,
         	);
             $data=array('icon'=>$picture,'title'=>$title,'content'=>$content,'h5_id'=>$h5_id);
             if(M('service')->where("id = $editid")->save($data) || M("h5")->where("id = $h5_id")->save($data_h5)){
                 $this->success('修改成功',U('server/index'));
             }else{
                 $this->error("修改失败");
             }
         }
     }

     public function delete(){
        $id = I("get.id",0,"intval");
        if (M('service')->delete($id)!==false) {
            $this->success("删除成功！");
        } else {
            $this->error("删除失败！");
        }
     }
} 
