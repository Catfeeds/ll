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
			<li><a href="<?php echo U('record/intention');?>"><?php echo L('ADMIN_INTENT_INDEX');?></a></li>
			<li><a href="<?php echo U('record/intention2');?>"><?php echo L('ADMIN_INTENTX_INDEX');?></a></li>
			<li class="active"><a href="<?php echo U('record/relation',array('id'=>$id,'type'=>$type));?>">关联意向课程</a></li>
		</ul>
		<button type="button" class="btn btn-primary" style="margin-bottom:20px;margin-left: 100px; " data-toggle="modal" data-target="#detail">查看意向详情</button>
		<form method="post" action="<?php echo U('record/relation_post');?>" class="form-horizontal js-ajax-form">
			<input type="hidden" name="id" value="<?php echo ($intention_info['id']); ?>">
			<input type="hidden" name="type" value="<?php echo ($type); ?>">
			<div class="control-group">
				<label class="control-label">课程列表</label>
				<div class="controls">
					<select name="course_id" id="course_id" >
					<option value="">请选择</option>
						<?php if(is_array($course)): foreach($course as $key=>$v): ?><option value="<?php echo ($v[id]); ?>" ig="<?php echo ($v['picture']); ?>" start_time="<?php echo ($v['start_time']); ?>" title="<?php echo ($v['title']); ?>" integral="<?php echo ($v['integral']); ?>" teacher="<?php echo ($v['tname']); ?>" <?php if($v[id] == $cinfo['id']): ?>selected<?php endif; ?> ><?php echo ($v['title']); ?></option><?php endforeach; endif; ?>
					</select>
				</div>
			</div>
	
				<div class="control-group">
					<label class="control-label">课程标题</label>
					<div class="controls">
						<input type="text" id="title" readonly value="<?php echo ($cinfo['title']); ?>">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">图片</label>
					<div class="controls">
						<div id="img2" style="width: 100px;height: 100px;<?php if(!empty($cinfo['picture'])): ?>background:url(/ll/data/upload/avatar/<?php echo ($cinfo['picture']); ?>) no-repeat center;<?php endif; ?> background-size: cover;"></div>
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">兑换积分</label>
					<div class="controls">
						<input type="text" readonly id="integral" value="<?php echo ($cinfo['integral']); ?>">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">讲师</label>
					<div class="controls">
						<input type="text" readonly id="teacher" value="<?php echo ($cinfo[tname]); ?>">
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">开课时间</label>
					<div class="controls">
						<input type="text" readonly id="start_time" value="<?php echo ($cinfo[start_time]); ?>">
					</div>
				</div>
				<div class="form-actions">
					<button type="submit" class="btn btn-primary js-ajax-submit">关联</button>
					<a class="btn" href="<?php echo U('record/intention');?>"><?php echo L('BACK');?></a>
				</div>
		</form>
	</div>	
		
			
			
	
<div class="modal fade" id="detail" style="top:300px;display: none;">
    <div class="modal-dialog" >
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">意向用户详细</h4>
            </div>
            <div class="modal-body">
       			上课学生：<?php echo ($intention_info['chname']); ?>
       			<br>
       			<!-- 选择型 -->
       			<?php if(empty($intention_info['content'])){ ?>
       			学段：<?php echo ($intention_info['grade']); ?>
       			<br>
       			科目：<?php echo ($intention_info['subject']); ?>
       			<br>
       			题型：<?php echo ($intention_info['question_type']); ?>
       			<br>
       			试题难度：<?php echo ($intention_info['question_difficulty']); ?>
       			<br>
       			希望上课时间：<?php echo ($intention_info['wanted_start_time']); ?>
       			<br>
       			希望上课老师：<?php echo ($intention_info['teacher']); ?>
       			<br>
       			班级类型：<?php echo ($intention_info['class_type']); ?>
       			<?php }else{ ?>
       				意向描述：<?php echo ($intention_info['content']); ?>
       			<?php } ?>	
       			
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">取 消</button>
            </div>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
	<script src="/ll/public/js/common.js"></script>
	<script type="text/javascript">
		$(function(){
			$("#course_id").change(function(){
				var ig = $(this).find("option:selected").attr("ig");
				var title = $(this).find("option:selected").attr("title");
				var start_time = $(this).find("option:selected").attr("start_time");
				var integral = $(this).find("option:selected").attr("integral");
				var teacher = $(this).find("option:selected").attr("teacher");
				$("#title").val(title);
				$("#start_time").val(start_time);
				$("#integral").val(integral);
				$("#teacher").val(teacher);
				$('#img2').css('background',
					'url(/ll/data/upload/avatar/'+ ig+') no-repeat center');
			});
		})
	</script>
</body>

</html>