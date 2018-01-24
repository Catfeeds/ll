<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html class="no-js">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="viewport"
          content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>填写订单</title>
    <link rel="stylesheet" href="/ll/themes/lailong/Public/font-awesome-4.7.0/css/font-awesome.css">
    <link rel="stylesheet" href="/ll/themes/lailong/Public/css/weixin/amazeui.min.css">
    <link rel="stylesheet" href="/ll/themes/lailong/Public/css/weixin/bdTel.css">
    <link rel="stylesheet" href="/ll/themes/lailong/Public/css/weixin/course.css">
	<link rel="stylesheet" href="/ll/themes/lailong/Public/css/weixin/public.css">
	<script src="/ll/themes/lailong/Public/js/weixin/jquery.min.js"></script>	
    <!--<link rel="stylesheet" href="assets/css/app.css">-->
</head>
<body>
<div data-am-widget="intro" class="am-intro am-cf am-intro-default" style="padding: 10px 12px;background: #f4f5f7">
    <div class="am-g am-intro-bd" style="background:white;padding: 0px">
        <div class="xq" style="height: inherit">
            <div class="am-intro-left am-u-sm-3" style="width:79px;height: 56px;margin: 8px 0 0 -6px;">
                <img style="display: inline-block; width: 56px;height: 56px; border-radius: 50%;" src="/ll/data/upload/avatar/<?php echo ($course["picture"]); ?>" alt="">
            </div>
            <div class="am-intro-right am-u-sm-9"><p style="font-size: 16px;margin-top: 8px;font-weight: bold"><?php echo ($course["title"]); ?></p><p style="font-size: 14px;margin-top: -17px;
color: black">讲师：<?php echo ($teacher["name"]); ?>  开课时间：<?php echo substr($course[start_time],0,10); ?></p><input type="hidden" id="courseid" value="<?php echo ($course["id"]); ?>"/></div>
        </div>
    </div>
</div>

<div data-am-widget="list_news" class="am-list-news am-list-news-default" >

    <div class="am-list-news-bd">
        <ul class="am-list">
            <li class="am-g am-list-item-dated" style="position: relative;height: 50px;border: none;">
                    <span style="line-height: 47px">上课学生</span>
                    <select id="child" style="width: 80%;color: #999;border:none; direction: rtl;appearance:none;  -moz-appearance:none;  -webkit-appearance:none;" >
                       <?php if(is_array($child)): foreach($child as $key=>$c): ?><option value="<?php echo ($c["id"]); ?>"><?php echo ($c["name"]); ?></option><?php endforeach; endif; ?>
                    </select>
            </li>
        </ul>
    </div>

</div>



<div class="am-modal am-modal-alert" tabindex="-1" id="my-alert">
  <div class="am-modal-dialog">
    <div class="am-modal-bd" id="alert_cont">
      Hello world！
    </div>
    <div class="am-modal-footer">
      <span class="am-modal-btn">确定</span>
    </div>
  </div>
</div>

<div class="am-modal am-modal-alert" tabindex="-1" id="default-alert">
  <div class="am-modal-dialog">
    <div class="am-modal-bd" id="alert_conts">
      Hello world！
    </div>
    <input type="hidden" id="returnval"/> 
    <div class="am-modal-footer">
      <span class="am-modal-btn true">确定</span>
    </div>
  </div>
</div>
<div class="am-modal am-modal-alert" tabindex="-1" id="conform-alert">
  <div class="am-modal-dialog">
    <div class="am-modal-bd" id="conform_conts">
      Hello world！
    </div>
    <input type="hidden" id="returnval"/> 
    <div class="am-modal-footer">
      <span class="am-modal-btn cancel">取消</span>
      <span class="am-modal-btn tobuy">购买</span>
    </div>
  </div>
</div>
<footer  data-am-widget="footer">
<input type="hidden" id="integral"  value="<?php echo ($course["integral"]); ?>"/>
    <span style="font-weight: bold">应支付：<?php echo ($course["integral"]); ?>积分</span>
    <button id="sign">立即报名</button>
</footer>
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
<!--<![endif]-->
<!--[if lte IE 8 ]>
<script src="http://libs.baidu.com/jquery/1.11.1/jquery.min.js"></script>
<![endif]-->
<script src="/ll/themes/lailong/Public/js/weixin/amazeui.min.js"></script>
</body>
<script>
	$('#sign').click(function(){
		var child=$('#child').find('option:selected').val();
		var integral=$('#integral').val();
		var courseid=$('#courseid').val();
		if(child ==""){
			$("#my-alert").modal();
	 		$("#alert_cont").text("请选择学生");
			return;
		}
		$.post('<?php echo U("course/do_pay");?>',
				{child:child,integral:integral,courseid:courseid},
			 	function(data){
					if(data[0]=="101"){
						$("#default-alert").modal();
				 		$("#alert_conts").text(data[1]);
				 		$('#returnval').val(data[2]);
					}else if(data[0]=="103"){
						$("#my-alert").modal();
				 		$("#alert_cont").text(data[1]);
				 		return;
					}else if(data[0] == '1'){
						$("#my-alert").modal();
				 		$("#alert_cont").text(data[1]);
				 		return;
                    }else if(data[0] == '0'){
                    	$("#default-alert").modal();
				 		$("#alert_conts").text(data[1]);
				 		$('#returnval').val(data[2]);
                    }else{
                    	$("#my-alert").modal();
				 		$("#alert_cont").text(data[1]);
				 		return;
                    }
					
		});
	})
	$('.tobuy').click(function(){
			window.location.href="<?php echo U('Mine/recharge');?>";
 		})
	$('.cancel').click(function(){
			return;
 		})
	$('.true').click(function(){
		var val=$('#returnval').val();
			window.location.href="<?php echo U('Mine/lineitem?id=');?>"+val;
 		})
</script>
</html>