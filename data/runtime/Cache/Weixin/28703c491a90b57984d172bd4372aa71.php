<?php if (!defined('THINK_PATH')) exit();?><!doctype html>
<html class="no-js">
<head>
<meta charset="utf-8">
<meta http-equiv="X-UA-Compatible" content="IE=edge">
<meta name="description" content="">
<meta name="keywords" content="">
<meta name="viewport"
	content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
<title>课程</title>
<link rel="stylesheet"
	href="/ll/themes/lailong/Public/font-awesome-4.7.0/css/font-awesome.css">
<link rel="stylesheet" href="/ll/themes/lailong/Public/css/weixin/amazeui.min.css">
<link rel="stylesheet" href="/ll/themes/lailong/Public/css/weixin/bdTel.css">
<link rel="stylesheet" href="/ll/themes/lailong/Public/css/weixin/course.css">
<script src="/ll/themes/lailong/Public/js/weixin/jquery.min.js"></script>
<!--<link rel="stylesheet" href="assets/css/app.css">-->
<style>
	@media all and (orientation: landscape) { 
		.txt{
			left:-50px;
		}
	}
.select ul {
	padding: 0;
}

.select ul li {
	list-style-type: none;
	text-align: center;
}

.styled-select {
	width: 96%;
	overflow: hidden;
}

.styled-select select {
	background: #fff;
	width: 268px;
	padding: 5px;
	font-size: 16px;
	border: 1px solid #ccc;
	height: 42px;
	-webkit-appearance: none; /*for chrome*/
}

.am-form-group {
	margin-bottom: 17px;
}

section .am-form div label {
	top: 8px;
}

form .am-form-group label {
	font-weight: 400;
}

