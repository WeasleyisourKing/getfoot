@extends('web/layout.app')

@section('content')

	@include('web/layout.category')
	<style>
		.comments{
			resize:none;
			width:100%;
			height:70px;
			margin-top:20px;
		}
		.commentbtn{
			overflow-y:hidden;	
		}
		.commentbtn button{
			float:right;
		}
	</style>
	<!--中间体-->
		

		<!--中间体-->
			<div class="maxCentr clearfloat">
				<div class="personalLeft float_left">
					<div class="protraitsBg">
						<div class="protraits">
							<img src="{{ Auth::guard('pc')->user()->avatar }}" alt="" />	
						</div>
							<p>{{ Auth::guard('pc')->user()->name }}</p>
					</div>
					<ul class="personalList ">
						<li class=" clearfloat" onclick="orderStatus()">
							<img src="home/img/1personal.png" alt="" />
							<img src="home/img/11personal.png" alt="" />
							<p>
							<script>
				                Language("个人中心","My Account")
				            </script>
							</p>
						</li>
						<!--<li class=" clearfloat">
							<img src="home/img/2personal.png" alt="" />
							<img src="home/img/22personal.png" alt="" />
							<p>
							<script>
								Language("账户设置","Account Setting")
							</script>
							</p>
						</li>-->
						<li class=" clearfloat">
							<img src="home/img/3personal.png" alt="" />
							<img src="home/img/33personal.png" alt="" />
							<p>
							<script>
								Language("修改密码","Change Password")
							</script>
							</p>
						</li>
						<!--<li class=" clearfloat">
							<img src="home/img/4personal.png" alt="" />
							<img src="home/img/44personal.png" alt="" />
							<p>
							<script>
								Language("我的评论","My Reviews")
							</script>
							</p>
						</li>-->
						<!--<li class=" clearfloat">
							<a href="/shop/cart/{{Auth()->guard('pc')->user()->id}}">
								<img src="home/img/5personal.png" alt="" />
								<img src="home/img/55personal.png" alt="" />
								<p>
								<script>
									Language("购物车","Shopping Cart")
								</script>
								</p>
							</a>
						</li>-->
						<li class=" clearfloat" onclick="showOrder()">
							<img src="home/img/6personal.png" alt="" />
							<img src="home/img/66personal.png" alt="" />
							<p>
							<script>
								Language("我的订单","My order")
							</script>
							</p>
						</li>
						<li class=" clearfloat" id="addressText" onclick="showAddress()">
							<img src="home/img/7personal.png" alt="" />
							<img src="home/img/77personal.png" alt="" />
							<p>
							<script>
								Language("地址管理","Manage Address")
							</script>
							</p>
						</li>
					</ul>
				</div>
				<div class="personalRight float_left">
					<!--账户概况-->
					<div class="personalPro">
						<div class="information clearfloat">
							<div class="text float_left" style="border-right: 1px solid #666666;">
								<p>
									<script>
										Language("手机号码","Phone Number ")
									</script>:
									{{$user['mobile']}}
								</p>
								<p>
									<script>
										Language("邮箱","Email")
									</script>:
									{{Auth::guard('pc')->user()->email}}
								</p>
							</div>
							<div class="text float_left">
								<p class="towLine">
									<script>
										Language("收货地址","Shipping Address")
									</script>:
									{{$user['detail']}}  {{$user['country']}}  {{$user['city']}}  {{$user['province']}}
								</p>
							</div>
						</div>
						<div class="Title clearfloat">
							<img class="float_left" src="home/img/user_2.png" alt="" />
							<p class="float_left">
								<script>
									Language("浏览过的商品"," Recently Viewed ")
								</script>
							</p>
						</div>
						<ul class="lockPro clearfloat">
							<li><img src="" alt="" /></li>
							<li><img src="" alt="" /></li>
							<li><img src="" alt="" /></li>
							<li><img src="" alt="" /></li>
							<li><img src="" alt="" /></li>
						</ul>
					<div class="myOder hide">
						<ul class="clearfloat" id="myOderStatus">
							<li>
								<script>
									Language("待付款","Waiting for payment")
								</script><span>0</span></li>
							<li>
								<script>
									Language("待发货"," Waiting for Shipment")
								</script><span>0</span></li>
							<li>
								<script>
									Language("待收货","Waiting for Delivered")
								</script><span>0</span></li>
							<li style="border: 0;">
								<script>
									Language("已完成的订单","Completed Order")
								</script><span>0</span></li>
						</ul>
					</div>
					<script type="text/javascript">
						$(document).ready(function(){
					});
					</script>
					</div>
					
						
					<!--账户设置-->
					<!--<div class="personalPro">
						<div class="account">
							<form action="/UpdatePersonal" method="post" enctype="multipart/form-data"  >
								<div class="am-form-group am-form-file">
								    <button type="button" class="am-btn am-btn-default am-btn-sm am-center">
								    	<i class="am-icon-cloud-upload"></i>	
											<script>
												Language("选择要上传的头像","Select A Profile Picture ")
											</script>
								    </button>
									<input type="hidden" name="_token"class="btn btn-primary" value="{{csrf_token()}}"/>
	  								<input type="file" name="img" multiple>
								</div>
							<ul class="accountText">
								<li class="clearfloat">
									<p class="float_left">
										<script>
											Language("名称","Nickname")
										</script>
									</p>
									<input name="name" class="float_left" type="text" placeholder="{{ Auth::guard('pc')->user()->name }}"/>
								</li>
					{{-- <li class="clearfloat">
									<p class="float_left">邮箱</p>
									<input class="float_left" type="text" placeholder=" 请输入邮箱"/>
								</li>
								<li class="clearfloat">
									<p class="float_left">手机号码</p>
									<input class="float_left" type="text" placeholder=" 请输入手机号码"/>
								</li> --}}

							</ul>
							<button type="submit" class="accountBut am-center">
								<script>
									Language("保存","Save")
								</script>
							</button>
							</form>
						</div>
					</div>-->
					<!--密码修改-->
					<div class="personalPro ">
						<div class="account">
							<form action="/pc/epassword" method="get">
							<ul class="accountText cipherText">
								<li class="clearfloat">
									<p >
										<script>
											Language("原密码","Old Password")
										</script>
									</p>
									<script>
										Language(`<input name="oldPasswd" type="password" placeholder=" 请输入原密码"/>`,
										`<input name="oldPasswd" type="password" placeholder=" Enter Old Password "/>`)
									</script>
								</li>
								<li class="clearfloat">
									<p >
										<script>
											Language("新密码","Enter Old Password")
										</script>
									</p>
									<script>
										Language(`<input name="newPasswd" type="password" placeholder=" 请输入新密码"/>`,
										`<input name="newPasswd" type="password" placeholder=" Enter New Password"/>`)
									</script>
								</li>
								<li class="clearfloat">
									<p >
										<script>
											Language("请再次输入新密码","Re-enter New Password")
										</script>
									</p>
									<script>
										Language(`<input name="newPasswd2" type="password" placeholder=" 请输入新密码"/>`,
										`<input name="newPasswd2" type="password" placeholder=" Enter New Password"/>`)
									</script>
								</li>
							</ul>
							<button type="submit" class="accountBut">
								<script>
									Language("修改","Edit")
								</script>
							</button>
							</form>
						</div>
					</div>
					<!--评论管理-->
					<!--<div class="personalPro">
						<div class="comment">
							<div class="commentTitle">
								<script>
									Language("我的评论","My Reviews")
								</script>
							</div>
							<div class="commentList">
								<ul class="commentHead am-g">
									<li class="am-u-sm-4">
										<script>
											Language("评论 ","Reviews")
										</script>
									</li>
									<li class="am-u-sm-3">
										<script>
											Language("评论商品","Reviewed Product")
										</script>
									</li>
									<li class="am-u-sm-3">
										<script>
											Language("商品信息","Product Information")
										</script>
									</li>
									<li class="am-u-sm-2">
										<script>
											Language("状态","Status")
										</script>
									</li>
								</ul>
								<ul class="commentPro " id="commentPro">
									<li class="am-g">
										<div class="am-u-sm-4">
											<div class="time">[2018-06-20/18：36：23]</div>
											<p class="myComment">[name] 
												<script>
													Language("[name]  山东省发生的根深蒂固受到粉丝的受到粉丝的粉丝市市是否",
														"[name]  Shandong province is deeply rooted by fans of the fans of the fans of the city")
												</script>
											</p>
											<p class="buyComment">
												<script>
													Language("[12buy回复]实打实的啊啊 dasd 啊阿斯顿阿斯顿啊 打算阿三!",
														"[12buy reply]Solid ah, dasd, aston, aston, plan ah-3!")
												</script>
											</p>
										</div>
										<div class="am-u-sm-3 ">
											<div class="personalProBox">
												<img src="img/r10.png" alt="" />
											</div>
										</div>
										<div class="am-u-sm-3 personalProText">
											<p class="personalProTitle">小米锅巴</p>
											<p class="personalProWeight">500g</p>
											<p class="totalPrice">$ <span>1.15</span></p>
										</div>
										<div class="am-u-sm-2">
											<div class="commentBut">
												<script>
													Language("匿名评价","Anonymous evaluation")
												</script>
											</div>
										</div>
									</li>
								</ul>
							</div>
						</div>
					</div>-->
				
					<!--<div class="personalPro">
						<!--购物车-->
					<!--</div>-->
					<!--我的订单-->
					<div class="personalPro" >
						<ul class="oderNav clearfloat" id="oderNav">
							<li>
								<script>
									Language("所有订单","All orders")
								</script>
								<span></span>
							</li>
							<li >
								<script>

									Language("已完成","Completed")
								</script>
								<span></span>
							</li>
							<li>
								<script>
									Language("已下单","Unpaid")
								</script>
								<span></span>
							</li>
							<li ><img src="" alt="" />
								<script>
									Language(" ","")
								</script>
								<span></span>
							</li>
							<li ><img src="" alt="" />
								<script>
									Language(" "," ")
								</script>
								<span></span>
							</li>
							<li><img src="" alt="" />
								<script>
									Language(" "," ")
								</script>
							</li>
						</ul>
						<ul class="oderPro" id="oderPro">
							<li></li>
							<li>
								<div class="oderPro_2_title clearfloat">
									<div style="width: 30%;">
										<script>
											Language("商品信息"," Product Information ")
										</script>
									</div>
									<div >
										<script>
											// Language("单价","Price")
										</script>
										&nbsp;
									</div>
									<div >
										<script>
											Language("数量","Quantity")
										</script>
									</div>
									<div >
										<script>
											Language("运费","Shipping")
										</script>
									</div>
									<div >
										<script>
											Language("商品总额","Total")
										</script>
									</div>
									<div >
										<script>
											Language("操作","Action")
										</script>
									</div>
								</div>
								<div class="oderPro_2_details" id="allOrderHtml">
								</div>
							</li>
						</ul>
						<!--订单详情-->
						<div class="oderDetail" id="oderDetail">
						</div>
						<!--end订单详情-->
						
					</div>
				
					<!--收货地址-->
					<div class="personalPro">
						<!--<div class="personalPro_newAddress">
							<div class="addressTitle clearfloat">
								<p class="float_left">
									<script>
										Language("新增收货地址"," Add New Shipping Address")
									</script>
								</p>
							</div>
							<div class="newAddress">
								<div class="clearfloat">
									<div class="float_left newAddress_text">
										<p class="float_left">
											<script>
												Language("名","First Name")
											</script>
										</p>
										<script>
											Language(`<input class="float_left" type="" name="" id="f-name" placeholder="请输入名" />`,
												`<input class="float_left" type="" name="" id="f-name" placeholder="Enter First Name" />`)
										</script>
									</div>
									<div class="float_left newAddress_text">
										<p class="float_left">
											<script>
												Language("姓","Last Name")
											</script>
										</p>
										<script>
											Language(`<input class="float_left" type="" name="" id="l-name" placeholder="请输入姓" />`,
												`<input class="float_left" type="" name="" id="f-name" placeholder="Enter Last Name" />`)
										</script>
									</div>
									<div class="float_left newAddress_text">
										<p class="float_left">
											<script>
												Language("手机号码","Phone Number")
											</script>
										</p>
										<script>
											Language(`<input class="float_left" type="" name="" id="mobile" placeholder="请输入手机号码" />`,
												`<input class="float_left" type="" name="" id="mobile" placeholder="Enter Phone Number " />`)
										</script>
									</div>
									<div class="float_left newAddress_text">
										<p class="float_left">
											<script>
												Language("邮政编号","Zip code")
											</script>
										</p>
										<script>
											Language(`<input class="float_left" type="" name="" id="zip" placeholder="请输入邮政编号" />`,
												`<input class="float_left" type="" name="" id="zip" placeholder="Enter Zip Code" />`)
										</script>
									</div>
									<div class="float_left newAddress_text2 newAddress_text">
										<p class="float_left">
											<script>
												Language("街道地址","Street Address")
											</script>
										</p>
										<script>
											Language(`<input class="float_left" type="" name="" id="country" placeholder="请输入街道地址" />`,
												`<input class="float_left" type="" name="" id="country" placeholder="Enter Street Address" />`)
										</script>
									</div>
									<div class="float_left newAddress_text2 newAddress_text">
										<p class="float_left">
											<script>
												Language("公寓号、楼号","Enter Street Address ")
											</script>
										</p>
										<script>
											Language(`<input class="float_left" type="" name="" id="detail" placeholder="请输入公寓号、楼号" />`,
												`<input class="float_left" type="" name="" id="detail" placeholder="Apt, suite, building, etc (optional)" />`)
										</script>
									</div>
									<div class="float_left newAddress_text3 newAddress_text">
										<p class="float_left">
											<script>
												Language("城市","City")
											</script>
										</p>
										<script>
											Language(`<input class="float_left" type="" name="" id="city" placeholder="请输入城市" />`,
												`<input class="float_left" type="" name="" id="city" placeholder="Enter City" />`)
										</script>
									</div>
									<div class="float_left newAddress_text4 newAddress_text">
										<p class="float_left">
											<script>
												Language("州","State")
											</script>
										</p>
										<div  class="float_left">
											  <select name="test"  id="province" required data-am-selected="{searchBox: 1}">
											    <option value=""></option>
											    <option value="a">Apple</option>
											    <option value="b">Banana</option>
											    <option value="o">Orange</option>
											  </select>
										</div>
									</div>
								</div>
								<div class="clearfloat">
									<p class="float_right">
										<script>
													Language("设置默认收货地址","Set As Primary Address")
										</script>
									</p>
									<div class="float_right default" default="2"   id="defaultCheck1"></div>
								</div>
								<div class="but1" onclick="addAddress();">
									<script>
										Language("保存","Save")
									</script>
								</div>
							</div>
						</div>-->
						<!-- 修改地址 -->
						<!--<div class="Modify" id="Modify">
							<div class="addressTitle clearfloat">
								<p class="float_left">
									<script>
										Language("修改收货地址"," Edit Shipping Address ")
									</script>
								</p>
							</div>
							<div class="newAddress">
								<div class="clearfloat">
									<div class="float_left newAddress_text">
										<p class="float_left">
											<script>
												Language("名","First name")
											</script>
										</p>
										<script>
											Language(`<input class="float_left" type="" name="" id="e-name" placeholder="请输入名" />`,
											`<input class="float_left" type="" name="" id="e-name" placeholder="Enter First Name" />`)
										</script>
									</div>
									<div class="float_left newAddress_text">
										<p class="float_left">
											<script>
												Language("姓","Last name")
											</script>
										</p>
										<script>
											Language(`<input class="float_left" type="" name="" id="e-name" placeholder="请输入姓" />`,
											`<input class="float_left" type="" name="" id="e-name" placeholder="Enter Last Name " />`)
										</script>
									</div>
									<div class="float_left newAddress_text">
										<p class="float_left">
											<script>
												Language("手机号码","Phone Number")
											</script>
										</p>
										<script>
											Language(`<input class="float_left" type="" name="" id="e-mobile" placeholder="请输入手机号码" />`,
											`<input class="float_left" type="" name="" id="e-mobile" placeholder="Enter Phone Number " />`)
										</script>
									</div>
									<div class="float_left newAddress_text">
										<p class="float_left">
											<script>
												Language("邮政编号","Zip code")
											</script>
										</p>
										<script>
											Language(`<input class="float_left" type="" name="" id="e-zip" placeholder="请输入邮政编号" />`,
											`<input class="float_left" type="" name="" id="e-zip" placeholder=" Enter Zip Code" />`)
										</script>
									</div>
									<div class="float_left newAddress_text2 newAddress_text">
										<p class="float_left">
											<script>
												Language("街道地址","Street Address")
											</script>
										</p>
										<script>
											Language(`<input class="float_left" type="" name="" id="e-country" placeholder="请输入街道地址" />`,
											`<input class="float_left" type="" name="" id="e-country" placeholder="Enter Street Address" />`)
										</script>
									</div>
									<div class="float_left newAddress_text2 newAddress_text">
										<p class="float_left">
											<script>
												Language("公寓号、楼号"," Apt, suite, building, etc (optional)")
											</script>
										</p>
										<script>
											Language(`<input class="float_left" type="" name="" id="e-detail" placeholder="请输入公寓号、楼号" />`,
											`<input class="float_left" type="" name="" id="e-detail" placeholder="Enter Apt, suite, building, etc" />`)
										</script>
									</div>
									<div class="float_left newAddress_text3 newAddress_text">
										<p class="float_left">
											<script>
												Language("城市","City")
											</script>
										</p>
										<script>
											Language(`<input class="float_left" type="" name="" id="e-city" placeholder="请输入城市" />`,
											`<input class="float_left" type="" name="" id="e-city" placeholder="Enter City" />`)
										</script>
									</div>
									<div class="float_left newAddress_text4 newAddress_text">
										<p class="float_left">
											<script>
												Language("州","State")
											</script>
										</p>
										<div  class="float_left" id="e-province">
											  <select id="province1" name="test"  required data-am-selected="{searchBox: 1}">
											    <option value=""></option>
											    <option value="a">Apple</option>
											    <option value="b">Banana</option>
											    <option value="o">Orange</option>
											  </select>
										</div>
									</div>
								</div>
								<div class="clearfloat">
									<p class="float_right">
										<script>
											Language("设置默认收货地址","Set As Primary Address")
										</script>
									</p>
									<div class="float_right default" default="2"   id="defaultCheck2"></div>
								</div>
								<div class="but1" onclick="editAddress()" id="editId" addId="">
									<script>
										Language("修改","Edit ")
									</script>
								</div>
							</div>
						</div>-->
						<div class="personalPro_address">
							<div class="addressTitle clearfloat">
								<p class="float_left">
									<script>
										Language("已保存的地址","Saved Address")
									</script>
								</p>
								<!--<div class="but1 float_right">
									<script>
										Language("新增地址","Add New address")
									</script>
								</div>-->
							</div>
							<div class="personalPro_address_pro"id="TestHtml">
								<ul class="am-g">
									<li class="am-u-sm-1">
										<script>
											Language("收货人","Recieptant")
										</script>
									</li>
									<li class="am-u-sm-3">
										<script>
											Language("州","State")
										</script>
									</li>
									<li class="am-u-sm-3">
										<script>
											Language("详细地址","Address")
										</script>
									</li>
									<li class="am-u-sm-2">
										<script>
											Language("邮编","Zip Code")
										</script>
									</li>
									<li class="am-u-sm-2">
										<script>
											Language("联系电话","Phone Number")
										</script>
									</li>
									<li class="am-u-sm-1">
										<script>
											Language("操作","Action")
										</script>
									</li>
								</ul>
								<div id="TestHtmlPro"></div>
								<div class="am-modal am-modal-alert" tabindex="-1" id="my-alert">
							  <div class="am-modal-dialog">
							    <div class="am-modal-bd">				      
										<script>
											Language("你确定删除吗？","Delete?")
										</script>
							    </div>
							    <div class="am-modal-footer">
							      <button class="am-modal-btn Delete" onclick="del()" id="btn" addid="${json.data[i].id}" style="border: 0;background: none;">
										<script>
											Language("确定","Yes")
										</script>
										</button>
							    </div>
									<div class="am-modal-footer">
							      <span class="am-modal-btn">
											<script>
												Language("取消","Cancel")
											</script>
										</span>
							    </div>
							  </div>
							</div>
							</div>
						</div>
					</div>
				</div>
			</div>
