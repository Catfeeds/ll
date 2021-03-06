<?php

namespace Other\Controller;
use Common\Controller\AdminbaseController;
class AppversionController extends AdminbaseController {
	function _initialize() {
	}
    /**
     *app版本
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
        $model = M ("app_version");
        $count = $model->where($where)->count();
        $page = $this->page($count, C('PAGENUM'));
        $list = $model->order("createtime DESC")->limit($page->firstRow . ',' . $page->listRows)->where($where)->select();
        $this->assign('list', $list);
        $this->assign("page", $page->show('Admin'));
        $this->assign("formget",$_SESSION); 
       	$this->display();
    }
    public function add(){
        $this->display();
    }
    public function add_post(){
        $version=$_POST['version'];
        $url=$_POST['url'];
        $content=$_POST['content'];
        $force=$_POST['force'];
        if(empty($version)){
            $this->error("请填写版本");
        }
        if(empty($url)){
            $this->error("请填写更新地址");
        }
        if(empty($content)){
            $this->error("请填写更新内容");
        }
        $data=array('version'=>$version,'url'=>$url,'content'=>$content,'force'=>$force,'createtime'=>date('Y-m-d H:m:s',time()));
        if(M('app_version')->add($data)){
            $this->success("操作成功",U('Appversion/index'));
        }else{
            $this->error("操作失败");
        }
    }
    public function edit(){
        $info=M("app_version")->where(" id = '".$_REQUEST['editid']."' ")->find();
        $this->assign($info);
        $this->display();
    }
    public function edit_post(){
        $version=$_POST['version'];
        $url=$_POST['url'];
        $content=$_POST['content'];
        $force=$_POST['force'];
        $id=$_POST['id'];
        if(empty($id)){
            $this->error("系统异常，请刷新重试");
        }
        if(empty($version)){
            $this->error("请填写版本");
        }
        if(empty($url)){
            $this->error("请填写更新地址");
        }
        if(empty($content)){
            $this->error("请填写更新内容");
        }
        $data=array('version'=>$version,'url'=>$url,'content'=>$content,'force'=>$force,'createtime'=>date('Y-m-d H:m:s',time()));
        $data['id']=$id;
        if(M('app_version')->save($data)){
            $this->success("操作成功",U('Appversion/index'));
        }else{
            $this->error("操作失败");
        }
    }
    public function delete(){
        if(M('app_version')->delete($_GET[id])){
            $this->success("删除成功");
        }else{
            $this->error("删除失败");
        }
    }
}
