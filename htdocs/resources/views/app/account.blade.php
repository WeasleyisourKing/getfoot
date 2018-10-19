@extends('/app/layouts.app')

@section('content')

<div class="container py-2 bg-light fixed-top">
	<div class="d-flex justify-content-between align-items-center text-mute">
		<a href="/apps/user/{{Auth()->guard('pc')->user()->id}}"  class="top-nav-item"><i class="fa fa-angle-left"></i></a>
		<h6 class="top-nav-title">
		<script>
			Language("个人资料","Profile")
		</script></h6>
		<a href="/apps/user/{{Auth()->guard('pc')->user()->id}}" class="top-nav-item"><i class="fa fa-user"></i></a>
	</div>
</div>


	<div class="d-flex flex-column p-5 mt-5 container">

		<!-- avatar Container -->
		<div class="d-flex justify-content-center">
			<div class="avatar-img-container">
				<!-- <img class="avatar-img" src="http://buy.yn-pulse.com/home/img/logo.png" alt=""> -->
				<img  id="imgSdf" class="avatar-img" src="{{$data['avatar']}}" alt="">
			</div>
		</div><!-- End avatar Container-->

		<!-- 按钮 -->
		<div class="d-flex justify-content-center py-3">
			<!-- <button class="btn btn-sm btn-outline-warning rounded-50">更换头像</button> -->
			
		</div><!-- 按钮 -->
		<form action="/apps/update/personal/info" method="post" enctype="multipart/form-data"
		>
		<!-- 姓名 -->
		<input type="hidden" name="_token"class="btn btn-primary" value="{{csrf_token()}}"/>
		<div id="choose" class="py-2 px-3 btn btn-sm btn-block w-50 text-center bg-pink rounded-50" style="margin: 0 auto;">
	   <span class="text-white">
	   <script type="text/javascript">
			Language("更换头像","Change Profile Photo")
	   </script></span>
	   
	  </div>
			<input type="file" name="img"/>
	  <input id="chooseimg" style="display: none" type="file" name="img" onchange="f_change(this);" oninput="imgchange()" />
	  <script>

		var ppi = document.querySelector("#chooseimg")
		document.querySelector("#choose").onclick = function(){
		 ppi.click();

		}
		function imgchange(){
		 console.log(ppi.value.slice(12))
		}
	  </script>

		<div class="d-flex justify-content-center py-3">
			<div class="input-group">
				<div class="input-group-prepend">
					<span class="input-group-text bg-white border-0" id=""><i class="fa fa-user"></i></span>
				</div>
				<input name="name" type="text" class="form-control border-0" placeholder='{{Auth()->guard("pc")->user()->name}}' aria-label="" aria-describedby="">
			</div>
		</div><!-- 姓名 -->

		<!-- 按钮 -->
		<div class="d-flex justify-content-center py-3">
			<button type="submit" class="btn btn-red btn-block rounded-50" id="tijiao">
			<script type="text/javascript">
				Language("保存","Save")
			</script></button>
		</div><!-- 按钮 -->
		</form>
		
		<!-- 按钮 -->
		<div class="d-flex justify-content-center py-3">
			<a href="{{ route('address') }}" class="w-100 d-block">
				<button type="submit" class="btn btn-red btn-block rounded-50" id="tijiao"><i class="fa fa-map-marker-alt"></i>
				<script type="text/javascript">
					Language("管理地址"," Manage Address ")
				</script>
				</button>	
			</a>
		</div><!-- 按钮 -->

	</div>	


<script type="text/javascript">
	
// 	$('#tijiao').click(function () {

//     var formData = new FormData();
   
   

//    var data = {};
//    data = {
//    	 _token: '{{csrf_token()}}',
//    	 formData:formData.append('img', $('input[name=img]')[0].files[0])
//    }
   
//     $.ajax({
//         url: '/imgHandle',
//         method: 'get',
       
//         contentType: false,
//         processData: false,
//         cache: false,
//         success: function (res) {
//             console.log(res);
//         }
//     })
// })
</script>
@endsection





@section('scripts')
<script type="text/javascript">
	$(document).ready(function(){
		$('#mobile-nav').hide();
	});
</script>
<script type="text/javascript">

	@if(session('msg'))	
	if( "{{ session('msg') }}" == '修改成功'){
		// swal({
		// 	title: "{{ session('msg') }}",
		// 	type: 'success',
		// 	confirmButton: true
		// })
		window.location.href="/apps/user/{{Auth()->guard('pc')->user()->id}}"
	}else{
		swal({
			title: "{{ session('msg') }}",
			type: 'error',
			confirmButton: true
		})
	}
	@endif

	</script>


<script type="text/javascript">
    //JS file 图片 即选即得 显示
    //创建一个FileReader对象
    var reader = new FileReader();

    function f_change(file){

        if (file.files[0].size / 1024 / 1024> 5){
            value = file.files[0].size/1024 / 1024;
            swal({
                title: LanguageHtml(`该文件大小已超过5MB,请重新选取照片！`,` The file has exceed 5MB, please reselect a photo!`),
                type: 'warning',
                showConfirmButton: false,
            });
            ppi.value = null;
            return;
        }
        var img = document.getElementById('imgSdf');

        //读取File对象的数据
        reader.onload = function(evt){
            //data:img base64 编码数据显示
            img.width  =  "100";
            img.height =  "100";
            img.src = evt.target.result;
        }
        reader.readAsDataURL(file.files[0]);
    }



</script>

@endsection