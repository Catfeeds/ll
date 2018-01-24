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
			<li class="active"><a href="<?php echo U('Order/orderlist');?>"><?php echo L('ADMIN_ENRO_INDEX');?></a></li>
		</ul>
		<form class="well form-search" method="get" action="<?php echo U('Order/orderlist');?>" id="form_submit">
		    <div class="search_type cc mb10">
		      <div class="mb10"> 
		        <span class="mr20">
		        <input type="hidden" name="g" value="Order">
		        <input type="hidden" name="m" value="Order">
		        <input type="hidden" name="a" value="orderlist">
		     
		        
			        <div class="row" style="margin-top: 20px;">
				        <div class="span1">
				        	订单号:
				        </div>
				        <div class="span2">
				        	<input type="text" name="order_id" style="width: 100px;" value="<?php echo ($order_id); ?>" placeholder="订单号"/>
				        </div>
				        <div class="span1">
				        	课程名:
						</div>
						<div class="span2">
							<input type="text" name="ctitle" style="width: 100px;" value="<?php echo ($ctitle); ?>" placeholder="课程名"/>
						</div>
						<div class="span1">
							状态
						</div>
						<div class="span2">
							<select name="state">
								<option value="">请选择</option>
								<option value="99" <?php if($state == 99): ?>selected<?php endif; ?>>未支付</option>
								<option value="1" <?php if($state == 1): ?>selected<?php endif; ?>>已支付待确认</option>
								<option value="3" <?php if($state == 3): ?>selected<?php endif; ?>>已完成</option>
								<option value="4" <?php if($state == 4): ?>selected<?php endif; ?>>已取消</option>
							</select>
						</div>
					</div>
				</span>
			   </div>
			   <div class="mb10">
			   	<span class="mr20">
			   		<div class="row" style="margin-top: 20px;">
				        <div class="span1">
				        	学生名:
				        </div>
				        <div class="span2">
				        	<input type="text" name="chname" style="width: 100px;" value="<?php echo ($chname); ?>" placeholder="学生名"/>
				        </div>
				        <div class="span1">
				        	手机号:
						</div>
						<div class="span2">
							<input type="text" name="uphone" style="width: 100px;" value="<?php echo ($uphone); ?>" placeholder="手机号"/>
						</div>
					</div>
			   	</span>
			   	</div>
			   	<div class="mb10"> 
		        <span class="mr20">
		        <div class="row" style="margin-top: 20px; ">
		        	<div style="display:inline;margin-left: 20px;">
				        	创建订单时间起始：
				        
				        	<input type="text" name="screatetime" class="input length_2 J_date" value="<?php echo ($screatetime); ?>" autocomplete="off" placeholder="请选择时间..." onClick="WdatePicker()" onfocus="WdatePicker({skin:'whyGreen',dateFmt:'yyyy-MM-dd HH:mm:ss'})">
				    </div>
				    <div style="display:inline;margin-left: 20px;">    
							创建订单时间结束：
						
						
							<input type="text" name="ecreatetime" class="input length_2 J_date" value="<?php echo ($ecreatetime); ?>" autocomplete="off" placeholder="请选择时间..." onClick="WdatePicker()" onfocus="WdatePicker({skin:'whyGreen',dateFmt:'yyyy-MM-dd HH:mm:ss'})">
					</div>
				       <button class="btn btn-primary" style="margin-left: 20px;">搜索</button>
					</div>
		        	
				</span>
			   </div>

		        
		        
		      
		    </div>
		  </form>
		<table class="table table-hover table-bordered">
			<thead>
				<tr>
					<th width="50">ID</th>
					<th><?php echo L('ORDER_SN');?></th>
					<th><?php echo L('COURSE');?></th>
					<th><?php echo L('CHILD');?></th>
					<th><?php echo L('PAYWAY');?></th>
					<th><?php echo L('CANCELSTATE');?></th>
					<th><?php echo L('CAOZUO');?></th>
					<th><?php echo L('CTIME');?></th>
					<th width="120"><?php echo L('ACTIONS');?></th>
				</tr>
			</thead>
			<tbody>
				<?php if(is_array($list)): foreach($list as $key=>$list): ?><tr>
						<td><?php echo ($list["id"]); ?></td>
						<td><?php echo ($list["order_id"]); ?></td>
						<td><?php echo ($list["coursename"]); ?></td>
						<td><?php echo ($list["childname"]); ?></td>
						<td>
							<?php if($list[state] == 0): ?>未支付<?php elseif($list[state] == 1): ?>已支付待确认<?php elseif($list[state] == 3): ?>已完成<?php elseif($list[state] == 4): ?>已取消<?php endif; ?>
						</td>
						<td>
							<?php if($list[cancel_state] == 1): ?>订单申请取消<a href="<?php echo U('order/ordercancel',array('orderid'=>$list[id]));?>">(查看)</a>
							<?php elseif($list[cancel_state] == 2 && $list[state] != 4): ?>订单取消被拒绝
							<?php elseif($list[cancel_state] == 0): ?>未申请
							<?php elseif($list[cancel_state] == 2 && $list[state] == 4): ?>订单已取消<?php endif; ?>
						</td>
						<td><?php echo ($list["username"]); ?></td>
						<td><?php echo ($list["createtime"]); ?></td>
						<td><a href="<?php echo U('order/editorder',array('orderid'=>$list[id]));?>">编辑</a>
						<?php if($list[state]=='1'){ ?>
						|<a href="#" onclick="xiugai('<?php echo ($list[id]); ?>')" >确认</a></td>
						<?php } ?>
						

					</tr><?php endforeach; endif; ?>
			</tbody>
		</table>
		<div class="pagination"><?php echo ($page); ?></div>
	</div>
	<script src="/ll/public/js/common.js"></script>
	<script type="text/javascript">
		function xiugai(id){
			$.ajax({
				type: "POST",
				url: "<?php echo U('order/change');?>",
				 data: {id:id},
				dataType : 'json',
				success: function(res){
					if(res=='1'){
						alert("修改成功");
						
					}
					if(res=='2'){
						alert("修改失败");
					}
					window.location.reload();
				},
				});
		}
	</script>
</body>
</html>