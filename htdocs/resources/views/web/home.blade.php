@extends('layouts.app')

@section('content')
  <!-- Mobile Top Nav -->
  <div class="container bg-gradient pb-2">
    <div class="d-flex justify-content-between pt-3 align-items-center">
      <div class="col-3 px-2">
        <img class="w-100" src="http://buy.yn-pulse.com/home/img/logo.png" alt="logo">
      </div>
      <div class="col-5 pl-2 pr-0">
        <div class="input-group">
          <div class="input-group-prepend">
            <span class="input-group-text top-search-prepend shaddow-light" id="Search"><i class="fa fa-search"></i></span>
          </div>
          <input type="text" class="form-control top-search-input shaddow-light" aria-label="Search" aria-describedby="">
        </div>
      </div>
      <div class="col-4 px-2 d-flex justify-content-around d-block d-sm-none">
        <a href="{{ route('user') }}" class="btn btn-circle btn-white shaddow-light"><i class="fa fa-user"></i></a>
        <a href="" class="btn btn-circle btn-white shaddow-light"><i class="fa fa-ellipsis-h"></i></a>
      </div>
    </div>
  </div><!-- End Mobile Top Nav -->


  <!-- Banner Container -->
  <div class="container position-relative">
    
    <div class="bg-curved bg-gradient"></div>

    <div class="d-flex flex-row scrolling-wrapper-flexbox rounded shaddow-dark">

      @for( $i = 0; $i < 3; $i++ )
      <div class="col-12 p-0">
        <img class="w-100 h-100" src="http://img.zcool.cn/community/019209598028460000002129ec0c8f.jpg" alt="">
      </div>
      @endfor
  </div><!-- End Banner Container-->

  <!-- Icon Nav Container -->
  <div class="container mt-3">
    <div class="d-flex flex-row justify-content-between">
      @for( $i = 0; $i < 5; $i++ )
      <div>
        <button type="button" class="btn btn-lg btn-circle btn-white shaddow-dark"><i class="fa fa-user"></i></button>
        <small class="d-block py-2">
            <script>
            	Language("休闲零食","Leisure snacks")
            </script>
        </small>
      </div>
      @endfor
    </div>
  </div><!-- End Icon Nav Container -->

    
  <!-- 秒杀 Container -->
  <div class="container mb-2 pb-1">

    <div class="d-flex justify-content-between my-4">
      <div>
				<h4 class="pl-2 title-border">
					<script>
						Language("秒杀专区","Seconds kill zone")
					</script>
	  		</h4>
			</div>
      <div>
				<a href="">
					<script>
						Language("更多","More")
					</script>
					<i class="fa fa-angle-right"></i>
				</a>
			</div>
    </div>

    <div class="d-flex justify-content-between position-relative my-4">
      <p class="text-dark">
	  		<script>
					Language("距离本场结束还有","The game is still to come")
				</script>
	  	</p>
    </div>

    <!-- Row -->
    <div class="row justify-content-center">

      @for( $i = 0; $i < 3; $i++ )
      <div class="card shaddow-dark mb-2 mx-1 w-30 border-0">
        <a href=""><img src="http://buy.yn-pulse.com/home/img/logo.png" class="img-fluid card-img-top rounded-top img-bg-{{$i+1}} mb-1" alt=""></a>
        <div class="card-body p-1">
          <small class="mt-0 d-block text-dark">
		  			<script>
							Language("商品{{$i+1}}名称","goods{{$i+1}}name")
						</script>
		  		</small>
          <h6 class="card-title d-inline text-red">$20.69</h6>
          <a class="card-link btn btn-sm bg-color-red text-white rounded-50 py-0">
						<script>
							Language("购买","Buy")
						</script>
					</a>
        </div>
      </div>
      @endfor

    </div><!-- Row -->
  </div><!-- End 秒杀 container -->


  <!-- 热销 Container -->
  <div class="container mb-2 px-0">
    
    <div class="container">
      <div class="d-flex justify-content-between mt-4">
        <div>
					<h4 class="pl-2 title-border">
						<script>
							Language("热销商品","Hot commodity")
						</script>
					</h4>
				</div>
      </div>
    </div>

    <!-- Flex container(scrolling wrapper) -->
    <div class="d-flex flex-row scrolling-wrapper-flexbox">

      @for( $i = 0; $i < 9; $i++ )
      <div class="card bg-color-{{$i+1}} border-0 mb-2 mx-1 w-25 mw-25 mt-5">
        <a href=""><img src="http://buy.yn-pulse.com/home/img/logo.png" class="img-fluid card-img-top rounded img-bg-{{$i+1}} mb-1 position-relative hot-sale-img shaddow" alt=""></a>
        <div class="card-body hot-sale-card-body text-white text-center p-1">
          <small class="mt-0 d-block">
		  		<script>
            Language("商品{{$i+1}}名称","goods{{$i+1}}name")
          </script>
				</div>
		  </small>
				<h6 class="card-title mb-0">$44.99</h6>
				<a class="card-link btn btn-sm bg-light text-dark rounded-50 opactity-50 mt-0 py-0 px-3">
					<script>
						Language("购买","Buy")
					</script>
				</a>
			</div>
		</div>
      @endfor

    </div><!-- Flex container(scrolling wrapper) -->
  </div><!-- End 热销 container -->

  <!-- 分类商品 Container -->
  <div class="container mb-2 pb-1">

    <div class="d-flex justify-content-between my-4">
      	<div>
			<h4 class="pl-2 title-border">
				<script>
					Language("分类商品","Classification of goods")
				</script>
			</h4>
		</div>
      <div>
				<a href=""> 
					<script>
						Language("更多","More")
					</script>
					<i class="fa fa-angle-right"></i>
				</a>
			</div>

    <!-- Row -->
    <div class="row justify-content-center">

      @for( $i = 0; $i < 6; $i++ )
      <div class="card shaddow mb-2 mx-1 border-0 w-30">
        <a href=""><img src="http://buy.yn-pulse.com/home/img/logo.png" class="img-fluid card-img-top rounded-top mb-1" alt=""></a>
        <div class="card-body p-1">
          <small class="mt-0 d-block text-dark">
						<script>
							Language("商品{{$i+1}}名称","goods{{$i+1}}name")
						</script>
					</small>
          <h6 class="card-title d-inline text-red">$33.99</h6>
          <a class="card-link btn btn-sm bg-color-red text-white rounded-50 py-0">
						<script>
							Language("购买","Buy")
						</script>
					</a>
        </div>
      </div>
      @endfor

    </div><!-- Row -->
  </div><!-- End 分类商品 container -->

  <!-- 晒单 Container -->
  <div class="container mb-2 px-0">
    
    <div class="container">
      <div class="d-flex justify-content-between mt-4">
        <div>
					<h4 class="pl-2 title-border">
						<script>
							Language("晒单","Bask in a single")
						</script>
					</h4>
				</div>
      </div>
    </div>

    <!-- Flex container(scrolling wrapper) -->
    <div id="comments" class="d-flex flex-row scrolling-wrapper-flexbox">

      @for( $i = 0; $i < 6; $i++ )
      <div class="card text-muted my-2 mx-1 w-30">
        <a href=""><img src="https://timgsa.baidu.com/timg?image&quality=80&size=b9999_10000&sec=1528363795671&di=73dc97030e6d76df68393bd53fc17401&imgtype=0&src=http%3A%2F%2Fc.hiphotos.baidu.com%2Fimage%2Fpic%2Fitem%2Fa044ad345982b2b7cac747293badcbef77099b86.jpg" class="img-fluid card-img-top rounded" alt=""></a>
        {{-- <div class="card-footer">
          2 days ago
        </div> --}}
      </div>
      @endfor

    </div><!-- Flex container(scrolling wrapper) -->
  </div><!-- End 晒单 container -->
@endsection

@section('scripts')

<script type="text/javascript">


</script>


@endsection
