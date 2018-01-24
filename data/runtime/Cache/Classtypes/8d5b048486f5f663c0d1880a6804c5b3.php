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
.bu{
  margin-left: 10px;
 }
 .add_zhang{
    margin-left: 100px;
    margin-top: 20px;
 }
 .add_jie{
    margin-left: 100px;
    margin-top: 10px;
 }
  .list-name-input{  
   color: #333;  
   font-family: tahoma, 'Microsoft YaHei', 'Segoe UI', Arial, 'Microsoft Yahei', Simsun, sans-serif;  
   font-size: 15px;  
   font-weight: bold;  
   height: 50px;  
   margin: 0px;  
   padding: 0px;  
   position: relative;  
   width: 200px;  
  }  
  .list-name-for-select{  
   border: 0;  
   color: #555;  
   height: 20px;  
   lighting-color: rgb(255, 255, 255);  
   line-height: 20px;  
   margin:0 0 10px 0;    
    outline-color: #555;  
   outline-offset: 0px;  
   outline-style: none;  
   outline-width: 0px;   
    padding: 0px 0px;  
   position: absolute;  
   top: 1px;  
   left: 3px;  
   vertical-align: middle;  
   width: 200px;  
  }  
  .list-name-input-for-select:focus{  
   border: 0;  
   border-radius: 0;  
  }  
  .list-select{  
   background-color: #FFF;  
   border:1px #ccc solid;  
   border-radius: 4px;  
   color: #555;  
   cursor: pointer;  
   height: 30px;  
   left: 0px;  
   
   padding: 0px 0px;  
   position: absolute;  
   top: 0px;  
   vertical-align: middle;  
   white-space: pre;  
   width: 240px; 
   border:none;margin:-2px; 
  }  
 </style>
<link rel="stylesheet" type="text/css" href="/ll/public/css/addcourse.css" />
<body>
	<div class="wrap">
		<ul class="nav nav-tabs">
			<li><a href="<?php echo U('Textbook/textbooklist');?>">教科书列表</a></li>
			<li class="active"><a href="<?php echo U('Textbook/addtextbook');?>">新增教科书</a></li>
		</ul>
		<form method="post" class="form-horizontal js-ajax-form" action="<?php echo U('Textbook/add_post');?>">
			<fieldset>
				<div class="control-group">
					<label class="control-label">科目</label>
					<div class="controls">

     					<select type="text" name="subject" >
                  <option value="">请选择</option>
     						<?php if(is_array($subject)): foreach($subject as $key=>$v): ?><option value="<?php echo ($v['title']); ?>"><?php echo ($v[title]); ?></option><?php endforeach; endif; ?>
     					</select>

 					</div>
				</div>
				<div class="control-group">
					<label class="control-label">出版社</label>
					<div class="controls">

     					<select type="text" name="press" >
                <option value="">请选择</option>
     						<?php if(is_array($press)): foreach($press as $key=>$v): ?><option value="<?php echo ($v['title']); ?>"><?php echo ($v[title]); ?></option><?php endforeach; endif; ?>
     					</select>
 		
					</div>
				</div>
				<div class="control-group">
					<label class="control-label">学段</label>
					<div class="controls">
					 
     					<select type="text" name="grade">
                <option value="">请选择</option>
     						<?php if(is_array($grade)): foreach($grade as $key=>$v): ?><option value="<?php echo ($v['title']); ?>上学期"><?php echo ($v[title]); ?>上学期</option>
                  <option value="<?php echo ($v['title']); ?>下学期"><?php echo ($v[title]); ?>下学期</option><?php endforeach; endif; ?>
     					</select>
 				
					</div>
				</div>
			</fieldset>


    <button type="button"  onclick="add_zhang()" class="btn btn-link" >添加章</button>

      <div id="addchapter">
      <input type="hidden" name="i" value="">
      </div>
    
    <div class="form-actions">
      <button type="submit" class="btn btn-primary js-ajax-submit"><?php echo L('ADD');?></button>
        <a class="btn" href="<?php echo U('Textbook/textbooklist');?>"><?php echo L('BACK');?></a>
        <span id="a"></span>
    </div>
    </form>
	</div>
	<script src="/ll/public/js/common.js"></script>
	<script type="text/javascript">

var i=1;
function add_zhang(){
  $("#addchapter").append('<div class="row add_zhang rep" id="zz'+i+'">章标题：<input type="text" name="zhang'+i+'" > <button type="button" onclick="add_jie('+i+')" id="z'+i+'" class="btn btn-link">添加节</button><button type="button" class="btn btn-danger" onclick="del_div($(this))" >删除章</button></div>');
 i=++i;
 $("input[name=i]").val(i);
}

function add_jie(num){
  
  $("#zz"+num+"").append('<div id="j'+i+'" class="row add_jie rej"><div>节标题：<input type="text" name="jie'+num+'[]"  ><button type="button" class="btn btn-danger bu" onclick="del_div2($(this))" >删除节</button></div></div>');
}
function del_div(obj){
  var del = confirm("是否删除本章");
  if(!del){
    return false;
  }else{
    obj.parents(".rep").remove();
  }
  
}
function del_div2(obj){
  var del2=confirm("是否删除本节");
  if(!del2){
    return false;
  }else{
    obj.parents(".rej").remove();
  }
  
}

</script>
</body>

</html>