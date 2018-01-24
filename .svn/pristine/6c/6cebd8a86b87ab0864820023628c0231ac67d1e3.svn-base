<?php

namespace Other\Controller;
use Common\Controller\AdminbaseController;
class ScorechargeController extends AdminbaseController {
	function _initialize() {
	}
    /**
     * 积分充值列表
     */
    public function scorechargelist() {
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
        $model = M ("integral_order_config");
        $count = $model->where($where)->count();
        $page = $this->page($count, C('PAGENUM'));
        $list = $model->order("index_id ASC")->limit($page->firstRow . ',' . $page->listRows)->where($where)->select();
        $this->assign('list', $list);
        $this->assign("page", $page->show('Admin'));
        $this->assign("formget",$_SESSION); 
       	$this->display();
    }
    //添加积分充值
     public function addscore(){
         $this->display();
     }
     public function add_post(){
         $score=$_POST['score'];
         $price=$_POST['price'];
         $title=$_POST['title'];
         if(empty($title)){
             $this->error("请填写标题");
         }
         if($score % 10 != 0){
             $this->error("积分应为10的倍数");
         }
         if($score<=0 || $price<=0){
             $this->error("积分数量或支付金额应大于0");
         }
         if(empty($_POST['index_id'])&&$_POST['index_id']!='0'){
            $_POST['index_id']='99';
         }
         $data=array('title'=>$title,'amount'=>$price,'integral'=>$score,'createtime'=>date('Y-m-d H:i:s',time()),'index_id'=>$_POST['index_id']);
         if(M('integral_order_config')->add($data)){
             $this->success('添加成功',U('scorecharge/scorechargelist'));
         }else{
             $this->error("添加失败");
         }
     }
    public function delete(){
        if(M('integral_order_config')->where("id = $_REQUEST[id]")->delete()){
            $this->success("删除成功");
        }else{
            $this->error("删除失败");
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
                    M("integral_order_config")->save($data);
                }
            }
        }
        $this->success("排序成功");
    }
}
