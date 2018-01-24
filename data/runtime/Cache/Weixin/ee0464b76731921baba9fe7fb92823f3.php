<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html class="no-js">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="viewport"
          content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>我的消息</title>
    <link rel="stylesheet" href="/ll/themes/lailong/Public/font-awesome-4.7.0/css/font-awesome.css">
    <link rel="stylesheet" href="/ll/themes/lailong/Public/css/weixin/amazeui.min.css">
    <link rel="stylesheet" href="/ll/themes/lailong/Public/css/weixin/bdTel.css">
    <link rel="stylesheet" href="/ll/themes/lailong/Public/css/weixin/course.css">
	<link rel="stylesheet" href="/ll/themes/lailong/Public/css/weixin/public.css">
	<script src="/ll/themes/lailong/Public/js/weixin/jquery.min.js"></script>	
    <!--<link rel="stylesheet" href="assets/css/app.css">-->
</head>
<body>
<div id="news_list">
<?php if(!empty($n)): if(is_array($n)): foreach($n as $key=>$n): ?><div data-am-widget="intro" class="am-intro am-cf am-intro-default" style="padding: 10px 12px;background: #f4f5f7;margin-bottom:-5px;">
	    <div class="am-g am-intro-bd" style="background:white;padding: 0px">
	        <div class="xq" style="height: inherit">
	        <?php if(empty($n[course_id])): ?><div class="am-intro-left am-u-sm-3" style="width:79px;height: 56px;margin-top: 11px">
					<div style=" width: 56px;height: 56px;border-radius:50%;background: url(<?php echo ($n["icon"]); ?>) no-repeat center;background-size:cover;"></div>
	            </div>
	            <div class="am-intro-right am-u-sm-9">
	                <p style="font-size: 1.6rem;margin-top: 8px;font-weight: bold;"><?php echo ($n["title"]); ?></p>
	                <p style="margin-top: -21px;font-size:1.4rem;color:black;overflow:hidden;white-space:nowrap;text-overflow:ellipsis;"><?php echo ($n["createtime"]); ?></p>
	                <p style="font-size: 1.3rem;margin-top: -21px;margin-bottom:8px;color: #7f7c8e;"><?php echo ($n["content"]); ?></p></div>
	        <?php else: ?>
	        	<a href="<?php echo U('course/course_detail?id='); echo ($n["course_id"]); ?>">
		        	<div class="am-intro-left am-u-sm-3" style="width:79px;height: 56px;margin-top: 11px">
						<div style=" width: 56px;height: 56px;border-radius:50%;background: url(<?php echo ($n["icon"]); ?>) no-repeat center;background-size:cover;"></div>
		            </div>
		            <div class="am-intro-right am-u-sm-9">
		                <p style="font-size: 1.6rem;margin-top: 8px;font-weight: bold;"><?php echo ($n["title"]); ?></p>
		                <p style="margin-top: -21px;font-size:1.4rem;color:black;overflow:hidden;white-space:nowrap;text-overflow:ellipsis;"><?php echo ($n["createtime"]); ?></p>
		                <p style="font-size: 1.3rem;margin-top: -21px;margin-bottom:8px;color: #7f7c8e;"><?php echo ($n["content"]); ?></p></div>
	        	</a><?php endif; ?>   
	        </div>
	        
	    </div>
	</div><?php endforeach; endif; ?>
<?php else: ?>
                <div style="text-align:center;background: #f4f5f7; line-height:525px">
                    <span style="font-size:18px;color:#aeb4aa">暂无数据</span>
                </div><?php endif; ?>
</div>
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
<?php if($typea == 1): ?><p style="text-align:center;color: #0e90d2;" class="select_f" name="1" id="news">点击加载更多</p><?php endif; ?>
<input type="hidden" value="<?php echo ($userid); ?>" id="userid">
<!--[if (gte IE 9)|!(IE)]><!-->
<script src="/ll/themes/lailong/Public/js/weixin/jquery.min.js"></script>
<!--<![endif]-->
<!--[if lte IE 8 ]>
<script src="http://libs.baidu.com/jquery/1.11.1/jquery.min.js"></script>
<![endif]-->
<script src="/ll/themes/lailong/Public/js/weixin/amazeui.min.js"></script>
<script>
//加载更多服务
$(".select_f").click(function(){
	var num=$(this).attr("name");
	var table=$(this).attr("id");
	var userid=$("#userid").val();
	$.post('<?php echo U("Mine/news_more");?>',
			{ num : num , table : table , userid : userid},
            function(data){
            	console.log(data);
            	if(data[1]!=""){
            		$("#"+table).attr("name",data[1]);
            	}else{
            		$("#"+table).css("display","none");
            	}
            	$("#"+table+"_list").append(data[0]);
            });
})
</script>
</body>
</html>