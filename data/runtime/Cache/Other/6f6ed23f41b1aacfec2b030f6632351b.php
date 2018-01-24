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
			<li><a href="<?php echo U('information/index');?>"><?php echo L('ADMIN_INFO_INDEX');?></a></li>
			<li class="active"><a href="<?php echo U('information/add');?>"><?php echo L('ADMIN_INFO_ADD');?></a></li>
		</ul>
		<form method="post" class="form-horizontal js-ajax-form" action="<?php echo U('information/add_post');?>">
			<input type="hidden" name="editid" value="<?php echo ($i["id"]); ?>"/>
			<fieldset>
				<div class="control-group">
					<label class="control-label"><?php echo L('TITLE');?></label>
					<div class="controls">
						<input type="text" name="title" value="<?php echo ($i["title"]); ?>">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label"><?php echo L('ICON');?></label>
					<div class="controls">
						<img id="img2" <?php if(!empty($i[icon])): ?>src="/ll/data/upload/avatar/<?php echo ($i[icon]); ?>"<?php endif; ?>>
							<div id="add_img">
								<input type="hidden" name="picture" value="<?php echo ($i[icon]); ?>"> 
								<input type="file" onchange="avatar_upload_filtration(this)" id="file2" name="icon" />
							</div>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label"><?php echo L('CONTENT');?></label>
					<div class="controls">
						<textarea rows="5" cols="5" name="content"><?php echo ($i["content"]); ?></textarea>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label"><?php echo L('H5');?></label>
					<div class="controls">
						<script type="text/plain" id="content" name="textareas"><?php echo ($h5["content"]); ?></script>
						<input type="hidden" name="h5_id" value="<?php echo ($h5["id"]); ?>" />
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">网页地址</label>
					<div class="controls">
						<input type="text" name="url" value="<?php echo ($h5["url"]); ?>" />
					</div>
				</div>
			</fieldset>
			<div class="form-actions">
				<button type="submit" class="btn btn-primary js-ajax-submit"><?php if(empty($_GET[id])): echo L('ADD'); else: echo L('EDIT'); endif; ?></button>
				<a class="btn" href="<?php echo U('Information/index');?>"><?php echo L('BACK');?></a>
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
			url : "<?php echo U('Testbase/Course/up');?>",
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
						'/ll/data/upload/avatar/'
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
	 $.post('<?php echo U("classification/deleteicon");?>', {
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
</script>
</html>