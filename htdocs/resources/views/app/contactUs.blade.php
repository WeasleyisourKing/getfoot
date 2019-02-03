@extends('/app/layouts.app')

@section('content')

<div class="container py-2 bg-light fixed-top">
	<div class="d-flex justify-content-between align-items-center text-mute">
		<a href="/apps/user/{{Auth()->guard('pc')->user()->id}}"  class="top-nav-item"><i class="fa fa-angle-left"></i></a>
		<h6 class="top-nav-title">
                	<script type="text/javascript">
                	Language("联系我们","Contact Us")
                </script></h6>
		<a href="/apps/user/{{Auth()->guard('pc')->user()->id}}" class="top-nav-item"><i class="fa fa-user"></i></a>
	</div>
</div>


<div class="container p-5 mt-5">
  <div class="d-flex justify-content-center  mb-3">
    <div class="p-2 mt-5 pt-3">
			<img class="w-50 logo img-center" src="" alt="" />
    </div>
  </div>
  <div class="d-flex justify-content-center  ">
    <div class="p-2 ">
    		<p class="text-red m-0">
                	<script type="text/javascript">
                	Language("联系我们","Contact Us")
                </script></p>
    </div>
  </div>
  <div class="d-flex justify-content-center  ">
    <div class="p-1 ">
    		<p class="text-muted m-0"><i class="fa fa-phone text-color-1 px-2"></i>818-477-8888</p>
    </div>
  </div>
  <div class="d-flex justify-content-center  ">
    <div class="p-1">
    		<p class="text-muted m-0"><i class="fa fa-envelope text-color-1 px-2"></i>help@12buy.com</p>
    </div>
  </div>
</div>

	
@endsection





@section('scripts')
<script type="text/javascript">
	$(document).ready(function(){
		$('#mobile-nav').hide();
	});
//	获取logo
    $.get('/api/home/login', {}, function (res) {
        if (res.status) {
            $('.logo').attr('src',"/"+res.data.logo);

        }
    })
</script>

@endsection