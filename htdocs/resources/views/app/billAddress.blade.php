@extends('/app/layouts.app')

@section('content')
<style>
    .box{
        width: 27%;
    }
    .form-control-select{

    }
</style>

<div class="container py-2 bg-light fixed-top">
	<div class="d-flex justify-content-between align-items-center text-mute">
		<a href="javascript:history.back(-1);" class="top-nav-item"><i class="fa fa-angle-left"></i></a>
		<h6 class="top-nav-title">
                	<script type="text/javascript">
                	Language("编辑账单地址","Edit billing address")
                </script></h6>
		<a href="/apps/user/{{Auth()->guard('pc')->user()->id}}" class="top-nav-item"><i class="fa fa-user"></i></a>
	</div>
</div>

<div class="top-fix"></div>

<div class="container">
	<div class="d-flex flex-column p-0 mt-0">

		<!-- 名 -->
		<div class="d-flex justify-content-center py-3">
			<div class="input-group">
				<div class="input-group-prepend">
					<span class="input-group-text bg-white border-0" id=""></span>
				</div>   
                    <label class="input-group-text bg-white border-0 box">
                	<script type="text/javascript">
                	Language("姓名","Name")
                </script></label>
                    <input id="f-name" type="text" class="form-control border-0" placeholder="请输入名字" aria-label="" aria-describedby="">
			</div>
		</div><!-- 名 -->

		<!-- 姓 
		<div class="d-flex justify-content-center py-2">
			<div class="input-group">
				<div class="input-group-prepend">
					<span class="input-group-text bg-white border-0" id=""></span>
				</div>
                <label class="input-group-text bg-white border-0 box">姓</label>
				<input id="l-name" type="text" class="form-control border-0" placeholder="请输入姓氏" aria-label="" aria-describedby="">
			</div>
		</div>姓 -->

		<!-- 手机号码 -->
		<div class="d-flex justify-content-center py-2">
			<div class="input-group">
				<div class="input-group-prepend">
					<span class="input-group-text bg-white border-0" id=""></span>
				</div>
                <label class="input-group-text bg-white border-0 box">
                	<script type="text/javascript">
                	Language("手机号码","phone number")
                </script></label>
				<input id="mobile" type="text" class="form-control border-0" placeholder="请输入手机号码" aria-label="" aria-describedby="">
			</div>
		</div><!-- 手机号码 -->

        <!-- 邮政编码 -->
		<div class="d-flex justify-content-center py-2">
			<div class="input-group">
				<div class="input-group-prepend">
					<span class="input-group-text bg-white border-0" id=""></span>
				</div>
                <label class="input-group-text bg-white border-0 box">
                	<script type="text/javascript">
                	Language("邮政编码","Postal code")
                </script></label>
				<input id="zip" type="text" class="form-control border-0" placeholder="请输入邮政编码" aria-label="" aria-describedby="">
			</div>
		</div><!-- 邮政编码 -->

        <!-- 城市 -->
		<div class="d-flex justify-content-center py-2">
			<div class="input-group">
				<div class="input-group-prepend">
					<span class="input-group-text bg-white border-0" id=""></span>
				</div>
                <label class="input-group-text bg-white border-0 box">
                	<script type="text/javascript">
                	Language("城市","city")
                </script></label>
				<input id="city" type="text" class="form-control border-0" placeholder="请输入城市" aria-label="" aria-describedby="">
			</div>
		</div><!-- 城市 -->

        <!-- 详细地址 -->
        <div class="d-flex justify-content-center py-2">
			<div class="input-group">
				<div class="input-group-prepend">
					<span class="input-group-text bg-white border-0" id=""></span>
				</div>
                <label class="input-group-text bg-white border-0 box">
                	<script type="text/javascript">
                	Language("详细地址1","Detailed address 1")
                </script></label>
				<input id="country" type="text" class="form-control border-0" placeholder="请输入详细地址" aria-label="" aria-describedby="">
			</div>
		</div><!-- 详细地址 -->

 <!-- 详细地址2 -->
        <div class="d-flex justify-content-center py-2">
			<div class="input-group">
				<div class="input-group-prepend">
					<span class="input-group-text bg-white border-0" id=""></span>
				</div>
                <label class="input-group-text bg-white border-0 box">
                	<script type="text/javascript">
                	Language("详细地址2","Detailed address 2")
                </script></label>
				<input id="detail" type="text" class="form-control border-0" placeholder="请输入详细地址" aria-label="" aria-describedby="">
			</div>
		</div><!-- 详细地址 -->

        <!-- 州 -->
        <div class="d-flex justify-content-center py-2">
			<div class="input-group">
				<div class="input-group-prepend">
					<span class="input-group-text bg-white border-0" id=""></span>
				</div>
                <label class="input-group-text bg-white border-0 box">
                	<script type="text/javascript">
                	Language("州","State")
                </script></label>
                <select id="province" class="custom-select mr-sm-2 bg-white border-0" id="exampleFormControlSelect1" aria-label="" aria-describedby="">
                    <option>California</option>
                    <option>New York</option>
                </select>
            </div>
		</div><!-- 州 -->

         <!-- 设置为默认收货地址 -->
         <div class="d-flex justify-content-center py-2">
			<div class="input-group">
				<div class="input-group-prepend">
					<span class="input-group-text bg-white border-0" id=""></span>
				</div>
            </div>
		</div><!-- 设置为默认收货地址 -->

		<!-- 按钮 -->
		<div class="d-flex justify-content-center py-3">
			<button type="button" class="btn btn-red btn-block rounded-50" id="onClickBill" >
                	<script type="text/javascript">
                	Language("保存","save")
                </script></button>
		</div><!-- 按钮 -->

	</div>
