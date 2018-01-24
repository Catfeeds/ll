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
	<div class="wrap js-check-wrap">
		<ul class="nav nav-tabs">
			<li class="active"><a href="<?php echo U('record/intention');?>"><?php echo L('ADMIN_INTENT_INDEX');?></a></li>
			<li><a href="<?php echo U('record/intention2');?>"><?php echo L('ADMIN_INTENTX_INDEX');?></a></li>
		</ul>
		<table class="table table-hover table-bordered">
			<thead>
				<tr>
					<th width="50">ID</th>
					<th><?php echo L('CHILD');?></th>
					<th><?php echo L('GRADE');?></th>
					<th><?php echo L('SUB');?></th>
					<th><?php echo L('QT');?></th>
					<th><?php echo L('QD');?></th>
					<th><?php echo L('WST');?></th>
					<th><?php echo L('TEACHER');?></th>
					<th><?php echo L('CT');?></th>
					<th><?php echo L('CTIME');?></th>
					<th width="120"><?php echo L('ACTIONS');?></th>
				</tr>
			</thead>
			<tbody>
				<?php if(is_array($list)): foreach($list as $key=>$list): ?><tr>
						<td><?php echo ($list["id"]); ?></td>
						<td><?php echo ($list["name"]); ?></td>
						<td><?php echo ($list["grade"]); ?></td>
						<td><?php echo ($list["subject"]); ?></td>
						<td><?php echo ($list["question_type"]); ?></td>
						<td><?php echo ($list["question_difficulty"]); ?></td>
						<td><?php if($list['wanted_start_time']!="0000-00-00 00:00:00"){ echo $list['wanted_start_time']; } ?></td>
						<td><?php echo ($list["teacher"]); ?></td>
						<td><?php echo ($list["class_type"]); ?></td>
						<td><?php echo ($list["createtime"]); ?></td>
						<td><a href="<?php echo U('record/find',array('id'=>$list[id],'type'=>0));?>"><?php echo L('查看');?></a>|<a href="<?php echo U('record/relation',array('id'=>$list[id],'type'=>1));?>">关联意向课程</td>
					</tr><?php endforeach; endif; ?>
			</tbody>
		</table>
		<div class="pagination"><?php echo ($page); ?></div>
	</div>
	<script src="/ll/public/js/common.js"></script>
</body>
</html>