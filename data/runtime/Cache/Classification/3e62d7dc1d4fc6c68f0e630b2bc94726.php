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
<style>
	.control-group{
		margin-left :100px; 
	}
	.s1{
		margin: 1px;
	}
</style>
<body>
	<div class="wrap js-check-wrap">
		<ul class="nav nav-tabs">
			<li><a href="<?php echo U('classification/childlist');?>">小孩列表</a></li>
			<li><a href="<?php echo U('classification/addchild');?>">新增孩子</a></li>
			<li class="active"><a href="<?php echo U('classification/relation_user');?>">关联用户</a></li>
		</ul>
		<form class="well form-search" method="get" action="<?php echo U('classification/relation_user');?>" id="form_submit">
		    <div class="search_type cc mb10">
		      <div class="mb10"> 
		        <span class="mr20">
		        <input type="hidden" name="g" value="Classification">
		        <input type="hidden" name="m" value="classification">
		        <input type="hidden" name="a" value="relation_user">
		        	姓名:<input type="text" name="name" style="width: 100px;margin-left: 10px;" value="<?php echo ($name); ?>" placeholder="姓名"/>
		        	手机号:<input type="text" name="phone" style="width: 100px;margin-left: 10px;" value="<?php echo ($phone); ?>" placeholder="手机号">
					<button class="btn btn-primary ">搜索</button>
				</span>
			   </div>
		        
		        
		      
		    </div>
		  </form>
			<table class="table table-hover table-bordered table-list center-table">
				<thead>
					<tr>
						<th width="50">ID</th>
						<th>姓名</th>
						<th>手机号</th>
						<th>操作</th>
					</tr>
				</thead>
				<tbody>
					<?php if(is_array($user_list)): foreach($user_list as $key=>$vo): ?><tr>
						<td><?php echo ($vo["id"]); ?></td>
						<td><?php echo ($vo["name"]); ?></td>
						<td><?php echo ($vo["phone"]); ?></td>
						<td>
							<?php if($type=='1'){ ?>
							<a href="<?php echo U('classification/addchild',array('u_id'=>$vo[id]));?>">关联孩子</a>
						<?php	} ?>
							<?php if($type=='2'){ ?>
							<a href="<?php echo U('classification/editchild',array('u_id'=>$vo[id],'editid'=>$child_id));?>">关联孩子</a>
						<?php	} ?>
						</td>
					</tr><?php endforeach; endif; ?>
				</tbody>
				
			</table>
		<div class="pagination"><?php echo ($page); ?></div>
	</div>
	<script src="/ll/public/js/common.js"></script>

</body>
</html>