@extends('/app/layouts.app')

@section('content')

    <div class="container">
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

            @if (!empty($product))
                <div class="col-12 bg-white text-center py-3">
                    <h6>
                    <script type="text/javascript">
                    	Language("{{$product->zn_name}}","{{$product->en_name}}")
                    </script>
                    </h6>
                </div>

                @foreach($product->products as $val)
                    <div class="col-6 col-md-4 col-lg-3 mt-3">
                        <a href="/apps/product/{{$val['id']}}"><img class="w-100" src="{{$val->product_image}}" alt=""></a>
                        <a href="" class="btn btn-sm bg-pink text-white pt-0 mt-2 tow-line">
                        <script type="text/javascript">
                        		Language("{{$product->zn_name}}","{{$product->en_name}}")
                        </script>
                        </a>
                        <p class="pt-1 tow-line">
                        	<script>
                        		Language("{{$val->zn_name}}","{{$val->en_name}}")
                        	</script>
                        </p>
                        <p class="text-red">
                        <script>
                                                Spricedetails({{$val['distributor']['level_four_price']}},{{$val['distributor']['level_two_price']}},{{$val['distributor']['level_one_price']}},{{$val['distributor']['level_three_price']}});
                                            </script>
                        </p>
                    </div>
                @endforeach

            @else
                <div class="col-12 bg-white text-center py-5">
                    <h6>
                    <script type="text/javascript">
                    	Language("搜索不到商品","No Results Found ")
                    </script></h6>
                </div>
            @endif

        </div>
    </div>

@endsection

@section('scripts')

@endsection