</style>
</head>
<body>
	<!--切换-->

	<div data-am-widget="tabs" class="am-tabs am-tabs-default">
		<ul class="am-tabs-nav am-cf"
			style="position: fixed; top: 5px; left: calc(50% - 90px); z-index: 999">
			<li class="am-active"
				style="border: 1px solid; border-radius: 5px 0 0 5px; background: #fff;"><a
				href="[data-tab-panel-0]">排课计划</a></li>
			<li class=""
				style="border: 1px solid; border-left: none; border-radius: 0 5px 5px 0; background: #fff;"><a
				href="[data-tab-panel-1]">课程意向</a></li>
		</ul>
		<!-----------------------排课计划------------------------------------------------------->
		<div class="am-tabs-bd" style="border: none; margin-top: 40px;">
			<!--  <div data-tab-panel-0 class="am-tab-panel am-active">-->
			<div data-tab-panel-0
				class="am-cf am-intro-default am-tab-panel am-active"
				style="margin-top: 20px; padding: 5px 8px 0">
				<?php if(is_array($list)): foreach($list as $key=>$vo): ?><div class="am-intro-hd divbox"
					style="padding-bottom: 2px;/* <?php if($vo[nums] != 1): ?>display:none;<?php endif; ?> */">
					<input type="hidden" value="<?php echo ($vo["nums"]); ?>" class="nums" /> 
					<span><?php echo ($vo["start_month"]); echo ($vo["start_week"]); ?></span> 
					<strong style="border-right: none"><?php echo ($vo["time"]); ?></strong>
				</div>
				 <?php if(is_array($vo["list"])): foreach($vo["list"] as $k=>$v): if( $k == 0){; ?>
				<div class="am-g am-intro-bd"
					style="padding-top: 7px; padding-bottom: 7px;/* <?php if($vo[nums] != 1): ?>display:none;<?php endif; ?> */">
					<?php }else{ ?>
					<div class="am-g am-intro-bd"
						style="padding-top: 0px; padding-bottom: 7px;/* <?php if($vo[nums] != 1): ?>display:none;<?php endif; ?> */">
						<?php } ?>
						<a href="<?php echo U('Course/course_detail?id='); echo ($v["id"]); ?>">
							<div class="xq" style="background: #eff6ff; height: 65px;">
								<?php
 if($v[cover]){ $imgurl = $v[cover]; }else{ $imgurl = "/ll/themes/lailong/Public/images/math.png"; } ?>
								<div class="am-intro-left am-u-sm-2"
									style="width: 45px; height: 45px;border-radius:50%; margin: 10px 0 0 6px; background-image: url('<?php echo ($imgurl); ?>'); background-size: cover; background-position: 50% 50%;">
									<!--<?php if($v["cover"] != ''): ?><img style="width: 40px;height: 40px;" src="<?php echo sp_get_asset_upload_path('avatar/'.$v['cover']);?>" alt="">
		                            	<?php else: ?><img style="width: 40px;height: 40px;" src="/ll/themes/lailong/Public/images/math.png" alt=""><?php endif; ?>-->
								</div>
								<div class="am-intro-right am-u-sm-10 txt">
									<p
										style="font-size: 1.6rem; margin-top: 8px; max-height: 20px; overflow: hidden;"><?php echo ($v["title"]); ?></p>
									<p style="font-size: 1.4rem; margin-top: -13px;">
										讲师：<?php echo ($v["teacher"]); ?>&nbsp;&nbsp; &nbsp;开课时间：
										<?php if(date('H',strtotime($v[start_time])) > 12): $dian = date("H",strtotime($v[start_time])) - 12; echo "下午".$dian."点"; ?>
										<?php else: ?>
										<?php echo "上午".date("H",strtotime($v[start_time]))."点"; endif; ?>
									</p>
								</div>

							</div>
						</a>
					</div><?php endforeach; endif; endforeach; endif; ?>
			</div>
			<script>
            $(function(){
                $('.am-intro-hd').eq(1).next('.am-intro-bd').attr('padding','7px');
            })

        </script>
			<!-- 课程意向 -->
			<div data-tab-panel-1 class="am-tab-panel "
				style="background: #f4f5f7; padding: 0;">
				<section>
					<form class="am-form am-form-horizontal"
						action="<?php echo U('Course/course_sub');?>" method="post">
						<div class="am-form-group">
							<div class="am-u-sm-13" style="padding: 0; height: 44px;background:white">
								<label>科目</label>
								<div class="styled-select">
									<select name="km"
										style="width: 100%; height: 44px; color: #000; border: none; direction: rtl; appearance: none; -moz-appearance: none; -webkit-appearance: none;"
										id="sel_sub" required>
										<option value="">请选择</option>
										<?php if(is_array($clist)): foreach($clist as $key=>$vo): ?><option value="<?php echo ($vo["title"]); ?>"><?php echo ($vo["title"]); ?></option><?php endforeach; endif; ?>
									</select>
								</div>
								<span style="position: absolute;top: 13px;right:6px;font-size: 20px;color: black;"
						  class="am-list-date fa fa-angle-right" aria-hidden="true"></span>
							</div>
						</div>

						<div class="am-form-group" style="margin-top: -16px;">
							<div class="am-u-sm-13" style="padding: 0; height: 44px;background:white">
								<label>教材</label>
								<div class="styled-select">
									<select name="jc"
										style="width: 100%; height: 44px; color: #000; border: none; direction: rtl; appearance: none; -moz-appearance: none; -webkit-appearance: none;"
										id="sel_jc" >
										<option value="">请选择</option>
									</select>
								</div>
								<span style="position: absolute;top: 13px;right:6px;font-size: 20px;color: black;"
						  class="am-list-date fa fa-angle-right" aria-hidden="true"></span>
							</div>
						</div>
						<script>
                        $('#sel_sub').change(function(){
                            var sub = $('#sel_sub').val(); 
                            var url = "<?php echo U('Course/course_textbook');?>";
                            var d;
                            var x=0;
                            if(sub == ''){

                            }else{
                                $('#sel_jc').empty('option');
                                $('#sel_jc').append("<option value=''>请选择</option>");
                                    $.ajax({
                                        url : url,
                                        type : 'post',
                                        data : {'subj':sub},
                                        success : function(data){
                                             for (d in data){
                                                if(d == 'referer'|| d =='state'){

                                                }else{
                                                    x++;
                                                }
                                             }
                                             console.log(x);
                                            for(var i = 0; i<x ;i++){
                                                $('#sel_jc').append("<option value='"+data[i]['press']+"'>"+data[i]['press']+"</option>");
                                                console.log(data[i]['press']);
                                            }
                                        },
                                        error : function(e){
                                            console.log(e);
                                        }
                                    })
                            }
                        })
                    </script>
						<div class="am-form-group"
							style="margin-top: -16px;border-bottom：1px solid black;">
							<div class="am-u-sm-13" style="padding: 0; height: 44px;background:white">
								<label>学段</label>
								<div class="styled-select">
									<select name="xd"
										style="width: 100%; height: 44px; color: #000; border: none; direction: rtl; appearance: none; -moz-appearance: none; -webkit-appearance: none;"
										id="sel_xd" >
										<option value="">请选择</option>
									</select>
								</div>
								<span style="position: absolute;top: 13px;right:6px;font-size: 20px;color: black;"
						  class="am-list-date fa fa-angle-right" aria-hidden="true"></span>
							</div>
						</div>
						<script>
                    $('#sel_jc').change(function(){
                        var sub = $('#sel_sub').val();
                        var jc = $('#sel_jc').val();
                        var url = "<?php echo U('Course/course_pre');?>";
                        var d;
                        var x=0;
                        if(sub == '' || jc == ''){

                        } else{
                            $('#sel_xd').empty('option');
                            $('#sel_xd').append('<option value="">请选择</option>');
                                $.ajax({
                                    url : url,
                                    type : 'post',
                                    data : {'subj':sub,'jc':jc},
                                    success : function(data){
                                        for (d in data){
                                            if(d == 'referer'|| d =='state'){

                                            }else{
                                                x++;
                                            }

                                        }
                                        console.log(x);
                                        for(var i = 0; i<x ;i++){
                                            $('#sel_xd').append("<option value='"+data[i]['grade']+"'>"+data[i]['grade']+"</option>");
                                            console.log(data[i]['press']);
                                        }
                                    },
                                    error : function(e){
                                        console.log(e);
                                    }
                                })

                        }
                    })
                </script>
						<div class="am-form-group"
							style="margin-top: -16px;border-bottom：1px solid #ccc">
							<div class="am-u-sm-13" style="padding: 0; height: 44px;background:white">
								<label>章节</label>
								<div class="styled-select">
									<select name="zj"
										style="width: 100%; height: 44px; color: #000; border: none; direction: rtl; appearance: none; -moz-appearance: none; -webkit-appearance: none;"
										id="sel_zj" >
										<option value="">请选择</option>
									</select>
								</div>
								<span style="position: absolute;top: 13px;right:6px;font-size: 20px;color: black;"
						  class="am-list-date fa fa-angle-right" aria-hidden="true"></span>
							</div>
						</div>
						<script>
                        $('#sel_xd').change(function(){
                            var sub = $('#sel_sub').val();
                            var jc = $('#sel_jc').val();
                            var xd = $(this).val();
                            var url = "<?php echo U('Course/course_chapter');?>";
                            var d;
                            var x=0;
                            if(sub == '' || jc == '' || xd == ''){

                            } else{
                                $('#sel_zj').empty('option');
                                $('#sel_zj').append('<option value="">请选择</option>');
                                $.ajax({
                                    url : url,
                                    type : 'post',
                                    data : {'sub':sub,'pre':jc,'gra':xd},
                                    success : function(data){
                                        for (d in data){
                                            if(d == 'referer'|| d =='state'){

                                            }else{
                                                x++;
                                            }

                                        }
                                        console.log(x);
                                        for(var i = 0; i<x ;i++){
                                            $('#sel_zj').append("<option value='"+data[i]['title']+"'>"+data[i]['title']+"</option>");
                                            console.log(data[i]['press']);
                                        }
                                    },
                                    error : function(e){
                                        console.log(e);
                                    }
                                })

                            }
                        })
                    </script>
						<div class="am-form-group"
							style="margin-top: -16px;border-bottom：1px solid #ccc">
							<div class="am-u-sm-13" style="padding: 0; height: 44px;background:white">
								<label>二级章节</label>
								<div class="styled-select">
									<select name="erzj"
										style="width: 100%; height: 44px; color: #000; border: none; direction: rtl; appearance: none; -moz-appearance: none; -webkit-appearance: none;"
										id="sel_erzj" >
										<option value="">请选择</option>
									</select>
								</div>
								<span style="position: absolute;top: 13px;right:6px;font-size: 20px;color: black;"
						  class="am-list-date fa fa-angle-right" aria-hidden="true"></span>
							</div>
						</div>
						<script>
                        $('#sel_zj').change(function(){
                            var sub = $('#sel_sub').val();
                            var jc = $('#sel_jc').val();
                            var xd = $('#sel_xd').val();
                            var zj = $('#sel_zj').val();
                            var url = "<?php echo U('Course/course_jie');?>";
                            var d;
                            var x=0;
                            if(sub == '' || jc == '' || xd == '' || zj == '' ){

                            } else{
                                $('#sel_erzj').empty('option');
                                $('#sel_erzj').append('<option value="">请选择</option>');
                                $.ajax({
                                    url : url,
                                    type : 'post',
                                    data : {'sub':sub,'pre':jc,'gra':xd,'zj':zj},
                                    success : function(data){
                                        for (d in data){
                                            if(d == 'referer'|| d =='state'){

                                            }else{
                                                x++;
                                            }

                                        }
                                        console.log(x);
                                        for(var i = 0; i<x ;i++){
                                            $('#sel_erzj').append("<option value='"+data[i]['title']+"'>"+data[i]['title']+"</option>");
                                            console.log(data[i]['press']);
                                        } 
                                    },
                                    error : function(e){
                                        console.log(e);
                                    }
                                })

                            }
                        })
                    </script>
						<div class="am-form-group"
							style="margin-top: -16px;border-bottom：1px solid #ccc">
							<div class="am-u-sm-13" style="padding: 0; height: 44px;background:white">
								<label>题型</label>
								<div class="styled-select">
									<select name="tx"
										style="width: 100%; height: 44px; color: #000; border: none; direction: rtl; appearance: none; -moz-appearance: none; -webkit-appearance: none;"
										>
										<option value="">请选择</option>
										<?php if(is_array($txlist)): foreach($txlist as $key=>$vo): ?><option value="<?php echo ($vo["title"]); ?>"><?php echo ($vo["title"]); ?></option><?php endforeach; endif; ?>
									</select>
								</div>
								<span style="position: absolute;top: 13px;right:6px;font-size: 20px;color: black;"
						  class="am-list-date fa fa-angle-right" aria-hidden="true"></span>
							</div>
						</div>

						<div class="am-form-group"
							style="margin-top: -16px;border-bottom：1px solid #ccc">
							<div class="am-u-sm-13" style="padding: 0; height: 44px;background:white">
								<label>难度</label>
								<div class="styled-select">
									<select name="nd"
										style="width: 100%; height: 44px; color: #000; border: none; direction: rtl; appearance: none; -moz-appearance: none; -webkit-appearance: none;"
										>
										<option value="">请选择</option>
										<?php if(is_array($ndlist)): foreach($ndlist as $key=>$vo): ?><option value="<?php echo ($vo["title"]); ?>"><?php echo ($vo["title"]); ?></option><?php endforeach; endif; ?>
									</select>
								</div>
								<span style="position: absolute;top: 13px;right:6px;font-size: 20px;color: black;"
						  class="am-list-date fa fa-angle-right" aria-hidden="true"></span>
							</div>
						</div>

						<div class="am-form-group"
							style="margin-top: -16px;border-bottom：1px solid #ccc">
							<div class="am-u-sm-13" style="padding: 0; height: 44px;background:white">
								<label>题集</label>
								<div class="styled-select">
									<select name="tj"
										style="width: 100%; height: 44px; color: #000; border: none; direction: rtl; appearance: none; -moz-appearance: none; -webkit-appearance: none;"
										>
										<option value="">请选择</option>
										<?php if(is_array($tjlist)): foreach($tjlist as $key=>$vo): ?><option value="<?php echo ($vo["title"]); ?>"><?php echo ($vo["title"]); ?></option><?php endforeach; endif; ?>
									</select>
								</div>
								<span style="position: absolute;top: 13px;right:6px;font-size: 20px;color: black;"
						  class="am-list-date fa fa-angle-right" aria-hidden="true"></span>
							</div>
						</div>

						<div class="am-form-group"
							style="margin-top: -16px;border-bottom：1px solid #ccc">
							<div class="am-u-sm-13"
								style="padding: 0; height: 44px; background: #FFFFFF">
								<label>希望上课的时间</label> <input
									style="margin-left: 56%; width: 50%; height: 44px; line-height: 28px; border: none; appearance: none; -moz-appearance: none; -webkit-appearance: none; realFullFmt:'%Date %Time',minDate:'1900-01-01',maxDate:'2018-01-01',startDate:'%y-%M-%d',alwaysUseStartDate:false"
									type="date" name="times" class="am-radius" placeholder="任意">
							</div>
						</div>
						<div class="am-form-group"
							style="margin-top: -16px;border-bottom：1px solid #ccc">
							<div class="am-u-sm-13" style="padding: 0; height: 44px;background:white">
								<label>老师</label>
								<div class="styled-select">
									<select name="ls"
										style="width: 100%; height: 44px; color: #000; border: none; direction: rtl; appearance: none; -moz-appearance: none; -webkit-appearance: none;"
										>
										<option value="">请选择</option>
										<?php if(is_array($lslist)): foreach($lslist as $key=>$vo): ?><option value="<?php echo ($vo["title"]); ?>"><?php echo ($vo["title"]); ?></option><?php endforeach; endif; ?>
									</select>
								</div>
								<span style="position: absolute;top: 13px;right:6px;font-size: 20px;color: black;"
						  class="am-list-date fa fa-angle-right" aria-hidden="true"></span>
							</div>
						</div>

						<div class="am-form-group"
							style="margin-top: -16px;border-bottom：1px solid #ccc">
							<div class="am-u-sm-13" style="padding: 0; height: 44px;background:white">
								<label>班级类型</label>
								<div class="styled-select">
									<select name="bj"
										style="width: 100%; height: 44px; color: #000; border: none; direction: rtl; appearance: none; -moz-appearance: none; -webkit-appearance: none;"
										>
										<option value="">请选择</option>
										<?php if(is_array($bjlist)): foreach($bjlist as $key=>$vo): ?><option value="<?php echo ($vo["title"]); ?>"><?php echo ($vo["title"]); ?></option><?php endforeach; endif; ?>
									</select>
								</div>
								<span style="position: absolute;top: 13px;right:6px;font-size: 20px;color: black;"
						  class="am-list-date fa fa-angle-right" aria-hidden="true"></span>
							</div>
						</div>

						<div class="am-form-group"
							style="margin-top: -16px;border-bottom：1px solid #ccc">
							<div class="am-u-sm-13" style="padding: 0; height: 44px;background:white">
								<label>意向学生</label>
								<div class="styled-select">
									<select name="yx"
										style="width: 100%; height: 44px; color: #000; border: none; direction: rtl; appearance: none; -moz-appearance: none; -webkit-appearance: none;"
										required>
										<?php if(is_array($stulist)): foreach($stulist as $key=>$vo): ?><option value="<?php echo ($vo["id"]); ?>"><?php echo ($vo["name"]); ?></option><?php endforeach; endif; ?>
									</select>
								</div>
								<span style="position: absolute;top: 13px;right:6px;font-size: 20px;color: black;"
						  class="am-list-date fa fa-angle-right" aria-hidden="true"></span>
							</div>
						</div>

						<div class="am-form-group">
							<div class="am-u-sm-13" style="text-align: center">
								<p style="color: #a5a8a0; font-size: 12px; letter-spacing: 1px">
									<a href="<?php echo U('Course/write_application');?>" style="color: blue">还可以直接填写意向</a>
								</p>
							</div>
						</div>


						<div class="am-form-group">
							<div class="am-u-sm-13" style="padding: 0;">
								<button type="submit" class="am-btn am-btn-block" id="tijiao"
									style="background: #2adcaa; color: white; height: 50px; margin-top: -27px; border-radius: 3px">提交意向</button>
							</div>
						</div>

					</form>
				</section>
			</div>
		</div>
		<!-- <p style="text-align: center; color: #0e90d2;" class="select_f"
			name="1" id="service">点击加载更多</p> -->
		<!-- ----- -->
		<script type="text/javascript">
		function hiddenblock(){
			$('.divbox').each(function(){
				var num=$(this).find("input[type='hidden']").val();
				console.log($('.select_f').attr('name'));
				if($('.select_f').attr('name') == num){
					$(this).css('display','block');
					$(this).next().css('display','block');
				}
				
			})
		}
		hiddenblock();
        $('#tijiao').click(function(){
            var sub = $('#sel_sub').val();
            if(sub == ''){
                alert('请选择科目');
                return false;
            } 
            
        })
        //加载更多课程
