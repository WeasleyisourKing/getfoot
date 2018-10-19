@extends('/app/layouts.app')

@section('content')

	<div class="container py-2 bg-light fixed-top">
		<div class="d-flex justify-content-between align-items-center text-mute">
			<a href="javascript:history.back(-1);"  class="top-nav-item"><i class="fa fa-angle-left"></i></a>
			<p class="top-nav-title text-left d-block my-2">
                	<script type="text/javascript">
                	Language("商品评论","Product Reviews")
                </script></p>
			<a  class="top-nav-item"></a>
		</div>
	</div>

	<div class="top-fix"></div>
	<div class="container main-container cartBox " style="height: auto;">
		<!--评论-->	
		@foreach($data as $val)
		<div class="row my-2 p-3 bg-white cartPro">
				<div class="col-2 d-flex align-items-center">
					<div class="avatar-img-container" style="margin: auto;height: 24px; width: 24px;">
						<img class="avatar-img" src="{{$val['users']['avatar']}}" alt="">
					</div>
				</div>
				<div class="col-4 d-flex align-items-center">
					<p style="font-size: 90%;" class="py-1 my-0">{{$val['name']}}</p>
				</div>
				<div class="col-6  align-items-center">
					<small class="text-muted py-2 d-block text-right">[{{$val['created_at']}}]</small>
				</div>
				<div class="col-9  my-2">
					<p class=" py-1 my-0 text-muted">{{$val['content']}}</p>
					<small class=" py-0 my-0" style="color: #BABABA;">
                	<script type="text/javascript">
                	Language("{{$val['messageImg']['zn_name']}}","{{$val['messageImg']['en_name']}}")
                </script></small>
				<!--评价星星-->
					<div id="oderBox" class="texti" style="padding: 0;" score="{{$val['score']}}" >
						<span><i class="far fa-star" aria-hidden="true" ></i></span>
						<span><i class="far fa-star" aria-hidden="true" ></i></span>
						<span><i class="far fa-star" aria-hidden="true" ></i></span>
						<span><i class="far fa-star" aria-hidden="true" ></i></span>
						<span><i class="far fa-star" aria-hidden="true" ></i></span>
					</div>
				</div>
				<div class="col-3 d-flex text-center  align-items-end py-2">
					<a href="##" class="btn btn-lg  btn-white border py-0 px-2 Plshow"><i class="fa fa-comment-dots"><small class="mx-1 text-muted">@if(count($val['reply'])!=0) {{count($val['reply'])}} @endif</small></i></a>
				</div>
				<!--次级评论-->
				<div class="col-12 py-1 plShow" style="display: none;">
					@foreach($val['reply'] as $v)
					<div class="row my-2"style="border-top: 1px #EEEEEE solid;">
						<div class="col-2 d-flex align-items-center">
							<div class="avatar-img-container" style="margin: auto;height: 24px; width: 24px;">
								<img class="avatar-img" src="/uploads/logo5.png" alt="">
							</div>
						</div>
						<div class="col-3 d-flex align-items-center">
							<p style="font-size: 90%;" class="py-1 my-0">{{$v['name']}}</p>
						</div>
						<div class="col-7 align-items-center">
							<small class="text-muted py-2 d-block text-right">[{{$v['created_at']}}]</small>
						</div>
						<div class="col-12 my-2">
							<small class=" py-1 my-0 text-muted">{{$v['content']}}</small>
						</div>
					</div>
					@endforeach
				</div>
				<!--end次级评论-->
		</div>
		@endforeach
		<!--end评论-->
	</div>
	
@endsection

@section('scripts')


<script type="text/javascript">

	$(".texti .fa,.texti .far").addClass("text-red")
	for(let i=0;i<$(".texti").length;i++){
		for( let o=0;o<$(".texti").eq(i).attr("score");o++){
			$(".texti").eq(i).find("i").eq(o).removeClass("far")
			$(".texti").eq(i).find("i").eq(o).addClass("fa ")
			// $(".texti").eq(i).children("span").eq(o).addClass("text-red")
		}
	}


    $(".cartPro:last").addClass("clearfix");
    $(".cartPro:last").after('<div style="width:100%;height:1px"></div>')
    console.log(1);
    $("#mobile-nav").hide();
//  显示隐藏次级评论$(".plShow").hide();
 $(".Plshow").click(function(){
  That=$(".Plshow").index(this);
  if($(".plShow").eq(That).css("display")=="none"){
   $(".plShow").eq(That).fadeIn();
  }else{
   $(".plShow").eq(That).hide();
  }
  
 })
</script>
<style type="text/css">
	.clearfix:before, .clearfix:after { display: table; content: " ";}
	.clearfix:after { clear: both;}
</style>

@endsection