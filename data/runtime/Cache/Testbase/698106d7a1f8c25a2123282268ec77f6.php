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
	</style><?php endif; ?>
</head>
<link rel="stylesheet" type="text/css" href="/ll/public/css/addcourse.css" />
<body>
	<div class="wrap">
		<ul class="nav nav-tabs">
			<li ><a href="<?php echo U('Chapter/chapterlist');?>">章节列表</a></li>
			<li class="active"><a href="<?php echo U('Chapter/addchapter');?>">新增章节</a></li>
		</ul>
		<form method="post" class="form-horizontal js-ajax-form" action="<?php echo U('Chapter/add_post');?>">
			<fieldset>
				<div class="control-group">
					<label class="control-label">标题</label>
					<div class="controls">
						<input type="text" name="title" required>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">所属书</label>
					<div class="controls">
						<select id="textbook_id" name="textbook_id" required>
							<option value="">请选择</option>
							<?php if(is_array($textbook)): foreach($textbook as $key=>$t): ?><option value="<?php echo ($t[id]); ?>"><?php echo ($t[subject]); ?></option><?php endforeach; endif; ?>
						</select>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">所属章</label>
					<div class="controls">
						<select id="parent_id" name="parent_id" required>
							<option value="0">设为章</option>
						</select>
						
					</div>
				</div>
			</fieldset>
			<div class="form-actions">
				<button type="submit" class="btn btn-primary js-ajax-submit
"><?php echo L('ADD');?></button>
				<a class="btn" href="javascript:history.back(-1);"><?php echo L('BACK');?></a>
			</div>
		</form>
	</div>
	<script src="/ll/public/js/common.js"></script>
</body>
<script type="text/javascript">
	$("#textbook_id").change(function(){
		var t_id = $("#textbook_id").val();
		//先移除章的所有选项
		$('#parent_id').empty();
		//添加一条为0的
		$('#parent_id').append("<option value='0'>设为章</option>");
		//ajax获取章名
		$.ajax({
			type: "POST",
			url: "<?php echo U('Chapter/getchapter');?>",
			dataType : 'json',
			data: {
				textbook_id : t_id
			},
			success: function(res){
				//js遍历生成option
				$.each(res,function(i, val) {
			      
			        $("#parent_id").append("<option value='" + val['id'] + "'>" + val['title'] + "</option>");
			      
			    });
			},
		});
	});
</script>
</html>