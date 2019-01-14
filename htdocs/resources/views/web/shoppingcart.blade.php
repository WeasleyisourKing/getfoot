@extends('web/layout.app')

@section('content')
    <!--中间体-->
    <div class="maxCentr">
        <div class="cartTitle">
            <p>
							<script>
								Language("我的商品","My Product(s)")
							</script>
						</p>
        </div>
        <div class="cartBox">
            <ul class="cartClass clearfloat">
                <li class="am-u-sm-6">
									<script>
										Language("商品信息","Product Information")
									</script>
								</li>
                <li class="am-u-sm-2">
									<script>
										Language("单价","Price")
									</script>
								</li>
                <li class="am-u-sm-2">
									<script>
										Language("数量","Quantity")
									</script>
								</li>
                {{--<li class="am-u-sm-2">运费</li>--}}
                <li class="am-u-sm-2" style="text-align: left;">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
									<script>
										Language("操作","Action")
									</script>
								</li>
            </ul>
            <div id="content">

            </div>
            {{--<div class="labelbox clearfloat ">--}}

            {{--<label class="am-u-sm-4">--}}
            {{--<div class="float_left" style="padding-top: 17%;">--}}
            {{--<div class="joinChoice"></div>--}}
            {{--</div>--}}
            {{--<div class="cartImgBox float_left">--}}
            {{--<img src="/home/img/r10.png" alt="" />--}}
            {{--</div>--}}
            {{--<p class="cartName float_left">小米锅巴500g</p>--}}
            {{--</label>--}}
            {{--<div class="am-u-sm-2">--}}
            {{--<p class="price unitPrice">$ <span>1.15</span></p>--}}
            {{--</div>--}}
            {{--<div class="am-u-sm-2 cartBut clearfloat">--}}
            {{--<div class="float_left increase but" >＋</div>--}}
            {{--<p class="number float_left productNumber">1</p>--}}
            {{--<div class="float_left reduce but">－</div>--}}
            {{--</div>--}}
            {{--<div class="am-u-sm-2">--}}
            {{--<p class="price freight">$ <span>0.00</span></p>--}}
            {{--</div>--}}
            {{--<div class="am-u-sm-2 cartCzBut">--}}
            {{--<div class="but delete" style="margin-bottom: 20px;"><img src="/home/img/cart.png" alt="" /><br />删除</div>--}}
            {{--<!--<div class="but"><img src="/home/img/shoucang.png" alt="" /><br />移入收藏夹</div>-->--}}
            {{--</div>--}}

        <!--<div class="labelbox clearfloat ">
        <label class="am-u-sm-4">
        <div class="float_left" style="padding-top: 17%;">
        <div class="joinChoice"></div>
        </div>
        <div class="cartImgBox float_left">
        <img src="/home/img/r10.png" alt="" />
        </div>
        <p class="cartName float_left">小米锅巴500g</p>
        </label>
        <div class="am-u-sm-2">
        <p class="price unitPrice">$ <span>1.15</span></p>
        </div>
        <div class="am-u-sm-2 cartBut clearfloat">
        <div class="float_left increase but" >＋</div>
        <p class="number float_left productNumber">1</p>
        <div class="float_left reduce but">－</div>
        </div>
        <div class="am-u-sm-2">
        <p class="price freight">$ <span>0.00</span></p>
        </div>
        <div class="am-u-sm-2 cartCzBut">
        <div class="but delete" style="margin-bottom: 20px;"><img src="/home/img/cart.png" alt="" /><br />删除</div>
        <div class="but"><img src="/home/img/shoucang.png" alt="" /><br />移入收藏夹</div>
        </div>
        </div>-->


        <!--<div class="am-form-group clearfloat cartText">
	        <div class="am-u-sm-6" >
		        <div class="tbsm">
							<script>
								Language("优惠类型","Promotion Type")
							</script>
						</div>
		        <div class="text" id="information" style="border: 0;">
			        <div class="cartText2">
				        <p id="queryText"style="line-height: 40px;text-align:  center;">
						</p>	
			        </div>
		        </div>
	        </div>
	        <div class="am-u-sm-6 "style="border-left:1px solid #eaeaea ;">
		        <div class="tbsm" style="background: #f2f2f2;">
							<script>
								Language("优惠名称","Promotion Name")
							</script>
						</div>
		        <div class="cartText2">
			        <!--<p>免运费优惠劵</p>
			        <div class="clearfloat cartText2But" >
			       		<input type="text"placeholder="请出入免运费优惠券代码" / class="float_left"><button class="float_left">使用</button>
			        </div>-->
			        <!-- <p>
								<script>
									Language("优惠劵","Promo Code")
								</script>
							</p>
			        <div class="clearfloat cartText2But">
									<script>
										Language(`<input id="cardNumber" type="text"placeholder="请出入优惠券代码" / class="float_left">`,
											`<input id="cardNumber" type="text"placeholder=" Enter Promo Code" / class="float_left">`)
									</script>
									<button id="query" class="float_left">
										<script>
											Language("使用","Use")
										</script>
									</button>
			        </div>
		        </div>
	        </div>
        </div>-->

        <div id="end" class="cartTj clearfloat">
            <div>
                <div class="allTotal float_left allTo"></div>
                <p class="float_left" style="margin-left: 10px;">
									<script>
										Language("全选","Select All ")
									</script>
								</p>
            </div>
            <a > <button class="float_right  am-btn am-btn-danger  goShop" type="submit">
							<script>
								Language("下订单","下订单")
							</script>
						</button></a>
            <p class="float_right overtotal">
							<script>
								Language("应付总额","Amounts payable")
							</script>
							$<span id="overtotal">0.00</span>
						</p>
            <p class="float_right freight">
							<script>
								Language("运费","Shipping")
							</script>
							$<span>0.00</span>
						</p>
            <!--<p class="float_right ">
							<script>
								Language("税金：<span>待定</span>","Tax：<span>undetermined</span>")
							</script>
							
						</p>-->
            <p class="float_right totalAmount">
							<script>
								Language("商品总额","Total")
							</script>
							$<span id="totalAmount">0.00</span>
						</p>
            <p class="float_right totalGoods">
							<script>
								Language("选择商品","Selected Item(s) ")
							</script>
						<span id="totalGoods">0</span>
							<script>
								Language("件","Item(s)")
							</script>
						</p>
        </div>


        {{--</form>--}}
    </div>
    </div>
    </div>
    <!--中间体-->
    <script>
