<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html class="no-js">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="viewport"
          content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>取消订单</title>
    <link rel="stylesheet" href="/ll/themes/lailong/Public/font-awesome-4.7.0/css/font-awesome.css">
    <link rel="stylesheet" href="/ll/themes/lailong/Public/css/weixin/amazeui.min.css">
    <link rel="stylesheet" href="/ll/themes/lailong/Public/css/weixin/bdTel.css">
    <link rel="stylesheet" href="/ll/themes/lailong/Public/css/weixin/dd.css">
    <!--<link rel="stylesheet" href="/ll/themes/lailong/Public/css/weixin/course.css">-->
    <!--<link rel="stylesheet" href="assets/css/app.css">-->
</head>
<body>
<form class="am-form am-form-horizontal" style="padding: 10px 10px">
        <div class="am-form-group">
            <textarea style="border:none;::-webkit-input-placeholder { /* WebKit browsers */
color:#d3d8cd;
};resize : none;" class="crouse" rows="8" placeholder="请填写取消原因"></textarea>
        </div>

        <div class="am-u-sm-13" style="padding: 0;margin-top: 20px">
          <input type="button" id="blacka" class="am-btn am-btn-block" style="background: #2adcaa;color: white;height: 50px;margin-top: -27px;border-radius:3px" value="提交">
        </div>
</form>
<input type="hidden" value="<?php echo ($_GET['id']); ?>" id="orderid">


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
<!--[if (gte IE 9)|!(IE)]><!-->
<script src="/ll/themes/lailong/Public/js/weixin/jquery.min.js"></script>
<!--<![endif]-->
<!--[if lte IE 8 ]>
<script src="http://libs.baidu.com/jquery/1.11.1/jquery.min.js"></script>
<![endif]-->
<script src="/ll/themes/lailong/Public/js/weixin/amazeui.min.js"></script>
<script>
$("#blacka").click(function(){
	var orderid=$("#orderid").val();
	var content=$(".crouse").val();
	if(content==""){
		$("#my-alert").modal();
 		$("#alert_cont").text("请填写取消原因!");
 		return;
	}
	$.post('<?php echo U("Mine/black_order");?>',
            { orderid : orderid , content : content},
            function(data){
            	if(data[0]=="101"){
					$("#my-alert").modal();
			 		$("#alert_cont").text(data[1]);
                    window.setTimeout("refreshPage()",1000);
			 		setTimeOut('1000',jump);
				}else{
					$("#my-alert").modal();
			 		$("#alert_cont").text(data[1]);
			 		return;
				}
            });
})
function refreshPage()
{
    var orderid=$("#orderid").val();
    window.location.href="<?php echo U('Mine/lineitem?id=');?>"+orderid;
}

</script>
</body>
</html>