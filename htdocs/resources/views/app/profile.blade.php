@extends('/app/layouts.app')

@section('content')

    <style type="text/css">
        .app a small{
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box !important;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
        }
    </style>
	<div id="add" class="modal fade" role="dialog" style="overflow: hidden;">
		<div class="modal-dialog">

			<!-- Modal content-->
			<div class="modal-content">
				<div class="modal-header">
					<h4 class="modal-title">
                	<script type="text/javascript">
                	Language("添加地址","Add Address")
                </script></h4>
					<button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
				</div>

				<div class="modal-body">
					<div class="form-group">
						<label class="control-label" for="name">
                	<script type="text/javascript">
                	Language("收件人（最多40字）","Receiptant ")
                </script><span
									style="color:red;">＊</span></label>
						<div class="controls">
							<input type="text" name="name" id="name"
								   class="form-control"
								   value="" required="required"/>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label" for="mobile">
                	<script type="text/javascript">
                	Language("联系电话"," Phone Number")
                </script><span
									style="color:red;">＊</span></label>
						<div class="controls">
							<input type="text" name="mobile" id="mobile"
								   class="form-control"
								   value="" required="required"/>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label" for="country">
                	<script type="text/javascript">
                	Language("街道地址","Street Address")
                </script><span
									style="color:red;">＊</span></label>
						<div class="controls">
							<input type="text" name="country" id="country"
								   class="form-control"
								   value="" required="required"/>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label" for="detail">
                	<script type="text/javascript">
                	Language("公寓号、楼号","Apt, suite, building, etc (optional)")
                </script><span
									style="color:red;">＊</span></label>
						<div class="controls">
							<input type="text" name="detail" id="detail"
								   class="form-control"
								   value="" required="required"/>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label" for="city">
                	<script type="text/javascript">
                	Language("城市","City")
                </script><span
									style="color:red;">＊</span></label>
						<div class="controls">
							<input type="text" name="city" id="city"
								   class="form-control"
								   value="" required="required"/>
						</div>
					</div>

					<div class="form-group">
						<label class="control-label" for="province">
                	<script type="text/javascript">
                	Language("州","State")
                </script><span
									style="color:red;">＊</span></label>
						<div class="controls">
							<input type="text" name="province" id="province"
								   class="form-control"
								   value="" required="required"/>
						</div>
					</div>
					<div class="form-group">
						<label class="control-label" for="zip">
                	<script type="text/javascript">
                	Language("邮编","Zip Code")
                </script><span
									style="color:red;">＊</span></label>
						<div class="controls">
							<input type="text" name="zip" id="zip"
								   class="form-control"
								   value="" required="required"/>
						</div>
					</div>



					<div class="modal-footer">
						<button type="button" class="btn btn-default waves-effect" data-dismiss="modal">
                	<script type="text/javascript">
                	Language("关闭","Close")
                </script></button>
						<button onclick="addAddress();" type="button" data-id=""
								class="btn btn-primary waves-effect waves-light"><i class="fa fa-save"></i> 
                	<script type="text/javascript">
                	Language("添加","Add")
                </script>
						</button>
					</div>
				</div>
			</div>
		</div>
	</div>
<!-- Mobile Top Nav -->
<div class="container bg-blue pb-2 sticky-top">
	<div class="d-flex justify-content-between align-items-end text-white">
		<a href="/apps" class="top-nav-item text-white"><i class="fa fa-angle-left"></i></a>
		<h6 class="top-nav-title">
                	<script type="text/javascript">
                	Language("个人中心","My Account")
                </script></h6>

		<a onclick="Quit()" class="top-nav-item text-white"><i class="fa fa-sign-out-alt"></i></a>
		<form id="logout-form" action="{{ route('quit') }}" method="POST" style="display: none;">
			<input type="hidden" name="_token" value="{{csrf_token()}}"/>
		</form>
	</div>
</div><!-- End Mobile Top Nav -->

<!-- avatar Container -->
<div class="container bg-blue">
	<div class="d-flex justify-content-center">
		<div class="col-12 px-3 pt-2 m-0 text-center">
			<div class="avatar-img-container" style="margin: auto;">
				<img class="avatar-img" src="{{ Auth::guard('pc')->user()->avatar }}" alt="">
			</div>
		</div>
	</div>
</div><!-- End avatar Container-->

 <!-- Curved bg Container -->
 <div class="container position-relative">
    <div class="bg-curved bg-blue"></div>
 </div><!-- End Curved bg Container-->

<div class="container justify-content-center text-center mb-5">
	<small class="d-inline text-white">{{ Auth::guard("pc")->user()->name }}</small>
</div>

