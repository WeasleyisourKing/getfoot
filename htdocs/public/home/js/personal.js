$(document).ready(function(){
	//我的订单
	//隐藏列表
	$(".personalPro").hide();
	$(".personalList li").click(function(){
		$(".personalPro").hide();
		$(".personalPro").eq($(this).index()).fadeIn();
		if($(this).index()=="6"){
			$(".personalPro").eq($(this).index()).find(".personalPro_newAddress").hide();
		}else if($(this).index()=="5"){
			$(".personalPro").eq($(this).index()).find(".oderDetail").hide();
		}
		$('html , body').animate({scrollTop: 300},'slow');
	});
	$(".personalList li").eq(0).click();
	//显示新增地址
	$(".addressTitle .but1").click(function(){
		$(this).hide();
		$(".personalPro_newAddress").fadeIn();
	});
	$(".default").click(function(){
		if($(this).hasClass("default1")){
			$(this).removeClass("default1");
			$(this).attr("default","2");
		}else{
			$(this).addClass("default1");
			$(this).attr("default","1");
		}
	});
});


//浏览历史 加载
$(document).ready(function(){
	var Collection=localStorage.getItem("collection")?JSON.parse(localStorage.getItem("collection")):[];
	var lockProText=""
	var lockProLength=null
	if(Collection.length){
		if(Collection.length>5){
			lockProLength=5;
		}else{
			lockProLength=Collection.length
		}
		for (let i=0;i<lockProLength;i++) {
			lockProText +=`<li><a href="/details/${Collection[i].shopid}"><img src="${Collection[i].image}"  /></a></li>`
		};
		$(".lockPro").eq(0).html(lockProText);
	}
});

