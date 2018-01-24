<?php

namespace Other\Controller;
use Common\Controller\AdminbaseController;
class H5Controller extends AdminbaseController {
	function _initialize() {
	}
    /**
     *讲师列表
     */
    public function h5list() {
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
        $model = M ("H5");
        $count = $model->where($where)->count();
        $page = $this->page($count, C('PAGENUM'));
        $list = $model->order("id DESC")->limit($page->firstRow . ',' . $page->listRows)->where($where)->select();
        $this->assign('list', $list);
        $this->assign("page", $page->show('Admin'));
        $this->assign("formget",$_SESSION); 
       	$this->display();
    }
    //添加课程
     public function addh5(){
         $this->display();
     }
     //添加操作
     public function add_post(){
         $title=$_REQUEST['title'];
         $content=$_REQUEST['textareas'];
         $url=$_REQUEST['url'];
         if(empty($title)){
             $this->error("请填写标题");
         }
         if(empty($content)){
             $this->error("请填写内容");
         }
         if(empty($url)){
             $this->error("请填写地址");
         }
          
         $where[title]=array('eq'=>$url);
         if(M('H5')->where($where)->find()){
             $this->error("此标题内容已添加过");
         }
         $data=array('title'=>$title,'content'=>$content,'url'=>$url,'updatetime'=>date('Y-m-d H:i:s',time()),'createtime'=>date('Y-m-d H:i:s',time()));
         if(M('H5')->add($data)){
             $this->success("添加H5成功");
         }else{
             $this->error("添加H5失败");
         }
     }
     //编辑
     public function edith5(){
         $res=M("H5")->where("id = $_REQUEST[editid]")->find();
         $this->assign('list',$res);
         $this->display();
     }
     public function edit_post(){
         $editid=$_REQUEST['editid'];
          $title=$_REQUEST['title'];
         $content=$_REQUEST['textareas'];
         $url=$_REQUEST['url'];
         if(empty($title)){
             $this->error("请填写标题");
         }
         if(empty($content)){
             $this->error("请填写内容");
         }
         if(empty($url)){
             $this->error("请填写地址");
         }
         $data=array('title'=>$title,'content'=>$content,'url'=>$url,'updatetime'=>date('Y-m-d H:i:s',time()));
         if(M('h5')->where("id = $editid")->save($data)){
             $this->success('修改H5成功');
         }else{
             $this->error('修改H5失败');
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
     function deleteicon()
     {
         if(!empty($_POST['img2']))
         {
             unlink("./data/upload/avatar/$_POST[img2]");
         }
     }
}
