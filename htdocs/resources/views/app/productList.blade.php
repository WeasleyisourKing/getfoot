@extends('/app/layouts.app')

@section('content')

	<div class="mobile-fix"style="height: 72px;"></div>
	<div class="container fixed-top bg-white">
        <div class="row border-bottom border-pink">
            <div class="col-2 my-auto">
                <a href="javascript:history.back(-1);" class="top-nav-item text-mute"><i
                            class="fa fa-angle-left"></i></a>
            </div>
            <div class="col-10 py-3 ml-auto">
                @include('/app/layouts/search')
            </div>
        </div>
    </div>

    <div class="container pt-3">
        <div class="row">


            @if (!empty($product ))

                @foreach($product as $val)
                    <div class="col-6 col-md-4 col-lg-3 mt-3">
                        <a href="/apps/product/{{$val['id']}}"><img class="w-100" src="{{$val->product_image}}" alt=""></a>
                        <a href="" class="btn btn-sm bg-pink text-white pt-0 mt-2 ">
                	<script type="text/javascript">
                	Language("{{$val->category->zn_name}}","{{$val->category->en_name}}")
                </script></a>
                        <p class="pt-1 tow-line stock_text"data-stock="{{$val->stock}}">
                	<script type="text/javascript">
                	Language("{{$val->zn_name}}","{{$val->en_name}}")
                </script></p>
                        <p class="text-red">
				            @if(!empty(Auth::guard("pc")->user()))
				            <script>
				            	Spricedetails({{$val->distributor->level_four_price}},{{$val->distributor->level_two_price}},{{$val->distributor->level_one_price}},{{$val->distributor->level_three_price}})
				            </script>
				            @endif
                        </p>
                    </div>
                @endforeach

            @else
                <div class="col-12 bg-white text-center py-5">
                    <h6>
                	<script type="text/javascript">
                	Language("搜索不到商品","No Results Found")
                </script></h6>
                </div>
            @endif

        </div>
    </div>

@endsection

@section('scripts')

@endsection