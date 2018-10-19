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
				Language("新增地址","New Address")
		</script>
		</h6>
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
                    	Language("名","First Name")
                    </script>
                    </label>
                    <input id="f-name" type="text" class="form-control border-0" placeholder="First Name" aria-label="" aria-describedby="">
			</div>
		</div><!-- 名 -->

		<!-- 姓 -->
		<div class="d-flex justify-content-center py-2">
			<div class="input-group">
				<div class="input-group-prepend">
					<span class="input-group-text bg-white border-0" id=""></span>
				</div>
                <label class="input-group-text bg-white border-0 box">
                		<script>
                				Language("姓","Last Name")
                		</script>
                </label>
				<input id="l-name" type="text" class="form-control border-0" placeholder="Last Name" aria-label="" aria-describedby="">
			</div>
		</div><!-- 姓 -->

		<!-- 手机号码 -->
		<div class="d-flex justify-content-center py-2">
			<div class="input-group">
				<div class="input-group-prepend">
					<span class="input-group-text bg-white border-0" id=""></span>
				</div>
                <label class="input-group-text bg-white border-0 box">
                <script>
                		Language("手机号码"," Phone Number")
                </script>
                </label>
				<input id="mobile" type="text" class="form-control border-0" placeholder=" Enter Phone Number" aria-label="" aria-describedby="">
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
                	Language("邮政编码","Zip Code")
                </script></label>
				<input id="zip" type="text" class="form-control border-0" placeholder="Enter Zip Code" aria-label="" aria-describedby="">
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
				<input id="city" type="text" class="form-control border-0" placeholder="Enter City" aria-label="" aria-describedby="">
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
                	Language("街道地址","Street Address ")
                </script></label>
				<input id="country" type="text" class="form-control border-0" placeholder="Enter Street Address" aria-label="" aria-describedby="">
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
                	Language("公寓号、楼号","Apt, suite, building, etc (optional) ")
                </script></label>
				<input id="detail" type="text" class="form-control border-0" placeholder="Apt, suite, building, etc (optional) " aria-label="" aria-describedby="">
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
                <div class="form-check">
                    <input style="margin-top: 12px;margin-bottom: 1px;vertical-align: middle;" class="form-check-input box" type="checkbox" default="2"   id="defaultCheck1" value="1">
                    <label class="input-group-text bg-white border-0">
                	<script type="text/javascript">
                	Language("设置为默认收货地址","Set as Primary Address")
                </script></label>
                </div>
            </div>
		</div><!-- 设置为默认收货地址 -->

		<!-- 按钮 -->
		<div class="d-flex justify-content-center py-3">
			<button type="button" class="btn btn-red btn-block rounded-50" onclick="addAddress();">
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

</script>

<script type="text/javascript">

	 var Default = $("#defaultCheck1").attr("default");

	$("#defaultCheck1").click(function(){
		 var at=$(this).attr("default");
			 if (at=="1") {
			 $(this).attr("default","2");

			 }else{
			 $(this).attr("default","1");
			 }

	  Default = $("#defaultCheck1").attr("default");
			 console.log(Default)
		})
		//console.log(Default)

	var addAddress = function () {
		var name = $('#f-name').val()+$('#l-name').val();
		var datas={
                    'name': name,
                    'mobile': $('#mobile').val(),
                    'province': $('#province').val(),
                    'city': $('#city').val(),
                    'country': $('#country').val(),
                    'detail': $('#detail').val()==''?' ':$('#detail').val(),
                    'zip': $('#zip').val(),
                    'default' : Default,
                    'id' : {{Auth()->guard('pc')->user()->id}}
                }
			
			var addAddressAjax=function (data){
				console.log(data)
                    if (!data.status) {
                        swal({
                            title: data.data,
                            type: 'warning',
                            showConfirmButton: true,

                        })
                    } else {
                        swal({
                            title:  LanguageHtml('添加成功','Added'),
                            type: 'success',
                            showConfirmButton: true,

                        })

                        setTimeout(function () {
                        	
                            location.href="/apps/address"
                        }, 1500);
                    }
			};
			jqAjaxJsonp('get','/api/upload/user/address',datas,addAddressAjax);

        };
        //州
	var optiontxt = '';
	var allplace = ["Alabama","Alaska","Arizona","Arkansas","California","Colorado","Connecticut","Delaware","Florida","Georgia","Hawaii","Idaho","Illinois","Indiana","Iowa","Kansas","Kentucky","Louisiana","Maine","Maryland","Massachusetts","Michigan","Minnesota","Mississippi","Missouri","Montana","Nebraska","Nevada","New Hampshire","New Jersey","New Mexico","New York","North Carolina","North Dakota","Ohio","Oklahoma","Oregon","Pennsylvania","Rhode Island","South Carolina","South Dakota","Tennessee","Texas","Utah","Vermont","Virginia","Washington","West Virginia","Wisconsin","Wyoming"];
	for(let i = 0; i < allplace.length; i++ ){
		optiontxt +=`<option>${allplace[i]}</option>`
	};
	document.querySelector("#province").innerHTML = optiontxt;
</script>


@endsection