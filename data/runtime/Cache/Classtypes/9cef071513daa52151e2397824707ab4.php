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
			<li class="active"><a href="<?php echo U('Classroom/classroomlist');?>">教室列表</a></li>
			<li><a href="<?php echo U('Classroom/add');?>">新增教室</a></li>
		</ul>
		<form class="well form-search" method="get" action="<?php echo U('Classroom/classroomlist');?>" id="form_submit">
		    <div class="search_type cc mb10">
		      <div class="mb10"> 
		        <span class="mr20">
		        <input type="hidden" name="g" value="Classtypes">
		        <input type="hidden" name="m" value="Classroom">
		        <input type="hidden" name="a" value="classroomlist">
		     
		        
			        <div class="row" style="margin-top: 20px;">
				        <div class="span1">
				        	教室名称:
				        </div>
				        <div class="span2">
				        	<input type="text" name="title" style="width: 100px;" value="<?php echo ($title); ?>" placeholder="教室名称"/>
				        </div>
				        <div class="span1">
				        	联系电话:
						</div>
						<div class="span2">
							<input type="text" name="phone" style="width: 100px;" value="<?php echo ($phone); ?>" placeholder="联系电话"/>
						</div>
						<div class="span1">
							地址:
						</div>
						<div class="span2">
							<input type="text" name="address" style="width: 100px;" value="<?php echo ($address); ?>" placeholder="地址"/>
						</div>
						<button class="btn btn-primary">搜索</button>
					</div>
				</span>
			   </div>

		        
		        
		      
		    </div>
		  </form>
		<table class="table table-hover table-bordered">
			<thead>
				<tr>
					<th width="50">ID</th>
					<th>教室名称</th>
					<th>联系电话</th>
					<th>地址</th>
					<th>操作</th>
				</tr>
			</thead>
			<tbody>
				<?php if(is_array($list)): foreach($list as $key=>$v): ?><tr>
						<td><?php echo ($v["id"]); ?></td>
						<td><?php echo ($v["title"]); ?></td>
						<td><?php echo ($v["phone"]); ?></td>
						<td><?php echo ($v["address"]); ?></td>
						<td>
							<a href="<?php echo U('Classroom/edit',array('editid'=>$v[id]));?>"><?php echo L('EDIT');?></a>
							<!-- <a class="js-ajax-delete" href="<?php echo U('Classroom/delete',array('id'=>$v[id]));?>"><?php echo L('DELETE');?></a> -->
						</td>
					</tr><?php endforeach; endif; ?>
			</tbody>
		</table>
		<div class="pagination"><?php echo ($page); ?></div>
	</div>
	<script src="/ll/public/js/common.js"></script>
</body>
</html>