//  	获取优惠卷信息
//		优惠码
		var concessionCode="";
//		优惠类型
		var couponType=null;
//		优惠力度
		var concessionalRate=null;
//		优惠名
		var concessionalName=null;

		$("#query").click(function(){
         $.ajax({
	             url:'/api/discount/use',
	             type: 'get',
	             data: {
			            	code:$("#cardNumber").val()
					},
	             success: function(data){
	             	if(data.status){
	             		$("#queryText").html(`${LanguageHtml("优惠类型","Promotion Type")}：${data.data.name}<br>${LanguageHtml("优惠","Promo")}：${data.data.rcent}`)
//	             		$("#information small").eq(1).html(data.data.name);
//	             		$("#information small").eq(3).html(data.data.rcent);
		             		couponType=parseFloat(data.data.type);
		             		concessionalRate=parseFloat(data.data.rcent);
		             		concessionalName=data.data.rcent;
		             		concessionCode=$("#cardNumber").val(); 
		             		Valuation();
	             	}else{
			            swal({
			                title:data.message,
			                type: 'info',
			                showConfirmButton: true,
			
			            })
//	             		alert(data.message)
	             		$("#queryText").html()
						 concessionCode="";
						 couponType=null;
						 concessionalRate=null;
						 concessionalName=null;
		             		Valuation();
	             	}
	             },
                	 error: function (data) {
		            swal({
		                title:"数据请求失败",
		                type: 'error',
		                showConfirmButton: true,
		
		            })
                }
	         });
			
		})
    	
//  	获取邮费和包邮额度
    var threshold =0;
    var freight =0;
