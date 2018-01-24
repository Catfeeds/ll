<?php
namespace Users\Controller;
use Common\Controller\AdminbaseController;

class SignrecordController  extends AdminbaseController {
    /**
     * 签到记录列表
     */
    public function index(){
        $where="1=1";
    $count=M('check_in')->table(C('DB_PREFIX')."check_in as c")
            ->join(C('DB_PREFIX')."user as u on u.id = c.user_id",'left')->count();
    $page = $this->page($count, 20);
        $check_in = M('check_in')
            ->field("c.id,c.createtime,c.Integral as cintegral,u.phone")
            ->table(C('DB_PREFIX')."check_in as c")
            ->join(C('DB_PREFIX')."user as u on u.id = c.user_id",'left')
            ->where($where)
            ->order(" c.createtime DESC ")
            ->limit($page->firstRow, $page->listRows)
            ->select();
            //var_dump($check_in);die;
    $this->assign("page", $page->show('Admin'));
    $this->assign("check_in",$check_in);
    $this->display();
  }
}