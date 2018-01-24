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
			<li><a href="<?php echo U('course/courselist');?>"><?php echo L('ADMIN_COURSE_INDEX');?></a></li>
			<li class="active"><a href="<?php echo U('course/addcourse');?>"><?php echo L('ADMIN_COURSE_ADD');?></a></li>
		</ul>
		<form method="post" class="form-horizontal js-ajax-form" action="<?php echo U('course/add_post');?>">
			<fieldset>
				<div class="control-group">
					<label class="control-label"><?php echo L('NAME');?></label>
					<div class="controls">
						<input type="text" name="title">
					</div>
				</div>
				<div class="control-group">
					<span style="margin-left: 200px;">注:列表图片建议尺寸80*80</span>
					<label class="control-label">列表图片</label>
					<div class="controls">
						<div id="img2" style="width: 80px;height: 80px; background-size: cover;"></div>
							<div id="add_img">
								<input type="hidden" name="cover"> 
								<input type="file" onchange="avatar_upload_filtration(this)" id="file2" name="icon" />
							</div>
					</div>
				</div>
				<div class="control-group">
					<span style="margin-left: 200px;">注:详情图片建议尺寸600*180</span>
					<label class="control-label">详情图片</label>
					<div class="controls">
						<div id="img3" style="width: 200px;height: 180px; background-size: cover;"></div>
							<div id="add_img2">
								<input type="hidden" name="picture"> 
								<input type="file" onchange="avatar_upload_filtration2(this)" id="file3" name="icon2" />
							</div>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label"><?php echo L('PERSONCOUNT');?></label>
					<div class="controls">
						<input type="text" name="rated_number">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label"><?php echo L('SCORE');?></label>
					<div class="controls">
						<input type="text" name="integral">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label"><?php echo L('TEACHER');?></label>
					<div class="controls">
						<select name="teacher_id">
							<?php if(is_array($teacher)): foreach($teacher as $key=>$t): ?><option value="<?php echo ($t["id"]); ?>"><?php echo ($t["name"]); ?></option><?php endforeach; endif; ?>
						</select>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">教室</label>
					<div class="controls">
						<select name="classroom_id">
							<?php if(is_array($classroom)): foreach($classroom as $key=>$t): ?><option value="<?php echo ($t["id"]); ?>"><?php echo ($t["address"]); ?></option><?php endforeach; endif; ?>
						</select>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label"><?php echo L('STARTIME');?></label>
					<div class="controls">
						<input type="text"placeholder="请输入日期..." name="start_time" class="input length_2" value="<?php echo ($formget["dates"]); ?>" autocomplete="off" onClick="WdatePicker()" onfocus="WdatePicker({skin:'whyGreen',dateFmt:'yyyy-MM-dd HH:mm:ss'})">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">课程详情</label>
					<div class="controls">
						<script type="text/plain" id="content" name="textareas"></script>
					</div>
				</div>
			</fieldset>
			<div class="form-actions">
				<button type="submit" class="btn btn-primary js-ajax-submit"><?php echo L('ADD');?></button>
				<a class="btn" href="<?php echo U('course/courselist');?>"><?php echo L('BACK');?></a>
			</div>
		</form>
	</div>
	<script src="/ll/public/js/common.js"></script>
	<script type="text/javascript" src="/ll/public/js/ueditor/ueditor.config.js"></script>
	<script type="text/javascript" src="/ll/public/js/ueditor/ueditor.all.min.js"></script>
</body>
<script type="text/javascript">
$(function(){
	var editorURL = GV.DIMAUB;
	editorcontent = new baidu.editor.ui.Editor();
	editorcontent.render('content');
	try {
		editorcontent.sync();
	} catch (err) {
	}
	$('#content').css({'width':'700px','height':'200px'});
})
//上传图片
function avatar_upload_filtration(obj) {
	var $fileinput = $(obj);
	var img2 = $('#img2').next().children('input').val();
	Wind.css("jcrop");
	Wind.use("ajaxfileupload", "jcrop", "noty", function() {
		$.ajaxFileUpload({
			url : "<?php echo U('Course/up');?>",
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
function avatar_upload_filtration2(obj) {
	var $fileinput = $(obj);
	var img3 = $('#img3').next().children('input').val();
	Wind.css("jcrop");
	Wind.use("ajaxfileupload", "jcrop", "noty", function() {
		$.ajaxFileUpload({
			url : "<?php echo U('Course/up2');?>",
			secureuri : false,
			fileElementId : "file3",
			dataType : 'json',
			data : {
				img3 : img3
			},
			success : function(data) {
				$('#file3').parent().css({'display':'none'});
				$('#img3').before(" <img src=\"/ll/public/images/tv.gif\" id='close3' style=\"margin-left: -13px;margin-top: -11px;position: relative;\" />");
				$('#img3').css(
						'background',
						'url(/ll/data/upload/avatar/'
								+ data.data.iconname2+') no-repeat center');
				$('#img3').next().children('input').val(data.data.iconname2);
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
$('fieldset').on('click','#close3',function(){
	var img3 = $('#img3').next().children('input').val();
	 $.post('<?php echo U("classification/deleteicon2");?>', {
		 img3: img3
		},
		function(data) {
		}
	)
	$('#img3').css('background','');
	$('#file3').parent().css({'display':'block'});
	$('#img3').next().children('input').val('');
	$(this).css({'display':'none'});
})
</script>
</html>