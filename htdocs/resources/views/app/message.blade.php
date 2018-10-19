@extends('/app/layouts.app')

@section('content')

    <style type="text/css">
        .app p{
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box !important;
            -webkit-line-clamp: 1;
            -webkit-box-orient: vertical;
        }
    </style>
	<div class="container py-2 bg-light fixed-top">
		<div class="d-flex justify-content-between align-items-center text-mute">
			<a href="/apps/user/{{ Auth::guard('pc')->user()->id }}"  class="top-nav-item"><i class="fa fa-angle-left"></i></a>
			<h6 class="top-nav-title">
                	<script type="text/javascript">
                	Language("我的评论","My Reviews")
                </script></h6>
			<a href="/apps/user/{{ Auth::guard('pc')->user()->id }}" class="top-nav-item"><i class="fa fa-user"></i></a>
		</div>
	</div>

	<div class="top-fix"></div>
	<div class="d-flex border-bottom bg-white pt-3 pl-3"style="padding: 0;">
		<p class="text-muted">
                	<script type="text/javascript">
                	Language("我的评论","My Reviews")
                </script></p>
	</div>

	<div class="container main-container cartBox bg-muted " style="height: auto;">
		@foreach($data as $val)
		<div class="row my-2 p-3 bg-white cartPro">
				<div class="col-3 d-flex align-items-center" >
					<img class="cart-img rounded-circle" src="/uploads/logo5.png" alt="">
				</div>
				<div class="col-9 d-flex align-items-center" >
					<p>{{$val['name']}}</p>
				</div>
				<div class="col-12 d-flex align-items-center">
					<small class="text-muted py-2">[{{$val['created_at']}}]</small>
				</div>
				<div class="col-12 d-flex ">
					<span class=" py-1 my-2">{{$val['content']}}</span>
				</div>
				<div class="col-12 d-flex ">
				<!--评价星星-->
					<div id="oderBox" class="texti" style="padding: 0;" score="{{$val['score']}}">
						<span><i class="far fa-star" aria-hidden="true" ></i></span>
						<span><i class="far fa-star" aria-hidden="true" ></i></span>
						<span><i class="far fa-star" aria-hidden="true" ></i></span>
						<span><i class="far fa-star" aria-hidden="true" ></i></span>
						<span><i class="far fa-star" aria-hidden="true" ></i></span>
					</div>
				</div>
				@foreach($val['reply'] as $v)
				<div class="col-12 d-flex border btn-white my-2 " style="border-color:#fdb3d3 !important;">
					<span class=" py-1 font-weight-light">[{{$val['message_name']}}
                	<script type="text/javascript">
                	Language("回复","Send")
                </script>]{{$v['content']}}</span>
				</div>
				@endforeach
				<div class="col-12 d-flex   py-1" style="border-top: 1px #EEEEEE solid;margin-top: 20px;">
					<div class="col-3 d-flex align-items-center">
						<img class="cart-img" src="{{$val['messageImg']['product_image']}}" alt="">
					</div>
					<div class="col-7">
						<span class="d-block"><p class="p-0">{{$val['messageImg']['zn_name']}}
                	<script type="text/javascript">
                	Language("{{$val['messageImg']['zn_name']}}","{{$val['messageImg']['en_name']}}")
                </script></p></span>
						<span class="d-block"><small class="text-red cartProPrice">$ <span>{{$val['distributor']['level_four_price']}}</span></small></span>
					</div>
				</div>
		</div>
		@endforeach
	</div>

	<!-- 结算 Container -->
    <!--<div class="container">
      <div class="row checkout-bar align-items-center" style="z-index: ;">
        <div class="col-3 pl-5">
        </div>
        <div class="col-5 text-right">
        	<a class="text-dark" href="#">
	        	<small>订单：xxxxxxxxxxxxxxx </small><br />
	        	<small class="text-red total">$ <span>00.00</span></small>
	        </a>
        </div>
        <div class="col-4 h-100 w-100">
        	<button class="btn btn-red rounded-0 btn-check-out Settlement"></i> 支付</button>


        </div>

      </div>
    </div>-->
    <!-- End 结算 Container -->
	    	<!--模态框-->
	        <!--<div class="modal fade bs-example-modal-sm "id="showx" tabindex="-1" role="dialog" aria-labelledby="mySmallModalLabel">
			  <div class="modal-dialog modal-sm" role="document">
			    <div class="modal-content "id="show_text"style="padding: 2% 5%;position: relative;z-index: 9999;">
			    </div>
			  </div>
			</div>
			<div id="pp" style="display: none;"></div>-->
@endsection


                                        

@section('scripts')
<script type="text/javascript">
	$(".texti .fa,.texti .far").addClass("text-red")
	for(let i=0;i<$(".texti").length;i++){
		for( let o=0;o<$(".texti").eq(i).attr("score");o++){
			$(".texti").eq(i).find("i").eq(o).removeClass("far")
			$(".texti").eq(i).find("i").eq(o).addClass("fa ")
			// $(".texti").eq(i).children("span").eq(o).addClass("text-red")
		}
	}
//		$(".cartProNumber").attr("value","1")
//		function summary(){
//			var summer=0
//			for(i=0;i<$(".cartPro").length;i++){
//				var price=$(".cartPro").eq(i).find(".cartProPrice").find("span").html();
//				var num=$(".cartPro").eq(i).find(".cartProNumber").val();
//				summer+=price*num
//			}
//			$(".total").eq(0).find("span").html(summer.toFixed(2))
//		};
//
//	var cart = localStorage.getItem('shopCart') ? JSON.parse(localStorage.getItem("shopCart")) : [];
//
//		if($.isEmptyObject(cart)){
//			$(".cartBox").html( "您还没有选择商品");
//		}else{
//		var cartText=`<div class="row border-bottom bg-white pt-3 pl-3"style="padding: 0;"><p class="text-muted ">收货地址</p></div>
//	<a href="##" addid="">
//      <div class="line-normal-wrapper clearfloat row bg-white"style="position: relative;">
//          <small class="float_left py-2 text-muted"style="padding: 0 3%;">Address[i]</small>
//          <small class="float_left py-2 text-muted" style="text-align: right;padding: 0 3%;">Address[i].mobile</small>
//          <small class="float_left py-2 text-muted twoLine" style="width: 100%;padding: 0 3%;">Address[i].detail</small>
//          <small class=" py-2 text-muted" style="position: absolute;top:0;right:2%;"><a>修改</a></small>
//      </div>
//   </a>`
//		for(var i=0;i<cart.length;i++){
//			var sl=cart[i].number;
//			cartText +=`<div class="row my-2 p-3 bg-white cartPro">
//			<div class="col-3 d-flex align-items-center">
//				<img class="cart-img" src="${cart[i].image}" alt="">
//			</div>
//			<div class="col-5">
//				<span class="d-block"><p class="p-0">${cart[i].zn_name}</p></span>
//				<span class="d-block"><small class="text-red cartProPrice">$ <span>${cart[i].price}</span></small></span>
//			</div>
//			<div class="col-4 p-0 d-flex align-items-end">
//				<div class="input-group">
//				    <div class="input-group-prepend">
//				    		<small class="py-1 text-muted" >数量</small>	
//				    	</div>
//				    <input	value="${sl}" class="form-control border-0 cartProNumber" id="pi${i}"style="padding:0;text-align:center" >
//				 </div>
//			</div>
//		</div>`
//		}
//		$(".cartBox").html( cartText);
//	};
//	summary();

	
	
	

</script>






@endsection