<script type="text/javascript">
	function showOrder(){
		 document.querySelector("#oderNav").style.display = 'block';
         document.querySelector("#oderPro").style.display = 'block';
	}
	function showAddress(){
			$("#Modify").hide();
			$(".personalPro_address").show();
			textAddress()
	}
	//我的评论数据绑定
	 $.ajax({
	  url:'/api/user/comments',
	  method:'post',
	  data:{
	   'id': {{Auth()->guard("pc")->user()->id}}

	  },
	  success:function(res){
	   var myComments=res.data
	   if(res.status){
	   	var commentText=""
	   	for(var i=0;i<myComments.length;i++){
	   		
						commentText+=`			<li class="am-g">
										<div class="am-u-sm-4">
											<div class="time">[${myComments[i].created_at}]</div>
											<p class="myComment">[${myComments[i].name}] ${myComments[i].content}</p>
											<p class="buyComment" style="display:${myComments[i].reply.length>0?'auto':'none'}">[12buy回复]${myComments[i].reply.length>0?myComments[i].reply[0].content:[]}</p>
										</div>
										<div class="am-u-sm-3 ">
											<div class="personalProBox">
												<img src="${myComments[i].message_img.product_image}" alt="" />
											</div>
										</div>
										<div class="am-u-sm-3 personalProText">
											<p class="personalProTitle towLine">${LanguageHtml(myComments[i].message_img.zn_name,myComments[i].message_img.en_name)}</p>
											<p class="totalPrice">$ <span>${myComments[i].message_img.distributor.level_four_price}</span></p>
										</div>
										<div class="am-u-sm-2">
											<div class="commentBut">
												${myComments[i].reply.length>0?"商家已回复":"商家未回复"}
											</div>
										</div>
									</li>`
	   	}
	   	$('#commentPro').html(commentText);
	   	
	   }else{
	   	
	   };
	  },
	  error:function(){
//		alert("网络错误")
        swal({
            title:LanguageHtml("数据请求失败","Failed to Proceed Request"),
            type: 'error',
            showConfirmButton: true,

        })
	  }
	 })
	//隐藏修改地址框
	$("#Modify").hide();
	@if(session('msg'))	
	if( "{{ session('msg') }}" == '修改成功'){
		// swal({
		// 	title: "{{ session('msg') }}",
		// 	type: 'success',
		// 	confirmButton: true
		// })
//		alert('修改成功!')
	}else{
		// swal({
		// 	title: "{{ session('msg') }}",
		// 	type: 'error',
		// 	confirmButton: true
		// })
//		alert("{{ session('msg') }}")
	}
	@endif
	//修改地址
	function edit(){
		addAddress();
	}
	//点击我的订单时，执行点击所有订单
	$(".personalList li").eq(2).click(function(){
		$("#oderNav li").eq(0).click();
	});
