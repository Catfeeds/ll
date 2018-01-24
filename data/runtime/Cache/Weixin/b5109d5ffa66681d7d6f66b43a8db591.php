<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html class="no-js">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="viewport"
          content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>我的订单</title>
    <link rel="stylesheet" href="/ll/themes/lailong/Public/css/weixin/amazeui.min.css">
    <link rel="stylesheet" href="/ll/themes/lailong/Public/css/weixin/bdTel.css">
    <link rel="stylesheet" href="/ll/themes/lailong/Public/css/weixin/dd.css">
	<link rel="stylesheet" href="/ll/themes/lailong/Public/css/weixin/public.css">
	<script src="/ll/themes/lailong/Public/js/weixin/jquery.min.js"></script>	
	<style>
	.am-tabs-bd .am-tab-panel .img1{
	width:50px;
	height:50px;
	margin-top:18px;
	border-radius:50%;
	background: url('<?php echo ($url); echo ($listmes["cover"]); ?>') no-repeat center;
	background-size:cover;
	}
	.am-tabs-bd .am-tab-panel .statu p{
	font-size:14px;
	}
	</style>

	
    <!--<link rel="stylesheet" href="assets/css/app.css">-margin-right:11px;
	margin-top:10px;->
</head>
<body>
<!--列表切换-->
<div data-am-widget="tabs" class="am-tabs am-tabs-d2" >
    <ul class="am-tabs-nav am-cf"  style="background: white;position: fixed;top: 0;z-index: 999;">
        <li class="am-active"><a style="font-size: 1.6rem" href="[data-tab-panel-0]">全部</a></li>
        <li class=""><a style="font-size: 1.6rem" href="[data-tab-panel-1]">待支付</a></li>
        <li class=""><a style="font-size: 1.6rem" href="[data-tab-panel-2]">待确认</a></li>
        <li class=""><a style="font-size: 1.6rem" href="[data-tab-panel-3]">已完成</a></li>
        <li class=""><a style="font-size: 1.6rem" href="[data-tab-panel-4]">已取消</a></li>
    </ul>
    <div class="am-tabs-bd" style="top: 42px;">
        <div data-tab-panel-0 class="am-tab-panel am-active">
	        <div style="background: #f4f5f7;padding: 0px;text-align: center;" id="enrollment6">
	         <?php if(empty($all_order)): ?><!-- div剧中 显示 暂无数据 -->
				 <span style="line-height: 525px;font-size: 18px;color: #aeb4aa;">暂无数据</span>
	         <?php else: ?>
	         	 <?php if(is_array($all_order)): foreach($all_order as $key=>$va): ?><div class="lb1" onclick="textmes(<?php echo ($va["oid"]); ?>)">
						<div class="img1" style="background: url('<?php echo ($url); echo ($va["cover"]); ?>') no-repeat center;background-size:cover;"></div>
			            <div class="txt" style="height: 64px;text-align:left;margin-top:4px;">
			                <p style="font-size: 16px;color: #4a76fb;width: 150px;overflow:hidden; white-space: nowrap;text-overflow: ellipsis;"><?php echo ($va["title"]); ?></p>
			                <p style="font-size: 12px;width: 150px;overflow:hidden; white-space: nowrap;text-overflow: ellipsis">下单时间：<?php echo date("Y-m-d",strtotime($va['time'])); ?></p>
			                <p style="font-size: 12px;width: 150px;overflow:hidden; white-space: nowrap;text-overflow: ellipsis">需要积分：<?php echo ($va["integral"]); ?></p>
			            </div>
			            <div class="statu">
			                <?php if($va['state'] == 0): ?><p>待付款</p>
			                <p class="pay" style="margin-top:-13px;">去支付</p>
			                <?php elseif($va['state'] == 1): ?>
			                <p>待确认</p>
			                <?php elseif($va['state'] == 3): ?>
			                <p style="color: #30ddac">已完成</p>
			                <?php elseif($va['state'] == 4): ?>
			                <p>已取消</p><?php endif; ?>
			            </div>
			        </div><?php endforeach; endif; endif; ?>
		    </div>
		    <?php if($all_c == 1): ?><p style="text-align:center;color: #0e90d2;" class="enrollment" name="1" type="6" id="enrollment_6">点击加载更多</p><?php endif; ?>
        </div>
        <div data-tab-panel-1 class="am-tab-panel ">
           <div style="background: #f4f5f7;padding: 0px;text-align: center" id="enrollment0">
            <?php if(empty($dai_order)): ?><!-- div剧中 显示 暂无数据 -->
				<span style="line-height: 525px;font-size: 18px;color: #aeb4aa;">暂无数据</span>
	         <?php else: ?>
	         	<?php if(is_array($dai_order)): foreach($dai_order as $key=>$vb): ?><div class="lb1" onclick="textmes(<?php echo ($vb["oid"]); ?>)">
			        	<div class="img1" style="background: url('<?php echo ($url); echo ($vb["cover"]); ?>') no-repeat center;background-size:cover;"></div>
			            
			            <div class="txt" style="width: 150px;height: 64px;text-align:left;margin-top:4px;" >
			                <p style="font-size: 16px;color: #4a76fb;width: 150px;white-space: nowrap;text-overflow: ellipsis;"><?php echo ($vb["title"]); ?></p>
			                <p style="font-size: 12px;text-overflow: ellipsis;">下单时间：<?php echo date("Y-m-d",strtotime($vb['time'])); ?></p>
			                <p style="font-size: 12px;text-overflow: ellipsis;">需要积分：<?php echo ($vb["integral"]); ?></p>
			            </div>
			            <div class="statu">
			                <p>待付款</p>
			                <p class="pay" style="margin-top:-13px;">去支付</p>
			            </div>
			        </div><?php endforeach; endif; endif; ?>
	        </div>
	        <?php if($dai_c == 1): ?><p style="text-align:center;color: #0e90d2;" class="enrollment" name="1" type="0" id="enrollment_0">点击加载更多</p><?php endif; ?>
        </div>
        <div data-tab-panel-2 class="am-tab-panel ">
	        <div style="background: #f4f5f7;padding: 0px;text-align: center" id="enrollment1">
	         <?php if(empty($true_order)): ?><!-- div剧中 显示 暂无数据 -->
				 <span style="line-height: 525px;font-size: 18px;color: #aeb4aa;">暂无数据</span>
	         <?php else: ?>
	         	 <?php if(is_array($true_order)): foreach($true_order as $key=>$vc): ?><div class="lb1" onclick="textmes(<?php echo ($vc["oid"]); ?>)">
			        	<div class="img1" style="background: url('<?php echo ($url); echo ($vc["cover"]); ?>') no-repeat center;background-size:cover;"></div>
			            <div class="txt" style="width: 150px;height: 64px;text-align:left;margin-top:4px;" >
			                <p style="font-size: 16px;color: #4a76fb;width: 150px;white-space: nowrap;text-overflow: ellipsis;"><?php echo ($vc["title"]); ?></p>
			                <p style="font-size: 12px;text-overflow: ellipsis;">下单时间：<?php echo date("Y-m-d",strtotime($vc['time'])); ?></p>
			                <p style="font-size: 12px;text-overflow: ellipsis;">需要积分：<?php echo ($vc["integral"]); ?></p>
			            </div>
			            <div class="statu">
			                <p>待确认</p>
			            </div>
			        </div><?php endforeach; endif; endif; ?>
		    </div>
		    <?php if($true_c == 1): ?><p style="text-align:center;color: #0e90d2;" class="enrollment" name="1" type="1" id="enrollment_1">点击加载更多</p><?php endif; ?>
        </div>
        <div data-tab-panel-3 class="am-tab-panel ">
	        <div style="background: #f4f5f7;padding: 0px;text-align: center" id="enrollment3">
	         <?php if(empty($over_order)): ?><!-- div剧中 显示 暂无数据 -->
				 <span style="line-height: 525px;font-size: 18px;color: #aeb4aa;">暂无数据</span>
	         <?php else: ?>
	         	 <?php if(is_array($over_order)): foreach($over_order as $key=>$vd): ?><div class="lb1" onclick="textmes(<?php echo ($vd["oid"]); ?>)">
			        	<div class="img1" style="background: url('<?php echo ($url); echo ($vd["cover"]); ?>') no-repeat center;background-size:cover;"></div>
			            <div class="txt" style="width: 150px;height: 64px;text-align:left;margin-top:4px;" >
			                <p style="font-size: 16px;color: #4a76fb;width: 150px;white-space: nowrap;text-overflow: ellipsis;"><?php echo ($vd["title"]); ?></p>
			                <p style="font-size: 12px;text-overflow: ellipsis;">下单时间：<?php echo date("Y-m-d",strtotime($vd['time'])); ?></p>
			                <p style="font-size: 12px;text-overflow: ellipsis;">需要积分：<?php echo ($vd["integral"]); ?></p>
			            </div>
			            <div class="statu">
			                <p style="color: #30ddac">已完成</p>
			            </div>
			        </div><?php endforeach; endif; endif; ?>
		    </div>
		    <?php if($over_c == 1): ?><p style="text-align:center;color: #0e90d2;" class="enrollment" name="1" type="3" id="enrollment_3">点击加载更多</p><?php endif; ?>
        </div>
        <div data-tab-panel-4 class="am-tab-panel ">
	        <div style="background: #f4f5f7;padding: 0px;text-align: center" id="enrollment4">
	        <?php if(empty($die_order)): ?><!-- div剧中 显示 暂无数据 -->
				<span style="line-height: 525px;font-size: 18px;color: #aeb4aa;">暂无数据</span>
	         <?php else: ?>
	         	 <?php if(is_array($die_order)): foreach($die_order as $key=>$ve): ?><div class="lb1" onclick="textmes(<?php echo ($ve["oid"]); ?>)">
			        	<div class="img1" style="background: url('<?php echo ($url); echo ($ve["cover"]); ?>') no-repeat center;background-size:cover;"></div>
			            <div class="txt" style="width: 150px;height: 64px;text-align:left;margin-top:4px;" >
			                <p style="font-size: 16px;color: #4a76fb;width: 150px;white-space: nowrap;text-overflow: ellipsis;"><?php echo ($ve["title"]); ?></p>
			                <p style="font-size: 12px;text-overflow: ellipsis;">下单时间：<?php echo date("Y-m-d",strtotime($ve['time'])); ?></p>
			                <p style="font-size: 12px;text-overflow: ellipsis;">需要积分：<?php echo ($ve["integral"]); ?></p>
			            </div>
			            <div class="statu">
			                <p>已取消</p>
			            </div>
			        </div><?php endforeach; endif; endif; ?>
		    </div>
		    <?php if($die_c == 1): ?><p style="text-align:center;color: #0e90d2;" class="enrollment" name="1" type="4" id="enrollment_4">点击加载更多</p><?php endif; ?>
        </div>
    </div>
