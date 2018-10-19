@extends('/app/layouts.app')

@section('content')
	<div class="mobile-fix"style="height: 72px;"></div>
	<div class="container fixed-top bg-white">
		<div class="row border-bottom border-pink ">
			<div class="col-2 my-auto">
				<a href="/apps" class="top-nav-item text-mute"><i class="fa fa-angle-left"></i></a>
			</div>
			<div class="col-10 py-3 ml-auto">
				@include('/app/layouts/search')
			</div>
		</div>
	</div>

	<div class="container d-flex bg-color-pink py-1 pr-0">
		<div class="col-3 pl-0 mt-4 scroll-y" id="categoryList">
		<!--<div class="col-3 pl-0 mt-4 " id="categoryList">-->
			@php $id = 0 @endphp
			@foreach($category as $val)
			<a href="?id={{$id}}" class="btn btn-block rounded-75 px-0 btn-white border-0 my-4 col-12 category-list" style="font-size: 0.9rem;">
				@php $id++ @endphp
			
                	<script type="text/javascript">
                	Language("{{$val['zn_name']}}","{{$val['en_name']}}")
                </script></a>
			@endforeach
		</div>
		<div class="col-9 bg-white text-center py-5">
			<h6>
                	<script type="text/javascript">
                	Language("- 为您推荐 -","Recommended for You ")
                </script></h6>
			<div class="container mt-4">
				<div class="row">
					@php $index = isset ($_GET['id']) ? $_GET['id'] : 0 @endphp
					@foreach($category[$index]['pid'] as $val)
					<div class="col-4 mt-2">
						<a href="/apps/category/categorylist/{{$val['id']}}">
						<button type="button" class="btn btn-lg btn-circle btn-white shaddow-dark"><i class="{{!empty($val['icon']) ? $val['icon'] : 'fa fa-user'}}"></i></button></a>
						@if(empty($val))
						@else
        				<small class="d-block py-2 tow-line">
                	<script type="text/javascript">
                	Language("{{$val['zn_name']}}","{{$val['en_name']}}")
                </script></small>
        				@endif
					</div>
					@endforeach
				</div>
			</div>
		</div>
	</div>



@endsection





@section('scripts')
<script type="text/javascript">
	 var Http=window.location.href;
	 console.log(Http);
	 Http=(Http.split("?id="))[1];
	 console.log(Http);
	 $(".category-list").eq(Http?Http:"0").addClass("active border")
</script>
    <script>
    //底部导航显示当前所在页面样式
    $("#mobile-nav a").eq(1).css({"background":"#fdb3d3","color":"#ffffff"})
    //设置分类高度
//  $(function(){
//  		var categoryListHeight=$(window).height()-$(".container").eq(0).height()-$(".mobile-fix").eq(0).height()-8-24;
//  		$("#categoryList").height(categoryListHeight);
//  });
    </script>
<style type="text/css">
	.active{
		background:none ;
		border:1px solid rgba(255,255,255,0.5) !important;
		color:#ffffff !important;
		outline: none;

	}
</style>


@endsection