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
			<li class="active"><a href="<?php echo U('Loginrecord/loginrecordlist');?>">登录记录列表</a></li>
		</ul>
		<form class="well form-search" method="get" action="<?php echo U('Loginrecord/loginrecordlist');?>" id="form_submit">
		    <div class="search_type cc mb10">
		      <div class="mb10"> 
		        <span class="mr20">
		        <input type="hidden" name="g" value="Users">
		        <input type="hidden" name="m" value="Loginrecord">
		        <input type="hidden" name="a" value="loginrecordlist">
		        <input type="hidden" name="search" value="1">
			        <div class="row" style="margin-top: 20px;">
				        <div class="span2">
				        	用户名:
				        </div>
				        <div class="span3">
				        	<input type="text" name="uname1"  value="<?php echo ($uname); ?>" placeholder="请输入查找的用户名"/>
				        </div>
				        <div class="span2">
				        	手机号:
				        </div>
				        <div class="span3">
				        	<input type="text" name="phone"  value="<?php echo ($phone); ?>" placeholder="请输入查找的手机号"/>
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
				        <div class="span2">
				        	登录时间起始：
				        </div>
				        <div class="span3">
				        	<input type="text" name="startlogin_time"  class="input length_2 J_date" value="<?php if($startlogin_time) echo date('Y-m-d H:i:s',$startlogin_time) ?>" autocomplete="off" placeholder="请选择时间..." onClick="WdatePicker()" onfocus="WdatePicker({skin:'whyGreen',dateFmt:'yyyy-MM-dd HH:mm:ss'})">
				        </div>
						<div class="span2">
							登录时间结束：
						</div>	
						<div class="span3">
							<input type="text" name="endlogin_time"  class="input length_2 J_date" value="<?php if($endlogin_time) echo date('Y-m-d H:i:s',$endlogin_time) ?>" autocomplete="off" placeholder="请选择时间..." onClick="WdatePicker()" onfocus="WdatePicker({skin:'whyGreen',dateFmt:'yyyy-MM-dd HH:mm:ss'})">
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
				        <div class="span2">
				        	设备类型:
				        </div>
				        <div class="span3">
				        	<input type="text" name="app_version"  value="<?php echo ($app_version); ?>" placeholder="请输入查找的版本号"/>
				        </div>
		        		<div class="span2">
		        			设备标识符:
		        		</div>
		        		<div class="span3">
		        			<input type="text" name="device_name"  value="<?php echo ($device_name); ?>" placeholder="请输入查找的型号"/>
		        		</div>
		        		<div class="span2">
							<button class="btn btn-primary">搜索</button>
						</div>
					</div>
				</span>
			   </div>
			   <div class="mb10" style="text-align:right;">
			   	<span class="mr20">
			   		
			   	</span>
			   </div>
		        
		        
		      
		    </div>
		  </form>
			<table class="table table-hover table-bordered table-list">
				<thead>
					<tr>
						<th width="50">ID</th>
						<th>用户名</th>
						<th>手机号</th>
						<th width="120">登录时间</th>
						<th>设备类型，品牌</th>
						<th>设备标识符</th>
					</tr>
				</thead>
				<tbody>
					<?php if(is_array($loginrecordlist)): foreach($loginrecordlist as $key=>$vo): ?><tr>
						<td><?php echo ($vo["id"]); ?></td>
						<td><?php echo ($vo["uname"]); ?></a></td>
						<td><?php echo ($vo["phone"]); ?></td>
						<td><?php echo ($vo[login_time]); ?></td>
						<td><?php echo ($vo["app_version"]); ?></td>
						<td><?php echo ($vo["device_name"]); ?></td>
					</tr><?php endforeach; endif; ?>
				</tbody>
				
			</table>
		<div class="pagination"><?php echo ($page); ?></div>
	</div>
	<script src="/ll/public/js/common.js"></script>
</body>
</html>