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
<link rel="stylesheet" type="text/css" href="/ll/public/css/addcourse.css" />
<body>
	<div class="wrap">
		<ul class="nav nav-tabs">
			<li ><a href="<?php echo U('order/orderlist');?>"><?php echo L('ADMIN_ENRO_INDEX');?></a></li>
		</ul>
		<form method="post" class="form-horizontal js-ajax-form" action="<?php echo U('order/agreecancelornot');?>">
			<input type="hidden" name="editid" value="<?php echo ($list["id"]); ?>"/>
			<fieldset>
				<div class="control-group">
					<label class="control-label"><?php echo L('ORDER_SN');?></label>
					<div class="controls">
						<input type="text" readonly value="<?php echo ($list["order_id"]); ?>">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label"><?php echo L('COURSE');?></label>
					<div class="controls">
						<input type="text" readonly value="<?php echo ($list["title"]); ?>">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label"><?php echo L('CANCELREASON');?></label>
					<div class="controls">
						<textarea name="desc"style="width:300px;height:100px;" disabled><?php echo ($list["note"]); ?></textarea>
					</div>
				</div>
				<?php if($list['state']=='1'&&$list['cancel_state']=='1'){ ?>
					<div class="control-group">
						<label class="control-label"><?php echo L('操作');?></label>
						<div class="controls">
							<select name="state" id="state"><option></option><option value="0">拒绝</option><option value="1">批准</option></select>
						</div>
					</div>
					<div class="control-group Xx" style="display: none" >
						<label class="control-label">备注:</label>
						<div class="controls">
							<input type="hidden" value="<?php echo ($param); ?>" name="param"/>
							<textarea id="desc" name="text_state" disabled="disabled" style="width:300px;height:100px;"></textarea>
						</div>
					</div>
				<?php } ?>
				<?php if($list['cancel_state']=='2'){ ?>

					<div class="control-group">
						<label class="control-label">订单申请状况</label>
						<div class="controls">
							<input type="text" readonly value="<?php if($list['state']==4){ ?> 已同意申请<?php }else{ ?>已拒绝申请<?php } ?>">
						</div>
					</div>
				<?php } ?>
			</fieldset>
			<div class="form-actions">
			<?php if($list['state']=='1'&&$list['cancel_state']=='1'){ ?>
				<button type="submit" class="btn btn-primary js-ajax-submit"><?php echo L('确定');?></button>
			<?php } ?>
				<a class="btn" href="<?php echo U('order/orderlist');?>"><?php echo L('BACK');?></a>
			</div>
		</form>
	</div>
	<script src="/ll/public/js/common.js"></script>
</body>
<script type="text/javascript">
$('#state').change(function(){
	if($(this).find("option:selected").val() == 0){
		$(".Xx").css('display','block');
		$('#desc').attr('disabled',false);
	}else{
		$(".Xx").css('display','none');
		$('#desc').attr('disabled',true);
	}
})
</script>
</html>