<?php

use Think\Log;
//获取用户id
function get_user_id($open_id){
	$users = M("user")->where("openid='$open_id'")->find();
	$user_id = $users['id'];
	return $user_id;
}