@extends('/app/layouts.app')

@section('content')

	<div class="container py-2 bg-white fixed-top">
		<div class="d-flex justify-content-between align-items-center text-mute">
			<a href="javascript:history.back(-1);"  class="top-nav-item"><i class="fa fa-angle-left"></i></a>
			<h6 class="top-nav-title">
                	<script type="text/javascript">
                	Language("待评论","Waiting for Reviews")
                </script></h6>
			<a  class="top-nav-item"></a>
		</div>
	</div>

	<div class="top-fix"></div>
	<div class="container main-container cartBox " style="height: auto;">
	<div class="top-fix" style="height: 1px;"></div>
	@foreach($data['manys'] as $val)
		<div class="row my-1 p-2 bg-white cartPro">
						<div class="col-3 d-flex align-items-center">
							<img class="cart-img" src="{{$val['product_image']}}" alt="">
						</div>
						<div class="col-6">
							<span class="d-block"><small class="p-0 tow-line">
                	<script type="text/javascript">
                	Language("{{$val['zn_name']}}","{{$val['en_name']}}")
                </script></small></span>
							<span class="d-block"><small class="p-0 text-muted">共<span>{{$val['pivot']['count']}}</span>
                	<script type="text/javascript">
                	Language("件商品","Items")
                </script></small></span>
							<span class="d-block"><small class="text-red cartProPrice">$ <span>{{$val['distributor']['level_four_price']}}</span></small></span>
						</div>
						<div class="col-3 p-0 align-items-center">
							<a class="text-center  d-block py-3">
								<i class="fa fa-comment-dots" style="color: #fdb3d3;"></i>
								<small class="p-0 d-block text-dark bntComment">
                	<script type="text/javascript">
                	Language("评论","Reviews")
                </script></small>
							</a>
							<span class="d-block text-center py-1"><a href="" class="text-muted card-link"><small class="p-0"></small></a></span>
						</div>
						<div class="col-12 tetxComment " style="border: 0; border-top: 1px solid #dee2e6; margin-top: 20px; ">
					     <div class="input-group border"style="border-radius: 24px;overflow: hidden; margin-top: 20px;">
					            <input id="comment" name="comment" type="text" class="form-control top-search-input py-0 comment" aria-label="Search" aria-describedby="" product="{{$val['id']}}">
					             <div class="input-group-prepend"style="border-left: 1px solid #dee2e6;">
					                           <span class="input-group-btn top-search-prepend input-group-text py-0" >
					           <button  class="btn  input-group-btn top-search-prepend input-group-text comment-btn"  style="background: none">
					            
                	<script type="text/javascript">
                	Language("评论","Reviews")
                </script>
					           </button>
					          </span>
					            </div>
					        </div>
							<div style="display:flex;margin-top:15px">
								<p style="margin-right:20px;color: #fdb3d3;">
                	<script type="text/javascript">
                	Language("评价","Ratings")
                </script></p>
								<div id="oderBox" class="texti" style="padding: 0;">
									<span><i class="fa fa-star" aria-hidden="true" ></i></span>
									<span><i class="fa fa-star" aria-hidden="true" ></i></span>
									<span><i class="fa fa-star" aria-hidden="true" ></i></span>
									<span><i class="fa fa-star" aria-hidden="true" ></i></span>
									<span><i class="fa fa-star" aria-hidden="true" ></i></span>
								</div>
							</div>
							
					    </div>
			</div>
			@endforeach
	</div>

@endsection



@section('scripts')
<script>
	$(".texti .fa,.texti .far").addClass("text-red")
	$(".texti i").addClass("text-red ");
	$(".comment-btn").attr("score","5")
	$(".texti span").click(function(){
	var That = $(this).index();
	var This = $(".texti span").index(this);
	for(i=(parseInt(This/5)*5); i<(parseInt(This/5+1)*5);i++){
		$(".texti i").eq(i).removeClass("fa")
		$(".texti i").eq(i).addClass("far")
	}
	for(i=parseInt(This/5)*5;i<This+1;i++){
		$(".texti i").eq(i).addClass("fa")
		$(".texti i").eq(i).removeClass("far")
	}
	$(".comment-btn").eq(parseInt(This/5)).attr("score",That+1)
	})
</script>

<script type="text/javascript">
    $(".cartPro:last").addClass("clearfix");
    $(".cartPro:last").after('<div style="width:100%;height:1px"></div>')
    //评论按钮
    $(".tetxComment").hide();
    $(".bntComment").click(function(){
    	That=$(".bntComment").index(this);
    	if($(".tetxComment").css("display")=="none"){
    		$(".tetxComment").eq(That).fadeIn();
    	}else{
    		$(".tetxComment").hide();
    	}
    })
</script>


<script type="text/javascript">
	var aa = window.location.href;
$(".comment-btn").click(
	function (){
		// console.log(aa.split('/tocomments/')[1])
		var That=$(".comment-btn").index(this);
		if($('.comment').eq(That).val()==''){ 
            		swal({
                            title:LanguageHtml( '评论内容不能为空','Reviews Should Not Be Blank'),
                            type: 'info',
                            showConfirmButton: true,

                        })
			return
		}
		$.ajax({
			url:'/apps/addComments',
			method: 'get',
			data: {
					order_id:aa.split('/tocomments/')[1],
					product_id:$('.comment').eq(That).attr("product"),
                    content :$('.comment').eq(That).val(),
					score:$('.comment-btn').eq(That).attr("score")
                },
            success: function(data){
            	if(data){
            		swal({
                            title: LanguageHtml( '评论成功',' Review Posted!'),
                            type: 'success',
                            showConfirmButton: true,

                        });
            		$(".cartPro").eq(That).remove()
            	}else{
            		swal({
                            title: LanguageHtml( '评论失败,请重试','Failed to post, please try again'),
                            type: 'waring',
                            showConfirmButton: true,

                        })
            	}
            },
            error: function () {
                    swal({
                        title: '请求失败',
                        type: 'info',
                        showConfirmButton: true,

                    })

                }
		})
	}
)
</script>


<style type="text/css">
	.clearfix:before, .clearfix:after { display: table; content: " ";}
	.clearfix:after { clear: both;}
</style>

@endsection