<?php

namespace Classtypes\Controller;
use Common\Controller\AdminbaseController;
class PressController extends AdminbaseController {
	function _initialize() {
	}
     public function presslist(){
         $where= "1=1";
         $title=$_REQUEST['title'];
         if(!empty($title)){
            $where.=" and title like '%".$title."%' ";
            $parameter['title']=$title;
            $this->assign('title',$title);
         }
         $model = M ("press");
         $count = $model->where($where)->count();
         $page = $this->page($count, C('PAGENUM'));
         $list = $model->where($where)->order("index_id ASC")->limit($page->firstRow . ',' . $page->listRows)->select();
         $this->assign('list', $list);
         if($parameter){
            foreach ($parameter as $key => $value) {
                $page->parameter .= "$key=".urlencode($value)."&";
            }
         } 
         $this->assign("page", $page->show('Admin'));
         $this->display();
     }
     public function addpress(){
        $this->display();
     }
     public function add_post(){
        if(empty($_POST['title'])){
            $this->error("出版社名称不能为空");
        }
        if(empty($_POST['index_id'])&&$_POST['index_id']!='0'){
            $_POST['index_id']='99';
        }
        $is_exist=M('press')->where("title = '".$_POST[title]."'")->find();
        if(empty($is_exist)){
            if(IS_POST){
                
                $_POST['createtime']=date("Y-m-d H:i:s");
                if (M("press")->create()!==false){
                    if (M("press")->add()!==false) {
                        $this->success(L('ADD_SUCCESS'), U("Press/presslist"));
                    } else {
                        $this->error(L('ADD_FAILED'));
                    }
                } else {
                    $this->error(M("press")->getError());
                }
        
            }
        }else{
                $this->error("出版社已存在");
            }
        
     }
     public function editpress(){
        $res=M("press")->where("id = $_REQUEST[editid]")->find();
        $this->assign($res);
        $this->display();
     }
     public function edit_post(){
        if(empty($_POST['title'])){
            $this->error("出版社名称不能为空");
        }
        if(empty($_POST['index_id'])&&$_POST['index_id']!='0'){
            $_POST['index_id']='99';
        }
        $is_exist=M('press')->where("title = '".$_POST[title]."' and id != '".$_POST[id]."' ")->find();
        if(empty($is_exist)){
            if(IS_POST){

                if (M("press")->create()!==false){
                    if (M("press")->save()!==false) {
                        $this->success(L('ADD_SUCCESS'), U("Press/presslist"));
                    } else {
                        $this->error(L('ADD_FAILED'));
                    }
                } else {
                    $this->error(M("press")->getError());
                }
            }
        }else{
            $this->error("出版社已存在");
        }
     }
     public function deletepress(){
        $id = I("get.id",0,"intval");
        if (M('press')->delete($id)!==false) {
            $this->success("删除成功！");
        } else {
            $this->error("删除失败！");
        }
    }

    public function listorders(){
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
                    M("press")->save($data);
                }
            }
        }
        $this->success("排序成功");
    }
}
