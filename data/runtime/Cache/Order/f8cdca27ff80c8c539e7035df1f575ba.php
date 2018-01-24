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
			<li class="active"><a href="<?php echo U('Order/weixinorderlist');?>"><?php echo L('ADMIN_ENRO_INDEX');?></a></li>
		</ul>
		<form class="well form-search" method="get" action="<?php echo U('Order/weixinorderlist');?>" id="form_submit">
		    <div class="search_type cc mb10">
		      <div class="mb10"> 
		        <span class="mr20">
		        <input type="hidden" name="g" value="Order">
		        <input type="hidden" name="m" value="Order">
		        <input type="hidden" name="a" value="weixinorderlist">
		     
		        
			        <div class="row" style="margin-top: 20px;">
				        <div class="span1">
				        	订单号:
				        </div>
				        <div class="span2">
				        	<input type="text" name="order_id" style="width: 100px;" value="<?php echo ($order_id); ?>" placeholder="订单号"/>
				        </div>
				        <div class="span1">
				        	用户手机号:
						</div>
						<div class="span2">
							<input type="text" name="uphone" style="width: 100px;" value="<?php echo ($uphone); ?>" placeholder="用户手机号"/>
						</div>
						<div class="span1">
							状态
						</div>
						<div class="span2">
							<select name="state">
								<option value="">请选择</option>
								<option value="99" <?php if($state == 99): ?>selected<?php endif; ?>>未支付</option>
								<option value="1" <?php if($state == 1): ?>selected<?php endif; ?>>支付成功</option>
								<option value="2" <?php if($state == 3): ?>selected<?php endif; ?>>支付失败</option>
							</select>
						</div>
					</div>
				</span>
			   </div>
			   	<div class="mb10"> 
		        <span class="mr20">
		        <div class="row" style="margin-top: 20px; ">
		        	<div style="display:inline;margin-left: 20px;">
				        	创建订单时间起始：
				        
				        	<input type="text" name="startcreatetime" class="input length_2 J_date" value="<?php echo ($startcreatetime); ?>" autocomplete="off" placeholder="请选择时间..." onClick="WdatePicker()" onfocus="WdatePicker({skin:'whyGreen',dateFmt:'yyyy-MM-dd HH:mm:ss'})">
				    </div>
				    <div style="display:inline;margin-left: 20px;">    
							创建订单时间结束：
						
						
							<input type="text" name="endcreatetime" class="input length_2 J_date" value="<?php echo ($endcreatetime); ?>" autocomplete="off" placeholder="请选择时间..." onClick="WdatePicker()" onfocus="WdatePicker({skin:'whyGreen',dateFmt:'yyyy-MM-dd HH:mm:ss'})">
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
					<th>订单号</th>
					<th>支付金额</th>
					<th>实际支付金额</th>
					<th>状态</th>
					<th>积分数量</th>
					<th>用户名</th>
					<th>用户手机号</th>
					<th><?php echo L('CTIME');?></th>
				</tr>
			</thead>
			<tbody>
				<?php if(is_array($list)): foreach($list as $key=>$list): ?><tr>
						<td><?php echo ($list["id"]); ?></td>
						<td><?php echo ($list["order_id"]); ?></td>
						<td><?php echo ($list["amount"]); ?></td>
						<td><?php echo ($list["pay_amount"]); ?></td>
						
						<td>
							<?php switch($list['state']){ case "0": echo "未支付"; break; case "1": echo "支付成功"; break; case "2": echo "支付失败"; break; } ?>
						</td>
						<td><?php echo ($list["integral"]); ?></td>
						<td><?php echo ($list["uname"]); ?></td>
						<td><?php echo ($list["uphone"]); ?></td>
						<td><?php echo ($list["createtime"]); ?></td>
					</tr><?php endforeach; endif; ?>
			</tbody>
		</table>
		<div class="pagination"><?php echo ($page); ?></div>
	</div>
	<script src="/ll/public/js/common.js"></script>
</body>
</html>