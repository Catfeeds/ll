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
	</style><?php endif; ?>
</head>
<body>
	<div class="wrap js-check-wrap">
		<ul class="nav nav-tabs">
			<li class="active"><a href="<?php echo U('Chapter/chapterlist');?>">章节列表</a></li>
			<li><a href="<?php echo U('Chapter/addchapter');?>">新增章节</a></li>
		</ul>
		<form class="well form-search" method="get" action="<?php echo U('Chapter/chapterlist');?>" id="form_submit">
		    <div class="search_type cc mb10">
		      <div class="mb10"> 
		        <span class="mr20">
		        <input type="hidden" name="g" value="Testbase">
		        <input type="hidden" name="m" value="Chapter">
		        <input type="hidden" name="a" value="chapterlist">
		        
			        <div class="row" style="margin-top: 20px;">
				        <div class="span1">
				        	标题:
				        </div>
				        <div class="span2">
				        	<input type="text" name="title" style="width: 100px;" value="<?php echo ($title); ?>" placeholder="标题"/>
				        </div>
				        <div class="span1">
				        	书名:
				        </div>
				        <div class="span2">
				        	<select name="textbook_id"  style="width: 120px;">
				        		<option value="">请选择</option>
				        		<?php if(is_array($textbook)): foreach($textbook as $key=>$v): ?><option value="<?php echo ($v[id]); ?>" <?php if($v[id] == $textbook_id): ?>selected<?php endif; ?> ><?php echo ($v["subject"]); ?></option><?php endforeach; endif; ?>
				        	</select>
				        </div>
				        <div class="span1">
							类型:
						</div>
						<div class="span2">
							<select name="is_chapter" style="width: 120px;">
								<option value="">请选择</option>
								<option value="2" <?php if(2 == $is_chapter): ?>selected<?php endif; ?>   >节</option>
								<option value="1" <?php if(1 == $is_chapter): ?>selected<?php endif; ?>>章</option>
							</select>
						</div>
					</div>
				</span>
			   </div>
			   
			   
			   <div class="mb10">
			   	<span class="mr20">
			   		<button class="btn btn-primary">搜索</button>
			   	</span>
			   </div>
		        
		        
		      
		    </div>
		  </form>
		<table class="table table-hover table-bordered">
			<thead>
				<tr>
					<th width="50">ID</th>
					<th>类型</th>
					<th>标题</th>
					<th>书名</th>
					<th>所属章</th>
					<th>创建时间</th>
					<th width="120"><?php echo L('ACTIONS');?></th>
				</tr>
			</thead>
			<tbody>
				<?php if(is_array($list)): foreach($list as $key=>$l): ?><tr>
						<td><?php echo ($l["id"]); ?></td>
						<td><?php echo empty($l[parent_id])?"章":"节" ?></td>
						<td><?php echo ($l["title"]); ?></td>
						<td><?php echo ($l["subject"]); ?></td>
						<td><?php echo empty($l[parent_title])?"本身为章":$l[parent_title] ?></td>
						<td><?php echo ($l["createtime"]); ?></td>
						<td><a href="<?php echo U('Chapter/editchapter',array('editid'=>$l[id]));?>"><?php echo L('EDIT');?></a>|<a href="<?php echo U('Chapter/delete',array('id'=>$l['id']));?>" class="js-ajax-delete"><?php echo L('DELETE');?></a>
						</td>
					</tr><?php endforeach; endif; ?>
			</tbody>
		</table>
		<div class="pagination"><?php echo ($page); ?></div>
	</div>
	<script src="/ll/public/js/common.js"></script>
</body>
</html>