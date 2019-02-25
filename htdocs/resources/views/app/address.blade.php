@extends('/app/layouts.app')

@section('content')

        <style type="text/css">
            * {
                margin: 0;
                padding: 0;
            }
            .twoLine{
	            	display: -webkit-box; 
				-webkit-line-clamp: 2; 
				-webkit-box-orient: vertical; 
				overflow: hidden;
            }
            .float_left{
            		float: left;
            }
            .float_right{
            		float: right;
            }
            .line-wrapper small{
            	line-height: 120%;
            	width: 50%;
            }
            .line-wrapper span{
            	display: block;
            	line-height: 120%;
            	width: 100%;
            }
            .line-wrapper {
                width: 100%;
                height: 90px;
                overflow: hidden;
                border-bottom: 1px solid #DDDDDD;
            }
            
            .line-scroll-wrapper {
                height: 90px;
                clear: both;
            }
            
            .line-btn-delete {
                float: left;
                width: 132px;
                height: 90px;
            }
            
            .line-btn-delete button {
                width: 100%;
                height: 100%;
                background: red;
                border: none;
                font-family: 'Microsoft Yahei';
                color: #fff;
            }
            
            .line-normal-wrapper {
                display: inline-block;
                line-height: 100px;
                float: left;
                padding-top: 10px;
                padding-bottom: 10px;
            }
             .clearfloat:after{display:block;clear:both;content:"";visibility:hidden;height:0}
  			 .clearfloat{zoom:1}
            .add{
                overflow: hidden;
            }
        </style>
<div class="bg-light">
	<div class="container py-2 bg-light fixed-top">
		<div class="d-flex justify-content-between align-items-center text-mute">
			<a href="/apps/user/{{Auth()->guard('pc')->user()->id}}" class="top-nav-item"><i class="fa fa-angle-left"></i></a>
			<h6 class="top-nav-title">
                	<script type="text/javascript">
                	Language("地址管理","Manage Address")
                </script></h6>
			<a href="/apps/user/{{Auth()->guard('pc')->user()->id}}" class="top-nav-item"><i class="fa fa-user"></i></a>
		</div>
	</div>

	<div class="top-fix"></div>
	
	<!--发票地址-->
	{{--<div class="d-flex border-bottom bg-white pt-3 " style="padding: 0;"id="billHtml">
		<p class="text-muted mx-auto">
                	<script type="text/javascript">
                	Language("账单地址","Billing Address")
                </script></p>
	</div>--}}
	<!--<div class="d-flex border-bottom bg-white px-2 py-2 text-muted"  >
		<div class="row py-2 px-2" >
			<div class="col-10">
				<div class="row">
					<div class="col-3">
						<small>name</small>
					</div>
					<div class="col-9">
						<small>13999999999</small>
					</div>
					<div class="col-9">
						<small class="one-line">史蒂夫哈苏发圣诞节爱上近代史实打实大师阿三大叔阿 dasd阿速度阿速度阿三阿速度阿阿三阿速度</small>
					</div>
				</div>
			</div>
			<div class="col-2">
				<a href="/apps/bill/address" class="text-muted d-block" style="
				    position: relative;
				    top: 50%;
				    transform: translateY(-50%);
				">
				    <small>修改</small>
				</a>
			</div>
		</div>
		</div>-->
		
	<!-- 标题 -->
	<div class="d-flex border-bottom bg-white pt-3"style="padding: 0;">
		<p class="text-muted mx-auto">
                	<script type="text/javascript">
                	Language("已保存的地址","Saved Address")
                </script></p>
		</div>
</div><!-- 标题 -->

	<!--<div class="bg-white">
		<div class="container">
			<div class="d-flex justify-content-center p-2">
				<i class="far fa-check-circle"></i>
			</div>
		</div>
	</div>-->
    <div id="txteHtml"></div>

       
<!--新增地址-->
                            <div class="form-group container mb-0" style="margin-top: 10%;">
                                <div class="col-md-8 offset-md-4" style="width: 80%;margin: 0 auto;">
                                    <!-- <a href="/apps/add/address"><button type="submit" class="btn btn-block btn-red">
                                    	
                	<script type="text/javascript">
                	Language("新增地址","New Address ")
                </script>
                                    </button></a> -->
                                </div>
                            </div>
