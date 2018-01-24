<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html class="no-js">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="viewport"
          content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>我的意向</title>
    <link rel="stylesheet" href="/ll/themes/lailong/Public/font-awesome-4.7.0/css/font-awesome.css">
    <link rel="stylesheet" href="/ll/themes/lailong/Public/css/weixin/amazeui.min.css">
    <link rel="stylesheet" href="/ll/themes/lailong/Public/css/weixin/integration.css">
	<link rel="stylesheet" href="/ll/themes/lailong/Public/css/weixin/public.css">
	<script src="/ll/themes/lailong/Public/js/weixin/jquery.min.js"></script>	
</head>
<body style="background: #f4f5f7;padding: 0px 10px;">
<?php if(!empty($mes)): if(is_array($mes)): foreach($mes as $key=>$vo): ?><div class="am-container" style=" background: white;color: #34394e;font-weight: 500;margin-top:10px;">
    <p style="margin-top: 5px;margin-bottom: -18px;font-size:  1.6rem; line-height: 30px"><?php echo date('Y-m-d',strtotime($vo[createtime])) ?></p>
    <?php if(!empty($vo['subject'])): ?><p style="font-size:  1.6rem;margin-bottom: -20px;"><?php if($vo[press] == '全部'): else: echo ($vo["press"]); endif; if($vo[grade] == '全部'): else: echo ($vo["grade"]); endif; if($vo[subject] == '全部'): else: echo ($vo["subject"]); endif; if($vo[chapter] == '全部'): else: echo ($vo["chapter"]); endif; if($vo[sub_chapter] == '全部'): else: echo ($vo["sub_chapter"]); endif; ?></p>
		<p style="font-size:  1.6rem;margin-bottom: -20px;">题型：<?php if(empty($vo[question_type])){echo '全部';}else{ echo ($vo["question_type"]); } ?></p>	    
	    <p style="font-size:  1.6rem;margin-bottom: -20px;">难度：<?php if(empty($vo[question_difficulty])){echo '全部';}else{ echo ($vo["question_difficulty"]); } ?></p>
	    <p style="font-size:  1.6rem;margin-bottom: -20px;">题集：<?php if(empty($vo[topic_set])){echo '全部';}else{ echo ($vo["topic_set"]); } ?></p>
	    <p style="font-size:  1.6rem;margin-bottom: -20px;">期望上课时间：
            <?php if($vo[wanted_start_time] == '0000-00-00 00:00:00'||$vo[wanted_start_time] == null){ ?>任意 <?php }else{ echo (date('Y-m-d',strtotime($vo['wanted_start_time']))); } ?></p>
	    <p style="font-size:  1.6rem;margin-bottom: -20px;">期望的老师：<?php if(!empty($vo[teacher])): echo ($vo["teacher"]); else: ?>任意<?php endif; ?></p>
	    <p style="font-size: 1.6rem;margin-bottom: 12px;">期望班级类型：<?php if(!empty($vo[class_type])): echo ($vo["class_type"]); else: ?>任意<?php endif; ?></p>
    <?php else: ?>
    	<p style="font-size:  1.6rem"><?php echo ($vo["content"]); ?></p><?php endif; ?>
</div><?php endforeach; endif; ?>
<?php else: ?>
                <div style="text-align:center;background: #f4f5f7; line-height:525px">
                    <span style="font-size:18px;color:#aeb4aa">暂无数据</span>
                </div><?php endif; ?>
<input type="hidden" id="moban" value="/ll/themes/lailong/">

<!--浮动导航-->
<div class="nav_bar" style="z-index:999;bottom:60px;left:20px">
	<ul class="am-list" id="panel">
		<li style="background:none!important;"><a href="<?php echo U('Mine/my');?>"><img style="width:41px;margin-top:-4px;" src="/ll/themes/lailong/Public/images/demo/user.png"></a></li>
		<li style="background:none!important;"><a href="<?php echo U('Mine/server');?>"><img style="width:41px;margin-top:-4px;" src="/ll/themes/lailong/Public/images/demo/gn.png"></a></li>
		<li style="background:none!important;"><a href="<?php echo U('Course/course');?>"><img style="width:41px;margin-top:-4px;" src="/ll/themes/lailong/Public/images/demo/course.png"></a></li>
	</ul>
	<!--<div id="flip" class="icon_nav"></div>-->
	<div id="flip" name="0" style="background:none" >
		<img style="width:41px;margin-top:-4px;" src="/ll/themes/lailong/Public/images/demo/open.png">
	</div>
</div>

<script src="/ll/themes/lailong/Public/js/weixin/public.js"></script>
<!--[if (gte IE 9)|!(IE)]><!-->

<!--<![endif]-->
<!--[if lte IE 8 ]>
<!--<script src="http://libs.baidu.com/jquery/1.11.1/jquery.min.js"></script>-->
<![endif]-->
<script src="/ll/themes/lailong/Public/js/weixin/amazeui.min.js"></script>
</body>
</html>