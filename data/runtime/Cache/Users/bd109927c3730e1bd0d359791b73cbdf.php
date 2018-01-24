<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html>
<head>
	<meta charset="utf-8">
	<!-- Set render engine for 360 browser -->
	<meta name="renderer" content="webkit">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- HTML5 shim for IE8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="https://oss.maxcdn.com/libs/html5shiv/3.7.0/html5shiv.js"></script>
    <![endif]-->

	<link href="/ll/public/simpleboot/themes/<?php echo C('SP_ADMIN_STYLE');?>/theme.min.css" rel="stylesheet">
    <link href="/ll/public/simpleboot/css/simplebootadmin.css" rel="stylesheet">
    <link href="/ll/public/js/artDialog/skins/default.css" rel="stylesheet" />
    <link href="/ll/public/simpleboot/font-awesome/4.4.0/css/font-awesome.min.css"  rel="stylesheet" type="text/css">
    <style>
		.length_3{width: 180px;}
		form .input-order{margin-bottom: 0px;padding:3px;width:40px;}
		.table-actions{margin-top: 5px; margin-bottom: 5px;padding:0px;}
		.table-list{margin-bottom: 0px;}
		.input-search{width: 100px;margin-left: 10px;margin-right: 20px;}
	</style>
	<!--[if IE 7]>
	<link rel="stylesheet" href="/ll/public/simpleboot/font-awesome/4.4.0/css/font-awesome-ie7.min.css">
	<![endif]-->
<script type="text/javascript">
//全局变量
var GV = {
    DIMAUB: "/ll/",
    JS_ROOT: "public/js/",
    TOKEN: ""
};
</script>
<!-- Le javascript
    ================================================== -->
    <!-- Placed at the end of the document so the pages load faster -->
    <script src="/ll/public/js/jquery.js"></script>
    <script src="/ll/public/js/wind.js"></script>
    <script src="/ll/public/simpleboot/bootstrap/js/bootstrap.min.js"></script>
    <script src="/ll/public/js/DatePicker1/WdatePicker.js"></script>
<?php if(APP_DEBUG): ?><style>
		#think_page_trace_open{
			z-index:9999;
		}
		.center-table th,.center-table td{
			text-align: center;
		}
	</style><?php endif; ?>
</head>
<body>
	<div class="wrap">
		<ul class="nav nav-tabs">
			<li><a href="<?php echo U('User/userlist');?>">用户列表</a></li>
			<li ><a href="<?php echo U('User/add');?>">新增用户</a></li>
			<li class="active"><a href="<?php echo U('User/edit',array('id'=>$id));?>">编辑用户</a></li>
		</ul>
		<form method="post" id="form" class="form-horizontal js-ajax-form" action="<?php echo U('User/edit_post',array('id'=>$id));?>">
			<fieldset>
				<div class="control-group">
					<input type="hidden" name="id" value="<?php echo ($id); ?>">
					<label class="control-label">姓名</label>
					<div class="controls">
						<input type="text" name="name" value="<?php echo ($name); ?>" required>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">手机号</label>
					<div class="controls">
						<input type="text" name="phone" value="<?php echo ($phone); ?>" required>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">密码</label>
					<div class="controls">
						<input type="password" name="password" value="<?php echo ($password); ?>" required>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">积分</label>
					<div class="controls">
						<input type="number" name="integral" value="<?php echo ($integral); ?>" disabled>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">推荐人手机号</label>
					<div class="controls">
						<input type="text" name="recommended_person" value="<?php echo ($recommended_person); ?>" >
					</div>
				</div>
			</fieldset>
			<div class="form-actions">
				<button type="submit"  class="btn btn-primary js-ajax-submit">保存</button>
				<a class="btn" href="<?php echo U('User/userlist');?>"><?php echo L('BACK');?></a>
			</div>
		</form>
	</div>
	<script src="/ll/public/js/common.js"></script>
	<script type="text/javascript">
		function submit2(){
			var phone = $("input[name=phone]").val();
			if (/^((\d{3}-\d{8}|\d{4}-\d{7,8})|(1[3|4|5|7|8][0-9]{9}))$/.test(phone)){ 
				
			}else{
				alert("手机号码格式不正确！"); return;
			}
			var recommended_person = $("input[name=recommended_person]").val();
			if(recommended_person!=''){
				if (/^((\d{3}-\d{8}|\d{4}-\d{7,8})|(1[3|4|5|7|8][0-9]{9}))$/.test(recommended_person)){ 
				
				}else{
					alert("推荐人手机号码格式不正确！"); return;
				}
				if(phone==recommended_person){
					alert("手机号和推荐人手机号不能相同");return;
				}
			}
			var integral = $("input[name=integral]").val();
			if(/^[0-9]*[1-9][0-9]*$/.test(integral)){
				
			}else{
				alert("积分必须是正整数");return;
			}
			$("#form").submit();
		}
	</script>
</body>
</html>