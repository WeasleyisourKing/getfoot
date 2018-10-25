$(document).ready(function(){
	$(".userTop div").eq(0).css("border-color","#4982a3");
	$(".userTop div").click(function(){
		$(".userTop div").css("border-color","rgba(0,0,0,0)");
		$(".userTop div").eq($(".userTop div").index(this)).css("border-color","#fdb3d3");
		$(".UserTog").hide();
		$(".UserTog").eq($(".userTop div").index(this)).show();
	});
	$(".toggleSingIn").click(function(){
		$(".userTop div").css("border-color","rgba(0,0,0,0)");
		$(".userTop div").eq(0).css("border-color","#4982a3");
		$(".UserTog").hide();
		$(".UserTog").eq(0).show();
	});
	$(".sigInBot div").eq(1).click(function(){
		$(".userTop div").css("border-color","rgba(0,0,0,0)");
		$(".userTop div").eq(1).css("border-color","#4982a3");
		$(".UserTog").hide();
		$(".UserTog").eq(1).show();
	})
	$("#showLogin").click(function(){
		$(".initialCipher").hide();
		$(".user").eq(0).show();
	})
	$("#showInitial").click(function(){
		console.log(1)
		$(".initialCipher").show();
		$(".user").eq(0).hide()
	})
})