<div class="container">
	<div class="row text-center">
		<div class="col-4 mt-2">
			<a href="/apps/Record" class="btn btn-lg btn-circle btn-white shaddow-dark"><i class="fa fa-user"></i></a>
        	<small class="d-block py-2">
                	<script type="text/javascript">
                	Language("浏览记录","Recently Viewed")
                </script></small>
		</div>
		<div class="col-4 mt-2">
			<a href="{{route('account')}}" class="btn btn-lg btn-circle btn-white shaddow-dark"><i class="fa fa-cog"></i></a>
        	<small class="d-block py-2">
                	<script type="text/javascript">
                	Language("个人资料","Account Information")
                </script></small>
		</div>
		<div class="col-4 mt-2">
			<a href="{{route('password')}}" class="btn btn-lg btn-circle btn-white shaddow-dark"><i class="fa fa-unlock"></i></a>
        	<small class="d-block py-2">
                	<script type="text/javascript">
                	Language("修改密码","Change Password")
                </script></small>
		</div>
		<div class="col-4 mt-2" style="position: relative;">
			<a href="/apps/users/message" class="btn btn-lg btn-circle btn-white shaddow-dark"><i class="fa fa-comment-dots"></i></a>
        	<small class="d-block py-2">
                	<script type="text/javascript">
                	Language("我的评论","My Reviews")
                </script></small>
        	<div class="border-0 rounded-50 " id="see" style="position: absolute;top: 5%;right: 30%;width: 10px;height: 10px;background: red; display: none;"></div>
		</div>
		<div class="col-4 mt-2">
			<a href="/apps/cart/{{ Auth::guard("pc")->user()->id }}" class="btn btn-lg btn-circle btn-white shaddow-dark"><i class="fa fa-shopping-cart"></i></a>
        	<small class="d-block py-2">
                	<script type="text/javascript">
                	Language("购物车","Shopping Cart")
                </script></small>
		</div>

		<div class="col-4 mt-2">
			<!--<a href="{{ route('address') }}" class="btn btn-lg btn-circle btn-white shaddow-dark"><i class="fa fa-map-marker-alt"></i></a>-->
			<a href="/apps/contactUs" class="btn btn-lg btn-circle btn-white shaddow-dark"><i class="fa fa-map-marker-alt"></i></a>
        	<small class="d-block py-2">
                	<script type="text/javascript">
                	Language("联系我们","Contact Us ")
                </script></small>
		</div>


	</div>
</div>

<!-- 我的订单 Container -->
<div class="container mb-2 pb-1">

	<div class="d-flex justify-content-between my-4">
	  <div><h6 class="pl-2 title-border text-secondary"><i class="far fa-list-alt"></i> 
                	<script type="text/javascript">
                	Language("我的订单","My Orders")
                </script></h6></div>
	  {{--<div><a href="">更多 <i class="fa fa-angle-right"></i></a></div>--}}
	</div>

	<!-- Row -->
	<div class="row text-center">



	  <div class="col-6 mt-2 oderList">
	  	<a href="##" class="btn btn-lg btn-circle btn-white shaddow-dark"><i class="fa fa-receipt"></i></a>
        <small class="d-block py-2">
                	<script type="text/javascript">
                        Language("已完成","Waiting for Shipment")
                </script></small>
	  </div>

	   <div class="col-6 mt-2 oderList">
	  	<a href="##" class="btn btn-lg btn-circle btn-white shaddow-dark"><i class="fa fa-clock"></i></a>
        <small class="d-block py-2">
                	<script type="text/javascript">
                        Language("已下单","Waiting for Payment")

                </script></small>
	  </div>

	  <!-- <div class="col-3 mt-2 oderList">
	  	<a href="##" class="btn btn-lg btn-circle btn-white shaddow-dark"><i class="fa fa-shipping-fast"></i></a>
        <small class="d-block py-2">
                	<script type="text/javascript">
                	Language("待收货","Waiting for Delivered")
                </script></small>
	  </div>

	  <div class="col-3 mt-2 oderList">
	  	<a href="##" class="btn btn-lg btn-circle btn-white shaddow-dark"><i class="fa fa-comment-dots"></i></a>
        <small class="d-block py-2">
                	<script type="text/javascript">
                	Language("待评论","Waiting for Reviews")
                </script></small>
	  </div> -->

	</div><!-- Row -->

</div><!-- End 我的 container -->
	<!--订单-->
	<div id="oderBox"style="padding: 0;">

	</div>

@endsection





