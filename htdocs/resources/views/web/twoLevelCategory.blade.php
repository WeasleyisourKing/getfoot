@extends('web/layout.app')

@section('content')

    @include('web/layout.category')
<style type="text/css">
	.Drinks .am-u-sm-3{
		height: 300px;
	}
</style>
    <div class="classIfyBg">
        <div class="maxCentr">


            @if (!empty($product))
                @foreach($product as $item)
                    <div class="DrinksTitle">
                        <p data-router="/shop/{{$item->id}}">
                            <script>
                            Language("{{$item->zn_name}}","{{$item->en_name}}")
                            </script>
                        </p>
                    </div>
                    @php
                        $j = 0;
                    @endphp
                    <div class="Drinks clearfloat">
						<div class="DrinksMore" style="position: absolute;top: -42px;right: 17px;font-size: 50px;">
							<p data-router="/shop/{{$item->id}}" style="cursor: pointer;font-size: 20px;font-weight: bold;color: #666;">MORE</p>
						</div>
                        @if (!empty($item->product))

                            @foreach($item->product as $items)
                                <div class="am-u-sm-3 ">
                                    <div class="DrinksPro" data-router="/details/{{$items->id}}">
                                        <img src="{{$items->product_image}}" alt=""/>
                                        <div class="Price">
                                        @if(!empty(Auth::guard("pc")->user()))
                            	<script type="text/javascript">
                            		Spricedetails({{$items->distributor->level_four_price}},{{$items->distributor->level_two_price}},{{$items->distributor->level_one_price}},{{$items->distributor->level_three_price}})
                            	</script>
                                        @endif</div>
                                        <div class="DrinksShow">
                                            <div class="classifyProName towLine">
                                                <script>
                                                    Language("{{$items->zn_name}}","{{$items->en_name}}")
                                                </script>
                                            </div>
                                            <button >
                                            	<script type="text/javascript">
                                            		Language("商品详情","Product Details")
                                            	</script>
                                            	
                                            	</button>
                                            <div class="Price">
				                                        @if(!empty(Auth::guard("pc")->user()))
							                            	<script type="text/javascript">
							                            		Spricedetails({{$items->distributor->level_four_price}},{{$items->distributor->level_two_price}},{{$items->distributor->level_one_price}},{{$items->distributor->level_three_price}})
							                            	</script>
				                                        @endif
				                            </div>
                                        </div>

                                    </div>
                                </div>
                                @php
                                    $j++;
                                @endphp

                                @if($j == 8)
                                    @php
                                        break;
                                    @endphp
                                @endif
                            @endforeach

                        @endif
                    </div>

                @endforeach

            @endif
        </div>
    </div>

@endsection
