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
			<li><a href="<?php echo U('record/intention');?>"><?php echo L('ADMIN_INTENT_INDEX');?></a></li>
			<li><a href="<?php echo U('record/intention2');?>"><?php echo L('ADMIN_INTENTX_INDEX');?></a></li>
			<li class="active"><a href="<?php echo U('record/find');?>"><?php echo L('ADMIN_INTENTX_FIND');?></a></li>
		</ul>
		<form method="post" class="form-horizontal js-ajax-form">
			<fieldset>
			<?php if($_GET[type] == 0): ?><div class="control-group">
					<label class="control-label"><?php echo L('CHILD');?></label>
					<div class="controls">
						<input type="text" value="<?php echo ($list["name"]); ?>" disabled>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label"><?php echo L('GRADE');?></label>
					<div class="controls">
						<input type="text" value="<?php echo ($list["grade"]); ?>" disabled>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label"><?php echo L('PRESS');?></label>
					<div class="controls">
						<input type="text" value="<?php echo ($list["press"]); ?>" disabled>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label"><?php echo L('SUB');?></label>
					<div class="controls">
						<input type="text" value="<?php echo ($list["subject"]); ?>" disabled>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label"><?php echo L('CHAPTER');?></label>
					<div class="controls">
						<input type="text" value="<?php echo ($list["chapter"]); ?>" disabled>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label"><?php echo L('SUB_CHAPTER');?></label>
					<div class="controls">
						<input type="text" value="<?php echo ($list["sub_chapter"]); ?>" disabled>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label"><?php echo L('QT');?></label>
					<div class="controls">
						<input type="text"  value="<?php echo ($list["question_type"]); ?>" disabled>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label"><?php echo L('QD');?></label>
					<div class="controls">
						<input type="text" value="<?php echo ($list["question_difficulty"]); ?>" disabled>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label"><?php echo L('TS');?></label>
					<div class="controls">
						<input type="text" value="<?php echo ($list["topic_set"]); ?>" disabled>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label"><?php echo L('WST');?></label>
					<div class="controls">
						<input type="text" value="<?php echo ($list["wanted_start_time"]); ?>" disabled>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label"><?php echo L('TEACHER');?></label>
					<div class="controls">
						<input type="text" value="<?php echo ($list["teacher"]); ?>" disabled>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label"><?php echo L('CT');?></label>
					<div class="controls">
						<input type="text"  value="<?php echo ($list["class_type"]); ?>" disabled>
					</div>
				</div>
			<?php elseif($_GET[type] == 1): ?>
				<div class="control-group">
					<label class="control-label"><?php echo L('CONTENT');?></label>
					<div class="controls">
						<textarea disabled style="width:70%;height:200px;"><?php echo ($list["content"]); ?></textarea>
					</div>
				</div><?php endif; ?>
			</fieldset>
		</form>
			<div class="form-actions">
				<a class="btn" href="<?php echo U('record/intention2');?>"><?php echo L('BACK');?></a>
			</div>
	</div>
	<script src="/ll/public/js/common.js"></script>
</body>

</html>