<!--新增地址-->
        <script >
                $.ajax({
                url: '/api/users/details',
                method: 'get',
                async: false,
                dataType: "jsonp",
                jsonp: "callbackparam",
                data: {
                     'id' : {{Auth()->guard('pc')->user()->id}}
                },
                crossDomain: true,//是否跨域:是
                cache: false,//是否缓存：否
                jsonpCallback: "my",
                success: function (json) {
                    var Address=json.data;
                    var textHtml=""
                    var textTop=""
                    for(var i=0;i<Address.length;i++){
                        if(Address[i].default=="1"){
                            textTop+=` <div class="line-wrapper">
                                <div class="line-scroll-wrapper">
                                        <a href="/apps/edit/address?id=${Address[i].id}" addid="${Address[i].id}">
                                            <div class="line-normal-wrapper clearfloat">
                                            <small class="float_left py-2 text-muted"style="padding: 0 3%;">${Address[i].name}</small><small class="float_left py-2 text-muted" style="text-align: right;padding: 0 3%;">${Address[i].mobile}</small>
                                            <small class="float_left py-2 text-muted twoLine" style="width: 100%;padding: 0 3%;">${Address[i].detail+" "+Address[i].country+" "+Address[i].city+" "+Address[i].province }</small>
                                        </div>
                                        </a>
                                    <div  class="line-btn-delete " ><button>${ LanguageHtml('默认地址','default address')}</button></div>
                                </div>
                            </div>`


                        }else{
                            textHtml+=` <div class="line-wrapper">
                                <div class="line-scroll-wrapper">
                                        <a href="/apps/edit/address?id=${Address[i].id}" addid="${Address[i].id}">
                                            <div class="line-normal-wrapper clearfloat">
                                            <small class="float_left py-2 text-muted"style="padding: 0 3%;">${Address[i].name}</small><small class="float_left py-2 text-muted" style="text-align: right;padding: 0 3%;">${Address[i].mobile}</small>
                                            <small class="float_left py-2 text-muted twoLine" style="width: 100%;padding: 0 3%;">${Address[i].detail+" "+Address[i].country+" "+Address[i].city+" "+Address[i].province }</small>
                                        </div>
                                        </a>
                                    
                                    <div  class="line-btn-delete " ><button class="Delete"addid="${Address[i].id}">${ LanguageHtml('删除','delete')}</button></div>
                                </div>
                            </div>`

                        }
                        
                    }
                    $("#txteHtml").html(textTop+textHtml)

                    $(function() {
                        init();
                        var pageNum = 1;


                    });
                    // 删除按钮
                    $(".Delete").click(function(){
                        var That=$(".Delete").index(this);
                        var addId=$(this).attr("addid");

                        swal({
                            title:  LanguageHtml('你确定删除吗?','Delete?'),
                            text: "",
                            type: 'warning',
                            showCancelButton: true,
                            confirmButtonColor: '#3085d6',
                            cancelButtonTerxt:LanguageHtml('取消','Cancel'),
                            cancelButtonColor: '#d33',
                            confirmButtonText: LanguageHtml('确定','Yes')
                            }).then(function(isConfirm) {
                            if (isConfirm.value==true) {
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
                                        window.location.reload();
                                    }
                                    }
                                })

                            }
                        })
                            
                            
                    })
                    //end删除
                    
                    
					//发票地址数据绑定