</div>
<input type="hidden" value="<?php echo ($userid); ?>" id="userid">
<input type="hidden" value="<?php echo ($_GET['id']); ?>" id="ids">
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

<!--[if (gte IE 9)|!(IE)]><!-->
<!--<![endif]-->
<!--[if lte IE 8 ]>
<script src="http://libs.baidu.com/jquery/1.11.1/jquery.min.js"></script>
<![endif]-->
<script src="/ll/themes/lailong/Public/js/weixin/amazeui.min.js"></script>
<script src="/ll/themes/lailong/Public/js/weixin/public.js"></script>
<script>
function textmes(id){
	window.location.href="<?php echo U('Mine/lineitem?id=');?>"+id;
}
//加载更多订单
$(".enrollment").click(function(){
	var num=$(this).attr("name");
	var type=$(this).attr("type");
	var userid=$("#userid").val();
	var id=$("#ids").val();
	$.post('<?php echo U("Mine/enrollment_more");?>',
            { num : num , type : type , id : id , userid : userid},
            function(data){
            	console.log(data);
            	if(data[1]!=""){
            		$("#enrollment_"+type).attr("name",data[1]);
            	}else{
            		$("#enrollment_"+type).css("display","none");
            	}
            	$("#enrollment"+type).append(data[0]);
            });
})
</script>
</body>
</html>