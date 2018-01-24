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
			<li class="active"><a href="<?php echo U('message/index');?>"><?php echo L('ADMIN_MESSAGE_INDEX');?></a></li>
			<li><a href="<?php echo U('message/add');?>"><?php echo L('ADMIN_MESSAGE_ADD');?></a></li>
		</ul>
		<form class="well form-search" method="post" action="<?php echo U('message/index');?>">
			课程： <select name="course">
					 <option></option>
					 <?php if(is_array($c)): foreach($c as $key=>$c): ?><option value="<?php echo ($c["id"]); ?>"<?php if($_SESSION[course] == $c[id]): ?>selected<?php endif; ?>><?php echo ($c["title"]); ?></option><?php endforeach; endif; ?>
				   </select>
			用户：<select name="user_id">
					 <option></option>
					 <?php if(is_array($u)): foreach($u as $key=>$u): ?><option value="<?php echo ($u["id"]); ?>" <?php if($_SESSION[users_id] == $u[id]): ?>selected<?php endif; ?>><?php echo ($u["phone"]); ?></option><?php endforeach; endif; ?>
				   </select>
			<input type="hidden" name="leixing" value="1"/>
			<input type="submit" class="btn btn-primary search" value="搜索"/>
       		<input type="submit" class="btn btn-primary all" value="全部" name="type"/>
		</form>
			<table class="table table-hover table-bordered table-list">
				<thead>
					<tr>
						<th width="5%">ID</th>
						<th><?php echo L('COURSE');?></th>
						<th><?php echo L('TITLE');?></th>
						<th><?php echo L('TYPE');?></th>
						<th><?php echo L('CTIME');?></th>
						<th><?php echo L('ACTIONS');?></th>
					</tr>
				</thead>
				<tbody>
					<?php if(is_array($list)): foreach($list as $key=>$vo): ?><tr>
							<td><?php echo ($vo["id"]); ?></td>
							<td><?php echo ($vo["coursename"]); ?></td>
							<td><?php echo ($vo["title"]); ?></td>
							<td><?php if($vo[type] == 0): ?>安卓app<?php elseif($vo[type] == 1): ?>微信<?php else: ?>安卓app 微信<?php endif; ?></td>
							<td><?php echo ($vo["createtime"]); ?></td>
							<td>
								<a href="<?php echo U('message/delete',array('id'=>$vo['id']));?>" class="js-ajax-delete"><?php echo L('DELETE');?></a>
							</td>
						</tr><?php endforeach; endif; ?>
				</tbody>
			</table><br/>
			<div class="pagination"><?php echo ($page); ?></div>
			<!-- <button class="btndelall btn-primary btn-small js-ajax-submit" type="button" data-subcheck="true" data-msg="你确定删除吗？"><?php echo L('DELETE');?></button> -->
	</div>
	<script src="/ll/public/js/common.js"></script>
</body>
</html>