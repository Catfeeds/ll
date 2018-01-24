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
<style type="text/css">
	.xin1{
		width: 80px;
		margin-left: 20px;
		display:inline-block;
		text-align:center;
	}
</style>
<body>
	<div class="wrap js-check-wrap">
		<ul class="nav nav-tabs">
			<li class="active"><a href="<?php echo U('course/courselist');?>"><?php echo L('ADMIN_COURSE_INDEX');?></a></li>
			<li><a href="<?php echo U('course/addcourse');?>"><?php echo L('ADMIN_COURSE_ADD');?></a></li>
		</ul>
		<form class="well form-search" method="get" action="<?php echo U('course/courselist');?>" id="form_submit">
		    <div class="search_type cc mb10">
		      <div class="mb10"> 
		        <span class="mr20">
		        <input type="hidden" name="g" value="Testbase">
		        <input type="hidden" name="m" value="course">
		        <input type="hidden" name="a" value="courselist">
		        
			        <div class="row" style="margin-top: 20px;">
				        <div class="span1">
				        	标题:
				        </div>
				        <div class="span2">
				        	<input type="text" name="title" style="width: 100px;" value="<?php echo ($title); ?>" placeholder="标题"/>
				        </div>
				        <div class="span1">
				        	最大人数:
				        </div>
				        <div class="span2">
				        	<input type="text" name="rated_number" style="width: 100px;" value="<?php echo ($rated_number); ?>" placeholder="最大人数">
				        </div>
				        <div class="span1">
							最大积分:
						</div>
						<div class="span2">
							<input type="text" name="integral" style="width: 100px;" value="<?php echo ($integral); ?>" placeholder="最大积分">
						</div>
						<div class="span1">
							教师:
						</div>
						<div class="span2">
							<select name="teacher_id" style="width: 120px;">
								<option value="">请选择</option>
								<?php if(is_array($teacher)): foreach($teacher as $key=>$v): ?><option value="<?php echo ($v[id]); ?>" <?php if($teacher_id == $v[id]): ?>selected<?php endif; ?> ><?php echo ($v[name]); ?></option><?php endforeach; endif; ?>
							</select>
						</div>
					</div>
				</span>
			   </div>
			   <div class="mb10"> 
		        <span class="mr20">
		        	<div class="row" style="margin-top: 20px; ">
		        	<div style="display:inline;margin-left: 20px;">
				        	开课时间起始：
				        
				        	<input type="text" name="startcreatetime"  class="input length_2 J_date" value="<?php echo ($startcreatetime); ?>" autocomplete="off" placeholder="请选择时间..." onClick="WdatePicker()" onfocus="WdatePicker({skin:'whyGreen',dateFmt:'yyyy-MM-dd HH:mm:ss'})">
				    </div>
				    <div style="display:inline;margin-left: 20px;">    
							开课时间结束
						
						
							<input type="text" name="estart_time" class="input length_2 J_date" value="<?php echo ($estart_time); ?>" autocomplete="off" placeholder="请选择时间..." onClick="WdatePicker()" onfocus="WdatePicker({skin:'whyGreen',dateFmt:'yyyy-MM-dd HH:mm:ss'})">
					</div>
				       <button class="btn btn-primary" style="margin-left: 20px;">搜索</button>
					</div>
				</span>
			   </div>
			   
			   <div class="mb10" style="text-align:right;">
			   	<span class="mr20">
			   		
			   	</span>
			   </div>
		        
		        
		      
		    </div>
		  </form>
		<table class="table table-hover table-bordered center-table">
			<thead>
				<tr>
					<th width="50">ID</th>
					<th style="min-width:200px"><?php echo L('NAME');?></th>
					<th><?php echo L('TEACHER');?></th>
					<th><?php echo L('STARTIME');?></th>
					<th>意向人数</th>
					<th><?php echo L('PERSONCOUNT');?></th>
					<th>已报名人数</th>
					<th><?php echo L('CTIME');?></th>
					<th width="120"><?php echo L('ACTIONS');?></th>
				</tr>
			</thead>
			<tbody>
				<?php if(is_array($list)): foreach($list as $key=>$l): ?><tr>
						<td><?php echo ($l["id"]); ?></td>
						<td><?php echo ($l["title"]); ?></td>
						<td><?php echo ($l["teacher"]); ?></td>
						<td><?php echo ($l["start_time"]); ?></td>
						<td><a href="#" onclick="intention_num_info('<?php echo ($l["id"]); ?>')" data-toggle="modal" data-target="#intention_detail" ><?php echo ($l["intention_num"]); ?></a></td>
						<td><?php echo ($l["rated_number"]); ?></td>
						<td><a href="#" onclick="sign_up_num_info('<?php echo ($l["id"]); ?>')" data-toggle="modal" data-target="#sign_up_detail" ><?php echo ($l["sign_up_num"]); ?></a></td>
						<td><?php echo ($l["createtime"]); ?></td>
						<td><a href="<?php echo U('course/editcourse',array('editid'=>$l[id]));?>"><?php echo L('EDIT');?></a>|<a href="<?php echo U('course/delete',array('id'=>$l['id']));?>" class="js-ajax-delete"><?php echo L('DELETE');?></a>
						</td>
					</tr><?php endforeach; endif; ?>
			</tbody>
		<div class="modal fade" id="intention_detail" style="top:70px;display: none;">
		    <div class="modal-dialog" >
		        <div class="modal-content">
		            <div class="modal-header">
		                <h4 class="modal-title">意向人员信息</h4>
		            </div>
		            <div id="main2" class="modal-body">
		       			<div class="row" style="display:inline-block;">
		            		<div class="xin1">ID</div>
		       				<div class="xin1">小孩名</div>
		       				<div class="xin1">家长名</div>
		       				<div class="xin1">联系方式</div>
		            	</div>
		            </div>
		            <div class="modal-footer">
		                <button type="button" class="btn btn-default" data-dismiss="modal">取 消</button>
		            </div>
		        </div><!-- /.modal-content -->
		    </div><!-- /.modal-dialog -->
		</div><!-- /.modal -->
		<div class="modal fade" id="sign_up_detail" style="top:70px;display: none;">
		    <div class="modal-dialog" >
		        <div class="modal-content">
		            <div class="modal-header">
		                <h4 class="modal-title">已报名人员信息</h4>
		            </div>
		            <div id="main1" class="modal-body">
		            	<div class="row" style="display:inline-block;">
		            		<div class="xin1">ID</div>
		       				<div class="xin1">小孩名</div>
		       				<div class="xin1">家长名</div>
		       				<div class="xin1">联系方式</div>
		            	</div>
		       			
		            </div>
		            <div class="modal-footer">
		                <button type="button" class="btn btn-default" data-dismiss="modal">取 消</button>
		            </div>
		        </div><!-- /.modal-content -->
		    </div><!-- /.modal-dialog -->
		</div><!-- /.modal -->
		</table>
		<div class="pagination"><?php echo ($page); ?></div>
	</div>
	<script src="/ll/public/js/common.js"></script>
	<script type="text/javascript">
		function intention_num_info(id){
			//查询意向人员
			$.ajax({
			type: "POST",
			url: "<?php echo U('course/intention_num_info');?>",
			dataType : 'json',
			data: {
				id : id
			},
			success: function(res){
				//js遍历生成option
				$.each(res,function(i, val) {
			      
			        $("#main2").append('<div class="row" style="display:block;"><div class="xin1">'+val["uid"]+'</div><div class="xin1">'+val["chname"]+'</div><div class="xin1">'+val["uname"]+'</div><div class="xin1">'+val["uphone"]+'</div></div>');
			      
			    });
			},
		});
		}
		function sign_up_num_info(id){
			//查询已报名人员
			$.ajax({
			type: "POST",
			url: "<?php echo U('course/sign_up_num_info');?>",
			dataType : 'json',
			data: {
				id : id
			},
			success: function(res){
				//js遍历生成option
				$.each(res,function(i, val) {
			      
			        $("#main1").append('<div class="row" style="display:block;"><div class="xin1">'+val["uid"]+'</div><div class="xin1">'+val["chname"]+'</div><div class="xin1">'+val["uname"]+'</div><div class="xin1">'+val["uphone"]+'</div></div>');
			      
			    });
			},
		});
		}
	</script>
</body>
</html>