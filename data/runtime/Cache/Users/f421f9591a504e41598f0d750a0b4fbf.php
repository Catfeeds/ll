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
			<li class="active"><a href="<?php echo U('Scorecord/index');?>">积分记录列表</a></li>
		</ul>
		<form class="well form-search" method="get" action="<?php echo U('Scorecord/index');?>" id="form_submit">
		    <div class="search_type cc mb10">
		      <div class="mb10"> 
		        <span class="mr20">
		        <input type="hidden" name="g" value="Users">
		        <input type="hidden" name="m" value="Scorecord">
		        <input type="hidden" name="a" value="index">
		        
			        <div class="row" style="margin-top: 20px;">
				        <div class="span1">
				        	用户名:
				        </div>
				        <div class="span2">
				        	<input type="text" name="uname1" style="width: 100px;" value="<?php echo ($uname); ?>" placeholder="用户名"/>
				        </div>
				        <div class="span1">
				        	手机号:
				        </div>
				        <div class="span2">
				        	<input type="text" name="phone" style="width: 100px;" value="<?php echo ($phone); ?>" placeholder="手机号"/>
				        </div>
				        <!-- <div class="span1">
							类型:
						</div>
						<div class="span2">
							<select name="is_obtain" style="width: 100px;">
								<option value="">请选择</option>
								<option value="2" <?php if(2 == $is_obtain): ?>selected<?php endif; ?>   >使用</option>
								<option value="1" <?php if(1 == $is_obtain): ?>selected<?php endif; ?>>获取</option>
							</select>
						</div> -->
					</div>
				</span>
			   </div>
			   <div class="mb10"> 
		        <span class="mr20">
		        	<div class="row" style="margin-top: 20px;">
				        <div class="span1">
				        	积分:
				        </div>
				        <div class="span2">
				        	<input type="text" name="integral" style="width: 100px;" value="<?php echo ($integral); ?>" placeholder="积分"/>
				        </div>
		        		<!-- <div class="span1">
							剩余积分
						</div>
						<div class="span2">
							<input type="number" name="uscore" style="width: 100px;" value="<?php echo ($uscore); ?>">
						</div> -->
						<div class="span1">
		        			途径:
		        		</div>
		        		<div class="span2">
		        			<select name="obtain_type" style="width: 115px;">
	        					<option value="">请选择</option>
		        				<option value="99" <?php if(99 == $obtain_type): ?>selected<?php endif; ?>>认证</option>
		        				<option value="1" <?php if(1 == $obtain_type): ?>selected<?php endif; ?>>推荐用户使用</option>
		        				<option value="2" <?php if(2 == $obtain_type): ?>selected<?php endif; ?>>签到</option>
		        				<option value="3" <?php if(3 == $obtain_type): ?>selected<?php endif; ?>>意见反馈</option>
		        				<option value="4" <?php if(4 == $obtain_type): ?>selected<?php endif; ?>>购买</option>
		        				<option value="5" <?php if(5 == $obtain_type): ?>selected<?php endif; ?>>取消报名退还积分</option>
		        				<option value="6" <?php if(6 == $obtain_type): ?>selected<?php endif; ?>>小孩表现好</option>
		        				<option value="7" <?php if(7 == $obtain_type): ?>selected<?php endif; ?>>小孩成绩好</option>
		        				<option value="8" <?php if(8 == $obtain_type): ?>selected<?php endif; ?>>其他</option>
		        			</select>
		        		</div>
					</div>
				</span>
			   </div>
			   <div class="mb10"> 
		        <span class="mr20">
		        	<div class="row" style="margin-top: 20px;">
				        <div class="span2">
				        	创建时间起始：
				        </div>
				        <div class="span3">
				        	<input type="text" name="startcreatetime" class="input length_2 J_date" value="<?php echo ($startcreatetime); ?>" autocomplete="off" placeholder="请选择时间..." onClick="WdatePicker()" onfocus="WdatePicker({skin:'whyGreen',dateFmt:'yyyy-MM-dd HH:mm:ss'})">
				        </div>
						<div class="span2">
							创建时间结束：
						</div>	
						<div class="span3">
							<input type="text" name="endcreatetime" class="input length_2 J_date" value="<?php echo ($endcreatetime); ?>" autocomplete="off" placeholder="请选择时间..." onClick="WdatePicker()" onfocus="WdatePicker({skin:'whyGreen',dateFmt:'yyyy-MM-dd HH:mm:ss'})">
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
						<!-- <th>类型</th> -->
						<th>积分</th>
						<th>途径</th>
						<!-- <th width="45">剩余积分</th> -->
						<!-- <th width="120">推荐人手机号</th> -->
						<th>内容</th>
						<th width="120">创建时间</th>
						
					</tr>
				</thead>
				<tbody>
					<?php if(is_array($scorecord)): foreach($scorecord as $key=>$vo): ?><tr>
						<td><?php echo ($vo["id"]); ?></td>
						<td><?php echo ($vo["uname"]); ?></a></td>
						<td><?php echo ($vo["phone"]); ?></td>
						
						<td><?php echo ($vo["integral"]); ?></td>
						<td>
							<?php  switch($vo[obtain_type]){ case '0': echo "认证"; break; case '1': echo "推荐用户使用"; break; case '2': echo "签到"; break; case '3': echo "意见反馈"; break; case '4': echo "购买"; break; case '5': echo "取消报名退还积分"; break; case '6': echo "小孩表现好"; break; case '7': echo "小孩成绩好"; break; case '8': echo "其他"; break; } ?>
						</td>
						
						<td><?php echo ($vo["content"]); ?></td>
						<td><?php echo ($vo["createtime"]); ?></td>
					</tr><?php endforeach; endif; ?>
				</tbody>
				
			</table>
		<div class="pagination"><?php echo ($page); ?></div>
	</div>
	<script src="/ll/public/js/common.js"></script>
</body>
</html>