//  计算总金额函数
    	function Valuation() {
			var total = 0;
			var totalnumber = 0;
			if( $(".cartBox .labelbox").length>0){
				for (var i = 0; i < $(".cartBox .labelbox").length; i++) {
					if ($(".cartBox .labelbox").eq(i).find(".joinChoice").hasClass("joinChoiceShow")) {
						totalnumber++;
						var Price = $(".cartBox .labelbox").eq(i).find(".unitPrice").find("span").html();
						var Num = $(".cartBox .labelbox").eq(i).find(".productNumber").html();
			//          var Freight = $(".cartBox .labelbox").eq(i).find(".freight").find("span").html();
			//          total += Price * Num + parseInt(Freight);
						total += Price * Num ;
					}
					var freightNew=total>threshold?0:freight;
					function freightActual(){
							if(freightNew>0){
								return `${freightNew.toFixed(2)}`
							}else{
								return ""
							}
					};
					total=function(){
							if(couponType==1){
								return parseFloat(total)-parseFloat(concessionalRate)>0?parseFloat(total)-parseFloat(concessionalRate):0
							}else if(couponType==2){
								return total*(1-parseFloat(concessionalRate)/100)
							}else{
								return parseFloat(total)
							}
						}();
			//       console.log(total)
			//       total=totalEnd();
					$("#totalAmount").html(total.toFixed(2))
					$("#freight").html(freightActual())
					if(freightActual()==""){
							$(".freight").hide()
					}else{
							$(".freight").show()
					}
					$("#totalGoods").html(totalnumber)
					$("#overtotal").html((total*1+freightActual()*1).toFixed(2))
				}
			}else{

				$("#totalAmount").html('0.00')
				$("#freight").hide()
				$("#totalGoods").html('0.00')
				$("#overtotal").html('0.00')
			}
		};