//	订单数据绑定
	$("#oderNav li").click(function(){
		$("#allOrderHtml").html("")
		var That=$(this).index();
		if(That==5){
			$("#allOrderHtml").html(LanguageHtml("没有此类订单","No Result"));
			return ;
		}
		var orderState=LanguageHtml(["","已完成","已下单", " "," "],["","Unshipped","Unpaid", " "," "]);
		var orderStateId=[""," 1", " 2","3"," 4"];
		$.ajax({
                url: "/api/order/bunsiess/state",
                method: "GET",
                dataType:"jsonp",
                jsonpCallback: "my",
                data:{
                    id: {{Auth()->guard("pc")->user()->id}},
                    status: orderStateId[That]
                },
                success:function (res) {
                		var allOrder = res.data;
					//没有此类订单返回
	                		if(!res.status){
	                			$("#allOrderHtml").html(LanguageHtml("没有此类订单","No Result"));
	                			return false;
	                		}
							console.log(res)
	                	//有订单数据  循环绑定
                        for(let i = 0; i < allOrder.length; i++){
                            document.querySelector("#allOrderHtml").innerHTML += `
							<div class="oderPro_2_box">
										<div class=" clearfloat">
											<div class="oderPro-2 float_left" style="width: 35%;">
													<div class="float_left oderPro_2_img"><img src="${allOrder[i].snap_img}" alt="" /></div>
													<div class="float_left oderPro_2_text">
														<p class="towLine">${allOrder[i].snap_name[0]=="{"?LanguageHtml(JSON.parse(allOrder[i].snap_name).zn,JSON.parse(allOrder[i].snap_name).en):allOrder[i].snap_name}</p>
														<span>${orderState[allOrder[i].status]}</span>
													</div>
											</div>
											<div class="oderPro_2">&nbsp;  <span>&nbsp;</span></div>
											<div class="oderPro_2">${allOrder[i].total_count}</div>
											<div class="oderPro_2"> <span>0</span></div>
											<div class="oderPro_2">$ <span>${allOrder[i].total_price}</span></div>
											<div class="oderPro_2 oderPro_2_but">
												<div class="but1" style="display :${(allOrder[i].status)=='2'?'auto':'none'}" onclick="comment(${allOrder[i].id})">${LanguageHtml("查看订单","view order")}</div>
											</div>
										</div>
										<div class="clearfloat oderPro_2_time">
											<p class="float_left" >${LanguageHtml("订单号：","Order Number:")}${allOrder[i].order_no}</p>
											<p class="float_right" style="text-align: right;">${allOrder[i].created_at}</p>
										</div>
									</div>
						`
                        }
                }
       });
	});
	</script>
	<script type="text/javascript">
		//待支付订单跳转支付
		function buttonpay(order_id){
			
//			var orderDetails = {
//				order_no:order_no,
//				totalPrice:total_price
//			}
//			localStorage.setItem("order_no",order_no);
//				localStorage.setItem("totalPrice",total_price);
//				window.open("/pay/paypal","_self");
				                    localStorage.setItem("order_id",order_id);
				                    window.location.href='/order/confirm/{{Auth()->guard("pc")->user()->id}}'
		}
		//删除订单
		function orderdel(orderid){
			var r = confirm("确认删除订单吗？")
			if(r==true){
				$.ajax({
					url:'/apps/delorder',
					method: 'get',
					data: {
					id : orderid
					},
					success: function(json){
						//console.log(json)
						alert("删除成功")
                        setTimeout(function () {
                            location.reload();
                        }, 1500);
//						window.location.reload();

					}
				})
			}else{
//				alert('删除失败')
		            swal({
		                title:"删除失败",
		                type: 'error',
		                showConfirmButton: true,
		            })
			}
		}
