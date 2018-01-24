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
			<li class="active"><a href="<?php echo U('scorecharge/scorechargelist');?>"><?php echo L('ADMIN_H5_INDEX');?></a></li>
			<li><a href="<?php echo U('scorecharge/addscore');?>"><?php echo L('ADMIN_H5_ADD');?></a></li>
		</ul>
		<form class="js-ajax-form" action="<?php echo U('scorecharge/listorders');?>" method="post">
			<div class="table-actions">
				<button class="btn btn-primary btn-small js-ajax-submit" type="submit"><?php echo L('SORT');?></button>
			</div>
		<table class="table table-hover table-bordered">
			<thead>
				<tr>
					<th width="80">排序</th>
					<th width="50">ID</th>
					<th><?php echo L('SCORE');?></th>
					<th><?php echo L('PRICE');?></th>
					<th><?php echo L('CTIME');?></th>
					<th width="120"><?php echo L('ACTIONS');?></th>
				</tr>
			</thead>
			<tbody>
				<?php if(is_array($list)): foreach($list as $key=>$list): ?><tr>
						<td style='padding-left:20px;'><input name='listorders[<?php echo ($list[id]); ?>]' type='number' size='3' value='<?php echo ($list["index_id"]); ?>' class='input input-order'></td>
						<td><?php echo ($list["id"]); ?></td>
						<td><?php echo ($list["integral"]); ?></td>
						<td><?php echo ($list["amount"]); ?></td>
						<td><?php echo ($list["createtime"]); ?></td>
						<td><!-- <a href="<?php echo U('h5/edith5',array('editid'=>$list[id]));?>"><?php echo L('EDIT');?></a> -->
							<a href="<?php echo U('scorecharge/delete',array('id'=>$list[id]));?>"  class="js-ajax-delete"><?php echo L('delete');?></a>
						</td>
					</tr><?php endforeach; endif; ?>
			</tbody>
		</table>
		<div class="table-actions">
				<button class="btn btn-primary btn-small js-ajax-submit" type="submit"><?php echo L('SORT');?></button>
			</div>
		</form>
		<div class="pagination"><?php echo ($page); ?></div>
	</div>
	<script src="/ll/public/js/common.js"></script>
</body>
</html>