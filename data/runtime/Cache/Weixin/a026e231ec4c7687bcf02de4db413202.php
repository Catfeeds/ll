<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html class="no-js">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="viewport"
          content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>课程详情</title>
    <!--<link rel="icon" href="/ll/themes/lailong/Public/i/favicon.png">-->
    <!--<link rel="stylesheet" href="/ll/themes/lailong/Public/fonts/fontawesome-webfont.woff">-->
    <link rel="stylesheet" href="/ll/themes/lailong/Public/font-awesome-4.7.0/css/font-awesome.css">
    <link rel="stylesheet" href="/ll/themes/lailong/Public/css/weixin/amazeui.min.css">
    <link rel="stylesheet" href="/ll/themes/lailong/Public/css/weixin/bdTel.css">
    <link rel="stylesheet" href="/ll/themes/lailong/Public/css/weixin/course.css">
    <link rel="stylesheet" href="/ll/themes/lailong/Public/css/weixin/courseX.css">
	<link rel="stylesheet" href="/ll/themes/lailong/Public/css/weixin/public.css">
	<script src="/ll/themes/lailong/Public/js/weixin/jquery.min.js"></script>	
    <!--<link rel="stylesheet" href="assets/css/app.css">-->
</head>
<body>
<div class="bg">
    <ul style="padding: 10px;" data-am-widget="gallery" class="am-gallery am-avg-sm-1
  am-avg-md-1 am-avg-lg-1 am-gallery-default" data-am-gallery="{ pureview: true }" >
        <li style="background: white">
            <div class="am-gallery-item">
                <a href="#" class="">
                    <!--<img style="border-radius: 3px;" src="/ll/themes/lailong/Public/images/bg.png"/>-->
                    <?php
 if($list[picture]){ $imgurl = AVATAR_ROOT."/data/upload/avatar/".$list[picture]; }else{ $imgurl = "/ll/themes/lailong/Public/images/bg.png"; } ?>
                    <div class="course_img" style="height:115px;background-image: url('<?php echo ($imgurl); ?>');background-size: cover;background-position: 50% 50%;">
       				</div>
                    <h3 class="am-gallery-title2" style="color: black;font-weight: bold;font-size: 1.6rem;"><?php echo ($list["title"]); ?></h3>
                    <div>
                        <p style="font-size: 12px;color: #3151f8;">开课时间：<?php echo ($list["start_time"]); ?></p>
                        <p style="font-size: 12px;margin-top: -18px;color: #3151f8;">每班人数：<?php echo ($list["rated_number"]); ?></p>
                        <h3 style="margin-top: -18px;color: orangered"><?php echo ($list["integral"]); ?>积分</h3>
                        <div class="starr"></div>
                    </div>
                </a>
            </div>
        </li>
    </ul>

</div>
<?php if($list["address"] != ''): ?><!--<div class="am-g am-intro-bd" style="padding: 10px 10px;font-size: 13px; margin-top: -10px">
	    <div class="xq" style="background:white;position: relative">
	        <div class="am-intro-left am-u-sm-6" style="margin: 8px 0 0 6px;">
	            <span style="font-size: 18px;font-weight:lighter; color: black"><?php echo ($list["address"]); ?></span><br>
	            <span><?php echo ($list["rcontent"]); ?></span>
	        </div>
	        <div class="am-intro-right am-u-sm-6" style="margin-top: 14px;position: absolute;top: 2px;right: 0;">
	            <img style="width: 25px;height: 30px;float: right" src="/ll/themes/lailong/Public/images/address.png" alt="">
	        </div>
	    </div>
	</div>-->
	<div class="am-g am-intro-bd" style="padding:10px 10px;font-size: 13px; margin-top: -10px;margin-bottom: 8px;">
		<div style="width: 100%;background-color: #ffffff;padding:6px 10px 0rem;">
			<table style="width: 100%;">
				<tr>
					<td style="    padding-right: 33px;">
						<span style="font-size: 18px;font-weight:lighter; color: black"><?php echo ($list["rtitle"]); ?></span>
						<br>
	           			 <span style="line-height: 36px;display:inline-block;margin-top:-8px;"><?php echo ($list["address"]); ?></span>
					</td>
					<td>
						<img style="width: 25px;height: 30px;float: right" src="/ll/themes/lailong/Public/images/address.png" alt="">
					</td>
				</tr>
			</table>
		</div>
	</div><?php endif; ?>


