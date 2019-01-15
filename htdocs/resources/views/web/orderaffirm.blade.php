@extends('web/layout.app')


@section('content')

    <!-- 添加 Modal -->
    <!--<div id="add" class="modal fade" role="dialog">
        <div class="modal-dialog">-->

            <!-- Modal content-->
            <!--<div class="modal-content">
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">
            <script>
            	Language("添加订单","Add New Order")
            </script></h4>
                </div>

                <div class="modal-body">
                    <div class="form-group">
                        <label class="control-label" for="name">
            <script>
            	Language("收件人（最多40字）","Recipient")
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
            <script>
            	Language("联系电话","Phone Number")
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
            <script>
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
            <script>
            	Language("公寓号、楼号","Apt, suite, building, etc (optional) ")
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
            <script>
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
            <script>
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
            <script>
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
            <script>
            	Language("关闭","Close")
            </script></button>
                        <button onclick="addAddress();" type="button" data-id=""
                                class="btn btn-primary waves-effect waves-light"><i class="fa fa-save"></i> 
            <script>
            	Language("添加","Add ")
            </script>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>-->
    <!--中间体-->
    <div class="maxCentr addressBox">
        <div class="addressTop clearfloat">
            <p class="float_left">
            <script>
            	Language("选择收货地址","Select Shipping Address")
            </script></p>
            {{--<a class="float_right" href="">使用新地址</a>--}}
        </div>
        <ul class="address clearfloat" id="address_choice">
            <!--<div class=" am-u-sm-4">
                @if (!empty($data))
                <li class="addressPro">

                        <div class="float_left">{{$data['name']}}</div>
                        <div class="float_right">{{$data['mobile']}}</div>
                        <div class="text"
                             style="clear: both;">{{$data['detail']}}{{$data['country']}}{{$data['city']}}{{$data['province']}}</div>
                        {{--<a href=""> 修改</a>--}}
                    @else
                        <div class="float_left " data-toggle="modal"
                             data-target="#add">没有填写地址,点击添加</div>
                    @endif
                </li>
            </div>-->
        </ul>
    </div>
    <div class="maxCentr">
        <div class="cartTitle">
            <p>
            <script>
            	Language("我的商品","My Product(s)")
            </script></p>
        </div>
        <div class="cartBox">
            <ul class="cartClass clearfloat">
                <li class="am-u-sm-4">
            <script>
            	Language("商品信息","Product Information")
            </script></li>
                <li class="am-u-sm-4">
            <script>
            	Language("单价","Price ")
            </script></li>
                <li class="am-u-sm-4">
            <script>
            	Language("数量","Quantity")
            </script></li>
                {{--<li class="am-u-sm-2">运费</li>--}}
                {{--<li class="am-u-sm-2" style="text-align: left;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;操作</li>--}}
            </ul>
            <div id="content">

            </div>
            {{--<div class="am-form-group clearfloat cartText">--}}
            {{--<div class="am-u-sm-6" >--}}
            {{--<div class="tbsm">特别说明</div>--}}
            {{--<div class="text">--}}
            {{--<textarea name="" id="" cols="30" rows="10"></textarea>--}}
            {{--</div>--}}
            {{--</div>--}}
            {{--<div class="am-u-sm-6 "style="border-left:1px solid #eaeaea ;">--}}
            {{--<div class="tbsm" style="background: #f2f2f2;">优惠用劵</div>--}}
            {{--<div class="cartText2">--}}
            {{--<p>免运费优惠劵</p>--}}
            {{--<div class="clearfloat cartText2But" >--}}
            {{--<input type="text"value="请出入免运费优惠券代码" / class="float_left"><button class="float_left">使用</button>--}}
            {{--</div>--}}
            {{--<p>优惠劵</p>--}}
            {{--<div class="clearfloat cartText2But">--}}
            {{--<input type="text"value="请出入优惠券代码" / class="float_left"><button class="float_left">使用</button>--}}
            {{--</div>--}}
            {{--</div>--}}
            {{--</div>--}}
            {{--</div>--}}
            {{--<div>--}}
            <div id="end" class="cartTj clearfloat">
                <a>
                    <div class="goshopping float_left"><img src="home/img/goshoppingcart.png" alt=""/></div>
                    <!--<a href="/shop/cart/{{Auth()->guard('pc')->user()->id}}">-->
                    <a href="##">
                    	<!--<p class="float_left"style="margin-left: 10px;"> 返回购物车</p>-->
                    </a>
                </a>
                <button class="float_right" type="submit" class="am-btn am-btn-primary">
            <script>
            	Language("已下单","已下单")
            </script></button>
                <!--<p  class="float_right totalAmount">
            <script>
            	Language("应付金额","Amounts payable")
            </script>$<span id="pricePro">0.00</span></p>
                <p class="float_right totalGoods">
            <script>
            	Language("选择商品","Select product")
            </script><span id="shopPro">0</span>
            <script>
            	Language("件","Piece")
            </script></p>-->
            <p class="float_right Amounts payable">
							<script>
								Language("应付总额","Amounts payable")
							</script>
							$<span>$0.00</span>
						</p>
            <p class="float_right freight"style="display: none;">
							<script>
								Language("运费","Shipping")
							</script>
							$<span>$0.00</span>
						</p>
            <p class="float_right tax" style="display: none;">
							<script>
								Language("税金：","Tax：")
							</script>$<span></span>
							
						</p>
            <p class="float_right totalAmount">
							<script>
								Language("商品总额","Total")
							</script>
							$<span>$0.00</span>
						</p>
            <p class="float_right totalGoods">
							<script>
								Language("选择商品","Selected Item(s) ")
							</script>
						<span>0</span>
							<script>
								Language("件","Item(s)")
							</script>
						</p>
            </div>
            {{--</form>--}}
        </div>
    </div>
    </div>

    <script>
    	
	localStorage.removeItem("totalPrice");
    localStorage.removeItem("order_no");
    	
    	
	//获取订单id
	var Http= localStorage.getItem("order_id") 
//  	请求订单信息
	$.ajax({
        // url: '/api/users/order/details',
        url: '/api/business/order/details',
        method: 'get',
        data: {
            'id':Http
        },
        success: function (data) {
        		var product=data.products
        		var text = '', number = 0;
            for (let i in product) {
                number += parseInt(product[i].count) ;
                text += `<div class="labelbox clearfloat ">
            <label class="am-u-sm-4">

            <div class="cartImgBox float_left">
                <img src="${product[i].products.product_image}" alt="" />
                </div>
                <p class="cartName float_left towLine">${LanguageHtml(product[i].products.zn_name,product[i].products.en_name)}</p>
                </label>
                <div class="am-u-sm-4">
                <p class="price unitPrice">$ <span>${Sprice1(product[i].products.distributor.level_four_price,product[i].products.distributor.level_two_price,product[i].products.distributor.level_one_price,product[i].products.distributor.level_three_price)}</span></p>
                </div>
                <div class="am-u-sm-4 cartBut clearfloat">
                  <p class="price unitPrice"><span>${product[i].count}</span></p>
            </div>

                </div>`;
            }
            $('.Amounts span').html(data.details.total_price);
            $('.totalGoods span').html(number);
            $(".freight span").html("")
            $(".tax span").html("")
             $(".totalAmount span").html(data.details.total_price)
            //show Settlement
            $('#end').show();
            $('#content').append(text);
        		localStorage.setItem("totalPrice",data.details.total_price);
            localStorage.setItem("order_no",data.details.order_no);
        },
        error: function () {
            swal({
                title:"数据请求失败",
                type: 'error',
                showConfirmButton: true,

            })

        }
      });
    </script>

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
			                title:json.data,
			                type: 'warning',
			                showConfirmButton: true,
			            })

                    } else {
			            swal({
			                title:LanguageHtml('添加成功',"Added"),
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
		                title:LanguageHtml("数据请求失败","Failed to Proceed Request"),
		                type: 'error',
		                showConfirmButton: true,
		
		            })
                }
            })

        }
        
        
            var totalPrice=$("#pricePro").html();
            console.log(totalPrice);
        var OrderDown = function () {
//      	修改订单地址
	    		$.ajax({
		    		url: '/api/edit/user/editAddress',
		            method: 'get',
		            data: {
		                'id':{{Auth()->guard('pc')->user()->id}},
		                'order_id':Http,
		                'address_id':$(".orderShow").attr("oder_id")
		            },
		            success: function (data){
		            		//跳转支付页面
            				window.open("/pay/paypal","_self");
		            },
		            error:function(data){
//		            		alert("请求错误！")
		            swal({
		                title:LanguageHtml("请求错误！","Failed to Proceed!"),
		                type: 'error',
		                showConfirmButton: true,
		            })
		            }
			});
        }
    </script>
    <script type="text/javascript">
    	
    	//绑定所有地址选项
    		 $.ajax({
    	 		url: '/api/apps/order/address',
                method: 'get',
                data: {
                    'id':{{Auth()->guard('pc')->user()->id}}
                },
                success: function (data){
                	console.log(data)
                	var Address=data
                	var address_json_text=""
                	var address_json_top_text=""
                	if(data.length<1){
                		
                		$(".address").html(`<div class='float_left'data-toggle='modal'data-target='#add'>${LanguageHtml("没有填写地址,点击添加"," An Address Is Needed, CLICK to Add ")}</div>`);
                        return
                	}
                	for (var i = 0; i<data.length ; i++) {
                		if(Address[i].default=="1"){
                			address_json_top_text+=`
                			<div class=" am-u-sm-4">
				    			<li class="addressPro" oder_id="${Address[i].id}" order_zip="${Address[i].zip}" order_city="${Address[i].city}">
			                        <div class="float_left">${Address[i].name}</div>
			                        <div class="float_right">${Address[i].mobile}</div>
			                        <div class="text"style="clear: both;">${Address[i].detail+" "+Address[i].country+" "+Address[i].city+" "+Address[i].province }</div>
		                		</li>
	                		</div>`
                		}else{
                			address_json_text+=`
                			<div class=" am-u-sm-4">
				    			<li class="addressPro" oder_id="${Address[i].id}"  order_zip="${Address[i].zip}" order_city="${Address[i].city}">
			                        <div class="float_left">${Address[i].name}</div>
			                        <div class="float_right">${Address[i].mobile}</div>
			                        <div class="text"style="clear: both;">${Address[i].detail+" "+Address[i].country+" "+Address[i].city+" "+Address[i].province }</div>
		                		</li>
	                		</div>`
                		}
                		$(".address").html(address_json_top_text+address_json_text);
			    	 	//地址选项
						    $(".addressPro ").eq(0).addClass("orderShow");
						    $(".addressPro").click(function () {
			                		var That=$(".addressPro").index(this)
								$.ajax({
							    	 		url: `/api/tax/zip/${$(this).attr("order_zip")}/city/${$(this).attr("order_city")}`,
							                method: 'get',
							                success: function (data){
							                			if(data.status){
							                				var newTax=data.data.tax
											            $('.Amounts span').html(($(".totalAmount span").eq(0).html()*1+$(".totalAmount span").eq(0).html()*newTax+$(".freight span").eq(0).html()*1).toFixed(2));
											            $(".tax span").html(($(".totalAmount span").eq(0).html()*newTax).toFixed(2));
							                				 $(".addressPro").removeClass("orderShow");
										       			  $(".addressPro").eq(That).addClass("orderShow");
							                			}else{
											            swal({
											                title:data.message,
											                type: 'error',
											                showConfirmButton: true,
											
											            })
							                			}
							                },
									        error: function () {
									            swal({
									                title:"数据请求失败",
									                type: 'error',
									                showConfirmButton: true,
									
									            })
									
									        }
								})
						    });

                	}		
    				$("#address_choice .am-u-sm-4").eq($("#address_choice .am-u-sm-4").length-1).addClass("am-u-end");
                }
				
			});
    </script>
	<script type="text/javascript">
//		$.ajax({
//	    	 		url: '/api/tax/zip/1/city/longbeach',
//	                method: 'get',
//	                success: function (data){
//	                		console.log(data)
//	                }
//		})
	</script>
@endsection
