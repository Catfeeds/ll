/**
 * Created by Administrator on 2017/6/18.
 */
$(function(){
	var starr=document.getElementsByClassName("starr")[0];
	var i = 1;
	var pic_url = $("#pic_url").val();
	var course_id = $("#course_id").val();
	var collect_url = $("#collect_url").val();
	var is_collect = $("#is_collect").val();
	var imgArr = [pic_url+"/images/shoucan.png",pic_url+"/images/yishoucan.png"];
	if(is_collect == 1){
    	starr.style.backgroundImage = "url('"+imgArr[1]+"')";
    }else{
    	starr.style.backgroundImage = "url('"+imgArr[0]+"')";
    }
	starr.addEventListener("click", function () {
	    
	    //加到后台
	    $.post(collect_url,
		{course_id : course_id},
	 	function(data){
	 		if(data[0] == "101"){
	 			 starr.style.backgroundImage = "url('"+imgArr[1]+"')";
	   			 //i++;
	 		}else if(data[0] == "103"){
	 			starr.style.backgroundImage = "url('"+imgArr[0]+"')";
	 		}
	 	})
	});
})