<div class="am-g am-intro-bd" style="padding: 10px 10px;margin-top: -18px">
    <a href="<?php echo U('Course/teacher_information?id='); echo ($list["tid"]); ?>" style="color: black">
    	<?php
 if($list[tavatar]){ $imgurl = AVATAR_ROOT."/data/upload/avatar/".$list[tavatar]; }else{ $imgurl = "/ll/themes/lailong/Public/images/teacher2.png"; } ?>
    <div class="xq" style="background:white;height: 110px;">
        <div class="am-intro-left am-u-sm-3 tea" style="width:69px;height: 77px;margin: 17px 0 0 6px;background-image: url('<?php echo ($imgurl); ?>');background-size: cover;background-position: 50% 50%;">
        </div>
        <div class="am-intro-right am-u-sm-9" style="overflow: hidden;height: 91px;padding-top:5px;">
            <p style="font-size: 13px;margin-top: 8px;">讲师：<?php echo ($list["teacher"]); ?></p>
            <p style="font-size: 13px;margin-top: -17px;">
            	<?php if($list["teaching_results"] != ''): echo ($list["teaching_results"]); endif; ?></p>
            <a href="<?php echo U('Course/teacher_information?id='); echo ($list["tid"]); ?>"> <span style="color: #ceced0; top: 4.4rem;font-size:1.9rem" class="am-list-date fa fa-chevron-right" aria-hidden="true"></span></a>
        </div>
    </div>
    </a>
</div>

<div class="bg1">
    <ul data-am-widget="gallery" class="am-gallery am-avg-sm-1
  am-avg-md-1 am-avg-lg-1 am-gallery-default" data-am-gallery="{ pureview: true }" >
        <li style="background: white">
            <h3>详情</h3>
            <div class="am-gallery-item" style="padding: 16px 13px;">
                    <?php echo ($list["content"]); ?>
            </div>
        </li>
    </ul>

</div>

<div class="am-form-group">
    <div class="am-u-sm-13" style="padding: 0px">
    	<?php if($list[start_time] <= date('Y-m-d H:i:s',time())): ?><button type="button" class="am-btn am-btn-block" style="background:#aeb4aa;height: 50px;color: white;margin-top: 10px;">已结束报名</button>
    	<?php else: ?>
    		 <a style="color:white" href="<?php echo U('write_order?courseid='); echo ($_GET[id]); ?>"><button type="submit" class="am-btn am-btn-block" style="background:#4877fb;height: 50px;color: white;margin-top: 10px;">立即报名</button></a><?php endif; ?>
       
    </div>
</div>
<input type="hidden" value="/ll/themes/lailong/Public" id="pic_url" />
<input type="hidden" value="<?php echo ($list["id"]); ?>" id="course_id" />
<input type="hidden" value='<?php echo U("Course/put_collection");?>' id="collect_url" />
<input type="hidden" value="<?php echo ($is_collect); ?>" id="is_collect" />
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
<script src="/ll/themes/lailong/Public/js/weixin/jquery.min.js"></script>
<!--<![endif]-->
<!--[if lte IE 8 ]>
<!--<script src="http://libs.baidu.com/jquery/1.11.1/jquery.min.js"></script>-->
<![endif]-->
<script src="/ll/themes/lailong/Public/js/weixin/amazeui.min.js"></script>
<script src="/ll/themes/lailong/Public/js/weixin/shoucang.js"></script>
</body>
</html>