@extends('/app/layouts.app')

@section('content')

    <style type="text/css">
        .app p{
            overflow: hidden;
            text-overflow: ellipsis;
            display: -webkit-box !important;
            -webkit-line-clamp: 1;
            -webkit-box-orient: vertical;
        }
    </style>
	<div class="container py-2 bg-white fixed-top">
		<div class="d-flex justify-content-between align-items-center text-mute">
			<a href="javascript:history.back(-1);"  class="top-nav-item"><i class="fa fa-angle-left"></i></a>
			<h6 class="top-nav-title">
                	<script type="text/javascript">
                	Language("历史浏览记录"," Recently Viewed ")
                </script></h6>
			<a href="/apps/user/{{ Auth::guard("pc")->user()->id }}" class="top-nav-item"><i class="fa fa-user"></i></a>
		</div>
	</div>

	<div class="top-fix"></div>
<div class="container justify-content-center ">
  <div class="row recordBox "style="width:95%;margin:0 auto;">

  </div>

</div>


<script type="text/javascript">
window.onload = function(){
  var record = localStorage.getItem('collection') ? JSON.parse(localStorage.getItem("collection")) : [];
  var Html = "";
  console.log(record);
  for (var i = record.length-1; i >-1; i--) {
    Html += ` <div class="card shaddow-dark mb-2 border-0" style="width:45%;margin-left:10px;">
                <a href="/apps/product/${record[i].shop_id}"><img src="${record[i].image}"
                                class="img-fluid card-img-top rounded-top  mb-1" alt=""></a>
                <div class="card-body p-1">
                    <small class="mt-0 d-block text-dark" style="overflow: hidden;text-overflow: ellipsis;display: -webkit-box !important;-webkit-line-clamp: 2;-webkit-box-orient: vertical;">${record[i].zn_name}</small>
                    <h6 class="card-title d-inline text-red">
                        <span>$</span>${record[i].price}</h6>

                </div>
            </div> `
            }
            	$(".recordBox").html(Html);
			}

</script>


@endsection
