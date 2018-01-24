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
			<li class="active"><a href="<?php echo U('User/userlist');?>">用户列表</a></li>
			<li><a href="<?php echo U('User/add');?>">新增用户</a></li>
		</ul>
		<form class="well form-search" method="get" action="<?php echo U('User/userlist');?>" id="form_submit">
		    <div class="search_type cc mb10">
		      <div class="mb10"> 
		        <span class="mr20">
		        <input type="hidden" name="g" value="Users">
		        <input type="hidden" name="m" value="User">
		        <input type="hidden" name="a" value="userlist">
		   <!--     <input type="hidden" name="leixing" value="1"> -->
		        	姓名:<input type="text" name="name" class="input-search" value="<?php echo ($name); ?>" placeholder="姓名"/>
		        	手机号:<input type="text" name="phone" class="input-search" value="<?php echo ($phone); ?>" placeholder="手机号">
		        	推荐人手机号:<input type="text" name="recommended_person" class="input-search" value="<?php echo ($recommended_person); ?>" placeholder="推荐人手机号">
		        	孩子姓名:<input type="text" name="chname" class="input-search" value="<?php echo ($chname); ?>" placeholder="孩子姓名">
					<button class="btn btn-primary">搜索</button>
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
						<th style="min-width: 45px;">积分</th>
						<th style="min-width: 120px;">推荐人手机号</th>
						<th style="min-width: 120px;">最后一次登录时间</th>
						<th>操作</th>
					</tr>
				</thead>
				<tbody>
					<?php if(is_array($userlist)): foreach($userlist as $key=>$vo): ?><tr>
						<td><?php echo ($vo["id"]); ?></td>
						<td><?php echo ($vo["name"]); ?></td>
						<td><?php echo ($vo["phone"]); ?></td>
						<td><?php echo ($vo["integral"]); ?></td>
						<td><?php echo ($vo["recommended_person"]); ?></td>
						<td><?php echo ($vo["last_login_time"]); ?></td>
						<td>
							<a href="<?php echo U('user/edit',array('id'=>$vo['id']));?>"><?php echo L('EDIT');?></a> |
							<a href="<?php echo U('user/delete',array('id'=>$vo['id']));?>" class="js-ajax-delete"><?php echo L('DELETE');?></a>|
							<a href="#" onclick="addsorce('<?php echo ($vo[id]); ?>','<?php echo ($vo[name]); ?>')" data-toggle="modal" data-target="#detail" >添加积分</a>
						</td>
					</tr><?php endforeach; endif; ?>
				</tbody>
				
			</table>
			<div class="modal fade" id="detail" style="top:70px;display: none;">
    <div class="modal-dialog" >
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">给用户添加积分</h4>
            </div>
            <div class="modal-body">
       			<form id="form1" action="<?php echo U('User/addsorce');?>" method="post">
       				<fieldset>
       				<input type="hidden" name="id" value="" >
	       				<div class="control-group">
							<label class="control-label">用户</label>
							<div class="controls">
								<input type="text" id="uname" value="" readonly >
							</div>
						</div>
						<div class="control-group">
							<label class="control-label">积分</label>
							<div class="controls">
								<input type="number" name="integral" value="">
							</div>
						</div>
						<div class="control-group">
							<label class="control-label">类型</label>
							<div class="controls">
								<select name="obtain_type">
									<option value="6">小孩表现好</option>
									<option value="7">小孩成绩好</option>
									<option value="8">其他</option>
								</select>
							</div>
						</div>
						<div class="control-group">
							<label class="control-label">备注</label>
							<div class="controls">
								<textarea name="content"></textarea>
							</div>
						</div>
       				</fieldset>
       			</form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取 消</button>
                <button type="button" onclick="submit1()" class="btn btn-default" data-dismiss="modal">确 认</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
		<div class="pagination"><?php echo ($page); ?></div>
	</div>
	<script src="/ll/public/js/common.js"></script>
	<script type="text/javascript">
		function addsorce(id,name){
			$("input[name=id]").val(id);
			$("#uname").val(name);
		}
		function myrefresh()
		{
      	 window.location.reload();
		}
		function submit1(){

			var data = $("#form1").serialize();
			$.post("<?php echo U('User/addsorce');?>",data,function(res){
				if(res=='1'){
					alert("积分不能为负数");
				}
				if(res=='2'){
					alert("添加积分成功");
					window.location.reload()
				}
				if(res == "3"){
					alert("该用户没有反馈过意见！");
				}
			});
			 setTimeout('myrefresh()',3000);
		}
	</script>
</body>
</html>