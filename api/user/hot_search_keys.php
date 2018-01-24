<?php

/**
 * ECSHOP 取得热门关键字接口 由上海睿风（Refineit）添加
 * ============================================================================
 * * 版权所有 2005-2012 上海商派网络科技有限公司，并保留所有权利。
 * 网站地址: http://www.ecshop.com；
 * ----------------------------------------------------------------------------
 * 这不是一个自由软件！您只能在不用于商业目的的前提下对程序代码进行修改和
 * 使用；不允许对程序代码以任何形式任何目的的再发布。
 * ============================================================================
 * $Author: liubo $
 * $Id: goods.php 17217 2011-01-19 06:29:08Z liubo $
 */


define('IN_ECS', true);

require('../init.php');
require('../token.php');
require_once(ROOT_PATH . 'includes/cls_json.php');
require_once(ROOT_PATH . 'config/config.php');

   $json = new JSON;

    if (!empty($GLOBALS['_CFG']['search_keywords']))
    {
        $searchkeywords = explode(',', trim($GLOBALS['_CFG']['search_keywords']));
    }
    else
    {
        $searchkeywords = array();
    }
   
 	$keys = array();
   	foreach ($searchkeywords AS $index=>$keyword) {
   		$keys[$index] = $keyword;
   		$index++;
   	}
  
	$result = array("code"=>"101", "msg"=>"成功", "keys"=>$keys);
    exit($json->encode($result));
?>