$(".select_f").click(function(){
		var num=$(this).attr("name");
		var parsenum=parseInt(num)+1;
		$(this).attr("name",parsenum);
		hiddenblock();
     })
    </script>
	</div>

	<!-- 顶部背景色 -->
	<div
		style="width: 100%; background: #f4f5f7; position: fixed; top: 0; height: 54px; z-index: 200;">

	</div>
	<footer style="overflow: hidden; z-index: 999">
		<div data-am-widget="navbar"
			class="am-navbar am-cf am-navbar-default " id="">
			<ul class="am-navbar-nav am-cf am-avg-sm-4"
				style="background: #fbfbfb;">
				<li><a href="<?php echo U('Course/course');?>"> <img class="show"
						src="/ll/themes/lailong/Public/images/course1.png" alt="课程" /> <img
						style="display: none" class="hide"
						src="/ll/themes/lailong/Public/images/coursed.png" alt="课程" /> <span
						class="am-navbar-label">课程</span>
				</a></li>
				<li><a href="<?php echo U('Mine/server');?>"> <img class="show1"
						src="/ll/themes/lailong/Public/images/server.png" alt="管家服务" /> <img
						style="display: none" class="hide1"
						src="/ll/themes/lailong/Public/images/servered.png" alt="服务" /> <span
						class="am-navbar-label txt1">管家服务</span>
				</a></li>
				<li><a href="<?php echo U('Mine/my');?>"> <img class="show2"
						src="/ll/themes/lailong/Public/images/my.png" alt="我的" /> <img
						style="display: none" class="hide2"
						src="/ll/themes/lailong/Public/images/myd.png" alt="我的" /> <span
						class="am-navbar-label txt2">我的</span>
				</a></li>
			</ul>
		</div>

	</footer>
	<!--[if (gte IE 9)|!(IE)]><!-->
	<!--<![endif]-->
	<!--[if lte IE 8 ]>
<!--<script src="http://libs.baidu.com/jquery/1.11.1/jquery.min.js"></script>-->
	<![endif]-->
	<script src="/ll/themes/lailong/Public/js/weixin/amazeui.min.js"></script>
	<script src="/ll/themes/lailong/Public/js/weixin/course.js"></script>


</body>
</html>