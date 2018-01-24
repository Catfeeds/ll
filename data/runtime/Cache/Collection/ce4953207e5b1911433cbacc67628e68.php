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
<body>
	<div class="wrap js-check-wrap">
		<ul class="nav nav-tabs">
			<li class="active"><a href="<?php echo U('Collection/collectionlist');?>">收藏记录列表</a></li>
		</ul>
		<form class="well form-search" method="get" action="<?php echo U('Collection/collectionlist');?>" id="form_submit">
		    <div class="search_type cc mb10">
		      <div class="mb10"> 
		        
		        <input type="hidden" name="g" value="Collection">
		        <input type="hidden" name="m" value="Collection">
		        <input type="hidden" name="a" value="collectionlist">
			        <div style="display:inline;">
				        	用户名：
				        
				        	<input type="text" name="uname"  value="<?php echo ($uname); ?>" placeholder="请输入查找的用户名"/>
				    </div>
				    <div style="display:inline;margin-left: 20px;">    
				        	手机号：
				       
				        	<input type="text" name="uphone"  value="<?php echo ($uphone); ?>" placeholder="请输入查找的手机号"/>
				    </div>
				    <div style="display:inline;margin-left: 20px;">    
							课程名：
						
							<input type="text" name="ctitle"  value="<?php echo ($ctitle); ?>" placeholder="请输入查找的课程名"/>
					</div>	
			
			   </div>
			   <div class="mb10" style="margin-top: 20px;"> 
		        
		        	<div style="display:inline">
				        	收藏时间起始：
				        
				        	<input type="text" name="startcreatetime"  class="input length_2 J_date" value="<?php echo ($startcreatetime); ?>" autocomplete="off" placeholder="请选择时间..." onClick="WdatePicker()" onfocus="WdatePicker({skin:'whyGreen',dateFmt:'yyyy-MM-dd HH:mm:ss'})">
				    </div>
				    <div style="display:inline;margin-left: 20px;">    
							收藏时间结束：
						
						
							<input type="text" name="endcreatetime"  class="input length_2 J_date" value="<?php echo ($endcreatetime); ?>" autocomplete="off" placeholder="请选择时间..." onClick="WdatePicker()" onfocus="WdatePicker({skin:'whyGreen',dateFmt:'yyyy-MM-dd HH:mm:ss'})">
					</div>	
					<div  style="display:inline;margin-left: 20px;text-align: right;">
						<button class="btn btn-primary">搜索</button>
					</div>
				
			   </div>
			   
			   
		        
		        
		      
		    </div>
		  </form>
			<table class="table table-hover table-bordered table-list">
				<thead>
					<tr>
						<th width="50">ID</th>
						<th>课程名</th>
						<th>用户名</th>
						<th width="150">手机号</th>
						<th width="100">积分</th>
						<th width="100">课程所需积分</th>
						<th >收藏时间</th>
					</tr>
				</thead>
				<tbody>
					<?php if(is_array($list)): foreach($list as $key=>$vo): ?><tr>
						<td><?php echo ($vo["id"]); ?></td>
						<td><?php echo ($vo["ctitle"]); ?></a></td>
						<td><?php echo ($vo["uname"]); ?></td>
						<td><?php echo ($vo["uphone"]); ?></td>
						<td><?php echo ($vo["uintegral"]); ?></td>
						<td><?php echo ($vo["cintegral"]); ?></td>
						<td><?php echo ($vo["createtime"]); ?></td>
					</tr><?php endforeach; endif; ?>
				</tbody>
				
			</table>
		<div class="pagination"><?php echo ($page); ?></div>
	</div>
	<script src="/ll/public/js/common.js"></script>
</body>
</html>