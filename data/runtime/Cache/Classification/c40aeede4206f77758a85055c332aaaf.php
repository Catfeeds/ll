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
			<li class="active"><a href="<?php echo U('classification/childlist');?>">小孩列表</a></li>
			<li><a href="<?php echo U('classification/addchild');?>">新增孩子</a></li>
		</ul>
		<form class="well form-search" method="get" action="<?php echo U('classification/childlist');?>" id="form_submit">
		    <div class="search_type cc mb10">
		      <div class="mb10"> 
		        <span class="mr20">
		        <input type="hidden" name="g" value="Classification">
		        <input type="hidden" name="m" value="classification">
		        <input type="hidden" name="a" value="childlist">
		     
		        
			        <div class="row-fluid" style="margin-top: 20px;">
				        <div class="span1">
				        	小孩真名:
				        </div>
				        <div class="span2">
				        	<input type="text" name="name" style="width: 100%;" value="<?php echo ($name); ?>" placeholder="小孩真名"/>
				        </div>
				        <div class="span1">
				        	小孩昵称:
				        </div>
				        <div class="span2">
				        	<input type="text" name="nickname1" style="width: 100%;" value="<?php echo ($nickname); ?>" placeholder="小孩昵称"/>
				        </div>
				        <div class="span1">
							性别:
						</div>
						<div class="span2">
							<select name="gender1" style="width: 100%;">
								<option value="">请选择</option>
								<option value="3" <?php if(3 == $gender): ?>selected<?php endif; ?>>未知</option>
								<option value="1" <?php if(1 == $gender): ?>selected<?php endif; ?>>男</option>
								<option value="2" <?php if(2 == $gender): ?>selected<?php endif; ?>>女</option>
							</select>
						</div>
						<div class="span3">
							&nbsp;
						</div>
					</div>
				</span>
			   </div>
			   <div class="mb10"> 
		        <span class="mr20">
		        	<div class="row-fluid" style="margin-top: 20px;">
				        <div class="span1">
				        	学校:
				        </div>
				        <div class="span2">
				        	<input type="text" name="school1" style="width: 100%;" value="<?php echo ($school); ?>" placeholder="学校"/>
				        </div>
		        		<div class="span1">
							年级
						</div>
						<div class="span2">
							<input type="text" name="grade1" style="width: 100%;" value="<?php echo ($grade); ?>" placeholder="年级">
						</div>
						<div class="span1">
		        			认证状态:
		        		</div>
		        		<div class="span2">
		        			<select name="vip_state1" style="width: 100%;">
	        					<option value="" >请选择</option>
		        				<option value="99" <?php if(99 == $vip_state): ?>selected<?php endif; ?>>未认证</option>
		        				<option value="1" <?php if(1 == $vip_state): ?>selected<?php endif; ?>>认证中</option>
		        				<option value="2" <?php if(2 == $vip_state): ?>selected<?php endif; ?>>认证失败</option>
		        				<option value="3" <?php if(3 == $vip_state): ?>selected<?php endif; ?>>认证成功</option>
		        			</select>
		        		</div>
		        		<div class="span3">
							&nbsp;
						</div>
					</div>
				</span>
			   </div>
			   <div class="mb10"> 
		        <span class="mr20">

		        	<div class="row-fluid" style="margin-top: 20px;">
		        	<div class="span1" >
				        	生日起始：
				    </div>
				    <div class="span2">
				    	<input type="text" style="width: 100%;" name="startbirthday1"  class="input length_2 J_date" value="<?php echo ($startbirthday); ?>" autocomplete="off" placeholder="请选择时间..." onClick="WdatePicker()" onfocus="WdatePicker({skin:'whyGreen',dateFmt:'yyyy-MM-dd HH:mm:ss'})">
				    </div>    
				        	
				    
				    <div class="span1">    
							生日结束：
					</div>	
					<div class="span2">
						<input type="text" style="width: 100%;" name="endbirthday1"  class="input length_2 J_date" value="<?php echo ($endbirthday); ?>" autocomplete="off" placeholder="请选择时间..." onClick="WdatePicker()" onfocus="WdatePicker({skin:'whyGreen',dateFmt:'yyyy-MM-dd HH:mm:ss'})">
					</div>
							
					
						<div class="span3" style="text-align: left;">
							<button class="btn btn-primary">搜索</button>
						</div>
				        
					</div>
				</span>
			   </div>
			   
			   
		        
		        
		      
		    </div>
		  </form>
		<table class="table table-hover table-bordered">
			<thead>
				<tr>
					<th width="50">ID</th>
					<th>小孩真名（昵称）</th>
					<th><?php echo L('ICON');?></th>
					<th>生日</th>
					<th>性别</th>
					<th>学校名字</th>
					<th>年级</th>
					<th>是否会员</th>
					<th>操作</th>
				</tr>
			</thead>
			<tbody>
				<?php if(is_array($list)): foreach($list as $key=>$v): ?><tr>
						<td><?php echo ($v["id"]); ?></td>
						<td><?php echo ($v["name"]); ?>（<?php echo ($v["nickname"]); ?>）</td>
						<td><?php if(!empty($v[avatar])): ?><div style="width: 50px;height: 50px; background: url(/ll/data/upload/avatar/<?php echo ($v["avatar"]); ?>) no-repeat center;background-size: cover;"></div><?php endif; ?></td>
						<td><?php echo ($v["birthday"]); ?></td>
						<td><?php switch($v['gender']){ case '0': echo "未知"; break; case '1': echo "男"; break; case '2': echo "女"; break; } ?></td>
						<td><?php echo ($v["school"]); ?></td>
						<td><?php echo ($v["grade"]); ?></td>
						<td><?php switch($v['vip_state']){ case '0': echo "未认证"; break; case '1': echo "认证中"; break; case '2': echo "认证失败"; break; case '3': echo "认证成功"; break; } ?> <?php if($v['vip_state']=='1'){ ?> <a onclick="xiugai('<?php echo ($v[id]); ?>','1')" href="#">批准</a>|<a href="#" onclick="xiugai('<?php echo ($v[id]); ?>','2')">拒绝</a> <?php } ?> </td>
						<td><a href="<?php echo U('classification/editchild',array('editid'=>$v[id]));?>"><?php echo L('EDIT');?></a></td>
					</tr><?php endforeach; endif; ?>
			</tbody>
		</table>
		<div class="pagination"><?php echo ($page); ?></div>
	</div>
	<script src="/ll/public/js/common.js"></script>
	<script type="text/javascript">
		function xiugai(id,type){
		$.ajax({
				type: "POST",
				url: "<?php echo U('classification/changechild');?>",
				 data: {id:id, type:type},
				dataType : 'json',
				success: function(res){
					if(res=="1"){
						alert("修改成功");
					
					}
					if(res=="2"){
						alert("未绑定用户");
					}
					if(res!="1"&&res!="2"){
						alert("修改失败");
					}
				window.location.reload();
				},
				});

				

			
		}

	</script>
</body>
</html>