//订单列表页点击 未支付 显示订单详情
        function comment(data){
            $.ajax({
                // url: '/api/users/order/details',
                url: '/api/business/order/details',
                method:'get',
                data:{
                    id:data
                },
                success:function (res) {
					console.log(res)
					var orderstatus=LanguageHtml(["","待发货","已下单", "待收货"," 已完成"],["","Wait for Shipment","Waiting for Payment", "Waiting to Delivered"," Completed Order"]);
					var projectlist = '';
					var comment = '';
					var orderdetails = JSON.parse(res.details.snap_address)
					switch(res.details.status){
						case '2': orderstatus = LanguageHtml("待发货","Wait for Shipment");
							break;
						case '1': orderstatus = LanguageHtml("已下单","Waiting for Payment");
							break;
						case '3': orderstatus = LanguageHtml("待收货","Waiting to Delivered");
							break;
						case '4': orderstatus = LanguageHtml("已完成的订单"," Completed Order ");
								  comment = `<div >
								  				<textarea class="comments"></textarea>
												<div id="oderBox" class="texti" style="padding: 0;" >
												<span>★</span>
												<span>★</span>
												<span>★</span>
												<span>★</span>
												<span>★</span>
												
											</div><p class="comment-btn"><button class="btn">${LanguageHtml('评价','Ratings')}</button></div></p>`;
							break;
					}
					var products = res.products;
					var order = {
						order_no : res.details.order_no,
						totalPrice : res.details.total_price
					}
					for(let i = 0; i < products.length; i++ ){
						projectlist += `
						<div class="myOder">
								<div class="myOderDetail clearfloat">
									<div class="am-u-sm-2 myOderDetailImg">
										<div>
											<img src="${products[i].products.product_image}" alt="#">
										</div>
									</div>
									<div class="am-u-sm-7">
										<p>${LanguageHtml(products[i].products.zn_name,products[i].products.en_name)}</p>
									</div>
									<div class="am-u-sm-3 myOderDetailText">
										<p>数量：${products[i].count}
											<br>
											<span>单价：$${products[i].products.distributor.level_four_price}</span>
											<br>
											<span>${LanguageHtml('待支付','Waiting for payment')}</span>
										</p>
									</div>
								</div>
							</div>	
							<div class="commentdata" order_id="${orderdetails.id}" product_id="${products[i].product_id}" >
								${comment}
							</div>
						`
					}
					document.querySelector("#oderDetail").innerHTML = `<div class="Title clearfloat">
								<!-- <img class="float_left" src="home/img/user_2.png" alt="" /> -->
                        <p class="float_left">${LanguageHtml("订单详情"," Order Details")}</p>
                        </div>
                        <div class="information clearfloat myOderTop" style="magin-top:20px !important;">
                        <div class="text clearfloat " style="border-bottom: 1px solid #cfcfcf; width:100%;" >
                        <p class="am-u-sm-5">${LanguageHtml("订单号","Order Number")}：<span>${res.details.order_no}</span></p>
                        <p class="am-u-sm-7">${LanguageHtml("订单状态"," Order Status")}：<span>${LanguageHtml("已下单","Waiting for Payment")}</span></p>
                        <!--<p class="am-u-sm-4">浏览时间:<span></span></p>-->
                        </div>
                        <div class="text " style="width:100%;">
                        <p>${LanguageHtml('您购买的订单<span >待支付</span>，您可以联系卖家了解商品详情。','If you purchase orders to be paid, you can contact the seller to find out the details of the products.')}</p>
                        </div>
                        </div>
						<div>
							${projectlist}
						</div>
                        <div class="payment am-u-sm-12 clearfloat"style="display:none">
                        <button type="button"data_router="${'/order/confirm/'+{{Auth()->guard("pc")->user()->id}}}"  data-order_no="${res.details.order_no}" data-totalprice="${res.details.total_price}" id="buttonpay" onclick="buttonpay('${data}')" class="am-btn am-btn-danger btn-loading-example">${LanguageHtml('付款','payment')}</button>
                        </div>
                        <div class="receivingAddress">
                        <div class="receivingTitle">
                        <p>${LanguageHtml('收货人信息','consignee')}
                        <!--<span>修改信息</span>-->
                        </p>
                        </div>
                        <div class="receivingInfo">
                        <p>${LanguageHtml('收货人','Name')}：
                        <span>${orderdetails.name}</span>
                        </p>
                        <p>${LanguageHtml('地址','Address')}：
                        <span>${orderdetails.province}</span>
                        </p>
                        <p>${LanguageHtml('联系电话','Phone Number')}：
                        <span>${orderdetails.mobile}</span>
                        </p>
                        </div>
                        </div>`;
					$(".personalPro").eq(2).children().hide();
                    document.querySelector("#oderDetail").style.display = 'block';
                    //五星评论js
                    $(".texti").attr("level","5");
                    $(".texti span").click(function(){
                    	var That=$(".texti span").index(this);
                    	var This=$(this).index()+1;
                    	$(this).parent(".texti").attr("level",This);
                    	for(var i=0;i<5;i++){
                    		$(".texti").eq(Math.floor(That/5)).find("span").eq(i).removeClass("text-red")
                    	};
                    	for(var i=0;i<This;i++){
                    		$(".texti").eq(Math.floor(That/5)).find("span").eq(i).addClass("text-red")
                    	};
						$(".comment-btn").eq(parseInt(This/5)).attr("score",That+1)
                    });
                }
            })
        }
		//订单列表页点击 待评论 显示订单详情
        function commenter(data){
            $.ajax({
                url: '/api/pc/tocomment',
                method:'get',
				async: false,
				dataType: "json",
				jsonp: "callbackparam",
				crossDomain: true,//是否跨域:是
				cache: false,//是否缓存：否
				jsonpCallback: "my",
                data:{
                		'id':data
                },
                success:function (res) {
                    if(res.status){
                    		
                    }
					var projectlist = '';
					var comment = '';
					for(let i = 0; i < res.data.manys.length; i++ ){
						projectlist += `
						<div class="myOder">
								<div class="myOderDetail clearfloat">
									<div class="am-u-sm-2 myOderDetailImg">
										<div>
											<img src="${res.data.manys[i].product_image}" alt="#">
										</div>
									</div>
									<div class="am-u-sm-8">
										<p>${LanguageHtml(res.data.manys[i].zn_name,res.data.manys[i].en_name)}</p>
									</div>
									<div class="am-u-sm-2 myOderDetailText">
										<p>${res.data.id}
											<br>
											<span>${res.data.manys[i].count}</span>
											<br>
											<span> 待评论</span>
										</p>
									</div>
								</div>
							</div>	
							<div class="commentdata" order_id="${res.data.id}" productId="${res.data.manys[i].id}" >
							<div >
								<textarea class="comments"></textarea>
								<div id="oderBox" class="texti" style="padding: 0;" >
									<span>★</span>
									<span>★</span>
									<span>★</span>
									<span>★</span>
									<span>★</span>
												
								</div>
								<p class="comment-btn"><button class="btn">评价</button></div></p>
							</div>
						`
					}
					document.querySelector("#oderDetail").innerHTML = `<div class="Title clearfloat">
								<!-- <img class="float_left" src="home/img/user_2.png" alt="" /> -->
                        <p class="float_left">订单详情</p>
                        </div>
                        <div class="information clearfloat myOderTop" style="magin-top:20px !important;">
                        <div class="text clearfloat " style="border-bottom: 1px solid #cfcfcf; width:100%;" >
                        <p class="am-u-sm-5">订单号：<span>${res.data.order_no}</span></p>
                        <p class="am-u-sm-3">订单状态：<span>待评论</span></p>
                        <p class="am-u-sm-4">浏览时间:<span></span></p>
                        </div>
                        <div class="text " style="width:100%;">
                        <p>您购买的订单<span >已完成</span>，您可以联系卖家了解商品详情。</p>
                        </div>
                        </div>
						<div>
							${projectlist}
						</div>
                        <div class="payment am-u-sm-12 clearfloat">
                        </div>
                        <div class="receivingAddress">
                        <!--<div class="receivingTitle">
	                        <p>收货人信息
	                        <span>修改信息</span>
	                        </p>
                        </div>
                        <div class="receivingInfo">
                        <p>收货人：
                        <span>orderdetails.name</span>
                        </p>
                        <p>地址：
                        <span>orderdetails.province</span>
                        </p>
                        <p>联系电话：
                        <span>orderdetails.mobile</span>
                        </p>
                        </div>-->
                        </div>`;
				
                    document.querySelector("#oderNav").style.display = 'none';
                    document.querySelector("#oderPro").style.display = 'none';
                    document.querySelector("#oderDetail").style.display = 'block';
                    //五星评论js
                    $(".comment-btn").attr("level","5");
                    $(".texti span").click(function(){
                    	var That=$(".texti span").index(this);
                    	var This=$(this).index()+1;
                    	$(this).parent(".texti").attr("level",This);
                    	for(var i=0;i<5;i++){
                    		$(".texti").eq(Math.floor(That/5)).find("span").eq(i).removeClass("text-red")
                    	};
                    	for(var i=0;i<This;i++){
                    		$(".texti").eq(Math.floor(That/5)).find("span").eq(i).addClass("text-red")
                    	};
						$(".comment-btn").eq(parseInt(This/5)).attr("level",That+1)
                    });
					//提交评论
					$(".comment-btn").click(function (){
							var aa = window.location.href;
							var score = $('.comment-btn').eq(That).attr("level") || 5
							var That=$(".comment-btn").index(this);
							if($('.comments').eq(That).val()==''){ 
//										alert("评论不能为空");
						            swal({
						                title:"评论不能为空",
						                type: 'warning',
						                showConfirmButton: true,
						
						            })
								return
							}
							
							$.ajax({
								url:'/apps/addComments',
								method: 'get',
								data: {
										order_id:$('.commentdata').eq(That).attr('order_id'),
										product_id:$('.commentdata').eq(That).attr("productId"),
										content :$('.comments').eq(That).val(),
										score:score
									},
								success: function(data){
									if(data){
//										alert("评论成功");
										
							            swal({
							                title:"评论成功",
							                type: 'success',
							                showConfirmButton: true,
							
							            })
										$(".cartPro").eq(That).remove()
									}else{
//										alert("评论失败");
							            swal({
							                title:"评论失败",
							                type: 'warning',
							                showConfirmButton: true,
							
							            })
									}
								},
								error: function () {
//										alert("请求失败");
							            swal({
							                title:"请求失败",
							                type: 'warning',
							                showConfirmButton: true,
							
							            })
									}
							})
						}
					)
                },
				error:function(){
//					alert('网络错误')
		            swal({
		                title:"网络错误",
		                type: 'warning',
		                showConfirmButton: true,
		
		            })
				}
            })
        }
	</script>
	
	
	
	
