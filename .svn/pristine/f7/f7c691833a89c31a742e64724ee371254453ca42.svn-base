<?php
namespace Users\Controller;
use Common\Controller\AdminbaseController;

class ScorecordController  extends AdminbaseController {
    /**
     * 积分记录列表
     */
    public function index(){
        $uname=$_REQUEST['uname1'];
        $phone=$_REQUEST['phone'];
        $is_obtain=$_REQUEST['is_obtain'];
        $integral=$_REQUEST['integral'];
        $uscore=$_REQUEST['uscore'];
        $obtain_type=$_REQUEST['obtain_type'];
        $startcreatetime=$_REQUEST['startcreatetime'];
        $endcreatetime=$_REQUEST['endcreatetime'];
      //var_dump($phone);
      $where="1=1";
      if(!empty($uname)){
        $where.=" and u.name like '%".$uname."%' ";
        $parameter['uname1']=$uname;
        $this->assign("uname",$uname);
      }
      if(!empty($phone)){
        $where.=" and u.phone like '%".$phone."%' ";
        $parameter['phone']=$phone;
        $this->assign("phone",$phone);
        //var_dump($where);
      }
      if(!empty($is_obtain)){
        if($is_obtain=='2'){
          $is_obtain1='0';
        }else{
          $is_obtain1=$is_obtain;
        }
        $where.=" and i.is_obtain =  ".$is_obtain1;
        $parameter['is_obtain']=$is_obtain;
        $this->assign("is_obtain",$is_obtain);
      }
      if(!empty($integral)){
        $where.=" and i.integral = ".$integral;
        $parameter['integral']=$integral;
        $this->assign("integral",$integral);
      }
      if(!empty($uscore)){
        $where.=" and u.integral = ".$uscore;
        $parameter['uscore']=$uscore;
        $this->assign("uscore",$uscore);
      }
      if(!empty($obtain_type)){
        if($obtain_type=='99'){
          $obtain_type1='0';
        }else{
          $obtain_type1=$obtain_type;
        }
        $where.=" and i.obtain_type = ".$obtain_type1;
        $parameter['obtain_type']=$obtain_type;
        $this->assign("obtain_type",$obtain_type);
      }
      if(!empty($startcreatetime)){
        $where.=" and i.createtime >='".$startcreatetime."'";
        $parameter['startcreatetime']=$startcreatetime;
        $this->assign("startcreatetime",$startcreatetime);
      }
      if(!empty($endcreatetime)){
        $where.=" and i.createtime <= '".$endcreatetime."'";
        $parameter['endcreatetime']=$endcreatetime;
        $this->assign("endcreatetime",$endcreatetime);
      }
      //var_dump($where);die;
      $count=M("integral")->alias('i')->join(' left join '.C('DB_PREFIX').'user as u on i.user_id=u.id ')
            ->where($where)
            ->count();
      $page = $this->page($count, 20);
      $scorecord = M("integral")->alias('i')
          ->field("i.*,u.phone,u.id as uid ,u.name as uname,u.recommended_person,u.integral as uscore")
          ->join(' left join '.C('DB_PREFIX').'user as u on i.user_id=u.id ')
          ->where($where)
          ->order("id desc")
          ->limit($page->firstRow, $page->listRows)
          ->select();
      if($parameter){
        foreach ($parameter as $key => $value) {
          $page->parameter .= "$key=".urlencode($value)."&";
        }
      }   
    $this->assign("page", $page->show('Admin'));
    $this->assign("scorecord",$scorecord);
    $this->display();



  }

}