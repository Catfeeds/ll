<?php

/* * 
 * 菜单
 */
namespace Common\Model;
use Common\Model\CommonModel;
class MenuModel extends CommonModel {

    //自动验证
    protected $_validate = array(
        //array(验证字段,验证规则,错误提示,验证条件,附加规则,验证时间)
        array('name', 'require', '菜单名称不能为空！', 1, 'regex', CommonModel:: MODEL_BOTH ),
        array('app', 'require', '应用不能为空！', 1, 'regex', CommonModel:: MODEL_BOTH ),
        array('model', 'require', '模块名称不能为空！', 1, 'regex', CommonModel:: MODEL_BOTH ),
        array('action', 'require', '方法名称不能为空！', 1, 'regex', CommonModel:: MODEL_BOTH ),
        array('app,model,action', 'checkAction', '同样的记录已经存在！', 1, 'callback', CommonModel:: MODEL_INSERT   ),
    	array('id,app,model,action', 'checkActionUpdate', '同样的记录已经存在！', 1, 'callback', CommonModel:: MODEL_UPDATE   ),
        array('parentid', 'checkParentid', '菜单只支持四级！', 1, 'callback', 1),
    );
    //自动完成
    protected $_auto = array(
            //array(填充字段,填充内容,填充条件,附加规则)
    );

    //验证菜单是否超出三级
    public function checkParentid($parentid) {
        $find = $this->where(array("id" => $parentid))->getField("parentid");
        if ($find) {
            $find2 = $this->where(array("id" => $find))->getField("parentid");
            if ($find2) {
                $find3 = $this->where(array("id" => $find2))->getField("parentid");
                if ($find3) {
                    return false;
                }
            }
        }
        return true;
    }

    //验证action是否重复添加
    public function checkAction($data) {
        //检查是否重复添加
        $find = $this->where($data)->find();
        if ($find) {
            return false;
        }
        return true;
    }
    //验证action是否重复添加
    public function checkActionUpdate($data) {
    	//检查是否重复添加
    	$id=$data['id'];
    	unset($data['id']);
    	$find = $this->field('id')->where($data)->find();
    	if (isset($find['id']) && $find['id']!=$id) {
    		return false;
    	}
    	return true;
    }
    

    /**
     * 按父ID查找菜单子项
     * @param integer $parentid   父菜单ID  
     * @param integer $with_self  是否包括他自己
     */
    public function admin_menu($parentid, $with_self = false) {
        //父节点ID
        $parentid = (int) $parentid;
        $result = $this->where(array('parentid' => $parentid, 'status' => 1))->order(array("listorder" => "ASC"))->select();
        if ($with_self) {
            $result2[] = $this->where(array('id' => $parentid))->find();
            $result = array_merge($result2, $result);
        }
        //权限检查
        if (sp_get_current_admin_id() == 1) {
            //如果是超级管理员 直接通过
            return $result;
        } 
        
         $array = array();
        foreach ($result as $v) {
        	
            //方法
            $action = $v['action'];
            
            //public开头的通过
            if (preg_match('/^public_/', $action)) {
                $array[] = $v;
            } else {
            	
                if (preg_match('/^ajax_([a-z]+)_/', $action, $_match)){
                	
                	$action = $_match[1];
                }
                   
                $rule_name=strtolower($v['app']."/".$v['model']."/".$action);
                
                if ( sp_auth_check(sp_get_current_admin_id(),$rule_name)){
                	$array[] = $v;
                }
                   
            }
        } 
        
        return $array;
    }

    /**
     * 获取菜单 头部菜单导航
     * @param $parentid 菜单id
     */
    public function submenu($parentid = '', $big_menu = false) {
        $array = $this->admin_menu($parentid, 1);
        $numbers = count($array);
        if ($numbers == 1 && !$big_menu) {
            return '';
        }
        return $array;
    }

    /**
     * 菜单树状结构集合
     */
    public function menu_json() {
        $data = $this->get_tree(0);
        return $data;
    }

    //取得树形结构的菜单
    public function get_tree($myid, $parent = "", $Level = 1) {
        $data = $this->admin_menu($myid);
        $Level++;
        if (is_array($data)) {
            $ret = NULL;
            foreach ($data as $a) {
                $id = $a['id'];
                $name = ucwords($a['app']);
                $model = ucwords($a['model']);
                $action = $a['action'];
                //附带参数
              	$fu = "";
                if ($a['data']) {
                    $fu = "?" . htmlspecialchars_decode($a['data']);
                }
                $array = array(
                    "icon" => $a['icon'],
                    "id" => $id . $name,
                    "parent" => $parent,
                    "url" => U("{$name}/{$model}/{$action}{$fu}", array("menuid" => $id)),
                    'lang'=> strtoupper($name.'_'.$model.'_'.$action),
                        );
                if($a[parentid] == 0){
                    if($this->updateOpinion()!=""){
                        $array["name"] = $a['name'].'<strong style=color:red;>●</strong>';
                    }else if($this->updateSign()!=""){
                        $array["name"] = $a['name'].'<strong style=color:red;>●</strong>';
                    }else if($this->updateIntention()!=""){
                        $array["name"] = $a['name'].'<strong style=color:red;>●</strong>';
                    }else if($this->updateChildren()!=""){
                        $array["name"] = $a['name'].'<strong style=color:red;>●</strong>';
                    }else{
                        $array["name"] = $a['name'];
                    }
                    
                }else{
                    $array["name"] = $a['name'];
                }
                $ret[$id . $name] = $array;
                $child = $this->get_tree($a['id'], $id, $Level);
                //由于后台管理界面只支持三层，超出的不层级的不显示
                if ($child && $Level <= 3) {
                    $ret[$id . $name]['items'] = $child;
                }
               
            }
            return $ret;
        }
       
        return false;
    }

    /**
     * 更新缓存
     * @param type $data
     * @return type
     */
    public function menu_cache($data = null) {
        if (empty($data)) {
            $data = $this->select();
            F("Menu", $data);
        } else {
            F("Menu", $data);
        }
        return $data;
    }

    /**
     * 后台有更新/编辑则删除缓存
     * @param type $data
     */
    public function _before_write(&$data) {
        parent::_before_write($data);
        F("Menu", NULL);
    }

    //删除操作时删除缓存
    public function _after_delete($data, $options) {
        parent::_after_delete($data, $options);
        $this->_before_write($data);
    }
    
    public function menu($parentid, $with_self = false){
    	//父节点ID
    	$parentid = (int) $parentid;
    	$result = $this->where(array('parentid' => $parentid))->select();
    	if ($with_self) {
    		$result2[] = $this->where(array('id' => $parentid))->find();
    		$result = array_merge($result2, $result);
    	}
    	return $result;
    }
    /**
     * 得到某父级菜单所有子菜单，包括自己
     * @param number $parentid 
     */
    public function get_menu_tree($parentid=0){
    	$menus=$this->where(array("parentid"=>$parentid))->order(array("listorder"=>"ASC"))->select();
    	
    	if($menus){
    		foreach ($menus as $key=>$menu){
    			$children=$this->get_menu_tree($menu['id']);
    			if(!empty($children)){
    				$menus[$key]['children']=$children;
    			}
    			unset($menus[$key]['id']);
    			unset($menus[$key]['parentid']);
    		}
    		return $menus;
    	}else{
    		return $menus;
    	}
    	
    }
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
        return $_SESSION['f_res'];
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
        return $_SESSION['e_res'];
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
        return $_SESSION['i_res'];
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
        return $_SESSION['c_res'];
    }
}