<!-- 默认状态1 -->
	<script>
	var Default = $("#defaultCheck1").attr("default");

 $("#defaultCheck1").click(function(){
		var at=$(this).attr("default");
			if (at=="1") {
			$(this).attr("default","2");

			}else{
			$(this).attr("default","1");
			}

	 Default = $("#defaultCheck1").attr("default");
	 })

//  新增地址1
	var addAddress = function () {
		var name = $('#f-name').val()+$('#l-name').val()
						$.ajax({
								url:'/api/upload/user/address',
								method: 'get',
								async: false,
								dataType: "jsonp",
								// jsonp: "callbackparam",
								data: {
//										'name': name,
//										'mobile': $('#mobile').val(),
//										'city': $('#city').val(),
//										'country': $('#country').val(),
//										'province': $('#province').val(),
//										'zip': $('#zip').val(),
//										'detail':'',
//										'default' : Default,
										
										'id' : {{Auth()->guard('pc')->user()->id}},
										'name':name,
										'mobile':$('#mobile').val(),
										'province':$(' .am-selected-status').eq(0).html(),
										'city':$('#city').val(),
										'country':$('#country').val(),
										'detail':$('#detail').val(),
										'zip':$('#zip').val(),
										'default' : Default
								},
								crossDomain: true,//是否跨域:是
								cache: false,//是否缓存：否
								jsonpCallback: "my",
								success: function (json) {
										if (!json.status) {
												alert(json.data)
										} else {
												alert('添加成功')
													window.location.reload();
										}

								},
								error: function () {
										alert('请求失败')
								}
						})

				};
				//州
