@extends('/app/layouts.app')

@section('content')

    <div class="container py-2 bg-white fixed-top">
        <div class="d-flex justify-content-between align-items-center text-mute">
            <a href="javascript:history.back(-1);" class="top-nav-item"><i class="fa fa-angle-left"></i></a>
            <h6 class="top-nav-title">
                <script type="text/javascript">
                    Language("购物车", " Shopping Cart")
                </script>
            </h6>
            <a href="/apps/user/{{ Auth::guard("pc")->user()->id }}" class="top-nav-item"><i class="fa fa-user"></i></a>
        </div>
    </div>

    <div class="top-fix"></div>
    <div class="container cartBox " style="height: auto;padding-bottom: 100px;">
    </div>

    <!-- 结算 Container -->
    <div class="container">
        <div class="row checkout-bar align-items-center" style="z-index: ;">
            <div class="col-3">
                {{-- <button href="" class="btn btn-danger"><i class="fa fa-trash-alt"></i> 清空购物车</button> --}}
                <!-- <button href="" class="btn btn-danger d-block btn-sm btn-red my-2 border-0" id="discount_btn">
                    <small>
                        <script type="text/javascript">
                            Language("使用优惠劵", "Use Promo Code")
                        </script>
                    </small>
                </button> -->
            </div>
            <div class="col-5 text-right">
                <a class="text-dark" id="total_btn" href="##">
                    <i class="fa fa-angle-up"></i>
                    <small>
                        <script type="text/javascript">
                            Language("应付金额", "Amounts payable")
                        </script>
                    </small>
                    <small class="text-red total">$ <span>00.00</span></small>
                </a>
            </div>
            <div class="col-4 h-100 w-100">
                <button class="btn btn-red rounded-0 btn-check-out Settlement"></i>
                    <script type="text/javascript">
                        Language("结算", "Checkout")
                    </script>
                </button>


            </div>

        </div>
    </div><!-- End 结算 Container -->
    <!--模态框-->
    <div class="modal fade bs-example-modal-sm " id="showx" tabindex="-1" role="dialog"
         aria-labelledby="mySmallModalLabel">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content py-4" id="show_text" style="padding: 2% 5%;">
            </div>
        </div>
    </div>
    <div class="modal fade bs-example-modal-sm " id="total_detail" tabindex="-1" role="dialog"
         aria-labelledby="mySmallModalLabel">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content py-3" id="total_text" style="padding: 2% 5%;">
            </div>
        </div>
    </div>
    <div class="modal fade bs-example-modal-sm " id="discount" tabindex="-1" role="dialog"
         aria-labelledby="mySmallModalLabel">
        <div class="modal-dialog modal-sm" role="document">
            <div class="modal-content py-3" id="total_text" style="padding: 2% 5%;">
                <div class="row pb-4">
                    <h5 class="text-muted" style="margin: 0 auto ;">
                        <script type="text/javascript">
                            Language("优惠卷", " Promo Code")
                        </script>
                    </h5>
                </div>
                <div class=" row px-2">
                    <div class="col-md-6  input-group">
                        <script>
                            Language(`<input id="cardNumber" name="" type="text"  class="form-control" value="" required="" placeholder="请输入优惠卷码">`,
                                `<input id="cardNumber" name="" type="text"  class="form-control" value="" required="" placeholder="Please enter the coupon code">`)
                        </script>

                        <span class="input-group-addon">
	                        <button type="button" class="btn btn-block btn-primary px-3" id="query">
                	<script type="text/javascript">
                	Language("查询", "Search ")
                </script></button>
	                    </span>
                    </div>
                </div>
                <div class="row py-4 text-muted" id="information">
                    <div class="col-6 text-right">
                        <small>
                            <script type="text/javascript">
                                Language("优惠名称", "Promotion Name ")
                            </script>
                        </small>
                    </div>
                    <div class="col-6 text-left">
                        <small>--</small>
                    </div>
                    <div class="col-6 text-right">
                        <small>
                            <script type="text/javascript">
                                Language("优惠类型", "Promotion Description")
                            </script>
                        </small>
                    </div>
                    <div class="col-6 text-left">
                        <small>--</small>
                    </div>
                </div>
                <input id="preferential_use" class="btn btn btn-block btn-primary mt-2" value="使用" type="button">
            </div>
        </div>
    </div>
    <div id="pp" style="display: none;"></div>
