

$(document).ready(function () {
    //	购物车
    $(".joinChoice").click(function () {
        if ($(this).hasClass("joinChoiceShow")) {
            $(this).removeClass("joinChoiceShow");
        } else {
            $(this).addClass("joinChoiceShow");
        }
    });
    //topNav
    $(".classify ul li").mouseenter(function () {
    	$(".classifyPro ").stop(true,true).hide();
        $(".classifyPro ").eq($(this).index()).fadeIn()
    }).mouseleave(function () {
    	$(".classifyPro ").stop(true,true).fadeOut();
    });
    $(".classifyPro ").mouseenter(function () {
        $(this).stop(true,true).fadeIn()
    }).mouseleave(function () {
        $(this).stop(true,true).fadeOut()
    });
    $(".category li").mouseenter(function () {
    	$(".categoryBtn").stop(true,true).hide();
        $(this).find(".categoryBtn").fadeIn()
    }).mouseleave(function () {
    	$(".categoryBtn ").stop(true,true).fadeOut();
    });
    //图标
    $(".icoPro img:odd").hide();
    $(".icoPro").mouseenter(function () {
        $(this).children("img").hide();
        $(this).children("img").eq(1).show();
    }).mouseleave(function () {
        $(this).children("img").hide();
        $(this).children("img").eq(0).show();
    });
    //drinks首页背景色
    var Drinklength = $(".Drinks").children().length
    var DrinkColor = ["f3cd8e", "fdb3d4", "acdcf0", "f5538e", "acdcf0", "aeeebf", "fcd947", "d8affd"]
    for (var i = 0; i < Drinklength; i++) {
        $(".DrinksPro").eq(i).css("background", "#" + DrinkColor[i % 8]);
    }
    ;
    //首页商品列表交互效果
    $(".DrinksPro").mouseenter(function () {
    		$(".DrinksShow").stop().hide();
        $(this).children(".DrinksShow").fadeIn()
    }).mouseleave(function () {
        $(this).children(".DrinksShow").hide()
    });
    $("img").eq($("img").length).ready(function () {
        $(".DrinksShow").css("height", $(".Drinks .am-u-sm-3").height() + "px");
    });
    //商品列表标题单双行换色
    $(".DrinksTitle:even").css("background", "#fdb3d4");
    //收藏安心点击效果
    $(" .title img:odd").hide();
    $(" .title ").find("img").click(function () {
        $(this).siblings().show();
        $(this).hide();
    });
    $(" .detailsIco li img:odd").hide();
    $(" .detailsIco li").mouseenter(function () {
        $(this).find("img").eq(0).hide();
        $(this).find("img").eq(1).show();
    }).mouseleave(function () {
        $(this).find("img").eq(1).hide();
        $(this).find("img").eq(0).show();
    });
    //商品聚合页列表交互效果
    $(".snacksShow").hide()
    $(".snacksPro").mouseenter(function () {
        $(this).find(".snacksShow").fadeIn()
    }).mouseleave(function () {
        $(".snacksShow").hide()
    });
    $(".categoryTitle:odd").css("background", "#acddef");
    $(".category:odd li,.category:odd").css("border-color", "#acddef");
    $(".categoryNav a:odd").css("background", "#acddef");
    $(".labelbox:odd").css("background", "#ffffff");
    //商品详情页加减按钮
    $(".increase").click(function () {
        var number = $(this).siblings(".productNumber").html()
        $(this).siblings(".productNumber").html(parseInt(number) + 1)
        $("#addCart").attr("data-number",parseInt(number) + 1)
    });
    $(".reduce").click(function () {
        var number = $(this).siblings(".productNumber").html()
        if (parseInt(number) == 1) {
        } else {
            $(this).siblings(".productNumber").html(parseInt(number) - 1)
        $("#addCart").attr("data-number",parseInt(number) - 1)
        }
    });
    //购物车全选按钮
    $(".allTotal").data("allPlay", "false");
    $(".allTotal").click(function () {
        if ($(this).data("allPlay") == "false") {
            $(this).data("allPlay", "ture");
            $(".cartBox .labelbox .joinChoice").addClass("joinChoiceShow");
            $(this).addClass("allTo")
        } else {
            $(".allTotal").data("allPlay", "false");
            $(".cartBox .labelbox .joinChoice").removeClass("joinChoiceShow");
            $(this).removeClass("allTo");
        }
        ;
    });

    $(".joinChoice,.cartBox .but,.allTotal").click(function () {
        Valuation()
    });
    $(".personalList li img:odd").hide();
    $(".personalList li").click(function () {
        $(".personalList li img").show();
        $(".personalList li img:odd").hide();
        $(".personalList li").removeClass("personalShow");
        $(this).find("img").show();
        $(this).find("img").eq(0).hide();
        $(this).addClass("personalShow");
    });
    $(".oderNav li").click(function () {
        $(".oderNav li").removeClass("oderNavShow")
        $(this).addClass("oderNavShow");
    });
});

