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
<body>
	<div class="wrap js-check-wrap">
		<ul class="nav nav-tabs">
			<li class="active"><a href="<?php echo U('classification/member');?>">成员列表</a></li>
			<li><a href="<?php echo U('classification/addmember');?>">新增成员</a></li>
		</ul>
		<form class="well form-search" method="get" action="<?php echo U('classification');?>" id="form_submit">
		    <div class="search_type cc mb10">
		      <div class="mb10"> 
		        <span class="mr20">
		        <input type="hidden" name="g" value="Classification">
		        <input type="hidden" name="m" value="classification">
		        <input type="hidden" name="a" value="member">
		     
		        
			        <div class="row" style="margin-top: 20px;">
				        <div class="span1">
				        	小孩:
				        </div>
				        <div class="span2">
				        	<input type="text" name="childname" style="width: 100px;" value="<?php echo ($childname); ?>" placeholder="小孩"/>
				        </div>
				        <div class="span1">
				        	用户:
				        </div>
				        <div class="span2">
				        	<input type="text" name="username" style="width: 100px;" value="<?php echo ($username); ?>" placeholder="小孩用户"/>
				        </div>
				        <div class="span1">
							&nbsp;
						</div>
						<div class="span2">
							&nbsp;
						</div>
					</div>
				</span>
			   </div>
			   <div class="mb10"> 
		        <span class="mr20">
		        	<div class="row" style="margin-top: 20px;">
				        <div class="span1">
				        	称呼:
				        </div>
				        <div class="span2">
				        	<input type="text" name="appellation" style="width: 100px;" value="<?php echo ($appellation); ?>" placeholder="称呼"/>
				        </div>
		        		<div class="span1">
							手机号
						</div>
						<div class="span2">
							<input type="number" name="phone" style="width: 100px;" value="<?php echo ($phone); ?>" placeholder="手机号">
						</div>
						<div class="span1">
		        			&nbsp;
		        		</div>
		        		<div class="span2">
		        			&nbsp;
		        		</div>
					</div>
				</span>
			   </div>
			   
			   
			   <div class="mb10">
			   	<span class="mr20">
			   		<button class="btn btn-primary">搜索</button>
			   	</span>
			   </div>
		        
		        
		      
		    </div>
		  </form>
		<table class="table table-hover table-bordered">
			<thead>
				<tr>
					<th width="50">ID</th>
					<th>小孩</th>
					<th>用户</th>
					<th>称呼</th>
					<th>手机号</th>
					<th>操作</th>
				</tr>
			</thead>
			<tbody>
				<?php if(is_array($list)): foreach($list as $key=>$v): ?><tr>
						<td><?php echo ($v["id"]); ?></td>
						<td><?php echo ($v["childname"]); ?>(<?php echo ($v["childnickname"]); ?>)</td>
						<td><?php echo ($v["username"]); ?></td>
						<td><?php echo ($v["appellation"]); ?></td>
						<td><?php echo ($v["phone"]); ?></td>
						<td><a href="<?php echo U('classification/editmember',array('editid'=>$v[id]));?>"><?php echo L('EDIT');?></a></td>
					</tr><?php endforeach; endif; ?>
			</tbody>
		</table>
		<div class="pagination"><?php echo ($page); ?></div>
	</div>
	<script src="/ll/public/js/common.js"></script>
</body>
</html>