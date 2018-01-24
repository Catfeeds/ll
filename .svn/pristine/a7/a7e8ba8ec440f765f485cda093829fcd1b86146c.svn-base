var pw = $("#pw").val();
//微信支付
$("#regist_go").click(function(){
	var goods = $(".am-active").children(".chongzhi_a").find(".goods").val();
	var price = $(".am-active").children(".chongzhi_a").find(".price").val();
	//提交支付
	$.post(pw,
	{goods : goods,price:price},
 	function(data){
 		if(data[0] == '101'){
 			window.location.href=data[1];
 		}
 	})
})