//		获取localStorage中的购物车数据
        var product = localStorage.getItem("myCart") ? JSON.parse(localStorage.getItem("myCart")) : '';
	function productList(){
        var text = '';
        if (product.length == 0) {
            //没有购物车
            text = `<h3 style="text-align: center;">${LanguageHtml("没有添加商品","No Item Added ")}</h3>`;
        } else {
            //have localStorage
            for (let i in product) {
                text += `<div class="labelbox clearfloat ">
            <label class="am-u-sm-6">
                <div class="float_left" style="padding-top: 17%;">
                <div class="joinChoice joinChoiceShow"></div>
                </div>
            <div class="cartImgBox float_left">
                <img class="myImg" src="${product[i].img}" alt="" />
                </div>
                <p class="cartName float_left">${LanguageHtml(product[i].zn_name,product[i].en_name)}</p>
                </label>
                <div class="am-u-sm-2">
                <p class="price unitPrice myPrice">$ <span>${product[i].price}</span></p>
                </div>
                <div class="am-u-sm-2 cartBut clearfloat">
			        <div class="float_left increase but" style="cursor:pointer " >＋</div>
                 		 <p class="productNumber myNumber number float_left ">${product[i].count}</p>
			        <div class="float_left reduce but" style="cursor:pointer " >－</div>
            </div>
                <div class="am-u-sm-2 cartCzBut">
                <div class="but delete" data-id="${product[i].product_id}" onclick="delFunc(this);" style="margin-bottom: 20px;"><img src="/home/img/cart.png" alt="" /><br />${LanguageHtml('删除','Delete')}</div>
                </div>
                </div>`;
            }
            //show Settlement
            $('#end').show();
        }
		$('#content').html(text);
		console.log('渲染')
		
	};
	productList();


        //localStorage delete product
        var delFunc =function(event){
        	swal({ 
		  title: "确定删除吗？", 
//		  text: "你将无法恢复该虚拟文件！", 
		  type: "warning",
		  showCancelButton: true, 
		  confirmButtonColor: "#DD6B55",
		  confirmButtonText: "确定删除！", 
		  cancelButtonText: "取消删除！",
		  closeOnConfirm: false, 
		},
		function(isConfirm){
			if (isConfirm) {
				delFunction(event)
			}
		}
		)

//		.then((value)=>{
//			if (value) {
//				delFunction(event)
//			} 
//		})
       };
         function delFunction(event) {
            for (var item in product) {
                var status = -1;
                //判断是否有相同的
                if (shop[item].product_id == $(event).attr('data-id')) {
                    status = item;
                    break;
                }
            }
            if (status != -1) {
                //通过id 删除
               product.splice(item,1);
               localStorage.setItem("myCart", JSON.stringify(product));
		       $(event).parents(".labelbox").remove();
				productList();
		       	Valuation();
	            swal({
	                title:"删除成功",
	                type: 'success',
	                showConfirmButton: true,
	
	            })
            } else {
//              alert("无法通过ID找到产品");
	            swal({
	                title:"无法通过ID找到产品",
	                type: 'info',
	                showConfirmButton: true,
	
	            })
            }
        }
    </script>
    <script>
    	var func = function() {
            if($(".joinChoiceShow").length==0){
	            swal({
	                title:"您还没有选择商品",
	                type: 'warning',
	                showConfirmButton: true,
	
	            })
//  			alert("您还没有选择商品");
    			return
    		}

        }
    	//选中的localStorage
    	$(".goShop").click(function(){
    		if($(".joinChoiceShow").length==0){
            swal({
                title:"您还没有选择商品",
                type: 'warning',
                showConfirmButton: true,

            })
    			return
    		}
	    		//查库存
    			var data=[];
			    for (let i=0;i<$(".labelbox").length;i++) {
			    	//判断是否选中
		    		if($(".labelbox").eq(i).find(".joinChoice").hasClass("joinChoiceShow")){
					    var shop = {
					        'count' : $(".labelbox").eq(i).find(".myNumber").html(),
			          		'product_id' : $(".labelbox").eq(i).find(".delete").attr('data-id'),
			                }
		                data.push(shop);
		    		};
	           };
				$.ajax({
					url:"/api/check/product",
					method:"get",
					data:{'products': JSON.stringify(data)},
					success:function(res){
						//库存足够执行
						if(res.status){
    						var shopCart=new Array();
				    		var	doto={};
					    	for(i=$(".labelbox").length-1;i>-1;i--){
					    		if($(".labelbox").eq(i).find(".joinChoice").hasClass("joinChoiceShow")){
//					    			删除并存储选中的商品
					    			product.splice( i, 1 )
					    			doto = {
				                        'count': $(".labelbox").eq(i).find(".myNumber").html(),
				                        'product_id': $(".labelbox").eq(i).find(".delete").attr('data-id'),
//				                        'name':  $(".labelbox").eq(i).find(".cartName").html(),
//				                        'price': $(".labelbox").eq(i).find(".myPrice").find("span").html(),
//				                        'img': $(".labelbox").eq(i).find(".myImg").attr('src'),
				                   };
				                    shopCart.push(doto);
					    		};
					    	};
//					    	localStorage.setItem("shopCart", JSON.stringify(shopCart));

						//下单
			            $.post('/api/business/order', 
				            {
					            	'products': JSON.stringify(shopCart),
					            'userId':{{Auth()->guard('pc')->user()->id}},
				            		'code':concessionCode
				            }, 
				            function (res) {
				                if (res.status) {
//				                		localStorage.setItem("totalPrice",totalPrice);
				                    localStorage.setItem("order_id",res.data.order_id);
						            swal({
						                title:LanguageHtml("下订单成功","shopping car check out"),
						                type: 'success',
						                showConfirmButton: true,
						
						            })
//				                    alert('下订单成功');

				                    setTimeout(function(){
	            							window.open('/order/confirm/{{Auth::guard("pc")->user()->id}}','_self');
				                    },2000)
					    				localStorage.setItem("myCart", JSON.stringify(product));
				                } else {
//				                    alert(res.message);
						            swal({
						                title:res.message,
						                type: 'warning',
						                showConfirmButton: true,
						
						            })
				                }
			            });
			            //
//          				window.open("/order/confirm/{{Auth::guard("pc")->user()->id}}",'_self') ;
						}else{
				            swal({
				                title:res.message,
				                type: 'warning',
				                showConfirmButton: true,
				
				            })
//							alert(res.message)
							return false;
						}
					}
				})
//	    	console.log(shopCart);
//	    	console.log(product);
    	});
    	Valuation()
    </script>
@endsection