//          						var jqAjaxFun=function (json) {
//                                  console.log(json)
//                                  if(json.status && (json.data==null)){
//                                  		console.log(123)
//                                  	$("#billHtml").after(
//                                  	`
//									<div class="container border-bottom bg-white px-2 py-2 text-muted"  >
//												<a href="/apps/bill/address" class="text-muted d-block" style="
//												    position: relative;
//												    top: 50%;
//												    transform: translateY(-50%);
//												">
//												    <small>${LanguageHtml('您还没有设置发票地址 新增发票地址','You have not set an invoice address. Add an invoice address.')}</small>
//												</a>
//									</div>`
//                                  	)
//                                  }else{
//                                  	$("#billHtml").after(
//                                  	`
//									<div class="container border-bottom bg-white py-2 text-muted"  >
//	                                    <div class="row py-2 px-2" >
//	                                    	<div class="col-10">
//												<div class="row">
//													<div class="col-3">
//														<small>${json.data.name}</small>
//													</div>
//													<div class="col-9">
//														<small>${json.data.mobile}</small>
//													</div>
//													<div class="col-9">
//														<small class="one-line">${json.data.detail+" "+json.data.country+" "+json.data.city+" "+json.data.province }</small>
//													</div>
//												</div>
//											</div>
//											<div class="col-2">
//												<a href="/apps/bill/address" class="text-muted d-block" style="
//												    position: relative;
//												    top: 50%;
//												    transform: translateY(-50%);
//												">
//												    <small>${LanguageHtml('修改','modify')}</small>
//												</a>
//											</div>
//										</div>
//									</div>`
//                                  	)
//                                  }
//                                  	};
//                                  	jqAjax(
//                                  		"get",
//                                  		'/api/user/bill/address',
//                                  		{
//                                      'id' : {{Auth()->guard('pc')->user()->id}}
//                                  		},
//                                  		jqAjaxFun
//                                  	)
                }
            })
        </script>
                            
        <!-- 右滑 -->
          <script type="text/javascript">
            function init() {

                // 设定每一行的宽度=屏幕宽度+按钮宽度
                $(".line-scroll-wrapper").width($(".line-wrapper").width() + $(".line-btn-delete").width());
                // 设定常规信息区域宽度=屏幕宽度
                $(".line-normal-wrapper").width($(".line-wrapper").width());
                // 设定文字部分宽度（为了实现文字过长时在末尾显示...）
                $(".line-normal-msg").width($(".line-normal-wrapper").width() - 280);

                // 获取所有行，对每一行设置监听
                var lines = $(".line-normal-wrapper");
                var len = lines.length;
                var lastX, lastXForMobile;

                // 用于记录被按下的对象
                var pressedObj; // 当前左滑的对象
                var lastLeftObj; // 上一个左滑的对象

                // 用于记录按下的点
                var start;

                // 网页在移动端运行时的监听
                for(var i = 0; i < len; ++i) {
                    lines[i].addEventListener('touchstart', function(e) {
                        lastXForMobile = e.changedTouches[0].pageX;
                        pressedObj = this; // 记录被按下的对象 

                        // 记录开始按下时的点
                        var touches = event.touches[0];
                        start = {
                            x: touches.pageX, // 横坐标
                            y: touches.pageY // 纵坐标
                        };
                    });

                    lines[i].addEventListener('touchmove', function(e) {
                        // 计算划动过程中x和y的变化量
                        var touches = event.touches[0];
                        delta = {
                            x: touches.pageX - start.x,
                            y: touches.pageY - start.y
                        };

                        // 横向位移大于纵向位移，阻止纵向滚动
                        if(Math.abs(delta.x) > Math.abs(delta.y)) {
                            event.preventDefault();
                        }
                    });

                    lines[i].addEventListener('touchend', function(e) {
                        if(lastLeftObj && pressedObj != lastLeftObj) { // 点击除当前左滑对象之外的任意其他位置
                            $(lastLeftObj).animate({
                                marginLeft: "0"
                            }, 500); // 右滑
                            lastLeftObj = null; // 清空上一个左滑的对象
                        }
                        var diffX = e.changedTouches[0].pageX - lastXForMobile;
                        if(diffX < -150) {
                            $(pressedObj).animate({
                                marginLeft: "-132px"
                            }, 500); // 左滑
                            lastLeftObj && lastLeftObj != pressedObj &&
                                $(lastLeftObj).animate({
                                    marginLeft: "0"
                                }, 500); // 已经左滑状态的按钮右滑
                            lastLeftObj = pressedObj; // 记录上一个左滑的对象
                        } else if(diffX > 150) {
                            if(pressedObj == lastLeftObj) {
                                $(pressedObj).animate({
                                    marginLeft: "0"
                                }, 500); // 右滑
                                lastLeftObj = null; // 清空上一个左滑的对象
                            }
                        }
                    });
                }

                // 网页在PC浏览器中运行时的监听
                for(var i = 0; i < len; ++i) {
                    $(lines[i]).bind('mousedown', function(e) {
                        lastX = e.clientX;
                        pressedObj = this; // 记录被按下的对象
                    });

                    $(lines[i]).bind('mouseup', function(e) {
                        if(lastLeftObj && pressedObj != lastLeftObj) { // 点击除当前左滑对象之外的任意其他位置
                            $(lastLeftObj).animate({
                                marginLeft: "0"
                            }, 500); // 右滑
                            lastLeftObj = null; // 清空上一个左滑的对象
                        }
                        var diffX = e.clientX - lastX;
                        if(diffX < -150) {
                            $(pressedObj).animate({
                                marginLeft: "-132px"
                            }, 500); // 左滑
                            lastLeftObj && lastLeftObj != pressedObj &&
                                $(lastLeftObj).animate({
                                    marginLeft: "0"
                                }, 500); // 已经左滑状态的按钮右滑
                            lastLeftObj = pressedObj; // 记录上一个左滑的对象
                        } else if(diffX > 150) {
                            if(pressedObj == lastLeftObj) {
                                $(pressedObj).animate({
                                    marginLeft: "0"
                                }, 500); // 右滑
                                lastLeftObj = null; // 清空上一个左滑的对象
                            }
                        }
                    });
                }
            }

        </script>
        <!-- end右滑 -->
        <!-- 删除 -->
        <script type="text/javascript">
        </script>


@endsection




@section('scripts')
 
@endsection