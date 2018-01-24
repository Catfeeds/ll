<?php
// +----------------------------------------------------------------------
// | ThinkCMF [ WE CAN DO IT MORE SIMPLE ]
// +----------------------------------------------------------------------
// | Copyright (c) 2013-2014 http://www.thinkcmf.com All rights reserved.
// +----------------------------------------------------------------------
// | Author: Tuolaji <479923197@qq.com>
// +----------------------------------------------------------------------
/**
 */
namespace Admin\Controller;
use Common\Controller\AdminbaseController;
class PublicController extends AdminbaseController {

    function _initialize() {
        C(S('sp_dynamic_config'));//加载动态配置
    }
    
    //后台登陆界面
    public function login() {
    	if(isset($_SESSION['ADMIN_ID']) && isset($_SESSION['PROJECTNAME']) && $_SESSION['PROJECTNAME'] = PROJECTNAME){//已经登录
    		$this->success(L('LOGIN_SUCCESS'),U("Index/index"));
    	}else{
    	    $site_admin_url_password =C("SP_SITE_ADMIN_URL_PASSWORD");
    	    $upw=session("__SP_UPW__");
    		if(!empty($site_admin_url_password) && $upw!=$site_admin_url_password){
    			redirect(__ROOT__."/");
    		}else{
    		    session("__SP_ADMIN_LOGIN_PAGE_SHOWED_SUCCESS__",true);
    			$this->display(":login");
    		}
    	}
    }
    
    public function logout(){
    	session('ADMIN_ID',null); 
    	redirect(U("public/login"));
    }
    
    public function dologin(){
        $login_page_showed_success=session("__SP_ADMIN_LOGIN_PAGE_SHOWED_SUCCESS__");
        if(!$login_page_showed_success){
            $this->error('login error!');
        }
    	$name = I("post.username");
    	if(empty($name)){
    		$this->error(L('USERNAME_OR_EMAIL_EMPTY'));
    	}
    	$pass = I("post.password");
    	if(empty($pass)){
    		$this->error(L('PASSWORD_REQUIRED'));
    	}
    	$verrify = I("post.verify");
    	if(empty($verrify)){
    		$this->error(L('CAPTCHA_REQUIRED'));
    	}
    	//验证码
    	if(!sp_check_verify_code()){
    		$this->error(L('CAPTCHA_NOT_RIGHT'));
    	}else{
    		$user = D("Common/Users");
    		if(strpos($name,"@")>0){//邮箱登陆
    			$where['user_email']=$name;
    		}else{
    			$where['user_login']=$name;
    		}
    		
    		$result = $user->where($where)->find();
    		if(!empty($result) && $result['user_type']==1){
    			if(sp_compare_password($pass,$result['user_pass'])){
    				
    				$role_user_model=M("RoleUser");
    				
    				$role_user_join = C('DB_PREFIX').'role as b on a.role_id =b.id';
    				
    				$groups=$role_user_model->alias("a")->join($role_user_join)->where(array("user_id"=>$result["id"],"status"=>1))->getField("role_id",true);
    				
    				if( $result["id"]!=1 && ( empty($groups) || empty($result['user_status']) ) ){
    					$this->error(L('USE_DISABLED'));
    				}
    				//登入成功页面跳转
    				$_SESSION["ADMIN_ID"]=$result["id"];
    				$_SESSION['name']=$result["user_login"];
    				$result['last_login_ip']=get_client_ip(0,true);
    				$result['last_login_time']=date("Y-m-d H:i:s");
    				$user->save($result);
    				setcookie("admin_username",$name,time()+30*24*3600,"/");
    				$this->success(L('LOGIN_SUCCESS'),U("Index/index"));
    			}else{
    				$this->error(L('PASSWORD_NOT_RIGHT'));
    			}
    		}else{
    			$this->error(L('USERNAME_NOT_EXIST'));
    		}
    	}
    }

    // public function ceshi(){
    //     $count=M('user')->count();
    //     //$guoqu=$_SESSION['xiaoxi'];
    //     if(empty($_SESSION['xiaoxi'])){
    //         $_SESSION['xiaoxi']=$count;
    //     }elseif($_SESSION['xiaoxi']<$count){
            
    //         $res=intval($count-$_SESSION['xiaoxi']);
    //         $res=$res+$_SESSION['res'];
    //         $_SESSION['xiaoxi']=$count;
    //         $_SESSION['res']=$res;
    //         echo  $res;
    //     }


        
    //  }
    //意见反馈
    public function updateOpinion(){
        $count=M("feedback")->count();
        if(empty($_SESSION['num_feedback'])){
            $_SESSION['num_feedback']=$count;
        }elseif($_SESSION['num_feedback']<$count){
            $res=intval($count-$_SESSION['num_feedback']);
            $res=$res+$_SESSION['f_res'];
            $_SESSION['num_feedback']=$count;
            $_SESSION['f_res']=$res;
        }
        echo $_SESSION['f_res'];
    }

    //报名管理
    public function updateSign(){
        //所有
        $count=M("enrollment")->count();
        if(empty($_SESSION['num_enrollment'])){
            $_SESSION['num_enrollment']=$count;
        }elseif($_SESSION['num_enrollment']<$count){
            $res=intval($count-$_SESSION['num_enrollment']);
            $res=$res+$_SESSION['e_res'];
            $_SESSION['num_enrollment']=$count;
            $_SESSION['e_res']=$res;
        }
        echo $_SESSION['e_res'];
    }

   //意向管理
    public function updateIntention(){
        $count=M("intention")->count();
        if(empty($_SESSION['num_intention'])){
            $_SESSION['num_intention']=$count;
        }elseif($_SESSION['num_intention']<$count){
            $res=intval($count-$_SESSION['num_intention']);
            $res=$res+$_SESSION['i_res'];
            $_SESSION['num_intention']=$count;
            $_SESSION['i_res']=$res;
        }
        echo $_SESSION['i_res'];
    }

    //小孩管理
    public function updateChildren(){
        $count=M("child")->count();
        if(empty($_SESSION['num_child'])){
            $_SESSION['num_child']=$count;
        }elseif($_SESSION['num_child']<$count){
            $res=intval($count-$_SESSION['num_child']);
            $res=$res+$_SESSION['c_res'];
            $_SESSION['num_child']=$count;
            $_SESSION['c_res']=$res;
        }
        echo $_SESSION['c_res'];
    }


}