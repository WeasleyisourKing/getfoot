<!doctype html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0" name="viewport" />
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
    <link href="{{ asset('lib/css/alertify.css') }}" rel="stylesheet">
    {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootswatch/4.1.1/litera/bootstrap.min.css"> --}}
    <link href="https://cdn.bootcss.com/font-awesome/4.3.0/css/font-awesome.css" rel="stylesheet">
    
    <link rel="stylesheet" type="text/css" href="{{asset('/app/css/12buy.css')}}">
    <script src="{{ asset('lib/js/alertify.js') }}" type="text/javascript"></script>
    <script src="{{ asset('lib/js/check.js') }}" type="text/javascript"></script>
    <script src="{{ asset('lib/js/jquery.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('lib/js/bootstrap.min.js') }}" type="text/javascript"></script>
    <!-- FontAwesome -->
    <!--<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">-->
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" integrity="sha384-hWVjflwFxL6sNzntih27bfxkr27PmbbK/iSvJ+a4+0owXq79v+lsFkW54bOGbiDQ" crossorigin="anonymous">
    <!-- Sweet Alert -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/limonte-sweetalert2/7.22.2/sweetalert2.all.js"></script>

{{--    <title>{{ config('app.name', '12Buy') }}</title>--}}
    <title>12Buy</title>
  </head>
  <script>
//设置语言
 var Language=function(one, tow){
 	 document.write(window.localStorage.getItem('lang') == null || window.localStorage.getItem('lang') == 1 ? one : tow); 
  }
 var LanguageHtml=function(one, tow){
 	return window.localStorage.getItem('lang') == null || window.localStorage.getItem('lang') == 1 ? one :  tow ;
  }
    var Sprice = function (role1, role2, role3, role4) {

        var haha;
        @if(!empty(Auth::guard("pc")->user()->role))
            switch ({{Auth::guard("pc")->user()->role}}) {
            case 1 :
                haha = `<div class='Price'>$${role1}</div>`;
                break;
            case 2 :
                haha = `<div class='Price'>$${role2}</div>`;
                break;
            case 3 :
                haha = `<div class='Price'>$${role3}</div>`;
                break;
            default :
                haha = `<div class='Price'>$${role4}</div>`;
        }
        document.write(haha);
        @endif

    }
    var Spricedetails = function (role1, role2, role3, role4) {

        var haha;
        @if(!empty(Auth::guard("pc")->user()->role))
            switch ({{Auth::guard("pc")->user()->role}}) {
            case 1 :
                haha = `$${role1}`;
                break;
            case 2 :
                haha = `$${role2}`;
                break;
            case 3 :
                haha = `$${role3}`;
                break;
            default :
                haha = `$${role4}`;
        }
        document.write(haha);
        @endif

    }
    var Spricedetails1 = function (role1, role2, role3, role4) {

        var haha;
        @if(!empty(Auth::guard("pc")->user()->role))
            switch ({{Auth::guard("pc")->user()->role}}) {
            case 1 :
                haha = `$${role1}`;
                break;
            case 2 :
                haha = `$${role2}`;
                break;
            case 3 :
                haha = `$${role3}`;
                break;
            default :
                haha = `$${role4}`;
        }
        return haha
        @endif

    }
  </script> 
  <body>
    
    <div class="app">
      @yield('content')
    </div>


    @if (!(Auth::guard("pc")->user()))
    {{--@guest--}}
      <div class="mobile-fix-unauth"></div>
      <!-- 移动导航 Container -->
      <div id="mobile-nav" class="container bg-white fixed-bottom CTA-container py-2">
          <a href="{{ route('appsLogin') }}" class="btn btn-block btn-white shaddow-dark"><i class="fa fa-user-circle"></i> 
          	<script>Language("登录","log in")</script>
          </a>
          <a href="{{ route('appsRegister') }}" class="btn btn-block btn-white shaddow-dark"><i class="fa fa-user-plus"></i> 
          	<script>Language("注册","registered")  </script></a>
      </div><!-- End 移动导航 Container -->
    @else
      <div class="mobile-fix"></div>
      <!-- 移动导航 Container -->
      <div id="mobile-nav" class="container bg-white fixed-bottom CTA-container py-2">
        <div class="d-flex flex-row justify-content-between">
          <a href="{{ route('home') }}" class="btn btn-white shaddow-dark"><i class="fa fa-home"></i></a>
          <a href="{{ route('category') }}" class="btn btn-white shaddow-dark"><i class="fa fa-bookmark"></i></a>
          {{--<button type="button" href="" class="btn btn-primary shaddow-dark" disabled><i class="fa fa-plus"></i></button>--}}
          <a href="/apps/cart/{{Auth()->guard('pc')->user()->id}}" class="btn btn-white shaddow-dark" style="position: relative;">
          	<p id="CartNumber1" class=" bg-pink text-white  rounded-50" style="position: absolute;
          		font-size: 10px;
			     top: -2px;
			    right: -6px;
			    width: 18px;
			    height: 18px;
			    display: none !important;">0</p>
			<i class="fa fa-shopping-cart"></i></a>
          <a href="/apps/user/{{Auth()->guard('pc')->user()->id}}" class="btn btn-white shaddow-dark"><i class="fa fa-user"></i></a>
        </div>
      </div><!-- End 移动导航 Container -->
      @endif
    {{--@endguest--}}

  



    <!-- Optional JavaScript -->
    <!-- jQuery first, then Popper.js, then Bootstrap JS -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>

    @yield('scripts')

  <script>
//		CartNumber function
	var CartNumber=function(){
		var shopCartLength=JSON.parse(localStorage.getItem("shopcart"));
		console.log(shopCartLength)
		if($.isEmptyObject(shopCartLength) ){
			console.log("1121")
			$("#CartNumber1").hide();
			console.log(shopCartLength)
		}else{
			$("#CartNumber1").show();
			console.log("2212")
			var nu=0;
			console.log(shopCartLength);
			for(var i=shopCartLength.length;i--;){
				nu+=parseInt(shopCartLength[i].number)
			}
			console.log(nu)
			$("#CartNumber1").html(nu);
		}
	}
  	$("#mobile-nav").ready(function(){
	CartNumber()
  		function joinShopCart(item){
        	 var id = {{ !empty(Auth::guard("pc")->user()) ? Auth::guard("pc")->user()->id : '-1'}};
if (id == -1) {
	    swal({
                            title: LanguageHtml('请先登录!','please log in first!'),
                            type: 'info',
                            showConfirmButton: true
                        })
                        return;
}
            var project = {
                zn_name : item.attributes["zn_name"].value,
                price   : item.attributes["price"].value,
                shop_id : item.attributes["shop_id"].value,
                image   : item.attributes["product_image"].value,
                number : item.attributes["product_number"]?item.attributes["product_number"]:1,
            }
            var cart =  JSON.parse(localStorage.getItem("shopCart"));
            if(cart){
                for(let i = 0;i < cart.length;i++){
                    if(cart[i].shop_id == item.attributes["shop_id"].value){
//        console.log(cart[i].shop_id);
//        console.log(item.attributes["shop_id"].value);
                        cart[i].number = cart[i].number * 1 + 1;
                        localStorage.setItem("shopCart",JSON.stringify(cart));
                			CartNumber();
                        swal({
                            title: LanguageHtml('添加商品成功!','Add item successfully!'),
                            type: 'success',
                            showConfirmButton: true
                        })
                        return;
                    }
                }
                cart.push(project);
                localStorage.removeItem("shopCart");
                localStorage.setItem("shopCart",JSON.stringify(cart));
            }else{
                cart = [];
                cart.push(project);
                localStorage.setItem("shopCart",JSON.stringify(cart));
            }
            swal({
                title: LanguageHtml('添加商品成功!','Add item successfully!'),
                type: 'success',
                showConfirmButton: true
            })
                CartNumber();
        };
  		
  	});
  	
        function jqAjaxJsonp( method,urls,datas,means){
	        	 $.ajax({
	             url: urls,
	             type: method,
	             data: datas,
	             dataType: "jsonp",
                 jsonp: "callbackparam",
                 jsonpCallback: "my",
	             success: function(data){
	             	means(data)
	             },
                	 error: function (data) {
                    swal({
                        title: LanguageHtml('请求失败','Request failed'),
                        type: 'error',
                        showConfirmButton: true,

                    })
                }
	         });
        }
        function jqAjax( method,urls,datas,means){
	        	 $.ajax({
	             url: urls,
	             type: method,
	             data: datas,
	             success: function(data){
	             	means(data)
	             },
                	 error: function (data) {
                    swal({
                        title: LanguageHtml('请求失败','Request failed'),
                        type: 'error',
                        showConfirmButton: true,

                    })
                }
	         });
        }
//        $(function(){
        	
//      	$(".stock_text").prepend($(this).attr("data-stock"))
//      	for(var i=0;i<$(".stock_text").length;i++){
//      		$(".stock_text").eq(i).prepend($(".stock_text").eq(i).attr("data-stock")>0?"":"【已售空】")
//      	}
//      })
    </script>

   

    {{--<script> document.write(window.localStorage.getItem('lang') == null || window.localStorage.getItem('lang') == 1 ? " {{1}} " : " {{2}} "); </script>--}}

  </body>
</html>