<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html class="no-js">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="description" content="">
    <meta name="keywords" content="">
    <meta name="viewport"
          content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <title>绑定手机号</title>
    <link rel="stylesheet" href="/ll/themes/lailong/Public/css/weixin/amazeui.min.css">
    <link rel="stylesheet" href="/ll/themes/lailong/Public/css/weixin/bdTel.css">
    <!--<link rel="stylesheet" href="assets/css/app.css">-->
</head>
<body>
<!--表单-->
<section>
    <form class="am-form am-form-horizontal">
        <div class="am-form-group">
            <div class="am-u-sm-13">
                <label id="te" style="color: #6f716c;">手机号</label>
                <input type="number" id="doc-ipt-3" class="am-radius" style="text-align: right;padding-right:13rem"placeholder="请输入手机号">
                <input id="min" style="font-size: 16px" type="button" value="发送验证码" class="btn1 getcode">
            </div>
        </div>

        <div class="am-form-group" style="margin-top: -16px;">
            <div class="am-u-sm-13">
                <label id="yz" style="color: #6f716c;">验证码</label>
                <input type="text" id="doc-ipt-pwd-2" class="am-radius" placeholder="输入验证码">
            </div>
        </div>

        <div class="am-form-group">
            <div class="am-u-sm-13">
                <label id="tj" style="color: #6f716c;">推荐人</label>
                <input type="text" id="doc-ipt-pwd-3" class="am-radius" placeholder="请填写推荐人手机号码（选填）">
            </div>
        </div>

        <div class="am-form-group">
            <div class="am-u-sm-13">
                <p style="color: #a5a8a0;font-size: 12px;margin: -2px 0 20px 0;letter-spacing: 1.5px">绑定即表明您同意<a href="<?php echo U('rulepage/user_protocol');?>" style="color: #0190ff;border-bottom: 1px solid #0190ff;">用户协议</a></p>
            </div>
        </div>

        <div class="am-form-group">
            <div class="am-u-sm-13">
            <input type="button" id="regist_go" value="绑定" class="am-btn am-btn-block" style="text-align:center;background: #2adcaa;font-weight: bold; color: white;height: 50px;margin-top: -23px;border-radius:3px">
            </div>
        </div>

    </form>
</section>


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
<!--<script src="http://libs.baidu.com/jquery/1.11.1/jquery.min.js"></script>-->
<![endif]-->
<script src="/ll/themes/lailong/Public/js/weixin/amazeui.min.js"></script>
<script>
$("#min").click(function(){
	$("#min").css({"width":"92px","text-align":"center"})
})
$("#regist_go").click(function(){
	var phone=$("#doc-ipt-3").val();
	var code=$("#doc-ipt-pwd-2").val();
	var recommend=$("#doc-ipt-pwd-3").val();
	if(phone==""){
		$("#my-alert").modal();
 		$("#alert_cont").text("请输入手机号!");
 		return;
	}
	if(code==""){
		$("#my-alert").modal();
 		$("#alert_cont").text("请输入验证码!");
 		return;
	}
	$.post('<?php echo U("Center/bang_go");?>',
			{ phone : phone , code : code , recommend : recommend},
		 	function(data){
				if(data[0]=="101"){
					$("#my-alert").modal();
			 		$("#alert_cont").text(data[1]);
			 		window.location.href="<?php echo U('Mine/my');?>";
				}else{
					$("#my-alert").modal();
			 		$("#alert_cont").text(data[1]);
			 		return;
				}
	});
})
$(".getcode").click(function(){
	var phone=$("#doc-ipt-3").val();
	var re = /^1\d{10}$/;
    if (re.test(phone)) {
    } else {
   	 $("#my-alert").modal();
		 $("#alert_cont").text("请输入正确手机号!");
		 return;
    }
	 $.post('<?php echo U("Center/send_note");?>',
			{ phone : phone},
		 	function(data){
				if(data[0]=="101"){
					//$("#my-alert").modal();
			 		 var t=60;
			 	    var interval=setInterval(function(){
			 	    	console.log(t);
			 	        if(t>0){
			 	            $(".getcode").attr("disabled","true")
			 	            $(".getcode").val(""+t+" 秒");
			 	        }else{
			 	            $(".getcode").removeAttr("disabled");
			 	            $(".getcode").val("获取验证码");
			 	            clearInterval(interval);
			 	        }
			 	        t--;
			 	    },1000);
			 		
				}else{
					$("#my-alert").modal();
			 		$("#alert_cont").text(data[1]);
			 		return;
			}
	}); 
   
})
</script>
</body>
</html>