</div>


@endsection





@section('scripts')
<script type="text/javascript">
	$(document).ready(function(){
		$('#mobile-nav').hide();
	});


        //州
	var optiontxt = '';
	var allplace = ["Alabama","Alaska","Arizona","Arkansas","California","Colorado","Connecticut","Delaware","Florida","Georgia","Hawaii","Idaho","Illinois","Indiana","Iowa","Kansas","Kentucky","Louisiana","Maine","Maryland","Massachusetts","Michigan","Minnesota","Mississippi","Missouri","Montana","Nebraska","Nevada","New Hampshire","New Jersey","New Mexico","New York","North Carolina","North Dakota","Ohio","Oklahoma","Oregon","Pennsylvania","Rhode Island","South Carolina","South Dakota","Tennessee","Texas","Utah","Vermont","Virginia","Washington","West Virginia","Wisconsin","Wyoming"];
	for(let i = 0; i < allplace.length; i++ ){
		optiontxt +=`<option>${allplace[i]}</option>`
	};
	document.querySelector("#province").innerHTML = optiontxt;
</script>

<script type="text/javascript">
	
	
	
					//发票地址数据绑定
            
                    $.ajax({
                        url: '/api/user/bill/address',
                        method: 'get',
                        async: false,
                        dataType: "json",
                        jsonp: "callbackparam",
                        data: {
                            'id' : {{Auth()->guard('pc')->user()->id}}
                        },
                        crossDomain: true,//是否跨域:是
                        cache: false,//是否缓存：否
                        jsonpCallback: "my",
                        success: function (json) {
                        console.log(json)
	                        if(json.status && (json.data==null)){
	                        		console.log(123)
	                        		$("#onClickBill").click(function(){
	                        			addAddress();
	                        		})
	                        }else{
	                        	$('#f-name').val(json.data.name)
			                    $('#mobile').val(json.data.mobile)
			                    $('#province').html(`<option>${json.data.province}</option>`+optiontxt)
			                    $('#city').val(json.data.city)
			                    $('#country').val(json.data.country)
			                    $('#detail').val(json.data.detail)
			                    $('#zip').val(json.data.zip)
                        		$("#onClickBill").click(function(){
                        			editAddress();
                        		})
			                }
                        }
                    })
	
	
	
	

	var addAddress = function () {
		var name = $('#f-name').val()
            $.ajax({
                url: '/api/insert/user/bill/address',
                method: 'post',
                async: false,
                dataType: "json",
                jsonp: "callbackparam",
                data: {
                    'name': name,
                    'mobile': $('#mobile').val(),
                    'province': $('#province').val(),
                    'city': $('#city').val(),
                    'country': $('#country').val(),
                    'detail': $('#detail').val()==''?' ':$('#detail').val(),
                    'zip': $('#zip').val(),
                    'id' : {{Auth()->guard('pc')->user()->id}}
                },
                crossDomain: true,//是否跨域:是
                cache: false,//是否缓存：否
                jsonpCallback: "my",
                success: function (json) {
                	console.log(json)
                    if (!json.status) {
                        swal({
                            title: json.data,
                            type: 'warning',
                            showConfirmButton: true,

                        })
                    } else {
                        swal({
                            title: LanguageHtml('保存成功','Saved successfully'),
                            type: 'success',
                            showConfirmButton: true,

                        })

                        setTimeout(function () {
                            location.href="/apps/address"
                        }, 1500);
                    }

                },
                error: function () {
                    swal({
                        title:  LanguageHtml('请求失败','Request failed'),
                        type: 'error',
                        showConfirmButton: true,

                    })

                }
            })

        };
	var editAddress = function () {
		var name = $('#f-name').val()
            $.ajax({
                url: '/api/edit/user/bill/address',
                method: 'post',
                async: false,
                dataType: "json",
                jsonp: "callbackparam",
                data: {
                    'name': name,
                    'mobile': $('#mobile').val(),
                    'province': $('#province').val(),
                    'city': $('#city').val(),
                    'country': $('#country').val(),
                    'detail': $('#detail').val()==''?' ':$('#detail').val(),
                    'zip': $('#zip').val(),
                    'id' : {{Auth()->guard('pc')->user()->id}}
                },
                crossDomain: true,//是否跨域:是
                cache: false,//是否缓存：否
                jsonpCallback: "my",
                success: function (json) {
                	console.log(json)
                    if (!json.status) {
                        swal({
                            title:json.data,
                            type: 'warning',
                            showConfirmButton: true,

                        })
                    } else {
                        swal({
                            title:  LanguageHtml('保存成功','Saved successfully'),
                            type: 'success',
                            showConfirmButton: true,

                        })

                        setTimeout(function () {
                            location.href="/apps/address"
                        }, 1500);
                    }

                },
                error: function () {
                    swal({
                        title:   LanguageHtml('请求失败','Request failed'),
                        type: 'error',
                        showConfirmButton: true,

                    })

                }
            })

        };
        
        
        
        
        
</script>


@endsection