@section('scripts')
	<script>
        var addAddress = function () {

            $.ajax({
                url: '/api/upload/user/address',
                method: 'get',
                async: false,
                dataType: "jsonp",
                jsonp: "callbackparam",
                data: {
                    'name': $('#name').val(),
                    'mobile': $('#mobile').val(),
                    'province': $('#province').val(),
                    'city': $('#city').val(),
                    'country': $('#country').val(),
                    'detail': $('#detail').val(),
                    'zip': $('#zip').val(),
                    'default' : 1,
                    'id' : {{Auth()->guard('pc')->user()->id}}
                },
                crossDomain: true,//是否跨域:是
                cache: false,//是否缓存：否
                jsonpCallback: "my",
                success: function (json) {
                    if (!json.status) {
                        swal({
                            title: json.data,
                            type: 'info',
                            showConfirmButton: true,

                        })
                    } else {
                        swal({
                            title: '添加成功',
                            type: 'success',
                            showConfirmButton: true,

                        })

                        setTimeout(function () {
                            location.reload();
                        }, 1500);
                    }

                },
                error: function () {
                    swal({
                        title: '请求失败',
                        type: 'info',
                        showConfirmButton: true,

                    })

                }
            })

        }
	</script>
	<script type="text/javascript">
		//绑定订单数据
		$(".oderList").click(function(){
			var aa = <?php echo Auth()->guard("pc")->user()->id ?>;
			var That=$(".oderList").index(this);
			var xx=LanguageHtml(["已完成","已下单","已发货","待评论"],["Waiting for Shipment","Waiting for Payment","Waiting for Delivered"," Waiting for Reviews"]);
				$.ajax({
					 url: '/api/order/bunsiess/state',
		                method: 'get',
		             //   async: false,
		              	 dataType: "jsonp",
		                jsonp: "callbackparam",
		                data: {
		                    id : aa,
		                    status:That +1
		                },
		                crossDomain: true,//是否跨域:是
		                cache: false,//是否缓存：否
		                jsonpCallback: "my",

					success: function(json) {

						var myOder=json.data;
						console.log(myOder)
						if(!json.status){
							$("#oderBox").html(LanguageHtml(`<small class="d-block py-1 text-center text-red">您没有${xx[That]}的订单</small>`,`<small class="d-block py-1 text-center text-red">No ${xx[That]} orders</small>`));
							return
						}
						var myOderText='<div class="line"style="width: 100%;height: 5px;background: #E3E3E3;"></div>'
						if (That=="1") {
							for(i=0;i<myOder.length;i++){
													myOderText+=`
														<a href="/apps/order/details?id=${myOder[i].id}" class="text-dark link"><div class="container" style="padding: 5% 0 2% 0;">
														    <div class="row "style="padding:0 8%; margin:0;">
															    <div class="col-3" w-100 h-100><img class="img-responsive w-100 " src="${myOder[i].snap_img}" /></div>
															     <div class="col-6 "style="padding-bottom: 5%;">
																     <small class="col-12 py-1 d-block">${myOder[i].snap_name[0]=="{"?LanguageHtml(JSON.parse(myOder[i].snap_name).zn,JSON.parse(myOder[i].snap_name).en):myOder[i].snap_name}</small>
																      <small style="color: #adadad" class="col-12">共${myOder[i].total_count}件商品</small>
															      </div>
															      <div style="font-size: 13px;color: #f14067;" class="col-3">
															      <div class="row">
												                       <!--<small style="color: #f14067;"links="${myOder[i].id}" class="col-12 py-2 delete text-muted">${LanguageHtml('删除订单','Delete Order')} </small>-->
												                      </div>
												                      <div class="row">

												                       <small style="color: #f14067;padding: 0px;" class="col-12 py-2"> $${myOder[i].total_price} </small>

												                      </div>
															      </div>
														      </div>
														      <div class="row "style="padding:0 5%;margin:0; border-top: 1px solid #E3E3E3;line-height: 200%;">
															      <small class=" col-9">${LanguageHtml('订单号：',' Order Number:')}${myOder[i].order_no}</small>
															      <small style="" class="col-3">${xx[That]}</small>
														     </div>
													    </div>
														<div class="line"style="width: 100%;height: 5px;background: #E3E3E3;"></div></a>`
											};

						}else if(That=="3"){
										for(i=0;i<myOder.length;i++){
													myOderText+=`
														<a href="/apps/tocomments/${myOder[i].id}" class="text-dark link"><div class="container" style="padding: 5% 0 2% 0;">
														    <div class="row "style="padding:0 8%; margin:0;">
															    <div class="col-3" w-100 h-100><img class="img-responsive w-100 " src="${myOder[i].snap_img}" /></div>
															     <div class="col-6 "style="padding-bottom: 5%;">
																     <small class="col-12 py-1 d-block">${myOder[i].snap_name[0]=="{"?LanguageHtml(JSON.parse(myOder[i].snap_name).zn,JSON.parse(myOder[i].snap_name).en):myOder[i].snap_name}</small>
																      <small style="color: #adadad" class="col-12">共${myOder[i].total_count}件商品</small>
															      </div>
															      <div style="font-size: 13px;color: #f14067;" class="col-3">
																      <div class="row">
												                       <small style="color: #f14067; " links="${myOder[i].id}" class="col-12 py-2 delete text-muted"> </small>
												                      </div>
												                      <div class="row">
																	  	<p class="class="col-12 py-2 "style="font-size:8px">
																		  $${myOder[i].total_price}
																		  </p>
												                      </div>
															      </div>
														      </div>
														      <div class="row "style="padding:0 5%;margin:0; border-top: 1px solid #E3E3E3;line-height: 200%;">
															      <small class=" col-9">${LanguageHtml('订单号：',' Order Number:')}${myOder[i].order_no}</small>
															      <small style="" class="col-3">${xx[That]}</small>
														     </div>
													    </div>
														<div class="line"style="width: 100%;height: 5px;background: #E3E3E3;"></div></a>`
											};

						}else{
							for(i=0;i<myOder.length;i++){
													myOderText+=`
														<a href="/apps/order/details?id=${myOder[i].id}" class="text-dark link">
														<div class="container" style="padding: 5% 0 2% 0;">
														    <div class="row "style="padding:0 8%; margin:0;">
															    <div class="col-3" w-100 h-100><img class="img-responsive w-100 " src="${myOder[i].snap_img}" /></div>
															     <div class="col-6 "style="padding-bottom: 5%;">
																     <small class="col-12 py-1 d-block">${myOder[i].snap_name[0]=="{"?LanguageHtml(JSON.parse(myOder[i].snap_name).zn,JSON.parse(myOder[i].snap_name).en):myOder[i].snap_name}</small>
																      <small style="color: #adadad" class="col-12">共${myOder[i].total_count}件商品</small>
															      </div>
															      <div style="font-size: 13px;color: #f14067;" class="col-3">
																       <small style="color: #f14067;padding: 0px;" class="col-12 py-2 "> $${myOder[i].total_price} </small>
															      </div>
														      </div>
														      <div class="row "style="padding:0 5%;margin:0; border-top: 1px solid #E3E3E3;line-height: 200%;">
															      <small class=" col-9">订单号：${myOder[i].order_no}</small>
															      <small style="" class="col-3">${xx[That]}</small>
														     </div>
													    </div>
														<div class="line"style="width: 100%;height: 5px;background: #E3E3E3;"></div></a>`
											};

						}
					$("#oderBox").html(myOderText);
					$(".link .delete").click(function(){
						var That=$(".link .delete").index(this);
						console.log(That)
						var order_id = $(this).attr("links");

						swal({
						title:LanguageHtml( '确认删除该订单吗?','Delete This Order?'),
						type: 'info',
						showCancelButton: true,
						confirmButtonColor: '#3085d6',
						cancelButtonColor: '#d33',
						cancelButtonText: LanguageHtml('取消',''),
						confirmButtonText: LanguageHtml('是的','Yes')
						}).then(function(isConfirm) {
						if (isConfirm.value==true) {
							$.ajax({
								url:'/apps/delorder',
								method: 'get',
								data: {
			                    id : order_id
			                	},
			                	success: function(json){
			                		//console.log(json)
			                        swal({
			                            title: json,
			                            type: 'success',
			                            showConfirmButton: true
			                        });
			                        $(".link").eq(That).remove()

			                	}
							})
						}
						})
						return false;
					})

					}
				});
		})

	</script>

	<script type="text/javascript">

	</script>
	<script type="text/javascript">
		function Quit(){

			swal({
			title: LanguageHtml('确认退出该账号吗?','Log Out?'),
			type: 'info',
			showCancelButton: true,
			confirmButtonColor: '#3085d6',
			cancelButtonColor: '#d33',
			cancelButtonText: LanguageHtml('取消',''),
			confirmButtonText: LanguageHtml('是的','Yes')
			}).then(function(isConfirm) {
			if (isConfirm.value==true) {
				document.getElementById('logout-form').submit();
			}
			})
		};

	</script>
	<script type="text/javascript">
		if({{$data}}){
		$('#see').show();
		}else{
			$('#see').hide();
		}
	</script>
    <script>
    //底部导航显示当前所在页面样式
    $("#mobile-nav a").eq(3).css({"background":"#4982A3","color":"#ffffff"})
    </script>


@endsection