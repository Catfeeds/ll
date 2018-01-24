<?php
namespace Lailonginterface\Controller;
use Lailonginterface\Controller\PublicController;

class ServerController  extends PublicController {
    /**
     * 获取服务
     */
    public function getserver()
    {
       $token=$_REQUEST['token'];
       $userid=$this->checkAccess($token);
       //当前条数
       $pagesize=$_REQUEST['pagesize'];
       //当前页数
       $pagec=$_REQUEST['pagec'];
       $start=($pagec-1)*$pagesize;
       $server=M('Service')->limit($start.','.$pagec)->limit($start.','.$pagesize)->order("createtime desc")->select();
       foreach($server as $r=>$rs){
           $server[$r][icon] = __ROOT__.'/data/upload/avatar/'.$rs[icon];
       }
       if($server){
           $this->successLongResult($server, "获取服务列表成功");
       }else{
           $this->errorResult("未获取到服务列表");
       }
    }
    /**
     * 获取服务详情
     */
    public function getserverdetail()
    {
        $token=$_REQUEST['token'];
        $serverid=$_REQUEST['severid'];
        $userid=$this->checkAccess($token);
        $server=M('Service')->where("id = '$serverid'")->find();
        /* $server[icon] = __ROOT__.'/data/upload/avatar/'.$server[icon]; */
        $array=array();
        if($server[h5_id]){
            $h5=M('H5')->where("id = '$server[h5_id]'")->find();
            $array[url]=$h5[url];
            $array[content]=$h5[content];
        }
        if($array){
            $this->successLongResult($array, "获取服务详情成功");
        }else{
            $this->errorResult("未获取到服务详情");
        }
    }
    /**
     * 获取资讯
     */
    public function getinformation()
    {
        $token=$_REQUEST['token'];
        $userid=$this->checkAccess($token);
        //当前条数
        $pagesize=$_REQUEST['pagesize'];
        //当前页数
        $pagec=$_REQUEST['pagec'];
        $start=($pagec-1)*$pagesize;
        $information=M('information')->limit($start.','.$pagesize)->order("createtime desc")->select();
        foreach($information as $r=>$rs){
            $information[$r][icon] = __ROOT__.'/data/upload/avatar/'.$rs[icon];
        }
        if($information){
            $this->successLongResult($information,"获取资讯列表成功");
        }else{
            $this->errorResult("获取资讯列表失败");
        }
    }
    /**
     * 获取资讯详情
     */
    public function getinformationdetail()
    {
        $token=$_REQUEST['token'];
        $informationid=$_REQUEST['informationid'];
        $userid=$this->checkAccess($token);
        $information=M('information')->where("id = '$informationid'")->find();
        //$information[icon] = __ROOT__.'/data/upload/avatar/'.$server[icon];
        $array=array();
        if($information[h5_id]){
            $h5=M('H5')->where("id = '$information[h5_id]'")->find();
            $array[url]=$h5[url];
            $array[content]=$h5[content];
        }
        /* if($information[h5_id]){
            $h5=M('H5')->where("id = $information[h5_id]")->find();
            $information[h5]=$h5;
        } */
        if($array){
            $this->successLongResult($array, "获取资讯详情成功");
        }else{
            $this->errorResult("未获取到资讯详情");
        }
    }
}