@endsection



@section('scripts')

    <script>
//  		优惠卷模态框点击
		$("#discount_btn").click(function(){
			$("#discount").modal("show")
		})
//		点击优惠码查询	
//		优惠码
		var concessionCode="";
//		优惠类型
		var couponType=null;
//		优惠力度
		var concessionalRate=null;
//		优惠名
		var concessionalName=null;
		
		$("#query").click(function(){
		var concessionFun=function(data){
             	if(data.status){
             		$("#information small").eq(1).html(data.data.name);
             		$("#information small").eq(3).html(data.data.rcent);
             		$("#preferential_use").click(function(){	
	             		couponType=parseFloat(data.data.type);
	             		concessionalRate=parseFloat(data.data.rcent);
	             		concessionalName=data.data.rcent;
	             		concessionCode=$("#cardNumber").val(); 
	             		summary();
	             		$("#discount").modal("hide")
             		})
             	}else{
		            swal({
		                title:data.message ,
		                type: 'info',
		                showConfirmButton: true,
		
		            })
             	}
		};
		var datas={
            	code:$("#cardNumber").val()
		};
//		请求优惠卷信息
            jqAjax('get', '/api/discount/use', datas, concessionFun)


        })


        //加载购物车
        var cart = JSON.parse(localStorage.getItem("shopcart"));
        if ($.isEmptyObject(cart)) {
//		if(cart.length?cart.length:0){
            //购物车为空
            $(".cartBox").html(LanguageHtml("您还没有选择商品", "No Item Selected "));
        } else {
            var cartText = "";
            //循环购物车
            for (var i = 0; i < cart.length; i++) {
                var sl = cart[i].number;
                cartText += `<div class="row my-2 p-3 bg-white cartPro">
			
			<div class="col-1 d-flex align-items-center">
				<a href="##" class="text-danger delete"><i class="fa fa-trash-alt"></i></a>
			</div>
			<div class="col-3 d-flex align-items-center">
				<img class="cart-img" src="${cart[i].image}" alt="">
			</div>
			<div class="col-5">
				<span class="d-block"><small class="p-0 tow-line">${LanguageHtml(cart[i].zn_name, cart[i].en_name)}</small></span>
				<span class="d-block"><small class="text-red cartProPrice">$ <span>${cart[i].price}</span></small></span>
			</div>
			<div class="col-3 p-0 d-flex align-items-end">
				<div class="input-group">
				    <div class="input-group-prepend">
				      <button class="btn btn-sm btn-white removeNumber"style="z-index:0;" ><i class="fa fa-minus"></i></button>
				    </div>
				    <input	value="${sl}" class="form-control border-0 cartProNumber" id="pi${i}"style="padding:0;text-align:center" >
				    <div class="parent">
				      <button class="btn btn-sm btn-white  addNumber" ><i class="fa fa-plus"></i></button>
				    </div>
				 </div>
			</div>
		</div>`
            }
            //添加到页面
            $(".cartBox").html(cartText);
        }
        ;
        summary();
        //总价
        var total = 0;

        //计算价格函数
        function summary() {
            var summer = 0;
            for (i = 0; i < $(".cartPro").length; i++) {
                var price = $(".cartPro").eq(i).find(".cartProPrice").find("span").html();
                var num = $(".cartPro").eq(i).find(".cartProNumber").val();
                summer += price * num
            }
            total = summer.toFixed(2);
            var threshold ={{$postage->threshold}};
            var freight =0;
            freight = total > threshold ? 0 : freight;
            if ($(".cartPro").length == 0) {
                freight = 0;
            }
            var totalEnd = function () {
                if (couponType == 1) {
                    return parseFloat(total) - parseFloat(concessionalRate) > 0 ? parseFloat(total) - parseFloat(concessionalRate) : 0
                } else if (couponType == 2) {
                    return total * (1 - parseFloat(concessionalRate) / 100)
                } else {
                    return parseFloat(total)
                }
            }()
            $("#total_text").html(`<span>
            	${LanguageHtml('本次预估总额', ' Est. Total')}：$${total}<br />
            	${LanguageHtml('运费', 'Shipping')}：$${freight}<br />
            	${LanguageHtml('税金：待定', 'Tax:undetermined')}<br />
            	${LanguageHtml('优惠', 'Discount')}：${concessionalName ? concessionalName : LanguageHtml("无", "None")}<br />
            	${LanguageHtml('应付总金额', 'Total ')}：$${(totalEnd + freight * 1).toFixed(2)}
            	</span>`);
            var summerOver = totalEnd + freight * 1
            $(".total").eq(0).find("span").html(summerOver.toFixed(2));
            return totalEnd
        };
        $("#total_btn").click(function () {
            $("#total_detail").modal("show");
        });

        //购物车删除按钮
        $(".delete").click(function () {
            var that = $(this).parent().parent(".cartPro");
            var ab = $(".delete").index(this);
            swal({
                title: LanguageHtml('确认删除该商品?', 'Delete Item?'),
                type: 'info',
                showCancelButton: true,
                confirmButtonColor: '#3085d6',
                cancelButtonColor: '#d33',
                cancelButtonText: LanguageHtml('取消', 'cancel'),
                confirmButtonText: LanguageHtml('确定', 'Yes')
            }).then(function (isConfirm) {
                if (isConfirm.value == true) {
                    that.remove();
                    cart.splice(ab, 1);
                    localStorage.setItem("shopcart", JSON.stringify(cart));
                    summary();
                    swal(
                        LanguageHtml('删除成功!', 'Successfully Deleted'),
                    );
                }
            })
        });
        //购物车删除end

        $(".addNumber").click(function () {
            var Number = $(this).parent(".parent").siblings(".cartProNumber").val();
            Number = Number * 1 + 1;
            $(this).parent(".parent").siblings(".cartProNumber").val(Number);
            cart[$(".addNumber").index(this)].number = Number;
        });
        $(".cartProNumber").blur(function () {
            var Number = $(this).val();
            cart[$(".cartProNumber").index(this)].number = Number;
            summary();
            localStorage.setItem("shopcart", JSON.stringify(cart));
        });
        $(".removeNumber").click(function () {
            var Number = $(this).parent(".input-group-prepend").siblings(".cartProNumber").val();
            Number = Number > 1 ? Number * 1 - 1 : 1;
            $(this).parent(".input-group-prepend").siblings(".cartProNumber").val(Number);
            cart[$(".removeNumber").index(this)].number = Number;
        });
        $(".removeNumber,.addNumber").click(function () {
            summary();
            localStorage.setItem("shopcart", JSON.stringify(cart));
        });
        //模态框上下剧中
        var boxHeight = $(document).height();
        $(".modal-dialog").css("margin-top", (boxHeight / 3));

        //结算点击

        $(".Settlement").click(function () {

            if ($.isEmptyObject(cart)) {
                swal({
                    title: LanguageHtml("您还没有添加商品", " No Items Added"),
                    type: 'info',
                    showConfirmButton: false,
                });
                return
            }
            //生成购物车数组
            var data = [];
            for (let i in cart) {
                var shop = {
                    'count': cart[i].number,
                    'product_id': cart[i].shop_id,
                }
                data.push(shop);
            }

            var sub = {{$postage->threshold}}-summary();
            //判断总商品价值，并给予提示
            if (false) {
                swal({
                    title: LanguageHtml('确认结算?', 'Confirm Check Out?'),
                    text: LanguageHtml(`您的商品总额未满${{{$postage->threshold}}}元将支付运费,还差 ${sub.toFixed(2)} 元才能免邮,确定继续结算吗?`, `$${sub.toFixed(2)} more for free shipping, continue to check out?`),
                    type: 'info',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    cancelButtonText: LanguageHtml('取消', 'Cancel'),
                    confirmButtonText: LanguageHtml('确定', 'Yes')
                }).then(function (isConfirm) {
                    if (isConfirm.value) {
                        checkOut()
                    }
                })
            } else {
                checkOut()
            }
//          				查询库存 返回true时，跳转到付款页
            function checkOut() {
                var stock = function (res) {
                    if (res.status) {
                        //有库存执行
                        var orderForm = function (res) {
                            if (res.status) {
                                localStorage.setItem("order_no", res.data.order_no);
                                var ppx = localStorage.getItem("order_no")
                                var order_id = res.data.order_id
                                //清空购物车
                                window.location.href = `/apps/order/details?id=${order_id}`
                                localStorage.removeItem("order_no");
                                localStorage.removeItem("shopcart");
                            } else {

                                if (res.error_code == 6001) {

                                    goAddAddress(res.message)
                                } else {
                                    swal({
                                        title:res.message,
                                        type: 'info',
                                        showConfirmButton: false,
                                    })
                                }

                            }
                        };
                        jqAjax(
                            "post",
                            "/api/business/order",
                            {
                                'products': JSON.stringify(data),
                                'userId':{{Auth()->guard('pc')->user()->id}},
                                'code': concessionCode
                            },
                            orderForm
                        );
//                      $.post('/api/order', {
//                          'products': JSON.stringify(data),
//                          'userId':{{Auth()->guard('pc')->user()->id}},
//                          'code':concessionCode
//                          }, function (res) {
//                          if (res.status) {
//                              localStorage.setItem("order_no", res.data.order_no);
//                              var ppx = localStorage.getItem("order_no")
//                              var order_id = res.data.order_id
//                              //清空购物车
//                              window.location.href = `/apps/order/details?id=${order_id}`
//                              localStorage.removeItem("order_no");
//                              localStorage.removeItem("shopcart");
//                          } else {
//                          		if (res.errorCode==6001) {
//                          			goAddAddress(res.message)
//                          		} else{
//                                  swal({
//                                      title: res.message,
//                                      type: 'info',
//                                      showConfirmButton: false,
//                                  })
//                          		}
//                                   
//                          }
//                      });
                    } else {
                        swal({
                            title: res.message,
                            type: 'info',
                            showConfirmButton: false,
                        })
                    }
                }
                jqAjax("get", "/api/check/product", {'products': JSON.stringify(data)}, stock)
//                      $.ajax({
//                          url: "/api/check/product",
//                          method: "get",
//                          data: {'products': JSON.stringify(data)},
//                          success: function (res) {
//                              if (res.status) {
//                                  //有库存执行
//                                  $.post('/api/order', {
//                                      'products': JSON.stringify(data),
//                                      'userId':{{Auth()->guard('pc')->user()->id}},
//                                      'code':concessionCode
//                                      }, function (res) {
//                                      if (res.status) {
//                                          localStorage.setItem("order_no", res.data.order_no);
//                                          var ppx = localStorage.getItem("order_no")
//                                          var order_id = res.data.order_id
//                                          //清空购物车
//                                          window.location.href = `/apps/order/details?id=${order_id}`
//                                          localStorage.removeItem("order_no");
//                                          localStorage.removeItem("shopcart");
//                                      } else {
//                                      		if (res.errorCode==6001) {
//                                      			goAddAddress(res.message)
//                                      		} else{
//	                                            swal({
//	                                                title: res.message,
//	                                                type: 'info',
//	                                                showConfirmButton: false,
//	                                            })
//                                      		}
//                                               
//                                      }
//                                  });
////										});
//
//                              } else {
//                                  swal({
//                                      title: res.message,
//                                      type: 'info',
//                                      showConfirmButton: false,
//                                  })
//                              }
//
//                          },
//                          fail: function () {
//
//                          }
//                      });
            }


        });

        //没有默认地址时，跳转地址管理页
        function goAddAddress(abc){
                swal({
                    title: abc,
                    text: LanguageHtml(`前往地址管理页，设置地址。`,`Go to Manage Address  `),
                    type: 'info',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    cancelButtonText: LanguageHtml('返回',"Back"),
                    confirmButtonText: LanguageHtml('确定',"Yes"),
                }).then(function (isConfirm) {
                    if( isConfirm.value){
                    		window.location.href="/apps/address"
                    }
                })
        };

        //底部填充
        $(".cartPro:last").addClass("clearfix");
        $(".cartPro:last").after('<div style="width:100%;height:1px"></div>')
        //底部导航显示当前所在页面样式
        $("#mobile-nav a").eq(2).css({"background": "#4982A3", "color": "#ffffff"})
    </script>
    <style type="text/css">
        .clearfix:before, .clearfix:after {
            display: table;
            content: " ";
        }

        .clearfix:after {
            clear: both;
        }
    </style>

@endsection