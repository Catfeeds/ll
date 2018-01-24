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
			<li><a href="<?php echo U('message/index');?>"><?php echo L('ADMIN_MESSAGE_INDEX');?></a></li>
			<li class="active"><a href="<?php echo U('message/add');?>"><?php echo L('ADMIN_MESSAGE_ADD');?></a></li>
		</ul>
		<form method="post" class="form-horizontal js-ajax-form"
			action="<?php echo U('message/add_post');?>">
			<fieldset>
				<div class="control-group">
					<label class="control-label"><?php echo L('TITLE');?></label>
					<div class="controls">
						<input type="text" name="title">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label"><?php echo L('COURSE');?></label>
					<div class="controls">
						<select name="course_id">
								<option></option>
							<?php if(is_array($res)): foreach($res as $key=>$v): ?><option value="<?php echo ($v["id"]); ?>"><?php echo ($v["title"]); ?></option><?php endforeach; endif; ?>
						</select>
					</div>
				</div>
				<!-- <div class="control-group">
					<label class="control-label"><?php echo L('ICON');?></label>
					<div class="controls">
						<input type="text" name="icon">
					</div>
				</div> -->
				<div class="control-group">
					<label class="control-label"><?php echo L('ICON');?></label>
					<div class="controls">
						<img id="img2" >
							<div id="add_img">
								<input type="hidden" name="icon1" value=""> 
								<input type="file" name="icon" onchange="avatar_upload_filtration(this)" id="file2"  />
							</div>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label"><?php echo L('DESC');?></label>
					<div class="controls">
						<textarea name="content"></textarea>
					</div>
				</div>
				<!-- <div class="control-group">
					<label class="control-label"><?php echo L('USER');?></label>
					<div class="controls">
						<select name="user_id">
							<option></option>
							<?php if(is_array($user)): foreach($user as $key=>$vs): ?><option value="<?php echo ($vs["id"]); ?>"><?php echo ($vs["phone"]); ?></option><?php endforeach; endif; ?>
						</select>
					</div>
				</div> -->
				<div class="control-group">
					<label class="control-label"><?php echo L('TYPE');?></label>
					<div class="controls">
						<!-- <select name="type">
							<option value="0">安卓app</option>
							<option value="1">微信</option>
						</select> -->
						<input type="checkbox" name="type" class="type" value="0" ><span style="font-size: 15px;margin-right: :15px; ">安卓app</span>
						<input type="checkbox" name="type" class="type"  value="1" ><span style="font-size: 15px;margin-right:15px; ">微信</span>
						<input type="checkbox" name="type" class="type"  value="2" ><span style="font-size: 15px;margin-right:15px; ">双平台</span>
					</div>
				</div>
			</fieldset>
			<div class="form-actions">
				<button type="submit" class="btn btn-primary js-ajax-submit"><?php echo L('ADD');?></button>
				<a class="btn" href="<?php echo U('message/index');?>"><?php echo L('BACK');?></a>
			</div>
		</form>
	</div>
<script src="/ll/public/js/common.js"></script>
	<script type="text/javascript">
//上传图片
function avatar_upload_filtration(obj) {
	var $fileinput = $(obj);
	var img2 = $('#img2').next().children('input').val();
	Wind.css("jcrop");
	Wind.use("ajaxfileupload", "jcrop", "noty", function() {
		$.ajaxFileUpload({
			url : "<?php echo U('Message/up');?>",
			secureuri : false,
			fileElementId : "file2",
			dataType : 'json',
			data : {
				img2 : img2
			},
			success : function(data) {
				$('#file2').parent().css({'display':'none'});
				$('#img2').before(" <img src=\"/ll/public/images/tv.gif\" id='close2' style=\"margin-left: -13px;margin-top: -11px;position: relative;\" />");
				$('#img2').attr(
						'src',
						'/ll/data/upload/message/'
								+ data.data.iconname);
				$('#img2').next().children('input').val(data.data.iconname);
			},
			error : function(data, status, e) {
			}
		});
	});
}
$('fieldset').on('click','#close2',function(){
	var img2 = $('#img2').next().children('input').val();
	 $.post('<?php echo U("Message/deleteicon");?>', {
		 img2: img2
		},
		function(data) {
		}
	)
	$('#img2').attr('src','');
	$('#file2').parent().css({'display':'block'});
	$('#img2').next().children('input').val('');
	$(this).css({'display':'none'});
})

	   $(':checkbox[type="checkbox"]').each(function(){
           $(this).click(function(){
               if($(this).attr('checked')){
                   $(':checkbox[type="checkbox"]').removeAttr('checked');
                   $(this).attr('checked','checked');
               }
           });
       });
	</script>

</body>
</html>