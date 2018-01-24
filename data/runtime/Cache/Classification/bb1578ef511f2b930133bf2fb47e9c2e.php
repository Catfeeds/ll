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
			<li><a href="<?php echo U('classification/teacherlist');?>"><?php echo L('ADMIN_TEACHER_INDEX');?></a></li>
			<li><a href="<?php echo U('classification/addteacher');?>"><?php echo L('ADMIN_TEACHER_ADD');?></a></li>
			<li class="active"><a href="<?php echo U('classification/editeacher');?>"><?php echo L('ADMIN_TEACHER_EDIT');?></a></li>
		</ul>
		<form method="post" class="form-horizontal js-ajax-form" action="<?php echo U('classification/edit_post');?>">
			<input type="hidden" name="editid" value="<?php echo ($list["id"]); ?>"/>
			<fieldset>
				<div class="control-group">
					<label class="control-label"><?php echo L('NAME');?></label>
					<div class="controls">
						<input type="text" name="name" value="<?php echo ($list["name"]); ?>">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label"><?php echo L('ICON');?></label>
					<div class="controls">
						<?php if(!empty($list[avatar])): ?><img src="/ll/public/images/tv.gif" id='close2' style="margin-left: -13px;margin-top: -11px;position: relative;" />
							<div id="img2" style="width: 100px;height: 100px;background: url(/ll/data/upload/avatar/<?php echo ($list["avatar"]); ?>) no-repeat center; background-size: cover;"></div><?php endif; ?>
							<div id="add_img" <?php if(!empty($list[avatar])): ?>style="display:none;"<?php endif; ?>>
								<input type="hidden" name="avatar" value="<?php echo ($list[avatar]); ?>"> 
								<input type="file" onchange="avatar_upload_filtration(this)" id="file2" name="icon" />
							</div>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label"><?php echo L('COLLEGE');?></label>
					<div class="controls">
						<input type="text" name="university" value="<?php echo ($list["university"]); ?>">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label"><?php echo L('GRADE');?></label>
					<div class="controls">
						<input type="text" name="teaching_grade" value="<?php echo ($list["teaching_grade"]); ?>">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label"><?php echo L('TEACHACHI');?></label>
					<div class="controls">
						<textarea name="teaching_results"><?php echo ($list["teaching_results"]); ?></textarea>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label"><?php echo L('TEACHEXPER');?></label>
					<div class="controls">
						<textarea name="experience"><?php echo ($list["experience"]); ?></textarea>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label"><?php echo L('TEACHCHARACT');?></label>
					<div class="controls">
						<textarea name="features"><?php echo ($list["features"]); ?></textarea>
					</div>
				</div>
			</fieldset>
			<div class="form-actions">
				<input type="hidden" name="id" value="<?php echo ($id); ?>" />
				<button type="submit" class="btn btn-primary js-ajax-submit"><?php echo L('SAVE');?></button>
				<a class="btn" href="<?php echo U('classification/teacherlist');?>"><?php echo L('BACK');?></a>
			</div>
		</form>
	</div>
	<script src="/ll/public/js/common.js"></script>
</body>
<script type="text/javascript">
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
	$(this).css({'display':'none'});
})
</script>
</html>