//订单页

//商品加入购物车

// var shopId=localStorage.getItem("myCart")?JSON.parse(localStorage.getItem("myCart")):new Array();
// var myId=null
// $(document).ready(function(){
// 	$(".shopAdd").click(function(){
// 		var myId=$(this).attr("data-id");
// 		if(shopId.length=="0"){
// 			shopId.push(myId);
// 		}else{
// 			for (var i=0;i<shopId.length;i++) {
// 				if(parseInt(myId)===parseInt(shopId[i])){
// 					alert("商品已添加");
// 					return
// 				};
// 			};
// 			shopId.push(myId)
// 		}
//
// 		localStorage.setItem("myCart",JSON.stringify(shopId));
// 	});
// });

    //     var shop = localStorage.getItem('myCart') ? JSON.parse(localStorage.getItem("myCart")) : [],
    //         data = {};
    //     $(document).ready(function () {
    //         $(".shopAdd").click(function () {
    //             if (!{{Auth::guard("pc")->user()->id}}) {

    //                 alert('请先登录');
    //                 return;
    //             }
    //             //判断空对象  [{"count":2, "product_id":1},{"count":2, "product_id":2}]
    //             if ($.isEmptyObject(shop)) {
    //                 //空对象
    //                 data = {
    //                     'count': $(this).attr('data-number'),
    //                     'product_id': $(this).attr('data-id'),
    //                     'name': $(this).attr('data-name'),
    //                     'price': $(this).attr('data-price'),
    //                     'img': $(this).attr('data-img')
    //                 };
    //                 shop.push(data);
    //             } else {
    //                 for (var item in shop) {
    //                     var status = -1;
    //                     //判断是否有相同的
    //                     if (shop[item].product_id == $(this).attr('data-id')) {
    //                         status = item;
    //                         break;
    //                     }
    //                 }

    //                 if (status != -1) {
    //                     //有重复
    //                     shop[item].count++;
    //                 } else {
    //                     data = {
    //                         'count': $(this).attr('data-number'),
    //                         'product_id': $(this).attr('data-id'),
    //                         'name': $(this).attr('data-name'),
    //                         'price': $(this).attr('data-price'),
    //                         'img': $(this).attr('data-img')
    //                     };
    //                     shop.push(data);
    //                 }

    //             }
    //             localStorage.setItem("myCart", JSON.stringify(shop));
    //             alert("商品已添加");
    //         });
    //     });

    //     //详情页购买
    // var addFunc = function (event) {

    //     //不能超过库存
    //     if ($(event).attr('datas-tock') < parseInt($('#prdoctNumbers').text())) {
    //         alert('不能超过库存');
    //         return;
    //     }
    //     //判断空对象  [{"count":2, "product_id":1},{"count":2, "product_id":2}]
    //     if ($.isEmptyObject(shop)) {
    //         //空对象
    //         data = {
    //             'count': parseInt($('#prdoctNumbers').text()),
    //             'product_id': $(event).attr('data-id'),
    //             'name': $(event).attr('data-name'),
    //             'price': $(event).attr('data-price'),
    //             'img': $(event).attr('data-img')
    //         };
    //         shop.push(data);
    //     } else {
    //         for (var item in shop) {
    //             var status = -1;
    //             //判断是否有相同的
    //             if (shop[item].product_id == $(event).attr('data-id')) {
    //                 status = item;
    //                 break;
    //             }
    //         }
    //         if (status != -1) {
    //             //有重复
    //             shop[item].count += parseInt($('#prdoctNumbers').text());
    //         } else {
    //             data = {
    //                 'count': parseInt($('#prdoctNumbers').text()),
    //                 'product_id': $(this).attr('data-id'),
    //                 'name': $(this).attr('data-name'),
    //                 'price': $(this).attr('data-price'),
    //                 'img': $(this).attr('data-img')
    //             };
    //             shop.push(data);
    //         }
    //     }
    //     console.log(shop);
    //     localStorage.setItem("myCart", JSON.stringify(shop));
    //     alert("商品已添加");

    // }

//首页链接点击进入详情页