//	var optiontxt = '';
//	var allplace = ["Alabama","Alaska","Arizona","Arkansas","California","Colorado","Connecticut","Delaware","Florida","Georgia","Hawaii","Idaho","Illinois","Indiana","Iowa","Kansas","Kentucky","Louisiana","Maine","Maryland","Massachusetts","Michigan","Minnesota","Mississippi","Missouri","Montana","Nebraska","Nevada","New Hampshire","New Jersey","New Mexico","New York","North Carolina","North Dakota","Ohio","Oklahoma","Oregon","Pennsylvania","Rhode Island","South Carolina","South Dakota","Tennessee","Texas","Utah","Vermont","Virginia","Washington","West Virginia","Wisconsin","Wyoming"];
//	for(let i = 0; i < allplace.length; i++ ){
//		optiontxt +=`<option>${allplace[i]}</option>`
//	};
//	document.querySelector("#province").innerHTML = optiontxt;

	// 地址管理页面1
	textAddress=function(){
		$.ajax({
				url:'/api/users/details',
				method: 'get',
				async: false,
				dataType: "jsonp",
	//			 jsonp: "callbackparam",
				data: {
						'id' : {{Auth()->guard('pc')->user()->id}}
				},
				crossDomain: true,//是否跨域:是
				cache: false,//是否缓存：否
				jsonpCallback: "my",
				success: function (json) {
					// var Address=json.data;
					var textHtml=""
					var textTop=""
					for (var i = 0; i < json.data.length; i++) {
								textTop+=`	
											<div class="address_pro am-g" >
												<div class="am-u-sm-1"style="padding: 0;">${json.data[i].name}</div>
													<div class="am-u-sm-3 oneLine">${json.data[i].province}</div>
													<div class="am-u-sm-3 towLine" >${json.data[i].country}</div>
													<div class="am-u-sm-2">${json.data[i].zip}</div>
													<div class="am-u-sm-2">${json.data[i].mobile}</div>
													<div class="am-u-sm-1 but1"style="padding: 0;">
														<!--<p><a class="address_pro_edit_bnt" href="##" addid="${json.data[i].id}" onclick="edit(${json.data[i].id})">${LanguageHtml('编辑','Edit')}</a></p>
														<p><button class="Delete am-btn am-btn-primary" data-am-modal="{target: '#my-alert'}" addid="${json.data[i].id}" style="border: 0;background-color: #fff;color: #666666;">${LanguageHtml('删除','Delete')}
														</button></p>-->
													</div></div>`
				}
				
				$("#TestHtml #TestHtmlPro").html(textTop)
	
				// 删除按钮1
				$(".Delete").click(function(){
						var That=$(".Delete").index(this);
						var addId=$(this).attr("addid");
	
						btn.onclick=function () {
										$.ajax({
												url: '/api/del/user/address',
												method: 'get',
												async: false,
												dataType: "jsonp",
												jsonp: "callbackparam",
												data: {
														'id' : addId
												},
												crossDomain: true,//是否跨域:是
												cache: false,//是否缓存：否
												jsonpCallback: "my",
												success: function (json) {
												if(json.status){
														alert('删除成功')
														window.location.reload();
												}
												}
										})
	
									}
	
	
				})
				// end删除
				},
				error: function () {
						// swal({
						// 		title: '请求失败',
						// 		type: 'error',
						// 		showConfirmButton: true,
						//
						// })
						alert('请求失败')
				}
	
		})
		
	}
	// 修改地址1
	
	function edit(aa){
				$("#Modify").show();
				$(".personalPro_address").hide();
					$.ajax({
						url: '/api/user/edit/address',
						method: 'get',
						async: false,
						dataType: "jsonp",
						jsonp: "callbackparam",
						data: {
							'id':aa
						},
						crossDomain: true,//是否跨域:是
						cache: false,//是否缓存：否
						jsonpCallback: "my",
						success:function(data){
							var myaddress=data.data;
							$('#e-name').val(myaddress.name);
							$('#e-mobile').val(myaddress.mobile);
							$('#e-province').val(myaddress.province);
							
	 						$("#province1").html(`<option>${myaddress.province}</option>`+optiontxt);
							$('#e-city').val(myaddress.city);
							$('#e-country').val(myaddress.country);
							$('#e-detail').val(myaddress.detail);
								$('#e-zip').val(myaddress.zip);
								$('#editId').attr("addId",aa);
								
						}

					})
				};
	function editAddress(){
		Default2 = $("#defaultCheck2").attr("default");
		$.ajax({
			url:"/api/edit/user/address",
			method: 'get',
			async: false,
			dataType: "jsonp",
			jsonp: "callbackparam",
			data: {
				'id':$('#editId').attr("addId"),
				'name':$('#e-name').val(),
				'mobile':$('#e-mobile').val(),
				'province':$('#e-province .am-selected-status').eq(0).html(),
				'city':$('#e-city').val(),
				'country':$('#e-country').val(),
				'detail':$('#e-detail').val(),
				'zip':$('#e-zip').val(),
				'default' : Default2,
		},
		crossDomain: true,//是否跨域:是
		cache: false,//是否缓存：否
		jsonpCallback: "my",
		success:function(res){
			alert('修改成功');
			$("#addressText").click();
		},
		error:function(){
			alert('网络错误');
		}
		})
	}



</script>
<script>
	
	//用户概览，订单状态数量
	var orderStatus=function (){
		$.ajax({
            url: "/api/order/state",
            url: "/api/pc/order/count",
            method: "GET",
            data:{
                id: {{Auth()->guard("pc")->user()->id}}
            },
            success:function (res) {
            	console.log(res)
            	for (let i in res.data) {
            		$("#myOderStatus span").eq(i).html(res.data[i].count)
            	}
//          		$("#myOderStatus li").eq(orderStatusNum).find("span").html(res.data.length)
            }
    		});
	}
	$("#myOderStatus").click(function(){
		$(".personalList li").eq(2).click()
	})
</script>

@endsection

