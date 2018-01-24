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
<link rel="stylesheet" type="text/css" href="/ll/public/css/addcourse.css" />
<body>
	<div class="wrap">
		<ul class="nav nav-tabs">
			<li><a href="<?php echo U('classification/childlist');?>">小孩列表</a></li>
			<li class="active"><a href="<?php echo U('classification/addchild');?>">新增孩子</a></li>
		</ul>
		<form method="post" class="form-horizontal js-ajax-form" action="<?php echo U('classification/addchild_post');?>">
			<fieldset>
				<div class="control-group">
					<label class="control-label">孩子真名</label>
					<div class="controls">
						<input type="text" name="name" required>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">孩子昵称</label>
					<div class="controls">
						<input type="text" name="nickname">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label"><?php echo L('ICON');?></label>
					<div class="controls">
					<div id="img2" style="width: 100px;height: 100px; background-size: cover;"></div>
						
							<div id="add_img">
								<input type="hidden" name="avatar" value=""> 
								<input type="file" onchange="avatar_upload_filtration(this)" id="file2" name="icon" required />
							</div>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">生日</label>
					<div class="controls">
						<input type="text" name="birthday" required class="input length_2 J_date" value="<?php echo ($birthday); ?>" autocomplete="off" placeholder="请选择时间..." onClick="WdatePicker()" onfocus="WdatePicker({skin:'whyGreen',dateFmt:'yyyy-MM-dd'})">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">性别</label>
					<div class="controls">
						<select name="gender" id="gender" required>
							<option value="0">未知</option>
							<option value="1">男</option>
							<option value="2">女</option>
						</select>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">所在学校</label>
					<div class="controls">
						<input type="text" name="school" required>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">所在年级</label>
					<div class="controls">
						<input type="text" name="grade" required>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">关联用户</label>
					<div class="controls" id="ceshi">
						<input type="text" id="username" name="username" readonly value="<?php echo ($uinfo[name]); ?>" ><a style="margin-left: 30px;" href="<?php echo U('classification/relation_user',array('type'=>1));?>">点击关联</a>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">用户与孩子的称呼</label>
					<div class="controls">
						<input type="text" name="appellation" value="">
					</div>
				</div>
				<input type="hidden" name="u_id" value="<?php echo ($uinfo[id]); ?>">
				<div class="control-group">
					<label class="control-label">认证会员状态</label>
					<div class="controls">
						<select id="vip_state" name="vip_state" required>
							<option value="0">未认证</option>
							<option value="1">认证中</option>
							<option value="2">认证失败</option>
							<option value="3">认证成功</option>
						</select>
					</div>
				</div>
			</fieldset>
			<div class="form-actions">
				<button type="submit" id="submit1" class="btn btn-primary js-ajax-submit
"><?php echo L('ADD');?></button>
				<a class="btn" href="<?php echo U('classification/childlist');?>"><?php echo L('BACK');?></a>
			</div>
		</form>
	</div>
	<script src="/ll/public/js/common.js"></script>
	<script src="/ll/public/js/cookie.js"></script>
</body>
<script type="text/javascript">
 $("#ceshi").click(function(){
 	//跳转前先存一下cookie，提交删除
 	var name =$("input[name=name]").val();
 	//不可以用name，在cookie里会被默认 - -
 	$.cookie('uname',name);
 	var nickname = $("input[name=nickname]").val();
 	$.cookie('nickname',nickname);
 	var avatar = $("input[name=avatar]").val();
 	$.cookie('avatar',avatar);
 	var birthday = $("input[name=birthday]").val();
 	$.cookie('birthday',birthday);
 	var gender =$("#gender").val();
 	$.cookie('gender',gender);
 	var school = $("input[name=school]").val();
 	$.cookie('school',school);
 	var grade = $("input[name=grade]").val();
 	$.cookie('grade',grade);
 	var vip_state = $("#vip_state").val();
 	$.cookie('vip_state',vip_state);
 });
$(function(){
	$("input[name=name]").val($.cookie('uname'));
	$("input[name=nickname]").val($.cookie('nickname'));
	$("input[name=birthday]").val($.cookie('birthday'));
	$("#gender").val($.cookie('gender'));
	$("input[name=school]").val($.cookie('school'));
	$("input[name=grade]").val($.cookie('grade'));
	$("#vip_state").val($.cookie('vip_state'));
	if($.cookie('avatar')){
		var s =$.cookie('avatar');
		
		$('#file2').parent().css({'display':'none'});
		$('#img2').before(" <img src=\"/ll/public/images/tv.gif\" id='close2' style=\"margin-left: -13px;margin-top: -11px;position: relative;\" />");
		$('#img2').css(
				'background',
				'url(/ll/data/upload/avatar/'
						+ s+') no-repeat center');
		//$('#img2').next().children('input').val(s);
	}
	$("input[name=avatar]").val($.cookie('avatar'));
	$("#submit1").click(function(){
		$.cookie('uname',"");$.cookie('gender',"");
		$.cookie('nickname',"");$.cookie('school',"");
		$.cookie('avatar',"");$.cookie('grade',"");
		$.cookie('birthday',"");$.cookie('vip_state',"");
	});
})
//上传图片
function avatar_upload_filtration(obj) {
	var $fileinput = $(obj);
	var img2 = $('#img2').next().children('input').val();
	Wind.css("jcrop");
	Wind.use("ajaxfileupload", "jcrop", "noty", function() {
		$.ajaxFileUpload({
			url : "<?php echo U('classification/up');?>",
			secureuri : false,
			fileElementId : "file2",
			dataType : 'json',
			data : {
				img2 : img2
			},
			success : function(data) {
				$('#file2').parent().css({'display':'none'});
				$('#img2').before(" <img src=\"/ll/public/images/tv.gif\" id='close2' style=\"margin-left: -13px;margin-top: -11px;position: relative;\" />");
				$('#img2').css(
						'background',
						'url(/ll/data/upload/avatar/'
								+ data.data.iconname+') no-repeat center');
				$('#img2').next().children('input').val(data.data.iconname);
			},
			error : function(data, status, e) {
			}
		});
	});
}
$('fieldset').on('click','#close2',function(){
	var img2 = $('#img2').next().children('input').val();
	 $.post('<?php echo U("classification/deleteicon");?>', {
		 img2: img2
		},
		function(data) {
		}
	)
	$('#img2').css('background','');
	$('#file2').parent().css({'display':'block'});
	$('#img2').next().children('input').val('');
	$(this).css({'display':'none'});
})
</script>
</html>